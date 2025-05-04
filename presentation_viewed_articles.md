# Quy Trình Xem Bài Viết Đã Xem Từ User
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống theo dõi và lưu trữ lịch sử bài viết mà người dùng đã xem
- Người dùng có thể xem lại danh sách các bài viết đã đọc
- Tính năng này áp dụng cho tất cả các loại người dùng: User thông thường, Author, Moderator và Admin
- Dữ liệu được lưu trữ trong cơ sở dữ liệu và hiển thị theo thứ tự thời gian xem gần nhất

---

## 2. Cấu Trúc Cơ Sở Dữ Liệu

### Bảng `article_views`
- `view_id`: ID của lượt xem (khóa chính)
- `article_id`: ID của bài viết được xem (khóa ngoại)
- `user_id`: ID của người dùng xem bài viết (khóa ngoại, có thể null nếu là người dùng ẩn danh)
- `anonymous`: Lưu trữ IP của người dùng ẩn danh (nếu không đăng nhập)
- `viewed_at`: Thời gian xem bài viết

### Quan hệ với các bảng khác
- Liên kết với bảng `articles` qua `article_id`
- Liên kết với bảng `users` qua `user_id`

---

## 3. Quy Trình Ghi Nhận Lượt Xem

### Khi người dùng xem bài viết:
1. Hệ thống kiểm tra xem người dùng đã đăng nhập chưa
   - Nếu đã đăng nhập: Lấy `user_id`
   - Nếu chưa đăng nhập: Lấy địa chỉ IP của người dùng

2. Kiểm tra xem người dùng đã xem bài viết này chưa
   ```php
   $hasViewed = ArticleView::where('article_id', $article->article_id)
       ->where(function ($query) use ($userId, $userIp) {
           if ($userId) {
               $query->where('user_id', $userId);
           } else {
               $query->whereNull('user_id')
                   ->where('anonymous', $userIp);
           }
       })
       ->exists();
   ```

3. Nếu chưa xem, thêm vào cơ sở dữ liệu và tăng lượt xem của bài viết
   ```php
   if (!$hasViewed) {
       ArticleView::create([
           'article_id' => $article->article_id,
           'user_id' => $userId,
           'anonymous' => $userIp,
           'viewed_at' => now(),
       ]);

       $article->increment('views');
   }
   ```

---

## 4. Hiển Thị Bài Viết Đã Xem

### Truy cập danh sách bài viết đã xem:
- Người dùng truy cập vào đường dẫn `/viewed-articles`
- Route được định nghĩa: `Route::get('/viewed-articles', [ArticleViewUserController::class, 'index'])->name('viewed.articles');`

### Controller xử lý:
```php
public function index()
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user_id = Auth::id();
    $user = Auth::user(); // Lấy thông tin người dùng hiện tại
    $viewedArticles = ArticleView::where('user_id', $user_id)
        ->with('article')
        ->orderBy('viewed_at', 'desc')
        ->paginate(6);
        
    return view('website.profiles.users.viewed-acticles', compact('viewedArticles', 'user'));
}
```

---

## 5. Giao Diện Hiển Thị

### Giao diện người dùng thông thường:
- Hiển thị trong trang cá nhân của người dùng
- Bao gồm: STT, ảnh đại diện bài viết, tiêu đề, nội dung tóm tắt và nút xem chi tiết
- Phân trang với 6 bài viết mỗi trang

### Mẫu code hiển thị:
```html
<table class="table table-bordered table-light mb-0" style="width:100%">
    <thead>
        <tr>
            <th>STT</th>
            <th>Ảnh Đại Diện</th>
            <th>Tiêu Đề</th>
            <th>Nội Dung</th>
            <th>Hoạt Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($viewedArticles as $index => $view)
            <tr>
                <td>{{ $loop->iteration + ($viewedArticles->currentPage() - 1) * $viewedArticles->perPage() }}</td>
                <td>
                    <a href="{{ route('articles.show', $view->article->article_id) }}">
                        <img src="{{ asset('storage/' . $view->article->thumbnail_url) }}" width="100px" height="100px">
                    </a>
                </td>
                <td>{{ $view->article->title }}</td>
                <td>{!! Str::limit(strip_tags($view->article->content), 100, '...') !!}</td>
                <td>
                    <a href="{{ route('article.detail', ['slug' => $view->article->slug]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

## 6. Các Giao Diện Khác Nhau Theo Vai Trò

### Hệ thống cung cấp giao diện riêng cho từng loại người dùng:

1. **User thông thường**:
   - Controller: `App\Http\Controllers\User\ArticleViewUserController`
   - View: `resources\views\website\profiles\users\viewed-acticles.blade.php`

2. **Author (Tác giả)**:
   - Controller: `App\Http\Controllers\Author\ArticleViewAuthorController`
   - View: `resources\views\author\viewed-articles.blade.php`

3. **Moderator (Người kiểm duyệt)**:
   - Controller: `App\Http\Controllers\Moderator\ArticleViewModeratorController`
   - View: `resources\views\moderator\viewed-articles.blade.php`

4. **Admin (Quản trị viên)**:
   - Controller: `App\Http\Controllers\Admin\ArticleViewAdminController`
   - View: `resources\views\admin\viewed-articles.blade.php`

---

## 7. Ứng Dụng Của Dữ Liệu Bài Viết Đã Xem

### Hiển thị bài viết đã xem gần đây:
```php
$recentArticles = Article::where('status', 'published')
    ->whereIn('article_id', function ($q) use ($userId, $userIp) {
        $q->select('article_id')
            ->from('article_views')
            ->when($userId, fn($q2) => $q2->where('user_id', $userId))
            ->when(!$userId, fn($q2) => $q2->whereNull('user_id')->where('anonymous', $userIp))
            ->orderByDesc('viewed_at');
    })
    ->limit(4)
    ->get();
```

### Đề xuất bài viết liên quan:
- Hệ thống sử dụng lịch sử xem để đề xuất các bài viết liên quan
- Kết hợp với thông tin về danh mục và thẻ tag để tạo đề xuất phù hợp

---

## 8. Lợi Ích Của Tính Năng

1. **Cho người dùng**:
   - Dễ dàng tìm lại các bài viết đã đọc
   - Theo dõi lịch sử đọc của bản thân
   - Tiếp tục đọc các bài viết đã xem trước đó

2. **Cho hệ thống**:
   - Thu thập dữ liệu về hành vi người dùng
   - Cải thiện đề xuất bài viết
   - Thống kê lượt xem chính xác

---

## 9. Kết Luận

- Tính năng xem bài viết đã xem là một phần quan trọng của hệ thống 24hNews
- Được thiết kế để hoạt động với tất cả các loại người dùng
- Cung cấp trải nghiệm người dùng tốt hơn và dữ liệu có giá trị cho hệ thống
- Được tích hợp chặt chẽ với các tính năng khác như đề xuất bài viết và thống kê

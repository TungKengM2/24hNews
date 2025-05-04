# Quy Trình Bài Viết Đã Lưu Từ User
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống cho phép người dùng lưu (bookmark) các bài viết yêu thích
- Người dùng có thể xem lại danh sách các bài viết đã lưu
- Tính năng này áp dụng cho tất cả các loại người dùng: User thông thường, Author, Moderator và Admin
- Dữ liệu được lưu trữ trong cơ sở dữ liệu và hiển thị theo thứ tự thời gian lưu gần nhất

---

## 2. Cấu Trúc Cơ Sở Dữ Liệu

### Bảng `article_saves`
- `id`: ID của lượt lưu (khóa chính)
- `article_id`: ID của bài viết được lưu (khóa ngoại)
- `user_id`: ID của người dùng lưu bài viết (khóa ngoại)
- `created_at`, `updated_at`: Thời gian tạo và cập nhật

### Ràng buộc quan trọng
```php
$table->unique(['article_id', 'user_id']); // Đảm bảo mỗi user chỉ lưu 1 lần
```

### Quan hệ với các bảng khác
- Liên kết với bảng `articles` qua `article_id`
- Liên kết với bảng `users` qua `user_id`

---

## 3. Quy Trình Lưu Bài Viết

### Khi người dùng nhấn nút lưu bài viết:
1. Hệ thống kiểm tra xem người dùng đã đăng nhập chưa
   - Nếu chưa đăng nhập: Hiển thị thông báo yêu cầu đăng nhập
   - Nếu đã đăng nhập: Tiếp tục quy trình

2. Kiểm tra xem bài viết đã được lưu chưa
   ```php
   $existingSave = ArticleSave::where('user_id', $user->user_id)
       ->where('article_id', $articleId)
       ->first();
   ```

3. Nếu chưa lưu, thêm vào cơ sở dữ liệu
   ```php
   ArticleSave::create([
       'user_id' => $user->user_id,
       'article_id' => $articleId
   ]);
   ```

4. Trả về thông báo thành công hoặc thông báo đã lưu trước đó

---

## 4. Giao Diện Lưu Bài Viết

### Nút lưu bài viết trên trang chi tiết bài viết:
```html
<a href="" id="bookmarkButton"
   class="d-flex flex-column align-items-center gap-1 text-decoration-none mb-3"
   data-article-id="{{ $article->article_id }}"
   onclick="toggleBookmark(this, {{ $article->article_id }}); return false;">
   <i class="la la-bookmark" id="bookmarkIcon"
      style="font-size: 28px; color: {{ $isBookmarked ? 'gold' : '#555' }};">
   </i>
   <span style="font-size: 14px; font-weight: bold; color: {{ $isBookmarked ? 'gold' : '#555' }};">
      {{ $isBookmarked ? 'Đã lưu' : 'Lưu' }}
   </span>
</a>
```

### Xử lý AJAX khi nhấn nút lưu:
```javascript
$(document).ready(function() {
    $("#bookmarkButton").click(function() {
        let articleId = $(this).data("article-id");

        $.ajax({
            url: "/save-article",
            type: "POST",
            data: {
                article_id: articleId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "Bài viết đã được lưu.",
                    timer: 2000
                });
                $("#bookmarkText").text("Đã lưu");
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                    "Lỗi khi lưu bài viết!";
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: errorMessage
                });
            }
        });
    });
});
```

---

## 5. Hiển Thị Trạng Thái Đã Lưu

### Kiểm tra trạng thái đã lưu khi hiển thị bài viết:
```php
// Trong ArticleUserController
$isBookmarked = false;
if ($userId) { // Nếu có user đăng nhập
    $isBookmarked = ArticleSave::where('user_id', $userId)
        ->where('article_id', $article->article_id)
        ->exists();
}
```

### Hiển thị trạng thái đã lưu:
- Nút lưu có màu vàng (gold) nếu đã lưu
- Nút lưu có màu xám (#555) nếu chưa lưu
- Văn bản hiển thị "Đã lưu" hoặc "Lưu" tương ứng

---

## 6. Hiển Thị Danh Sách Bài Viết Đã Lưu

### Truy cập danh sách bài viết đã lưu:
- Người dùng truy cập vào đường dẫn `/saved-articles`
- Route được định nghĩa tùy theo loại người dùng:
  - User: `Route::get('/saved-articles', [ArticleSaveController::class, 'savedArticles'])->name('user.saved');`
  - Author: `Route::get('/saved-articles', [AuthorArticleSaveController::class, 'savedArticles'])->name('author.saved');`
  - Moderator: `Route::get('/saved-articles', [ModeratorArticleSaveController::class, 'savedArticles'])->name('moderator.saved');`
  - Admin: `Route::get('/saved-articles', [AdminArticleSaveController::class, 'savedArticles'])->name('admin.saved');`

### Controller xử lý:
```php
public function savedArticles()
{
    $user = Auth::user();

    // Lấy danh sách bài viết đã lưu kèm thông tin bài viết
    $savedArticles = ArticleSave::where('user_id', $user->user_id)
        ->with('article') // Load thông tin bài viết
        ->latest()
        ->paginate(10);
        
    return view('website.profiles.users.saved', compact('savedArticles', 'user'));
}
```

---

## 7. Giao Diện Hiển Thị Danh Sách Bài Viết Đã Lưu

### Giao diện người dùng thông thường:
- Hiển thị trong trang cá nhân của người dùng
- Bao gồm: STT, ảnh đại diện bài viết, tiêu đề, nội dung tóm tắt, thời gian lưu và các nút hành động
- Phân trang với 10 bài viết mỗi trang

### Mẫu code hiển thị:
```html
<table class="table table-bordered table-light mb-0" style="width:100%">
    <thead>
        <tr>
            <th>STT</th>
            <th>Ảnh Đại Diện</th>
            <th>Tiêu Đề</th>
            <th>Nội Dung</th>
            <th>Thời Gian</th>
            <th>Hoạt Động</th>
        </tr>
    </thead>
    @foreach ($savedArticles as $index => $savedArticle)
        <tbody>
            <td>
                {{ $loop->iteration + ($savedArticles->currentPage() - 1) * $savedArticles->perPage() }}
            </td>
            <td>
                <a href="{{ route('articles.show', $savedArticle->article->article_id) }}">
                    <img src="{{ asset('storage/' . $savedArticle->article->thumbnail_url) }}"
                        width="100px" height="100px">
                </a>
            </td>
            <td>
                <h5 class="card-title">{{ $savedArticle->article->title }}</h5>
            </td>
            <td>
                {!! Str::limit(strip_tags($savedArticle->article->content), 100, '...') !!}
            </td>
            <td>
                <h5 class="card-title">{{ $savedArticle->created_at->diffForHumans() }}</h5>
            </td>
            <td>
                <a href="{{ route('article.detail', ['slug' => $savedArticle->article->slug]) }}"
                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i>
                </a>
                <form action="{{ route('user.remove.saved', $savedArticle->id) }}"
                    method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tbody>
    @endforeach
</table>
```

---

## 8. Xóa Bài Viết Đã Lưu

### Quy trình xóa bài viết đã lưu:
1. Người dùng nhấn nút xóa bên cạnh bài viết đã lưu
2. Hiển thị hộp thoại xác nhận
3. Nếu xác nhận, gửi request DELETE đến endpoint tương ứng

### Controller xử lý xóa:
```php
public function removeSavedArticle($id)
{
    $userId = auth()->id();
    $savedArticle = ArticleSave::where('id', $id)->where('user_id', $userId)->first();

    if (!$savedArticle) {
        return redirect()->back()->with('error', 'Bài viết không tồn tại hoặc bạn không có quyền xóa!');
    }

    $savedArticle->delete();

    return redirect()->back()->with('success', 'Bài viết đã được xoá thành công!');
}
```

---

## 9. Các Giao Diện Khác Nhau Theo Vai Trò

### Hệ thống cung cấp giao diện riêng cho từng loại người dùng:

1. **User thông thường**:
   - Controller: `App\Http\Controllers\User\ArticleSaveController`
   - View: `resources\views\website\profiles\users\saved.blade.php`

2. **Author (Tác giả)**:
   - Controller: `App\Http\Controllers\Author\ArticleSaveController`
   - View: `resources\views\author\saved.blade.php`

3. **Moderator (Người kiểm duyệt)**:
   - Controller: `App\Http\Controllers\Moderator\ArticleSaveController`
   - View: `resources\views\moderator\saved.blade.php`

4. **Admin (Quản trị viên)**:
   - Controller: `App\Http\Controllers\Admin\ArticleSaveController`
   - View: `resources\views\admin\saved.blade.php`

---

## 10. Lợi Ích Của Tính Năng

1. **Cho người dùng**:
   - Dễ dàng lưu trữ bài viết yêu thích
   - Truy cập nhanh các bài viết quan trọng
   - Tạo danh sách đọc cá nhân

2. **Cho hệ thống**:
   - Thu thập dữ liệu về sở thích người dùng
   - Có thể sử dụng để đề xuất bài viết tương tự
   - Đánh giá mức độ phổ biến của bài viết

---

## 11. Kết Luận

- Tính năng lưu bài viết là một phần quan trọng của hệ thống 24hNews
- Được thiết kế để hoạt động với tất cả các loại người dùng
- Cung cấp trải nghiệm người dùng tốt hơn và dữ liệu có giá trị cho hệ thống
- Được tích hợp chặt chẽ với các tính năng khác như xem chi tiết bài viết

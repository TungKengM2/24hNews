# Quy Trình Người Đã Theo Dõi Từ User
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống cho phép người dùng theo dõi (follow) các tác giả và người dùng khác
- Người dùng có thể xem danh sách những người mình đang theo dõi (following)
- Người dùng có thể xem danh sách những người đang theo dõi mình (followers)
- Tính năng này áp dụng cho tất cả các loại người dùng: User thông thường, Author, Moderator và Admin
- Dữ liệu được lưu trữ trong cơ sở dữ liệu và hiển thị theo thứ tự thời gian theo dõi gần nhất

---

## 2. Cấu Trúc Cơ Sở Dữ Liệu

### Bảng `follows`
- `id`: ID của lượt theo dõi (khóa chính)
- `follower_id`: ID của người theo dõi (khóa ngoại)
- `following_id`: ID của người được theo dõi (khóa ngoại)
- `created_at`, `updated_at`: Thời gian tạo và cập nhật

### Quan hệ với các bảng khác
```php
// Trong model User
public function followers()
{
    return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
}

public function following()
{
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
}
```

---

## 3. Quy Trình Theo Dõi Người Dùng

### Khi người dùng nhấn nút theo dõi:
1. Hệ thống kiểm tra xem người dùng đã đăng nhập chưa
   - Nếu chưa đăng nhập: Chuyển hướng đến trang đăng nhập
   - Nếu đã đăng nhập: Tiếp tục quy trình

2. Kiểm tra xem người dùng có đang cố gắng tự theo dõi chính mình không
   ```php
   if ($authUser->user_id === $user->user_id) {
       return back()->with('error', 'Bạn không thể tự follow chính mình!');
   }
   ```

3. Kiểm tra xem đã theo dõi người này chưa
   ```php
   if (!$authUser->following()->where('following_id', $user->user_id)->exists()) {
       $authUser->following()->attach($user->user_id);
       return back()->with('success', 'Bạn đã follow ' . $user->username);
   }
   ```

4. Nếu đã theo dõi, hiển thị thông báo
   ```php
   return back()->with('error', 'Bạn đã follow người này rồi!');
   ```

---

## 4. Quy Trình Hủy Theo Dõi

### Khi người dùng nhấn nút hủy theo dõi:
1. Hệ thống xóa mối quan hệ theo dõi trong cơ sở dữ liệu
   ```php
   auth()->user()->following()->detach($user->user_id);
   return back()->with('success', 'Bạn đã unfollow ' . $user->username);
   ```

2. Hiển thị thông báo thành công và cập nhật giao diện

---

## 5. Hiển Thị Danh Sách Người Đang Theo Dõi (Following)

### Truy cập danh sách người đang theo dõi:
- Người dùng truy cập vào đường dẫn `/following`
- Route được định nghĩa: `Route::get('/following', [ProfileController::class, 'followingList'])->name('user.following');`

### Controller xử lý:
```php
public function followingList()
{
    $user = auth()->user();
    $followingUsers = $user->following()->paginate(10);
    return view('website.profiles.users.following', compact('followingUsers', 'user'));
}
```

### Giao diện hiển thị:
- Hiển thị danh sách người dùng đang theo dõi với ảnh đại diện, tên người dùng và nút hủy theo dõi
- Phân trang với 10 người dùng mỗi trang

---

## 6. Hiển Thị Danh Sách Người Theo Dõi (Followers)

### Truy cập danh sách người theo dõi:
- Các route được định nghĩa cho từng loại người dùng:
  - Author: `Route::get('/author/followers', [AuthorDashboard::class, 'followers'])->name('author.followers');`
  - Admin: `Route::get('/followers', [ProfileController::class, 'followersOfAdminList'])->name('admin.followers');`

### Controller xử lý:
```php
public function followers()
{
    $user = Auth::user();

    // Lấy người theo dõi với phân trang
    $followers = DB::table('follows')
        ->join('users', 'follows.follower_id', '=', 'users.user_id')
        ->where('follows.following_id', $user->user_id)
        ->select('users.*', 'follows.created_at as followed_at')
        ->orderBy('follows.created_at', 'desc')
        ->paginate(20);

    return view('author.followers', compact('followers'));
}
```

### Giao diện hiển thị:
- Hiển thị danh sách người dùng đang theo dõi mình với ảnh đại diện, tên người dùng, email và thời gian theo dõi
- Phân trang với 10-20 người dùng mỗi trang

---

## 7. Hiển Thị Trạng Thái Theo Dõi

### Trên trang hồ sơ tác giả:
```php
@if (auth()->check() && auth()->id() !== $author->user_id)
    @if (auth()->user()->following()->where('following_id', $author->user_id)->exists())
        <form action="{{ route('user.unfollow', $author->user_id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="la la-user-minus me-1"></i> Bỏ theo dõi
            </button>
        </form>
    @else
        <form action="{{ route('user.follow', $author->user_id) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="la la-user-plus me-1"></i> Theo dõi
            </button>
        </form>
    @endif
@endif
```

---

## 8. Các Giao Diện Khác Nhau Theo Vai Trò

### Hệ thống cung cấp giao diện riêng cho từng loại người dùng:

1. **User thông thường**:
   - Following Controller: `ProfileController@followingList`
   - Following View: `website.profiles.users.following`

2. **Author (Tác giả)**:
   - Following Controller: `ProfileController@followingOfAuthorList`
   - Following View: `author.following`
   - Followers Controller: `AuthorDashboard@followers`
   - Followers View: `author.followers`

3. **Moderator (Người kiểm duyệt)**:
   - Following Controller: `ProfileController@followingOfModeratorList`
   - Following View: `moderator.following`

4. **Admin (Quản trị viên)**:
   - Following Controller: `ProfileController@followingOfAdminList`
   - Following View: `admin.following`
   - Followers Controller: `ProfileController@followersOfAdminList`
   - Followers View: `admin.followers`

---

## 9. Thông Báo Khi Có Bài Viết Mới

### Khi tác giả đăng bài viết mới, hệ thống sẽ gửi thông báo cho người theo dõi:
```php
// Trong ArticleObserver
public function updated(Article $article)
{
    if ($article->status === 'published') {
        // Gửi thông báo cho followers
        $author = $article->author;
        $author->followers()->chunk(200, function ($followers) use ($article, $author) {
            foreach ($followers as $follower) {
                $follower->notify(new NewArticleFromFollowedAuthor($article, $author));
            }
        });
    }
}
```

---

## 10. Lợi Ích Của Tính Năng

1. **Cho người dùng**:
   - Theo dõi các tác giả yêu thích
   - Nhận thông báo khi tác giả đăng bài viết mới
   - Xây dựng cộng đồng và tương tác giữa người dùng

2. **Cho tác giả**:
   - Xây dựng lượng người theo dõi
   - Tăng khả năng tiếp cận khi đăng bài viết mới
   - Nhận phản hồi từ người theo dõi

3. **Cho hệ thống**:
   - Tăng tương tác giữa người dùng
   - Tăng lượt xem bài viết
   - Cải thiện trải nghiệm người dùng

---

## 11. Kết Luận

- Tính năng theo dõi người dùng là một phần quan trọng của hệ thống 24hNews
- Được thiết kế để hoạt động với tất cả các loại người dùng
- Cung cấp trải nghiệm người dùng tốt hơn và tăng tương tác giữa người dùng
- Được tích hợp chặt chẽ với các tính năng khác như thông báo và hiển thị bài viết

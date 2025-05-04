# Quy Trình Đổi Mật Khẩu Của User
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống cho phép người dùng đổi mật khẩu tài khoản của mình
- Áp dụng cho tất cả các loại người dùng: User thông thường, Author, Moderator và Admin
- Có xử lý đặc biệt cho tài khoản đăng nhập bằng mạng xã hội (Google, Facebook)
- Đảm bảo tính bảo mật với các yêu cầu về độ phức tạp của mật khẩu
- Yêu cầu xác nhận mật khẩu hiện tại trước khi đổi

---

## 2. Các Loại Tài Khoản Và Đặc Điểm

### Tài khoản đăng ký thông thường
- Đăng ký bằng email, username và mật khẩu
- Lưu trữ mật khẩu đã được mã hóa (hashed) trong cơ sở dữ liệu
- Có thể đổi mật khẩu bất cứ lúc nào

### Tài khoản đăng nhập bằng mạng xã hội
- Đăng nhập thông qua Google hoặc Facebook
- Không có mật khẩu trong cơ sở dữ liệu (`password` = null)
- Không thể đổi mật khẩu vì không sử dụng mật khẩu để đăng nhập

---

## 3. Quy Trình Hiển Thị Form Đổi Mật Khẩu

### Truy cập form đổi mật khẩu:
1. Người dùng truy cập vào trang đổi mật khẩu thông qua menu hoặc trang cá nhân
2. Hệ thống kiểm tra loại tài khoản của người dùng

### Kiểm tra loại tài khoản:
```php
public function showChangePasswordForm()
{
    $user = Auth::user();

    // Nếu user đăng nhập bằng Google/Facebook, chuyển hướng về profile với thông báo
    if (!$user->password) {
        return redirect()
            ->route('profile')
            ->with(
                'error',
                'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
            );
    }
    
    return view('website.profiles.users.change-password', compact('user'));
}
```

### Hiển thị form tương ứng với loại người dùng:
- User thông thường: `website.profiles.users.change-password`
- Author: `author.profile-setting`
- Moderator: `moderator.profile-setting`
- Admin: Sử dụng form chung

---

## 4. Giao Diện Form Đổi Mật Khẩu

### Form đổi mật khẩu cho user thông thường:
```html
<form action="{{ route('profile.update-password') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
        <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
        <div class="input-group">
            <input type="password" id="current_password" name="current_password"
                class="form-control @error('current_password') is-invalid @enderror" required>
            <span class="input-group-text toggle-password" data-target="current_password">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="new_password" class="form-label">Mật khẩu mới</label>
        <div class="input-group">
            <input type="password" id="new_password" name="new_password" 
                class="form-control @error('new_password') is-invalid @enderror" required>
            <span class="input-group-text toggle-password" data-target="new_password">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        @error('new_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-4">
        <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
        <div class="input-group">
            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                class="form-control @error('new_password_confirmation') is-invalid @enderror" required>
            <span class="input-group-text toggle-password" data-target="new_password_confirmation">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        @error('new_password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Cập nhật mật khẩu
        </button>
    </div>
</form>
```

---

## 5. Quy Trình Xử Lý Đổi Mật Khẩu

### Khi người dùng gửi form đổi mật khẩu:
1. Hệ thống kiểm tra lại loại tài khoản
   ```php
   $user = Auth::user();

   // Nếu user đăng nhập bằng Google/Facebook thì không cho đổi mật khẩu
   if (!$user->password) {
       return redirect()
           ->route('profile')
           ->with(
               'error',
               'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.'
           );
   }
   ```

2. Kiểm tra dữ liệu nhập vào
   ```php
   $request->validate([
       'current_password' => 'required',
       'new_password' => 'required|min:8|confirmed',
   ]);
   ```

3. Kiểm tra mật khẩu hiện tại
   ```php
   if (!Hash::check($request->current_password, $user->password)) {
       return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
   }
   ```

4. Cập nhật mật khẩu mới
   ```php
   $user->update([
       'password' => Hash::make($request->new_password),
   ]);
   ```

5. Thông báo thành công và chuyển hướng
   ```php
   return redirect()
       ->back()
       ->with('success', 'Mật khẩu đã được cập nhật thành công.');
   ```

---

## 6. Xử Lý Lỗi Và Thông Báo

### Các loại lỗi có thể xảy ra:
1. **Tài khoản đăng nhập bằng mạng xã hội**
   - Thông báo: "Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu."
   - Chuyển hướng về trang profile

2. **Mật khẩu hiện tại không đúng**
   - Thông báo: "Mật khẩu hiện tại không đúng."
   - Giữ người dùng ở form đổi mật khẩu

3. **Mật khẩu mới không đáp ứng yêu cầu**
   - Thông báo: "Mật khẩu phải có ít nhất 8 ký tự."
   - Giữ người dùng ở form đổi mật khẩu

4. **Xác nhận mật khẩu không khớp**
   - Thông báo: "Xác nhận mật khẩu không khớp."
   - Giữ người dùng ở form đổi mật khẩu

### Hiển thị thông báo thành công:
```php
return redirect()
    ->back()
    ->with('success', 'Mật khẩu đã được cập nhật thành công.');
```

---

## 7. Quy Trình Đổi Mật Khẩu Cho Các Vai Trò Khác Nhau

### Đường dẫn truy cập form đổi mật khẩu:
- User thông thường: `/user/change-password`
- Author: `/author/change-password`
- Moderator: `/moderator/change-password`
- Admin: Sử dụng route chung

### Controller xử lý:
```php
// User thông thường
public function showChangePasswordForm()
{
    $user = Auth::user();
    // Kiểm tra tài khoản mạng xã hội
    return view('website.profiles.users.change-password', compact('user'));
}

// Moderator
public function showChangePasswordFormModerator()
{
    $user = Auth::user();
    // Kiểm tra tài khoản mạng xã hội
    return view('moderator.profile-setting');
}

// Author
public function showChangePasswordFormAuthor()
{
    $user = Auth::user();
    // Kiểm tra tài khoản mạng xã hội
    return view('author.profile-setting');
}
```

### Route định nghĩa:
```php
// User
Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('user.change-password');

// Author
Route::get('/change-password', [ProfileController::class, 'showChangePasswordFormAuthor'])->name('author.change-password');

// Moderator
Route::get('/change-password', [ProfileController::class, 'showChangePasswordFormModerator'])->name('moderator.change-password');

// Route chung cho việc cập nhật mật khẩu
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
```

---

## 8. Bảo Mật Trong Quy Trình Đổi Mật Khẩu

### Các biện pháp bảo mật được áp dụng:
1. **Mã hóa mật khẩu**
   - Sử dụng `Hash::make()` để mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
   - Sử dụng `Hash::check()` để so sánh mật khẩu nhập vào với mật khẩu đã mã hóa

2. **Yêu cầu xác thực mật khẩu hiện tại**
   - Người dùng phải nhập đúng mật khẩu hiện tại mới được đổi mật khẩu
   - Ngăn chặn việc đổi mật khẩu trái phép khi người dùng quên đăng xuất

3. **Yêu cầu về độ phức tạp của mật khẩu**
   - Mật khẩu phải có ít nhất 8 ký tự
   - Yêu cầu xác nhận mật khẩu để tránh lỗi đánh máy

4. **Bảo vệ form bằng CSRF token**
   - Sử dụng `@csrf` trong form để ngăn chặn tấn công CSRF
   - Đảm bảo request đổi mật khẩu đến từ form hợp lệ

---

## 9. Quy Trình Quên Mật Khẩu

### Khi người dùng quên mật khẩu:
1. Truy cập trang quên mật khẩu
2. Nhập email đã đăng ký
3. Hệ thống gửi email chứa link đặt lại mật khẩu
4. Người dùng nhấp vào link và nhập mật khẩu mới
5. Hệ thống cập nhật mật khẩu mới

### Xử lý đặt lại mật khẩu:
```php
public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:8|confirmed',
        'token' => 'required'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        // Kiểm tra nếu email thuộc Admin hay User
        $isAdmin = \App\Models\User::where('email', $request->email)->where('role_id', 1)->exists();

        return redirect()->route($isAdmin ? 'loginadmin' : 'loginuser')->with('status', __($status));
    }

    return back()->withErrors(['email' => __($status)]);
}
```

---

## 10. Kết Luận

- Tính năng đổi mật khẩu là một phần quan trọng của hệ thống bảo mật trong 24hNews
- Được thiết kế để hoạt động với tất cả các loại người dùng
- Có xử lý đặc biệt cho tài khoản đăng nhập bằng mạng xã hội
- Đảm bảo tính bảo mật với các yêu cầu về độ phức tạp của mật khẩu
- Cung cấp thông báo rõ ràng cho người dùng trong quá trình đổi mật khẩu

# Quy Trình Nâng Cấp Từ User Lên Author
## Dự án 24hNews

---

## 1. Tổng Quan Về Tính Năng

- Hệ thống cho phép người dùng thông thường (User) nâng cấp lên tác giả (Author)
- Quy trình kiểm duyệt hai bước: User gửi yêu cầu, Admin/Moderator xem xét và phê duyệt
- Yêu cầu cung cấp giấy tờ tùy thân và chứng chỉ hành nghề để đảm bảo tính xác thực
- Mục đích: Đảm bảo chất lượng nội dung và tính xác thực của người viết bài

---

## 2. Quy Trình Từ Phía Người Dùng (User)

### 2.1. Điều kiện tiên quyết
- Người dùng đã đăng nhập vào hệ thống
- Người dùng có vai trò là User (role_id = 4)
- Người dùng chưa có yêu cầu nâng cấp đang chờ duyệt

### 2.2. Kiểm tra tình trạng yêu cầu
```php
public function upgradeToAuthor()
{
    $user = auth()->user();

    // Ghi log để gỡ lỗi
    Log::info('Bắt đầu kiểm tra yêu cầu nâng cấp', [
        'user_id' => $user->user_id,
        'user_name' => $user->name
    ]);

    // Kiểm tra xem user đã gửi yêu cầu chưa
    $existingRequest = Approval::where('user_id', $user->user_id)
        ->where('type', 'role_upgrade')
        ->where('requested_role', 'author')
        ->latest()
        ->first();

    if ($existingRequest) {
        if ($existingRequest->status === 'pending') {
            return redirect()->to('/user/upgrade-result')
                ->with('error', 'Bạn đã gửi yêu cầu trước đó và đang chờ duyệt.');
        } elseif ($existingRequest->status === 'approved') {
            return redirect()->to('/user/upgrade-result')
                ->with('error', 'Bạn đã là tác giả của hệ thống.');
        }
        // Nếu yêu cầu bị từ chối, cho phép gửi yêu cầu mới
    }

    return view('website.profiles.users.upgrade', compact('user'));
}
```

---

## 3. Form Nâng Cấp Lên Tác Giả

### 3.1. Giao diện form
- Form được hiển thị trong view `website.profiles.users.upgrade`
- Bao gồm các trường thông tin cá nhân và tải lên giấy tờ
- Sử dụng `enctype="multipart/form-data"` để hỗ trợ tải lên file

### 3.2. Các trường thông tin cá nhân
- Họ tên đầy đủ
- Ngày sinh (phải từ 18 đến 45 tuổi)
- Số điện thoại (định dạng Việt Nam)
- Địa chỉ (tỉnh/thành phố, quận/huyện, phường/xã, địa chỉ chi tiết)

### 3.3. Các trường giấy tờ
- Ảnh CCCD mặt trước (bắt buộc)
- Ảnh CCCD mặt sau (bắt buộc)
- Số CCCD (bắt buộc, 12 chữ số)
- Chứng chỉ hành nghề (bắt buộc, file PDF, có thể tải nhiều file)

### 3.4. Xem trước ảnh CCCD
```javascript
function previewImage(event, previewId) {
    let input = event.target;
    let reader = new FileReader();
    let preview = document.getElementById(previewId);

    reader.onload = function () {
        preview.src = reader.result;
        preview.classList.remove('d-none');
    };

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
```

---

## 4. Validation Dữ Liệu

### 4.1. Validation phía client
```javascript
// Validate form trước khi submit
form.addEventListener('submit', function(e) {
    const isFullnameValid = validateFullname();
    const isDobValid = validateDob();
    const isPhoneValid = validatePhone();
    const isCCCDValid = validateCCCD();
    const isAddressValid = validateAddress();

    if (!isFullnameValid || !isDobValid || !isPhoneValid || !isCCCDValid || !isAddressValid) {
        e.preventDefault();
    }
});
```

### 4.2. Validation ngày sinh
```javascript
function validateDob() {
    const value = dobInput.value;
    removeError(dobInput);

    if (!value) {
        showError(dobInput, 'Ngày sinh là bắt buộc');
        return false;
    }

    const today = new Date();
    const birthDate = new Date(value);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 18) {
        showError(dobInput, 'Bạn phải đủ 18 tuổi trở lên');
        return false;
    }

    if (age > 45) {
        showError(dobInput, 'Tuổi của bạn không được vượt quá 45');
        return false;
    }

    return true;
}
```

### 4.3. Validation số CCCD
```javascript
function validateCCCD() {
    const value = cccdInput.value.trim();
    removeError(cccdInput);

    if (!value) {
        showError(cccdInput, 'Số CCCD là bắt buộc');
        return false;
    }

    const cccdRegex = /^[0-9]{12}$/;
    if (!cccdRegex.test(value)) {
        showError(cccdInput, 'Số CCCD phải có 12 chữ số');
        return false;
    }

    return true;
}
```

---

## 5. Xử Lý Yêu Cầu Nâng Cấp

### 5.1. Xử lý form submit
```php
public function requestAuthorRole(Request $request)
{
    $user = auth()->user();

    // Kiểm tra xem user đã có yêu cầu đang chờ duyệt chưa
    $existingRequest = Approval::where([
        'user_id' => $user->user_id,
        'type' => 'role_upgrade',
        'status' => 'pending',
        'requested_role' => 'author'
    ])->first();

    if ($existingRequest) {
        return redirect()->route('user.upgrade.result')
            ->with('error', 'Bạn đã gửi yêu cầu trước đó và đang chờ duyệt.');
    }

    // Validate dữ liệu
    $request->validate([
        'fullname' => 'required|string|max:255',
        'dob' => 'required|date',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'cccd_number' => 'required|string|size:12',
        'cccd_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'cccd_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'certificates' => 'required|array',
        'certificates.*' => 'required|mimes:pdf|max:10240',
    ]);

    // Cập nhật thông tin người dùng
    $user->fullname = $request->fullname;
    $user->dob = $request->dob;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->save();

    // Lưu ảnh CCCD
    $cccdFrontPath = $request->file('cccd_front')->store('public/cccd');
    $cccdBackPath = $request->file('cccd_back')->store('public/cccd');

    // Lưu các chứng chỉ
    $certificatePaths = [];
    foreach ($request->file('certificates') as $certificate) {
        $path = $certificate->store('public/certificates');
        $certificatePaths[] = str_replace('public/', '', $path);
    }

    // Tạo yêu cầu nâng cấp
    $approval = new Approval();
    $approval->type = 'role_upgrade';
    $approval->user_id = $user->user_id;
    $approval->requested_role = 'author';
    $approval->status = 'pending';
    $approval->cccd_number = $request->cccd_number;
    $approval->cccd_front = str_replace('public/', '', $cccdFrontPath);
    $approval->cccd_back = str_replace('public/', '', $cccdBackPath);
    $approval->certificates = json_encode($certificatePaths);
    $approval->save();

    // Gửi thông báo cho tất cả admin
    $admins = User::where('role_id', 1)->get();
    foreach ($admins as $admin) {
        $admin->notify(new AuthorUpgradeRequest($user));
    }

    return redirect()->route('user.upgrade.result')
        ->with('status', 'Yêu cầu nâng cấp tài khoản đã được gửi thành công.');
}
```

---

## 6. Thông Báo Cho Admin

### 6.1. Tạo thông báo
```php
// Trong AuthorUpgradeRequest.php
public function toArray(object $notifiable): array
{
    return [
        'title' => 'Yêu cầu nâng cấp tài khoản',
        'message' => "Có " . \App\Models\Approval::where('type', 'role_upgrade')
            ->where('status', 'pending')
            ->count() . " yêu cầu nâng cấp lên tác giả đang chờ duyệt",
        'user_id' => $this->requestingUser->user_id,
    ];
}
```

### 6.2. Gửi thông báo
```php
// Gửi thông báo cho tất cả admin
$admins = User::where('role_id', 1)->get();
foreach ($admins as $admin) {
    $admin->notify(new AuthorUpgradeRequest($user));
}
```

---

## 7. Quy Trình Từ Phía Admin

### 7.1. Xem danh sách yêu cầu nâng cấp
```php
public function roleUpgradeRequests(Request $request)
{
    $roles = Role::all();
    $role_id = $request->input('role_id');

    $approvals = Approval::with('user.role')
        ->where('type', 'role_upgrade')
        ->where('status', 'pending')
        ->when($role_id, function ($query) use ($role_id) {
            return $query->whereHas(
                'user',
                function ($q) use ($role_id) {
                    $q->where('role_id', $role_id);
                }
            );
        })
        ->paginate(10);

    return view(
        'admin.users.upgrade-requests',
        compact('approvals', 'roles', 'role_id')
    );
}
```

### 7.2. Xem chi tiết yêu cầu nâng cấp
```php
public function showApprovalDetail($id)
{
    $approval = Approval::with('user')->findOrFail($id);
    return view('admin.users.approval-detail', compact('approval'));
}
```

---

## 8. Phê Duyệt Hoặc Từ Chối Yêu Cầu

### 8.1. Phê duyệt yêu cầu
```php
public function approve(Request $request, $id)
{
    try {
        $approval = Approval::findOrFail($id);
        $user = $approval->user;

        // Kiểm tra xem yêu cầu đã được xử lý chưa
        if ($approval->status !== 'pending') {
            return redirect()->back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $role = Role::where('name', $approval->requested_role)->first();
        if ($role) {
            $user->update(['role_id' => $role->role_id]);
        }

        $approval->update([
            'status' => 'approved',
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        return redirect()->route('admin.user-role-requests')
            ->with('success', 'Yêu cầu nâng cấp đã được phê duyệt thành công.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
    }
}
```

### 8.2. Từ chối yêu cầu
```php
public function reject(Request $request, $id)
{
    try {
        $approval = Approval::findOrFail($id);

        // Kiểm tra xem yêu cầu đã được xử lý chưa
        if ($approval->status !== 'pending') {
            return redirect()->back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
        }

        $approval->update([
            'status' => 'rejected',
            'remarks' => $request->reason,
            'processed_at' => now(),
            'processed_by' => auth()->id()
        ]);

        return redirect()->route('admin.user-role-requests')
            ->with('success', 'Yêu cầu nâng cấp đã bị từ chối.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
    }
}
```

---

## 9. Các Trạng Thái Của Yêu Cầu Nâng Cấp

### 9.1. Pending (Đang chờ duyệt)
- Yêu cầu đã được gửi nhưng chưa được xử lý
- Người dùng không thể gửi yêu cầu mới khi có yêu cầu đang ở trạng thái này
- Admin/Moderator có thể xem và xử lý yêu cầu

### 9.2. Approved (Đã duyệt)
- Yêu cầu đã được phê duyệt
- Vai trò của người dùng đã được nâng cấp lên Author (role_id = 2)
- Người dùng có thể sử dụng các tính năng của Author

### 9.3. Rejected (Đã từ chối)
- Yêu cầu đã bị từ chối
- Vai trò của người dùng không thay đổi
- Người dùng có thể gửi yêu cầu mới

---

## 10. Quyền Hạn Sau Khi Nâng Cấp

Sau khi được nâng cấp lên Author, người dùng có thể:
- Tạo và quản lý bài viết
- Gửi bài viết để kiểm duyệt
- Xem thống kê về bài viết của mình
- Tương tác với người đọc thông qua bình luận
- Và các quyền khác dành cho Author

---

## 11. Kết Luận

- Quy trình nâng cấp từ User lên Author trong hệ thống 24hNews là một quy trình kiểm duyệt hai bước
- Đảm bảo rằng chỉ những người dùng đủ điều kiện mới được nâng cấp lên vai trò Author
- Giúp duy trì chất lượng nội dung trên hệ thống và đảm bảo tính xác thực của người viết bài
- Cung cấp trải nghiệm người dùng tốt với giao diện trực quan và thông báo rõ ràng

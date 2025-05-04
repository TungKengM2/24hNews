# Quy Trình Nâng Cấp Từ User Lên Author
## Hệ thống 24hNews

---

## Nội dung thuyết trình

1. Tổng quan về quy trình
2. Quy trình từ phía người dùng (User)
3. Quy trình từ phía quản trị viên (Admin/Moderator)
4. Các trạng thái của yêu cầu nâng cấp
5. Dữ liệu yêu cầu nâng cấp
6. Quyền hạn sau khi nâng cấp

---

## 1. Tổng quan về quy trình

- Quy trình kiểm duyệt hai bước
- Người dùng (User) gửi yêu cầu nâng cấp kèm giấy tờ
- Quản trị viên (Admin/Moderator) xem xét và phê duyệt/từ chối
- Mục đích: Đảm bảo chất lượng nội dung và tính xác thực của người viết bài

---

## 2. Quy trình từ phía người dùng (User)

### 2.1. Điều kiện tiên quyết
- Đã đăng nhập vào hệ thống
- Có vai trò là User (role_id = 4)
- Chưa có yêu cầu nâng cấp đang chờ duyệt

---

## 2.2. Các bước thực hiện

1. **Truy cập trang yêu cầu nâng cấp**
   - Đường dẫn: `/user/upgrade`
   - Hệ thống kiểm tra tình trạng yêu cầu trước đó

2. **Điền thông tin và tải lên giấy tờ**
   - Thông tin cá nhân
   - Ảnh CCCD mặt trước và mặt sau
   - Số CCCD
   - Chứng chỉ hành nghề (PDF)

3. **Gửi yêu cầu nâng cấp**
   - Lưu vào bảng `approvals` với trạng thái `pending`
   - Gửi thông báo đến tất cả admin

---

## 3. Quy trình từ phía quản trị viên (Admin/Moderator)

### 3.1. Nhận thông báo yêu cầu nâng cấp
- Thông báo hiển thị số lượng yêu cầu đang chờ duyệt

### 3.2. Xem danh sách yêu cầu nâng cấp
- Hiển thị: ID, Username, Email, Số điện thoại, Thời gian
- Có thể lọc theo vai trò hiện tại của người dùng

---

### 3.3. Xem chi tiết yêu cầu nâng cấp
- Thông tin cá nhân của người dùng
- Ảnh CCCD mặt trước và mặt sau
- Số CCCD
- Danh sách các chứng chỉ đã tải lên
- Thời gian hoạt động của tài khoản
- Tình trạng tài khoản

---

### 3.4. Phê duyệt hoặc từ chối yêu cầu

#### Phê duyệt yêu cầu:
- Cập nhật trạng thái thành `approved`
- Cập nhật vai trò thành Author (role_id = 2)
- Ghi log kiểm duyệt
- Xóa thông báo liên quan

#### Từ chối yêu cầu:
- Nhập lý do từ chối
- Cập nhật trạng thái thành `rejected`
- Ghi log kiểm duyệt
- Xóa thông báo liên quan

---

## 4. Các trạng thái của yêu cầu nâng cấp

### 4.1. Pending (Đang chờ duyệt)
- Yêu cầu đã gửi nhưng chưa được xử lý
- Không thể gửi yêu cầu mới khi có yêu cầu đang ở trạng thái này

### 4.2. Approved (Đã duyệt)
- Yêu cầu đã được phê duyệt
- Vai trò đã được nâng cấp lên Author

### 4.3. Rejected (Đã từ chối)
- Yêu cầu đã bị từ chối
- Vai trò không thay đổi
- Có thể gửi yêu cầu mới

---

## 5. Dữ liệu yêu cầu nâng cấp

### 5.1. Thông tin cá nhân
- Họ tên đầy đủ
- Ngày sinh (18-45 tuổi)
- Số điện thoại (định dạng Việt Nam)
- Địa chỉ

### 5.2. Giấy tờ tùy thân
- Số CCCD (12 chữ số)
- Ảnh CCCD mặt trước và mặt sau

---

### 5.3. Chứng chỉ hành nghề
- File PDF chứng chỉ hành nghề (nhiều file)
- Kích thước tối đa: 10MB mỗi file

### 5.4. Yêu cầu về giấy tờ
- CCCD rõ ràng, không mờ, không khuất góc
- Chứng chỉ còn hiệu lực
- File PDF rõ ràng
- Chứng chỉ liên quan đến lĩnh vực viết bài

---

## 6. Quyền hạn sau khi nâng cấp

Sau khi được nâng cấp lên Author, người dùng có thể:
- Tạo và quản lý bài viết
- Gửi bài viết để kiểm duyệt
- Xem thống kê về bài viết của mình
- Tương tác với người đọc thông qua bình luận
- Và các quyền khác dành cho Author

---

## Lưu đồ quy trình nâng cấp

```
User                                Admin/Moderator
┌─────────────────┐                ┌─────────────────┐
│ Truy cập trang  │                │ Nhận thông báo  │
│ yêu cầu nâng cấp│                │ yêu cầu nâng cấp│
└────────┬────────┘                └────────┬────────┘
         │                                   │
         ▼                                   ▼
┌─────────────────┐                ┌─────────────────┐
│ Điền thông tin  │                │ Xem danh sách   │
│ và tải giấy tờ  │                │ yêu cầu nâng cấp│
└────────┬────────┘                └────────┬────────┘
         │                                   │
         ▼                                   ▼
┌─────────────────┐                ┌─────────────────┐
│ Gửi yêu cầu     │───────────────▶│ Xem chi tiết    │
│ nâng cấp        │                │ yêu cầu nâng cấp│
└─────────────────┘                └────────┬────────┘
                                            │
                                            ▼
                                   ┌─────────────────┐
                                   │ Quyết định      │
                                   └────────┬────────┘
                                            │
                   ┌────────────────────────┴────────────────────────┐
                   │                                                  │
                   ▼                                                  ▼
          ┌─────────────────┐                               ┌─────────────────┐
          │ Phê duyệt       │                               │ Từ chối         │
          └────────┬────────┘                               └────────┬────────┘
                   │                                                  │
                   ▼                                                  ▼
          ┌─────────────────┐                               ┌─────────────────┐
          │ Cập nhật vai trò│                               │ Ghi log và      │
          │ thành Author    │                               │ thông báo       │
          └────────┬────────┘                               └────────┬────────┘
                   │                                                  │
                   ▼                                                  ▼
          ┌─────────────────┐                               ┌─────────────────┐
          │ Ghi log và      │                               │ User có thể     │
          │ thông báo       │                               │ gửi yêu cầu mới │
          └─────────────────┘                               └─────────────────┘
```

---

## Kết luận

- Quy trình nâng cấp từ User lên Author là quy trình kiểm duyệt hai bước
- Đảm bảo chỉ những người dùng đủ điều kiện mới được nâng cấp
- Giúp duy trì chất lượng nội dung và tính xác thực của người viết bài
- Quy trình minh bạch và có thể kiểm soát

# QUY TRÌNH NÂNG CẤP TỪ USER LÊN AUTHOR
## Hệ thống 24hNews

---

## 1. Tổng quan về quy trình

Quy trình nâng cấp từ user lên author trong hệ thống 24hNews là một quy trình kiểm duyệt hai bước, trong đó:
- **Người dùng (User)** gửi yêu cầu nâng cấp kèm theo các giấy tờ cần thiết
- **Quản trị viên (Admin/Moderator)** xem xét và phê duyệt hoặc từ chối yêu cầu

---

## 2. Quy trình từ phía người dùng (User)

### 2.1. Điều kiện tiên quyết
- Người dùng đã đăng nhập vào hệ thống
- Người dùng có vai trò là User (role_id = 4)
- Người dùng chưa có yêu cầu nâng cấp đang chờ duyệt

### 2.2. Các bước thực hiện

1. **Truy cập trang yêu cầu nâng cấp**
   - Người dùng truy cập vào đường dẫn `/user/upgrade`
   - Hệ thống kiểm tra xem người dùng đã có yêu cầu nâng cấp trước đó hay chưa
   - Nếu đã có yêu cầu đang chờ duyệt, chuyển hướng đến trang kết quả với thông báo lỗi
   - Nếu đã là author, chuyển hướng đến trang kết quả với thông báo lỗi
   - Nếu chưa có yêu cầu hoặc yêu cầu trước đó đã bị từ chối, hiển thị form nâng cấp

2. **Điền thông tin và tải lên giấy tờ**
   - Điền các thông tin cá nhân (nếu chưa có)
   - Tải lên ảnh CCCD mặt trước và mặt sau
   - Nhập số CCCD
   - Tải lên các chứng chỉ hành nghề liên quan (dạng PDF)

3. **Gửi yêu cầu nâng cấp**
   - Nhấn nút "Gửi yêu cầu nâng cấp"
   - Hệ thống lưu thông tin vào bảng `approvals` với trạng thái `pending`
   - Hệ thống gửi thông báo đến tất cả admin
   - Chuyển hướng đến trang kết quả với thông báo thành công

---

## 3. Quy trình từ phía quản trị viên (Admin/Moderator)

### 3.1. Nhận thông báo yêu cầu nâng cấp
- Admin nhận được thông báo về yêu cầu nâng cấp mới
- Thông báo hiển thị số lượng yêu cầu đang chờ duyệt

### 3.2. Xem danh sách yêu cầu nâng cấp
- Admin truy cập vào trang danh sách yêu cầu nâng cấp
- Danh sách hiển thị các thông tin cơ bản: ID, Username, Email, Số điện thoại, Thời gian yêu cầu
- Admin có thể lọc danh sách theo vai trò hiện tại của người dùng

### 3.3. Xem chi tiết yêu cầu nâng cấp
- Admin nhấn vào nút "Xem chi tiết" để xem thông tin chi tiết về yêu cầu
- Hệ thống hiển thị:
  - Thông tin cá nhân của người dùng
  - Ảnh CCCD mặt trước và mặt sau
  - Số CCCD
  - Danh sách các chứng chỉ đã tải lên
  - Thời gian hoạt động của tài khoản
  - Tình trạng tài khoản (có bị cấm hay không)

### 3.4. Phê duyệt hoặc từ chối yêu cầu

#### Phê duyệt yêu cầu:
- Admin nhấn nút "Duyệt yêu cầu"
- Hệ thống cập nhật trạng thái yêu cầu thành `approved`
- Hệ thống cập nhật vai trò của người dùng thành Author (role_id = 2)
- Hệ thống ghi log kiểm duyệt vào bảng `moderation_logs`
- Hệ thống xóa thông báo liên quan đến yêu cầu này
- Chuyển hướng về trang danh sách yêu cầu với thông báo thành công

#### Từ chối yêu cầu:
- Admin nhấn nút "Từ chối yêu cầu"
- Hiển thị modal yêu cầu nhập lý do từ chối
- Admin nhập lý do từ chối và xác nhận
- Hệ thống cập nhật trạng thái yêu cầu thành `rejected`
- Hệ thống ghi log kiểm duyệt vào bảng `moderation_logs`
- Hệ thống xóa thông báo liên quan đến yêu cầu này
- Chuyển hướng về trang danh sách yêu cầu với thông báo thành công

---

## 4. Các trạng thái của yêu cầu nâng cấp

### 4.1. Pending (Đang chờ duyệt)
- Yêu cầu đã được gửi nhưng chưa được xử lý
- Người dùng không thể gửi yêu cầu mới khi có yêu cầu đang ở trạng thái này
- Admin/Moderator có thể xem và xử lý yêu cầu

### 4.2. Approved (Đã duyệt)
- Yêu cầu đã được phê duyệt
- Vai trò của người dùng đã được nâng cấp lên Author
- Người dùng có thể truy cập các tính năng dành cho Author

### 4.3. Rejected (Đã từ chối)
- Yêu cầu đã bị từ chối
- Vai trò của người dùng không thay đổi
- Người dùng có thể gửi yêu cầu mới

---

## 5. Lưu đồ quy trình nâng cấp

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
│ Gửi yêu cầu     │                │ Xem chi tiết    │
│ nâng cấp        │───────────────▶│ yêu cầu nâng cấp│
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

## 6. Dữ liệu yêu cầu nâng cấp

### 6.1. Thông tin cá nhân
- Họ tên đầy đủ
- Ngày sinh (phải từ 18 đến 45 tuổi)
- Số điện thoại (định dạng Việt Nam)
- Địa chỉ

### 6.2. Giấy tờ tùy thân
- Số CCCD (12 chữ số)
- Ảnh CCCD mặt trước
- Ảnh CCCD mặt sau

### 6.3. Chứng chỉ hành nghề
- File PDF chứng chỉ hành nghề (có thể tải nhiều file)
- Kích thước tối đa: 10MB mỗi file

### 6.4. Yêu cầu về giấy tờ
- CCCD phải rõ ràng, không bị mờ, không bị khuất góc
- Chứng chỉ phải còn hiệu lực
- File PDF phải rõ ràng, không bị mờ
- Chứng chỉ phải liên quan đến lĩnh vực muốn viết bài

---

## 7. Quyền hạn sau khi nâng cấp

Sau khi được nâng cấp lên Author, người dùng có thể:
- Tạo và quản lý bài viết
- Gửi bài viết để kiểm duyệt
- Xem thống kê về bài viết của mình
- Tương tác với người đọc thông qua bình luận
- Và các quyền khác dành cho Author

---

## 8. Kết luận

Quy trình nâng cấp từ User lên Author trong hệ thống 24hNews là một quy trình kiểm duyệt hai bước, đảm bảo rằng chỉ những người dùng đủ điều kiện mới được nâng cấp lên vai trò Author. Quy trình này giúp duy trì chất lượng nội dung trên hệ thống và đảm bảo tính xác thực của người viết bài.

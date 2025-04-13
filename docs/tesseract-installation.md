# Hướng dẫn cài đặt Tesseract OCR

Để sử dụng tính năng tự động điền thông tin từ ảnh CCCD, bạn cần cài đặt Tesseract OCR trên máy chủ. Dưới đây là hướng dẫn cài đặt cho các hệ điều hành khác nhau:

## Windows

1. Tải Tesseract OCR từ trang chủ: https://github.com/UB-Mannheim/tesseract/wiki
2. Chọn phiên bản phù hợp với hệ thống của bạn (32-bit hoặc 64-bit)
3. Chạy file cài đặt và làm theo hướng dẫn
4. Trong quá trình cài đặt, đảm bảo chọn cài đặt ngôn ngữ tiếng Việt (Vietnamese)
5. Sau khi cài đặt, thêm đường dẫn Tesseract vào biến môi trường PATH:
   - Mở Control Panel > System > Advanced System Settings > Environment Variables
   - Tìm biến PATH trong phần System Variables
   - Thêm đường dẫn cài đặt Tesseract (thường là `C:\Program Files\Tesseract-OCR`)

## Linux (Ubuntu/Debian)

```bash
# Cài đặt Tesseract OCR
sudo apt-get update
sudo apt-get install tesseract-ocr

# Cài đặt ngôn ngữ tiếng Việt
sudo apt-get install tesseract-ocr-vie

# Kiểm tra cài đặt
tesseract --version
```

## macOS

```bash
# Sử dụng Homebrew
brew install tesseract
brew install tesseract-lang  # Cài đặt các ngôn ngữ bổ sung

# Kiểm tra cài đặt
tesseract --version
```

## Kiểm tra cài đặt

Sau khi cài đặt, bạn có thể kiểm tra xem Tesseract OCR đã được cài đặt đúng cách chưa bằng cách chạy lệnh sau trong terminal:

```bash
tesseract --version
```

Nếu hiển thị phiên bản Tesseract, điều đó có nghĩa là cài đặt đã thành công.

## Xử lý lỗi

Nếu gặp lỗi "Không tìm thấy Tesseract OCR", hãy kiểm tra:

1. Tesseract OCR đã được cài đặt chưa
2. Đường dẫn Tesseract đã được thêm vào biến môi trường PATH chưa
3. Khởi động lại máy chủ web sau khi cài đặt

## Lưu ý

- Đảm bảo máy chủ có đủ quyền truy cập vào thư mục cài đặt Tesseract
- Nếu sử dụng Docker, bạn cần cài đặt Tesseract OCR trong container
- Đối với môi trường production, nên cài đặt Tesseract OCR trên máy chủ riêng để tránh ảnh hưởng đến hiệu suất 
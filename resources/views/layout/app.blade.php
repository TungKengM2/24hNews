<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang cá nhân')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Reset mặc định */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        /* Header */
        header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }

        /* Container bố cục chính */
        .container {
            display: flex;
            flex-wrap: nowrap;
            /* Ngăn xuống dòng */
            align-items: flex-start;
            /* Căn đều theo trục dọc */
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            gap: 20px;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            flex-shrink: 0;
            /* Ngăn sidebar bị co lại */
        }

        /* Avatar */
        .sidebar .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }



        .sidebar h3 {
            margin-top: 10px;
            font-size: 18px;
        }

        /* Menu sidebar */
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        .sidebar ul li {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .sidebar ul li i {
            font-size: 18px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .sidebar ul li.active,
        .sidebar ul li:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Đổi màu cho mục đăng xuất */
        .sidebar ul li.logout {
            margin-top: 20px;
            color: #ffcccb;
        }

        /* Nội dung chính */
        .content {
            flex-grow: 1;
            padding: 20px;
            background: white;
            border-radius: 10px;
        }

        /* PROFILE FORM */
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h4 {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .avatar-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #ddd;
            /* Thêm viền cho nổi bật */
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-edit {
            position: absolute;
            bottom: 10px;
            /* Đẩy lên trên */
            right: 10px;
            /* Đẩy sang trái một chút */
            width: 45px;
            /* Tăng kích thước */
            height: 45px;
            background: white;
            color: black;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: background 0.3s;
        }

        .avatar-edit:hover {
            background: #e0e0e0;
        }

        .avatar-edit i {
            font-size: 20px;
            /* Làm icon lớn hơn */
        }
    </style>
</head>

<body>
    @include('layout.header')

    <div class="container">
        @include('layout.sidebar')

        <div class="content">
            @yield('content')
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const imageUpload = document.getElementById("avatarUpload");
            const imagePreview = document.getElementById("avatarPreview");

            document.querySelector(".avatar-edit").addEventListener("click", function() {
                imageUpload.click();
            });

            imageUpload.addEventListener("change", function() {
                if (this.files && this.files[0]) {
                    const formData = new FormData();
                    formData.append("image", this.files[0]); // Attach the image to the FormData
                    formData.append("_token", "{{ csrf_token() }}"); // Add the CSRF token for security

                    // Send the request to the server to upload the image
                    fetch("{{ route('profile.upload-avatar') }}", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Error uploading the image!");
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update the avatar preview with the new image URL
                            imagePreview.src = data.image_url;
                        } else {
                            alert("Error uploading the image.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("An error occurred while uploading the image.");
                    });

                    this.value = ""; // Reset input to allow re-uploading the same file
                }
            });
        });
        function openNotification(notificationId, message) {
        // Gửi request đánh dấu đã đọc và xóa luôn thông báo
        fetch(`/notifications/${notificationId}/read`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json",
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ẩn thông báo đã đọc trên giao diện
                document.getElementById(`notification-${notificationId}`).remove();

                // Cập nhật số lượng thông báo chưa đọc
                let countElem = document.getElementById("notificationCount");
                if (countElem) {
                    let count = parseInt(countElem.innerText) - 1;
                    if (count <= 0) {
                        countElem.remove(); // Xóa badge khi không còn thông báo nào
                    } else {
                        countElem.innerText = count;
                    }
                }
            }
        })
        .catch(error => console.error("Error:", error));
    }
    </script>






</body>

</html>

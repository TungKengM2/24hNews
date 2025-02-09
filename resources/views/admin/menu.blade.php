<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu với Hiệu ứng Chữ Nhảy Sang Phải</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 40%;
        }
        .jump-effect {
            transition: transform 0.3s ease;
        }
        .jump-effect:hover {
            transform: translateX(20px);
        }
        .jump-effect:hover {
            transform: translateX(10px) scale(1.1);
        }
    </style>
</head>
<body>
        <div class="row">
            <div class="col-md-2 bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link jump-effect" href="#">
                                <i class="fas fa-newspaper"></i> Bài viết
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jump-effect" href="#"><i class="fas fa-users"></i> Người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jump-effect" href="#"><i class="fas fa-comments"></i> Bình luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jump-effect" href="#"><i class="fas fa-chart-bar"></i> Thống kê</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link jump-effect" href="#"><i class="fas fa-tags"></i> Thể loại</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
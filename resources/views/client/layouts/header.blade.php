<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNExpress Header & Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .info {
    display: flex;
    align-items: center;
    gap: 15px; /* Khoảng cách giữa các phần tử */
    white-space: nowrap;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }


        /* Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: white;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }
        .logo span {
            color: #b22222;
            font-weight: bold;
            border: 1px solid #b22222;
            padding: 2px 5px;
        }

        /* User info */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .user-avatar img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #b22222;
        }

        .user-name {
            font-weight: bold;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            padding: 10px;
        }

        .user-menu:hover .dropdown {
            display: block;
        }

        /* Menu chính */
        .menu {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 15px 20px;
            background: white;
            border-bottom: 1px solid #ddd;
            position: fixed;
            top: 50px;
            left: 00;
            width: 100%;
            z-index: 999;
            overflow-x: auto;
            white-space: nowrap;
        }

        .menu a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 14px;
            margin-top: 1px;
  

        }
        .menu a i {
            color: inherit; /* Icon cùng màu với chữ */
            font-size: 16px; /* Điều chỉnh kích thước icon */
        }

        /* Nội dung */
        .content {
            flex: 1;
            margin-top: 100px;
            padding: 20px;
        }

        /* Footer */
        .footer {
            background: #f8f8f8;
            padding: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
        a{
    text-decoration: none;
}
    </style>
</head>
<body>

<!-- Header -->
<div class="top-header">
  <div class="logo">24H<span>N</span>EWS</div>
    <div class="info">
        <span id="date-time"></span>
        @auth
        <div class="user-menu">
            <div class="user-avatar">
                <img src="{{ Auth::user()->image ?? asset('default-avatar.png') }}" alt="Avatar">
            </div>
            <div class="user-name">Xin chào, {{ Auth::user()->username }}</div>
            <div class="dropdown">
                <a href="{{ route('logout') }}" class="logout-btn">Đăng xuất</a>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="login-btn">Đăng nhập 🔔</a>
        @endauth
    </div>
</div>

<!-- Menu chính -->
<div class="menu">
    <a href="{{ url('/') }}"><i class="fas fa-home"></i> Trang chủ</a>
    <a href="/thoi-su"><i class="fas fa-newspaper"></i> Thời sự</a>
    <a href="/the-gioi"><i class="fas fa-globe"></i> Thế giới</a>
    <a href="/kinh-doanh"><i class="fas fa-chart-line"></i> Kinh doanh</a>
    <a href="/cong-nghe"><i class="fas fa-microchip"></i> Công nghệ</a>
    <a href="/khoa-hoc"><i class="fas fa-flask"></i> Khoa học</a>
    <a href="/video"><i class="fas fa-video"></i> Video</a>
    <a href="/podcasts"><i class="fas fa-podcast"></i> Podcasts</a>
    <a href="/bat-dong-san"><i class="fas fa-building"></i> Bất động sản</a>
    <a href="/suc-khoe"><i class="fas fa-heartbeat"></i> Sức khỏe</a>
    <a href="/the-thao"><i class="fas fa-futbol"></i> Thể thao</a>
</div>

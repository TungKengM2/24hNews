<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

::after,
::before {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

body {
    font-family: 'Poppins', sans-serif;
}

.wrapper {
    display: flex;
}

.main {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    width: 100%;
    overflow: hidden;
    transition: all 0.35s ease-in-out;
    background-color: #fff;
    min-width: 0;
}

#sidebar {
    width: 300px;
    min-width: 70px;
    position: relative;
    min-height: 100vh;
    z-index: 1000;
    transition: all .25s ease-in-out;
    background-color: #0e2238;
    display: flex;
    flex-direction: column;
}

#sidebar.expand {
    width: 260px;
    min-width: 260px;
}

.toggle-btn {
    background-color: transparent;
    cursor: pointer;
    border: 0;
    padding: 1rem 1.5rem;
}

.toggle-btn i {
    font-size: 1.5rem;
    color: #FFF;
}



@keyframes fadeIn {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

.sidebar-logo {
            margin: auto 0;
            padding: 20px 50px;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.15rem;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #FFF;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
            text-decoration: none; /* Ensure no underline on menu links */
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item {
            position: relative;
        }

        .sidebar-dropdown {
            display: none;
        }

        .sidebar-item:hover .sidebar-dropdown {
            display: block;
            background-color: #0e2238;
            padding-left: 1.625rem;
        }

        .sidebar-footer {
            margin: 1rem 1.625rem;
        }

.navbar {
    background-color: #f5f5f5;
    box-shadow: 0 0 2rem 0 rgba(33, 37, 41, .1);
}

.navbar-expand .navbar-collapse {
    min-width: 200px;
}

.avatar {
    height: 40px;
    width: 40px;
}



@media (min-width: 768px) {}
    </style>
</head>

<body>
    <div class="wrapper">
    <aside id="sidebar">
            <div class="d-flex">
                <div class="sidebar-logo">
                    <a href="#">logo 24hnews</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('articles.index') }}" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Article</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('categories.index') }}" class="sidebar-link">
                        <i class="lni lni-list"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown">
                        <i class="lni lni-protection"></i>
                        <span>Chức Năng </span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Chức Năng 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Chức Năng 2</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link has-dropdown">
                        <i class="lni lni-layout"></i>
                        <span>Liên Kết</span>
                    </a>
                    <ul class="sidebar-dropdown list-unstyled">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Liên kết 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Liên kết 2</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Thông báo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </aside>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

</body>

</html>
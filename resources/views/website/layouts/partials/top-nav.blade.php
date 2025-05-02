<style>
    /* Cho phép cuộn dọc nếu có nhiều hơn 4 danh mục */
    .sidebar-categories {
        max-height: 500px;
        /* Giới hạn chiều cao của danh sách danh mục */
        overflow-y: auto;
        /* Cho phép cuộn dọc */
    }

    /* Responsive styles */
    @media (max-width: 991.98px) {
        .top-navbar .date-weather {
            margin-bottom: 1rem !important;
        }

        .top-navbar .logo-brand {
            text-align: center;
            margin: 1rem 0;
        }

        .top-navbar .logo-brand img {
            max-width: 120px;
        }

        .top-navbar .sub-darkLight {
            text-align: center;
            margin-top: 1rem;
        }

        .offcanvas-body .row-cols-2 > .col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }

    @media (max-width: 767.98px) {
        .date-weather .item {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .date-weather .icon {
            font-size: 1.2rem;
            min-width: 24px;
        }

        .weather-form {
            min-width: 200px !important;
            right: 0 !important;
            left: auto !important;
        }

        .top-navbar .container {
            padding: 0 10px !important;
        }

        .offcanvas-body {
            padding: 1rem;
        }

        .offcanvas-body h6 {
            font-size: 1rem;
        }

        .offcanvas-body .row-cols-2 > .col {
            padding: 0.5rem;
        }

        .offcanvas-body .row-cols-2 > .col h5 {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .offcanvas-body .row-cols-2 > .col ul {
            padding-left: 0;
            margin-bottom: 0.5rem;
        }

        .offcanvas-body .row-cols-2 > .col ul li {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }
    }

    @media (max-width: 575.98px) {
        .top-navbar {
            padding: 0.5rem 0;
        }

        .top-navbar .container {
            padding: 0 5px !important;
        }

        .date-weather .row {
            flex-direction: column;
            margin: 0;
        }

        .date-weather .col-6 {
            width: 100%;
            padding: 0;
            margin-bottom: 0.5rem;
        }

        .date-weather .item {
            padding: 0.25rem 0;
        }

        .date-weather .inf {
            font-size: 0.9rem;
        }

        .date-weather .inf p {
            margin-bottom: 0.25rem;
        }

        .darkLight-btn {
            justify-content: center;
            padding: 0.5rem 0;
        }

        .darkLight-btn .icon {
            font-size: 1.2rem;
            padding: 0.5rem;
        }

        .offcanvas-header {
            padding: 0.5rem;
        }

        .offcanvas-body {
            padding: 0.75rem;
        }

        .offcanvas-body .row-cols-2 > .col {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0.25rem;
        }

        .offcanvas-body .row-cols-2 > .col h5 {
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .offcanvas-body .row-cols-2 > .col ul {
            padding-left: 0;
            margin-bottom: 0.25rem;
        }

        .offcanvas-body .row-cols-2 > .col ul li {
            font-size: 0.75rem;
            margin-bottom: 0.15rem;
        }

        .offcanvas-body .col-lg-3 {
            margin-top: 1rem;
        }

        .offcanvas-body .col-lg-3 h6 {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .offcanvas-body .col-lg-3 .text {
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .offcanvas-body .col-lg-3 .icon-box {
            padding: 0.25rem;
            margin-right: 0.5rem;
        }

        .offcanvas-body .col-lg-3 ul li {
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
        }

        .offcanvas-body .col-lg-3 .social-links {
            margin-top: 0.5rem;
        }

        .offcanvas-body .col-lg-3 .social-links a {
            font-size: 1rem;
            padding: 0.25rem;
        }
    }
</style>

<div class="top-navbar style-1">
    <div class="container p-0">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="date-weather mb-3 mb-lg-0">
                    <div class="row align-items-center g-0">
                        <div class="col-6 col-sm-6">
                            <div class="item">
                                <div class="icon me-2 pt-1">
                                    <i class="la la-calendar"></i>
                                </div>
                                <div class="inf">
                                    <div id="dateElement"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6">
                            <div class="item position-relative">
                                <div class="icon me-2 pt-1">
                                    <img id="weather-icon" alt="Biểu tượng thời tiết" style="width: 20px; height: 20px;">
                                </div>
                                <div class="inf">
                                    <strong>
                                        <p id="weather-temperature" class="mb-0"></p>
                                        <p id="weather-description" class="mb-0"></p>
                                    </strong>
                                    <p id="weather-city" class="mb-0"></p>
                                </div>
                                <div class="weather-form position-absolute bg-white p-2 rounded shadow"
                                    style="display: none; top: 100%; left: 0; z-index: 1000; min-width: 200px;">
                                    <div class="form-group">
                                        <input type="text" id="cityInput" class="form-control mb-2"
                                            placeholder="Nhập tên thành phố">
                                        <button class="btn btn-primary btn-sm w-100" onclick="updateWeather()">Cập nhật
                                            thành phố</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <a href="{{ url('/') }}" class="logo-brand d-block text-center">
                    <img src="{{ asset('images/logo24news.png') }}" alt="logo" class="img-fluid" style="max-width: 150px;">
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-12">
                <div class="sub-darkLight">
                    <div class="row text-center text-lg-end align-items-center">
                        <div class="col-6 d-none d-lg-block">
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="darkLight-btn d-flex justify-content-center justify-content-lg-end">
                                <span class="icon active" id="light-icon">
                                    <i class="la la-sun"></i>
                                </span>
                                <span class="icon" id="dark-icon">
                                    <i class="la la-moon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightIcon = document.getElementById('light-icon');
        const darkIcon = document.getElementById('dark-icon');
        const body = document.body;

        // Kiểm tra trạng thái đã lưu trong localStorage
        const savedTheme = localStorage.getItem('theme');

        // Áp dụng theme từ localStorage nếu có
        if (savedTheme === 'dark') {
            lightIcon.classList.remove('active');
            darkIcon.classList.add('active');
            body.classList.add('dark-theme');
        } else {
            lightIcon.classList.add('active');
            darkIcon.classList.remove('active');
            body.classList.remove('dark-theme');
        }

        // Xử lý sự kiện khi click vào icon light mode
        lightIcon.addEventListener('click', function() {
            lightIcon.classList.add('active');
            darkIcon.classList.remove('active');
            body.classList.remove('dark-theme');
            localStorage.setItem('theme', 'light');
        });

        // Xử lý sự kiện khi click vào icon dark mode
        darkIcon.addEventListener('click', function() {
            darkIcon.classList.add('active');
            lightIcon.classList.remove('active');
            body.classList.add('dark-theme');
            localStorage.setItem('theme', 'dark');
        });
    });
</script>

<div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel" style="width: 100%;">
    <div class="offcanvas-header">
        <div class="col-lg-4 col-12">
            <a href="{{ url('/') }}" class="logo-brand d-block text-center">
                <img src="{{ asset('images/logo24news.png') }}" alt="logo" class="img-fluid" style="max-width: 100px;">
            </a>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h6 class="text-uppercase mb-4">Tất cả chuyên mục</h6>
        <div class="row">
            <!-- Danh mục chính hiển thị động -->
            <div class="col-lg-9 col-12">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-4">
                    @foreach ($parentCategories as $category)
                        <div class="col">
                            <h5 class="fw-bold" style="color: #a10034;">
                                <a href="{{ route('client.category.show', $category->slug) }}" class="text-decoration-none hover-underline" style="color: #a10034;">
                                    {{ $category->name }}
                                </a>
                            </h5>
                            @if($category->children->isNotEmpty())
                                <ul class="list-unstyled py-3">
                                    @foreach ($category->children as $child)
                                        <li>
                                            <a href="{{ route('client.category.show', $child->slug) }}" class="mb-3">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Phần liên hệ -->
            <div class="col-lg-3 col-12 mt-4 mt-lg-0">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold">
                    Giới Thiệu 24News <i class="la la-angle-right ms-1"></i>
                </h6>
                <div class="text mb-4">
                    24News là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật 24/7.
                    Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
                </div>
                <div class="mt-4">
                    <h6 class="color-000 mb-3 fw-bold">Tại sao chọn 24News?</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-newspaper-o text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Tin tức chính xác, đa chiều</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-bolt text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cập nhật tin tức 24/7</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-users text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cộng đồng độc giả lớn mạnh</p>
                        </div>
                    </div>
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold">
                        Liên Hệ & Theo Dõi <i class="la la-angle-right ms-1"></i>
                    </h6>
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="#">bayanhtai@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="#">0981 725 836</a>
                        </li>
                    </ul>
                    <div class="social-links mt-3 d-flex justify-content-center justify-content-lg-start">
                        <a href="#" class="me-2">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

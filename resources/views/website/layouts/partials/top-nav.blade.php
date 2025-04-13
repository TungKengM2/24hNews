<style>
    /* Cho phép cuộn dọc nếu có nhiều hơn 4 danh mục */
    .sidebar-categories {
        max-height: 500px;
        /* Giới hạn chiều cao của danh sách danh mục */
        overflow-y: auto;
        /* Cho phép cuộn dọc */
    }
</style>

<div class="top-navbar style-1">
    <div class="container p-0">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="date-weather mb-3 mb-lg-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="item">
                                <div class="icon me-3 pt-1">
                                    <i class="la la-calendar"></i>
                                </div>
                                <div class="inf">
                                    <div id="dateElement"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item position-relative">
                                <div class="icon me-3 pt-1">
                                    <img id="weather-icon" alt="Biểu tượng thời tiết">
                                </div>
                                <div class="inf">
                                    <strong>
                                        <p id="weather-temperature"></p>
                                        <p id="weather-description"></p>
                                    </strong>
                                    <p id="weather-city"></p>
                                </div>
                                <div class="weather-form position-absolute bg-white p-3 rounded shadow"
                                    style="display: none; top: 100%; left: 0; z-index: 1000; min-width: 250px;">
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
            <div class="col-lg-4">
                <a href="{{ url('/') }}" class="logo-brand d-none d-lg-block">
                    <h1>News24h</h1>
                </a>
            </div>
            <div class="col-lg-4">
                <div class="sub-darkLight">
                    <div class="row text-end align-items-center">
                        <div class="col-6">
                            <a href="home-default.html#0"
                                class="text-uppercase fs-6 border-bottom border-1 border-dark subs">
                                <i class="la la-envelope fs-5 me-1"></i>
                                Đăng ký
                            </a>
                        </div>
                        <div class="col-6">
                            <div class="darkLight-btn">
                                <span class="icon active" id="light-icon">
                                    <i class="la la-sun"></i>
                                </span>
                                <span class="icon" id="dark-icon">
                                    <i class="la la-moon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="nav-subs-card">
                        <p class="fsz-16px text-uppercase mb-20">Bản tin</p>
                        <div class="sub-form">
                            <div class="form-group">
                                <span class="icon">
                                    <i class="la la-envelope"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Nhập email của bạn">
                                <button>Đăng ký</button>
                            </div>
                            <p class="mt-3 color-666 fsz-12px fst-italic">Bằng cách đăng ký, bạn đã chấp nhận <a
                                    href="home-default.html#0"
                                    class="color-777 text-decoration-underline fst-normal">Chính sách</a></p>
                        </div>
                        <span class="cls"><i class="la la-times"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="logo">
            <h1>News24h</h1>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mt-[-20px]">


        <div class="sidebar-categories mt-40">
            <h6 class="color-000 text-uppercase mb-30 ltspc-1"> Tất Cả Danh Mục <i class="la la-angle-right ms-1"></i>
            </h6>

            @foreach ($category2 as $category)
                <a href="{{ route('client.category.show', $category->slug) }}" class="cat-card">
                    <div class="img img-cover ">

                        <div class="info">
                            <h5 href="{{ route('client.category.show', $category->slug) }}">
                                {{ $category->name }}
                            </h5>
                            <span class="num">{{ $category->articles_count }}</span>
                        </div>
                    </div>
                </a>
            @endforeach


        </div>
        <div class="offcanvas-body mt-4">
            <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold"> Giới Thiệu News24h <i
                    class="la la-angle-right ms-1"></i>
            </h6>
            <div class="text mb-4">
                News24h là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật 24/7.
                Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
            </div>

            <div class="mt-4">
                <h6 class="color-000 mb-3 fw-bold">Tại sao chọn News24h?</h6>
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
            </div>

            <div class="sidebar-contact-info mt-4 pt-4 border-top">
                <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold"> Liên Hệ & Theo Dõi <i
                        class="la la-angle-right ms-1"></i> </h6>
                <ul class="m-0">
                    <li class="mb-3">
                        <i class="las la-map-marker me-2 color-main fs-5"></i>
                        <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ
                            Liêm, Hà Nội</a>
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
                <div class="social-links mt-3">
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
</div> --}}

<div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel" style="width: 100%;">
    <div class="offcanvas-header">
        <div class="col-lg-4">
            <a href="{{ url('/') }}" class="logo-brand d-none d-lg-block">
                <h1>News24h</h1>
            </a>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h6 class="text-uppercase mb-4">Tất cả chuyên mục</h6>
        <div class="row ">
            <!-- Danh mục chính -->
            <div class="col-lg-9">
                <div class="row row-cols-6 g-4">
                    <!-- Danh mục 1 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Thời sự</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Chính trị</a></li>
                            <li><a href="#" class="mb-3">Nhân sự</a></li>
                            <li><a href="#" class="mb-3">Kỷ nguyên mới</a></li>
                            <li><a href="#" class="mb-3">Dân sinh</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 2 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Thế giới</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Tư liệu</a></li>
                            <li><a href="#" class="mb-3">Phân tích</a></li>
                            <li><a href="#" class="mb-3">Người Việt 5 châu</a></li>
                            <li><a href="#" class="mb-3">Cuộc sống đó đây</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 3 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Kinh doanh</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">NetZero</a></li>
                            <li><a href="#" class="mb-3">Quốc tế</a></li>
                            <li><a href="#" class="mb-3">Doanh nghiệp</a></li>
                            <li><a href="#" class="mb-3">Chứng khoán</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 4 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Công nghệ</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">AI</a></li>
                            <li><a href="#" class="mb-3">Chuyển đổi số</a></li>
                            <li><a href="#" class="mb-3">Nhịp sống số</a></li>
                            <li><a href="#" class="mb-3">Thiết bị</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 5 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Khoa học</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Tin tức</a></li>
                            <li><a href="#" class="mb-3">Đổi mới sáng tạo</a></li>
                            <li><a href="#" class="mb-3">Bàn tròn</a></li>
                            <li><a href="#" class="mb-3">Nhân vật</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 6 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Giải trí</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Giới sao</a></li>
                            <li><a href="#" class="mb-3">Sách</a></li>
                            <li><a href="#" class="mb-3">Video</a></li>
                            <li><a href="#" class="mb-3">Phim</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 7 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Thể thao</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Bóng đá</a></li>
                            <li><a href="#" class="mb-3">Lịch thi đấu</a></li>
                            <li><a href="#" class="mb-3">Marathon</a></li>
                            <li><a href="#" class="mb-3">Tennis</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 8 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Podcasts</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">VnExpress hôm nay</a></li>
                            <li><a href="#" class="mb-3">Tâm điểm kinh tế</a></li>
                            <li><a href="#" class="mb-3">Tài chính cá nhân</a></li>
                            <li><a href="#" class="mb-3">Giải mã</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 9 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Góc nhìn</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Bình luận nhiều</a></li>
                            <li><a href="#" class="mb-3">Chính trị & chính sách</a></li>
                            <li><a href="#" class="mb-3">Y tế & sức khỏe</a></li>
                            <li><a href="#" class="mb-3">Kinh doanh & quản trị</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 10 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Bất động sản</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Chính sách</a></li>
                            <li><a href="#" class="mb-3">Thị trường</a></li>
                            <li><a href="#" class="mb-3">Dự án</a></li>
                            <li><a href="#" class="mb-3">Không gian sống</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 11 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Du lịch</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Điểm đến</a></li>
                            <li><a href="#" class="mb-3">Ẩm thực</a></li>
                            <li><a href="#" class="mb-3">Dấu chân</a></li>
                            <li><a href="#" class="mb-3">Tư vấn</a></li>
                        </ul>
                    </div>
                    <!-- Danh mục 12 -->
                    <div class="col">
                        <h5 class="fw-bold" style="color: #a10034;">
                            <a href="#" class="text-decoration-none hover-underline" style="color: #a10034;">Pháp luật</a>
                        </h5>
                        <ul class="list-unstyled py-3">
                            <li><a href="#" class="mb-3">Hồ sơ phá án</a></li>
                            <li><a href="#" class="mb-3">Tư vấn</a></li>
                            <li><a href="#" class="mb-3">Video</a></li>
                            <li><a href="#" class="mb-3">Tin tức</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Phần liên hệ -->
            <div class="col-lg-3">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold"> Giới Thiệu News24h <i
                        class="la la-angle-right ms-1"></i>
                </h6>
                <div class="text mb-4">
                    News24h là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật
                    24/7.
                    Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
                </div>
                <div class="mt-4">
                    <h6 class="color-000 mb-3 fw-bold">Tại sao chọn News24h?</h6>
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
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold"> Liên Hệ & Theo Dõi <i
                            class="la la-angle-right ms-1"></i> </h6>
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam
                                Từ
                                Liêm, Hà Nội</a>
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
                    <div class="social-links mt-3">
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

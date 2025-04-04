<style>
    /* Cho phép cuộn dọc nếu có nhiều hơn 4 danh mục */
.sidebar-categories {
    max-height: 500px; /* Giới hạn chiều cao của danh sách danh mục */
    overflow-y: auto;  /* Cho phép cuộn dọc */
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
                                    <strong><p id="weather-temperature"></p><p id="weather-description"></p></strong>
                                    <p id="weather-city"></p>
                                </div>
                                <div class="weather-form position-absolute bg-white p-3 rounded shadow" style="display: none; top: 100%; left: 0; z-index: 1000; min-width: 250px;">
                                    <div class="form-group">
                                        <input type="text" id="cityInput" class="form-control mb-2" placeholder="Nhập tên thành phố">
                                        <button class="btn btn-primary btn-sm w-100" onclick="updateWeather()">Cập nhật thành phố</button>
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
                            <a href="home-default.html#0" class="text-uppercase fs-6 border-bottom border-1 border-dark subs">
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
                            <p class="mt-3 color-666 fsz-12px fst-italic">Bằng cách đăng ký, bạn đã chấp nhận <a href="home-default.html#0" class="color-777 text-decoration-underline fst-normal">Chính sách</a></p>
                        </div>
                        <span class="cls"><i class="la la-times"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
aria-labelledby="offcanvasExampleLabel">
<div class="offcanvas-header">
    <div class="logo">
        <h1>News24h</h1>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
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
</div>

<div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <div class="col-lg-4">
            <a href="{{ url('/') }}" class="logo-brand d-none d-lg-block">
                <h1>News24h</h1>
            </a>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mt-4">

        <h6 class="color-000 text-uppercase mb-30 ltspc-1">Danh mục <i class="la la-angle-right ms-1"></i></h6>
        <div class="sidebar-categories mt-40">
            

            @foreach ($category2 as $category)
                <a href="{{ route('client.category.show', $category->slug) }}" class="cat-card">
                    <div class="img img-cover ">
                        <div class="info">
                            <h5 href="{{ route('client.category.show', $category->slug) }}">
                                {{ $category->name }}
                            </h5>
                            <span class="num">{{ $category->articles_count ?? 0 }}</span> <!-- Số thứ tự danh mục -->
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="sidebar-contact-info mt-50">
            <h6 class="color-000 text-uppercase mb-20 ltspc-1">Liên hệ & theo dõi <i class="la la-angle-right ms-1"></i></h6>
            <ul class="m-0">
                <li class="mb-3">
                    <i class="las la-map-marker me-2 color-main fs-5"></i>
                    <a href="home-default.html#">Địa chỉ: FPT POLYTECHNIC Hà Nội</a>
                </li>
                <li class="mb-3">
                    <i class="las la-envelope me-2 color-main fs-5"></i>
                    <a href="home-default.html#">support@24News.com</a>
                </li>
                <li class="mb-3">
                    <i class="las la-phone-volume me-2 color-main fs-5"></i>
                    <a href="home-default.html#">(+051) 3235 68 69</a>
                </li>
            </ul>
            
            <div class="social-links">
                <a href="home-default.html#">
                    <i class="la la-twitter"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-facebook-f"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-instagram"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-youtube"></i>
                </a>
                <a href="home-default.html#">
                    <i class="la la-spotify"></i>
                </a>
            </div>
        </div>
    </div>
</div>

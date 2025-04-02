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
                                    <img id="weather-icon" alt="Weather Icon">
                                </div>
                                <div class="inf">
                                    <strong><p id="weather-temperature"></p><p id="weather-description"></p></strong>
                                    <p id="weather-city"></p>
                                </div>
                                <div class="weather-form position-absolute bg-white p-3 rounded shadow" style="display: none; top: 100%; left: 0; z-index: 1000; min-width: 250px;">
                                    <div class="form-group">
                                        <input type="text" id="cityInput" class="form-control mb-2" placeholder="Nhập Tên Thành Phố ">
                                        <button class="btn btn-primary btn-sm w-100" onclick="updateWeather()">Cập Nhật Thành Phố </button>
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
                             Đăng Ký
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
                        <p class="fsz-16px text-uppercase mb-20"> Bản tin </p>
                        <div class="sub-form">
                            <div class="form-group">
                                <span class="icon">
                                    <i class="la la-envelope"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Nhập email của bạn">
                                <button>đăng ký </button>
                            </div>
                            <p class="mt-3 color-666 fsz-12px fst-italic">Bằng cách đăng ký, bạn đã chấp nhận
                                của chúng tôi <a href="home-default.html#0"
                                       class="color-777 text-decoration-underline fst-normal">Chính sách</a></p>
                        </div>
                        <span class="cls"> <i class="la la-times"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
aria-labelledby="offcanvasExampleLabel">
<div class="offcanvas-header">
    <div class="logo">
        <img src="client/assets/img/logo_home1.png" alt="" class="dark-none">
        <img src="client/assets/img/logo_home1_lt.png" alt="" class="light-none">
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
</div>
<div class="offcanvas-body mt-4">
    <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i>
    </h6>
    <div class="text">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae.
        Soluta corporis quidem aperiam amet nihil.
    </div>

    <div class="sidebar-categories mt-40">
        <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i>
        </h6>

        @foreach ($category2 as $category)
            <a href="{{ route('client.category.show', $category->slug) }}" class="cat-card">
                <div class="img img-cover ">

                    <div class="info">
                        <h5 href="{{ route('client.category.show', $category->slug) }}">
                            {{ $category->name }}
                        </h5>
                        <span class="num">{{ $loop->iteration }}</span> <!-- Số thứ tự danh mục -->
                    </div>
                </div>
            </a>
        @endforeach


    </div>
    <div class="sidebar-contact-info mt-50">
        <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i
                class="la la-angle-right ms-1"></i></h6>
        <ul class="m-0">
            <li class="mb-3">
                <i class="las la-map-marker me-2 color-main fs-5"></i>
                <a href="home-default.html#">streat name 12, hollywood City, USA</a>
            </li>
            <li class="mb-3">
                <i class="las la-envelope me-2 color-main fs-5"></i>
                <a href="home-default.html#">Newzin@gmail.com</a>
            </li>
            <li class="mb-3">
                <i class="las la-phone-volume me-2 color-main fs-5"></i>
                <a href="home-default.html#">+12 123 456 789</a>
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
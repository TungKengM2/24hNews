<style>
.nav-scroll-container {
    width: 100%;
    overflow-x: auto;
    white-space: nowrap;
}

.navbar-nav {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Ẩn thanh cuộn trên Chrome, Safari */
.navbar-nav::-webkit-scrollbar {
    display: none;
}

/* Hiển thị thanh cuộn tùy chỉnh trên Firefox */
.navbar-nav {
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.2) transparent;
}
.active-home i {
    color: rgb(249, 60, 50) !important;
}

</style>
<div class="navbar-container">
        <div class="container">
            <!-- ====== start top navbar ====== -->
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
                                                <strong>Monday</strong>
                                                <p>Nov 25, 2023</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="item">
                                            <div class="icon me-3 pt-1">
                                                <i class="la la-cloud-sun"></i>
                                            </div>
                                            <div class="inf">
                                                <strong>32° deg, Cloudy</strong>
                                                <p>New York</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <a href="home-default.html#" class="logo-brand d-none d-lg-block">
                                <img src="{{ asset('client/img/logo_home1.png') }}" alt="" class="dark-none">
                                <img src="{{ asset('client/img/logo_home1_lt.png') }}" alt="" class="light-none">
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <div class="sub-darkLight">
                                <div class="row text-end align-items-center">
                                    <div class="col-6">
                                        <a href="home-default.html#0"
                                            class="text-uppercase fs-6 border-bottom border-1 border-dark subs">
                                            <i class="la la-envelope fs-5 me-1"></i>
                                            Subscribe
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
                                    <p class="fsz-16px text-uppercase mb-20"> Newsletter </p>
                                    <div class="sub-form">
                                        <div class="form-group">
                                            <span class="icon">
                                                <i class="la la-envelope"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="your email">
                                            <button>subscribe</button>
                                        </div>
                                        <p class="mt-3 color-666 fsz-12px fst-italic">By subscribing, you accepted the
                                            our <a href="home-default.html#0"
                                                class="color-777 text-decoration-underline fst-normal">Policy</a></p>
                                    </div>
                                    <span class="cls"> <i class="la la-times"></i> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ====== end top navbar ====== -->

            <!-- ====== start navbar ====== -->
            <nav class="navbar navbar-expand-lg navbar-light style-1">
                <div class="container p-0">
                    <div class="mob-nav-toggles d-flex align-items-center justify-content-between">
                        <button class="navbarList-icon me-lg-5" data-bs-toggle="offcanvas" href="#offcanvasExample"
                            role="button" aria-controls="offcanvasExample">
                            <span></span>
                            <span></span>
                        </button>
                        <a href="home-default.html#" class="logo-brand d-block d-lg-none w-50 my-4">
                            <img src="{{ asset('client/img/logo_home1.png') }}" alt="" class="dark-none">
                            <img src="{{ asset('client/img/logo_home1_lt.png') }}" alt="" class="light-none">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="nav-scroll-container">
                            <ul class="navbar-nav d-flex flex-row flex-nowrap overflow-auto">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('/') ? 'active-home' : '' }}" href="{{ url('/') }}">
                                        <i class="la la-home fs-4"></i>
                                    </a>
                                </li>
                                
            
                                @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('client.category.show', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                            
                            </ul>
                        </div>
                        
                        <div class="nav-side">
                            <a href="home-default.html#" class="icon-link search-btn-style1">
                                <i class="la la-search fs-4 sOpen-btn"></i>
                                <i class="la la-close fs-4 sClose-btn"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>


            <!-- ====== start nav-search ====== -->
            <div class="nav-search-style1">
                <div class="row justify-content-center align-items-center gx-lg-5">
                    <div class="col-lg-4">
                        <div class="info">
                            <h5> you can search by category <br> or news title </h5>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form class="form">
                            <span class="color-777 fst-italic text-capitalize mb-2 fsz-13px">Enter Keyword</span>
                            <div class="form-group">
                                <span class="icon">
                                    <i class="la la-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Elon Musk ... ">
                                <button type="submit">search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ====== end nav-search ====== -->
        </div>
    </div>
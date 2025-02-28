<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
    <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
    <meta name="author" content="" />

    <!-- Title  -->
    <title>News24h</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('client/img/fav.png') }}" title="Favicon" sizes="16x16" />

   @include('website.layouts.partials.css')
    <title> News24h </title>
</head>

<body class="home-style1">

    <!-- ====== start loading page ====== -->
    @include('website.layouts.partials.loadingpage')
    <!-- ====== end loading page ====== -->

    <!-- ====== start navbar-container ====== -->
    <div class="navbar-container">
        <div class="container">
            <!-- ====== start top navbar ====== -->
           @include('website.layouts.partials.top-nav')
            <!-- ====== end top navbar ====== -->
    
            <!-- ====== start navbar ====== -->
            @include('website.layouts.partials.start-nav')
            <!-- ====== end navbar ====== -->
    
            <!-- ====== start nav-search ====== -->
            @include('website.layouts.partials.nav-search')
            <!-- ====== end nav-search ====== -->
        </div>
    </div>
    <!-- ====== start navbar-container ====== -->

    <!--Contents-->
    @yield('content')
    <!--End-Contents-->

    <!-- ====== start footer ====== -->
    <footer class="footer-style1">
        <div class="container">
            {{-- footer email --}}
            @include('website.layouts.partials.footer-email')
            {{-- footer main --}}
            @include('website.layouts.partials.footer-main')
            {{-- footer end --}}
            @include('website.layouts.partials.footer-end')
        </div>
        <!-- ====== start to top button ====== -->
       @include('website.layouts.partials.to-top')
        <!-- ====== end to top button ====== -->
    </footer>
    <!-- ====== end footer ====== -->

    <!-- ====== start to top button ====== -->
    <!-- <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 220.587;"></path></svg>
    </div> -->
    <!-- ====== end to top button ====== -->

    <!-- ====== request ====== -->
    @include('website.layouts.partials.js')

</body>

</html>
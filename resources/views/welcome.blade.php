<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
    <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
    <meta name="author" content="" />

    <!-- Title  -->
    <title>Newzin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('client/img/fav.png') }}" title="Favicon" sizes="16x16" />

    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/bootstrap.min.css') }}">

    <!-- font family -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- ionicons icons  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/ionicons.css') }}">
    <!-- line-awesome icons  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/line-awesome.css') }}">
    <!-- animate css  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/animate.css') }}" />
    <!-- fancybox popup  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/jquery.fancybox.css') }}" />
    <!-- lity popup  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/lity.css') }}" />
    <!-- swiper slider  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/swiper.min.css') }}" />

    <!-- ====== main style ====== -->
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}" />
    <title> Newzin </title>
</head>

<body class="home-style10">

    <!-- ====== start loading page ====== -->

    @include('website.layouts.partials.loadingpage')
    <!-- ====== end loading page ====== -->

    <!-- ====== start nav-search ====== -->
    @include('website.layouts.partials.navsearch')
    <!-- ====== end nav-search ====== -->

    <!-- ====== start header ====== -->
    @include('website.layouts.partials.header')
    <!-- ====== end header ====== -->

    <!--Contents-->
   <div class="main">
        @include('website.layouts.partials.main')
   </div>
    <!--End-Contents-->

    <!-- ====== start footer ====== -->
    @include('website.layouts.partials.footer')
    <!-- ====== end footer ====== -->

    <!-- ====== start to top button ====== -->
    <!-- <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 220.587;"></path></svg>
    </div> -->
    <!-- ====== end to top button ====== -->

    <!-- ====== request ====== -->
    <script src="{{ asset('client/js/lib/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/wow.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('client/js/lib/lity.js') }}"></script>
    <script src="{{ asset('client/js/lib/swiper.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.counterup.js') }}"></script>
    <!-- <script src="client/js/lib/pace.js"></script> -->
    <script src="{{ asset('client/js/lib/back-to-top.js') }}"></script>
    <script src="{{ asset('client/js/lib/parallaxie.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>

    <script>
        // const TweenMax = window.TweenMax;
        // const cursor = document.querySelector(".cursor"),
        // follower = document.querySelector(".follow");
        // let posX = 0,
        // posY = 0;
        // let mouseX = 0,
        // mouseY = 0;
        // TweenMax.to({}, 0.016, {
        // repeat: -1,
        // onRepeat: function () {
        //     posX += (mouseX - posX) / 9;
        //     posY += (mouseY - posY) / 9;

        //     TweenMax.set(follower, {
        //     css: {
        //         left: posX - 37,
        //         top: posY - 37
        //     }
        //     });
        //     TweenMax.set(cursor, {
        //     css: {
        //         left: mouseX,
        //         top: mouseY
        //     }
        //     });
        // }
        // });
        document.onmousemove = function (e) {
        mouseX = e.pageX;
        mouseY = e.pageY;
        document.body.style.setProperty("--x", e.clientX + "px");
        document.body.style.setProperty("--y", e.clientY + "px");
        };
    </script>


</body>

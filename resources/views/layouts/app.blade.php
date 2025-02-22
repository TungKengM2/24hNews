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
    <link rel="shortcut icon" href="https://newzin-html.themescamp.com/assets/img/fav.png" title="Favicon" sizes="16x16" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/lib/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/line-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lib/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lib/jquery.fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lib/lity.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lib/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="home-style10">
    @include('website.partials.loading-page')
    @include('website.partials.nav-search')
    @include('website.layouts.header')
    
    <main>
        @yield('content')
    </main>

    @include('website.layouts.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/lib/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/lib/wow.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('js/lib/lity.js') }}"></script>
    <script src="{{ asset('js/lib/swiper.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/lib/jquery.counterup.js') }}"></script>
    <script src="{{ asset('js/lib/back-to-top.js') }}"></script>
    <script src="{{ asset('js/lib/parallaxie.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
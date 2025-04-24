<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {{-- <link rel="icon" href="/admin/main/../images/favicon.ico"> --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo24news.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo24news.png') }}?v={{ time() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('author.layouts.partials.css')

    <style>
        /* Add this CSS rule to control the loader speed */
        #loader {
            transition: opacity 0.3s ease; /* Adjusts the opacity transition duration */
        }
    </style>

</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

<div class="wrapper">
    <div id="loader"></div>

    <header class="main-header">
        @include('author.layouts.partials.header-logo')
        <!-- Header Navbar -->
        @include('author.layouts.partials.header-top')
    </header>

    <aside class="main-sidebar">
        @include('author.layouts.partials.aside-user-profile')
        <!-- sidebar-->
        @include('author.layouts.partials.aside-sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->

    @yield('content')

    <!-- /.content-wrapper -->

    @include('author.layouts.partials.footer')

    @include('author.layouts.partials.control-sidebar')

    <div class="control-sidebar-bg"></div>

</div>

@include('author.layouts.partials.js')

@yield('scripts')

</body>

</html>

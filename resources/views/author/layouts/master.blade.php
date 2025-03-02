<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/admin/main/../images/favicon.ico">

    <title>@yield('title')</title>

    @include('author.layouts.partials.css')

</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

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


    <div class="control-sidebar-bg"></div>

</div>

@include('author.layouts.partials.js')

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>@yield('title')</title>

    <!-- Vendors Style -->
    @include('author.layouts.partials.css')
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>
        <header class="main-header">
            {{-- logo --}}
          @include('author.layouts.partials.logo-header')
            <!-- Header Navbar -->
            @include('author.layouts.partials.navbar-header')
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            {{-- user profile --}}
          @include('author.layouts.partials.user-profile')
            <!-- sidebar-->
           @include('author.layouts.partials.sidebar')
        </aside>
        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        @include('author.layouts.partials.footer')

        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- Vendor JS -->
   @include('author.layouts.partials.js')
</body>

</html>

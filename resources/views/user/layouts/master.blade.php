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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>@yield('title')</title>

    @include('user.layouts.partials.css')

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
            {{-- @include('user.layouts.partials.header-logo')
            <!-- Header Navbar -->
            @include('user.layouts.partials.header-top') --}}
        </header>

        <aside class="main-sidebar">
            {{-- <!-- sidebar-->
            @include('user.layouts.partials.aside-sidebar') --}}
        </aside>

        

        @yield('content')

       
        <div class="control-sidebar-bg"></div>

    </div>
 
    @include('user.layouts.partials.js')

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<<<<<<< HEAD:resources/views/admin/layouts/dashboard.blade.php
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
=======
    <style>

    </style>
>>>>>>> 941a6101d9d4141920aeac018608817cd3b3abdd:resources/views/admin/dashboard.blade.php
</head>
<body>
    <div class="wrapper">
<<<<<<< HEAD:resources/views/admin/layouts/dashboard.blade.php
=======
        @include('admin.menu')
        {{-- @include('admin.articles.index') --}}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('expand');
        });
    </script>  -->
</body>
>>>>>>> 941a6101d9d4141920aeac018608817cd3b3abdd:resources/views/admin/dashboard.blade.php

            @include('admin.layouts.partials.menusidebar')

            <div class="main">
                @include('admin.layouts.partials.header')

        @include('admin.layouts.partials.sidebar')
            </div>
    </div>
    <div>
        @include('admin.layouts.partials.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

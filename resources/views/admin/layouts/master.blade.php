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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>@yield('title')</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @include('admin.layouts.partials.css')

    <style>
        /* Add this CSS rule to control the loader speed */
        #loader {
            transition: opacity 0.3s ease; /* Adjusts the opacity transition duration */
        }
    </style>
   

</head>
{{-- dat them --}}
<body class="hold-transition light-skin sidebar-mini theme-primary fixed" id="admin-body">

    <div class="wrapper">
        <div id="loader"></div>

        <header class="main-header">
            @include('admin.layouts.partials.header-logo')
            <!-- Header Navbar -->
            @include('admin.layouts.partials.header-top')
        </header>

        <aside class="main-sidebar">
            @include('admin.layouts.partials.aside-user-profile')
            <!-- sidebar-->
            @include('admin.layouts.partials.aside-sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        @include('admin.layouts.partials.footer')

        <!-- Control Sidebar -->
        @include('admin.layouts.partials.control-sidebar')
        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Bootstrap 4 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Vendor JS -->
    @include('admin.layouts.partials.js')

    <!-- Flash Messages with SweetAlert2 -->
    @include('admin.layouts.partials.flash-messages')
{{-- dat them --}}
    <!-- Theme Persistence Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if dark-skin preference is stored in localStorage
            const darkModePreference = localStorage.getItem('admin-dark-mode');
            const body = document.getElementById('admin-body');

            // Apply dark-skin if preference exists
            if (darkModePreference === 'true') {
                body.classList.remove('light-skin');
                body.classList.add('dark-skin');

                // Update the toggle switch state if it exists
                const toggleSwitch = document.getElementById('toggle_left_sidebar_skin');
                if (toggleSwitch) {
                    toggleSwitch.checked = true;
                }
            }

            // Listen for changes to the dark mode toggle
            document.addEventListener('click', function(e) {
                if (e.target && e.target.getAttribute('data-mainsidebarskin') === 'toggle') {
                    // Store the preference when toggle is clicked
                    if (body.classList.contains('dark-skin')) {
                        localStorage.setItem('admin-dark-mode', 'true');
                    } else {
                        localStorage.setItem('admin-dark-mode', 'false');
                    }
                }
            });
        });
    </script>
    @yield('styles')
    @yield('scripts')

</body>

</html>

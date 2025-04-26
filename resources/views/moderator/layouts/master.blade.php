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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>@yield('title')</title>

    @include('moderator.layouts.partials.css')

    {{-- <style>
        /* Add this CSS rule to control the loader speed */
        #loader {
            transition: opacity 0.3s ease; /* Adjusts the opacity transition duration */
        }

        .user-panel .image {
            width: 128px;
            height: 128px;
            border: 3px solid #fff;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 0 auto;
        }

        .user-panel .image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .user-panel .info {
            text-align: center;
            margin-top: 10px;
        }

        .user-panel .info p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        /* Style cho phần preview ảnh khi upload */
        .widget-user-image {
            position: relative;
            width: 128px;
            height: 128px;
            margin: -64px auto 0;
            border: 3px solid #fff;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .widget-user-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            padding: 0;
            margin: 0;
        }

        #avatarPreview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            padding: 0;
            margin: 0;
        }

        /* Style cho input file */
        #avatarUpload {
            display: none;
        }

        .profile-pic {
            width: 128px;
            height: 128px;
            border: 3px solid #fff;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 0 auto;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            padding: 0;
            margin: 0;
        }

        .profile-info {
            text-align: center;
            margin-top: 10px;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
    </style> --}}
    <style>
        /* Add this CSS rule to control the loader speed */
        #loader {
            transition: opacity 0.3s ease; /* Adjusts the opacity transition duration */
        }
    </style>

</head>
{{-- dat them --}}
<body class="hold-transition light-skin sidebar-mini theme-primary fixed" id="moderator-body">

    <div class="wrapper">
        <div id="loader"></div>

        <header class="main-header">
            @include('moderator.layouts.partials.header-logo')
            <!-- Header Navbar -->
            @include('moderator.layouts.partials.header-top')
        </header>

        <aside class="main-sidebar">
            @include('moderator.layouts.partials.aside-user-profile')
            <!-- sidebar-->
            @include('moderator.layouts.partials.aside-sidebar')
        </aside>

        <!-- Content Wrapper. Contains page content -->

        @yield('content')

        <!-- /.content-wrapper -->

        @include('moderator.layouts.partials.footer')

        <!-- Control Sidebar -->
        @include('moderator.layouts.partials.control-sidebar')
        <!-- /.control-sidebar -->

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>



    <!-- Vendor JS -->
    @include('moderator.layouts.partials.js')

    @yield('styles')
    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarUpload = document.getElementById('avatarUpload');
            const avatarPreview = document.getElementById('avatarPreview');

            if (avatarUpload && avatarPreview) {
                avatarUpload.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
{{-- dat them --}}
    <!-- Theme Persistence Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if dark-skin preference is stored in localStorage
            const darkModePreference = localStorage.getItem('moderator-dark-mode');
            const body = document.getElementById('moderator-body');

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
                        localStorage.setItem('moderator-dark-mode', 'true');
                    } else {
                        localStorage.setItem('moderator-dark-mode', 'false');
                    }
                }
            });
        });
    </script>

</body>

</html>

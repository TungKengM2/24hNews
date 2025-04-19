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

    @include('moderator.layouts.partials.css')

    <style>
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
    <!-- ./wrapper -->

    <!-- ./side demo panel -->
    {{-- <div class="sticky-toolbar">
        <a href="index.html#" data-bs-toggle="tooltip" data-bs-placement="left" title="Buy Now"
            class="waves-effect waves-light btn btn-success btn-flat mb-5 btn-sm" target="_blank">
            <span class="icon-Money"><span class="path1"></span><span class="path2"></span></span>
        </a>
        <a href="https://themeforest.net/user/multipurposethemes/portfolio" data-bs-toggle="tooltip"
            data-bs-placement="left" title="Portfolio"
            class="waves-effect waves-light btn btn-danger btn-flat mb-5 btn-sm" target="_blank">
            <span class="icon-Image"></span>
        </a>
        <a id="chat-popup" href="index.html#" data-bs-toggle="tooltip" data-bs-placement="left" title="Live Chat"
            class="waves-effect waves-light btn btn-warning btn-flat btn-sm">
            <span class="icon-Group-chat"><span class="path1"></span><span class="path2"></span></span>
        </a>
    </div> --}}
    <!-- Sidebar -->

    {{-- <div id="chat-box-body">
        <div id="chat-circle" class="waves-effect waves-circle btn btn-circle btn-lg btn-warning l-h-70">
            <div id="chat-overlay"></div>
            <span class="icon-Group-chat fs-30"><span class="path1"></span><span class="path2"></span></span>
        </div>

        <div class="chat-box">
            <div class="chat-box-header p-15 d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <button
                        class="waves-effect waves-circle btn btn-circle btn-primary-light h-40 w-40 rounded-circle l-h-45"
                        type="button" data-bs-toggle="dropdown">
                        <span class="icon-Add-user fs-22"><span class="path1"></span><span
                                class="path2"></span></span>
                    </button>
                    <div class="dropdown-menu min-w-200">
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Color me-15"></span>
                            New Group</a>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Clipboard me-15"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span
                                    class="path4"></span></span>
                            Contacts</a>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Group me-15"><span class="path1"></span><span
                                    class="path2"></span></span>
                            Groups</a>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Active-call me-15"><span class="path1"></span><span
                                    class="path2"></span></span>
                            Calls</a>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Settings1 me-15"><span class="path1"></span><span
                                    class="path2"></span></span>
                            Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Question-circle me-15"><span class="path1"></span><span
                                    class="path2"></span></span>
                            Help</a>
                        <a class="dropdown-item fs-16" href="index.html#">
                            <span class="icon-Notifications me-15"><span class="path1"></span><span
                                    class="path2"></span></span>
                            Privacy</a>
                    </div>
                </div>
                <div class="text-center flex-grow-1">
                    <div class="text-dark fs-18">Mayra Sibley</div>
                    <div>
                        <span class="badge badge-sm badge-dot badge-primary"></span>
                        <span class="text-muted fs-12">Active</span>
                    </div>
                </div>
                <div class="chat-box-toggle">
                    <button id="chat-box-toggle"
                        class="waves-effect waves-circle btn btn-circle btn-danger-light h-40 w-40 rounded-circle l-h-45"
                        type="button">
                        <span class="icon-Close fs-22"><span class="path1"></span><span
                                class="path2"></span></span>
                    </button>
                </div>
            </div>
            <div class="chat-box-body">
                <div class="chat-box-overlay">
                </div>
                <div class="chat-logs">
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="/admin/main/../images/avatar/2.jpg" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="index.html#" class="text-dark hover-primary fw-bold">Mayra Sibley</a>
                                <p class="text-muted fs-12 mb-0">2 Hours</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Hi there, I'm Jesse and you?
                        </div>
                    </div>
                    <div class="chat-msg self">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="mx-10">
                                <a href="index.html#" class="text-dark hover-primary fw-bold">You</a>
                                <p class="text-muted fs-12 mb-0">3 minutes</p>
                            </div>
                            <span class="msg-avatar">
                                <img src="/admin/main/../images/avatar/3.jpg" class="avatar avatar-lg">
                            </span>
                        </div>
                        <div class="cm-msg-text">
                            My name is Anne Clarc.
                        </div>
                    </div>
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img src="/admin/main/../images/avatar/2.jpg" class="avatar avatar-lg">
                            </span>
                            <div class="mx-10">
                                <a href="index.html#" class="text-dark hover-primary fw-bold">Mayra Sibley</a>
                                <p class="text-muted fs-12 mb-0">40 seconds</p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Nice to meet you Anne.<br>How can i help you?
                        </div>
                    </div>
                </div><!--chat-log -->
            </div>
            <div class="chat-input">
                <form>
                    <input type="text" id="chat-input" placeholder="Send a message..." />
                    <button type="submit" class="chat-submit" id="chat-submit">
                        <span class="icon-Send fs-22"></span>
                    </button>
                </form>
            </div>
        </div>
    </div> --}}

    <!-- Page Content overlay -->


    <!-- Vendor JS -->
    @include('moderator.layouts.partials.js')

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

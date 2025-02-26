<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from demo.dashboardpack.com/sales-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 May 2024 07:23:13 GMT -->

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Create</title>


    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/themefy_icon/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/niceselect/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/owl_carousel/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/gijgo/gijgo.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/font_awesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/tagsinput/tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datepicker/date-picker.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/vectormap-home/vectormap-2.0.2.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/scroll/scrollable.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/responsive.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatable/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/text_editor/summernote-bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/morris/morris.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendors/material_icon/material-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/metisMenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/style1.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/colors/default.css') }}" id="colorSkinCSS">

</head>

<body class="crm_body_bg">

    // Sidebar
    @include('admin.layouts.partials.sidebar')
    // main
    <section class="main_content dashboard_part large_header_bg">

        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-lg-12 p-0 ">
                    <div class="header_iner d-flex justify-content-between align-items-center">
                        <div class="sidebar_icon d-lg-none">
                            <i class="ti-menu"></i>
                        </div>
                        <div class="serach_field-area d-flex align-items-center">
                            <div class="search_inner">
                                <form action="#">
                                    <div class="search_field">
                                        <input type="text" placeholder="Search here...">
                                    </div>
                                    <button type="submit"> <img src="img/icon/icon_search.svg" alt> </button>
                                </form>
                            </div>
                            <span class="f_s_14 f_w_400 ml_25 white_text text_white">Apps</span>
                        </div>
                        <div class="header_right d-flex justify-content-between align-items-center">
                            <div class="header_notification_warp d-flex align-items-center">
                                <li>
                                    <a class="bell_notification_clicker nav-link-notify" href="#"> <img
                                            src="img/icon/bell.svg" alt>
                                    </a>

                                    <div class="Menu_NOtification_Wrap">
                                        <div class="notification_Header">
                                            <h4>Notifications</h4>
                                        </div>
                                        <div class="Notification_body">

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/2.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>Cool Marketing </h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/4.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>Awesome packages</h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/3.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>what a packages</h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/2.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>Cool Marketing </h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/4.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>Awesome packages</h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>

                                            <div class="single_notify d-flex align-items-center">
                                                <div class="notify_thumb">
                                                    <a href="#"><img src="img/staf/3.png" alt></a>
                                                </div>
                                                <div class="notify_content">
                                                    <a href="#">
                                                        <h5>what a packages</h5>
                                                    </a>
                                                    <p>Lorem ipsum dolor sit amet</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nofity_footer">
                                            <div class="submit_button text-center pt_20">
                                                <a href="#" class="btn_1">See More</a>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                                <li>
                                    <a class="CHATBOX_open nav-link-notify" href="#"> <img src="img/icon/msg.svg" alt>
                                    </a>
                                </li>
                            </div>
                            <div class="profile_info">
                                <img src="img/client_img.png" alt="#">
                                <div class="profile_info_iner">
                                    <div class="profile_author_name">
                                        <p>Neurologist </p>
                                        <h5>Dr. Robar Smith</h5>
                                    </div>
                                    <div class="profile_info_details">
                                        <a href="#">My Profile </a>
                                        <a href="#">Settings</a>
                                        <a href="#">Log Out </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main_content_iner ">
            <div class="container-fluid p-0 sm_padding_15px">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Text</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2 mb-2">Usage <code>type="text"</code></h6>
                                <div class=" mb-0">
                                    <input type="text" class="form-control" name="inputText" id="inputText"
                                        placeholder="Text Input">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Email</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2 mb-2">Usage <code>type="email"</code></h6>
                                <div class=" mb-0">
                                    <input type="email" class="form-control" name="inputEmail" id="inputEmail"
                                        placeholder="name@example.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">Password</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="password"</code></h6>
                                <div class=" mb-0">
                                    <input type="password" class="form-control" name="inputPassword" id="inputPassword"
                                        placeholder="Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">number</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="number"</code></h6>
                                <div class=" mb-0">
                                    <input type="number" class="form-control" name="inputNumber" id="inputNumber"
                                        value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">search</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="search"</code></h6>
                                <div class=" mb-0">
                                    <input type="Search" class="form-control" name="inputSearch" id="inputSearch"
                                        placeholder="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">url</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="url"</code></h6>
                                <div class=" mb-0">
                                    <input type="url" class="form-control" name="inputUrl" id="inputUrl"
                                        placeholder="https://getbootstrap.com/">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">tel</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="tel"</code></h6>
                                <div class=" mb-0">
                                    <input type="tel" class="form-control" name="inputTel" id="inputTel"
                                        placeholder="+1 9876543210">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">file</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="file"</code></h6>
                                <div class=" mb-0">
                                    <input type="file" class id="exampleFormControlFile1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">datetime-local</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="datetime-local"</code></h6>
                                <div class=" mb-0">
                                    <input type="datetime-local" class="form-control" name="inputDateTime"
                                        id="inputDateTime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">date</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="date"</code></h6>
                                <div class=" mb-0">
                                    <input type="date" class="form-control" name="inputDate" id="inputDate">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">time</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="time"</code></h6>
                                <div class=" mb-0">
                                    <input type="time" class="form-control" name="inputTime" id="inputTime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="white_card card_height_100 mb_30">
                            <div class="white_card_header">
                                <div class="box_header m-0">
                                    <div class="main-title">
                                        <h3 class="m-0">week</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="white_card_body">
                                <h6 class="card-subtitle mb-2">Usage <code>type="week"</code></h6>
                                <div class=" mb-0">
                                    <input type="week" class="form-control" name="inputWeek" id="inputWeek">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer_part">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer_iner text-center">
                            <p>2020 © Influence - Designed by <a href="#"> <i class="ti-heart"></i> </a><a href="#">
                                    Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    // backtop
    @include('admin.layouts.partials.backtop')

    <script src="{{ asset('admin/js/jquery1-3.4.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/popper1.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/metisMenu.js') }}"></script>
    <script src="{{ asset('admin/vendors/count_up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/chartlist/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/count_up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{ asset('admin/vendors/datepicker/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin/vendors/datepicker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('admin/js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/chartjs/roundedBar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/progressbar/jquery.barfiller.js') }}"></script>
    <script src="{{ asset('admin/vendors/tagsinput/tagsinput.js') }}"></script>
    <script src="{{ asset('admin/vendors/text_editor/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/vendors/am_chart/amcharts.js') }}"></script>
    <script src="{{ asset('admin/vendors/scroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/scroll/scrollable-custom.js') }}"></script>
    <script src="{{ asset('admin/vendors/vectormap-home/vectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/vectormap-home/vectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/apex-chart2.js') }}"></script>
    <script src="{{ asset('admin/vendors/apex_chart/apex_dashboard.js') }}"></script>
    <script src="{{ asset('admin/vendors/echart/echarts.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart_am/core.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart_am/charts.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart_am/animated.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart_am/kelly.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart_am/chart-custom.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard_init.js') }}"></script>
    <script src="{{ asset('admin/js/custom.js') }}"></script>

</body>

<!-- Mirrored from demo.dashboardpack.com/sales-html/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 May 2024 07:24:00 GMT -->

</html>

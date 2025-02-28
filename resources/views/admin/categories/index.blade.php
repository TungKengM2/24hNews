<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>Danh Sách Danh Mục</title>

    <!-- Vendors Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <div id="loader"></div>

        @include('admin.layouts.partials.header')

        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.layouts.partials.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h4 class="page-title">Danh Sách Danh Mục</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                        <li class="breadcrumb-item active" aria-current="page">Danh Sách Danh Mục</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Main content -->
                <div class="container-full">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">

                                <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                        href="{{ route('admin.dashboard') }}">
                                        Back to Dashboard
                                    </a></button>
                                <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                        href="{{ route('categories.create') }}">
                                        <i class="si-plus si"></i>
                                    </a></button>

                            </div>

                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="complex_header" class="table table-striped table-bordered display"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">NAME</th>
                                                <th scope="col">SLUG</th>
                                                <th scope="col">IS ACTIVE</th>
                                                <th scope="col">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td scope="row">{{ $category->category_id }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->slug }}</td>
                                                    <td>{{ $category->is_active ? 'Có' : 'Không' }}</td>
                                                    <td class="d-flex">
                                                        <a class="btn btn-warning me-2"
                                                            href="{{ route('categories.edit', $category) }}">
                                                            <i class="si-pencil si"></i>
                                                        </a>
                                                        <form action="{{ route('categories.destroy', $category) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xoá không?')"
                                                                type="submit">
                                                                <i class="si-trash si"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->

            @include('admin.layouts.partials.footer')

            <!-- Control Sidebar -->
            <!-- /.control-sidebar -->

            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>


        <!-- Vendor JS -->
        <script src="{{ asset('admin/main/js/vendors.min.js') }}"></script>
        <script src="{{ asset('admin/main/js/pages/chat-popup.js') }}"></script>
        <script src="{{ asset('admin/assets/icons/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor_components/zingchart_branded_version/zingchart.min.js') }}"></script>

        <!-- CrmX Admin App -->
        <script src="{{ asset('admin/main/js/template.js') }}"></script>
        <script src="{{ asset('admin/main/js/demo.js') }}"></script>
        <script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>

</body>

</html>

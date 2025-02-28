<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>Thêm Mới Danh Mục</title>

    <!-- Vendors Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
    @include('admin.layouts.partials.header')

    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.partials.aside')
    <div class="wrapper">
        <div class="container mt-5 ">
            <div class="card p-2">
                <h2 class="mb-4">Update Category</h2>
                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $category->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Is Active</label>
                        <input type="checkbox" id="is_active" name="is_active"
                            {{ $category->is_active ? 'checked' : '' }}>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

  <title>CrmX Admin - Dashboard Data Tables</title>

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
  @include('admin.layouts.partials.content')
  <!-- /.content-wrapper -->

  @include('admin.layouts.partials.footer')

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Vendor JS -->
		<script src="{{ asset('admin/main/js/vendors.min.js') }}"></script>
		<script src="{{ asset('admin/main/js/pages/chat-popup.js') }}"></script>
		<script src="{{ asset('admin/assets/icons/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
		<script src="{{ asset('admin/assets/vendor_components/zingchart_branded_version/zingchart.min.js') }}"></script>
		<script src="https://www.amcharts.com/lib/4/core.js"></script>
		<script src="https://www.amcharts.com/lib/4/maps.js"></script>
		<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
		<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
		<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

		<!-- CrmX Admin App -->
		<script src="{{ asset('admin/main/js/template.js') }}"></script>
		<script src="{{ asset('admin/main/js/demo.js') }}"></script>
		<script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>


</body>
</html>

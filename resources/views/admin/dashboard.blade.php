@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">

                <div class="col-xl-4 col-12">
                    <div class="box">
                        <div class="box-body">
                            <h4 class="box-title">Thống Kê Tương Tác</h4>
                            <div id="donut-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="box">
                        <div class="box-body">
                            <h4 class="box-title">Thống Kê Tài Khoản</h4>
                            <ul class="list-inline text-end">
                                <li>
                                    <h5><i class="fa fa-circle me-5 text-primary"></i>Người Dùng</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle me-5 text-success"></i>Tác Giả</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle me-5 text-info"></i>Kiểm Duyệt Viên</h5>
                                </li>
                            </ul>
                            <div id="area-chart"></div>
                        </div>
                    </div>
                </div>
        </div>
        <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection

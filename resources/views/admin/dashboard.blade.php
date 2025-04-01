@extends('admin.layouts.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Main content -->
            <section class="content">
                <!-- Thống kê bài viết -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Tổng bài viết</h5>
                                        <p class="mb-0 text-fade fs-12">Tất cả bài viết</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['total'] ?? 0 }}</h3>
                                    <div class="text-primary">
                                        <i class="fa fa-file-text fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Đã xuất bản</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đã xuất bản</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['published'] ?? 0 }}</h3>
                                    <div class="text-success">
                                        <i class="fa fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Chờ duyệt</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đang chờ duyệt</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['pending'] ?? 0 }}</h3>
                                    <div class="text-warning">
                                        <i class="fa fa-hourglass-half fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="d-flex align-items-center">
                                    <div class="ms-15">
                                        <h5 class="mb-0">Bản nháp</h5>
                                        <p class="mb-0 text-fade fs-12">Bài viết đang lưu nháp</p>
                                    </div>
                                </div>
                                <div class="mt-20 d-flex justify-content-between align-items-center">
                                    <h3 class="fw-600">{{ $articleStats['draft'] ?? 0 }}</h3>
                                    <div class="text-secondary">
                                        <i class="fa fa-pencil-square-o fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Các biểu đồ thống kê hiện tại -->
                <div class="row">
                    <div class="col-xl-4 col-12">
                        <div class="box">
                            <div class="box-body">
                                <h4 class="box-title">Thống Kê Tương Tác</h4>
                                <div id="donut-chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
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
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection

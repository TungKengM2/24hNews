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
                
                <!-- Thống kê người dùng và tương tác -->
                <div class="row">
                    <div class="col-xl-6 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê người dùng</h4>
                            </div>
                            <div class="box-body text-center">
                                <div class="mb-20">
                                    <div class="icon bg-info-light rounded-circle w-80 h-80 text-center mx-auto l-h-100">
                                        <span class="fs-40 icon-User"><span class="path1"></span><span class="path2"></span></span>
                                    </div>
                                </div>
                                <h1 class="countnm fs-50" id="total-users">0</h1>
                                <p class="mb-0 text-fade">Tổng số người dùng</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-info-light mt-10">
                                    <i class="fa fa-users"></i> Xem danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Thống kê lượt tương tác tổng</h4>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div class="icon bg-primary-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <i class="fa fa-eye fs-30"></i>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalViews ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Lượt xem</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div class="icon bg-success-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Chat"><span class="path1"></span><span class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalComments ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Bình luận</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="mb-10">
                                            <div class="icon bg-warning-light rounded-circle w-60 h-60 text-center mx-auto l-h-80">
                                                <span class="fs-30 icon-Heart"><span class="path1"></span><span class="path2"></span></span>
                                            </div>
                                        </div>
                                        <h3 class="fw-600">{{ $totalLikes ?? 0 }}</h3>
                                        <p class="mb-0 text-fade">Lượt thích</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>
@endsection

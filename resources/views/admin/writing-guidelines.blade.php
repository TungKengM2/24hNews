@extends('admin.layouts.master')
@section('title', 'Hướng dẫn viết bài')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Hướng dẫn viết bài</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                <li class="breadcrumb-item active" aria-current="page">Hướng dẫn viết bài</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Vui lòng đọc kỹ các hướng dẫn dưới đây trước khi viết bài.
                            </div>

                            <div class="guidelines-section mb-4">
                                <h4 class="text-primary">1. Yêu cầu kỹ thuật</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <i class="fas fa-check text-success"></i>
                                                <strong>Tiêu đề:</strong> Bắt buộc, không quá 255 ký tự
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check text-success"></i>
                                                <strong>Nội dung:</strong> Bắt buộc, sử dụng trình soạn thảo
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check text-success"></i>
                                                <strong>Ảnh đại diện:</strong>
                                                <ul>
                                                    <li>Định dạng: jpeg, png, jpg, gif, webp</li>
                                                    <li>Kích thước tối đa: 2048KB</li>
                                                </ul>
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check text-success"></i>
                                                <strong>Danh mục:</strong> Bắt buộc chọn một danh mục phù hợp
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="guidelines-section mb-4">
                                <h4 class="text-danger">2. Tiêu chí nội dung cấm</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h5 class="text-danger">Chính trị/Quốc phòng</h5>
                                            <ul>
                                                <li>Không được kích động chống đối nhà nước</li>
                                                <li>Không được tiết lộ bí mật quốc gia</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="text-danger">Xã hội/An ninh</h5>
                                            <ul>
                                                <li>Không được đe dọa tính mạng</li>
                                                <li>Không được gây hoang mang dư luận</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="text-danger">Y tế/Sức khỏe</h5>
                                            <ul>
                                                <li>Không được lan truyền thông tin sai về vaccine</li>
                                                <li>Không được vu khống cơ quan y tế</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="text-danger">Kinh tế/Tài chính</h5>
                                            <ul>
                                                <li>Không được loan tin khủng hoảng kinh tế giả</li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="text-danger">Văn hóa/Đạo đức</h5>
                                            <ul>
                                                <li>Không được lăng mạ cá nhân</li>
                                                <li>Không được phân biệt chủng tộc/tôn giáo</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="guidelines-section mb-4">
                                <h4 class="text-success">3. Quy trình kiểm duyệt</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h5>Trạng thái bài viết:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <span class="badge bg-secondary">Draft</span> - Bài viết nháp
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-warning">Pending</span> - Đang chờ kiểm duyệt
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-success">Published</span> - Đã xuất bản
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-danger">Rejected</span> - Bị từ chối
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-info">Archived</span> - Đã lưu trữ
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mb-3">
                                            <h5>Mức độ vi phạm:</h5>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <span class="badge bg-success">None</span> - Không vi phạm
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-warning">Low</span> - Vi phạm nhẹ
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-danger">Medium</span> - Vi phạm trung bình
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="badge bg-dark">High</span> - Vi phạm nghiêm trọng
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="guidelines-section mb-4">
                                <h4 class="text-info">4. Ngoại lệ cho phép</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-info"></i>
                                                Từ ngữ trong ngữ cảnh tin tức chính thống
                                            </li>
                                            <li class="list-group-item">
                                                <i class="fas fa-check-circle text-info"></i>
                                                Trích dẫn ý kiến chuyên gia có kiểm chứng
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('articles.create') }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i> Bắt đầu viết bài
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<style>
    .guidelines-section {
        margin-bottom: 2rem;
    }
    .guidelines-section h4 {
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #eee;
    }
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .list-group-item {
        border: none;
        padding: 0.75rem 1.25rem;
    }
    .badge {
        margin-right: 0.5rem;
    }
</style>
@endsection

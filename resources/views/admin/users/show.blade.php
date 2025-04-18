@extends('admin.layouts.master')

@section('title', 'Chi Tiết Tài Khoản')

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="box container mb-4">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h4 class="box-title">Chi Tiết tài khoản / {{ $user->username }}</h4>

                    <div class="d-flex gap-2 ms-auto">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <!-- Thông tin người dùng -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Thông tin người dùng</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Họ và tên:</th>
                                            <td>
                                                @if (!empty($user->fullname))
                                                    {{ $user->fullname }}
                                                @else
                                                    <span class="text-danger">Tài khoản chưa cung cấp Họ tên</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Username:</th>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Số điện thoại:</th>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Thời gian hoạt động:</th>
                                            <td>{{ $accountAge }} ngày</td>
                                        </tr>
                                        <tr>
                                            <th>Số lần vi phạm:</th>
                                            <td>
                                                <span
                                                    class="badge {{ $user->violation_count > 0 ? 'badge-danger' : 'badge-success' }}">
                                                    {{ $user->violation_count }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tình trạng tài khoản:</th>
                                            <td>
                                                @if ($isBanned)
                                                    <span class="badge badge-danger">{{ $banMessage }}</span>
                                                @else
                                                    <span class="badge badge-success">Hoạt động bình thường</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Thông tin địa chỉ -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Thông tin chi tiết</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Số CCCD:</th>
                                            <td>
                                                @if (!empty($approval->cccd_number))
                                                    {{ $approval->cccd_number }}
                                                @else
                                                    <span class="text-danger">Chưa có thông tin</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Địa chỉ:</th>
                                            <td>
                                                @if (!empty($user->address))
                                                    {{ $user->address }}
                                                @else
                                                    <span class="text-danger">Chưa có thông tin</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CCCD -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Ảnh CCCD</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Mặt Trước -->
                                        <div class="col-md-6 text-center">
                                            <h6>Mặt Trước</h6>
                                            @if (!empty($approval?->cccd_front))
                                                <a href="{{ asset('storage/' . $approval->cccd_front) }}"
                                                    data-lightbox="cccd" data-title="CCCD Mặt Trước">
                                                    <img src="{{ asset('storage/' . $approval->cccd_front) }}"
                                                        class="cccd-image" alt="CCCD Mặt Trước">
                                                </a>
                                            @else
                                                <p class="text-muted">Chưa có ảnh được cung cấp</p>
                                            @endif
                                        </div>

                                        <!-- Mặt Sau -->
                                        <div class="col-md-6 text-center">
                                            <h6>Mặt Sau</h6>
                                            @if (!empty($approval?->cccd_back))
                                                <a href="{{ asset('storage/' . $approval->cccd_back) }}"
                                                    data-lightbox="cccd" data-title="CCCD Mặt Sau">
                                                    <img src="{{ asset('storage/' . $approval->cccd_back) }}"
                                                        class="cccd-image" alt="CCCD Mặt Sau">
                                                </a>
                                            @else
                                                <p class="text-muted">Chưa có ảnh được cung cấp</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Chứng chỉ -->
                    @if (isset($certificates) && count($certificates) > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0">Chứng chỉ đã tải lên</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($certificates as $certificate)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card h-100">
                                                        <div class="card-body text-center">
                                                            <i class="fa fa-file-pdf-o fa-4x text-danger mb-3"></i>
                                                            <h6 class="card-title">
                                                                {{ basename($certificate) }}</h6>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ asset('storage/' . $certificate) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-eye"></i> Xem
                                                                </a>
                                                                <a href="{{ asset('storage/' . $certificate) }}" download
                                                                    class="btn btn-success btn-sm">
                                                                    <i class="fa fa-download"></i> Tải
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Không có chứng chỉ nào được tải
                                    lên.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox2 CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <style>
        .cccd-image,
        .certificate-image {
            width: 100%;
            max-width: 300px;
            height: auto;
            cursor: pointer;
            border: 2px solid #ddd;
            border-radius: 5px;
            transition: transform 0.3s ease-in-out;
        }

        .cccd-image:hover,
        .certificate-image:hover {
            transform: scale(1.05);
        }

        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-bottom: none;
        }

        .table th {
            background-color: #f8f9fa;
        }
    </style>
@endsection

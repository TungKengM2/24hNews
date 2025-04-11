@extends('admin.layouts.master')

@section('title', 'Chi Tiết Yêu Cầu Nâng Cấp')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <div class="box container mb-4">
            <div class="box-header with-border d-flex justify-content-between align-items-center">
                <h4 class="box-title">Chi Tiết Yêu Cầu #{{ $approval->approval_id }}</h4>
                <a href="{{ route('admin.user-role-requests') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>
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
                                        <td>{{ $user->fullname }}</td>
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
                                            <span class="badge {{ $user->violation_count > 0 ? 'badge-danger' : 'badge-success' }}">
                                                {{ $user->violation_count }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tình trạng tài khoản:</th>
                                        <td>
                                            @if($isBanned)
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

                    <!-- Thông tin yêu cầu -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">Thông tin yêu cầu</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Thời gian gửi:</th>
                                        <td>{{ $approval->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            @if ($approval->status === 'pending')
                                                <span class="badge badge-warning">Chờ duyệt</span>
                                            @elseif ($approval->status === 'approved')
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @else
                                                <span class="badge badge-danger">Từ chối</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Số CCCD:</th>
                                        <td>{{ $approval->cccd_number ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                                <div class="mt-3">
                                    <h6 class="text-primary">Lý do yêu cầu nâng cấp:</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            {{ $approval->remarks ?? 'Không có lý do' }}
                                        </div>
                                    </div>
                                </div>
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
                                    <div class="col-md-6 text-center">
                                        <h6>Mặt Trước</h6>
                                        <a href="{{ asset('storage/' . $approval->cccd_front) }}" data-lightbox="cccd" data-title="CCCD Mặt Trước">
                                            <img src="{{ asset('storage/' . $approval->cccd_front) }}" class="cccd-image" alt="CCCD Mặt Trước">
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <h6>Mặt Sau</h6>
                                        <a href="{{ asset('storage/' . $approval->cccd_back) }}" data-lightbox="cccd" data-title="CCCD Mặt Sau">
                                            <img src="{{ asset('storage/' . $approval->cccd_back) }}" class="cccd-image" alt="CCCD Mặt Sau">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chứng chỉ -->
                @if(isset($certificates) && count($certificates) > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Chứng chỉ đã tải lên</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($certificates as $certificate)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body text-center">
                                                        <i class="fa fa-file-pdf-o fa-4x text-danger mb-3"></i>
                                                        <h6 class="card-title">{{ basename($certificate) }}</h6>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ asset('storage/' . $certificate) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="fa fa-eye"></i> Xem
                                                            </a>
                                                            <a href="{{ asset('storage/' . $certificate) }}" download class="btn btn-success btn-sm">
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
                                <i class="fa fa-info-circle"></i> Không có chứng chỉ nào được tải lên.
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Nút hành động -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        @if ($approval->status === 'pending')
                            <form action="{{ route('admin.approve.user', $approval->approval_id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg"
                                    onclick="return confirm('Xác nhận duyệt?')">
                                    <i class="fa fa-check"></i> Duyệt
                                </button>
                            </form>

                            <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#rejectModal">
                                <i class="fa fa-times"></i> Từ chối
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Từ chối -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Từ chối yêu cầu nâng cấp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.reject.user', $approval->approval_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejectReason">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectReason" name="reject_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lightbox2 CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<style>
    .cccd-image, .certificate-image {
        width: 100%;
        max-width: 300px;
        height: auto;
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
    }
    .cccd-image:hover, .certificate-image:hover {
        transform: scale(1.05);
    }
    .card {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .card-header {
        border-bottom: none;
    }
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endsection

@extends('admin.layouts.master')

@section('title', 'Chi Tiết Yêu Cầu Nâng Cấp')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <div class="box container mb-4">
            <div class="box-header with-border d-flex justify-content-between align-items-center">
                <h4 class="box-title">Chi Tiết Yêu Cầu #{{ $approval->approval_id }}</h4>
                <a href="{{ route('admin.user-role-requests') }}" class="btn btn-secondary">Quay lại</a>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-dark mb-0">
                        <tbody>
                            <tr>
                                <th>Họ và tên</th>
                                <td>{{ $user->fullname }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại</th>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Vai trò hiện tại</th>
                                <td>{{ $user->role->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Thời gian hoạt động</th>
                                <td>{{ $accountAge }} ngày</td>
                            </tr>
                            <tr>
                                <th>Số lần vi phạm</th>
                                <td>{{ $user->violation_count }}</td>
                            </tr>
                            <tr>
                                <th>Tình trạng tài khoản</th>
                                <td>
                                    @if($isBanned)
                                        <span class="badge badge-danger">{{ $banMessage }}</span>
                                    @else
                                        <span class="badge badge-success">Hoạt động bình thường</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Lý do yêu cầu nâng cấp</th>
                                <td>{{ $approval->remarks ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">CCCD:</h5>
                <div class="row">
                    <div class="col-md-6 text-center">
                        <p><strong>Mặt Trước:</strong></p>
                        <a href="{{ asset('storage/' . $approval->cccd_front) }}" data-lightbox="cccd" data-title="CCCD Mặt Trước">
                            <img src="{{ asset('storage/' . $approval->cccd_front) }}" class="cccd-image" alt="CCCD Mặt Trước">
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <p><strong>Mặt Sau:</strong></p>
                        <a href="{{ asset('storage/' . $approval->cccd_back) }}" data-lightbox="cccd" data-title="CCCD Mặt Sau">
                            <img src="{{ asset('storage/' . $approval->cccd_back) }}" class="cccd-image" alt="CCCD Mặt Sau">
                        </a>
                    </div>
                </div>

                <h5 class="mt-4">Chứng chỉ đã tải lên:</h5>
                <ul>
                    @forelse ($certificates as $certificate)
                        <li>
                            <a href="{{ asset('storage/' . $certificate) }}" target="_blank">
                                {{ basename($certificate) }}
                            </a>
                        </li>
                    @empty
                        <p>Không có chứng chỉ nào.</p>
                    @endforelse
                </ul>

                <div class="mt-4">
                    @if ($approval->status === 'pending')
                        <form action="{{ route('admin.approve.user', $approval->approval_id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm"
                                onclick="return confirm('Xác nhận duyệt?')">
                                Duyệt
                            </button>
                        </form>

                        <form action="{{ route('admin.reject.user', $approval->approval_id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Xác nhận từ chối?')">
                                Từ chối
                            </button>
                        </form>
                    @else
                        <p>
                            <strong>Trạng thái yêu cầu:</strong>
                            @if ($approval->status === 'approved')
                                <span class="badge badge-success">Đã duyệt</span>
                            @elseif ($approval->status === 'rejected')
                                <span class="badge badge-danger">Đã từ chối</span>
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox2 CSS & JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<style>
    .cccd-image {
        width: 200px;
        height: auto;
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
    }
    .cccd-image:hover {
        transform: scale(1.1);
    }
</style>
@endsection

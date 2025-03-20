@extends('admin.layouts.master')

@section('title')
    Danh Sách Yêu Cầu Nâng Cấp
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="box container mb-4">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h4 class="box-title">Danh sách yêu cầu nâng cấp</h4>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Vai trò hiện tại</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvals as $approval)
                                    <tr>
                                        <td>{{ $approval->approval_id }}</td>
                                        <td>{{ $approval->user->username ?? 'N/A' }}</td>
                                        <td>{{ $approval->user->email ?? 'N/A' }}</td>
                                        <td>{{ $approval->user->phone ?? 'N/A' }}</td>
                                        <td>{{ $approval->user?->role?->name ?? 'N/A' }}</td>
                                        <td>
                                            @if ($approval->status === 'pending')
                                                <span class="badge badge-warning">Chờ duyệt</span>
                                            @elseif ($approval->status === 'approved')
                                                <span class="badge badge-success">Đã duyệt</span>
                                            @else
                                                <span class="badge badge-danger">Từ chối</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user-role-request.show', $approval->approval_id) }}"
                                               class="btn btn-info btn-sm">
                                                Chi tiết
                                            </a>

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
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                        <nav>
                            <ul class="pagination pagination-sm">
                                {{ $approvals->appends(['role_id' => $role_id])->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

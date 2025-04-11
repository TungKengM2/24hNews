@extends('admin.layouts.master')

@section('title')
    Danh Sách Yêu Cầu Nâng Cấp
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h4 class="box-title">Danh sách yêu cầu nâng cấp</h4>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Thời gian</th>
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
                                        <td>{{ $approval->created_at->format('d/m/Y H:i') }}</td>
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
                                            <div class="btn-group">
                                                <a href="{{ route('admin.user-role-request.show', $approval->approval_id) }}"
                                                    class="btn btn-info btn-sm" data-toggle="tooltip" title="Xem chi tiết">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @if ($approval->status === 'pending')
                                                    <form action="{{ route('admin.approve.user', $approval->approval_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            data-toggle="tooltip" title="Duyệt yêu cầu"
                                                            onclick="return confirm('Xác nhận duyệt?')">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                        data-toggle="modal" 
                                                        data-target="#rejectModal{{ $approval->approval_id }}"
                                                        data-toggle="tooltip" 
                                                        title="Từ chối yêu cầu">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $approvals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Từ chối cho từng yêu cầu -->
    @foreach($approvals as $approval)
        @if($approval->status === 'pending')
            <div class="modal fade" id="rejectModal{{ $approval->approval_id }}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{ $approval->approval_id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="rejectModalLabel{{ $approval->approval_id }}">Từ chối yêu cầu nâng cấp</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.reject.user', $approval->approval_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rejectReason{{ $approval->approval_id }}">Lý do từ chối <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="rejectReason{{ $approval->approval_id }}" name="reject_reason" rows="3" required></textarea>
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
        @endif
    @endforeach

    <style>
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            background-color: #4a90e2;
            color: white;
            padding: 12px 15px;
        }
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
            border-radius: 4px;
        }
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-danger {
            background-color: #dc3545;
        }
        .btn-group .btn {
            margin-right: 5px;
            border-radius: 4px;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .pagination .page-item.active .page-link {
            background-color: #4a90e2;
            border-color: #4a90e2;
        }
        .pagination .page-link {
            color: #4a90e2;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        .modal-header {
            border-bottom: none;
            padding: 1rem 1.5rem;
        }
        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
        }
        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection

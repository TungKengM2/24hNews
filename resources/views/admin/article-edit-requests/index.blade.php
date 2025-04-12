@extends('admin.layouts.master')

@section('title', 'Yêu cầu chỉnh sửa bài viết')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Yêu cầu chỉnh sửa bài viết</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item">Bài viết</li>
                                <li class="breadcrumb-item active">Yêu cầu chỉnh sửa</li>
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
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('sweet_alert'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            icon: '{{ session('sweet_alert.type') }}',
                                            title: '{{ session('sweet_alert.title') }}',
                                            text: '{{ session('sweet_alert.text') }}',
                                            @if(session('sweet_alert.type') == 'success')
                                            timer: 3000,
                                            timerProgressBar: true,
                                            showConfirmButton: false
                                            @else
                                            confirmButtonText: 'Đóng'
                                            @endif
                                        });
                                    });
                                </script>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-center" width="5%">ID</th>
                                            <th width="20%">Bài viết</th>
                                            <th width="15%">Tác giả</th>
                                            <th width="25%">Lý do yêu cầu</th>
                                            <th width="15%">Ngày yêu cầu</th>
                                            <th class="text-center" width="20%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($requests as $request)
                                            <tr>
                                                <td class="text-center">{{ $request->id }}</td>
                                                <td>
                                                    <strong>{{ $request->article->title }}</strong>
                                                    <div class="small text-muted">ID: {{ $request->article->article_id }}</div>
                                                </td>
                                                <td>
                                                    <strong>{{ $request->author->name }}</strong>
                                                    <div class="small text-muted">{{ $request->author->email }}</div>
                                                </td>
                                                <td>{{ $request->reason }}</td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-success btn-sm approve-btn" data-id="{{ $request->id }}">
                                                        <i class="fas fa-check"></i> Đồng ý
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm reject-btn" data-id="{{ $request->id }}">
                                                        <i class="fas fa-times"></i> Từ chối
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có yêu cầu chỉnh sửa nào đang chờ xử lý</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $requests->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phê duyệt yêu cầu chỉnh sửa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approve_note">Ghi chú (không bắt buộc)</label>
                        <textarea class="form-control" id="approve_note" name="admin_note" rows="3" placeholder="Nhập ghi chú nếu cần"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success">Xác nhận phê duyệt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Từ chối yêu cầu chỉnh sửa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_note">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_note" name="admin_note" rows="3" required placeholder="Nhập lý do từ chối yêu cầu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Modal Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Define the functions in global scope
    function showApproveModal(requestId) {
        const modal = document.getElementById('approveModal');
        const form = document.getElementById('approveForm');
        form.action = '/admin/article-edit-requests/' + requestId + '/approve';
        console.log('Setting approve form action to:', form.action);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    function showRejectModal(requestId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = '/admin/article-edit-requests/' + requestId + '/reject';
        console.log('Setting reject form action to:', form.action);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    // Add event listeners to buttons
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const requestId = this.getAttribute('data-id');
            showApproveModal(requestId);
        });
    });

    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function() {
            const requestId = this.getAttribute('data-id');
            showRejectModal(requestId);
        });
    });

    // Xử lý thông báo
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Lỗi!',
            text: '{{ session('error') }}'
        });
    @endif
});
</script>
@section('scripts')
<!-- Additional scripts can go here -->
@endsection

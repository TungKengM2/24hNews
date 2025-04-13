@extends('admin.layouts.master')

@section('title', 'Yêu cầu chỉnh sửa bài viết')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Yêu cầu chỉnh sửa bài viết</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Yêu cầu chỉnh sửa</li>
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
                        <div class="box-header with-border">
                            <h4 class="box-title">Danh sách yêu cầu chỉnh sửa đang chờ xử lý</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="30%">Bài viết</th>
                                            <th width="15%">Tác giả</th>
                                            <th width="25%">Lý do</th>
                                            <th width="15%">Ngày yêu cầu</th>
                                            <th width="10%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($editRequests as $request)
                                            <tr>
                                                <td>{{ $request->id }}</td>
                                                <td>
                                                    <a href="{{ route('articles.show', $request->article_id) }}" target="_blank">
                                                        {{ $request->article->title }}
                                                    </a>
                                                    <br>
                                                    <small class="text-muted">ID: {{ $request->article_id }}</small>
                                                </td>
                                                <td>
                                                    {{ $request->user->email }}
                                                </td>
                                                <td>{{ $request->reason }}</td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="waves-effect waves-light btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $request->id }}">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="waves-effect waves-light btn btn-success btn-sm" onclick="approveRequest({{ $request->id }})">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button type="button" class="waves-effect waves-light btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Chi tiết Modal -->
                                            <div class="modal fade" id="detailsModal{{ $request->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Chi tiết yêu cầu chỉnh sửa</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Bài viết:</strong> {{ $request->article->title }}</p>
                                                            <p><strong>Tác giả:</strong> {{ $request->user->email }}</p>
                                                            <p><strong>Lý do:</strong> {{ $request->reason }}</p>
                                                            <p><strong>Ngày yêu cầu:</strong> {{ $request->created_at->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Từ chối Modal -->
                                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.edit-requests.reject', $request->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Từ chối yêu cầu chỉnh sửa</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label class="form-label">Lý do từ chối</label>
                                                                    <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                                <button type="submit" class="btn btn-danger">Từ chối</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có yêu cầu chỉnh sửa nào đang chờ xử lý</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $editRequests->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- /.content-wrapper -->
@endsection

@push('scripts')
<script>
function approveRequest(id) {
    if (confirm('Bạn có chắc chắn muốn chấp nhận yêu cầu chỉnh sửa này?')) {
        fetch(`/admin/edit-requests/${id}/approve`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
        });
    }
}
</script>
@endpush

@extends('layouts.moderator')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Yêu cầu chỉnh sửa bài viết</h2>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách yêu cầu chỉnh sửa đang chờ xử lý</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Bài viết</th>
                            <th>Tác giả</th>
                            <th>Lý do</th>
                            <th>Ngày yêu cầu</th>
                            <th>Thao tác</th>
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
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal{{ $request->id }}">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" onclick="approveRequest({{ $request->id }})">
                                        <i class="fas fa-check"></i> Đồng ý
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $request->id }}">
                                        <i class="fas fa-times"></i> Từ chối
                                    </button>
                                </td>
                            </tr>

                            <!-- Chi tiết Modal -->
                            <div class="modal fade" id="detailsModal{{ $request->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Chi tiết yêu cầu chỉnh sửa</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
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
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('edit-requests.reject', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Từ chối yêu cầu chỉnh sửa</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="rejection_reason">Lý do từ chối</label>
                                                    <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
            {{ $editRequests->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveRequest(id) {
    if (confirm('Bạn có chắc chắn muốn chấp nhận yêu cầu chỉnh sửa này?')) {
        fetch(`/moderator/edit-requests/${id}/approve`, {
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
@endsection

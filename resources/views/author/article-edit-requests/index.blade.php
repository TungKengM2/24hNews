@extends('author.layouts.master')

@section('title')
    Yêu cầu chỉnh sửa bài viết
@endsection

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
                                <li class="breadcrumb-item"><a href="{{ route('author.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Quản lý bài viết</li>
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
                            <h4 class="box-title">Danh sách yêu cầu chỉnh sửa bài viết</h4>
                            <div class="box-controls pull-right">
                                <a href="{{ route('author.articles.index') }}" class="btn btn-default btn-sm">
                                    <i class="fa fa-arrow-left me-1"></i> Quay lại
                                </a>
                            </div>
                        </div>

                        <div class="box-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Bài viết</th>
                                            <th>Lý do yêu cầu</th>
                                            <th>Ngày yêu cầu</th>
                                            <th>Trạng thái</th>
                                            <th>Ghi chú</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($requests as $request)
                                            <tr>
                                                <td>{{ $request->id }}</td>
                                                <td>
                                                    <a href="{{ route('author.articles.show', $request->article) }}">
                                                        <strong>{{ $request->article->title }}</strong>
                                                    </a>
                                                </td>
                                                <td>{{ Str::limit($request->reason, 100) }}</td>
                                                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($request->status === 'pending')
                                                        <span class="badge bg-warning">Đang chờ xử lý</span>
                                                    @elseif($request->status === 'approved')
                                                        <span class="badge bg-success">Đã chấp nhận</span>
                                                    @elseif($request->status === 'rejected')
                                                        <span class="badge bg-danger">Đã từ chối</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($request->admin_note)
                                                        {{ Str::limit($request->admin_note, 100) }}
                                                    @else
                                                        <span class="text-muted">Không có ghi chú</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($request->status === 'pending')
                                                        <form action="{{ route('author.articles.edit-request.cancel', $request) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn hủy yêu cầu này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-times-circle"></i> Hủy yêu cầu
                                                            </button>
                                                        </form>
                                                    @elseif($request->status === 'approved')
                                                        <a href="{{ route('author.articles.edit', $request->article) }}" class="btn btn-primary btn-sm">
                                                            <i class="fa fa-edit"></i> Chỉnh sửa bài viết
                                                        </a>
                                                    @else
                                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $request->id }}">
                                                            <i class="fa fa-eye"></i> Xem chi tiết
                                                        </button>

                                                        <!-- Modal chi tiết từ chối -->
                                                        <div class="modal fade" id="detailModal{{ $request->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $request->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="detailModalLabel{{ $request->id }}">Chi tiết yêu cầu</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h6>Yêu cầu của bạn:</h6>
                                                                        <p>{{ $request->reason }}</p>

                                                                        <h6>Lý do từ chối:</h6>
                                                                        <p>{{ $request->admin_note }}</p>

                                                                        <h6>Thời gian từ chối:</h6>
                                                                        <p>{{ $request->processed_at ? $request->processed_at->format('d/m/Y H:i') : 'Không có thông tin' }}</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Bạn chưa có yêu cầu chỉnh sửa nào</td>
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
@endsection

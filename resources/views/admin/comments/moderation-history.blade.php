@extends('admin.layouts.master')

@section('title', 'Lịch sử kiểm duyệt bình luận')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h3 class="page-title">Lịch sử kiểm duyệt bình luận</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Bình luận</li>
                                <li class="breadcrumb-item active" aria-current="page">Lịch sử kiểm duyệt</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Thông tin bình luận</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID:</strong> {{ $comment->comment_id }}</p>
                                    <p><strong>Người bình luận:</strong> {{ $comment->user->username ?? 'Không xác định' }}</p>
                                    <p><strong>Bài viết:</strong>
                                        @if($comment->article)
                                            <a href="{{ route('articles.show', $comment->article) }}">{{ $comment->article->title }}</a>
                                        @else
                                            Không xác định
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Trạng thái:</strong>
                                        @if($comment->status == 'approved')
                                            <span class="badge badge-success">Đã duyệt</span>
                                        @elseif($comment->status == 'rejected')
                                            <span class="badge badge-danger">Đã từ chối</span>
                                        @else
                                            <span class="badge badge-warning">{{ $comment->status }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Thời gian tạo:</strong> {{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                                    <p><strong>Cập nhật lần cuối:</strong> {{ $comment->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h5>Nội dung bình luận:</h5>
                                    <div class="p-3 bg-light">
                                        {!! $comment->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Lịch sử kiểm duyệt</h4>
                        </div>
                        <div class="box-body">
                            @if($logs->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Thời gian</th>
                                                <th>Hành động</th>
                                                <th>Người thực hiện</th>
                                                <th>Chi tiết</th>
                                                <th>Mức độ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($logs as $log)
                                                <tr>
                                                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                                    <td>
                                                        <span class="badge
                                                            @if($log->action_type == 'approve') badge-success
                                                            @elseif($log->action_type == 'reject') badge-danger
                                                            @elseif($log->action_type == 'flag') badge-warning
                                                            @elseif($log->action_type == 'auto_moderate') badge-info
                                                            @elseif($log->action_type == 'restore') badge-primary
                                                            @else badge-secondary
                                                            @endif">
                                                            @switch($log->action_type)
                                                                @case('approve')
                                                                    Phê duyệt
                                                                    @break
                                                                @case('reject')
                                                                    Từ chối
                                                                    @break
                                                                @case('flag')
                                                                    Gắn cờ
                                                                    @break
                                                                @case('edit')
                                                                    Chỉnh sửa
                                                                    @break
                                                                @case('delete')
                                                                    Xóa
                                                                    @break
                                                                @case('restore')
                                                                    Khôi phục
                                                                    @break
                                                                @case('auto_moderate')
                                                                    Tự động kiểm duyệt
                                                                    @break
                                                                @default
                                                                    {{ $log->action_type }}
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($log->moderator)
                                                            {{ $log->moderator->username }}
                                                        @else
                                                            <span class="text-muted">Hệ thống</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#logModal{{ $log->log_id }}">
                                                            Xem chi tiết
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <span class="badge
                                                            @if($log->severity == 'high') badge-danger
                                                            @elseif($log->severity == 'medium') badge-warning
                                                            @elseif($log->severity == 'low') badge-info
                                                            @else badge-secondary
                                                            @endif">
                                                            @switch($log->severity)
                                                                @case('high')
                                                                    Cao
                                                                    @break
                                                                @case('medium')
                                                                    Trung bình
                                                                    @break
                                                                @case('low')
                                                                    Thấp
                                                                    @break
                                                                @default
                                                                    Không
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                </tr>

                                                <!-- Modal chi tiết -->
                                                <div class="modal fade" id="logModal{{ $log->log_id }}" tabindex="-1" role="dialog" aria-labelledby="logModalLabel{{ $log->log_id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="logModalLabel{{ $log->log_id }}">Chi tiết kiểm duyệt</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <h6>Trạng thái trước:</h6>
                                                                        <pre class="bg-light p-2">{{ json_encode($log->before_state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <h6>Trạng thái sau:</h6>
                                                                        <pre class="bg-light p-2">{{ json_encode($log->after_state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-3">
                                                                    <div class="col-12">
                                                                        <h6>Chi tiết:</h6>
                                                                        <pre class="bg-light p-2">{{ json_encode($log->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Chưa có lịch sử kiểm duyệt nào cho bình luận này.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

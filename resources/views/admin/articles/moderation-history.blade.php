@extends('admin.layouts.master')

@section('title', 'Lịch sử kiểm duyệt bài viết')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Lịch sử kiểm duyệt bài viết</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Bài viết</li>
                                <li class="breadcrumb-item active" aria-current="page">Lịch sử kiểm duyệt</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="container-full">
            <div class="col-12">
                <div class="box">
                    <div class="box-header with-border d-flex justify-content-between align-items-center">
                        <h3 class="box-title">Lịch sử kiểm duyệt bài viết: {{ $article->title }}</h3>
                        <div>
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Chỉnh sửa bài viết
                            </a>
                            <a href="{{ route('articles.index') }}" class="btn btn-sm btn-default ms-2">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mb-4">
                            <h5>Thông tin bài viết</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tiêu đề:</strong> {{ $article->title }}</p>
                                <p><strong>Tác giả:</strong> {{ $article->author->username ?? 'Không xác định' }}</p>
                                <p><strong>Danh mục:</strong> {{ $article->category->name ?? 'Không có danh mục' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Trạng thái hiện tại:</strong>
                                    <span class="badge
                                        @if($article->status == 'published') badge-success
                                        @elseif($article->status == 'pending') badge-warning
                                        @elseif($article->status == 'rejected') badge-danger
                                        @elseif($article->status == 'draft') badge-secondary
                                        @else badge-info
                                        @endif">
                                        {{ $article->status }}
                                    </span>
                                </p>
                                <p><strong>Ngày tạo:</strong> {{ $article->created_at->format('d/m/Y H:i:s') }}</p>
                                <p><strong>Cập nhật lần cuối:</strong> {{ $article->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <h5>Lịch sử kiểm duyệt</h5>
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
                                                            Đánh dấu
                                                            @break
                                                        @case('auto_moderate')
                                                            Tự động kiểm duyệt
                                                            @break
                                                        @case('restore')
                                                            Khôi phục
                                                            @break
                                                        @default
                                                            {{ $log->action_type }}
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td>{{ $log->moderator->username ?? 'Hệ thống' }}</td>
                                            <td>
                                                @if(isset($log->details['action']))
                                                    {{ $log->details['action'] }}
                                                    @if(isset($log->details['reason']))
                                                        <br><small class="text-muted">Lý do: {{ $log->details['reason'] }}</small>
                                                    @endif
                                                @else
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#logModal{{ $log->log_id }}">
                                                        Xem chi tiết
                                                    </button>
                                                @endif
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

                                        <!-- Modal for log details -->
                                        <div class="modal fade" id="logModal{{ $log->log_id }}" tabindex="-1" role="dialog" aria-labelledby="logModalLabel{{ $log->log_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="logModalLabel{{ $log->log_id }}">Chi tiết log kiểm duyệt</h5>
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
                            Chưa có lịch sử kiểm duyệt nào cho bài viết này.
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

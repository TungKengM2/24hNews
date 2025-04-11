@extends('admin.layouts.master')

@section('title', 'Lịch sử kiểm duyệt')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Lịch sử kiểm duyệt</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Kiểm duyệt</li>
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
                        <h3 class="box-title">Lịch sử kiểm duyệt</h3>
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <!-- Bộ lọc -->
                        <div class="mb-4">
                            <form action="{{ route('admin.moderation.history') }}" method="GET" class="row g-3">
                                <div class="col-md-2">
                                    <label for="content_type" class="form-label">Loại nội dung</label>
                                    <select name="content_type" id="content_type" class="form-select">
                                        <option value="all" {{ request('content_type') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                        <option value="article" {{ request('content_type') == 'article' ? 'selected' : '' }}>Bài viết</option>
                                        <option value="comment" {{ request('content_type') == 'comment' ? 'selected' : '' }}>Bình luận</option>
                                        <option value="role_upgrade" {{ request('content_type') == 'role_upgrade' ? 'selected' : '' }}>Nâng cấp vai trò</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="action_type" class="form-label">Loại hành động</label>
                                    <select name="action_type" id="action_type" class="form-select">
                                        <option value="all" {{ request('action_type') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                        <option value="approve" {{ request('action_type') == 'approve' ? 'selected' : '' }}>Phê duyệt</option>
                                        <option value="reject" {{ request('action_type') == 'reject' ? 'selected' : '' }}>Từ chối</option>
                                        <option value="flag" {{ request('action_type') == 'flag' ? 'selected' : '' }}>Đánh dấu</option>
                                        <option value="auto_moderate" {{ request('action_type') == 'auto_moderate' ? 'selected' : '' }}>Tự động kiểm duyệt</option>
                                        <option value="restore" {{ request('action_type') == 'restore' ? 'selected' : '' }}>Khôi phục</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="severity" class="form-label">Mức độ</label>
                                    <select name="severity" id="severity" class="form-select">
                                        <option value="all" {{ request('severity') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                        <option value="none" {{ request('severity') == 'none' ? 'selected' : '' }}>Không</option>
                                        <option value="low" {{ request('severity') == 'low' ? 'selected' : '' }}>Thấp</option>
                                        <option value="medium" {{ request('severity') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                        <option value="high" {{ request('severity') == 'high' ? 'selected' : '' }}>Cao</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="date_from" class="form-label">Từ ngày</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="date_to" class="form-label">Đến ngày</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Lọc</button>
                                    <a href="{{ route('admin.moderation.history') }}" class="btn btn-default ms-2">Đặt lại</a>
                                </div>
                            </form>
                        </div>

                        <!-- Hiển thị thông báo lỗi nếu có -->
                        @if(isset($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif

                        <!-- Bảng lịch sử kiểm duyệt -->
                        @if(isset($logs) && $logs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nội dung</th>
                                            <th>Thời gian</th>
                                            <th>Hành động</th>
                                            <th>Người thực hiện</th>
                                            <th>Chi tiết</th>
                                            <th>Mức độ</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <td>{{ $log->log_id }}</td>
                                                <td>
                                                    @if($log->content_type == 'article')
                                                        @php
                                                            $article = App\Models\Article::find($log->content_id);
                                                        @endphp
                                                        @if($article)
                                                            <a href="{{ route('articles.show', $article) }}" title="{{ $article->title }}">
                                                                {{ Str::limit($article->title, 30) }}
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Bài viết #{{ $log->content_id }}</span>
                                                        @endif
                                                    @elseif($log->content_type == 'comment')
                                                        @php
                                                            $comment = App\Models\Comment::find($log->content_id);
                                                        @endphp
                                                        @if($comment)
                                                            <span title="{{ strip_tags($comment->content) }}">
                                                                {{ Str::limit(strip_tags($comment->content), 30) }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Bình luận #{{ $log->content_id }}</span>
                                                        @endif
                                                    @elseif($log->content_type == 'role_upgrade')
                                                        @php
                                                            $user = App\Models\User::find($log->content_id);
                                                        @endphp
                                                        @if($user)
                                                            <span>{{ $user->username }}</span>
                                                        @else
                                                            <span class="text-muted">Người dùng #{{ $log->content_id }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">{{ $log->content_type }} #{{ $log->content_id }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i:s') }}</td>
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
                                                <td>{{ $log->username ?? 'Hệ thống' }}</td>
                                                <td>
                                                    @php
                                                        $details = json_decode($log->details, true);
                                                    @endphp
                                                    @if(isset($details['action']))
                                                        {{ $details['action'] }}
                                                        @if(isset($details['reason']))
                                                            <br><small class="text-muted">Lý do: {{ $details['reason'] }}</small>
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
                                                <td>
                                                    @if($log->content_type == 'article')
                                                        @php
                                                            $article = App\Models\Article::find($log->content_id);
                                                        @endphp
                                                        @if($article)
                                                            <a href="{{ route('articles.moderation-history', $article) }}" class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-history"></i> Xem lịch sử
                                                            </a>
                                                        @endif
                                                    @elseif($log->content_type == 'comment')
                                                        @php
                                                            $comment = App\Models\Comment::find($log->content_id);
                                                        @endphp
                                                        @if($comment)
                                                            <a href="{{ route('comments.moderation-history', $comment) }}" class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-history"></i> Xem lịch sử
                                                            </a>
                                                        @endif
                                                    @elseif($log->content_type == 'role_upgrade')
                                                        @php
                                                            $user = App\Models\User::find($log->content_id);
                                                        @endphp
                                                        @if($user)
                                                            <a href="{{ route('users.role-upgrade-history', $user) }}" class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-history"></i> Xem lịch sử
                                                            </a>
                                                        @endif
                                                    @endif
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
                                                                    <pre class="bg-light p-2">{{ json_encode(json_decode($log->before_state, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Trạng thái sau:</h6>
                                                                    <pre class="bg-light p-2">{{ json_encode(json_decode($log->after_state, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-12">
                                                                    <h6>Chi tiết:</h6>
                                                                    <pre class="bg-light p-2">{{ json_encode(json_decode($log->details, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
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

                            <!-- Phân trang -->
                            <div class="mt-4">
                                {{ $logs->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Không có dữ liệu lịch sử kiểm duyệt nào.
                            </div>

                            <!-- Thông tin debug -->
                            @if(config('app.debug'))
                                <div class="card mt-4">
                                    <div class="card-header bg-secondary text-white">
                                        Thông tin debug (chỉ hiển thị trong môi trường debug)
                                    </div>
                                    <div class="card-body">
                                        <h5>Kiểm tra bảng moderation_logs:</h5>
                                        <p>Hãy kiểm tra file log để xem thông tin chi tiết về các truy vấn và kết quả.</p>
                                        <p>File log: <code>storage/logs/laravel.log</code></p>

                                        @if(isset($sampleData))
                                            <h5>Dữ liệu mẫu từ bảng moderation_logs:</h5>
                                            @if($sampleData->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>log_id</th>
                                                                <th>action_type</th>
                                                                <th>content_type</th>
                                                                <th>content_id</th>
                                                                <th>moderator_id</th>
                                                                <th>created_at</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sampleData as $item)
                                                                <tr>
                                                                    <td>{{ $item->log_id }}</td>
                                                                    <td>{{ $item->action_type }}</td>
                                                                    <td>{{ $item->content_type }}</td>
                                                                    <td>{{ $item->content_id }}</td>
                                                                    <td>{{ $item->moderator_id }}</td>
                                                                    <td>{{ $item->created_at }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    Không tìm thấy dữ liệu nào trong bảng moderation_logs!
                                                </div>
                                            @endif
                                        @endif

                                        <h5>Thử truy vấn trực tiếp:</h5>
                                        <pre>SELECT * FROM moderation_logs LIMIT 5;</pre>

                                        <h5>Kiểm tra cấu trúc bảng:</h5>
                                        <pre>DESCRIBE moderation_logs;</pre>

                                        <h5>Các bước khắc phục:</h5>
                                        <ol>
                                            <li>Kiểm tra xem bảng moderation_logs có tồn tại không</li>
                                            <li>Kiểm tra xem bảng có dữ liệu không</li>
                                            <li>Kiểm tra cấu trúc bảng có đúng với model không</li>
                                            <li>Kiểm tra các cột cần thiết có tồn tại không</li>
                                        </ol>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Sử dụng Select2 cho dropdown bài viết
        $('#article_id').select2({
            placeholder: 'Chọn bài viết',
            allowClear: true
        });
    });
</script>
@endsection

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
                                        <option value="role_upgrade" {{ request('content_type') == 'role_upgrade' ? 'selected' : '' }}>Nâng cấp vai trò</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="action_type" class="form-label">Loại hành động</label>
                                    <select name="action_type" id="action_type" class="form-select">
                                        <option value="all" {{ request('action_type') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                        <option value="approve" {{ request('action_type') == 'approve' ? 'selected' : '' }}>Phê duyệt</option>
                                        <option value="reject" {{ request('action_type') == 'reject' ? 'selected' : '' }}>Từ chối</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="moderator_id" class="form-label">Người kiểm duyệt</label>
                                    <select name="moderator_id" id="moderator_id" class="form-select">
                                        <option value="">Tất cả</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->user_id }}" {{ request('moderator_id') == $user->user_id ? 'selected' : '' }}>
                                                {{ $user->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2" style="visibility: hidden;">
                                    <label for="content_id" class="form-label">ID nội dung</label>
                                    <input type="number" name="content_id" id="content_id" class="form-control" value="{{ request('content_id') }}" placeholder="Nhập ID">
                                </div>
                               
                                <div class="col-md-2">
                                    <label for="date_from" class="form-label">Từ ngày</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="date_to" class="form-label">Đến ngày</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-12 d-flex justify-content-end mt-3">
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

                                                    @elseif($log->content_type == 'role_upgrade')
                                                        @php
                                                            $user = App\Models\User::find($log->content_id);
                                                            $approval = App\Models\Approval::where('user_id', $log->content_id)
                                                                ->where('type', 'role_upgrade')
                                                                ->orderBy('created_at', 'desc')
                                                                ->first();
                                                        @endphp
                                                        @if($user)
                                                            <span>{{ $user->username }}</span>
                                                            @if($approval)
                                                                <br>
                                                                <small class="text-muted">
                                                                    Yêu cầu nâng cấp lên: {{ $approval->requested_role }}
                                                                </small>
                                                            @endif
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
                                                        @else badge-secondary
                                                        @endif">
                                                        @switch($log->action_type)
                                                            @case('approve')
                                                                Phê duyệt
                                                                @break
                                                            @case('reject')
                                                                Từ chối
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
                                                    @if(isset($details['reason']))
                                                        <span class="text-muted">Lý do: {{ $details['reason'] }}</span>
                                                    @elseif(isset($details['action']))
                                                        {{ $details['action'] }}
                                                    @else
                                                        <span class="text-muted">Không có chi tiết</span>
                                                    @endif
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $logs->appends(request()->except('page'))->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Không có dữ liệu lịch sử kiểm duyệt nào phù hợp với bộ lọc.
                            </div>
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
        // Sử dụng Select2 cho dropdown người kiểm duyệt
        $('#moderator_id').select2({
            placeholder: 'Chọn người kiểm duyệt',
            allowClear: true
        });

        // Xử lý khi thay đổi loại nội dung
        $('#content_type').change(function() {
            if ($(this).val() === 'article') {
                $('#content_id').attr('placeholder', 'Nhập ID bài viết');
            } else if ($(this).val() === 'role_upgrade') {
                $('#content_id').attr('placeholder', 'Nhập ID người dùng');
            } else {
                $('#content_id').attr('placeholder', 'Nhập ID nội dung');
            }
        });

        // Kích hoạt sự kiện change khi trang tải
        $('#content_type').trigger('change');
    });
</script>
@endsection

@extends('moderator.layouts.master')

@section('title')
    Lịch sử kiểm duyệt bài viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Lịch sử kiểm duyệt & bài viết chờ duyệt</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.articles.index') }}">Danh sách
                                            bài viết</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Lịch sử kiểm duyệt</li>
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
                                <h4 class="box-title">Bộ lọc</h4>
                                <div class="box-controls pull-right">
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#filterCollapse" aria-expanded="false"
                                        aria-controls="filterCollapse" style="margin-top: -10px">
                                        <i class="fa fa-filter"></i> Hiển thị bộ lọc
                                    </button>
                                </div>
                            </div>
                            <div class="box-body collapse" id="filterCollapse">
                                <form action="{{ route('moderator.articles.moderation-history.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="action_type">Loại hành động</label>
                                                <select class="form-control" id="action_type" name="action_type">
                                                    <option value="">Tất cả</option>
                                                    <option value="approve"
                                                        {{ request('action_type') == 'approve' ? 'selected' : '' }}>Phê
                                                        duyệt</option>
                                                    <option value="reject"
                                                        {{ request('action_type') == 'reject' ? 'selected' : '' }}>Từ chối
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date_from">Từ ngày</label>
                                                <input type="date" class="form-control" id="date_from" name="date_from"
                                                    value="{{ request('date_from') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date_to">Đến ngày</label>
                                                <input type="date" class="form-control" id="date_to" name="date_to"
                                                    value="{{ request('date_to') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <div>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-search"></i> Tìm kiếm
                                                    </button>
                                                    <a href="{{ route('moderator.articles.moderation-history.index') }}"
                                                        class="btn btn-default">
                                                        <i class="fa fa-refresh"></i> Đặt lại
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Lịch sử kiểm duyệt & bài viết chờ duyệt</h4>
                            </div>
                            <div class="box-body">
                                @if ($paginatedLogs->isEmpty() && $paginatedPendingArticles->isEmpty())
                                    <div class="alert alert-info">
                                        Không có dữ liệu lịch sử kiểm duyệt hoặc bài viết chờ duyệt.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Bài viết</th>
                                                    <th>Trạng thái</th>
                                                    <th>Chi tiết</th>
                                                    <th>Thời gian</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Hiển thị các bài viết đã kiểm duyệt -->
                                                @foreach ($paginatedLogs as $log)
                                                    <tr>
                                                        <td>{{ $log->log_id }}</td>
                                                        <td>
                                                            @if (isset($articles[$log->content_id]))
                                                                <a href="{{ route('moderator.articles.show', $log->content_id) }}"
                                                                    title="{{ $articles[$log->content_id]->title }}">
                                                                    {{ Str::limit($articles[$log->content_id]->title, 30) }}
                                                                </a>
                                                            @else
                                                                <span class="text-muted">Bài viết
                                                                    #{{ $log->content_id }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($log->action_type == 'approve')
                                                                <span class="badge badge-success">Phê duyệt</span>
                                                            @elseif($log->action_type == 'reject')
                                                                <span class="badge badge-danger">Từ chối</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-secondary">{{ $log->action_type }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (is_array($log->details))
                                                                @if (isset($log->details['reason']))
                                                                    <strong>Lý do:</strong>
                                                                    {{ $log->details['reason'] }}<br>
                                                                @endif
                                                                @if (isset($log->details['action']))
                                                                    <strong>Hành động:</strong>
                                                                    {{ $log->details['action'] }}<br>
                                                                @endif
                                                            @else
                                                                {{ $log->details }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                                        <td>
                                                            <a href="{{ route('moderator.articles.moderation-history', $log->content_id) }}"
                                                                class="btn btn-info btn-sm">
                                                                <i class="fa fa-history"></i> Xem chi tiết
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <!-- Hiển thị các bài viết đang chờ duyệt -->
                                                @foreach ($paginatedPendingArticles as $article)
                                                    <tr class="table-warning">
                                                        <td>{{ $article->article_id }}</td>
                                                        <td>
                                                            <a href="{{ route('moderator.articles.show', $article->article_id) }}"
                                                                title="{{ $article->title }}">
                                                                {{ Str::limit($article->title, 30) }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-warning">Chờ duyệt</span>
                                                        </td>
                                                        <td>
                                                            <strong>Danh mục:</strong>
                                                            {{ $article->category->name ?? 'Không có' }}<br>
                                                            <strong>Tác giả:</strong>
                                                            {{ $article->author->username ?? 'Không có' }}
                                                        </td>
                                                        <td>{{ $article->created_at->format('d/m/Y H:i:s') }}</td>
                                                        <td>
                                                            <a href="{{ route('moderator.articles.show', $article->article_id) }}"
                                                                class="btn btn-primary btn-sm">
                                                                <i class="fa fa-eye"></i> Xem & duyệt
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Phân trang thủ công -->
                                    <div class="d-flex justify-content-end mt-4">
                                        <nav>
                                            <ul class="pagination">
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                                        <a class="page-link"
                                                            href="{{ route('moderator.articles.moderation-history.index', array_merge(request()->except('page'), ['page' => $i])) }}">
                                                            {{ $i }}
                                                        </a>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </nav>
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

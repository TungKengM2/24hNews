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
                        <h4 class="page-title">Lịch sử kiểm duyệt bài viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.articles.index') }}">Danh sách bài viết</a></li>
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
                                <h4 class="box-title">Thông tin bài viết</h4>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width: 150px">ID</th>
                                                <td>{{ $article->article_id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <td>{{ $article->title }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tác giả</th>
                                                <td>{{ $article->author->username ?? 'Không có thông tin' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Trạng thái</th>
                                                <td>
                                                    @if($article->status == 'published')
                                                        <span class="badge badge-success">Đã xuất bản</span>
                                                    @elseif($article->status == 'pending')
                                                        <span class="badge badge-warning">Chờ duyệt</span>
                                                    @elseif($article->status == 'draft')
                                                        <span class="badge badge-info">Bản nháp</span>
                                                    @elseif($article->status == 'rejected')
                                                        <span class="badge badge-danger">Đã từ chối</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $article->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Ngày tạo</th>
                                                <td>{{ $article->created_at->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        @if($article->thumbnail_url)
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}" class="img-fluid">
                                        @else
                                            <div class="alert alert-info">Không có hình ảnh</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <a href="{{ route('moderator.articles.show', $article) }}" class="btn btn-info">
                                            <i class="fa fa-arrow-left"></i> Quay lại chi tiết bài viết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Lịch sử kiểm duyệt</h4>
                            </div>
                            <div class="box-body">
                                @if($logs->isEmpty())
                                    <div class="alert alert-info">
                                        Chưa có lịch sử kiểm duyệt cho bài viết này.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Hành động</th>
                                                    <th>Người thực hiện</th>
                                                    <th>Chi tiết</th>
                                                    <th>Thời gian</th>
                                                    <th>Mức độ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($logs as $log)
                                                    <tr>
                                                        <td>{{ $log->log_id }}</td>
                                                        <td>
                                                            @if($log->action_type == 'approve')
                                                                <span class="badge badge-success">Phê duyệt</span>
                                                            @elseif($log->action_type == 'reject')
                                                                <span class="badge badge-danger">Từ chối</span>
                                                            @elseif($log->action_type == 'edit')
                                                                <span class="badge badge-info">Chỉnh sửa</span>
                                                            @elseif($log->action_type == 'flag')
                                                                <span class="badge badge-warning">Đánh dấu</span>
                                                            @elseif($log->action_type == 'delete')
                                                                <span class="badge badge-dark">Xóa</span>
                                                            @elseif($log->action_type == 'restore')
                                                                <span class="badge badge-primary">Khôi phục</span>
                                                            @elseif($log->action_type == 'auto_moderate')
                                                                <span class="badge badge-secondary">Tự động kiểm duyệt</span>
                                                            @else
                                                                <span class="badge badge-secondary">{{ $log->action_type }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($log->moderator)
                                                                {{ $log->moderator->username }}
                                                            @else
                                                                <span class="text-muted">Hệ thống</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(is_array($log->details))
                                                                @foreach($log->details as $key => $value)
                                                                    @if($key != 'title' && $key != 'author_id' && $key != 'category_id')
                                                                        <strong>{{ ucfirst($key) }}:</strong> 
                                                                        @if(is_array($value))
                                                                            {{ json_encode($value) }}
                                                                        @else
                                                                            {{ $value }}
                                                                        @endif
                                                                        <br>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                {{ $log->details }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                                        <td>
                                                            @if($log->severity == 'high')
                                                                <span class="badge badge-danger">Cao</span>
                                                            @elseif($log->severity == 'medium')
                                                                <span class="badge badge-warning">Trung bình</span>
                                                            @elseif($log->severity == 'low')
                                                                <span class="badge badge-info">Thấp</span>
                                                            @else
                                                                <span class="badge badge-secondary">Không</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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

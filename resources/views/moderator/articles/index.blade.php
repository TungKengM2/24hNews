@extends('moderator.layouts.master')

@section('title')
    Duyệt bài viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Duyệt bài viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('moderator.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết Chờ Duyệt</li>
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
                            <div>
                                <a href="{{ route('moderator.dashboard') }}" class="btn btn-default">
                                    <i class="fa fa-arrow-left me-1"></i> Quay Lại Trang Chủ
                                </a>
                            </div>
                            
                            <div class="d-flex">
                                <form method="GET" action="{{ route('moderator.articles.index') }}" class="me-2">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài viết..." 
                                            value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="box-body">
                            <div class="row mb-3">
                                <div class="col-md-6 text-end">
                                    <span class="badge bg-info">Tổng số: {{ $articles->total() }} bài viết</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0" style="width:100%">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Tiêu Đề</th>
                                            <th width="10%">Hình Ảnh</th>
                                            <th width="10%">Danh Mục</th>
                                            <th width="10%">Trạng Thái</th>
                                            <th width="10%">Tác Giả</th>
                                            <th width="10%">Lượt Xem</th>
                                            <th width="10%">Nội Dung Nhạy Cảm</th>
                                            <th width="20%">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($articles as $article)
                                            <tr>
                                                <td>{{ $article->article_id }}</td>
                                                <td>
                                                    <strong>{{ $article->title }}</strong>
                                                    <div class="small text-muted">{{ Str::limit($article->slug, 30) }}</div>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh" 
                                                        class="img-thumbnail" width="80" height="80">
                                                </td>
                                                <td>
                                                    @if ($article->category)
                                                        @if (!$article->category->is_active)
                                                            <span class="text-warning">{{ $article->category->name }} <i class="fa fa-exclamation-triangle"></i></span>
                                                        @else
                                                            <span class="badge bg-info">{{ $article->category->name }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-danger">Không có danh mục</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @switch($article->status)
                                                        @case('draft')
                                                            <span class="badge bg-secondary">Bản Nháp</span>
                                                            @break
                                                        @case('pending')
                                                            <span class="badge bg-warning">Chờ Duyệt</span>
                                                            @break
                                                        @case('published')
                                                            <span class="badge bg-success">Đã Đăng</span>
                                                            @break
                                                        @case('archived')
                                                            <span class="badge bg-danger">Đã Lưu Trữ</span>
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td>{{ $article->author->username ?? 'Chưa xác định' }}</td>
                                                <td class="text-center">{{ number_format($article->views) }}</td>
                                                <td class="text-center">
                                                    @if ($article->contains_sensitive_content)
                                                        <span class="badge bg-danger">Có</span>
                                                    @else
                                                        <span class="badge bg-success">Không</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                                        <a href="{{ route('moderator.articles.show', $article) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                            <i class="si-eye si"></i>
                                                        </a>

                                                        @if ($article->status === 'pending')
                                                            <form action="{{ route('moderator.articles.approve', $article) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm" title="Duyệt bài viết"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('moderator.articles.reject', $article) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Từ chối bài viết"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn từ chối bài viết này không?')">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                    
                                                    <div>
                                                        @if ($article->tags->isNotEmpty())
                                                            @foreach ($article->tags as $tag)
                                                                <span class="badge bg-primary">{{ $tag->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <small class="text-muted">Không có thẻ</small>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Không có bài viết nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-4">
                                    {{ $articles->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.master')

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
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Duyệt bài viết</li>
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
                        <div class="box-header">
                            <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                    href="{{ route('admin.dashboard') }}">
                                    Quay Lại Bảng Điều Khiển
                                </a></button>
                            <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                    href="{{ route('articles.create') }}">
                                    <i class="si-plus si"></i>
                                </a></button>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tiêu Đề</th>
                                            <th>Nội Dung Nhạy Cảm</th>
                                            <th>Tác Giả</th>
                                            <th>Danh Mục</th>
                                            <th>Hình Ảnh</th>
                                            <th>Trạng Thái</th>
                                            <th>Thẻ</th>
                                            <th>Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $article)
                                            <tr>
                                                <td>{{ $article->title }}</td>
                                                <td class="text-center">
                                                    @if ($article->contains_sensitive_content)
                                                        <span class="badge bg-danger">Có</span>
                                                    @else
                                                        <span class="badge bg-success">Không</span>
                                                    @endif
                                                </td>
                                                <td>{{ $article->author->username ?? 'Chưa xác định' }}</td>
                                                <td>{{ $article->category->name ?? 'Chưa phân loại' }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh" width="100" height="150">
                                                </td>
                                                <td>
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
                                                <td>
                                                    @if ($article->tags->isNotEmpty())
                                                        @foreach ($article->tags as $tag)
                                                            <span class="badge bg-primary">{{ $tag->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Không có thẻ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                                        <i class="si-eye si"></i>
                                                    </a>

                                                    @if ($article->status === 'pending')
                                                        <form action="{{ route('articles.approve', $article) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-success btn-sm" title="Duyệt bài viết"
                                                                onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                                Duyệt
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('articles.reject', $article) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Từ chối bài viết"
                                                                onclick="return confirm('Bạn có chắc chắn muốn từ chối bài viết này không?')">
                                                                Từ Chối
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                                    <nav>
                                        <ul class="pagination pagination-sm">
                                            {{ $articles->links('pagination::bootstrap-5') }}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

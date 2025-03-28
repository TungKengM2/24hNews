@extends('author.layouts.master')
@section('title')
    Chi Tiết Bài Viết
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Chi Tiết Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('author.articles.index') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Chi Tiết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <div class="content">
                <div class="container-full">
                    <div class="card">
                        <div class="card-img-top">
                            <h5 class="card-title">Ảnh đại diện:
                                <div class="thumbnail">
                                    @if ($article->thumbnail_url)
                                        <div class="mb-3">
                                            <br>
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện"
                                                 class="img-thumbnail" style="max-width: 100px;">
                                        </div>
                                    @endif
                                </div>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <h6 class="card-title">Tiêu đề: {{ $article->title }}</h6>
                                <h6 class="card-title">Đường dẫn: {{ $article->slug }}</h6>
                                <h6 class="card-title">Chứa nội dung nhạy cảm:
                                    {{ $article->contains_sensitive_content ? 'Có' : 'Không' }}</h6>
                                <h6 class="card-title">Tác giả: {{ $article->author->username ?? 'Không có' }}</h6>
                                <h6 class="card-title">Danh mục: {{ $article->category->name ?? 'Không có' }}</h6>
                                <h6 class="card-title">Trạng thái: {{ ucfirst($article->status) }}</h6>
                                <h6 class="card-title">Lượt xem: {{ $article->views }}</h6>
                                <h6 class="card-title">Được duyệt bởi: {{ $article->approver->username ?? 'Chưa được duyệt' }}</h6>
                                <h6 class="card-title">Thẻ:
                                    <div class="tags">
                                        @if ($article->tags->isNotEmpty())
                                            @foreach ($article->tags as $tag)
                                                <span class="badge bg-primary">{{ $tag->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Không có thẻ</span>
                                        @endif
                                    </div>
                                </h6>
                            </div>
                            <p class="card-text">Nội dung xem trước:</p>
                        </div>
                        <div class="card-footer justify-content-between d-flex">
                            <div class="box-body">
                                <div id="slimtest2">
                                    <div class="row">
                                        <h5 class="card-text">Nội dung xem trước: {{ $article->preview_content }}</h5>
                                        <div class="col-md-7">
                                            <p>{!! $article->content !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="waves-effect waves-light btn btn-default mb-5">
                                <a href="{{ route('author.articles.index') }}">
                                    Quay lại
                                </a>
                            </button>
                            <a href="{{ route('author.articles.edit', $article) }}" class="btn btn-warning btn-sm">
                                <i class="si-pencil si"></i>
                            </a>
                            <form action="{{ route('author.articles.destroy', $article) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                    <i class="si-trash si"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Chi tiết bài viết - {{ $article->title }}</h4>
                    <div class="box-tools">
                        <div class="btn-group">
                            <a href="{{ route('author.articles.versions', $article) }}" class="btn btn-info btn-sm me-2">
                                <i class="si-history si"></i> Lịch sử phiên bản
                            </a>
                            <a href="{{ route('author.articles.edit', $article) }}" class="btn btn-warning btn-sm me-2">
                                <i class="si-pencil si"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('author.articles.index') }}" class="btn btn-default btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <!-- Article Information -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Thông tin bài viết</h4>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px">Mã bài viết:</th>
                                            <td>{{ $article->code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tiêu đề:</th>
                                            <td>{{ $article->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Đường dẫn:</th>
                                            <td>{{ $article->slug }}</td>
                                        </tr>
                                        <tr>
                                            <th>Danh mục:</th>
                                            <td>{{ $article->category ? $article->category->name : 'Không có danh mục' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Thẻ:</th>
                                            <td>
                                                @foreach($article->tags as $tag)
                                                    <span class="badge bg-info me-1">{{ $tag->name }}</span>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Trạng thái:</th>
                                            <td>
                                                @switch($article->status)
                                                    @case('draft')
                                                        <span class="badge bg-secondary">Bản nháp</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">Chờ duyệt</span>
                                                        @break
                                                    @case('published')
                                                        <span class="badge bg-success">Đã xuất bản</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge bg-danger">Đã ẩn</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $article->status }}</span>
                                                @endswitch
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ngày tạo:</th>
                                            <td>{{ $article->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cập nhật lần cuối:</th>
                                            <td>{{ $article->updated_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Ảnh đại diện</h4>
                                </div>
                                <div class="box-body text-center">
                                    @if($article->thumbnail_url)
                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                             alt="Ảnh đại diện"
                                             class="img-fluid rounded"
                                             style="max-height: 300px;">
                                    @else
                                        <p class="text-muted">Không có ảnh đại diện</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Content -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">Nội dung bài viết</h4>
                                </div>
                                <div class="box-body">
                                    <div class="content-preview border rounded p-3 bg-light">
                                        {!! $article->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .content-preview img {
            max-width: 100%;
            height: auto;
        }
        .badge {
            font-size: 0.9em;
            padding: 5px 10px;
        }
    </style>
@endsection

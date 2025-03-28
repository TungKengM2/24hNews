@extends('admin.layouts.master')

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
                                    <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
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
                    <h4 class="box-title">Chi Tiết Bài Viết</h4>
                </div>
                <div class="box-body">
                    <div id="slimtest2">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="col-md-12 p-3 ">
                                    <p><i class="mdi mdi-title"></i> <strong>Tiêu đề:</strong> {{ $article->title }}</p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 p-3 ">

                                    <p><i class="mdi mdi-link-variant"></i> <strong>Đường dẫn:</strong> {{ $article->slug }}</p>
                                </div>
                            </div>
                        </div>

                        <p class="col-md-5 mx-3"><strong>Nội dung tóm tắt:</strong> {{ $article->preview_content }}</p>
                        <div class="bg-white p-3 m-2">
                            <p class="col-md-5 text-bold">Nội dung:</p>
                            <div class="col-md-7 mb-3">
                                <p>{!! $article->content !!}</p>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mx-2" >
                           <div class="row">
                            @if ($article->thumbnail_url)
                            <div class="mb-3 col-md-4">
                                <strong>Ảnh đại diện:</strong>
                                <br>
                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện"
                                     class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                        <div class="col-md-4">
                            <div class="d-flex ">
                                <strong>Chứa nội dung nhạy cảm?</strong>
                                <p>{{ $article->contains_sensitive_content ? 'Có' : 'Không' }}</p>
                            </div>

                            <div class="d-flex ">
                                <strong>Tác giả:</strong>
                                <p>{{ $article->author->username ?? 'Không có' }}</p>
                            </div>

                            <div class="d-flex ">
                                <strong>Danh mục:</strong>
                                <p>{{ $article->category->name ?? 'Không có' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex">
                                <strong>Trạng thái:</strong>
                                <p>{{ ucfirst($article->status) }}</p>
                            </div>

                            <div class="d-flex">
                                <strong>Lượt xem:</strong>
                                <p>{{ $article->views }}</p>
                            </div>

                            <div class="d-flex">
                                <strong>Được duyệt bởi:</strong>
                                <p>{{ $article->approver->username ?? 'Chưa được duyệt' }}</p>
                            </div>
                        </div>
                           </div>
                        </div>



                        <div class="mt-4">
                            <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                    href="{{ route('articles.index') }}">
                                    Quay lại
                                </a></button>
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm"><i
                                    class="si-pencil si"></i></a>
                            <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
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

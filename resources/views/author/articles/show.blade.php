@extends('author.layouts.master')

@section('content')

        <!-- Content Wrapper. Contains page content -->
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
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
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
                        <h4 class="box-title">Title: {{ $article->title }}</h4> <br>
                        <h6 class="box-title mt-2">Slug: {{ $article->slug }}</h6>
                    </div>
                    <div class="box-body">
                        <div id="slimtest2">
                            <div class="row">

                                <p class="col-md-5">Preview Content: {{ $article->preview_content }}</p>
                                <div class="row">
                                    <p class="col-md-5">Content:</p>
                                    <div class="col-md-7">
                                        <p>{!! $article->content !!}</p>
                                    </div>
                                </div>

                                <div>
                                    @if ($article->thumbnail_url)
                                        <div class="mb-3">
                                            <strong>Thumbnail:</strong>
                                            <br>
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail"
                                                class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="row" style="margin-top: 50px">

                                    <div class="col-2">
                                        <strong>Contains Sensitive Content?</strong>
                                        <p>{{ $article->contains_sensitive_content ? 'Yes' : 'No' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Author:</strong>
                                        <p>{{ $article->author->username ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Category:</strong>
                                        <p>{{ $article->category->name ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Status:</strong>
                                        <p>{{ ucfirst($article->status) }}</p>

                                    </div>

                                    <div class="col-2">
                                        <strong>Views:</strong>
                                        <p>{{ $article->views }}</p>

                                    </div>

                                    <div class="col-2">
                                        <strong>Approved By:</strong>
                                        <p>{{ $article->approver->username ?? 'Not Approved' }}</p>
                                    </div>


                                </div>

                                <div class="mt-4">
                                    <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                            href="{{ route('articles.index') }}">
                                            Back to Dashboard
                                        </a></button>
                                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm"><i
                                            class="si-pencil si"></i></a>
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST"
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
        </div>

@endsection
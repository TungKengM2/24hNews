@extends('author.layouts.master')

@section('title')
    Danh Sách Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Danh Sách Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                    <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-full">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-secondary btn-sm">
                                <a href="{{ route('author.dashboard') }}" class="text-white">Back to Dashboard</a>
                            </button>
                            <a href="{{ route('author.articles.create') }}" class="btn btn-primary btn-sm">
                                <i class="si-plus si"></i> Thêm bài viết
                            </a>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th class="text-center">Contains Sensitive Content</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Thumbnail</th>
                                        <th class="text-center">Status</th>
                                        <th>Views</th>
                                        <th>Tags</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ $article->article_id }}</td>
                                            <td>{{ $article->title }}</td>
                                            <td>{{ $article->slug }}</td>
                                            <td class="text-center">
                                                @if ($article->contains_sensitive_content)
                                                    <span class="badge bg-danger">Yes</span>
                                                @else
                                                    <span class="badge bg-success">No</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->author->username ?? 'Unknown' }}</td>
                                            <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                     alt="Thumbnail" width="100" height="150">
                                            </td>
                                            <td class="text-center">
                                                @switch($article->status)
                                                    @case('draft')
                                                        <span class="badge bg-secondary">Draft</span>
                                                        @break
                                                    @case('pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                        @break
                                                    @case('published')
                                                        <span class="badge bg-success">Published</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge bg-danger">Archived</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $article->views }}</td>
                                            <td>
                                                @if ($article->tags->isNotEmpty())
                                                    @foreach ($article->tags as $tag)
                                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có tag</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('author.articles.show', $article) }}"
                                                   class="btn btn-info btn-sm"><i class="si-eye si"></i></a>
                                                <a href="{{ route('author.articles.edit', $article) }}"
                                                   class="btn btn-warning btn-sm"><i class="si-pencil si"></i></a>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="deleteArticle({{ $article->article_id }})">
                                                    <i class="si-trash si"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
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

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
                            @if (session('success'))
                                <div class="alert alert-success">
                                {{ session('success') }}
                                </div>
                            @endif


                            <div class="d-flex">
                                <form method="GET" action="{{ route('author.articles.index') }}" class="me-2">
                                    <div class="d-flex align-items-center">
                                        <label for="filter" class="me-2">Lọc bài viết:</label>
                                        <select name="filter" class="form-control w-auto" onchange="this.form.submit()">
                                            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Tất
                                                cả bài viết
                                            </option>
                                            <option
                                                value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Bài
                                                viết có danh mục hoạt động
                                            </option>
                                            <option
                                                value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>
                                                Bài viết có danh mục bị vô hiệu hóa
                                            </option>
                                            <option
                                                value="no_category" {{ request('filter') == 'no_category' ? 'selected' : '' }}>
                                                Bài viết không có danh mục
                                            </option>
                                        </select>
                                    </div>
                                </form>

                                <a href="{{ route('author.articles.create') }}" class="btn btn-primary btn-sm">
                                    <i class="si-plus si"></i> Thêm bài viết
                                </a>
                            </div>
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
                                            <td>
                                                @if ($article->category)
                                                    @if (!$article->category->is_active)
                                                        <span class="text-warning">{{$article->category->name}} (Không Hoạt Động)</span>
                                                    @else
                                                        {{ $article->category->name }}
                                                    @endif
                                                @else
                                                    <span class="text-danger">Không có danh mục</span>
                                                @endif
                                            </td>
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

                                                    <form action="{{ route('author.articles.destroy', $article) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                            <i class="si-trash si"></i>
                                                        </button>
                                                    </form>
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
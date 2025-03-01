@extends('author.layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Danh Sách Bài Viết</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                            class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết</li>
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
                                Back to Dashboard
                            </a></button>
                        <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                href="{{ route('author.articles.create') }}">
                                <i class="si-plus si"></i>
                            </a></button>

                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="complex_header" class="table table-striped table-bordered display"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Contains Sensitive Content</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Thumbnail</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Tags</th>
                                        <th>Approved By</th>
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
                                            <td>
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
                                                        <span
                                                            class="badge bg-primary">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có tag</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->approved_by ? $article->approver->username : 'Not Approved' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('author.articles.show', $article) }}"
                                                    class="btn btn-info btn-sm"><i class="si-eye si"></i></a>

                                                <a href="{{ route('author.articles.edit', $article) }}"
                                                    class="btn btn-warning btn-sm"><i
                                                        class="si-pencil si"></i></a>

                                                @if ($article->status === 'pending')
                                                    <form action="{{ route('articles.approve', $article) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('articles.destroy', $article) }}"
                                                    method="POST" class="d-inline">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- /.content-wrapper -->
@endsection
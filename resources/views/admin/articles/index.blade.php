<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div class="wrapper" >
        @include('admin.layouts.partials.menusidebar')
        <div class="main">
            @include('admin.layouts.partials.header')
            <main class="content px-3 py-4">
                <div class="container-fluid">
                    <div class="mb-3">


                        <h3 class="fw-bold fs-4 my-3">Avg. Agent Earnings
                        </h3>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h1>Thêm mới bài viết</h1>
                                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                    <i class="lni lni-arrow-left"></i> Back to Dashboard
                                </a>
                                <a class="btn btn-primary" href="{{ route('articles.create') }}">
                                    <i class="lni lni-plus"></i>
                                </a>

                            </div>
                            <div class="col-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr class="highlight">
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Content</th>
                                            <th>Preview Content</th>
                                            <th>Contains Sensitive Content</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Thumbnail</th>
                                            <th>Status</th>
                                            <th>Views</th>
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
                                                <td>{{ Str::limit($article->content, 50) }}</td>
                                                <td>{{ Str::limit($article->preview_content, 50) }}</td>
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
                                                        alt="Thumbnail" width="100" height="200">

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
                                                <td>{{ $article->approved_by ? $article->approver->username : 'Not Approved' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('articles.show', $article) }}"
                                                        class="btn btn-info btn-sm">Show</a>
                                                    <a href="{{ route('articles.edit', $article) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>

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

                                                    <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $articles->Links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>

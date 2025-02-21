<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Detail</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Chi tiết bài viết</h2>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Title: {{ $article->title }}</h3>
                <p class="text-muted">Slug: {{ $article->slug }}</p>

            <div class="card mx-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="lni lni-text-format"></i> <strong>Title:</strong> {{ $article->title }}</p>
                            <p><i class="lni lni-link"></i> <strong>Slug:</strong> {{ $article->slug }}</p>
                            <p><i class="lni lni-user"></i> <strong>Author:</strong> {{ $article->author->username ?? 'N/A' }}</p>
                            <p><i class="lni lni-folder"></i> <strong>Category:</strong> {{ $article->category->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="lni lni-checkmark"></i> <strong>Status:</strong> {{ ucfirst($article->status) }}</p>
                            <p><i class="lni lni-eye"></i> <strong>Views:</strong> {{ $article->views }}</p>
                            <p><i class="lni lni-thumbs-up"></i> <strong>Approved By:</strong> {{ $article->approver->username ?? 'Not Approved' }}</p>
                            <p><i class="lni lni-warning"></i> <strong>Contains Sensitive Content?</strong> {{ $article->contains_sensitive_content ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>Contains Sensitive Content?</strong>
                    <p>{{ $article->contains_sensitive_content ? 'Yes' : 'No' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Author:</strong>
                    <p>{{ $article->author->username ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Category:</strong>
                    <p>{{ $article->category->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <p>{{ ucfirst($article->status) }}</p>
                </div>

                <div class="mb-3">
                    <strong>Views:</strong>
                    <p>{{ $article->views }}</p>
                </div>

                <div class="mb-3">
                    <strong>Approved By:</strong>
                    <p>{{ $article->approver->username ?? 'Not Approved' }}</p>
                </div>

                @if ($article->thumbnail_url)
                    <div class="mb-3">
                        <strong><i class="lni lni-pencil"></i> Content:</strong>
                        <div class="border p-3" style="width: 100%; min-height: 300px;">{!! $article->content !!}</div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to List</a>

                    <div class="mt-4">
                        <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary"><i class="lni lni-pencil"></i> Edit</a>
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary"><i class="lni lni-list"></i> Back to List</a>

                        <form action="{{ route('articles.destroy', $article->article_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="lni lni-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

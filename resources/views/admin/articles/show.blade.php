<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-display img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Chi tiết bài viết</h2>

        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Title: {{ $article->title }}</h3>
                <p class="text-muted">Slug: {{ $article->slug }}</p>

                <div class="mb-3 content-display">
                    <strong>Content:</strong>
                    <div>{!! $article->content !!}</div>
                </div>

                @if ($article->preview_content)
                    <div class="mb-3">
                        <strong>Preview Content:</strong>
                        <p>{{ $article->preview_content }}</p>
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
                        <strong>Thumbnail:</strong>
                        <br>
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to List</a>

                    <form action="{{ route('articles.destroy', $article->article_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

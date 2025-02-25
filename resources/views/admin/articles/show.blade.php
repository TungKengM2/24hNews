<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-display img {
            max-width: 100%;
            height: auto;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .thumbnail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .tag-badge {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h2 class="mb-4">Chi tiết bài viết</h2>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Thông tin bài viết</div>
            <div class="card-body">
                <h3 class="card-title">{{ $article->title }}</h3>
                <p class="text-muted">Slug: {{ $article->slug }}</p>

                @if ($article->thumbnail_url)
                    <div class="mb-3 text-center thumbnail">
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail" class="img-fluid">
                    </div>
                @endif

                <div class="mb-3 content-display">
                    <strong>Nội dung bài viết:</strong>
                    <div>{!! $article->content !!}</div>
                </div>

                @if ($article->preview_content)
                    <div class="mb-3">
                        <strong>Mô tả ngắn:</strong>
                        <p>{{ $article->preview_content }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>Nội dung nhạy cảm:</strong>
                    <p>{{ $article->contains_sensitive_content ? 'Có' : 'Không' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Tác giả:</strong>
                        <p>{{ $article->author->username ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Danh mục:</strong>
                        <p>{{ $article->category->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Trạng thái:</strong>
                        <p><span class="badge bg-info text-dark">{{ ucfirst($article->status) }}</span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Lượt xem:</strong>
                        <p>{{ $article->views }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Người duyệt:</strong>
                    <p>{{ $article->approver->username ?? 'Chưa duyệt' }}</p>
                </div>

                @if ($article->tags->count() > 0)
                    <div class="mb-3">
                        <strong>Tags:</strong>
                        <div>
                            @foreach ($article->tags as $tag)
                                <span class="tag-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary">
                        <i class="lni lni-pencil"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                        <i class="lni lni-list"></i> Quay lại danh sách
                    </a>

                    <form action="{{ route('articles.destroy', $article->article_id) }}" method="POST"
                        class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="lni lni-trash-can"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            margin: 0px;
        }

        .container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 300px;
        }

        .form-label {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.menu')
        <div class="container mt-5">
            <div class="card p-4">
                <h2 class="mb-4">Chỉnh sửa bài viết</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $article->slug) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea id="content" name="content" class="form-control" required>{{ old('content', $article->content) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                    <div class="mb-3">
                        <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                        <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                        @if ($article->thumbnail_url)
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail" width="100">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Trạng thái</label>
                        <select class="form-control" name="status" required>
                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="pending" {{ $article->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                            <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("title").addEventListener("input", function() {
            let title = this.value.trim();
            let slug = title.toLowerCase()
                .normalize("NFD").replace(/[̀-ͯ]/g, "")
                .replace(/đ/g, "d").replace(/Đ/g, "D")
                .replace(/\s+/g, "-")
                .replace(/[^\w-]/g, "")
                .replace(/--+/g, "-")
                .replace(/^-+|-+$/g, "");
            document.getElementById("slug").value = slug;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

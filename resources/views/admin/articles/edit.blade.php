<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">


</head>

<body>
    <div class="wrapper">
<<<<<<< HEAD
        @include('admin.layouts.partials.menusidebar')
        <div class="main">
            @include('admin.layouts.partials.header')
=======
        @include('admin.menu')
        <div class="container mt-5">
>>>>>>> a1d5130132ec68db69e96f865df4f85cc957fc2a
            <div class="card p-2">
                <h2 class="mb-4">Update Post</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                    id="articleForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $article->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                            value="{{ $article->slug }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <div id="editor"></div>
                        <textarea id="content" name="content" style="display: none;">{!! $article->content !!}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Tự động gán tác giả -->
                    <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                    <div class="mt-3">
                        <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                        <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                        @if ($article->thumbnail_url)
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail"
                                width="100">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>

                <script>
                    document.getElementById('articleForm').addEventListener('submit', function() {
                        document.getElementById('content').value = document.getElementById('editor').innerHTML;
                    });
                </script>
              <script>
                document.getElementById("title").addEventListener("input", function() {
                    let title = this.value.trim();
                    let slug = title.toLowerCase()
                        .normalize("NFD").replace(/[̀-ͯ]/g, "") // Loại bỏ dấu tiếng Việt
                        .replace(/đ/g, "d").replace(/Đ/g, "D")
                        .replace(/\s+/g, "-") // Thay dấu cách bằng "-"
                        .replace(/[^\w-]/g, "") // Xóa ký tự đặc biệt
                        .replace(/--+/g, "-") // Loại bỏ nhiều dấu "-" liên tiếp
                        .replace(/^-+|-+$/g, ""); // Xóa "-" ở đầu và cuối

                    document.getElementById("slug").value = slug;
                });

                document.getElementById('articleForm').addEventListener('submit', function() {
                    document.getElementById('content').value = document.getElementById('editor').innerHTML;
                });
            </script>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

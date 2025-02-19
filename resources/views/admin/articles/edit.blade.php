<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
        <div class="container">
            <h1>Chỉnh sửa bài viết</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleEditForm">
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
                    <textarea id="editor" name="content">{{ old('content', $article->content) }}</textarea>
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
            
                <div class="mb-3">
                    <label for="thumbnail_url" class="form-label">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url" accept="image/*">
                    @if ($article->thumbnail_url)
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện" class="mt-2" width="200">
                    @endif
                </div>
            
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="contains_sensitive_content" name="contains_sensitive_content" value="1"
                        {{ $article->contains_sensitive_content ? 'checked' : '' }}>
                    <label class="form-check-label" for="contains_sensitive_content">Nội dung nhạy cảm</label>
                </div>
            
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
            
            {{-- Scripts --}}
         <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // Kích hoạt CKEditor
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('Lỗi CKEditor:', error);
        });

    // Tạo slug tự động khi nhập tiêu đề
    document.getElementById("title").addEventListener("input", function () {
        let title = this.value.trim();
        let slug = title.toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
            .replace(/đ/g, "d").replace(/Đ/g, "D")
            .replace(/\s+/g, "-")
            .replace(/[^\w-]/g, "")
            .replace(/--+/g, "-")
            .replace(/^-+|-+$/g, "");

        document.getElementById("slug").value = slug;
    });

    // Cảnh báo rời trang nếu có chỉnh sửa
    let isFormEdited = false;
    document.getElementById('articleEditForm').addEventListener('input', function () {
        isFormEdited = true;
    });

    window.addEventListener('beforeunload', function (e) {
        if (isFormEdited) {
            e.returnValue = 'Bạn có chắc chắn muốn rời khỏi trang? Những thay đổi chưa được lưu sẽ bị mất.';
        }
    });
</script>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>

<div class="mt-3"><label class="form-label" for="category_id">Category</label>
    <select class="form-select" name="category_id" id="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->category_id }}"
                {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

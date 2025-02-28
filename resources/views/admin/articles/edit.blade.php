@extends('admin.layouts.master')

<<<<<<< HEAD
@section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h4 class="page-title">Cập Nhập Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                        <li class="breadcrumb-item active" aria-current="page">Cập Nhập</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
        }

        .container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 300px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.menu')
        <div class="container mt-5">
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
>>>>>>> tungkeng

                <!-- Main content -->
                <div class="card p-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

<<<<<<< HEAD
                    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                        id="articleForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $article->title }}" required>
                        </div>
=======
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                            value="{{ $article->slug }}" required>
                    </div>
>>>>>>> tungkeng

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $article->slug }}" required>
                        </div>

<<<<<<< HEAD
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung</label>
                            <textarea id="content" name="content" class="form-control">{!! $article->content !!}</textarea>
                        </div>
=======
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div class="d-flex flex-wrap">
                            @foreach ($tags as $tag)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                        value="{{ $tag->tag_id }}"
                                        {{ in_array($tag->tag_id, $article->tags->pluck('tag_id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thêm Tags mới (cách nhau bởi dấu phẩy)</label>
                        <input type="text" class="form-control" name="new_tags" placeholder="Tag1, Tag2, Tag3">
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
>>>>>>> tungkeng

                        <div class="mb-3">
                            <label class="form-label">Chọn hoặc thêm tags:</label>
                            <select name="tags[]" class="form-control select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->tag_id }}"
                                        @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

<<<<<<< HEAD

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



                        <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                        <div class="mt-3">
                            <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                            <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                            @if ($article->thumbnail_url)
                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail"
                                    width="100">
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                    </form>
                </div>
=======
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
>>>>>>> tungkeng

                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            tags: true,
                            tokenSeparators: [','],
                            placeholder: "Chọn hoặc nhập tags mới",
                            allowClear: true
                        });
                    });
<<<<<<< HEAD

=======
                </script>
                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            placeholder: "Chọn tags...",
                            allowClear: true
                        });
                    });
                </script>
                <script>
>>>>>>> tungkeng
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
            </div>
        </div>

<<<<<<< HEAD

                <!-- /.content-wrapper -->    
@endsection
=======
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
>>>>>>> tungkeng

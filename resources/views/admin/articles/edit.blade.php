<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
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
<<<<<<< HEAD
        @include('admin.menu')
        <div class="container">
            <h1>Chỉnh sửa bài viết</h1>
=======
        @include('admin.layouts.partials.menusidebar')
        <div class="main">
            @include('admin.layouts.partials.header')
            <h1 class="mb-4">Chỉnh sửa bài viết</h1>
>>>>>>> c4fb09e72b4073f0818a85d1413b6074debe5c8d

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-text-format"></i> Title</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title', $article->title) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-link"></i> Slug</label>
                        <input class="form-control" type="text" name="slug" value="{{ old('slug', $article->slug) }}" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label"><i class="lni lni-pencil"></i> Content</label>
                    <textarea class="form-control" name="content" required>{{ old('content', $article->content) }}</textarea>
                </div>

                <div class="mt-3">
                    <label class="form-label"><i class="lni lni-eye"></i> Preview Content</label>
                    <textarea class="form-control" name="preview_content">{{ old('preview_content', $article->preview_content) }}</textarea>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-warning"></i> Contains Sensitive Content?</label>
                        <select class="form-control" name="contains_sensitive_content" required>
                            <option value="0" {{ old('contains_sensitive_content', $article->contains_sensitive_content) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('contains_sensitive_content', $article->contains_sensitive_content) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-user"></i> Author</label>
                        <select class="form-select" name="author_id" required>
                            @foreach ($authors as $user)
                                <option value="{{ $user->user_id }}" {{ $article->author_id == $user->user_id ? 'selected' : '' }}>
                                    {{ $user->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-folder"></i> Category</label>
                        <select class="form-select" name="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-image"></i> Thumbnail</label>
                        @if ($article->thumbnail_url)
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail" width="100" class="d-block mb-2">
                        @endif
                        <input class="form-control" type="file" name="thumbnail_url">
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-checkmark"></i> Status</label>
                        <select class="form-select" name="status" required>
                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending" {{ $article->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><i class="lni lni-eye"></i> Views</label>
                        <input class="form-control" type="number" name="views" value="{{ old('views', $article->views) }}" min="0">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label"><i class="lni lni-thumbs-up"></i> Approved By</label>
                    <select class="form-select" name="approved_by">
                        <option value="">Not Approved</option>
                        @foreach ($authors as $user)
                            <option value="{{ $user->user_id }}" {{ $article->approved_by == $user->user_id ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update</button>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

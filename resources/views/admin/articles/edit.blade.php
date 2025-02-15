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
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div class="wrapper">
        @include('admin.layouts.partials.menusidebar')
        <div class="main p-2">
            @include('admin.layouts.partials.header')
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

            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mt-3">
                    <label class="form-label" for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="slug">Slug</label>
                    <input class="form-control" type="text" name="slug" id="slug"
                        value="{{ old('slug', $article->slug) }}" required>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="content">Content</label>
                    <textarea class="form-control" name="content" id="content" required>{{ old('content', $article->content) }}</textarea>
                </div>


                <div class="mt-3">
                    <label class="form-label" for="preview_content">Preview Content</label>
                    <textarea class="form-control" name="preview_content" id="preview_content">{{ old('preview_content', $article->preview_content) }}</textarea>
                </div>


                <div class="mt-3">
                    <label for="contains_sensitive_content" class="form-label">Contains Sensitive Content?</label>
                    <select class="form-control" id="contains_sensitive_content" name="contains_sensitive_content"
                        required>
                        <option value="0"
                            {{ old('contains_sensitive_content', $article->contains_sensitive_content) == 0 ? 'selected' : '' }}>
                            No</option>
                        <option value="1"
                            {{ old('contains_sensitive_content', $article->contains_sensitive_content) == 1 ? 'selected' : '' }}>
                            Yes</option>
                    </select>
                </div>


                <div class="mt-3">
                    <label class="form-label" for="author_id">Author</label>
                    <select class="form-select" name="author_id" id="author_id" required>
                        @foreach ($authors as $user)
                            <option value="{{ $user->user_id }}"
                                {{ $article->author_id == $user->user_id ? 'selected' : '' }}>
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                </div>


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


                <div class="mt-3">
                    <label class="form-label" for="thumbnail_url">Thumbnail</label>
                    @if ($article->thumbnail_url)
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail"
                            width="100">
                    @endif
                    <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                </div>


                <div class="mt-3"> <label class="form-label" for="status">Status</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="pending" {{ $article->status == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>
                            Published
                        </option>
                        <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>
                            Archived</option>
                    </select>
                </div>


                <div class="mt-3"><label class="form-label" for="views">Views</label>
                    <input class="form-control" type="number" name="views" id="views"
                        value="{{ old('views', $article->views) }}" min="0">
                </div>


                <div class="mt-3">
                    <label class="form-label" for="approved_by">Approved By</label>
                    <select class="form-select" name="approved_by" id="approved_by">
                        <option value="">Not Approved</option>
                        @foreach ($authors as $user)
                            <option value="{{ $user->user_id }}"
                                {{ $article->approved_by == $user->user_id ? 'selected' : '' }}>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

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
        <div class="main">
            @include('admin.layouts.partials.header')
            <div class="card p-2">
                <h2 class="mb-4">Create New Post</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group form-group-full">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="lni lni-text-format"></i>
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="col-md-6">
                                <i class="lni lni-link"></i>
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="lni lni-user"></i>
                                <label class="form-label">Author</label>
                                <select name="author_id" class="form-control" required>
                                    <option value="">-- Chọn tác giả --</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->user_id }}">{{ $author->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <i class="lni lni-grid-alt"></i>
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <i class="lni lni-pencil"></i>
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        <input type="file" id="fileInput" accept=".docx" style="margin-top: 10px;">
                    </div>

                    <div class="form-group form-group-full">
                        <i class="lni lni-text-format"></i>
                        <label for="preview_content" class="form-label">Preview Content</label>
                        <textarea class="form-control" id="preview_content" name="preview_content" rows="3" required></textarea>
                    </div>

                    <div class="form-group form-group-full">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="lni lni-image"></i>
                                <label for="thumbnail_url" class="form-label">Thumbnail Url</label>
                                <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url" required>
                            </div>
                            <div class="col-md-6">
                                <i class="lni lni-checkmark-circle"></i>
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-full">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="lni lni-eye"></i>
                                <label class="form-label">Views</label>
                                <input type="number" name="views" class="form-control" value="0">
                            </div>
                            <div class="col-md-6">
                                <i class="lni lni-checkmark"></i>
                                <label class="form-label">Approved By</label>
                                <select name="approved_by" class="form-control">
                                    <option value="">Not Approved</option>
                                    @if (isset($approvers) && $approvers->count() > 0)
                                        @foreach ($approvers as $approver)
                                            <option value="{{ $approver->user_id }}">{{ $approver->username }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
        <script>
            document.getElementById('fileInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const arrayBuffer = e.target.result;
                        mammoth.extractRawText({
                                arrayBuffer: arrayBuffer
                            })
                            .then(function(result) {
                                document.getElementById('content').value = result.value;
                            })
                            .catch(function(error) {
                                console.error('Error reading file:', error);
                            });
                    };
                    reader.readAsArrayBuffer(file);
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</body>

</html>

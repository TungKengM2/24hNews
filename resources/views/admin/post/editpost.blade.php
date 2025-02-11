<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
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
            padding: 2rem;
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
        <h2 class="mb-4">Edit Post</h2>
        <form action="/admin/post/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="preview_content" class="form-label">Preview Content</label>
                <textarea class="form-control" id="preview_content" name="preview_content" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="sensitive_content" class="form-label">Contains Sensitive Content</label>
                <select class="form-control" id="sensitive_content" name="sensitive_content" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="news">News</option>
                    <option value="sports">Sports</option>
                    <option value="entertainment">Entertainment</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
            </div>
            <div class="mb-3">
                <label for="word_document" class="form-label">Upload Word Document</label>
                <input type="file" class="form-control" id="word_document" name="word_document" accept=".doc,.docx">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

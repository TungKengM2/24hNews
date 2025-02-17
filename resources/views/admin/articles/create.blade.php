<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css"/>

    <link rel="stylesheet"
          href="https://cdn.ckeditor.com/ckeditor5-premium-features/44.2.0/ckeditor5-premium-features.css"/>
    {{--    <script src="https://cdn.ckbox.io/ckbox/2.6.1/ckbox.js" crossorigin></script>--}}
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
    <div class="container mt-5 ">
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
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" required>
                </div>
                <div class="mb-3" style="height: auto; width: auto">
                    <label for="content" class="form-label">Content</label>
                    <div id="editor">
                        <p>Hello from CKEditor 5!</p>
                    </div>
                    <textarea id="content" name="content" style="display: none;"></textarea>
                    <input type="file" id="fileInput" accept=".docx" style="margin-top: 10px;">
                </div>
                {{--                <div class="mb-3">--}}
                {{--                    <label for="preview_content" class="form-label">Preview Content</label>--}}
                {{--                    <textarea class="form-control" id="preview_content" name="preview_content" rows="3"--}}
                {{--                              required></textarea>--}}
                {{--                </div>--}}
                <div class="mb-3">
                    <label for="contains_sensitive_content" class="form-label">Contains Sensitive Content?</label>
                    <select class="form-control" id="contains_sensitive_content" name="contains_sensitive_content"
                            required>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Author</label>
                    <select name="author_id" class="form-control" required>
                        <option value="">-- Chọn tác giả --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->user_id }}">{{ $author->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="thumbnail_url" class="form-label">Thumbnail Url</label>
                    <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="draft">Draft</option>
                        <option value="pending">Pending</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Views</label>
                    <input type="number" name="views" class="form-control" value="0">
                </div>
                <div class="mb-3">
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
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
<script>
    document.getElementById('fileInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const arrayBuffer = e.target.result;
                mammoth.extractRawText({
                    arrayBuffer: arrayBuffer,
                })
                    .then(function (result) {
                        document.getElementById('editor').innerHTML = result.value;
                    })
                    .catch(function (error) {
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
{{--<script src="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.umd.js"></script>--}}
{{--<script>--}}
{{--    // Import CKEditor 5 plugins and editor--}}
{{--    const {--}}
{{--        ClassicEditor,--}}
{{--        Essentials,--}}
{{--        Paragraph,--}}
{{--        Bold,--}}
{{--        Italic,--}}
{{--        Font,--}}
{{--        Indent, BlockQuote,--}}
{{--        Emoji, Mention, TextTransformation, Code, Strikethrough, Subscript, Superscript, Underline,--}}
{{--    } = CKEDITOR;--}}

{{--    // Initialize CKEditor 5--}}
{{--    ClassicEditor--}}
{{--        .create(document.querySelector('#editor'), {--}}
{{--            licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDA4NzM1OTksImp0aSI6IjU3NjMyMzYyLThjYzktNGI5OS04YTk4LTA3YTQ0NTRhOTk2OSIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImY3ODMxZjUwIn0.8zMtmfSOdINS8gAXMt-u-ORW6jDDZLl5fJejawSrIC7aeWgLGNiBwgApykggy8_Z789xYoaJ4aygTNI0YniwRA',--}}

{{--            // Plugins to include--}}
{{--            plugins: [--}}
{{--                Essentials, Paragraph, Bold, Italic, Font, Indent, BlockQuote, Emoji, Mention, TextTransformation, Code, Strikethrough, Subscript, Superscript,--}}
{{--                Underline,--}}
{{--            ],--}}

{{--            // Toolbar configuration--}}
{{--            toolbar: {--}}
{{--                items: [--}}
{{--                    'undo', 'redo', 'emoji',--}}
{{--                    '|',--}}
{{--                    'heading',--}}
{{--                    '|',--}}
{{--                    'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',--}}
{{--                    '|',--}}
{{--                    'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',--}}
{{--                    '|',--}}
{{--                    'link', 'uploadImage', 'blockQuote', 'codeBlock',--}}
{{--                    '|',--}}
{{--                    'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent',--}}
{{--                ],--}}
{{--                shouldNotGroupWhenFull: false,--}}
{{--            },--}}
{{--            menuBar: {--}}
{{--                isVisible: true,--}}
{{--            },--}}
{{--            heading: {--}}
{{--                options: [--}}
{{--                    { modelElement: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },--}}
{{--                    { modelElement: 'heading1', viewElement: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },--}}
{{--                    { modelElement: 'heading2', viewElement: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },--}}
{{--                    { modelElement: 'heading', viewElement: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },--}}
{{--                ],--}}
{{--            },--}}

{{--        })--}}
{{--        .then(editor => {--}}
{{--            console.log('CKEditor initialized:', editor);--}}

{{--            const form = document.querySelector('form');--}}
{{--            form.addEventListener('submit', () => {--}}
{{--                const contentTextarea = document.querySelector('#content');--}}
{{--                if (contentTextarea) {--}}
{{--                    contentTextarea.value = editor.getData();--}}
{{--                }--}}
{{--            });--}}
{{--        })--}}
{{--        .catch(error => {--}}
{{--            console.error('Error initializing CKEditor:', error);--}}
{{--        });--}}
{{--</script>--}}

</body>
</html>
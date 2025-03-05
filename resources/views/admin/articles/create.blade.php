@extends('admin.layouts.master')

@section('head')
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
@endsection

@section('title')
    Thêm Mới Bài Viết
@endsection

@section('content')
    <div class="wrapper">
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

                <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea name="content" id="editor" cols="30" rows="10"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="word_file" class="form-label">Nhập nội dung từ file Word</label>
                        <input type="file" class="form-control" id="word_file" accept=".docx">
                    </div>

                    <div class="mb-3">
                        <label for="tags">Chọn hoặc thêm tags:</label>
                        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->tag_id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail_url" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url" accept="image/*" required>
                    </div>

                    <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="status" id="articleStatus" value="pending">

                    <button type="submit" class="btn btn-primary">Gửi</button>
                    <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                    <button type="button" class="waves-effect waves-light btn btn-default">
                        <a href="{{ route('articles.index') }}">Back to List</a>
                    </button>
                </form>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#tags').select2({
                            tags: true,
                            tokenSeparators: [','],
                            placeholder: "Chọn hoặc nhập tags mới",
                            allowClear: true
                        });
                    });

                    document.getElementById('saveDraft').addEventListener('click', function() {
                        document.getElementById('articleStatus').value = 'draft';
                        document.getElementById('articleForm').setAttribute('novalidate', 'novalidate');
                        document.getElementById('articleForm').submit();
                    });

                    document.getElementById('word_file').addEventListener('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const arrayBuffer = e.target.result;
                                mammoth.convertToHtml({ arrayBuffer: arrayBuffer })
                                    .then(function(result) {
                                        tinymce.get('editor').setContent(result.value);
                                    })
                                    .catch(function(error) {
                                        console.error('Lỗi đọc file:', error);
                                    });
                            };
                            reader.readAsArrayBuffer(file);
                        }
                    });

                    tinymce.init({
                        selector: '#editor',
                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
                        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | table',
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
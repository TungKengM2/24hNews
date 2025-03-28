@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Bài Viết
@endsection

@section('head')
    <!-- CKBox -->
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <!-- TinyMCE -->
    <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom Styles -->
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-section {
            margin-bottom: 25px;
        }
        
        .form-section-title {
            margin-bottom: 15px;
            font-weight: 600;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }
        
        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        
        .back-button {
            margin-left: auto;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Cập Nhật Bài Viết</h4>
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}"><i
                                                class="mdi mdi-home-outline"></i></a></li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Cập Nhật</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="wrapper">
                <div class="container mt-5">
                    <div class="card p-2">
                        <h2 class="mb-4">Cập Nhật Bài Viết</h2>
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
                            
                            <!-- Thông tin cơ bản -->
                            <div class="form-section">
                                <h4 class="form-section-title">Thông tin cơ bản</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Tiêu đề</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="slug" class="form-label">Đường dẫn</label>
                                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $article->slug }}" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Danh mục</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">-- Không có danh mục --</option>
                                            @foreach ($categories as $category)
                                                @if ($category->is_active || $article->category_id == $category->category_id)
                                                    <option value="{{ $category->category_id }}"
                                                        {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                        @if (!$category->is_active)
                                                            (Đã vô hiệu hóa)
                                                        @endif
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="tags">Chọn hoặc thêm thẻ:</label>
                                        <select name="tags[]" id="tags" class="form-control select2" multiple="multiple">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->tag_id }}" @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="thumbnail_url" class="form-label">Ảnh đại diện</label>
                                    <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url" accept="image/*">
                                    @if ($article->thumbnail_url)
                                        <div class="mt-2">
                                            <p>Ảnh hiện tại:</p>
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh hiện tại" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Nội dung bài viết -->
                            <div class="form-section">
                                <h4 class="form-section-title">Nội dung bài viết</h4>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung</label>
                                    <textarea name="content" id="editor" cols="30" rows="10">{!! $article->content !!}</textarea>
                                </div>
                            </div>

                            <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{ route('articles.index') }}" class="btn btn-default back-button">Quay Lại Danh Sách</a>
                            </div>
                        </form>

                        <script>
                            $(document).ready(function() {
                                $('.select2').select2({
                                    tags: true,
                                    tokenSeparators: [','],
                                    placeholder: "Chọn hoặc nhập thẻ mới",
                                    allowClear: true
                                });
                            });

                            // Tạo slug tự động
                            document.getElementById("title").addEventListener("input", function() {
                                let title = this.value.trim();
                                let slug = title.toLowerCase()
                                    .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Loại bỏ dấu tiếng Việt
                                    .replace(/đ/g, "d").replace(/Đ/g, "D")
                                    .replace(/\s+/g, "-") // Thay dấu cách bằng "-"
                                    .replace(/[^\w-]/g, "") // Xóa ký tự đặc biệt
                                    .replace(/--+/g, "-") // Loại bỏ nhiều dấu "-" liên tiếp
                                    .replace(/^-+|-+$/g, ""); // Xóa "-" ở đầu và cuối

                                document.getElementById("slug").value = slug;
                            });

                            tinymce.init({
                                selector: '#editor',
                                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
                                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | table',
                                menubar: 'file edit view insert format tools table help'
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

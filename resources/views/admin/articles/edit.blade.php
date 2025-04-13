@extends('admin.layouts.master')

@section('head')
    <!-- Style -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

<<<<<<< HEAD
<body>
    <div class="wrapper">
        @include('admin.menu')
        <div class="container mt-5">
=======
@section('title')
    Chỉnh Sửa Bài Viết
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="me-auto">
                        <h4 class="page-title">Cập Nhật Bài Viết</h4>

                        <!-- Error messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger error_message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Violation reasons -->
                        @if (session('violation_reasons'))
                            <div class="alert alert-warning error_message">
                                <strong>Lý do vi phạm:</strong>
                                <ul>
                                    @if (is_array(session('violation_reasons')))
                                        @foreach (session('violation_reasons') as $word => $reason)
                                            <li><strong>{{ $word }}:</strong> {{ $reason }}</li>
                                        @endforeach
                                    @else
                                        <li>{{ session('violation_reasons') }}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif

                        <!-- Breadcrumb -->
                        <div class="d-inline-block align-items-center">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                    <li class="breadcrumb-item active" aria-current="page">Cập Nhật</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

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

                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                    id="articleForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $article->title }}" required>
                    </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">Đường dẫn:</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="slug" name="slug"
                                                    value="{{ $article->slug }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Danh mục chính</label>
                                            <select name="category_id" id="parent_category"
                                                class="form-control select2-categories">
                                                <option value="">-- Chọn danh mục chính --</option>
                                                @foreach ($parentCategories as $category)
                                                    @if ($category->is_active || $article->category_id == $category->category_id)
                                                        <option value="{{ $category->category_id }}"
                                                            {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                                            {{ $category->name }} @if (!$category->is_active)
                                                                (Đã vô hiệu hóa)
                                                            @endif
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="tags" class="form-label">Chọn hoặc thêm thẻ:</label>
                                            <select name="tags[]" id="tags" class="form-control select2-tags"
                                                multiple="multiple" data-placeholder="Chọn hoặc nhập thẻ mới">
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->name }}"
                                                        @if (in_array($tag->name, $selectedTags)) selected @endif>
                                                        {{ $tag->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Bạn có thể chọn thẻ có sẵn hoặc nhập thẻ mới
                                                (chấp nhận cả chữ và số).</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Danh mục phụ</label>
                                            <select name="subcategory_id" id="child_category"
                                                class="form-control select2-subcategories"
                                                {{ empty($article->category_id) ? 'disabled' : '' }}>
                                                <option value="">-- Chọn danh mục phụ --</option>
                                                @if ($article->subcategory_id)
                                                    <option value="{{ $article->subcategory_id }}" selected>
                                                        {{ $article->subcategory->name }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thumbnail Section - Moved up -->
                                <div class="form-section">
                                    <h5 class="form-section-title">Ảnh Đại Diện</h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file"
                                                class="form-control @error('thumbnail_url') is-invalid @enderror"
                                                id="thumbnail_url" name="thumbnail_url" accept="image/*">

                                            @error('thumbnail_url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            @if (session('thumbnail_reasons'))
                                                <div class="alert alert-warning mt-2">
                                                    <strong>Ảnh đại diện vi phạm quy định!</strong>
                                                    <ul>
                                                        @foreach (session('thumbnail_reasons') as $key => $reason)
                                                            <li>{{ $reason }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <p>Vui lòng chọn ảnh đại diện khác phù hợp với quy định.</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mt-2" id="current-image-container">
                                                @if ($article->thumbnail_url)
                                                    <div>
                                                        <p><strong>Ảnh đại diện hiện tại:</strong></p>
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                            alt="Ảnh đại diện" class="img-thumbnail"
                                                            style="max-width: 200px; max-height: 150px;">
                                                    </div>
                                                @endif
                                            </div>

                                            <div id="image-preview-container" style="display: none;">
                                                <p class="mt-2"><strong>Ảnh xem trước:</strong></p>
                                                <img id="image-preview" src="#" alt="Xem trước"
                                                    class="img-fluid mb-2">
                                            </div>

                                            <div id="moderation-result" style="display: none;">
                                                <div id="moderation-loading" class="moderation-loading"
                                                    style="display: none;">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Đang kiểm duyệt...</span>
                                                    </div>
                                                    <p>Đang kiểm duyệt ảnh...</p>
                                                </div>
                                                <div id="moderation-error" class="alert alert-danger"
                                                    style="display: none;">
                                                    <strong>Lỗi!</strong> <span id="error-message"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Section -->
                                @php
                                    $content = str_replace('src="../../storage', 'src="/storage', $article->content);
                                @endphp

                                <div class="form-group">
                                    <label for="content" class="form-label" style="color: white">Nội dung</label>
                                    @if (session('violations'))
                                        <textarea id="full-featured" name="content"
                                            style="height: 800px; background: #ffe6e6; padding: 10px; border: 1px solid red;">
                            {!! highlightWords(old('content'), session('violations')) !!}
                        </textarea>
                                    @else
                                        <textarea id="full-featured" name="content" style="height: 800px;">
                        {!! $content !!}
                        </textarea>
                                    @endif
                                </div>

                                <!-- Hidden fields and buttons -->
                                <input type="hidden" name="status" id="articleStatus" value="pending">
                                <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                                <div class="action-buttons">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Cập nhật</button>
                                    <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tiêu chí xuất bản -->
                    <div class="col-md-3">
                        <div class="verification-criteria">
                            <h4 class="verification-criteria-title">Tiêu chí xuất bản</h4>
                            <div class="criteria-content">
                                <ul class="criteria-list" id="criteria-list">
                                    <li class="criteria-item failed" id="criteria-title" data-target="title">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Tiêu đề từ 50-60 ký tự <span id="current-title-length">(0 ký tự)</span>
                                            <span class="tooltip-text">Tiêu đề trong khoảng 50-60 ký tự sẽ hiển thị đầy đủ
                                                trên Google và tối ưu cho SEO</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-category"
                                        data-target="parent_category">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Chọn danh mục chính và phụ
                                            <span class="tooltip-text">Bắt buộc chọn cả danh mục chính và danh mục phụ phù
                                                hợp với nội dung bài viết</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-tags" data-target="tags">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Chọn 2-5 thẻ tag liên quan <span id="current-tag-count">(0 thẻ)</span>
                                            <span class="tooltip-text">Thẻ tag phù hợp giúp phân loại bài viết và tăng khả
                                                năng xuất hiện trong tìm kiếm</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-thumbnail" data-target="thumbnail_url">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Ảnh đại diện chất lượng cao
                                            <span class="tooltip-text">Ảnh đại diện tối thiểu 1200x630px, rõ nét và vượt
                                                qua kiểm duyệt</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-content" data-target="content">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Nội dung từ 800-1500 từ <span id="current-word-count">(0 từ)</span>
                                            <span class="tooltip-text">Bài viết dài 800-1500 từ được đánh giá cao hơn trong
                                                kết quả tìm kiếm và tối ưu cho người đọc</span>
                                        </div>
                                    </li>
                                </ul>
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="progress-container position-relative" style="height: 150px;">
                                        <div class="criteria-progress">
                                            <div class="criteria-progress-bar" id="criteria-progress-bar"></div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small id="criteria-count">0/5 tiêu chí đạt</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    // Khởi tạo Select2 với tính năng tags
                    $('.select2-tags').select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        placeholder: 'Chọn hoặc nhập thẻ mới',
                        allowClear: true,
                        maximumSelectionLength: 5,
                    }).on('change', function() {
                        // Cập nhật tiêu chí khi thay đổi tag
                        if (window.updateCriteria) {
                            window.updateCriteria();
                        }
                    });

                    // Khởi tạo Select2 cho danh mục cha
                    $('.select2-categories').select2({
                        placeholder: 'Chọn danh mục chính',
                        allowClear: true
                    });

                    // Khởi tạo Select2 cho danh mục con
                    $('.select2-subcategories').select2({
                        placeholder: 'Chọn danh mục phụ',
                        allowClear: true
                    });
                });

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

        @endsection

        @section('scripts')
        @endsection

@extends('admin.layouts.master')

@section('head')
    <!-- Style -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS cho hiệu ứng loading */
        .image-upload-loading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #007bff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        #moderation-result {
            margin-top: 10px;
        }

        .moderation-loading {
            text-align: center;
            padding: 10px;
        }

        .violation-high {
            color: #dc3545;
            font-weight: bold;
        }

        .violation-medium {
            color: #fd7e14;
            font-weight: bold;
        }

        .violation-low {
            color: #ffc107;
        }

        .violation-none {
            color: #28a745;
        }
    </style>
@endsection

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
            <div class="container-fluid mt-5">
                <div class="row no-gutters align-items-start">
                    <div class="col-md-9">
                        <div class="card p-4">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('articles.moderation-history', $article) }}" class="btn btn-info">
                                    <i class="fas fa-history"></i> Xem lịch sử kiểm duyệt
                                </a>
                            </div>
                            <form action="{{ route('articles.update', $article) }}" method="POST"
                                enctype="multipart/form-data" id="articleForm">
                                @csrf
                                @method('PUT')

                                <!-- Basic Information Section -->
                                <div class="form-section">
                                    <h5 class="form-section-title">Thông Tin Cơ Bản</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Tiêu đề:</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ $article->title }}" required>
                                            </div>
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
                                                <div id="moderation-loading" class="alert alert-info"
                                                    style="display: none;">
                                                    <strong><i class="fas fa-spinner fa-spin"></i> Đang kiểm
                                                        tra...</strong> Vui lòng đợi trong giây lát.
                                                </div>
                                                <div id="moderation-error" class="alert alert-danger"
                                                    style="display: none;">
                                                    <strong>Lỗi!</strong> <span id="error-message"></span>
                                                </div>
                                                <div id="moderation-success" class="alert alert-success"
                                                    style="display: none;">
                                                    <strong><i class="fas fa-check-circle"></i> Thành công!</strong> Ảnh đã
                                                    được kiểm duyệt và không vi phạm quy định.
                                                </div>
                                            </div>

                                            <!-- Thêm phần loading -->
                                            <div class="image-upload-loading" id="image-upload-loading">
                                                <div class="spinner"></div>
                                                <p class="mt-2">Đang tải lên và kiểm duyệt hình ảnh...</p>
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
                        tokenSeparators: [','],
                        placeholder: 'Chọn hoặc nhập thẻ mới',
                        allowClear: true,
                        maximumSelectionLength: 5,
                        matcher: function(params, data) {
                            // Nếu người dùng đang nhập thẻ mới
                            if (params.term && !data.id) {
                                // Kiểm tra xem thẻ đã tồn tại trong danh sách chưa
                                var existingTags = $(this).find('option').map(function() {
                                    return $(this).text().toLowerCase();
                                }).get();

                                // Nếu thẻ đã tồn tại => chọn thẻ cũ thay vì tạo mới
                                if (existingTags.includes(params.term.toLowerCase())) {
                                    return null; // Không hiển thị trong dropdown
                                }
                            }
                            return data;
                        }
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

                    // Xử lý khi thay đổi danh mục con
                    $('#child_category').on('change', function() {
                        // Cập nhật tiêu chí danh mục
                        if (window.updateCriteria) {
                            window.updateCriteria();
                        }
                    });

                    // Xử lý khi thay đổi danh mục cha
                    $('#parent_category').on('change', function() {
                        var parentId = $(this).val();
                        var childSelect = $('#child_category');

                        // Reset danh mục con
                        childSelect.empty().append('<option value="">-- Chọn danh mục phụ --</option>');

                        // Cập nhật tiêu chí danh mục
                        if (window.updateCriteria) {
                            window.updateCriteria();
                        }

                        if (parentId) {
                            // Enable select danh mục con
                            childSelect.prop('disabled', false);

                            // Gọi AJAX để lấy danh sách danh mục con
                            $.ajax({
                                url: '{{ route('ajax.subcategories') }}',
                                type: 'GET',
                                data: {
                                    parent_id: parentId
                                },
                                success: function(response) {
                                    if (response.success && response.data.length > 0) {
                                        // Thêm các option mới
                                        $.each(response.data, function(key, value) {
                                            childSelect.append('<option value="' + value
                                                .category_id + '">' + value.name +
                                                '</option>');
                                        });
                                    }
                                },
                                error: function() {
                                    console.error('Lỗi khi lấy danh sách danh mục con');
                                }
                            });
                        } else {
                            // Disable select danh mục con
                            childSelect.prop('disabled', true);
                        }
                    });
                });

                document.getElementById('title').addEventListener('input', function() {
                    let title = this.value.trim();
                    let slug = title.toLowerCase()
                        .normalize('NFD').replace(/[̀-ͯ]/g, '')
                        .replace(/đ/g, 'd').replace(/Đ/g, 'D')
                        .replace(/\s+/g, '-')
                        .replace(/[^\w-]/g, '')
                        .replace(/--+/g, '-')
                        .replace(/^-+|-+$/g, '');

                    document.getElementById('slug').value = slug;

                    // Cập nhật tiêu chí khi thay đổi tiêu đề
                    if (window.updateCriteria) {
                        window.updateCriteria();
                    }
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Khởi tạo các phần tử DOM
                    const imageUpload = document.getElementById('thumbnail_url');
                    const imagePreview = document.getElementById('image-preview');
                    const previewContainer = document.getElementById('image-preview-container');
                    const currentImageContainer = document.getElementById('current-image-container');
                    const moderationResult = document.getElementById('moderation-result');
                    const errorDiv = document.getElementById('moderation-error');
                    const errorMessage = document.getElementById('error-message');
                    const submitButton = document.getElementById('submitButton');
                    const imageUploadLoading = document.getElementById('image-upload-loading');

                    // Đảm bảo mặc định nút submit được bật và không có kiểm duyệt ảnh hiển thị
                    submitButton.disabled = false;
                    window.isImageChanged = false; // Theo dõi xem người dùng đã thay đổi ảnh chưa
                    window.isImageValid = true; // Mặc định ảnh hiện tại là hợp lệ

                    // Ẩn tất cả các phần tử kiểm duyệt ảnh khi trang mới tải
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (moderationResult) moderationResult.style.display = 'none';
                    if (errorDiv) errorDiv.style.display = 'none';
                    if (imageUploadLoading) imageUploadLoading.style.display = 'none';

                    // Hàm cập nhật tiêu chí xuất bản
                    function updateCriteria() {
                        const title = document.getElementById('title').value;
                        const titleLength = title.length;
                        const titleCriteria = document.getElementById('criteria-title');
                        const titleLengthSpan = document.getElementById('current-title-length');
                        if (titleLengthSpan) {
                            titleLengthSpan.textContent = `(${titleLength} ký tự)`;
                            if (titleLength >= 50 && titleLength <= 60) titleLengthSpan.style.color = '#28a745';
                            else titleLengthSpan.style.color = '#dc3545';
                        }
                        if (titleCriteria) {
                            if (titleLength >= 50 && titleLength <= 60) {
                                titleCriteria.classList.remove('failed');
                                titleCriteria.classList.add('passed');
                                titleCriteria.querySelector('.criteria-icon').textContent = '✓';
                                titleCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                titleCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                titleCriteria.classList.remove('passed');
                                titleCriteria.classList.add('failed');
                                titleCriteria.querySelector('.criteria-icon').textContent = '✗';
                                titleCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                titleCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        // Kiểm tra danh mục
                        const categoryCriteria = document.getElementById('criteria-category');
                        const parentCategory = document.getElementById('parent_category').value;
                        const childCategory = document.getElementById('child_category').value;
                        if (categoryCriteria) {
                            if (parentCategory && childCategory) {
                                categoryCriteria.classList.remove('failed');
                                categoryCriteria.classList.add('passed');
                                categoryCriteria.querySelector('.criteria-icon').textContent = '✓';
                                categoryCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                categoryCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                categoryCriteria.classList.remove('passed');
                                categoryCriteria.classList.add('failed');
                                categoryCriteria.querySelector('.criteria-icon').textContent = '✗';
                                categoryCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                categoryCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        const tagCriteria = document.getElementById('criteria-tags');
                        const tagCountSpan = document.getElementById('current-tag-count');

                        // Lấy số lượng tag đã chọn bằng nhiều cách khác nhau
                        let selectedTags = 0;

                        // Cách 1: Sử dụng Select2 API với ID
                        if ($('#tags').length && $('#tags').select2) {
                            selectedTags = $('#tags').select2('data').length;
                        }
                        // Cách 2: Sử dụng Select2 API với class
                        else if ($('.select2-tags').length && $('.select2-tags').select2) {
                            selectedTags = $('.select2-tags').select2('data').length;
                        }
                        // Cách 3: Đếm trực tiếp các option đã chọn
                        else {
                            selectedTags = $('select[name="tags[]"] option:selected').length;
                        }

                        console.log('Số lượng tag đã chọn:', selectedTags);

                        if (tagCountSpan) {
                            tagCountSpan.textContent = `(${selectedTags} thẻ)`;
                            if (selectedTags >= 2 && selectedTags <= 5) {
                                tagCountSpan.style.color = '#28a745';
                            } else {
                                tagCountSpan.style.color = '#dc3545';
                            }
                        }

                        if (tagCriteria) {
                            if (selectedTags >= 2 && selectedTags <= 5) {
                                tagCriteria.classList.remove('failed');
                                tagCriteria.classList.add('passed');
                                tagCriteria.querySelector('.criteria-icon').textContent = '✓';
                                tagCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                tagCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                tagCriteria.classList.remove('passed');
                                tagCriteria.classList.add('failed');
                                tagCriteria.querySelector('.criteria-icon').textContent = '✗';
                                tagCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                tagCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        const thumbnailCriteria = document.getElementById('criteria-thumbnail');
                        if (thumbnailCriteria) {
                            if (!window.isImageChanged || window.isImageValid) {
                                thumbnailCriteria.classList.remove('failed');
                                thumbnailCriteria.classList.add('passed');
                                thumbnailCriteria.querySelector('.criteria-icon').textContent = '✓';
                                thumbnailCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                thumbnailCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                thumbnailCriteria.classList.remove('passed');
                                thumbnailCriteria.classList.add('failed');
                                thumbnailCriteria.querySelector('.criteria-icon').textContent = '✗';
                                thumbnailCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                thumbnailCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        let wordCount = 0;
                        const contentCriteria = document.getElementById('criteria-content');
                        const wordCountSpan = document.getElementById('current-word-count');

                        // Sử dụng TinyMCE để đếm từ
                        if (typeof tinymce !== 'undefined' && tinymce.get('full-featured')) {
                            // Lấy nội dung văn bản từ TinyMCE
                            const content = tinymce.get('full-featured').getContent({
                                format: 'text'
                            });
                            // Đếm số từ bằng cách tách chuỗi theo khoảng trắng
                            wordCount = content.trim().split(/\s+/).filter(word => word.length > 0).length;
                        } else {
                            // Nếu TinyMCE chưa sẵn sàng, sử dụng textarea thông thường
                            const textarea = document.getElementById('full-featured');
                            if (textarea) {
                                wordCount = textarea.value.trim().split(/\s+/).filter(word => word.length > 0).length;
                            }
                        }

                        // Cập nhật hiển thị số từ
                        if (wordCountSpan) {
                            wordCountSpan.textContent = `(${wordCount} từ)`;
                            if (wordCount >= 800 && wordCount <= 1500) {
                                wordCountSpan.style.color = '#28a745';
                            } else {
                                wordCountSpan.style.color = '#dc3545';
                            }
                        }

                        // Cập nhật trạng thái tiêu chí
                        if (contentCriteria) {
                            if (wordCount >= 800 && wordCount <= 1500) {
                                contentCriteria.classList.remove('failed');
                                contentCriteria.classList.add('passed');
                                contentCriteria.querySelector('.criteria-icon').textContent = '✓';
                                contentCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                contentCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                contentCriteria.classList.remove('passed');
                                contentCriteria.classList.add('failed');
                                contentCriteria.querySelector('.criteria-icon').textContent = '✗';
                                contentCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                contentCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        const criteriaCount = document.querySelectorAll('.criteria-item.passed').length;
                        const progressBar = document.getElementById('criteria-progress-bar');
                        const criteriaCountSpan = document.getElementById('criteria-count');
                        if (progressBar) progressBar.style.height = `${criteriaCount * 20}%`;
                        if (criteriaCountSpan) criteriaCountSpan.textContent = `${criteriaCount}/5 tiêu chí đạt`;
                    }

                    window.updateCriteria = updateCriteria;
                    setTimeout(updateCriteria, 1000);

                    // Xử lý cuộn trang để làm cho phần Tiêu chí xuất bản di chuyển theo
                    function handleCriteriaScroll() {
                        const criteriaBox = document.querySelector('.verification-criteria');
                        if (!criteriaBox) return;

                        // Lấy vị trí ban đầu của phần Tiêu chí xuất bản
                        const criteriaBoxOffset = criteriaBox.getBoundingClientRect().top + window.scrollY;

                        // Lấy chiều rộng ban đầu của phần Tiêu chí xuất bản
                        const criteriaBoxWidth = criteriaBox.offsetWidth;

                        // Xử lý sự kiện cuộn trang
                        window.addEventListener('scroll', function() {
                            if (window.scrollY > criteriaBoxOffset - 20) {
                                criteriaBox.classList.add('fixed');
                                criteriaBox.style.width = criteriaBoxWidth + 'px';
                            } else {
                                criteriaBox.classList.remove('fixed');
                                criteriaBox.style.width = '';
                            }
                        });
                    }

                    // Gọi hàm xử lý cuộn trang
                    handleCriteriaScroll();

                    // Thêm sự kiện lắng nghe cho TinyMCE
                    if (typeof tinymce !== 'undefined') {
                        tinymce.on('AddEditor', function(e) {
                            e.editor.on('input change keyup', function() {
                                updateCriteria();
                            });

                            // Thêm sự kiện khi người dùng nhấp vào editor
                            e.editor.on('click', function() {
                                updateCriteria();
                            });

                            // Cập nhật khi nội dung thay đổi
                            e.editor.on('NodeChange', function() {
                                updateCriteria();
                            });
                        });

                        // Kiểm tra nếu TinyMCE đã được khởi tạo
                        if (tinymce.activeEditor) {
                            tinymce.activeEditor.on('input change keyup click NodeChange', function() {
                                updateCriteria();
                            });
                        }
                    }

                    // Lưu nháp
                    document.getElementById('saveDraft').addEventListener('click', function() {
                        document.getElementById('articleStatus').value = 'draft';
                        document.getElementById('articleForm').submit();
                    });

                    // Chỉ xử lý sự kiện khi người dùng chọn ảnh mới
                    if (imageUpload) {
                        imageUpload.addEventListener('change', function(e) {
                            const file = e.target.files[0];

                            // Chỉ xử lý khi có file được chọn
                            if (file) {
                                window.isImageChanged = true;
                                window.isImageValid = false;

                                // Ẩn ảnh hiện tại, hiển thị xem trước
                                if (currentImageContainer) {
                                    currentImageContainer.style.display = 'none';
                                }

                                // Lấy tất cả các phần tử DOM cần thiết
                                const moderationResult = document.getElementById('moderation-result');
                                const loadingDiv = document.getElementById('moderation-loading');
                                const errorDiv = document.getElementById('moderation-error');
                                const errorMessage = document.getElementById('error-message');
                                const successDiv = document.getElementById('moderation-success');
                                const imageUploadLoading = document.getElementById('image-upload-loading');

                                // Hiển thị loading và ẩn các thông báo khác
                                if (moderationResult) moderationResult.style.display = 'block';
                                if (loadingDiv) loadingDiv.style.display = 'block';
                                if (errorDiv) errorDiv.style.display = 'none';
                                if (successDiv) successDiv.style.display = 'none';
                                if (imageUploadLoading) imageUploadLoading.style.display = 'block';

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const imagePreview = document.getElementById('image-preview');
                                    const previewContainer = document.getElementById('image-preview-container');
                                    if (imagePreview) imagePreview.src = e.target.result;
                                    if (previewContainer) previewContainer.style.display = 'block';
                                };
                                reader.readAsDataURL(file);

                                // Hiển thị trạng thái kiểm duyệt
                                if (moderationResult) moderationResult.style.display = 'block';
                                if (errorDiv) errorDiv.style.display = 'none';

                                // Tạm thời vô hiệu hóa nút submit cho đến khi kiểm duyệt hoàn tất
                                submitButton.disabled = true;

                                const formData = new FormData();
                                formData.append('image', file);
                                formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                                .content);

                                fetch('/api/check-image-moderation', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                                .content,
                                        },
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Lỗi kết nối: ' + response.status);
                                        }
                                        return response.json();
                                    })
                                    .then(result => {
                                        // Ẩn loading
                                        if (imageUploadLoading) imageUploadLoading.style.display = 'none';
                                        if (loadingDiv) loadingDiv.style.display = 'none';

                                        if (result.status === 'error') {
                                            // Hiển thị thông báo lỗi
                                            if (errorDiv) {
                                                errorDiv.style.display = 'block';
                                                if (successDiv) successDiv.style.display = 'none';
                                                if (errorMessage) errorMessage.textContent = result.message ||
                                                    'Có lỗi xảy ra khi kiểm duyệt hình ảnh';
                                            }
                                            window.isImageValid = false;
                                            submitButton.disabled = true;
                                            if (window.updateCriteria) window.updateCriteria();
                                        } else if (result.violation_level !== 'none') {
                                            // Hiển thị thông báo lỗi vi phạm
                                            if (errorDiv) {
                                                errorDiv.style.display = 'block';
                                                if (successDiv) successDiv.style.display = 'none';
                                                let violationMessages = [];

                                                for (let violation in result.reason) {
                                                    violationMessages.push(result.reason[violation]);
                                                }

                                                if (errorMessage) errorMessage.innerHTML =
                                                    `Vi phạm: ${violationMessages.join(', ')}`;
                                            }
                                            window.isImageValid = false;
                                            submitButton.disabled = true;
                                            if (window.updateCriteria) window.updateCriteria();
                                        } else {
                                            // Ẩn thông báo lỗi và hiển thị thông báo thành công
                                            if (errorDiv) errorDiv.style.display = 'none';
                                            if (successDiv) {
                                                successDiv.style.display = 'block';
                                                successDiv.style.opacity = '1';

                                                // Tự động ẩn thông báo thành công sau 3 giây
                                                setTimeout(function() {
                                                    const fadeEffect = setInterval(function() {
                                                        if (successDiv.style.opacity > 0) {
                                                            successDiv.style.opacity -= 0.1;
                                                        } else {
                                                            clearInterval(fadeEffect);
                                                            successDiv.style.display = 'none';
                                                        }
                                                    }, 100);
                                                }, 3000);
                                            }

                                            window.isImageValid = true;
                                            submitButton.disabled = false;
                                            if (window.updateCriteria) window.updateCriteria();
                                        }
                                    })
                                    .catch(error => {
                                        // Ẩn loading
                                        if (imageUploadLoading) imageUploadLoading.style.display = 'none';
                                        if (loadingDiv) loadingDiv.style.display = 'none';

                                        if (errorDiv && errorMessage) {
                                            errorDiv.style.display = 'block';
                                            errorMessage.textContent = 'Có lỗi khi kiểm duyệt: ' + error
                                            .message;
                                        }
                                        submitButton.disabled = true;
                                        window.isImageValid = false;
                                        if (window.updateCriteria) window.updateCriteria();
                                    });
                            } else {
                                // Nếu không có file được chọn
                                window.isImageChanged = false;
                                if (currentImageContainer) currentImageContainer.style.display = 'block';
                                if (previewContainer) previewContainer.style.display = 'none';
                                if (moderationResult) moderationResult.style.display = 'none';
                                if (errorDiv) errorDiv.style.display = 'none';
                                if (imageUploadLoading) imageUploadLoading.style.display = 'none';
                                submitButton.disabled = false;
                                window.isImageValid = true;
                                if (window.updateCriteria) window.updateCriteria();
                            }
                        });
                    }

                    // Kiểm tra trước khi submit form
                    document.getElementById('articleForm').addEventListener('submit', function(e) {
                        if (document.activeElement.id === 'saveDraft') {
                            document.getElementById('articleStatus').value = 'draft';
                            return true;
                        }

                        document.getElementById('articleStatus').value = 'pending';

                        // Chỉ kiểm tra khi người dùng đã thay đổi ảnh và ảnh không hợp lệ
                        if (window.isImageChanged && imageUpload && imageUpload.files[0] && !window.isImageValid) {
                            e.preventDefault();
                            alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                            return false;
                        }

                        // Kiểm tra danh mục chính và danh mục phụ
                        const parentCategory = document.getElementById('parent_category').value;
                        const childCategory = document.getElementById('child_category').value;
                        if (!parentCategory) {
                            e.preventDefault();
                            alert('Vui lòng chọn danh mục chính cho bài viết.');
                            return false;
                        }

                        const criteriaCount = document.querySelectorAll('.criteria-item.passed').length;
                        if (criteriaCount < 5) {
                            e.preventDefault();
                            const failedCriteria = [];
                            document.querySelectorAll('.criteria-item.failed').forEach(item => {
                                const criteriaText = item.querySelector('.criteria-text').textContent.split(
                                    '(')[0].trim();
                                failedCriteria.push(`<li>${criteriaText}</li>`);
                            });

                            Swal.fire({
                                title: 'Bài viết chưa đạt tất cả tiêu chí',
                                html: `
                                    <div class="text-left">
                                        <p>Bài viết của bạn chưa đạt các tiêu chí sau:</p>
                                        <ul class="text-danger">${failedCriteria.join('')}</ul>
                                        <p>Bạn vẫn muốn cập nhật bài viết?</p>
                                    </div>
                                `,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Vẫn cập nhật',
                                cancelButtonText: 'Chỉnh sửa thêm'
                            }).then((result) => {
                                if (result.isConfirmed) document.getElementById('articleForm').submit();
                            });
                            return false;
                        }
                        return true;
                    });
                });
            </script>

        @endsection

        @section('scripts')
        @endsection

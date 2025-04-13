@extends('admin.layouts.master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Style -->
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        #image-preview-container {
            margin-top: 10px;
            text-align: center;
            max-width: 300px;
        }

        #image-preview {
            max-height: 150px;
            width: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
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

        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-section-title {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        /* Tiêu chí xuất bản styling */
        .verification-criteria {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            max-height: calc(100vh - 40px);
            /* Chiều cao tối đa là chiều cao của viewport trừ đi khoảng cách từ top */
            overflow-y: auto;
            /* Cho phép cuộn nếu nội dung quá dài */
        }

        /* Class được thêm bằng JavaScript khi cuộn trang */
        .verification-criteria.fixed {
            position: fixed;
            top: 20px;
            z-index: 100;
            width: 23%;
            /* Tương ứng với col-md-3 */
        }

        .verification-criteria-title {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .criteria-list {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .criteria-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .criteria-item:hover {
            background-color: #f0f0f0;
        }

        .criteria-icon {
            margin-right: 10px;
            font-weight: bold;
            font-size: 16px;
            min-width: 20px;
            text-align: center;
        }

        .criteria-icon.passed {
            color: #28a745;
        }

        .criteria-icon.failed {
            color: #dc3545;
        }

        .criteria-text {
            flex: 1;
            position: relative;
        }

        .criteria-tooltip {
            cursor: help;
        }

        .criteria-tooltip .tooltip-text {
            visibility: hidden;
            width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -125px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .criteria-tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .criteria-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .criteria-progress {
            width: 8px;
            height: 100%;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-right: 10px;
        }

        .criteria-progress-bar {
            width: 100%;
            background-color: #28a745;
            border-radius: 4px;
            height: 0%;
            transition: height 0.3s ease;
            position: absolute;
            bottom: 0;
        }

        .criteria-item.passed #current-title-length,
        .criteria-item.passed #current-tag-count,
        .criteria-item.passed #current-word-count {
            color: #28a745 !important;
        }

        .criteria-item.failed #current-title-length,
        .criteria-item.failed #current-tag-count,
        .criteria-item.failed #current-word-count {
            color: #dc3545 !important;
        }
    </style>
@endsection

@section('title')
    Thêm Mới Bài Viết
@endsection

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="mb-0">Tạo Bài Viết Mới</h2>
                            <a href="{{ route('admin.writing-guidelines') }}" class="btn btn-info">
                                <i class="fas fa-book"></i> Xem hướng dẫn viết bài
                            </a>
                        </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger error_message">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('blocked_images'))
                                    <div class="alert alert-warning error_message">
                                        <strong>Cảnh báo: Một số hình ảnh đã bị chặn</strong>
                                        <ul>
                                            @foreach (session('blocked_images') as $image)
                                                <li>
                                                    <strong>{{ $image['filename'] ?? 'Hình ảnh' }}</strong>:
                                                    @if (isset($image['reason']) && is_array($image['reason']))
                                                        {{ implode(', ', array_values($image['reason'])) }}
                                                    @else
                                                        {{ $image['reason'] ?? 'Vi phạm quy định nội dung' }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p>Các hình ảnh vi phạm đã bị xóa khỏi nội dung bài viết. Bạn vẫn có thể lưu bài
                                            viết dưới
                                            dạng
                                            nháp hoặc xác nhận tiếp tục gửi.</p>
                                    </div>
                                @endif

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

                                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data"
                                    id="articleForm">
                                    @csrf

                                    <div class="form-section">
                                        <h4 class="form-section-title">Thông tin cơ bản</h4>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="title" class="form-label">Tiêu đề</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ old('title') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="slug" class="form-label">Đường dẫn</label>
                                                <input type="text" class="form-control" id="slug" name="slug"
                                                    value="{{ old('slug') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Danh mục chính</label>
                                                <select name="category_id" id="parent_category"
                                                    class="form-control select2-categories">
                                                    <option value="">-- Chọn danh mục chính --</option>
                                                    @foreach ($parentCategories as $category)
                                                        @if ($category->is_active)
                                                            <option value="{{ $category->category_id }}">
                                                                {{ $category->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Danh mục phụ</label>
                                                <select name="subcategory_id" id="child_category"
                                                    class="form-control select2-subcategories" disabled>
                                                    <option value="">-- Chọn danh mục phụ --</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="tags">Chọn hoặc thêm thẻ:</label>
                                                <select name="tags[]" id="tags" class="form-control select2-tags"
                                                    multiple="multiple" data-placeholder="Chọn hoặc nhập thẻ mới">
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->name }}"
                                                            {{ in_array($tag->name, old('tags', [])) ? 'selected' : '' }}>
                                                            {{ $tag->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Bạn có thể chọn thẻ có sẵn hoặc nhập thẻ
                                                    mới (chấp nhận cả chữ và số).</small>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-section">
                                        <h4 class="form-section-title">Ảnh đại diện</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="thumbnail_url" class="form-label">Chọn ảnh đại diện</label>
                                                <input type="file"
                                                    class="form-control @error('thumbnail_url') is-invalid @enderror"
                                                    id="thumbnail_url" name="thumbnail_url" accept="image/*" required>

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

                                                @if (old('thumbnail_url'))
                                                    <p>File đã chọn trước đó: {{ old('thumbnail_url') }}</p>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <div id="image-preview-container" style="display: none;">
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
                                                        <strong><i class="fas fa-check-circle"></i> Thành công!</strong> Ảnh
                                                        đã được kiểm duyệt và không vi phạm quy định.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section">
                                        <h4 class="form-section-title">Nội dung bài viết</h4>
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Nội dung</label>
                                            @if (session()->has('violations') && !empty(session('violations')))
                                                <textarea id="full-featured" name="content"
                                                    style="height: 800px; background: #ffe6e6; padding: 10px; border: 1px solid red;">
                                        {!! highlightWords(old('content', isset($article) ? $article->content : ''), session('violations')) !!}
                                        </textarea>
                                            @else
                                                <textarea id="full-featured" name="content" style="height: 800px;">
                                {{ old('content', isset($article) ? $article->content : '') }}
                                </textarea>
                                            @endif
                                        </div>
                                    </div>

                                    <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="status" id="articleStatus" value="pending">

                                    <div class="action-buttons">
                                        <button type="submit" class="btn btn-primary" id="submitButton">Gửi đi</button>
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
                                                <span class="tooltip-text">Tiêu đề trong khoảng 50-60 ký tự sẽ hiển thị đầy
                                                    đủ trên Google và tối ưu cho SEO</span>
                                            </div>
                                        </li>
                                        <li class="criteria-item failed" id="criteria-category"
                                            data-target="parent_category">
                                            <div class="criteria-icon failed">✗</div>
                                            <div class="criteria-text criteria-tooltip">
                                                Chọn danh mục chính và phụ
                                                <span class="tooltip-text">Bắt buộc chọn cả danh mục chính và danh mục phụ
                                                    phù hợp với nội dung bài viết</span>
                                            </div>
                                        </li>
                                        <li class="criteria-item failed" id="criteria-tags" data-target="tags">
                                            <div class="criteria-icon failed">✗</div>
                                            <div class="criteria-text criteria-tooltip">
                                                Chọn 2-5 thẻ tag liên quan <span id="current-tag-count">(0 thẻ)</span>
                                                <span class="tooltip-text">Thẻ tag phù hợp giúp phân loại bài viết và tăng
                                                    khả năng xuất hiện trong tìm kiếm</span>
                                            </div>
                                        </li>
                                        <li class="criteria-item failed" id="criteria-thumbnail"
                                            data-target="thumbnail_url">
                                            <div class="criteria-icon failed">✗</div>
                                            <div class="criteria-text criteria-tooltip">
                                                Ảnh đại diện chất lượng cao
                                                <span class="tooltip-text">Ảnh đại diện tối thiểu 1200x630px, rõ nét và
                                                    vượt qua kiểm duyệt</span>
                                            </div>
                                        </li>
                                        <li class="criteria-item failed" id="criteria-content" data-target="content">
                                            <div class="criteria-icon failed">✗</div>
                                            <div class="criteria-text criteria-tooltip">
                                                Nội dung từ 800-1500 từ <span id="current-word-count">(0 từ)</span>
                                                <span class="tooltip-text">Bài viết dài 800-1500 từ được đánh giá cao hơn
                                                    trong kết quả tìm kiếm và tối ưu cho người đọc</span>
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

                        <!-- Scripts -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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

                            document.getElementById('saveDraft').addEventListener('click', function() {
                                document.getElementById('articleStatus').value = 'draft';
                                document.getElementById('articleForm').setAttribute('novalidate', 'novalidate'); // Bỏ qua required
                                document.getElementById('articleForm').submit();
                            });

                            // Cảnh báo khi người dùng rời khỏi trang nếu có thay đổi
                            let isFormEdited = false;
                            const formElements = document.getElementById('articleForm').elements;

                            for (let i = 0; i < formElements.length; i++) {
                                formElements[i].addEventListener('change', function() {
                                    isFormEdited = true;
                                });
                            }

                            window.addEventListener('beforeunload', function(e) {
                                if (isFormEdited) {
                                    const confirmationMessage =
                                        'Bạn có chắc chắn muốn rời khỏi trang? Những thay đổi chưa được lưu sẽ bị mất.';
                                    e.returnValue = confirmationMessage;
                                    return confirmationMessage;
                                }
                            });

                            document.addEventListener('DOMContentLoaded', function() {
                                // Ẩn các thành phần moderation khi trang mới tải
                                const moderationResult = document.getElementById('moderation-result');
                                const errorDiv = document.getElementById('moderation-error');
                                if (moderationResult) moderationResult.style.display = 'none';
                                if (errorDiv) errorDiv.style.display = 'none';

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
                                        if (window.isImageValid) {
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
                                window.isImageValid = false;
                                setTimeout(updateCriteria, 1000);

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

                                // Xử lý sinh slug tự động từ tiêu đề
                                document.getElementById('title').addEventListener('input', function() {
                                    let title = this.value.trim();
                                    let slug = title.toLowerCase()
                                        .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu tiếng Việt
                                        .replace(/đ/g, 'd').replace(/Đ/g, 'D')
                                        .replace(/\s+/g, '-') // Thay dấu cách bằng "-"
                                        .replace(/[^\w-]/g, '') // Xóa ký tự đặc biệt
                                        .replace(/--+/g, '-') // Loại bỏ nhiều dấu "-" liên tiếp
                                        .replace(/^-+|-+$/g, ''); // Xóa "-" ở đầu và cuối

                                    document.getElementById('slug').value = slug;

                                    // Cập nhật tiêu chí khi thay đổi tiêu đề
                                    if (window.updateCriteria) {
                                        window.updateCriteria();
                                    }
                                });

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

                                const violationDescriptions = {
                                    'nudity': 'Hình ảnh chứa nội dung nhạy cảm, khỏa thân hoặc gợi dục',
                                    'violence': 'Hình ảnh chứa cảnh bạo lực, đánh đập hoặc gây tổn thương',
                                    'text_violation': 'Hình ảnh chứa văn bản vi phạm quy định (ngôn từ thô tục, kích động)',
                                    'gore': 'Hình ảnh chứa cảnh máu me, tổn thương cơ thể',
                                    'self_harm': 'Hình ảnh liên quan đến tự gây thương tích hoặc tự tử',
                                    'gambling': 'Hình ảnh liên quan đến cờ bạc, đánh bạc',
                                };

                                window.isImageValid = false;
                                const submitButton = document.getElementById('submitButton');

                                // Chỉ có một sự kiện lắng nghe cho phần tử thumbnail_url
                                const thumbnailInput = document.getElementById('thumbnail_url');
                                if (thumbnailInput) {
                                    thumbnailInput.addEventListener('change', function(e) {
                                        const file = e.target.files[0];
                                        if (file) {
                                            window.isImageValid = false;

                                            // Hiển thị thông báo đang kiểm tra và ẩn các thông báo khác
                                            const moderationResult = document.getElementById('moderation-result');
                                            const loadingDiv = document.getElementById('moderation-loading');
                                            const errorDiv = document.getElementById('moderation-error');
                                            const successDiv = document.getElementById('moderation-success');
                                            if (moderationResult) moderationResult.style.display = 'block';
                                            if (loadingDiv) loadingDiv.style.display = 'block';
                                            if (errorDiv) errorDiv.style.display = 'none';
                                            if (successDiv) successDiv.style.display = 'none';

                                            // Xử lý preview ảnh
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                document.getElementById('image-preview').src = e.target.result;
                                                document.getElementById('image-preview-container').style.display = 'block';
                                            };
                                            reader.readAsDataURL(file);

                                            // Kiểm duyệt hình ảnh
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
                                                    document.getElementById('image-upload-loading').style.display = 'none';
                                                    
                                                    const moderationResult = document.getElementById('moderation-result');
                                                    const loadingDiv = document.getElementById('moderation-loading');
                                                    const errorDiv = document.getElementById('moderation-error');
                                                    const errorMessage = document.getElementById('error-message');
                                                    const successDiv = document.getElementById('moderation-success');

                                                    // Ẩn thông báo đang kiểm tra
                                                    if (loadingDiv) loadingDiv.style.display = 'none';
                                                    moderationResult.style.display = 'block';

                                                    if (result.status === 'error') {
                                                        // Hiển thị thông báo lỗi
                                                        errorDiv.style.display = 'block';
                                                        successDiv.style.display = 'none';
                                                        errorMessage.textContent = result.message ||
                                                            'Có lỗi xảy ra khi kiểm duyệt hình ảnh';
                                                        window.isImageValid = false;
                                                        submitButton.disabled = true;
                                                        if (window.updateCriteria) window.updateCriteria();
                                                    } else if (result.violation_level !== 'none') {
                                                        // Hiển thị thông báo lỗi vi phạm
                                                        errorDiv.style.display = 'block';
                                                        successDiv.style.display = 'none';
                                                        let violationMessages = [];

                                                        for (let violation in result.reason) {
                                                            violationMessages.push(result.reason[violation]);
                                                        }

                                                        errorMessage.innerHTML = `Vi phạm: ${violationMessages.join(', ')}`;
                                                        window.isImageValid = false;
                                                        submitButton.disabled = true;
                                                        if (window.updateCriteria) window.updateCriteria();
                                                    } else {
                                                        // Ẩn thông báo lỗi
                                                        errorDiv.style.display = 'none';

                                                        // Hiển thị thông báo thành công
                                                        successDiv.style.display = 'block';
                                                        successDiv.style.opacity = '1';

                                                        // Cập nhật trạng thái hình ảnh hợp lệ
                                                        window.isImageValid = true;
                                                        submitButton.disabled = false;

                                                        // Cập nhật tiêu chí kiểm tra
                                                        if (window.updateCriteria) window.updateCriteria();

                                                        // Tự động ẩn thông báo thành công sau 3 giây
                                                        setTimeout(function() {
                                                            // Hiệu ứng mờ dần trong 1 giây
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
                                                })
                                                .catch(error => {
                                                    // Ẩn loading khi có lỗi
                                                    document.getElementById('image-upload-loading').style.display = 'none';
                                                    
                                                    console.error('Lỗi kiểm duyệt:', error);
                                                    const moderationResult = document.getElementById('moderation-result');
                                                    const loadingDiv = document.getElementById('moderation-loading');
                                                    const errorDiv = document.getElementById('moderation-error');
                                                    const errorMessage = document.getElementById('error-message');
                                                    const successDiv = document.getElementById('moderation-success');

                                                    // Ẩn thông báo đang kiểm tra
                                                    if (loadingDiv) loadingDiv.style.display = 'none';
                                                    if (successDiv) successDiv.style.display = 'none';
                                                    moderationResult.style.display = 'block';
                                                    errorDiv.style.display = 'block';
                                                    errorMessage.textContent = 'Có lỗi xảy ra khi kiểm duyệt hình ảnh: ' +
                                                        error.message;
                                                    window.isImageValid = false;
                                                    submitButton.disabled = true;
                                                    if (window.updateCriteria) window.updateCriteria();
                                                });

                                            // Nếu cần xử lý mammoth (chuyển đổi .docx)
                                            if (file.type ===
                                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                                                const docReader = new FileReader();
                                                docReader.onload = function(e) {
                                                    const arrayBuffer = e.target.result;
                                                    mammoth.extractRawText({
                                                            arrayBuffer: arrayBuffer,
                                                        })
                                                        .then(function(result) {
                                                            document.getElementById('editor').innerHTML = result.value;
                                                        })
                                                        .catch(function(error) {
                                                            console.error('Lỗi đọc file:', error);
                                                        });
                                                };
                                                docReader.readAsArrayBuffer(file);
                                            }
                                        }
                                    });
                                }

                                // Kiểm tra trước khi submit form
                                const form = document.getElementById('articleForm');
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        if (document.getElementById('articleStatus').value === 'draft') {
                                            return true;
                                        }

                                        if (thumbnailInput && thumbnailInput.files && thumbnailInput.files[0] && !
                                            window.isImageValid) {
                                            e.preventDefault();
                                            alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                                            thumbnailInput.focus();
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
                                                const criteriaText = item.querySelector('.criteria-text').textContent
                                                    .split('(')[0].trim();
                                                failedCriteria.push(`<li>${criteriaText}</li>`);
                                            });

                                            Swal.fire({
                                                title: 'Bài viết chưa đạt tất cả tiêu chí',
                                                html: `
                                                    <div class="text-left">
                                                        <p>Bài viết của bạn chưa đạt các tiêu chí sau:</p>
                                                        <ul class="text-danger">${failedCriteria.join('')}</ul>
                                                        <p>Bạn vẫn muốn gửi bài?</p>
                                                    </div>
                                                `,
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Vẫn gửi bài',
                                                cancelButtonText: 'Chỉnh sửa thêm'
                                            }).then((result) => {
                                                if (result.isConfirmed) document.getElementById('articleForm').submit();
                                            });
                                            return false;
                                        }
                                        return true;
                                    });
                                }
                            });
                        </script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@extends('author.layouts.master')

@section('head')
    <!-- Style -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Màu cho các số lượng */
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
                            <form action="{{ route('author.articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                                  id="articleForm">
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
                                <label for="category_id" class="form-label">Danh Mục</label>
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
                                <label for="tags" class="form-label">Chọn hoặc thêm thẻ:</label>
                                <select name="tags[]" class="form-control select2" multiple="multiple">
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->tag_id }}"
                                                @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Section - Moved up -->
                    <div class="form-section">
                        <h5 class="form-section-title">Ảnh Đại Diện</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="file" class="form-control @error('thumbnail_url') is-invalid @enderror"
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
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Ảnh đại diện"
                                                 class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                        </div>
                                    @endif
                                </div>

                                <div id="image-preview-container" style="display: none;">
                                    <p class="mt-2"><strong>Ảnh xem trước:</strong></p>
                                    <img id="image-preview" src="#" alt="Xem trước" class="img-fluid mb-2">
                                </div>

                                <div id="moderation-result" style="display: none;">
                                    <div id="moderation-loading" class="moderation-loading" style="display: none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Đang kiểm duyệt...</span>
                                        </div>
                                        <p>Đang kiểm duyệt ảnh...</p>
                                    </div>
                                    <div id="moderation-error" class="alert alert-danger" style="display: none;">
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

                    <div class="col-md-3">
                        <div class="verification-criteria">
                            <h4 class="verification-criteria-title">Tiêu chí xuất bản</h4>
                            <div class="criteria-content">
                                <ul class="criteria-list" id="criteria-list">
                                    <li class="criteria-item failed" id="criteria-title" data-target="title">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Tiêu đề từ 50-60 ký tự <span id="current-title-length">(0 ký tự)</span>
                                            <span class="tooltip-text">Tiêu đề trong khoảng 50-60 ký tự sẽ hiển thị đầy đủ trên Google và tối ưu cho SEO</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-tags" data-target="tags">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Chọn 2-5 thẻ tag liên quan <span id="current-tag-count">(0 thẻ)</span>
                                            <span class="tooltip-text">Thẻ tag phù hợp giúp phân loại bài viết và tăng khả năng xuất hiện trong tìm kiếm</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-thumbnail" data-target="thumbnail_url">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Ảnh đại diện chất lượng cao
                                            <span class="tooltip-text">Ảnh đại diện tối thiểu 1200x630px, rõ nét và vượt qua kiểm duyệt</span>
                                        </div>
                                    </li>
                                    <li class="criteria-item failed" id="criteria-content" data-target="content">
                                        <div class="criteria-icon failed">✗</div>
                                        <div class="criteria-text criteria-tooltip">
                                            Nội dung từ 800-1500 từ <span id="current-word-count">(0 từ)</span>
                                            <span class="tooltip-text">Bài viết dài 800-1500 từ được đánh giá cao hơn trong kết quả tìm kiếm và tối ưu cho người đọc</span>
                                        </div>
                                    </li>
                                </ul>

                                <div class="progress-container">
                                    <div class="criteria-progress">
                                        <div class="criteria-progress-bar" id="criteria-progress-bar"></div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <small id="criteria-count">0/4 tiêu chí đạt</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        tags: true,
                        tokenSeparators: [','],
                        placeholder: 'Chọn hoặc nhập thẻ mới',
                        allowClear: true,
                    });

                    // Khởi tạo biến toàn cục
                    window.isImageValid = true; // Mặc định ảnh hiện tại là hợp lệ
                    window.isImageChanged = false; // Theo dõi xem người dùng đã thay đổi ảnh chưa

                    // Hàm cập nhật tiêu chí
                    function updateCriteria() {
                        // Kiểm tra tiêu đề
                        const title = document.getElementById('title').value;
                        const titleLength = title.length;
                        const titleCriteria = document.getElementById('criteria-title');
                        const titleLengthSpan = document.getElementById('current-title-length');

                        if (titleLengthSpan) {
                            titleLengthSpan.textContent = `(${titleLength} ký tự)`;

                            // Thay đổi màu của số lượng ký tự
                            if (titleLength >= 50 && titleLength <= 60) {
                                titleLengthSpan.style.color = '#28a745'; // Màu xanh khi đạt yêu cầu
                            } else {
                                titleLengthSpan.style.color = '#dc3545'; // Màu đỏ khi không đạt yêu cầu
                            }
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

                        // Kiểm tra tags
                        const tagCriteria = document.getElementById('criteria-tags');
                        const tagCountSpan = document.getElementById('current-tag-count');

                        // Đếm số lượng tag đã chọn
                        let selectedTags = 0;
                        try {
                            // Cách 1: Sử dụng Select2 API
                            if ($('.select2').data('select2')) {
                                selectedTags = $('.select2').select2('data').length;
                            }
                            // Cách 2: Đếm trực tiếp các option đã chọn
                            else {
                                selectedTags = $('select[name="tags[]"] option:selected').length;
                            }
                        } catch (e) {
                            console.error('Lỗi khi đếm tags:', e);
                            // Cách 3: Đếm trực tiếp các option đã chọn
                            selectedTags = $('select[name="tags[]"] option:selected').length;
                        }

                        console.log('Số lượng tag đã chọn:', selectedTags);

                        if (tagCountSpan) {
                            tagCountSpan.textContent = `(${selectedTags} thẻ)`;

                            // Thay đổi màu của số lượng thẻ tag
                            if (selectedTags >= 2 && selectedTags <= 5) {
                                tagCountSpan.style.color = '#28a745'; // Màu xanh khi đạt yêu cầu
                            } else {
                                tagCountSpan.style.color = '#dc3545'; // Màu đỏ khi không đạt yêu cầu
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

                        // Kiểm tra ảnh đại diện
                        const thumbnailCriteria = document.getElementById('criteria-thumbnail');

                        if (thumbnailCriteria) {
                            // Nếu không có ảnh mới được chọn hoặc ảnh mới hợp lệ
                            if (!window.isImageChanged || window.isImageValid) {
                                // Ảnh hiện tại luôn được coi là hợp lệ nếu không có ảnh mới
                                thumbnailCriteria.classList.remove('failed');
                                thumbnailCriteria.classList.add('passed');
                                thumbnailCriteria.querySelector('.criteria-icon').textContent = '✓';
                                thumbnailCriteria.querySelector('.criteria-icon').classList.remove('failed');
                                thumbnailCriteria.querySelector('.criteria-icon').classList.add('passed');
                            } else {
                                // Chỉ khi người dùng đã chọn ảnh mới và ảnh đó không hợp lệ
                                thumbnailCriteria.classList.remove('passed');
                                thumbnailCriteria.classList.add('failed');
                                thumbnailCriteria.querySelector('.criteria-icon').textContent = '✗';
                                thumbnailCriteria.querySelector('.criteria-icon').classList.remove('passed');
                                thumbnailCriteria.querySelector('.criteria-icon').classList.add('failed');
                            }
                        }

                        // Kiểm tra nội dung
                        let wordCount = 0;
                        const contentCriteria = document.getElementById('criteria-content');
                        const wordCountSpan = document.getElementById('current-word-count');

                        // Kiểm tra nếu TinyMCE đã được khởi tạo
                        if (typeof tinymce !== 'undefined' && tinymce.get('full-featured')) {
                            const editor = tinymce.get('full-featured');
                            const content = editor.getContent({format: 'text'});
                            wordCount = content.trim().split(/\s+/).length;
                        } else {
                            // Nếu TinyMCE chưa sẵn sàng, lấy nội dung từ textarea
                            const textarea = document.getElementById('full-featured');
                            if (textarea) {
                                wordCount = textarea.value.trim().split(/\s+/).length;
                            }
                        }

                        if (wordCountSpan) {
                            wordCountSpan.textContent = `(${wordCount} từ)`;

                            // Thay đổi màu của số lượng từ
                            if (wordCount >= 800 && wordCount <= 1500) {
                                wordCountSpan.style.color = '#28a745'; // Màu xanh khi đạt yêu cầu
                            } else {
                                wordCountSpan.style.color = '#dc3545'; // Màu đỏ khi không đạt yêu cầu
                            }
                        }

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

                        // Cập nhật thanh tiến trình
                        const criteriaItems = document.querySelectorAll('.criteria-item.passed');
                        const criteriaCount = criteriaItems.length;
                        const progressBar = document.getElementById('criteria-progress-bar');
                        const criteriaCountSpan = document.getElementById('criteria-count');

                        if (progressBar) {
                            progressBar.style.width = `${criteriaCount * 25}%`;
                        }

                        if (criteriaCountSpan) {
                            criteriaCountSpan.textContent = `${criteriaCount}/4 tiêu chí đạt`;
                        }
                    }

                    // Đặt hàm cập nhật tiêu chí vào biến toàn cục để có thể gọi từ nơi khác
                    window.updateCriteria = updateCriteria;

                    // Gọi hàm cập nhật tiêu chí khi trang tải xong
                    // Đợi lâu hơn để đảm bảo Select2 và các phần tử khác đã được khởi tạo hoàn toàn
                    setTimeout(updateCriteria, 1000);

                    // Thêm sự kiện lắng nghe cho các trường dữ liệu
                    $('#title').on('input', updateCriteria);
                    $('.select2').on('change', updateCriteria);

                    // Kiểm tra nội dung khi editor thay đổi
                    if (typeof tinymce !== 'undefined') {
                        tinymce.on('AddEditor', function(e) {
                            e.editor.on('input change', function() {
                                updateCriteria();
                            });
                        });
                    }
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
                    const moderationLoading = document.getElementById('moderation-loading');
                    const errorDiv = document.getElementById('moderation-error');
                    const errorMessage = document.getElementById('error-message');
                    const submitButton = document.getElementById('submitButton');

                    // Đảm bảo mặc định nút submit được bật và không có kiểm duyệt ảnh hiển thị
                    submitButton.disabled = false;
                    window.isImageChanged = false; // Theo dõi xem người dùng đã thay đổi ảnh chưa
                    window.isImageValid = true; // Mặc định ảnh hiện tại là hợp lệ

                    // Ẩn tất cả các phần tử kiểm duyệt ảnh khi trang mới tải
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (moderationResult) moderationResult.style.display = 'none';
                    if (moderationLoading) moderationLoading.style.display = 'none';
                    if (errorDiv) errorDiv.style.display = 'none';

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
                                window.isImageChanged = true; // Người dùng đã thay đổi ảnh
                                window.isImageValid = false; // Đặt lại trạng thái khi có ảnh mới

                                // Ẩn ảnh hiện tại, hiển thị xem trước
                                if (currentImageContainer) {
                                    currentImageContainer.style.display = 'none';
                                }

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview.src = e.target.result;
                                    previewContainer.style.display = 'block';
                                };
                                reader.readAsDataURL(file);

                                // Hiển thị trạng thái kiểm duyệt
                                moderationResult.style.display = 'block';
                                moderationLoading.style.display = 'block';
                                errorDiv.style.display = 'none';

                                // Tạm thời vô hiệu hóa nút submit cho đến khi kiểm duyệt hoàn tất
                                submitButton.disabled = true;

                                // Gửi request kiểm duyệt ảnh
                                if (document.querySelector('meta[name="csrf-token"]')) {
                                    const formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                                    // Gửi API kiểm duyệt
                                    fetch('/api/check-image-moderation', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            },
                                        })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Lỗi kết nối: ' + response.status);
                                            }
                                            return response.json();
                                        })
                                        .then(result => {
                                            moderationLoading.style.display = 'none';

                                            if (result.status === 'error') {
                                                errorDiv.style.display = 'block';
                                                errorMessage.textContent = result.message ||
                                                    'Có lỗi xảy ra khi kiểm duyệt hình ảnh';
                                                submitButton.disabled = true;
                                                isImageValid = false;
                                            } else if (result.violation_level !== 'none') {
                                                errorDiv.style.display = 'block';
                                                let violationMessages = [];

                                                for (let violation in result.reason) {
                                                    violationMessages.push(result.reason[violation]);
                                                }

                                                errorMessage.innerHTML =
                                                    `Vi phạm: ${violationMessages.join(', ')}`;
                                                submitButton.disabled = true;
                                                window.isImageValid = false;
                                                if (typeof window.updateCriteria === 'function') {
                                                    window.updateCriteria();
                                                }
                                            } else {
                                                errorDiv.style.display = 'none';
                                                submitButton.disabled = false;
                                                window.isImageValid = true;
                                                if (typeof window.updateCriteria === 'function') {
                                                    window.updateCriteria();
                                                }
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi kiểm duyệt:', error);
                                            moderationLoading.style.display = 'none';
                                            errorDiv.style.display = 'block';
                                            errorMessage.textContent =
                                                'Có lỗi xảy ra khi kiểm duyệt hình ảnh: ' + error.message;
                                            submitButton.disabled = true;
                                            window.isImageValid = false;
                                            if (typeof window.updateCriteria === 'function') {
                                                window.updateCriteria();
                                            }
                                        });
                                }
                            } else {
                                // Nếu người dùng hủy chọn ảnh
                                window.isImageChanged = false;
                                if (currentImageContainer) {
                                    currentImageContainer.style.display = 'block';
                                }
                                previewContainer.style.display = 'none';
                                moderationResult.style.display = 'none';
                                errorDiv.style.display = 'none';
                                submitButton.disabled = false;
                                window.isImageValid = true;
                                if (typeof window.updateCriteria === 'function') {
                                    window.updateCriteria();
                                }
                            }
                        });
                    }

                    // Kiểm tra trước khi submit form
                    document.getElementById('articleForm').addEventListener('submit', function(e) {
                        // Nếu là lưu nháp, cho phép submit mà không cần kiểm tra
                        if (document.activeElement.id === 'saveDraft') {
                            document.getElementById('articleStatus').value = 'draft';
                            return true;
                        }

                        // Nếu không phải lưu nháp, đặt trạng thái là pending
                        document.getElementById('articleStatus').value = 'pending';

                        // Kiểm tra ảnh có vi phạm không
                        if (window.isImageChanged && imageUpload && imageUpload.files && imageUpload.files[0] && !window.isImageValid) {
                            e.preventDefault();
                            alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                            return false;
                        }

                        // Kiểm tra các tiêu chí khác
                        const criteriaItems = document.querySelectorAll('.criteria-item.passed');
                        const criteriaCount = criteriaItems.length;

                        if (criteriaCount < 4) {
                            // Sử dụng SweetAlert2 thay vì confirm mặc định
                            e.preventDefault(); // Ngăn chặn submit form trước

                            // Tạo danh sách các tiêu chí chưa đạt
                            const failedCriteria = [];
                            document.querySelectorAll('.criteria-item.failed').forEach(item => {
                                const criteriaText = item.querySelector('.criteria-text').textContent.split('(')[0].trim();
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
                                if (result.isConfirmed) {
                                    // Nếu người dùng xác nhận, submit form
                                    document.getElementById('articleForm').submit();
                                }
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

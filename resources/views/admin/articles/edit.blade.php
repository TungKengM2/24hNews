@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Bài Viết
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CKBox -->
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/z5nmbwpgzi1mqfjo2czz0cu8h05tmwnkumfhvwkcnr16tn3a/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Mammoth (Word to HTML) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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
                                <p>Các hình ảnh vi phạm đã bị xóa khỏi nội dung bài viết. Bạn vẫn có thể lưu bài viết dưới
                                    dạng nháp hoặc xác nhận tiếp tục gửi.</p>
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

                        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
                            id="articleForm">
                            @csrf
                            @method('PUT')

            <!-- Main content -->
            <div class="card p-4">
                        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data"
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

                            <!-- Nội dung bài viết -->
                            <div class="form-section">
                                <h4 class="form-section-title">Nội dung bài viết</h4>
                                <div class="mb-3">
                                    <label for="word_file" class="form-label">Nhập nội dung từ file Word</label>
                                    <input type="file" class="form-control" id="word_file" accept=".docx">
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung</label>
                                    @if (session()->has('violations') && !empty(session('violations')))
                                        <textarea id="full-featured" name="content"
                                            style="height: 800px; background: #ffe6e6; padding: 10px; border: 1px solid red;">
                                        {!! old('content', $article->content) !!}
                                        </textarea>
                                    @else
                                        <textarea id="full-featured" name="content" style="height: 800px;">
                                {{ old('content', $article->content) }}
                                        </textarea>
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

                            <input type="hidden" name="author_id" value="{{ $article->author_id }}">
                            <input type="hidden" name="status" id="articleStatus" value="{{ $article->status }}">
                            <input type="hidden" name="has_blocked_images" id="has_blocked_images" value="false">
                            <input type="hidden" name="confirmed_submit" id="confirmed_submit" value="false">
                            <input type="hidden" name="blocked_images_list" id="blocked_images_list" value="">

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

                        <script>
                            $(document).ready(function() {
                                $('.select2').select2({
                                    tags: true,
                                    tokenSeparators: [','],
                        placeholder: 'Chọn hoặc nhập thẻ mới',
                        allowClear: true,
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
                });
            </script>
            <script>
                // Lưu nháp
                document.getElementById('saveDraft').addEventListener('click', function() {
                    document.getElementById('articleStatus').value = 'draft';
                    document.getElementById('articleForm').submit();
                });

                document.getElementById('articleForm').addEventListener('submit', function(e) {
                    if (document.activeElement.id !== 'saveDraft') {
                        document.getElementById('articleStatus').value = 'pending';

                        const errorDiv = document.getElementById('moderation-error');
                        if (errorDiv && errorDiv.style.display !== 'none') {
                            e.preventDefault();
                            alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                            return false;
                        }
                    }
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const imageUpload = document.getElementById('thumbnail_url');
                    const imagePreview = document.getElementById('image-preview');
                    const previewContainer = document.getElementById('image-preview-container');
                    const currentImageContainer = document.getElementById('current-image-container');
                    const moderationResult = document.getElementById('moderation-result');
                    const moderationLoading = document.getElementById('moderation-loading');
                    const errorDiv = document.getElementById('moderation-error');
                    const errorMessage = document.getElementById('error-message');
                    const submitButton = document.getElementById('submitButton');
                    let isImageValid = true;

                    if (imageUpload) {
                        imageUpload.addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                isImageValid = false;

                                if (currentImageContainer) {
                                    currentImageContainer.style.display = 'none';
                                }
                            });

                            // Tạo slug tự động
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
                            });

                            const violationDescriptions = {
                                'nudity': 'Hình ảnh chứa nội dung nhạy cảm, khỏa thân hoặc gợi dục',
                                'violence': 'Hình ảnh chứa cảnh bạo lực, đánh đập hoặc gây tổn thương',
                                'text_violation': 'Hình ảnh chứa văn bản vi phạm quy định (ngôn từ thô tục, kích động)',
                                'gore': 'Hình ảnh chứa cảnh máu me, tổn thương cơ thể',
                                'self_harm': 'Hình ảnh liên quan đến tự gây thương tích hoặc tự tử',
                                'gambling': 'Hình ảnh liên quan đến cờ bạc, đánh bạc',
                            };

                            let isImageValid = true; // Mặc định là true vì ảnh không bắt buộc khi chỉnh sửa
                            const submitButton = document.getElementById('submitButton');

                            document.getElementById('thumbnail_url').addEventListener('change', function(e) {
                                const file = e.target.files[0];
                                if (file) {
                                    isImageValid = false;

                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        document.getElementById('image-preview').src = e.target.result;
                                        document.getElementById('image-preview-container').style.display = 'block';
                                        document.getElementById('current-image').style.display = 'none';
                                    };
                                    reader.readAsDataURL(file);

                                    const formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

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
                                            const moderationResult = document.getElementById('moderation-result');
                                            const errorDiv = document.getElementById('moderation-error');
                                            const errorMessage = document.getElementById('error-message');

                                            moderationResult.style.display = 'block';

                                            if (result.status === 'error') {
                                                errorDiv.style.display = 'block';
                                                errorMessage.textContent = result.message ||
                                                    'Có lỗi xảy ra khi kiểm duyệt hình ảnh';
                                                isImageValid = false;
                                                submitButton.disabled = true;
                                            } else if (result.violation_level !== 'none') {
                                                errorDiv.style.display = 'block';
                                                let violationMessages = [];

                                                for (let violation in result.reason) {
                                                    violationMessages.push(result.reason[violation]);
                                                }

                                                errorMessage.innerHTML = `Vi phạm: ${violationMessages.join(', ')}`;
                                                isImageValid = false;
                                                submitButton.disabled = true;
                                            } else {
                                                errorDiv.style.display = 'none';
                                                isImageValid = true;
                                                submitButton.disabled = false;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi kiểm duyệt:', error);
                                            const moderationResult = document.getElementById('moderation-result');
                                            const errorDiv = document.getElementById('moderation-error');
                                            const errorMessage = document.getElementById('error-message');

                                            moderationResult.style.display = 'block';
                                            errorDiv.style.display = 'block';
                                            errorMessage.textContent = 'Có lỗi xảy ra khi kiểm duyệt hình ảnh: ' + error.message;
                                            isImageValid = false;
                                            submitButton.disabled = true;
                                        });
                                } else {
                                    // Nếu không chọn ảnh mới, hiện lại ảnh cũ
                                    document.getElementById('image-preview-container').style.display = 'none';
                                    document.getElementById('current-image').style.display = 'block';
                                    document.getElementById('moderation-result').style.display = 'none';
                                    isImageValid = true;
                                    submitButton.disabled = false;
                                }
                            });

                            const form = document.getElementById('articleForm');
                            form.addEventListener('submit', function(e) {
                                const thumbnailInput = document.getElementById('thumbnail_url');
                                if (document.getElementById('articleStatus').value === 'draft') {
                                    return true;
                                }

                    document.getElementById('articleForm').addEventListener('submit', function(e) {
                        if (document.activeElement.id !== 'saveDraft') {
                            document.getElementById('articleStatus').value = 'pending';

                            if (imageUpload.files && imageUpload.files[0] && !isImageValid) {
                                e.preventDefault();
                                alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                                return false;
                            }
                        }
                    });
                            });
                        </script>

                            const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

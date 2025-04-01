@extends('admin.layouts.master')

@section('head')
    <!-- Style -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Tags styling */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Image preview styling */
        #image-preview-container {
            margin-top: 10px;
            text-align: center;
            max-width: 300px;
        }

        #image-preview {
            max-height: 150px;
            max-width: 100%;
            width: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Moderation result styling */
        #moderation-result {
            margin-top: 10px;
        }

        .moderation-loading {
            text-align: center;
            padding: 10px;
        }

        /* Violation levels */
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

        /* Form section styling */
        .form-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-section-title {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Button styling */
        .action-buttons {
            margin-top: 30px;
        }

        .action-buttons .btn {
            padding: 8px 20px;
            margin-right: 10px;
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

                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    imagePreview.src = e.target.result;
                                    previewContainer.style.display = 'block';
                                };
                                reader.readAsDataURL(file);

                                moderationResult.style.display = 'block';
                                moderationLoading.style.display = 'block';
                                errorDiv.style.display = 'none';
                                submitButton.disabled = true;

                                if (document.querySelector('meta[name="csrf-token"]')) {
                                    const formData = new FormData();
                                    formData.append('image', file);
                                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                                        .content);

                                    fetch('/api/check-image-moderation', {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content,
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
                                                isImageValid = false;
                                            } else {
                                                errorDiv.style.display = 'none';
                                                submitButton.disabled = false;
                                                isImageValid = true;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi kiểm duyệt:', error);
                                            moderationLoading.style.display = 'none';
                                            errorDiv.style.display = 'block';
                                            errorMessage.textContent =
                                                'Có lỗi xảy ra khi kiểm duyệt hình ảnh: ' + error.message;
                                            submitButton.disabled = true;
                                            isImageValid = false;
                                        });
                                }
                            } else {
                                if (currentImageContainer) {
                                    currentImageContainer.style.display = 'block';
                                }
                                previewContainer.style.display = 'none';
                                moderationResult.style.display = 'none';
                                errorDiv.style.display = 'none';
                                submitButton.disabled = false;
                                isImageValid = true;
                            }
                        });
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

@endsection

@section('scripts')
@endsection

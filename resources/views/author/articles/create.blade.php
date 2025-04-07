@extends('author.layouts.master')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    </style>
@endsection

@section('title')
    Tạo bài viết mới
@endsection

@section('content')
    <!-- Main content -->
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5 ">
                    <div class="card p-4">
                        <div class="content-header">
                            <div class="d-flex align-items-center">
                                <div class="me-auto">
                                    <h4 class="page-title">Tạo Bài Viết Mới</h4>
                                    <div class="d-inline-block align-items-center">
                                        <nav>
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('author.dashboard') }}"><i class="mdi mdi-home-outline"></i></a></li>
                                                <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                                <li class="breadcrumb-item active" aria-current="page">Tạo Bài Viết</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('author.writing-guidelines') }}" class="btn btn-info">
                                        <i class="fas fa-book"></i> Xem hướng dẫn viết bài
                                    </a>
                                </div>
                            </div>
                        </div>

                        <h2 class="mb-4">Tạo Bài Viết Mới</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger error_message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('warnings'))
                            <div class="alert alert-warning">
                                <ul>
                                    @foreach (session('warnings') as $warning)
                                        <li>{{ $warning }}</li>
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

                        <form action="{{ route('author.articles.store') }}" method="POST" enctype="multipart/form-data"
                            id="articleForm">
                            @csrf

                            <div class="form-section">
                                <h4 class="form-section-title">Thông tin cơ bản</h4>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ old('title') }}" required>
                                        <small class="form-text text-muted">Tối đa 255 ký tự</small>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="slug" class="form-label">Đường dẫn <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                            value="{{ old('slug') }}" required>
                                        <small class="form-text text-muted">Tối đa 255 ký tự, chỉ chấp nhận chữ cái, số và dấu gạch ngang</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="tags">Chọn hoặc thêm thẻ:</label>
                                        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->tag_id }}"
                                                    {{ in_array($tag->tag_id, old('tags', [])) ? 'selected' : '' }}>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Ảnh đại diện</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="thumbnail_url" class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                                        <input type="file"
                                            class="form-control @error('thumbnail_url') is-invalid @enderror"
                                            id="thumbnail_url" name="thumbnail_url" accept="image/*" required>
                                        <small class="form-text text-muted">Kích thước tối thiểu: 1200x630px, tối đa 2MB</small>

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
                                            <img id="image-preview" src="#" alt="Xem trước" class="img-fluid mb-2">
                                        </div>

                                        <div id="moderation-result" style="display: none;">
                                            <div id="moderation-error" class="alert alert-danger" style="display: none;">
                                                <strong>Lỗi!</strong> <span id="error-message"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="form-section">
                                <h4 class="form-section-title">Nội dung bài viết</h4>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                    @if (session()->has('violations') && !empty(session('violations')))
                                        <textarea id="full-featured" name="content" style="height: 800px; background: #ffe6e6; padding: 10px; border: 1px solid red;">
                                            {!! highlightWords(old('content'), session('violations')) !!}
                                        </textarea>
                                    @else
                                        <textarea id="full-featured" name="content" style="height: 800px;">
                                            {{ old('content') }}
                                        </textarea>
                                    @endif
                                    <div class="mt-2">
                                        <small class="form-text text-muted">
                                            <strong>Yêu cầu về nội dung:</strong>
                                            <ul>
                                                <li>Tối thiểu 500 từ</li>
                                                <li>Phải có đầy đủ các phần: Mở bài, Thân bài, Kết luận</li>
                                                <li>Tối thiểu 1 hình ảnh cho mỗi 500 từ</li>
                                                <li>Tất cả hình ảnh phải có alt text</li>
                                                <li>Khi trích dẫn phải ghi rõ nguồn</li>
                                            </ul>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="status" id="articleStatus" value="pending">

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary" id="submitButton">Gửi đi</button>
                                <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                            </div>
                        </form>

                        <!-- Scripts -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                        <script>
                            $(document).ready(function() {
                                $('#tags').select2({
                                    tags: true,
                                    tokenSeparators: [','],
                                    placeholder: 'Chọn hoặc nhập thẻ mới',
                                    allowClear: true,
                                });

                                // Tự động tạo slug từ tiêu đề
                                $('#title').on('keyup', function() {
                                    var title = $(this).val();
                                    var slug = title.toLowerCase()
                                        .replace(/[^\w\s-]/g, '')
                                        .replace(/\s+/g, '-')
                                        .replace(/-+/g, '-');
                                    $('#slug').val(slug);
                                });

                                // Xử lý nút lưu nháp
                                $('#saveDraft').click(function() {
                                    $('#articleStatus').val('draft');
                                    $('#articleForm').submit();
                                });

                                // Xử lý nút gửi đi
                                $('#submitButton').click(function() {
                                    $('#articleStatus').val('pending');
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

                                    // Kiểm tra trước khi submit form
                                    const form = document.getElementById('articleForm');
                                    if (form) {
                                        form.addEventListener('submit', function(e) {
                                            if (document.getElementById('articleStatus').value === 'draft') {
                                                return true;
                                            }

                                            const thumbnailInput = document.getElementById('thumbnail_url');
                                            if (thumbnailInput && thumbnailInput.files && thumbnailInput.files[0] && !isImageValid) {
                                                e.preventDefault();
                                                alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                                                thumbnailInput.focus();
                                                return false;
                                            }
                                            return true;
                                        });
                                    }
                                });
                            });
                        </script>

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

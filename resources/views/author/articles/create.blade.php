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
    </style>
@endsection

@section('title')
    Thêm Mới Bài Viết
@endsection

@section('content')
    <!-- Main content -->
    <div class="wrapper">
        <div class="container mt-5 ">
            <div class="card p-2">
                <h2 class="mb-4">Create New Post</h2>
                @if ($errors->any())
                    <div class="alert alert-danger error_message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('blocked_images'))
                    <div class="alert alert-warning error_message">
                        <strong>Cảnh báo: Một số hình ảnh đã bị chặn</strong>
                        <ul>
                            @foreach(session('blocked_images') as $image)
                                <li>
                                    <strong>{{ $image['filename'] ?? 'Hình ảnh' }}</strong>:
                                    @if(isset($image['reason']) && is_array($image['reason']))
                                        {{ implode(', ', array_values($image['reason'])) }}
                                    @else
                                        {{ $image['reason'] ?? 'Vi phạm quy định nội dung' }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <p>Các hình ảnh vi phạm đã bị xóa khỏi nội dung bài viết. Bạn vẫn có thể lưu bài viết dưới dạng
                            nháp hoặc xác nhận tiếp tục gửi.</p>
                    </div>
                @endif

                @if(session('violation_reasons'))
                    <div class="alert alert-warning error_message">
                        <strong>Lý do vi phạm:</strong>
                        <ul>
                            @if(is_array(session('violation_reasons')))
                                @foreach(session('violation_reasons') as $word => $reason)
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
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        @if(session()->has('violations') && !empty(session('violations')))
                            <textarea id="full-featured" name="content"
                                      style="height: 800px; background: #ffe6e6; padding: 10px; border: 1px solid red;">
                              {!! highlightWords(old('content', isset($article) ? $article->content : ''), session('violations')) !!}
                              </textarea>
                        @else
                            <textarea id="full-featured" name="content"
                                      style="height: 800px;">
                    {{ old('content', isset($article) ? $article->content : '') }}
                    </textarea>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="tags">Chọn hoặc thêm tags:</label>
                        <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option
                                    value="{{ $tag->tag_id }}" {{ in_array($tag->tag_id, old('tags', [])) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                @if ($category->is_active)
                                    <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail_url" class="form-label">Ảnh đại diện</label>
                        <input type="file" class="form-control @error('thumbnail_url') is-invalid @enderror"
                               id="thumbnail_url" name="thumbnail_url" accept="image/*" required>

                        <div id="image-preview-container" style="display: none;">
                            <img id="image-preview" src="#" alt="Preview" class="img-fluid mb-2">
                        </div>

                        <div id="moderation-result" style="display: none;">
                            <div id="moderation-error" class="alert alert-danger" style="display: none;">
                                <strong>Lỗi!</strong> <span id="error-message"></span>
                            </div>
                        </div>

                        @error('thumbnail_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                        @if (session('thumbnail_reasons'))
                            <div class="alert alert-warning mt-2">
                                <strong>Ảnh đại diện vi phạm quy định!</strong>
                                <ul>
                                    @foreach(session('thumbnail_reasons') as $key => $reason)
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


                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                    <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="status" id="articleStatus" value="pending">

                    <button type="submit" class="btn btn-primary" id="submitButton">Gửi đi</button>
                    <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                </form>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                <script>
                    $(document).ready(function () {
                        $('#tags').select2({
                            tags: true,
                            tokenSeparators: [','],
                            placeholder: 'Chọn hoặc nhập tags mới',
                            allowClear: true,
                        });
                    });

                    // Lưu nháp bài viết
                    document.getElementById('saveDraft').addEventListener('click', function () {
                        document.getElementById('articleStatus').value = 'draft';
                        document.getElementById('articleForm').setAttribute('novalidate', 'novalidate'); // Bỏ qua required
                        document.getElementById('articleForm').submit();
                    });

                    // Cảnh báo khi người dùng rời khỏi trang nếu có thay đổi
                    let isFormEdited = false;
                    const formElements = document.getElementById('articleForm').elements;

                    for (let i = 0; i < formElements.length; i++) {
                        formElements[i].addEventListener('change', function () {
                            isFormEdited = true;
                        });
                    }

                    window.addEventListener('beforeunload', function (e) {
                        if (isFormEdited) {
                            const confirmationMessage =
                                'Bạn có chắc chắn muốn rời khỏi trang? Những thay đổi chưa được lưu sẽ bị mất.';
                            e.returnValue = confirmationMessage;
                            return confirmationMessage;
                        }
                    });

                    // Tạo slug tự động
                    document.getElementById('title').addEventListener('input', function () {
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

                    let isImageValid = false;
                    const submitButton = document.getElementById('submitButton');

                    document.getElementById('thumbnail_url').addEventListener('change', function (e) {
                        const file = e.target.files[0];
                        if (file) {
                            isImageValid = false;

                            const reader = new FileReader();
                            reader.onload = function (e) {
                                document.getElementById('image-preview').src = e.target.result;
                                document.getElementById('image-preview-container').style.display = 'block';
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
                                        errorMessage.textContent = result.message || 'Có lỗi xảy ra khi kiểm duyệt hình ảnh';
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
                        }
                    });

                    const form = document.getElementById('articleForm');
                    form.addEventListener('submit', function (e) {
                        const thumbnailInput = document.getElementById('thumbnail_url');
                        if (document.getElementById('articleStatus').value === 'draft') {
                            return true;
                        }

                        if (thumbnailInput.files && thumbnailInput.files[0] && !isImageValid) {
                            e.preventDefault();
                            alert('Vui lòng chọn hình ảnh khác tuân thủ quy định nội dung.');
                            thumbnailInput.focus();
                            return false;
                        }
                        return true;
                    });
                </script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
                <script>
                    document.getElementById('thumbnail_url').addEventListener('change', function (event) {
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
                                        console.error('Lỗi đọc file:', error);
                                    });
                            };
                            reader.readAsArrayBuffer(file);
                        }
                    });
                </script>


            </div>
        </div>
    </div>
@endsection

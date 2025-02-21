@extends('author.layouts.app')
@section('title', 'Quản lý bài viết')

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

                <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

                <form action="{{ route('author.articles.store') }}" method="POST" enctype="multipart/form-data"
                      id="articleForm">
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
                        <div id="editor"></div>
                        <textarea id="content" name="content" style="display: none;"></textarea>
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
                        <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url"
                               accept="image/*" required>
                    </div>


                    <!-- Tự động gán tác giả -->
                    <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                    <input type="hidden" name="status" id="articleStatus" value="pending">

                    <button type="submit" class="btn btn-primary">Gửi</button>
                    <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                </form>


                <script>
                    // Lưu nháp bài viết
                    document.getElementById('saveDraft').addEventListener('click', function () {
                        document.getElementById('articleStatus').value = 'draft';
                        document.getElementById('articleForm').setAttribute('novalidate', 'novalidate'); // Bỏ qua required
                        document.getElementById('articleForm').submit();
                    });

                    // Cập nhật nội dung từ editor vào textarea trước khi submit
                    document.getElementById('articleForm').addEventListener('submit', function () {
                        document.getElementById('content').value = document.getElementById('editor').innerHTML;
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
                </script>

                {{-- Đọc nội dung file Word (nếu có) --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

@endsection

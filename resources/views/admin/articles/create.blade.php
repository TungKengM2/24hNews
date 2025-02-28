<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>Thêm Mới Bài Viết</title>

    <!-- Vendors Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css" />

    <link rel="stylesheet"
        href="https://cdn.ckeditor.com/ckeditor5-premium-features/44.2.0/ckeditor5-premium-features.css" />
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        @include('admin.layouts.partials.header')

        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.layouts.partials.aside')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h4 class="page-title">Thêm Mới Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                        <li class="breadcrumb-item active" aria-current="page">Thêm Mới</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Main content -->
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

                            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data"
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
                                    <label for="tags">Chọn hoặc thêm tags:</label>
                                    <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->tag_id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
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

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                                <!-- Tự động gán tác giả -->
                                <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                                <input type="hidden" name="status" id="articleStatus" value="pending">

                                <button type="submit" class="btn btn-primary">Gửi</button>
                                <button type="button" class="btn btn-secondary" id="saveDraft">Lưu nháp</button>
                            </form>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                            <script>
                                $(document).ready(function() {
                                    $('#tags').select2({
                                        tags: true,
                                        tokenSeparators: [','],
                                        placeholder: "Chọn hoặc nhập tags mới",
                                        allowClear: true
                                    });
                                });

                                // Lưu nháp bài viết
                                document.getElementById('saveDraft').addEventListener('click', function() {
                                    document.getElementById('articleStatus').value = 'draft';
                                    document.getElementById('articleForm').setAttribute('novalidate', 'novalidate'); // Bỏ qua required
                                    document.getElementById('articleForm').submit();
                                });

                                // Cập nhật nội dung từ editor vào textarea trước khi submit
                                document.getElementById('articleForm').addEventListener('submit', function() {
                                    document.getElementById('content').value = document.getElementById('editor').innerHTML;
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
                            </script>

                            {{-- Đọc nội dung file Word (nếu có) --}}
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.8/mammoth.browser.min.js"></script>
                            <script>
                                document.getElementById('thumbnail_url').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            const arrayBuffer = e.target.result;
                                            mammoth.extractRawText({
                                                    arrayBuffer: arrayBuffer
                                                })
                                                .then(function(result) {
                                                    document.getElementById('editor').innerHTML = result.value;
                                                })
                                                .catch(function(error) {
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
                <!-- ./wrapper -->

                <!-- Vendor JS -->
                <script src="{{ asset('admin/main/js/vendors.min.js') }}"></script>
                <script src="{{ asset('admin/main/js/pages/chat-popup.js') }}"></script>
                <script src="{{ asset('admin/assets/icons/feather-icons/feather.min.js') }}"></script>
                <script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
                <script src="{{ asset('admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
                <script src="{{ asset('admin/assets/vendor_components/zingchart_branded_version/zingchart.min.js') }}"></script>
                <script src="{{ asset('./admin/assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>

                <!-- CrmX Admin App -->
                <script src="{{ asset('admin/main/js/template.js') }}"></script>
                <script src="{{ asset('admin/main/js/demo.js') }}"></script>
                <script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>


</body>

</html>

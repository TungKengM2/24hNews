<!DOCTYPE html>
<html lang="en">

<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
=======
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>Cập Nhập Bài Viết</title>

    <!-- Vendors Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">
>>>>>>> dat
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="https://cdn.ckbox.io/ckbox/2.4.0/ckbox.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<<<<<<< HEAD
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .wrapper {
            display: flex;
        }
        .container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 300px;
=======

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #c3bebe;
            color: white;
            border: 1px solid #c2c2c2;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
>>>>>>> dat
        }
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
<<<<<<< HEAD
        @include('admin.menu')
        <div class="container mt-5">
            <div class="card p-2">
                <h2 class="mb-4">Update Post</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ $article->slug }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea id="content" name="content" class="form-control">{!! $article->content !!}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Chọn hoặc thêm tags:</label>
                        <select name="tags[]" class="form-control select2" multiple="multiple">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->tag_id }}" @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->category_id }}" {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                    <div class="mt-3">
                        <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                        <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                        @if ($article->thumbnail_url)
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail" width="100">
                        @endif
                    </div>
                    

                    <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                tags: true,
                tokenSeparators: [','],
                placeholder: "Chọn hoặc nhập tags mới",
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
=======
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
                            <h4 class="page-title">Cập Nhập Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                        <li class="breadcrumb-item active" aria-current="page">Cập Nhập</li>
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

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $article->slug }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung</label>
                            <textarea id="content" name="content" class="form-control">{!! $article->content !!}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chọn hoặc thêm tags:</label>
                            <select name="tags[]" class="form-control select2" multiple="multiple">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->tag_id }}"
                                        @if (in_array($tag->tag_id, $selectedTags)) selected @endif>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Danh mục</label>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}"
                                        {{ $article->category_id == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <input type="hidden" name="author_id" value="{{ $article->author_id }}">

                        <div class="mt-3">
                            <label class="form-label" for="thumbnail_url">Ảnh Đại Diện</label>
                            <input class="form-control" type="file" name="thumbnail_url" id="thumbnail_url">
                            @if ($article->thumbnail_url)
                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Current Thumbnail"
                                    width="100">
                            @endif
                        </div>


                        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                    </form>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            tags: true,
                            tokenSeparators: [','],
                            placeholder: "Chọn hoặc nhập tags mới",
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


                <!-- /.content-wrapper -->

                @include('admin.layouts.partials.footer')

                <!-- Control Sidebar -->
                <!-- /.control-sidebar -->

                <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
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
        </div>

>>>>>>> dat
</body>

</html>

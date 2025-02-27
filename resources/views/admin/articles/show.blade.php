<!DOCTYPE html>
<<<<<<< HEAD
<html lang="vi">
=======
<html lang="en">
>>>>>>> dat

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<<<<<<< HEAD
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài viết</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-display img {
            max-width: 100%;
            height: auto;
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .thumbnail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .tag-badge {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h2 class="mb-4">Chi tiết bài viết</h2>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Thông tin bài viết</div>
            <div class="card-body">
                <h3 class="card-title">{{ $article->title }}</h3>
                <p class="text-muted">Slug: {{ $article->slug }}</p>

                @if ($article->thumbnail_url)
                    <div class="mb-3 text-center thumbnail">
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail" class="img-fluid">
                    </div>
                @endif

                <div class="mb-3 content-display">
                    <strong>Nội dung bài viết:</strong>
                    <div>{!! $article->content !!}</div>
                </div>

                @if ($article->preview_content)
                    <div class="mb-3">
                        <strong>Mô tả ngắn:</strong>
                        <p>{{ $article->preview_content }}</p>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>Nội dung nhạy cảm:</strong>
                    <p>{{ $article->contains_sensitive_content ? 'Có' : 'Không' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Tác giả:</strong>
                        <p>{{ $article->author->username ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Danh mục:</strong>
                        <p>{{ $article->category->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Trạng thái:</strong>
                        <p><span class="badge bg-info text-dark">{{ ucfirst($article->status) }}</span></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Lượt xem:</strong>
                        <p>{{ $article->views }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Người duyệt:</strong>
                    <p>{{ $article->approver->username ?? 'Chưa duyệt' }}</p>
                </div>

                @if ($article->tags->count() > 0)
                    <div class="mb-3">
                        <strong>Tags:</strong>
                        <div>
                            @foreach ($article->tags as $tag)
                                <span class="tag-badge">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary">
                        <i class="lni lni-pencil"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">
                        <i class="lni lni-list"></i> Quay lại danh sách
                    </a>

                    <form action="{{ route('articles.destroy', $article->article_id) }}" method="POST"
                        class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="lni lni-trash-can"></i> Xóa
                        </button>
                    </form>
=======
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}">

    <title>Danh Sách Bài Viết</title>

    <!-- Vendors Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/vendors_css.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('admin/main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/main/css/skin_color.css') }}">
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
                            <h4 class="page-title">Chi Tiết Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Danh Sách Bài Viết</li>
                                        <li class="breadcrumb-item active" aria-current="page">Chi Tiết</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
>>>>>>> dat
                </div>

                <!-- Main content -->

                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Title: {{ $article->title }}</h4> <br>
                        <h6 class="box-title mt-2">Slug: {{ $article->slug }}</h6>
                    </div>
                    <div class="box-body">
                        <div id="slimtest2">
                            <div class="row">

                                <p class="col-md-5">Preview Content: {{ $article->preview_content }}</p>
                                <div class="row">
                                    <p class="col-md-5">Content:</p>
                                    <div class="col-md-7">
                                        <p>{!! $article->content !!}</p>
                                    </div>
                                </div>

                                <div>
                                    @if ($article->thumbnail_url)
                                        <div class="mb-3">
                                            <strong>Thumbnail:</strong>
                                            <br>
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail"
                                                class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="row" style="margin-top: 50px">

                                    <div class="col-2">
                                        <strong>Contains Sensitive Content?</strong>
                                        <p>{{ $article->contains_sensitive_content ? 'Yes' : 'No' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Author:</strong>
                                        <p>{{ $article->author->username ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Category:</strong>
                                        <p>{{ $article->category->name ?? 'N/A' }}</p>
                                    </div>

                                    <div class="col-2">
                                        <strong>Status:</strong>
                                        <p>{{ ucfirst($article->status) }}</p>

                                    </div>

                                    <div class="col-2">
                                        <strong>Views:</strong>
                                        <p>{{ $article->views }}</p>

                                    </div>

                                    <div class="col-2">
                                        <strong>Approved By:</strong>
                                        <p>{{ $article->approver->username ?? 'Not Approved' }}</p>
                                    </div>


                                </div>

                                <div class="mt-4">
                                    <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                            href="{{ route('articles.index') }}">
                                            Back to Dashboard
                                        </a></button>
                                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm"><i
                                            class="si-pencil si"></i></a>
                                    <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                            <i class="si-trash si"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- /.box-body -->

                                @include('admin.layouts.partials.footer')

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

                            <!-- CrmX Admin App -->
                            <script src="{{ asset('admin/main/js/template.js') }}"></script>
                            <script src="{{ asset('admin/main/js/demo.js') }}"></script>
                            <script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>


</body>

</html>

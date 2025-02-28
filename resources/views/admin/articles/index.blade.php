<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                            <h4 class="page-title">Danh Sách Bài Viết</h4>
                            <div class="d-inline-block align-items-center">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="tables_data.html#"><i
                                                    class="mdi mdi-home-outline"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page">Trang Chủ</li>
                                        <li class="breadcrumb-item active" aria-current="page">Danh Sách Bài Viết</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Main content -->
                <div class="container-full">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">

                                <button type="button" class="waves-effect waves-light btn btn-default mb-5"><a
                                        href="{{ route('admin.dashboard') }}">
                                        Back to Dashboard
                                    </a></button>
                                <button type="button" class="waves-effect waves-light btn btn-primary mb-5"> <a
                                        href="{{ route('articles.create') }}">
                                        <i class="si-plus si"></i>
                                    </a></button>

                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="complex_header" class="table table-striped table-bordered display"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Slug</th>
                                                <th>Contains Sensitive Content</th>
                                                <th>Author</th>
                                                <th>Category</th>
                                                <th>Thumbnail</th>
                                                <th>Status</th>
                                                <th>Views</th>
                                                <th>Tags</th>
                                                <th>Approved By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($articles as $article)
                                                <tr>
                                                    <td>{{ $article->article_id }}</td>
                                                    <td>{{ $article->title }}</td>
                                                    <td>{{ $article->slug }}</td>
                                                    <td class="text-center">
                                                        @if ($article->contains_sensitive_content)
                                                            <span class="badge bg-danger">Yes</span>
                                                        @else
                                                            <span class="badge bg-success">No</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $article->author->username ?? 'Unknown' }}</td>
                                                    <td>{{ $article->category->name ?? 'Uncategorized' }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                            alt="Thumbnail" width="100" height="150">

                                                    </td>
                                                    <td>
                                                        @switch($article->status)
                                                            @case('draft')
                                                                <span class="badge bg-secondary">Draft</span>
                                                            @break

                                                            @case('pending')
                                                                <span class="badge bg-warning">Pending</span>
                                                            @break

                                                            @case('published')
                                                                <span class="badge bg-success">Published</span>
                                                            @break

                                                            @case('archived')
                                                                <span class="badge bg-danger">Archived</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>{{ $article->views }}</td>
                                                    <td>
                                                        @if ($article->tags->isNotEmpty())
                                                            @foreach ($article->tags as $tag)
                                                                <span
                                                                    class="badge bg-primary">{{ $tag->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">Không có tag</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $article->approved_by ? $article->approver->username : 'Not Approved' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('articles.show', $article) }}"
                                                            class="btn btn-info btn-sm"><i class="si-eye si"></i></a>

                                                        <a href="{{ route('articles.edit', $article) }}"
                                                            class="btn btn-warning btn-sm"><i
                                                                class="si-pencil si"></i></a>

                                                        @if ($article->status === 'pending')
                                                            <form action="{{ route('articles.approve', $article) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-success btn-sm"
                                                                    onclick="return confirm('Bạn có chắc chắn muốn duyệt bài viết này không?')">
                                                                    Approve
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form action="{{ route('articles.destroy', $article) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                                <i class="si-trash si"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

            <!-- CrmX Admin App -->
            <script src="{{ asset('admin/main/js/template.js') }}"></script>
            <script src="{{ asset('admin/main/js/demo.js') }}"></script>
            <script src="{{ asset('admin/main/js/pages/dashboard.js') }}"></script>


</body>

</html>

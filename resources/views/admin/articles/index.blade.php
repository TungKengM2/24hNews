@extends('admin.layouts.master')

<<<<<<< HEAD
@section('content')
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
=======
function formatPlainText($text)
{
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);
    $text = preg_replace('/\[([^\]]+)\](.*?)\[\/\1\]/', '<span style="color:$1">$2</span>', $text);

    return $text;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=account_circle" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        ::after,
        ::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .main {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            background-color: #fff;
            min-width: 0;
        }


        .toggle-btn {
            background-color: transparent;
            cursor: pointer;
            border: 0;
            padding: 1rem 1.5rem;
        }

        .toggle-btn i {
            font-size: 1.5rem;
            color: #FFF;
        }


        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .sidebar-logo {
            margin: auto 0;
            padding: 20px 50px;
        }

        .sidebar-logo a {
            color: #FFF;
            font-size: 1.15rem;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 2rem 0;
            flex: 1 1 auto;
        }

        a.sidebar-link {
            padding: .625rem 1.625rem;
            color: #FFF;
            display: block;
            font-size: 0.9rem;
            white-space: nowrap;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: .75rem;
        }

        a.sidebar-link:hover {
            background-color: rgba(255, 255, 255, .075);
            border-left: 3px solid #3b7ddd;
        }

        .sidebar-item:hover .sidebar-dropdown {
            display: block;
            background-color: #0e2238;
            padding-left: 1.625rem;
        }

        .sidebar-footer {
            margin: 1rem 1.625rem;
        }

        .navbar {
            background-color: #f5f5f5;
            box-shadow: 0 0 2rem 0 rgba(33, 37, 41, .1);
        }

        .navbar-expand .navbar-collapse {
            min-width: 200px;
        }

        .avatar {
            height: 40px;
            width: 40px;
        }

        a {
            text-decoration: none;
            /* Ensure no underline on links */
        }

        @media (min-width: 768px) {}
    </style>
</head>

<body>
    <div class="main">
        @include('admin.layouts.partials.header')
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">

                    <div class="row">
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class=" fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card  border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class="fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Memebers Progress
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        $72,540
                                    </p>
                                    <div class="mb-0">
                                        <span class="badge text-success me-2">
                                            +9.0%
                                        </span>
                                        <span class="fw-bold">
                                            Since Last Month
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="fw-bold fs-4 my-3">Avg. Agent Earnings
                    </h3>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h1>Danh sách bài viết</h1>
                            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                <i class="lni lni-arrow-left"></i> Back to Dashboard
                            </a>
                            <a class="btn btn-primary" href="{{ route('articles.create') }}">
                                <i class="lni lni-plus"></i>
                            </a>

                        </div>
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="highlight">
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
                                                    alt="Thumbnail" width="100" height="200">

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
                                                        <span class="badge bg-primary">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">Không có tag</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->approved_by ? $article->approver->username : 'Not Approved' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('articles.show', $article) }}"
                                                    class="btn btn-info btn-sm">Show</a>
                                                <a href="{{ route('articles.edit', $article) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>

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

                                                <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xoá bài viết này không?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $articles->links() }}
>>>>>>> tungkeng
                        </div>

                    </div>
                </div>
<<<<<<< HEAD

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
            </div>
        </div>
                <!-- /.content-wrapper -->
@endsection
=======
            </div>
        </main>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
>>>>>>> tungkeng

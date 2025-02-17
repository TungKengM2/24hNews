<?php

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
            /* box-sizing: border-box;
            margin: 0;
            padding: 0; */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #fff;
            margin: 0;
        }

        .main {
            display: flex;
            flex: 1;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
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

        .sidebar {

            color: #fff;
        }

        .content {
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>


    <div class="main">
        <div class="row ">
            <div class="sidebar col-3">
                @include('admin.menu')
            </div>

            <div class="content col-9">
                @include('admin.header')
                <main class="">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="card border-0">
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">Members Progress</h5>
                                            <p class="mb-2 fw-bold">$72,540</p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">+9.0%</span>
                                                <span class="fw-bold">Since Last Month</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card border-0">
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">Members Progress</h5>
                                            <p class="mb-2 fw-bold">$72,540</p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">+9.0%</span>
                                                <span class="fw-bold">Since Last Month</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card border-0">
                                        <div class="card-body py-4">
                                            <h5 class="mb-2 fw-bold">Members Progress</h5>
                                            <p class="mb-2 fw-bold">$72,540</p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">+9.0%</span>
                                                <span class="fw-bold">Since Last Month</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="fw-bold fs-4 my-3">Avg. Agent Earnings</h3>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h1>Thêm mới bài viết</h1>
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
                                                <th>Content</th>
                                                <th>Preview Content</th>
                                                <th>Contains Sensitive Content</th>
                                                <th>Author</th>
                                                <th>Category</th>
                                                <th>Thumbnail</th>
                                                <th>Status</th>
                                                <th>Views</th>
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
                                                    <td>{{ Str::limit($article->content, 50) }}</td>
                                                    <td>{{ Str::limit($article->preview_content, 50) }}</td>
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
                                                    <td>{{ $article->approved_by ? $article->approver->username : 'Not Approved' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm">
                                                            Show
                                                        </a>
                                                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning btn-sm">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>

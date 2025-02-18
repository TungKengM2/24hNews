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
    <div class="wrapper width-100 ">
        @include('admin.menu')


        <div class="card d-flex flex-column justify-content-center align-items-center w-50">
            <h2 class="mb-4">Chi tiết bài viết</h2>
            <div class="card-body d-flex flex-wrap align-items-start">
                <div class="col-md-6 mb-3">
                    <h3 class="card-title">Title: {{ $article->title }}</h3>
                    <p class="text-muted">Slug: {{ $article->slug }}</p>

                    <div class="mb-3">
                        <strong>Content:</strong>
                        <p>{{ $article->content }}</p>
                    </div>

                    @if ($article->preview_content)
                        <div class="mb-3">
                            <strong>Preview Content:</strong>
                            <p>{{ $article->preview_content }}</p>
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Contains Sensitive Content?</strong>
                        <p>{{ $article->contains_sensitive_content ? 'Yes' : 'No' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Author:</strong>
                        <p>{{ $article->author->username ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Category:</strong>
                        <p>{{ $article->category->name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <p>{{ ucfirst($article->status) }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Views:</strong>
                        <p>{{ $article->views }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>Approved By:</strong>
                        <p>{{ $article->approver->username ?? 'Not Approved' }}</p>
                    </div>

                    @if ($article->thumbnail_url)
                        <div class="mb-3">
                            <strong>Thumbnail:</strong>
                            <br>
                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Thumbnail"
                                class="img-thumbnail" style="max-width: 300px;">
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('articles.edit', $article->article_id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('articles.index') }}" class="btn btn-secondary">Back to List</a>

                        <form action="{{ route('articles.destroy', $article->article_id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>

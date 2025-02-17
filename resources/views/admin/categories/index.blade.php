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

        .wrapper {
            display: flex;
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
    <div class="wrapper">
        @include('admin.menu')
        <main class="content px-3 py-4 w-100">
            @include('admin.header')
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                <i class="lni lni-arrow-left"></i> Back to Dashboard
                            </a>
                            <a class="btn btn-primary" href="{{ route('categories.create') }}">
                                <i class="lni lni-plus"></i>
                            </a>

                        </div>
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="highlight">
                                        <th scope="col">ID</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">SLUG</th>
                                        <th scope="col">IS ACTIVE</th>
                                        {{-- <th scope="col">preview content</th>
                                        <th scope="col">contains sensitive content</th>
                                        <th scope="col">author</th>
                                        <th scope="col">category</th>
                                        <th scope="col">thumbnail</th>
                                        <th scope="col">views</th> --}}
                                        <th scope="col">ACTION</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td scope="row">{{ $category->category_id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->is_active ? 'Có' : 'Không' }}</td>
                                            {{-- <td>@mdo</td> --}}
                                            {{-- <td>@mdo</td>
                                            <td>@mdo</td>
                                            <td>@mdo</td>
                                            <td>@mdo</td>
                                            <td>@mdo</td> --}}
                                            <td class="d-flex">
                                                <a class="btn btn-warning me-2"
                                                    href="{{ route('categories.edit', $category) }}">
                                                    sửa
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xoá không?')"
                                                        type="submit">
                                                        xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $categories->Links() }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>

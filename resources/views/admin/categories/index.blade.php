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
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
</head>

<body>
    <div class="wrapper">
<<<<<<< HEAD
        @include('admin.layouts.partials.menusidebar')
        <div class="main">
            @include('admin.layouts.partials.header')
=======
        @include('admin.menu')
        <main class="content px-3 py-4 w-100">
            @include('admin.header')
>>>>>>> 65459d5776a18e445735a074bd602982137e0024
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="    ">
                        <div class=" mb-3">
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>

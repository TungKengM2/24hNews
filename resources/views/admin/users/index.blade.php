<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-size: 0.875rem; /* Reduce font size */
        }

        .table th, .table td {
            padding: 0.5rem; /* Reduce padding */
        }

        .btn {
            padding: 0.25rem 0.5rem; /* Reduce button padding */
            font-size: 0.75rem; /* Reduce button font size */
        }

        .page-title {
            font-size: 1.25rem; /* Reduce page title font size */
        }
    </style>
</head>

<body>
    <div class="main">
        <main class="content">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h1 class="page-title mb-3">Người dùng</h1>
                            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                <i class="lni lni-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                        <div class="col-9">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Phone</th>
                                        <th>Image</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Is Promoted</th>
                                        <th>Violation Count</th>
                                        <th>Banned Until</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td><img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->username }}" width="100"></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->is_promoted }}</td>
                                        <td>{{ $user->violation_count }}</td>
                                        <td>{{ $user->banned_until }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Show</a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
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



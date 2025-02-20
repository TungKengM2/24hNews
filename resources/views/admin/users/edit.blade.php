<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        .form-group {
            margin-bottom: 1.5rem; /* Add spacing between form fields */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('admin.layouts.partials.menusidebar')
        <div class="main">
            @include('admin.layouts.partials.header')
            <main class="content">
                <div class="container-fluid">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <h1 class="page-title mb-3">Edit User</h1>
                                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                                    <i class="lni lni-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                            <div class="col-9">
                                <form action="{{ route('users.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="role_id" class="form-label">Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="admin" {{ $user->role_id == '1' ? 'selected' : '' }}>Admin</option>
                                            <option value="editor" {{ $user->role_id == '2' ? 'selected' : '' }}>Biên tập</option>
                                            <option value="user" {{ $user->role_id == '3' ? 'selected' : '' }}>Người viết bài</option>
                                            <option value="user" {{ $user->role_id == '4' ? 'selected' : '' }}>Người dùng</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_promoted" class="form-label">Is Promoted</label>
                                        <select class="form-control" id="is_promoted" name="is_promoted">
                                            <option value="0" {{ $user->is_promoted == '0' ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $user->is_promoted == '1' ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="violation_count" class="form-label">Violation Count</label>
                                        <input type="number" class="form-control" id="violation_count" name="violation_count" value="{{ $user->violation_count }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="banned_until" class="form-label">Banned Until</label>
                                        <input type="date" class="form-control" id="banned_until" name="banned_until" value="{{ $user->banned_until }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>

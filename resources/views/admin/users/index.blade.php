@extends('admin.layouts.master')

@section('title')
    Danh Sách Tài Khoản
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="box container mb-4">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h4 class="box-title">Danh sách người dùng</h4>
                    <div>
                        <label for="role-filter" class="text-white">Lọc theo vai trò:</label>
                        <select id="role-filter" class="form-control">
                            <option value="">Tất cả</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->role_id }}" {{ $role_id == $role->role_id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-dark mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Vai trò</th>
                                <th>Ảnh đại diện</th>
                            </tr>
                            </thead>
                            <tbody id="user-table">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ ucfirst($user->role->name ?? 'Chưa có vai trò') }}</td>
                                    <td>
                                        @if ($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar"
                                                 width="50">
                                        @else
                                            Không có ảnh
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="pagination-wrapper" class="d-flex justify-content-end mt-5">
                        <nav>
                            <ul class="pagination pagination-sm">
                                {{ $users->appends(['role_id' => $role_id])->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let roleFilter = document.getElementById('role-filter');
            roleFilter.addEventListener('change', function () {
                let selectedRole = this.value;
                let url = new URL(window.location.href);

                if (selectedRole) {
                    url.searchParams.set('role_id', selectedRole);
                } else {
                    url.searchParams.delete('role_id');
                }

                window.location.href = url.toString();
            });
        });
    </script>
@endsection

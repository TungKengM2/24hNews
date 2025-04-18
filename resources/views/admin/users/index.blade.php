@extends('admin.layouts.master')

@section('title')
    Danh Sách Tài Khoản
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="box container mb-4">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <div class="title">
                        <h4 class="box-title">Danh sách người dùng</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-grow-1 me-3">
                            <div class="input-group">
                                <input type="text" id="searchUser" class="form-control"
                                    placeholder="Tìm kiếm người dùng..." value="{{ request('search') }}">
                                <input type="text" id="searchEmail" class="form-control"
                                    placeholder="Tìm kiếm email..." style="max-width: 200px;">
                                <input type="text" id="searchPhone" class="form-control"
                                    placeholder="Tìm kiếm số điện thoại..." style="max-width: 200px;">
                                <button type="button" class="btn btn-primary" id="searchButton">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-white mb-2 d-block" style="min-width: 50px;">
                            {{-- <label for="role-filter" class="text-white mb-2 d-block">Lọc theo vai trò:</label> --}}
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
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchUser = document.getElementById('searchUser');
                        const searchEmail = document.getElementById('searchEmail');
                        const searchPhone = document.getElementById('searchPhone');
                        const searchButton = document.getElementById('searchButton');
                        const userRows = document.querySelectorAll('tbody tr');

                        function performSearch() {
                            const searchTerm = searchUser.value.toLowerCase().trim();
                            const emailSearchTerm = searchEmail.value.toLowerCase().trim();
                            const phoneSearchTerm = searchPhone.value.toLowerCase().trim();

                            userRows.forEach(row => {
                                const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                                const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                                const phone = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                                const matchesUsername = username.includes(searchTerm);
                                const matchesEmail = !emailSearchTerm || email.includes(emailSearchTerm);
                                const matchesPhone = !phoneSearchTerm || phone.includes(phoneSearchTerm);

                                if (matchesUsername && matchesEmail && matchesPhone) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        }

                        // Search on button click
                        searchButton.addEventListener('click', performSearch);

                        // Search on Enter key press
                        [searchUser, searchEmail, searchPhone].forEach(input => {
                            input.addEventListener('keyup', function(event) {
                                if (event.key === 'Enter') {
                                    performSearch();
                                }
                            });

                            // Real-time search as user types
                            input.addEventListener('input', performSearch);
                        });
                    });
                </script>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Vai trò</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Chỉnh sửa vai trò</th>
                                    <th>Thông tin tài khoản</th>
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
                                        @if (in_array($user->role_id, [2, 3, 4]))
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                <span class="text-danger">Admin không thể thay đổi vai trò</span>
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('admin.users.show', $user->user_id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
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
        document.addEventListener('DOMContentLoaded', function() {
            let roleFilter = document.getElementById('role-filter');
            roleFilter.addEventListener('change', function() {
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

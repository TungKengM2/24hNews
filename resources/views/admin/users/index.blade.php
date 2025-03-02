@extends('admin.layouts.master')

@section('title')
    Danh Sách Tài Khoản
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            @foreach ($roles as $role)
                <div class="box container mb-4">
                    <div class="box-header with-border">
                        <h4 class="box-title">{{ ucfirst($role->name) }}</h4>
                        <small>{{ $role->description }}</small>
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
                                        <th>Ảnh đại diện</th>
                                    </tr>
                                </thead>
                                <tbody id="user-table">
                                    @foreach ($users->where('role_id', $role->role_id) as $user)
                                        <tr>
                                            <td>{{ $user->user_id }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone }}</td>
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
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

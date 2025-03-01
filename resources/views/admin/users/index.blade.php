@extends('admin.layouts.master')

@section('title')
    Danh Sách Tài Khoản
@endsection

@section('content')
    {{-- <div class="mt-5">
        @foreach ($roles as $role)
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ ucfirst($role->name) }}</h4>
                    <small>{{ $role->description }}</small>
                </div>
                <div class="card-body">
                    @if ($role->users->isEmpty())
                        <p class="text-muted">Chưa có người dùng nào.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Ảnh đại diện</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role->users as $user)
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
                    @endif
                </div>
            </div>
        @endforeach
    </div> --}}

    {{-- <div class="container">
        <div class="box-header with-border">
            <h3 class="box-title">Data Table With Full Features</h3>
        </div> --}}
    <!-- /.box-header -->
    {{-- <div class="box-body">
            <div class="table-responsive">
                @foreach ($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">{{ ucfirst($role->name) }}</h4>
                            <small>{{ $role->description }}</small>
                        </div>
                        <div class="card-body">
                            @if ($role->users->isEmpty())
                                <p class="text-muted">Chưa có người dùng nào.</p>
                            @else
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Ảnh đại diện</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($role->users as $user)
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
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}

    @foreach ($roles as $role)
        <div class="card mb-3">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">{{ ucfirst($role->name) }}</h4>
                <small>{{ $role->description }}</small>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Ảnh đại diện</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users->where('role_id', $role->role_id) as $user)
                            <tr>
                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if ($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar" width="50">
                                    @else
                                        Không có ảnh
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Hiển thị phân trang -->
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @endforeach
@endsection

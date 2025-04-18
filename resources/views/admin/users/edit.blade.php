@extends('admin.layouts.master')

@section('title')
    Chỉnh Sửa Vai Trò Người Dùng
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-full">
            <div class="wrapper">
                <div class="container mt-5">
                    <div class="card p-4 shadow rounded">
                        <h2 class="mb-4">Cập Nhật Vai Trò Người Dùng</h2>

                        {{-- Hiển thị thông báo thành công --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif

                        {{-- Hiển thị lỗi validate --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Form cập nhật --}}
                        <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Tên người dùng</label>
                                <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Vai trò</label>
                                <select name="role_id" id="role_id" class="form-select" required>
                                    <option value="" disabled>-- Chọn vai trò --</option>
                                    @foreach ($roles as $role)
                                        @if (in_array($role->role_id, [2, 3, 4]))
                                            <option value="{{ $role->role_id }}"
                                                {{ $user->role_id == $role->role_id ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

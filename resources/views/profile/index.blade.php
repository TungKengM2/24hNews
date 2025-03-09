@extends('layout.app')

@section('title', 'Thông tin tài khoản')

@section('content')
<div class="card p-4">
    <h4>Thông tin tài khoản</h4>

    {{-- Thông báo thành công hoặc thất bại --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        {{-- Tên hiển thị --}}
        <div class="mb-3">
            <label class="form-label">Tên hiển thị</label>
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                value="{{ old('username', auth()->user()->username) }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email (Không cho sửa) --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
        </div>

        {{-- Điện thoại --}}
        <div class="mb-3">
            <label class="form-label">Điện thoại</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                value="{{ old('phone', auth()->user()->phone) }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nút lưu --}}
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </form>
</div>
@endsection

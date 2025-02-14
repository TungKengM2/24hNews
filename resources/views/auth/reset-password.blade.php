@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <h2>Đặt lại mật khẩu</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email của bạn</label>
        <input type="email" name="email" required>

        <label>Mật khẩu mới</label>
        <input type="password" name="password" required>

        <label>Xác nhận mật khẩu</label>
        <input type="password" name="password_confirmation" required>

        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit">Đặt lại mật khẩu</button>
    </form>
@endsection

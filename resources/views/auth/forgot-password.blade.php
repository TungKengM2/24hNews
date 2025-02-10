@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
    <h2>Quên mật khẩu</h2>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label>Email của bạn</label>
        <input type="email" name="email" required>
        
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit">Gửi link đặt lại mật khẩu</button>
    </form>
@endsection

@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-md-6 ads">
            <h3>Quên mật khẩu</h3>
            <div class="img">
                <img src="https://i.imgur.com/HWuWWE9.jpeg" alt="">
            </div>
        </div>
        <div class="col-md-6 login-form">
            <div class="profile-img">
                <img src="https://i.imgur.com/HWuW" alt="">
            </div>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email của bạn</label>
                    <input type="email" name="email" class="form-control" required>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Gửi link đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
</div>
@endsection

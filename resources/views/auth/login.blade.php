@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <h2>Đăng nhập</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required value="{{ old('email') }}">

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label>
           <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          Ghi nhớ đăng nhập
      </label>
  

        <button type="submit">Đăng nhập</button>
    </form>
    <div class="login social" >

        <button class="btn btn-google" >
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Icon"> Login with Google
        </button>
        <button class="btn btn-facebook" >
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Icon"> Login with Facebook
        </button>
    </div>

    <p><a href="{{ route('password.request') }}">Quên mật khẩu?</a></p>
    <p>Chưa có tài khoản? <a href="{{ route('signup') }}">Đăng ký</a></p>
@endsection

<style>
   
</style>

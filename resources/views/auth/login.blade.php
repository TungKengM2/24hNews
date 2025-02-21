@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-md-6 ads">
        <h3>Đăng nhập</h3>
          <div class="img">
            <img src="{{ asset('images/bannerauth.jpg') }}" class="img-fluid" alt="banner login">
          </div>
        </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
        <div class="form-section">
            <div class="profile-img">
                <img src="{{ asset('images/headerbanner24hnews.jpg') }}" width="100px" height="100px" alt="Logo 24H News">
            </div>
            <form action="{{ route('login') }}" method="POST" >
                @csrf
                <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" required id="password">
                    <div class="eye">
                        <i class="fa fa-eye" id="togglePassword"></i>
                    </div>
                </div>

                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Ghi nhớ đăng nhập
                </label>

                <button type="submit">Đăng nhập</button>
            </form>
            <div class="login social">
                <button class="btn btn-google">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Icon"> Login with Google
                </button>
                <button class="btn btn-facebook">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Icon"> Login with Facebook
                </button>
            </div>

            <p><a href="{{ route('password.request') }}">Quên mật khẩu?</a></p>
            <p>Chưa có tài khoản? <a href="{{ route('signup') }}">Đăng ký</a></p>
        </div>
    </div>
</div>
<script>
document.getElementById('togglePassword').addEventListener('click', function (e) {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
@endsection

<style>
</style>

@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="login-container">
    <div class="row">
        <div class="col-md-6 ads">
        <h3>Login Admin</h3>
          <div class="img">
            <img src="{{ asset('images/bannerloginadmin.jpg') }}" class="img-fluid" alt="banner login 24H News">
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
            <form action="{{ route('admin.login.submit') }}" method="POST" >
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

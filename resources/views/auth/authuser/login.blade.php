<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-theme21.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-body without-side">
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="https://brandio.io/envato/iofrm/html/images/graphic3.svg" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3 class="mb-3">Đăng nhập tài khoản</h3>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('loginuser.process') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Địa chỉ email" required value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Mật khẩu" required>
                                <i class="fas fa-eye eye" id="togglePassword"></i>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="chk1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="chk1">Ghi nhớ đăng nhập</label>
                            </div>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Đăng nhập</button>
                                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                            </div>
                        </form>
                        <div class="other-links social-with-title">
                            <div class="text">Hoặc đăng nhập bằng</div>
                            {{-- <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i> Facebook</a> --}}
                            <a href="{{ url('auth/google') }}"><i class="fab fa-google"></i> Google</a>
                        </div>

                        <div class="page-links">
                            <a href="{{ route('signupuser') }}">Đăng ký tài khoản mới</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('authuser/js/jquery.min.js') }}"></script>
<script src="{{ asset('authuser/js/popper.min.js') }}"></script>
<script src="{{ asset('authuser/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('authuser/js/main.js') }}"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('input[name="password"]');

    togglePassword.addEventListener('click', function (e) {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // Toggle the eye / eye slash icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .form-group {
        position: relative;
        margin-bottom: 20px;
    }
    .eye {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
    }
    .eye:hover {
        color: #333;
    }
    .form-control {
        height: 50px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
    }
    .ibtn {
        background-color: #4a90e2;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .ibtn:hover {
        background-color: #357abd;
        transform: translateY(-2px);
    }
    .form-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    .form-button a {
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .form-button a:hover {
        color: #357abd;
        text-decoration: underline;
    }
    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .alert-danger {
        background-color: #ffebee;
        border-color: #ffcdd2;
        color: #c62828;
    }
    .alert-success {
        background-color: #e8f5e9;
        border-color: #c8e6c9;
        color: #2e7d32;
    }
    .other-links {
        margin-top: 30px;
        text-align: center;
    }
    .other-links .text {
        margin-bottom: 15px;
        color: #757575;
    }
    .other-links a {
        display: inline-block;
        margin: 0 10px;
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .other-links a:hover {
        color: #357abd;
    }
    .page-links {
        margin-top: 20px;
        text-align: center;
    }
    .page-links a {
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .page-links a:hover {
        color: #357abd;
        text-decoration: underline;
    }
    h3 {
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
    }
    p {
        color: #757575;
        margin-bottom: 25px;
    }
</style>
</body>
</html>

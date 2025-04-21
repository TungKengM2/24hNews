<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-theme21.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}?v={{ time() }}">
</head>

<body>

    <div class="form-body without-side">


        <div class="website-logo">
            <a href="index.html">
                <div class="logo">
                    <img class="logo-size" src="https://brandio.io/envato/iofrm/html/images/logo-light.svg"
                        alt="">
                </div>
            </a>
        </div>

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
                        <h3 class="mb-3">Đăng ký tài khoản mới</h3>
                        <p>Tham gia cùng chúng tôi để cập nhật tin tức mới nhất</p>

                        <form action="{{ route('signupuser.process') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="form-control @error('username') is-invalid @enderror" type="text" name="username" placeholder="Tên đăng nhập"
                                    value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Địa chỉ email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" placeholder="Số điện thoại"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Mật khẩu" required>
                                <i class="fas fa-eye eye" id="togglePassword"></i>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation"
                                    placeholder="Xác nhận mật khẩu" required>
                                <i class="fas fa-eye eye" id="toggleConfirmPassword"></i>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                                <label for="terms">Tôi đồng ý với <a href="#">điều khoản sử dụng</a></label>
                                @error('terms')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-button">
                                <button type="submit" class="ibtn">Đăng ký</button>
                            </div>
                        </form>

                        <div class="other-links social-with-title">
                            <div class="text">Hoặc đăng ký bằng</div>
                            <a href="{{ url('auth/facebook') }}"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="{{ url('auth/google') }}"><i class="fab fa-google"></i> Google</a>
                        </div>

                        <div class="page-links">
                            <a href="{{ route('loginuser') }}">Đã có tài khoản? Đăng nhập</a>
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
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const password = document.querySelector('input[name="password"]');
        const confirmPassword = document.querySelector('input[name="password_confirmation"]');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function (e) {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
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
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .form-button a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: 500;
            margin-top: 15px;
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
        input[type="checkbox"] {
            margin-right: 10px;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }
    </style>
</body>

</html>

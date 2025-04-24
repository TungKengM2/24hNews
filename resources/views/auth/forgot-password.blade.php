<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-theme21.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/logo24news.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo24news.png') }}?v={{ time() }}">
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
                        <h3>Quên mật khẩu</h3>
                        <p>Nhập địa chỉ email của bạn để nhận liên kết đặt lại mật khẩu.</p>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Nhập email của bạn" required>
                            </div>
                            <div class="form-button">
                                <button type="submit" class="ibtn">Gửi liên kết đặt lại mật khẩu</button>
                                <br>
                                <a href="{{ route('loginuser') }}">Quay lại đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('authuser/js/jquery.min.js') }}"></script>
<script src="{{ asset('authuser/js/popper.min.js') }}"></script>
<script src="{{ asset('authuser/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('authuser/js/main.js') }}"></script>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .form-group {
        position: relative;
        margin-bottom: 20px;
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

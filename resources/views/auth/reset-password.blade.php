<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-theme21.css') }}">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="{{ route('password.request') }}">
                <div class="logo">
                    <img class="logo-size" src="https://brandio.io/envato/iofrm/html/images/logo-light.svg" alt="Logo">
                </div>
            </a>
        </div>
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Đặt lại mật khẩu</h3>
                        <p>Nhập mật khẩu mới của bạn bên dưới.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            
                            <input class="form-control" type="email" name="email" placeholder="Nhập email" required>
                            <input class="form-control" type="password" name="password" placeholder="Mật khẩu mới" required>
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>

                            <div class="form-button full-width">
                                <button type="submit" class="ibtn btn-primary">Đặt lại mật khẩu</button>
                            </div>
                        </form>

                        <div class="mt-3">
                            <a href="{{ request()->get('admin') ? route('loginadmin') : route('loginuser') }}">Quay lại đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="{{ asset('authadmin/js/jquery.min.js') }}"></script>
<script src="{{ asset('authadmin/js/popper.min.js') }}"></script>
<script src="{{ asset('authadmin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('authadmin/js/main.js') }}"></script>
</body>
</html>

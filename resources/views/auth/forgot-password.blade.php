<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
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
                                <label for="email">Nhập email:</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Nhập email của bạn" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Gửi liên kết đặt lại mật khẩu</button>
                            </div>
                        </form>
                        
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

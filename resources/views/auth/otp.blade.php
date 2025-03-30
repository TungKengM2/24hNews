<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận OTP - News24h</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-theme21.css') }}">
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
                        <h3>Xác nhận OTP</h3>
                        <p>Vui lòng nhập mã OTP đã được gửi đến email của bạn.</p>
                        
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif
                    
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('otp.verify.process') }}" method="POST">
                            @csrf
                            <input class="form-control" type="text" name="otp" id="otp" 
                                   inputmode="numeric" pattern="\d{6}" maxlength="6"
                                   required placeholder="Nhập 6 chữ số OTP" autofocus>
                            
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Xác nhận OTP</button>
                                <a href="{{ route('loginuser') }}">Quay lại đăng nhập</a>
                            </div>
                        </form>
                        
                        <div class="other-links">
                            <span>Bạn chưa nhận được mã?</span>
                            <a href="#">Gửi lại mã OTP</a>
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
</body>
</html>



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

    <style>
        .countdown {
            font-size: 1.2em;
            font-weight: bold;
            color: #4a90e2;
            margin: 10px 0;
        }
        .resend-btn {
            background: none;
            border: none;
            color: #4a90e2;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font: inherit;
        }
        .resend-btn:disabled {
            color: #999;
            text-decoration: none;
            cursor: not-allowed;
        }
        .alert {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 4px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>
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



                        <form action="{{ route('otp.verify.process') }}" method="POST">
                            @csrf
                            <input class="form-control @error('otp') is-invalid @enderror"
                                   type="text"
                                   name="otp"
                                   id="otp"
                                   inputmode="numeric"
                                   pattern="\d{6}"
                                   maxlength="6"
                                   required
                                   placeholder="Nhập 6 chữ số OTP"
                                   autofocus
                                   value="{{ old('otp') }}">
                            @error('otp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Xác nhận OTP</button>
                                <a href="{{ route('loginuser') }}">Quay lại đăng nhập</a>
                            </div>
                        </form>

                        <div class="other-links">
                            <span>Bạn chưa nhận được mã?</span>
                            <div class="countdown" id="countdown">60</div>
                            <button id="resendBtn" class="resend-btn" disabled>Gửi lại mã OTP</button>
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
        // Đếm ngược thời gian
        let timeLeft = 60;
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        const countdown = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                countdownEl.style.display = 'none';
                resendBtn.disabled = false;
            }
        }, 1000);

        // Xử lý sự kiện gửi lại mã OTP
        resendBtn.addEventListener('click', function() {
            // Gửi request để lấy mã OTP mới
            fetch('{{ route("otp.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset đếm ngược
                    timeLeft = 60;
                    countdownEl.style.display = 'block';
                    countdownEl.textContent = timeLeft;
                    resendBtn.disabled = true;

                    // Hiển thị thông báo thành công
                    alert('Mã OTP mới đã được gửi đến email của bạn.');
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        });
    </script>
</body>
</html>



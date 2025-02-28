<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authuser/css/iofrm-theme21.css') }}">
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
                        <h3>Register new account</h3>
                        <div>
                            <input class="form-control" type="checkbox" name="terms"
                                {{ old('terms') ? 'checked' : '' }} required>
                            Tôi đồng ý với <a href="#">điều khoản sử dụng</a>

                        </div>

                        <p>Access to the most powerful tools in the entire design and web industry.</p>

                        <!-- Display errors if any -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('signupuser.process') }}" method="POST">
                            @csrf
                            <input class="form-control" type="text" name="username" placeholder="Username"
                                value="{{ old('username') }}" required>
                            <input class="form-control" type="email" name="email" placeholder="E-mail Address"
                                value="{{ old('email') }}" required>
                            <input class="form-control" type="text" name="phone" placeholder="Phone"
                                value="{{ old('phone') }}" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <input class="form-control" type="password" name="password_confirmation"
                                placeholder="Confirm Password" required>

                            {{-- <!-- Checkbox Terms -->
                            <div>

                                <input class="form-control" type="checkbox" name="terms"
                                    {{ old('terms') ? 'checked' : '' }} required>
                                Tôi đồng ý với <a href="#">điều khoản sử dụng</a>

                            </div> --}}

                            <div class="form-button">
                                <button type="submit" class="ibtn">Register</button>
                            </div>
                        </form>

                        <div class="other-links social-with-title">
                            <div class="text">Or register with</div>
                            <a href="register21.html#"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="register21.html#"><i class="fab fa-google"></i> Google</a>
                            <a href="register21.html#"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
                        </div>

                        <div class="page-links">
                            <a href="{{ route('loginuser') }}">Login to account</a>
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

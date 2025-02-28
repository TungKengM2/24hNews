<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
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
                    <img class="logo-size" src="https://brandio.io/envato/iofrm/html/images/logo-light.svg" alt="">
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
                        <h3>Login to account</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <form>
                            <input class="form-control" type="text" name="username" placeholder="E-mail Address" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="{{ route('password.request') }}">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links social-with-title">
                            <div class="text">Or login with</div>
                            <a href="login21.html#"><i class="fab fa-facebook-f"></i>Facebook</a><a href="login21.html#"><i class="fab fa-google"></i>Google</a><a href="login21.html#"><i class="fab fa-linkedin-in"></i>Linkedin</a>
                        </div>
                        <div class="page-links">
                            <a href="{{ route('signupuser') }}">Register new account</a>
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
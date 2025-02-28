<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-theme2.css') }}">
</head>
<body>
    <div class="form-body">
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

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Get more things done with Loggin platform.</h3>
                        <p>Access to the most powerfull tool in the entire design and web industry.</p>
                        <form action="{{ route('loginadmin.process') }}" method="POST">
                            @csrf
                            <input class="form-control" type="email" name="email" placeholder="E-mail Address" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror  
                            <input type="checkbox" id="chk1" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="chk1">Remember me</label>
                                                        <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button>
                                <a href="{{ route('password.request') }}">Forget password?</a>
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
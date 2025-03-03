<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iofrm</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('authadmin/css/iofrm-theme21.css') }}">
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
                        <h3>Password Reset</h3>
                        <p>To reset your password, enter the email address you use to sign in to iofrm</p>
                        <form>
                            <input class="form-control" type="text" name="username" placeholder="E-mail Address" required>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password link sent</h3>
                        <p>Please check your inbox <a href="https://brandio.io/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="88e1e7eefae5c8e1e7eefae5fcede5f8e4e9fceda6e1e7">[email&#160;protected]</a></p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span> <a href="forget2.html#">We can help</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="{{ asset('authadmin/js/jquery.min.js') }}"></script>
<script src="{{ asset('authadmin/js/popper.min.js') }}"></script>
<script src="{{ asset('authadmin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('authadmin/js/main.js') }}"></script>
</body>
</html>
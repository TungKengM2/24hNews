<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    body {
  font-family: 'Montserrat', sans-serif;
  transition: 3s;
}

.login-container {
  margin-top: 8%;
  border: 1px solid #CCD1D1;
  border-radius: 5px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  max-width: 50%;
}

.ads {
  background-color: #A569BD;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  color: #fff;
  padding: 15px;
  text-align: center;
}

.ads h1 {
  margin-top: 20%;
}
.ads .img img {
  width: 100%;
  height: auto;
  border-radius: 5px;
  object-fit: cover; /* Added this line */
}

#fl {
  font-weight: 600;
}

#sl {
  font-weight: 100 !important;
}

.profile-img {
  text-align: center;
}

.profile-img img {
  border-radius: 50%;
  /* animation: mymove 2s infinite; */
}

@keyframes mymove {
  from {border: 1px solid #F2F3F4;}
  to {border: 8px solid #F2F3F4;}
}

.login-form {
  padding: 15px;
}

.login-form h3 {
  text-align: center;
  padding-top: 15px;
  padding-bottom: 15px;
}

.form-control {
  font-size: 14px;
  padding-left: 30px;
  border-radius: 25px; /* Added this line */
}

.form-group {
  position: relative;
}

.eye {
  position: absolute;
  top: 50%;
  right: 45px;
  transform: translateY(-50%);
  cursor: pointer;
}

.form-group i {
  position: absolute;
  top: 50%;
  left: 10px;
  transform: translateY(-50%);
  color: #999;
}

.forget-password a {
  font-weight: 500;
  text-decoration: none;
  font-size: 14px;
}

</style>
<body>
<div class="container login-container">
      <div class="row">
        <div class="col-md-6 ads">
          <div class="img">
            <img src="https://i.imgur.com/HWuWWE9.jpeg" alt="">
          </div>
        </div>
        <div class="col-md-6 login-form">
          <div class="profile-img">
            <img src="https://i.imgur.com/ZuUExs4.jpeg" alt="profile_img" height="140px" width="140px;">
          </div>
          <h3>Login</h3>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <i class="fas fa-user"></i>
              <input type="email" class="form-control" name="email" placeholder="email">
            </div>
            <div class="form-group">
              <i class="fas fa-lock"></i>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
              <div class="eye">
                  <i class="fas fa-eye" id="togglePassword""></i>
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary btn-lg btn-block">Sign In</button>
            </div>
            <div class="form-group forget-password">
                <a href="#">Forget Password</a>
            </div>
          </form>
          <button class="btn btn-primary" onclick="window.location.href='{{ route('signup') }}'">Sign Up</button>
        </div>
      </div>
    </div>
<script>
  document.getElementById('togglePassword').addEventListener('click', function (e) {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
  });
</script>
</body>
</html>

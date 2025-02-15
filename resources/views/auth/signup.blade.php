@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="container login-container">
    <div class="row">
        <div class="col-md-6 ads">
            <h3>Đăng ký</h3>
            <div class="img">
                <img src="https://i.imgur.com/HWuWWE9.jpeg" alt="">
            </div>
        </div>
        <div class="col-md-6 form-section">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('signup.process') }}" method="POST" >
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Phone" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                        Tôi đồng ý với <a href="#">điều khoản sử dụng</a>
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                </div>
                <div class="login social">
                    <h4 class="text-center">Đăng kí cách khác</h4>
                    <button class="btn btn-google">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Icon">
                        Login with Google
                    </button>
                    <button class="btn btn-facebook">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Icon">
                        Login with Facebook
                    </button>
                </div>
            </form>
            <p>Nếu đã có tài khoản, hãy <a href="{{ route('login') }}">đăng nhập</a>.</p>
        </div>
    </div>

</body>
</html>

</div>
@endsection


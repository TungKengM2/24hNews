<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Trang tin tức cập nhật những tin tức nóng hổi nhất.">
  <title>@yield('tieudetrang')</title>
  <!-- Bootstrap CSS CDN -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Tùy chỉnh giao diện */
    .navbar-brand {
      font-weight: bold;
      font-size: 1.8rem;
    }
    .nav-link {
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
  <!-- Header sử dụng Bootstrap Navbar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">News Today</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" 
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">World</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Technology</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Sports</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Entertainment</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Health</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/signup') }}">Sign Up</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>


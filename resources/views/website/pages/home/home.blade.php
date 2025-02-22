<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>24HNews Homapage</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
    @include('website.layouts.partials.header')
    <div class="container mx-auto">
        @include('website.layouts.partials.main')
        @yield('content')

    </div>
    @include('website.layouts.partials.footer')



</body>
</html>

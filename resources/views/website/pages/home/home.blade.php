<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>24HNews Homapage</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    @include('website.layouts.partials.header')
    <div class="container mx-auto">
        @include('website.layouts.partials.main')
        @yield('content')

    </div>

    @include('website.layouts.partials.footer')

    <button id="scrollToTop" class="fixed bottom-4 right-4 bg-blue-500 text-white rounded-full p-3 shadow-lg w-12 h-12 flex items-center justify-center">
        ↑
    </button>
    <script>
        document.getElementById('scrollToTop').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>

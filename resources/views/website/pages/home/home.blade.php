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
        <button id="btn-to-top" title="Lên đầu trang"
            class="fixed bottom-4 right-4 bg-transparent text-gray-500 font-bold py-2 px-4 rounded hover:border-gray-500 hover:border-2">
            <i class="fas fa-arrow-up"></i>
        </button>




    </div>
    @include('website.layouts.partials.footer')


    <script>
        document.getElementById("btn-to-top").addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>

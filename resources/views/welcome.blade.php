<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <style>
        /* Reset some default browser styles */
body, h1, h2, h3, p, ul, li, a, img {
    margin: 0;
    padding: 0;
    border: 0;
    list-style: none;
    text-decoration: none;
    box-sizing: border-box;
}

/* Body */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

/* Grid System */
.row {
    display: flex;
    flex-wrap: wrap;
}

.col-9 {
    flex: 0 0 75%;
    max-width: 75%;
}

.col-3 {
    flex: 0 0 25%;
    max-width: 25%;
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Header */
.header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
}

.header .logo {
    font-size: 2rem;
    text-align: center;
}

.header .nav ul {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.header .nav a {
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    transition: color 0.3s ease;
}

.header .nav a:hover {
    color: #ff6347;
}

/* Main Content */
.main-content {
    margin: 20px 0;
}

/* Section Titles */
.section-title {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: #333;
}

/* Featured Article */
.featured-article {
    margin-bottom: 40px;
}

.featured-article .article {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.featured-article .article img {
    max-width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.featured-article .article-title {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.featured-article .article-summary {
    font-size: 1rem;
    margin-bottom: 15px;
}

.featured-article .read-more {
    display: inline-block;
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.featured-article .read-more:hover {
    background-color: #ff6347;
}

/* News Categories */
.news-categories .categories-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.news-categories .category {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.news-categories .category-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.news-categories .category-summary {
    font-size: 1rem;
    margin-bottom: 15px;
}
    /* Tùy chỉnh giao diện */
    .navbar-brand {
      font-weight: bold;
      font-size: 1.8rem;
    }
    .nav-link {
      font-size: 1.1rem;
    }

/* Latest Articles */
.latest-articles .articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.latest-articles .article {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.latest-articles .article img {
    max-width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.latest-articles .article-title {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.latest-articles .article-summary {
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.latest-articles .read-more {
    display: inline-block;
    background-color: #333;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.latest-articles .read-more:hover {
    background-color: #ff6347;
}

/* Footer */
.footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    margin-top: 40px;
}

.footer p {
    margin: 0;
}
    </style>
</head>
<body>
<<<<<<< HEAD
  <header class="flex flex-col bg-white shadow-md w-full">
    <div class="flex justify-between items-center p-4 max-w-7xl mx-auto">
      <div class="flex items-center space-x-4 mx-10">
        <h1 class="text-2xl font-bold text-red-600">24H<span class="text-gray-800">News</span></h1>
        <span class="text-sm text-gray-500">Thứ bảy, 15/2/2025</span>

      </div>
      <div class="flex items-center space-x-3">
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Mới nhất</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Tin theo khu vực</button>

        <div class="relative">
          <input type="text" placeholder="Tìm kiếm..." class="pl-10 pr-2 py-1 border rounded" />
          <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z"></path></svg>
        </div>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Đăng nhập</button>
        <button class="px-3 py-1 border rounded hover:bg-gray-100">Đăng ký</button>
=======
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="#">News</a>
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
>>>>>>> 9baf5eac5d64d621b341ac5924a67958dde626cb

      </div>
    </div>
    <nav class="border-t bg-white mt-4">
        <ul class="flex justify-between px-20 p-2 text-sm font-medium text-gray-700">
          <li class="hover:text-red-600 cursor-pointer">Thời sự</li>
          <li class="hover:text-red-600 cursor-pointer">Góc nhìn</li>
          <li class="hover:text-red-600 cursor-pointer">Thế giới</li>
          <li class="hover:text-red-600 cursor-pointer">Video</li>
          <li class="hover:text-red-600 cursor-pointer">Podcasts</li>
          <li class="hover:text-red-600 cursor-pointer">Kinh doanh</li>
          <li class="hover:text-red-600 cursor-pointer">Bất động sản</li>
          <li class="hover:text-red-600 cursor-pointer">Khoa học</li>
          <li class="hover:text-red-600 cursor-pointer">Giải trí</li>
          <li class="hover:text-red-600 cursor-pointer">Thể thao</li>
          <li class="hover:text-red-600 cursor-pointer">Pháp luật</li>
          <li class="hover:text-red-600 cursor-pointer">Giáo dục</li>
          <li class="hover:text-red-600 cursor-pointer">Sức khoẻ</li>
          <li class="hover:text-red-600 cursor-pointer">Đời sống</li>
          <li class="hover:text-red-600 cursor-pointer">Du lịch</li>
          <li class="hover:text-red-600 cursor-pointer">Công nghệ</li>
          <li class="hover:text-red-600 cursor-pointer">Xe</li>
          <li class="hover:text-red-600 cursor-pointer">Ý kiến</li>
          <li class="hover:text-red-600 cursor-pointer">Tâm sự</li>
        </ul>
      </nav>
  </header>
  <main class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 min-h-[75vh]">
    <div class="col-span-4 grid grid-rows-4 gap-4">
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 1</article>
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 2</article>
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 3</article>
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 4</article>
    </div>
    <div class="col-span-8 grid grid-rows-2 gap-4">
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 5</article>
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 6</article>
    </div>
  </main>

  <main class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 h-60">


    <div class="col-span-8 grid grid-rows-2 gap-4 ">
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 5</article>
      <article class="bg-white p-4 shadow rounded-lg h-full">Content 6</article>
    </div>
    <div class="col-span-4 grid grid-rows-4 gap-4 ">
        <article class="bg-white p-4 shadow rounded-lg h-full">Content 1</article>
        <article class="bg-white p-4 shadow rounded-lg h-full">Content 2</article>
        <article class="bg-white p-4 shadow rounded-lg h-full">Content 3</article>
        <article class="bg-white p-4 shadow rounded-lg h-full">Content 4</article>
      </div>
  </main>

</body>
</html>
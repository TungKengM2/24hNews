<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>24HNews Homapage</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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


                                    <h3 class="article-title">
                                        <a href="{{ route('client.articles.article', $article->article_id) }}">{{ $article->title }}</a>


                                    </h3>
                                    <p class="text-muted">Lượt xem: {{ $article->views }}</p>
                                    <p class="article-summary">
                                        @if(Auth::check())
                                            {{ Str::limit($article->content, 70, '...') }}
                                        @else
                                            {{ Str::limit($article->content, 50, '...') }}
                                        @endif
                                    </p>
                                    @if(!Auth::check())
                                        <a href="{{ route('login') }}" class="read-more" onclick="event.preventDefault(); document.getElementById('login-form').submit();">
                                            Đăng nhập để đọc tiếp
                                        </a>
                                        <form id="login-form" action="{{ route('login') }}" method="GET" style="display: none;"></form>
                                    @else
                                        <a href="{{ route('client.articles.article', $article->article_id) }}" class="read-more">Read More</a>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>
                
                

                <aside class="sidebar col-3">
                    <section class="news-categories">
                        <h2 class="section-title">News Categories</h2>
                        <div class="categories-list">
                            <div class="category">
                                <h3 class="category-title">World</h3>
                                <p class="category-summary">Latest news from around the world...</p>
                            </div>
                            <div class="category">
                                <h3 class="category-title">Technology</h3>
                                <p class="category-summary">New advancements in technology...</p>
                            </div>
                            <div class="category">
                                <h3 class="category-title">Sports</h3>
                                <p class="category-summary">Updates on sports events...</p>
                            </div>
                            <div class="category">
                                <h3 class="category-title">Entertainment</h3>
                                <p class="category-summary">Latest entertainment news...</p>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 News Today. All rights reserved.</p>
        </div>
    </footer>
</body>


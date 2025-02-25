<main>
    <!-- Hiển thị 3 bài viết mới nhất -->
    <div class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 mb-20 min-h-[75vh]">
        <div class="col-span-12 flex flex-col space-y-4">
            <h1 class="text-3xl font-bold">Bài viết mới nhất</h1>
            @foreach($latestArticles as $article)
                <article class="flex items-center bg-white p-4 shadow rounded-lg">
                    <a href="{{ route('client.articles.article', ['article_id' => $article->article_id]) }}"
                       class="flex flex-1 pr-4 no-underline hover:text-blue-500">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">{{ $article->created_at->diffForHumans() }}</p>
                            <h2 class="text-xl font-bold mb-1">{{ $article->title }}</h2>
                            <p class="text-sm text-gray-600">{{ $article->preview_content }}</p>
                        </div>
                    </a>
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                         class="w-48 h-32 object-cover rounded-lg">
                </article>
            @endforeach
        </div>
    </div>

    <!-- Hiển thị 7 bài viết tiêu biểu theo danh mục -->
    <div class="max-w-7xl mx-auto p-4 grid grid-cols-12 gap-4 min-h-[75vh]">
        <!-- Cột trái (2 bài viết) -->
        <div class="col-span-3 flex flex-col space-y-4">
            @foreach($categoryArticles->slice(0, 2) as $article)
                <article class="bg-white p-4 shadow rounded-lg h-1/2 w-full">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                         class="w-full h-1/2 object-cover rounded-lg mb-2">
                    <div class="p-2 w-full h-1/4">
                        <h2 class="text-lg font-bold mb-1">{{ $article->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $article->preview_content }}</p>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Cột giữa (1 bài viết lớn) -->
        <div class="col-span-6">
            @if($categoryArticles->count() > 2)
                <article class="bg-white p-4 shadow rounded-lg h-full flex flex-col">
                    <img src="{{ asset('storage/' . $categoryArticles[2]->thumbnail_url) }}" alt="Hình ảnh bài viết"
                         class="w-full h-1/2 object-cover rounded-lg mb-2">
                    <div class="p-4 flex flex-col justify-center">
                        <h2 class="text-xl font-bold mb-2">{{ $categoryArticles[2]->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $categoryArticles[2]->preview_content }}</p>
                    </div>
                </article>
            @endif
        </div>

        <!-- Cột phải (4 bài viết) -->
        <div class="col-span-3 flex flex-col space-y-4">
            @foreach($categoryArticles->slice(3, 4) as $article)
                <article class="bg-white p-4 shadow rounded-lg h-1/4 w-full flex">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="Hình ảnh bài viết"
                         class="w-1/2 h-full object-cover rounded-lg">
                    <div class="p-2 w-1/2 h-full flex flex-col justify-center">
                        <h2 class="text-lg font-bold mb-1">{{ $article->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $article->preview_content }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</main>

<div class="container mt-4">
    <!-- Header -->
    <header class="mb-4 text-center">
        <h1 class="display-5">{{ $article->title }}</h1>
        <p class="text-muted">Lượt xem: {{ $article->views }} | Tác giả: {{ $article->author->username ?? 'N/A' }}</p>
    </header>

    <div class="row">
        <!-- Nội dung bài viết -->
        <div class="col-lg-8">
            <article class="article-detail card shadow-sm p-4">
                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}" class="img-fluid rounded mb-3">
                
                <div class="article-content">
                    {!! $article->content !!}
                </div>
            </article>
        </div>

        <!-- Sidebar Bài viết liên quan -->
        <div class="col-lg-4">
            <h3 class="section-title text-center mb-3">Bài viết liên quan</h3>
            <div class="list-group">
                @foreach ($relatedArticles as $related)
                    <a href="{{ route('client.articles.article', $related->article_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                        <img src="{{ asset('storage/' . $related->thumbnail_url) }}" alt="{{ $related->title }}" width="80" class="rounded me-3">
                        <span class="text-truncate">{{ $related->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="mt-5 py-4 bg-light text-center">
    <p class="mb-0">© {{ date('Y') }} 24hNews. All Rights Reserved.</p>
</footer>

<div class="container">
    <div class="row">
        <!-- Nội dung bài viết -->
        <div class="col-md-8">
            <div class="card">
                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="card-img-top" alt="{{ $article->title }}">
                <div class="card-body">
                    <h1 class="card-title">{{ $article->title }}</h1>
                    <p class="text-muted">Lượt xem: {{ $article->views }}</p>
                    <p>{!! nl2br(e($article->content)) !!}</p>
                </div>
            </div>
        </div>

        <!-- Bài viết liên quan -->
        <div class="col-md-4">
            <h3>Bài viết liên quan</h3>
            <ul class="list-group">
                @foreach($relatedArticles as $related)
                    <li class="list-group-item">
                        <a href="{{ route('article.show', $related->id) }}">
                            <img src="{{ asset('storage/' . $related->thumbnail_url) }}" height="50" width="80">
                            {{ $related->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


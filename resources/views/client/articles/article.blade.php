@extends('master')

@section('tieudetrang')
    Article
@endsection

@section('content')

<style>
    /* Giới hạn kích thước ảnh chính trong bài viết */
    .article-image {
        max-height: 450px;
        object-fit: cover;
        width: 100%;
    }

    /* Giới hạn kích thước ảnh trong sidebar */
    .related-article-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>
<div class="container mt-5">
    <!-- Header của bài viết -->
    <header class="mb-5 text-center">
        <h1 class="display-4 font-weight-bold">{{ $article->title }}</h1>
        <p class="text-muted">
            <i class="fa fa-eye"></i> {{ $article->views }} lượt xem |
            <i class="fa fa-user"></i> {{ $article->author->username ?? 'N/A' }}
        </p>
    </header>

    <div class="row">
        <!-- Nội dung chính của bài viết -->
        <div class="col-lg-8">
            <article class="card shadow-sm border-0 mb-4">
                @if($article->thumbnail_url)
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="card-img-top img-fluid rounded-top article-image" alt="{{ $article->title }}">
                @endif
                <div class="card-body">
                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar: Bài viết liên quan -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Bài viết liên quan</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($relatedArticles as $related)
                        <li class="list-group-item">
                            <a href="{{ route('client.articles.article', $related->article_id) }}" class="d-flex align-items-center text-dark text-decoration-none">
                                <img src="{{ asset('storage/' . $related->thumbnail_url) }}" alt="{{ $related->title }}" class="related-article-img mr-3">
                                <span class="flex-fill text-truncate">{{ $related->title }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection

@extends('master')

@section('tieudetrang')
    Home
@endsection

@section('content')
<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #ffffff;
    color: #333;
}
a{
    text-decoration: none;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.section-title {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #2c3e50;
    font-weight: bold;
    border-bottom: 2px solid #ddd;
    padding-bottom: 5px;
}

/* Featured Article */
.featured-article .article {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    display: flex;
    gap: 20px;
    align-items: center;
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}

.featured-article .article:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.featured-article img {
    width: 300px;
    height: 200px;
    border-radius: 15px;
    object-fit: cover;
    transition: filter 0.3s;
}

.featured-article img:hover {
    filter: brightness(1.2);
}

.featured-article .article-content {
    flex: 1;
}

.featured-article h3 a {
    text-decoration: none;
    color: #007bff;
    font-size: 1.5rem;
    font-weight: bold;
}

.featured-article h3 a:hover {
    text-decoration: none;
    color: #0056b3;
}

/* Latest Articles */
.latest-articles .articles-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.latest-articles .article {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    transition: transform 0.3s;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

.latest-articles .article:hover {
    transform: translateY(-5px);
}

.latest-articles img {
    width: 100%;
    height: 180px;
    border-radius: 10px;
    object-fit: cover;
}

.read-more {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.read-more:hover {
    background-color: #0056b3;
}
</style>

<main class="main-content">
    <div class="container">
        <section class="featured-article">
            <h2 class="section-title">Featured Article</h2>
            <article class="article">
                <img src="{{ asset('storage/' . $featuredArticle->thumbnail_url) }}" alt="{{ $featuredArticle->title }}">
                <div class="article-content">
                    <h3><a href="{{ route('client.articles.article', $featuredArticle->article_id) }}">{{ $featuredArticle->title }}</a></h3>
                    <p>{{ Str::limit($featuredArticle->preview_content, 150, '...') }}</p>
                    <a href="{{ route('client.articles.article', $featuredArticle->article_id) }}" class="read-more">Read More</a>
                </div>
            </article>
        </section>

        <section class="latest-articles">
            <h2 class="section-title">Latest Articles</h2>
            <div class="articles-grid">
                @foreach ($articles as $article)
                    <article class="article">
                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}">
                        <h3><a href="{{ route('client.articles.article', $article->article_id) }}">{{ $article->title }}</a></h3>
                        <p>{{ Str::limit($article->preview_content, 80, '...') }}</p>
                        <a href="{{ route('client.articles.article', $article->article_id) }}" class="read-more">Read More</a>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
</main>
@endsection
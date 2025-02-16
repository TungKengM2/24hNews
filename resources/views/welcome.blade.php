<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Website</title>
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
    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1 class="logo">News Today</h1>
            <nav class="nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">World</a></li>
                    <li><a href="#">Technology</a></li>
                    <li><a href="#">Sports</a></li>
                    <li><a href="#">Entertainment</a></li>
                    <li><a href="#">Health</a></li>
                    <li><a href="{{ url('/signup') }}">Sign Up</a></li>
                    <li><a href="{{ url('/login') }}">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Featured Article (full width) -->
            <section class="featured-article">
                <h2 class="section-title">Featured Article</h2>
                <article class="article">
                    <img src="https://thanhnien.mediacdn.vn/zoom/320_200/325084952045817856/2025/2/14/base64-17395312512031903184687.png"width="1200" height="400" alt="Article Image">
                    <h3 class="article-title">This is the featured article title</h3>
                    <p class="article-summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam...</p>
                    <a href="#" class="read-more">Read More</a>
                </article>
            </section>

            <div class="row">


                <div class="content col-9">
                    <section class="latest-articles">
                        <h2 class="section-title">Latest Articles</h2>
                        <div class="articles-grid">
                            @foreach ($articles as $article)
                                <article class="article">
                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}" height="200" width="404">


                                    <h3 class="article-title">
                                        <a href="{{ url('/article/' . $article->article_id) }}">{{ $article->title }}</a>
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
                                        <a href="{{ url('/article/' . $article->article_id) }}" class="read-more">Read More</a>
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

</html>

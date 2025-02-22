@extends('master')

@section('tieudetrang')
    Article
@endsection

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Giới hạn kích thước ảnh chính trong bài viết */
    .article-image {
        max-height: 450px;
        object-fit: cover;
        width: 100%;
        border-radius: 10px;
    }

    /* Giới hạn kích thước ảnh trong sidebar */
    .related-article-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
    }

    .like-btn {
        background-color: #ff4757;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease-in-out;
    }
    .like-btn:hover {
        background-color: #e84118;
    }

    .advertisement {
        text-align: center;
        margin-bottom: 20px;
    }
    .advertisement img {
        width: 100%;
        border-radius: 10px;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }
    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .scroll-to-top {
        position: fixed;
        bottom: 20px; /* Adjusted from 20px to 60px */
        right: 20px;
        width: 50px;
        height: 50px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        cursor: pointer;
        display: none;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: background-color 0.3s ease-in-out;
    }
    .scroll-to-top:hover {
        background-color: #0056b3;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Bài viết chính -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="card-img-top article-image" alt="{{ $article->title }}">
                <div class="card-body">
                    <h2 class="card-title">{{ $article->title }}</h2>
                    <p class="text-muted">Lượt xem: {{ $article->views }} | Tác giả: {{ $article->author->username ?? 'N/A' }}</p>
                    <button class="like-btn" id="likeButton">
                        <i class="fa fa-thumbs-up"></i> Thích (<span id="likeCount">{{ $article->likes ?? 0 }}</span>)
                    </button>
                    <div class="article-content mt-3">{!! $article->content !!}</div>
                </div>
            </div>
        </div>
        
        <!-- Quảng cáo -->
        <div class="col-lg-4">
            <div class="advertisement fade-in"><a href="https://shop.mixigaming.com/">
                <img src="https://th.bing.com/th/id/R.638f0378be501384598c313b9254a074?rik=4q27eEjjmHzVeA&riu=http%3a%2f%2fintemnhandecal.net%2fwp-content%2fuploads%2f2019%2f07%2fcac-mau-in-poster-quang-cao.jpg&ehk=xEa19xG1SoAREwQ5DcFB6e7uJVPbPgG6cHVQGMLTuvA%3d&risl=&pid=ImgRaw&r=0" class="w-100" alt="Quảng cáo">
            </a>
            </div>
            
            <!-- Bài viết liên quan -->
            <div class="card shadow-sm fade-in">
                <div class="card-header bg-primary text-white">Bài viết liên quan</div>
                <ul class="list-group list-group-flush">
                    @foreach ($relatedArticles as $related)
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ asset('storage/' . $related->thumbnail_url) }}" class="mr-3 related-article-img" alt="{{ $related->title }}">
                            <a href="{{ route('client.articles.article', $related->article_id) }}" class="text-dark">{{ $related->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Button to scroll to top -->
<button id="scrollToTopButton" class="scroll-to-top">
    ↑
</button>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let likeButton = document.getElementById("likeButton");
        let likeCount = document.getElementById("likeCount");
        let liked = false;

        likeButton.addEventListener("click", function() {
            if (!liked) {
                liked = true;
                likeCount.textContent = parseInt(likeCount.textContent) + 1;
                likeButton.style.backgroundColor = "#e84118";
            }
        });

        document.querySelectorAll(".fade-in").forEach((element) => {
            element.classList.add("visible");
        });

        let scrollToTopButton = document.getElementById("scrollToTopButton");

        window.addEventListener("scroll", function() {
            if (window.scrollY > 200) {
                scrollToTopButton.style.display = "flex";
            } else {
                scrollToTopButton.style.display = "none";
            }
        });

        scrollToTopButton.addEventListener("click", function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>

@endsection

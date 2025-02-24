
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
    <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
    <meta name="author" content="" />

    <!-- Title  -->
    <title>Newzin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('client/img/fav.png') }}" title="Favicon" sizes="16x16" />

    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/bootstrap.min.css') }}" />

    <!-- font family -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- ionicons icons  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/ionicons.css') }}">
    <!-- line-awesome icons  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/line-awesome.css') }}">
    <!-- animate css  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/animate.css') }}" />
    <!-- fancybox popup  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/jquery.fancybox.css') }}" />
    <!-- lity popup  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/lity.css') }}" />
    <!-- swiper slider  -->
    <link rel="stylesheet" href="{{ asset('client/css/lib/swiper.min.css') }}" />

    <!-- ====== main style ====== -->
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}" />
    <title> Newzin </title>
</head>

<body class="home-style1">

    <!-- ====== start loading page ====== -->
    @include('website.layouts.partials.loadingpage')
    <!-- ====== end loading page ====== -->

    <!-- ====== start navbar-container ====== -->
    @include('website.layouts.partials.header')
    <!-- ====== start navbar-container ====== -->

    <!--Contents-->
    
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


    <!--End-Contents-->

    <!-- ====== start footer ====== -->
    @include('website.layouts.partials.footer')
    <!-- ====== end footer ====== -->

    <!-- ====== start to top button ====== -->
    <!-- <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 220.587;"></path></svg>
    </div> -->
    <!-- ====== end to top button ====== -->

    <!-- ====== request ====== -->
    <script src="{{ asset('client/js/lib/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/wow.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('client/js/lib/lity.js') }}"></script>
    <script src="{{ asset('client/js/lib/swiper.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('client/js/lib/jquery.counterup.js') }}"></script>
    <!-- <script src="client/js/lib/pace.js"></script> -->
    <script src="{{ asset('client/js/lib/back-to-top.js') }}"></script>
    <script src="{{ asset('client/js/lib/parallaxie.js') }}"></script>
    <script src="{{ asset('client/js/main.js') }}"></script>

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
        });
    </script>
</body>

</html>




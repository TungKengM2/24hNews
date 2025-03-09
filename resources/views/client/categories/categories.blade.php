<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metas -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
    <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
    <meta name="author" content="" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

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
    <style>
        .article-card {
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .featured-article .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .article-card .card-img-top {
            height: 150px;
            object-fit: cover;
        }
    </style>
    <html lang="en">

    <head>
        <!-- Metas -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="keywords" content="HTML5 Template Iteck Multi-Purpose themeforest" />
        <meta name="description" content="Iteck - Multi-Purpose HTML5 Template" />
        <meta name="author" content="" />
        <!-- Font Awesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

        <!-- Title  -->
        <title>Newzin</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('client/img/fav.png') }}" title="Favicon" sizes="16x16" />

        <!-- bootstrap 5 -->
        <link rel="stylesheet" href="{{ asset('client/css/lib/bootstrap.min.css') }}" />

        <!-- font family -->
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
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
        <title> Trang Báo Theo Danh Mục </title>
    </head>

<body class="home-style1">

    <!-- ====== start loading page ====== -->
    @include('website.layouts.partials.loadingpage')
    <!-- ====== end loading page ====== -->

    <!-- ====== start navbar-container ====== -->
    @include('website.layouts.partials.header')

 
    <section class="tc-trends-news-style6">
        <div class="container">
            <div class="content pb-50">
                <strong class="color-000 text-uppercase mb-30 d-block  pt-15 border-2 border-top border-dark">
                   Bài viết thịnh hành</strong>
                <div class="tc-post-grid-style6">
                    <div class="tc-trends-news-slider6 tc-slider-style1">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($articlesViews as $index => $articleviews)
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <div class="row gx-4 align-items-center">
                                                <div class="col-2">
                                                    <h4 class="number">{{ $index + 1 }}</h4>
                                                </div>
                                                <div class="col-4">
                                                    <a
                                                        href="{{ Auth::check() ? route('client.articles.article', ['article_id' => $articleviews->article_id]) : route('login') }}">
                                                        <img src="{{ asset('storage/' . $articleviews->thumbnail) }}"
                                                            alt="{{ $articleviews->title }}">
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <div class="content">
                                                        <h5 class="title">
                                                            <a
                                                                href="{{ Auth::check() ? route('client.articles.article', ['article_id' => $articleviews->article_id]) : route('login') }}">
                                                                {{ $articleviews->title }}
                                                            </a>
                                                        </h5>
                                                        <div class="meta-bot mt-10 color-666 fsz-11px text-uppercase">
                                                            <ul>
                                                                <li class="date"> <i class="la la-clock"></i>
                                                                    {{ $articleviews->created_at->diffForHumans() }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach



                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-60 overflow-hidden">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-12">
                    <div class="features-content pb-60">
                        <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">Bài viết nổi bật</p>
                        <div class="row gx-5">
                            @if($featuredArticle)
                            <div class="col-lg-8 border-1 border-end brd-gray">
                                <div class="tc-post-grid-default">
                                    <div class="item">
                                        <a href="{{ route('client.articles.article', ['article_id' => $featuredArticle->article_id]) }}" class="img img-cover th-400 d-block">
                                            <img src="{{ asset('storage/'. $featuredArticle->thumbnail_url) }}" alt="{{ $featuredArticle->title }}">
                                        </a>
                                        <div class="content pt-30">
                                            <a href="#" class="news-cat color-main fsz-13px text-uppercase mb-15 fw-bold">Featured</a>
                                            <h2 class="title ltspc--1 mb-20">
                                                <a href="{{ route('client.articles.article', ['article_id' => $featuredArticle->article_id]) }}">
                                                    {{ $featuredArticle->title }}
                                                </a>
                                            </h2>
                                            <div class="text color-666">
                                                {{ Str::limit($featuredArticle->preview_content, 150, '...') }}
                                            </div>
                                            <div class="meta-bot lh-1 mt-40">
                                                <span class="fsz-11px color-000 text-uppercase">
                                                    {{ $featuredArticle->created_at->diffForHumans() }}
                                                    <span class="color-999">by</span> {{ $featuredArticle->author->name ?? 'Admin' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-lg-4 border-1 border-end brd-gray">
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    @foreach($relatedArticles as $article)
                                        <div class="item">
                                            <div class="content">
                                                <a href="#" class="news-cat fsz-13px text-uppercase mb-2 fw-bold color-main">
                                                    {{ $article->category->name }}
                                                </a>
                                                <h5 class="title">
                                                    <a href="{{ route('client.articles.article', ['article_id' => $article->article_id]) }}" class="hover-underline">
                                                        {{ $article->title }}
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                </div>
                
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="tc-post-list-style3">
                        <div class="items mt-5 mt-lg-0">
                            <div class="item gary-item rounded-0 m-0">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="img img-cover overflow-hidden">
                                            <img src="https://newzin-html.themescamp.com/assets/img/latest/28.png" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="content mt-20 mt-lg-0">
                                            <div class="tags mb-10">
                                                <a href="home-politic.html#">Sponsored</a>
                                            </div>
                                            <h4 class="title fw-bold">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    LG Oled Television 4K Utral HD, Sale 10% Off on Amazon
                                                </a>
                                            </h4>
                                            <a href="home-politic.html#" class="meta-bot fsz-13px color-666">
                                                www.amazon.com <i class="la la-external-link-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    @include('website.layouts.partials.footer')
    <!-- ====== end footer ====== -->

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
</body>

</html>

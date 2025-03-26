@extends('website.layouts.master')

@section('content')
    <main>
        <section class="tc-breaking-news-style1">
            <div class="container">
                @php
                    use Illuminate\Support\Str;
                    use Carbon\Carbon;
                @endphp
                <div class="content pt-50 pb-50 border-1 border-bottom brd-gray">
                    <p class="color-000 fw-bold text-uppercase mb-30 ltspc-1">Tin mới nhất</p>
                    <div class="tc-post-grid-default">
                        <div class="tc-breaking-news-slider4 tc-slider-style1 slider-color-creamy1">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($articlesNews as $news)
                                        <div class="swiper-slide">
                                            <div class="item border-1 border-end brd-gray ">
                                                <div class="row gx-4 align-items-center">
                                                    <div class="col-4">
                                                        <a href="{{ route('articles.article', ['slug' => $news->slug]) }}"
                                                            class="d-block">
                                                            <div class="w-100"
                                                                style="width: 80px; height: 80px; overflow: hidden; border-radius: 8px;">
                                                                <img src="{{ asset('storage/' . $news->thumbnail_url) }}"
                                                                    class="w-100 h-100 object-fit-cover"
                                                                    alt="{{ $news->title }}">
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="{{ route('articles.article', ['slug' => $news->slug]) }}"
                                                                    class="hover-underline">
                                                                    {{ Str::limit($news->title, 100) }}
                                                                </a>
                                                            </h5>
                                                            <div class="meta-bot mt-10 color-666">
                                                                <ul>
                                                                    <li class="date">
                                                                        <i class="la la-clock"></i>
                                                                        {{ Carbon::parse($news->created_at)->diffForHumans() }}
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
                            <div class="swiper-button-next rounded-0"></div>
                            <div class="swiper-button-prev rounded-0"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
       

        <section class="pb-60 overflow-hidden">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-lg-11,5">
                        <div class="features-content pb-60">
                            <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">Bài viết
                                nổi bật</p>
                            <div class="row gx-5">
                                @if ($featuredArticle)
                                    <div class="col-lg-8 border-1 border-end brd-gray">
                                        <div class="tc-post-grid-default">
                                            <div class="item">
                                                <a href="{{ route('articles.article', ['slug' => $featuredArticle->slug]) }}"
                                                    class="img img-cover th-400 d-block">
                                                    <img src="{{ asset('storage/' . $featuredArticle->thumbnail_url) }}"
                                                        alt="{{ $featuredArticle->title }}">
                                                </a>
                                                <div class="content pt-30">
                                                    <a href="#"
                                                        class="news-cat color-main fsz-13px text-uppercase mb-15 fw-bold">
                                                        {{ $featuredArticle->category->name ?? 'Không có danh mục' }}
                                                    </a>
                                                    <h2 class="title ltspc--1 mb-20">
                                                        <a
                                                            href="{{ route('articles.article', ['slug' => $featuredArticle->slug]) }}">
                                                            {{ $featuredArticle->title }}
                                                        </a>
                                                    </h2>
                                                    <div class="text color-666">
                                                        {{ Str::limit($featuredArticle->preview_content, 150, '...') }}
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-40">
                                                        <span class="fsz-11px color-000 text-uppercase">
                                                            {{ $featuredArticle->created_at->diffForHumans() }}
                                                            <span class="color-999">by</span>
                                                            {{ $featuredArticle->author->name ?? 'Admin' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center text-muted">Không có bài viết nổi bật nào.</p>
                                @endif

                                <div class="col-lg-4 border-1 border-end brd-gray">
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            @if ($relatedArticles->count() > 0)
                                                @foreach ($relatedArticles as $article)
                                                    <div class="item">
                                                        <div class="content">
                                                            <a href="#"
                                                                class="news-cat fsz-13px text-uppercase mb-2 fw-bold color-main">
                                                                {{ $article->category->name }}
                                                            </a>
                                                            <h5 class="title">
                                                                <a href="{{ route('articles.article', ['slug' => $article->slug]) }}"
                                                                    class="hover-underline">
                                                                    {{ $article->title }}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-center text-muted">Không có bài viết liên quan.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="tc-post-list-style3">
                            <div class="items mt-5 mt-lg-0">
                                <div class="item gary-item rounded-0 m-0">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="img img-cover overflow-hidden">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/28.png"
                                                    alt="">
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
                    <div class="col-lg-6">
                        <div class="tc-widget-podcast-style6 mt-5 mt-lg-0">
                            <div
                                class="d-flex justify-content-between align-items-center mb-20 pt-15 border-2 border-top border-dark">
                                <p class="fw-bold text-uppercase fsz-14px">Featured posts</p>
                                <a href="page-blog.html" class="fsz-13px">See more <i
                                        class="la la-angle-right me-2"></i></a>
                            </div>
                            <div class="widget-card">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="home-politic.html#" class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/latest/59.png"
                                                alt="">
                                        </a>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="info mt-4 mt-lg-0">
                                            <a href="home-politic.html#"
                                                class="news-cat fsz-13px text-uppercase mb-2 fw-bold color-main">Business</a>
                                            <h5 class="title">
                                                <a href="page-single-post-creative.html" class="hover-underline">Episode
                                                    15: Mike Pence Day at the
                                                    January 6 Committee</a>
                                            </h5>
                                            <audio controls class="audio">
                                                <source src="https://newzin-html.themescamp.com/assets/img/audio1.mp3"
                                                    type="audio/mpeg">
                                            </audio>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- ====== start latest posts style4 ====== -->
        <section class="tc-latest-posts-style4 pt-70 pb-70">
            <div class="container">
                <div class="content pt-15 border-2 border-white border-top">
                    <div class="row">
                        <div class="col-lg-3 col-8">
                            <div class="d-flex justify-content-between align-items-center mb-30">
                                <p class="fw-bold text-uppercase fsz-14px">latest news</p>
                                <a href="page-blog.html" class="fsz-13px">See more <i
                                        class="la la-angle-right me-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="tc-post-grid-default">
                        <div class="tc-latest-posts-slider4 tc-slider-style1">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <a href="page-single-post-creative.html" class="img img-cover th-180 d-block">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/32.png"
                                                    alt="">
                                            </a>
                                            <div class="content pt-20">
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">Polictic</a>
                                                <h4 class="title">
                                                    <a href="page-single-post-creative.html">
                                                        Biden asks Congress for to support Ukraine
                                                    </a>
                                                </h4>
                                                <div class="meta-bot lh-1 mt-30">
                                                    <a href="home-politic.html#"
                                                        class="fsz-11px text-white text-uppercase">25 Minutes ago
                                                        <span class="color-999">by</span> Admin</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity=""
                                                class="img img-cover th-180 d-block">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/1.png"
                                                    alt="">
                                                <span class="video_icon icon-60">
                                                    <i class="ion-play"></i>
                                                </span>
                                            </a>
                                            <div class="content pt-20">
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">World,</a>
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">Video</a>
                                                <h4 class="title">
                                                    <a href="page-single-post-features.html">
                                                        U.S. Discussing Whether to Ask Ukraine to ‘Dial Back’ War Aims:
                                                        NBC
                                                    </a>
                                                </h4>
                                                <div class="meta-bot lh-1 mt-30">
                                                    <a href="home-politic.html#"
                                                        class="fsz-11px text-white text-uppercase">1 day ago
                                                        <span class="color-999">by</span> conor bradley</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <a href="page-single-post-creative.html" class="img img-cover th-180 d-block">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/60.png"
                                                    alt="">
                                            </a>
                                            <div class="content pt-20">
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">Polictic</a>
                                                <h4 class="title">
                                                    <a href="page-single-post-creative.html">
                                                        DeSantis draws huge cash haul from Trump donors
                                                    </a>
                                                </h4>
                                                <div class="meta-bot lh-1 mt-30">
                                                    <a href="home-politic.html#"
                                                        class="fsz-11px text-white text-uppercase">4 Hours ago
                                                        <span class="color-999">by</span> Luis diaz</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="item">
                                            <a href="page-single-post-creative.html" class="img img-cover th-180 d-block">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/61.png"
                                                    alt="">
                                            </a>
                                            <div class="content pt-20">
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">Business,</a>
                                                <a href="home-politic.html#"
                                                    class="news-cat color-main fsz-13px text-uppercase mb-10 fw-bold">White
                                                    House</a>
                                                <h4 class="title">
                                                    <a href="page-single-post-creative.html">
                                                        Texas lawmaker salutes the power of Juneteenth
                                                    </a>
                                                </h4>
                                                <div class="meta-bot lh-1 mt-30">
                                                    <a href="home-politic.html#"
                                                        class="fsz-11px text-white text-uppercase">15 Hours ago
                                                        <span class="color-999">by</span> Luis diaz</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- pagination -->
                            <div class="swiper-pagination"></div>
                            <!-- arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end latest posts style4 ====== -->

        <!-- ====== start columnist ====== -->
        <section class="tc-columnist-style1 pt-60 pb-60">
            <div class="container">
                <div class="content">
                    <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">Featured writers
                    </p>
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-4">
                                <a href="home-politic.html#" class="columnist-card d-flex align-items-center">
                                    <div
                                        class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                        <img src="https://newzin-html.themescamp.com/assets/img/colums/1.png"
                                            alt="">
                                    </div>
                                    <div class="info">
                                        <h6 class="name fsz-20px mb-10">
                                            Conor Bradley
                                        </h6>
                                        <div class="jop-title">
                                            <small class="fsz-13px color-999">Specialize in</small>
                                            <p class="fsz-13px text-uppercase">Business, technology</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="home-politic.html#"
                                    class="columnist-card d-flex align-items-center mt-4 mt-lg-0">
                                    <div
                                        class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                        <img src="https://newzin-html.themescamp.com/assets/img/colums/2.png"
                                            alt="">
                                    </div>
                                    <div class="info">
                                        <h6 class="name fsz-20px mb-10">
                                            Luis Diaz
                                        </h6>
                                        <div class="jop-title">
                                            <small class="fsz-13px color-999">Specialize in</small>
                                            <p class="fsz-13px text-uppercase">Politic, lifestyle</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="home-politic.html#"
                                    class="columnist-card d-flex align-items-center mt-4 mt-lg-0">
                                    <div
                                        class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                        <img src="https://newzin-html.themescamp.com/assets/img/colums/3.png"
                                            alt="">
                                    </div>
                                    <div class="info">
                                        <h6 class="name fsz-20px mb-10">
                                            Alberto Moreno
                                        </h6>
                                        <div class="jop-title">
                                            <small class="fsz-13px color-999">Specialize in</small>
                                            <p class="fsz-13px text-uppercase">Entertaiment, culture, wolrd </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end columnist ====== -->

        <!-- ====== start must read ====== -->
        <section>
            <div class="container">
                <div class="tags-posts pt-60 pb-60 border-2 border-top brd-gray">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="tc-must-read-style6 p-30 bg-gray2">
                                <div class="box-content border-2 border-top border-dark py-3">
                                    <p class="fw-bold text-uppercase fsz-14px mb-30"> Must read </p>
                                    <div class="tc-post-grid-default">
                                        <div class="item pb-30">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <a href="page-single-post-creative.html"
                                                        class="img img-cover th-230 d-block">
                                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/31.png"
                                                            alt="">
                                                    </a>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="content mt-4 mt-lg-0">
                                                        <a href="home-politic.html#"
                                                            class="news-cat color-main fsz-13px text-uppercase mb-15 fw-bold">White
                                                            House</a>
                                                        <h2 class="title mb-20">
                                                            <a href="page-single-post-creative.html">
                                                                Manoah dominates, closes in on Blue Jays history
                                                            </a>
                                                        </h2>
                                                        <div class="text color-666">
                                                            The social-media company is in discussions to sell itself to
                                                            Elon, a
                                                            dramatic turn of events just 11 days after the [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 mt-40">
                                                            <a href="home-politic.html#"
                                                                class="fsz-11px color-000 text-uppercase"> 2 Days ago <span
                                                                    class="color-999">by</span> Moreno </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub-content pt-30 border-1 border-top brd-gray">
                                            <div class="row gx-5">
                                                <div class="col-lg-4 border-1 border-end brd-gray">
                                                    <div class="item">
                                                        <a href="page-single-post-creative.html"
                                                            class="img img-cover th-160 d-block">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/trend/14.png"
                                                                alt="">
                                                        </a>
                                                        <div class="content pt-20">
                                                            <a href="home-politic.html#"
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Legal</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    Sponsored Content Post with Double line
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 border-1 border-end brd-gray">
                                                    <div class="item">
                                                        <a href="page-single-post-creative.html"
                                                            class="img img-cover th-160 d-block">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/latest/62.png"
                                                                alt="">
                                                        </a>
                                                        <div class="content pt-20">
                                                            <a href="home-politic.html#"
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Congress</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    France’s Jupiter may be about to discover a culture of
                                                                    compromise
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="item">
                                                        <a href="page-single-post-creative.html"
                                                            class="img img-cover th-160 d-block">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/latest/63.png"
                                                                alt="">
                                                        </a>
                                                        <div class="content pt-20">
                                                            <a href="home-politic.html#"
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Elections</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    “A World without Risk’
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-single-tag-post mt-60">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">
                                    legal </p>
                                <div class="pb-30 border-1 border-bottom brd-gray">
                                    <div class="row">
                                        <div class="col-lg-8 border-1 border-end brd-gray">
                                            <div class="tc-post-overlay-default">
                                                <div class="img th-400 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/64.png"
                                                        alt="">
                                                    <div class="tags">
                                                        <a href="home-politic.html#"
                                                            class="text-capitalize color-main fw-bold">legal</a>
                                                    </div>
                                                </div>
                                                <div class="content p-40">
                                                    <h3 class="title mb-30">
                                                        <a href="page-single-post-creative.html">What a Roberts compromise
                                                            on abortion could look like</a>
                                                    </h3>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#">25 Minutes ago <span
                                                                class="color-999">by</span> cornor bradley</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="tc-post-list-style2">
                                                <div class="items">
                                                    <div class="item pb-20">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">Global financial
                                                                    markets after covid 2022</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">15 hours ago <span
                                                                        class="color-999">by</span> luis diaz</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">U.S Stocks Market
                                                                    today</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">1 day ago <span
                                                                        class="color-999">by</span> Admin</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">World swimming
                                                                    bans transgender athletes from women’s events</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">15 hours ago <span
                                                                        class="color-999">by</span> luis diaz</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20 border-0">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">Success Stories of
                                                                    Starbuck</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">2 days ago <span
                                                                        class="color-999">by</span> Cornor bradley</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tc-post-list-style2 pt-30">
                                    <div class="items">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="item border-0">
                                                    <div class="row gx-3 align-items-center">
                                                        <div class="col-4">
                                                            <div class="img th-70 img-cover">
                                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/35.png"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="content">
                                                                <h5 class="title">
                                                                    <a href="page-single-post-creative.html">Horseback
                                                                        Riding, <br> A business-class hobby</a>
                                                                </h5>
                                                                <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                    <a href="home-politic.html#">1 day ago <span
                                                                            class="color-999">by</span> Admin</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="item border-0">
                                                    <div class="row gx-3 align-items-center">
                                                        <div class="col-4">
                                                            <div class="img th-70 img-cover">
                                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/40.png"
                                                                    alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="content">
                                                                <h5 class="title">
                                                                    <a href="page-single-post-creative.html">The Financial
                                                                        statements of ABC Bank are questionable</a>
                                                                </h5>
                                                                <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                    <a href="home-politic.html#">15 hours ago <span
                                                                            class="color-999">by</span> luis diaz </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ====== start banner14 ====== -->
                            <section class="banner14 pt-60 pb-60">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <a href="home-politic.html#" class="img">
                                                <img src="https://newzin-html.themescamp.com/assets/img/banner14.png"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- ====== end banner14 ====== -->
                            <div class="tc-single-tag-post">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">
                                    legal </p>
                                <div class="tc-post-grid-default pb-30 border-2 border-bottom brd-gray">
                                    <div class="row gx-5">
                                        <div class="col-lg-6 border-1 border-end brd-gray">
                                            <div class="item">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-280 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/65.png"
                                                        alt="">
                                                </a>
                                                <div class="content pt-30">
                                                    <h3 class="title ltspc--1 mb-20">
                                                        <a href="page-single-post-creative.html">
                                                            DeSantis draws huge cash haul from Trump donors
                                                        </a>
                                                    </h3>
                                                    <div class="text color-666">
                                                        The social-media company is in discussions to sell itself to Elon, a
                                                        dramatic turn of events just 11 days after the [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-40">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">2 Days ago
                                                            <span class="color-999">by</span> Moreno</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="item">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-280 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/66.png"
                                                        alt="">
                                                </a>
                                                <div class="content pt-30">
                                                    <h3 class="title ltspc--1 mb-20">
                                                        <a href="page-single-post-creative.html">
                                                            Deese says Biden's Saudi trip not out of desperation
                                                        </a>
                                                    </h3>
                                                    <div class="text color-666">
                                                        The social-media company is in discussions to sell itself to Elon, a
                                                        dramatic turn of events just 11 days after the [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-40">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">2 Days ago
                                                            <span class="color-999">by</span> admin</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tc-post-list-style3 pt-30">
                                    <div class="items">
                                        <div class="item">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="img th-190 img-cover">
                                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/50.png"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="content mt-4 mt-lg-0">
                                                        <h4 class="title">
                                                            <a href="page-single-post-creative.html">FBI, Police
                                                                Investigating ‘Disturbing’ Letters Found at Tennessee
                                                                Churches</a>
                                                        </h4>
                                                        <div class="text color-666 mt-20">
                                                            Do No Harm’s report concludes that UCSD’s ‘increasing
                                                            integration of racial politics into its medical school and
                                                            related programs is one case [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                            <a href="home-politic.html#">1 day ago <span
                                                                    class="color-999">by</span> thiago</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item border-0 pb-0">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="img th-190 img-cover">
                                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/67.png"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="content mt-4 mt-lg-0">
                                                        <h4 class="title">
                                                            <a href="page-single-post-creative.html">African Union chief
                                                                urges EU to help with food payments to Russia</a>
                                                        </h4>
                                                        <div class="text color-666 mt-20">
                                                            Do No Harm’s report concludes that UCSD’s ‘increasing
                                                            integration of racial politics into its medical school and
                                                            related programs is one case [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                            <a href="home-politic.html#">1 day ago <span
                                                                    class="color-999">by</span> thiago</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="widgets">
                                <!-- widget-tags -->
                                <div class="tc-widget-tags-style6 pb-50 mt-5 mt-lg-0">
                                    <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-20">
                                        popular tags </p>
                                    <div class="tags-content">
                                        <a href="home-politic.html#">Covid-19</a>
                                        <a href="home-politic.html#">Bitcoin</a>
                                        <a href="home-politic.html#">Wordpress</a>
                                        <a href="home-politic.html#">Elon Musk</a>
                                        <a href="home-politic.html#">Google Cloud</a>
                                        <a href="home-politic.html#">Figma</a>
                                        <a href="home-politic.html#">Crypto</a>
                                        <a href="home-politic.html#">Marketplace</a>
                                        <a href="home-politic.html#">Graphicriver</a>
                                        <a href="home-politic.html#">Game Consoles</a>
                                        <a href="home-politic.html#">Robotics</a>
                                        <a href="home-politic.html#">Psd</a>
                                        <a href="home-politic.html#">Hackers</a>
                                        <a href="home-politic.html#">Foody</a>
                                        <a href="home-politic.html#">Breakfast</a>
                                        <a href="home-politic.html#">Dessert</a>
                                        <a href="home-politic.html#">Soup</a>
                                        <a href="home-politic.html#">Cuisine</a>
                                        <a href="home-politic.html#">Vegan</a>
                                        <a href="home-politic.html#">Restaurant</a>
                                        <a href="home-politic.html#">Beef</a>
                                    </div>
                                </div>
                                <!-- widget-videos -->
                                <div class="tc-widget-videos-style6">
                                    <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                        featured videos </p>
                                    <div class="videos-content">
                                        <div class="main-card">
                                            <div class="img th-300 img-cover">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/68.png"
                                                    alt="">
                                                <div class="tags">
                                                    <a href="home-politic.html#">Politic</a>
                                                </div>
                                            </div>
                                            <div class="info">
                                                <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity=""
                                                    class="video_icon icon-60 mb-30">
                                                    <i class="ion-play fs-5"></i>
                                                </a>
                                                <h5 class="title mb-15">
                                                    <a href="page-single-post-features.html">
                                                        Big Title for featured post with double
                                                    </a>
                                                </h5>
                                                <div class="meta-bot">
                                                    <a href="home-politic.html#" class="fsz-11px text-uppercase"> 2 Days
                                                        ago <span class="color-999">by</span> Moreno </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub-cards">
                                            <a href="page-single-post-creative.html" class="item">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/69.png"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        The Taboo lifts on discussing Biden’s Age
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html" class="item">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/70.png"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        This Year, Florida’s not a Swing State
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html" class="item border-0">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/71.png"
                                                        alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        Why do central banks raise interest rates?
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-blog.html" class="fsz-13px mt-15">
                                                <span>See more</span>
                                                <i class="las la-angle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- ====== start banner15 ====== -->
                                <div class="banner15 pt-60 pb-60 text-center">
                                    <a href="home-politic.html#" class="img">
                                        <img src="https://newzin-html.themescamp.com/assets/img/banner15.png"
                                            alt="">
                                    </a>
                                </div>
                                <!-- ====== end banner15 ====== -->
                                <!-- widget-categories -->
                                <div class="tc-widget-categories-style6">
                                    <p class="fw-bold text-uppercase fsz-14px mb-15 border-2 border-top border-dark pt-20">
                                        top categories </p>
                                    <div class="categories-content">
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-fist-raised"></i>
                                                </span>
                                                <strong class="title">Politics</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">24 Posts</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-landmark"></i>
                                                </span>
                                                <strong class="title">White House</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">15 Posts</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-balance-scale"></i>
                                                </span>
                                                <strong class="title">Legal</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">17 Posts</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-globe"></i>
                                                </span>
                                                <strong class="title">World</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">9 Posts</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-suitcase"></i>
                                                </span>
                                                <strong class="title">Business</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">16 Posts</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-chart-pie"></i>
                                                </span>
                                                <strong class="title">Economy</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">2 Posts</small>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="page-blog.html" class="fsz-13px mt-15">
                                        <span>See more</span>
                                        <i class="las la-angle-right"></i>
                                    </a>
                                </div>
                                <!-- widget-survey -->
                                <div class="tc-widget-survey-style6 mt-60">
                                    <p class="text-uppercase ltspc-1 mb-20">quick survey</p>
                                    <div class="title fsz-16px fw-bold mb-15">
                                        How was your experience on newzin?
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="survey" id="survey1">
                                        <label class="form-check-label fsz-13px color-666 lh-5" for="survey1">
                                            Awesome, I’m satisfied!
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="survey" id="survey2">
                                        <label class="form-check-label fsz-13px color-666 lh-5" for="survey2">
                                            Normal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="survey" id="survey3">
                                        <label class="form-check-label fsz-13px color-666 lh-5" for="survey3">
                                            Bad! Need improve more
                                        </label>
                                    </div>
                                    <div class="btns">
                                        <button class="butn btn_color"> Submit </button>
                                        <button class="butn"> Result </button>
                                    </div>
                                    <p class="fsz-12px color-666"> <span class="fw-bold color-000">24,562</span> Peoples
                                        joined</p>
                                </div>
                                <!-- widget-survey -->
                                <div class="tc-widget-webStories-style5 mt-60">
                                    <p class="fw-bold text-uppercase fsz-14px mb-15 border-2 border-top border-dark pt-15">
                                        google web stories </p>
                                    <div class="web-content">
                                        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card pt-0"
                                            data-fancybox="">
                                            <div class="img img-cover">
                                                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/1.png"
                                                    alt="">
                                            </div>
                                            <div class="cont">
                                                <h6>Kayak stories</h6>
                                            </div>
                                        </a>
                                        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card seen"
                                            data-fancybox="">
                                            <div class="img img-cover">
                                                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/2.png"
                                                    alt="">
                                            </div>
                                            <div class="cont">
                                                <h6>6 Tips Successful for Developers</h6>
                                            </div>
                                        </a>
                                        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card pb-0 border-0"
                                            data-fancybox="">
                                            <div class="img img-cover">
                                                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/3.png"
                                                    alt="">
                                            </div>
                                            <div class="cont">
                                                <h6>PS Controller</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end must read ====== -->
        <section class="tags-posts">
            <div class="container">
                <div class="content pt-60 pb-60 border-2 border-top brd-gray">
                    <div class="titles d-none d-lg-block">
                        <div class="row gx-5">
                            <div class="col-lg-4">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                    Congress </p>
                            </div>
                            <div class="col-lg-4">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                    elections </p>
                            </div>
                            <div class="col-lg-4">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                    Business </p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-4 border-1 border-end brd-gray">
                            <p
                                class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                Congress </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/72.png"
                                            alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                Mitch Daniels weighing return to politics
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            The social-media company is in discussions to sell Elon, a dramatic turn of
                                            events just 11 days [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">2 Days
                                                ago <span class="color-999">by</span> Moreno</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/73.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Senators tack $45B onto
                                                            Biden's defense budget</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">2 Days ago <span
                                                                class="color-999">by</span> Moreno</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/74.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Senate advances bill on
                                                            veterans' burn pit care</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">1 Days ago <span
                                                                class="color-999">by</span> Admin</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 border-1 border-end brd-gray mt-5 mt-lg-0">
                            <p
                                class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                elections </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/75.png"
                                            alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                Dem redistricting group lays out broad 2022 election targets
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            The social-media company is in discussions to sell Elon, a dramatic turn of
                                            events just 11 days [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">2 Days
                                                ago <span class="color-999">by</span> Moreno</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/76.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Jan. 6 panel calls Ginni
                                                            Thomas to testify</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">2 Days ago <span
                                                                class="color-999">by</span> Moreno</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/77.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content h-auto">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Connell's gun safety</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">1 Days ago <span
                                                                class="color-999">by</span> Admin</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-5 mt-lg-0">
                            <p
                                class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                Business </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/78.png"
                                            alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                FEMA flood program could violate civil rights law
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            The social-media company is in discussions to sell Elon, a dramatic turn of
                                            events just 11 days [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">1 Days
                                                ago <span class="color-999">by</span> admin</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/79.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content pb-20">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Here Comes Fiscal
                                                            Arberto</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">2 Days ago <span
                                                                class="color-999">by</span> Moreno</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html"
                                                    class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/80.png"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Geoff Dyer: How to grow
                                                            old in America</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#"
                                                            class="fsz-11px color-000 text-uppercase">1 Days ago <span
                                                                class="color-999">by</span> Admin</a>
                                                    </div>
                                                </div>
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



        <!-- ====== start banner16 ====== -->
        <section class="banner16 pt-70 pb-70 bg-gray1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <a href="home-politic.html#" class="img">
                            <img src="https://newzin-html.themescamp.com/assets/img/banner16.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

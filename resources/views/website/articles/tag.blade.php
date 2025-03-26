@extends('website.layouts.master')

@section('content')
<style>
.hr-section {
    background-color: #f9f9f9;
    padding: 20px 0;
}
.hr-section .title a:hover {
    color: #0056b3;
}

<<<<<<< HEAD
</style>
    <main>
        <section class="tc-post-title-style1 py-4  border-bottom">
            <div class="container tc-post-title-style1">
                <div class="row align-items-center tc-post-title-style1">
                    <div class="col-lg-8">
                        <h4 class="mb-2 fw-bold">{{ $tag->name }}</h4>
                        <p class=" fw-semibold mb-0">{{ 'Khám phá các bài viết trong thẻ này' }}</p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Tag</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $tag->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== start  ====== -->
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
                                            <div class="item border-1  brd-gray ">
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




        <!-- ====== end ====== -->

        <!-- ====== start Latest news ====== -->
        <section class=" tc-post-title-style1">
            <div class="container tc-post-title-style1">
                <div class="section-content pt-50 pb-50 border-bottom border-1 brd-gray">
                    <div class="row gx-5">
                        <div class="col-lg-9">
                            <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">Các bài viết yêu thích nhất</p>

                            @if ($articlesViews->count() > 0)
                                @php
                                    // Lấy bài viết đầu tiên từ collection của paginator
                                    $firstArticle = $articlesViews->getCollection()->first();
                                @endphp

                                <div class="row gx-5">
                                    <!-- Bài viết lớn -->
                                    <div class="col-lg-6 border-end brd-gray border-1">
                                        <div class="tc-post-grid-style3">
                                            <div class="item">
                                                <a href="{{ route('articles.article', ['slug' => $firstArticle->slug]) }}">
                                                    <div class="img img-cover th-300">
                                                        <img src="{{ asset('storage/' . $firstArticle->thumbnail_url) }}"
                                                            alt="{{ $firstArticle->title }}"
                                                            class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                </a>
                                                <div class="content pt-30">
                                                    <h2 class="title ltspc--1 mb-20 fw-normal">
                                                        <a
                                                            href="{{ route('articles.article', ['slug' => $firstArticle->slug]) }}">
                                                            {{ $firstArticle->title }}
                                                        </a>
                                                    </h2>
                                                    <div class="meta-bot mt-20 fsz-12px color-666 text-uppercase">
                                                        {{ $firstArticle->category->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Danh sách bài viết nhỏ -->
                                    <div class="col-lg-6 border-end brd-gray border-1">
                                        <div class="tc-post-list-style2">
                                            <div class="items">
                                                @foreach ($articlesViews->getCollection()->skip(1)->take(4) as $news)
                                                    <div class="item">
                                                        <div class="row gx-3 align-items-center">
                                                            <div class="col-8">
                                                                <div class="content">
                                                                    <h4 class="title">
                                                                        <a href="{{ route('articles.article', ['slug' => $news->slug]) }}"
                                                                            class="hover-underline">
                                                                            {{ $news->title }}
                                                                        </a>
                                                                    </h4>
                                                                    <div
                                                                        class="news-cat color-666 fsz-11px text-uppercase mt-20">
                                                                        {{ $news->category->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                        </div>
                                                    </div>
                                                @endforeach
=======
 <main>

        <!-- ====== start  ====== -->

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
>>>>>>> dadf66f2 (có trang tag)
                                            </div>
                                        </div>
                                    </div>
                                </div>
<<<<<<< HEAD
                            @else
                                <p>Hiện tại không có bài viết nào</p>
                            @endif



                        </div>
                        <div class="col-lg-3">
                            <div class="">
                                <p class="color-000 text-uppercase mb-20 ltspc-1 fw-bold">Thẻ phổ biến</p>
                                {{-- <div class="content">
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}"
                                            class="btn border border-1 mt-20 py-2 px-3">
                                            {{ $tag->name }} ({{ $tag->published_articles_count }})
                                        </a>
                                    @endforeach
                                </div> --}}
                                <div class="tc-post-list-style1 p-3">
                                    <div class="tc-post-list-style1 d-flex flex-wrap gap-2">

                                        @foreach ($tags as $tag)
                                        <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}" class="  btn btn-sm btn-light btn-outline-secondary">{{ $tag->name }} ({{ $tag->published_articles_count }})</a>

                                    @endforeach

=======
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
>>>>>>> dadf66f2 (có trang tag)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                </div>
            </div>
        </section>

        <!-- ====== end Latest news ====== -->


    <!-- ====== Tin tức có thể quan tâm ====== -->
    <section class="tc-news-style1">
        <div class="container">
            <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                <h5 class="color-000 text-uppercase mb-40 ltspc-1 fw-bold">Tin Tức Có Thể Quan Tâm
                    <i class="la la-angle-right ms-1"></i>
                </h5>
                <div class="row">
                    @foreach ($otherArticles as $data)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="news-card h-100 shadow-sm rounded overflow-hidden">
                                <div class="img img-cover th-200">
                                    <img src="{{ $data->thumbnail_url ? asset('storage/' . $data->thumbnail_url) : 'https://via.placeholder.com/400' }}"
                                        alt="{{ $data->title }}">
                                </div>
                                <div class="info p-3">
                                    <h6 class="category text-uppercase text-primary mb-2">
                                        {{ $data['category']->name }}
                                    </h6>
                                    <h5 class="title mb-3">{{ $data->title }}</h5>
                                    <a href="{{ Auth::check() ? route('articles.article', $data->slug) : url('/login-user') }}"
                                        class="btn btn-sm btn-outline-primary mt-2">
                                        Xem chi tiết <i class="la la-angle-right"></i>
=======

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
>>>>>>> dadf66f2 (có trang tag)
                                    </a>
                                </div>
                            </div>
                        </div>
<<<<<<< HEAD
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- ====== end tin tức có thể quan tâm ====== -->



        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.tc-tabs-head a').on('click', function(e) {
                    e.preventDefault();
                    var filter = $(this).data('filter');

                    // Cập nhật active cho các tab
                    $('.tc-tabs-head a').removeClass('active');
                    $(this).addClass('active');

                    // Lọc các item dựa trên filter
                    if (filter === 'all') {
                        $('.tc-tabs-body .item').show();
                    } else {
                        $('.tc-tabs-body .item').hide().filter('.' + filter).show();
                    }
                });
            });
        </script>


        <!-- ====== end tabs ====== -->

=======
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




        </main>

        <!-- ====== end ====== -->

        <!-- ====== start trends news ====== -->
        <section class="tc-trends-news-style3 pt-50 pb-50">
            <div class="container">
                <div class="section-content">
                    <div class="row gx-5">
                        <div class="col-lg-9 border-1 border-end brd-gray">
                            <div class="tc-trends-news-slider3 tc-slider-style2">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="tc-post-overlay-style2">
                                                <div class="img th-600 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/trend/9.png" alt="">
                                                    <div class="tags tags-40">
                                                        <a href="home-food.html#">Featured</a>
                                                        <a href="home-food.html#">Restaurant</a>
                                                    </div>
                                                </div>
                                                <div class="content ps-40 pe-40 pb-40">
                                                    <h2 class="title mb-20">
                                                        <a href="page-single-post-creative.html">Top 15 Bakery Store in Brooklyn <br> with Vintage style</a>
                                                    </h2>
                                                    <div class="text mb-40">
                                                        To be perfectly honest, I’m not a big fan of alcoholic beverages in summer. They make me <br> sweat even more; they make me [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 fsz-13px text-white text-capitalize">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="home-food.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="home-food.html#"><i class="la la-user me-2"></i> by logan</a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="home-food.html#"><i class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="tc-post-overlay-style2">
                                                <div class="img th-600 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/trend/10.png" alt="">
                                                    <div class="tags tags-40">
                                                        <a href="home-food.html#">Featured</a>
                                                        <a href="home-food.html#">Restaurant</a>
                                                    </div>
                                                </div>
                                                <div class="content ps-40 pe-40 pb-40">
                                                    <h2 class="title mb-20">
                                                        <a href="page-single-post-creative.html">Top 15 Bakery Store in Brooklyn <br> with Vintage style</a>
                                                    </h2>
                                                    <div class="text mb-40">
                                                        To be perfectly honest, I’m not a big fan of alcoholic beverages in summer. They make me <br> sweat even more; they make me [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 fsz-13px text-white text-capitalize">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="home-food.html#"><i class="la la-calendar me-2"></i> Dec 14,
                                                                    2022</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="home-food.html#"><i class="la la-user me-2"></i> by logan</a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="home-food.html#"><i class="la la-comment me-2"></i> 55
                                                                    Comments</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="tc-post-list-style4">
                                <p class="color-000 fw-bold text-uppercase mb-30 ltspc-1 lh-1">trending posts</p>
                                <div class="tc-post-overlay-style2">
                                    <div class="img th-180 img-cover">
                                        <img src="https://newzin-html.themescamp.com/assets/img/trend/11.png" alt="">
                                    </div>
                                    <div class="content ps-20 pe-20 pb-20 text-white">
                                        <h6 class="title">
                                            <a href="page-single-post-creative.html">Top 5 Street Tacos in  Mahattan</a>
                                        </h6>
                                        <a href="home-food.html#" class="text-uppercase fsz-12px mt-10">cuisine</a>
                                    </div>
                                </div>
                                <div class="items">
                                    <a href="page-single-post-creative.html" class="item">
                                        <h2 class="num">
                                            2
                                        </h2>
                                        <div class="content border-start border-1 brd-gray ms-15 ps-15">
                                            <h6 class="title">How to choose blueberries clean & fresh</h6>
                                            <span class="fsz-10px color-666 text-uppercase mt-2">receipes</span>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <h2 class="num">
                                            3
                                        </h2>
                                        <div class="content border-start border-1 brd-gray ms-15 ps-15">
                                            <h6 class="title">Healthy breakfast just in 10 minutes everyday</h6>
                                            <span class="fsz-10px color-666 text-uppercase mt-2">receipes, breakfast</span>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <h2 class="num">
                                            4
                                        </h2>
                                        <div class="content border-start border-1 brd-gray ms-15 ps-15">
                                            <h6 class="title">Don’t need est calories everyday with Calo App</h6>
                                            <span class="fsz-10px color-666 text-uppercase mt-2">cuisine, asia</span>
                                        </div>
                                    </a>
                                    <a href="page-blog.html" class="fsz-13px color-000 text-uppercase pt-30">
                                        See all posts <i class="la la-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end trends news ====== -->

        <!-- ====== start google web stories ====== -->
        <section class="tc-google-stories-style1">
            <div class="container">
                <div class="section-content pt-60 pb-60 border-top brd-gray">
                    <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">google web stories</p>
                    <div class="tc-google-stories-slider1 tc-slider-style1">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/9.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Vegan Brea ...
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item seen">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/10.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            6 Tips To Ch ...
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/11.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Sugar
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/12.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Minimal Drin ...
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/13.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            A Little Honey
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/14.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Ice Cream
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/15.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Cafe Morning
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/16.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Food Art
                                        </div>
                                    </a>
                                </div>
                                <div class="swiper-slide">
                                    <a href="home-food.html#" class="story-item">
                                        <div class="img img-cover">
                                            <img src="https://newzin-html.themescamp.com/assets/img/google-stories/12.png" alt="">
                                        </div>
                                        <div class="title fsz-14px color-000 mt-10">
                                            Minimal Drin ...
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end google web stories ====== -->


        <!-- ====== start banner10 ====== -->
        <section class="banner10">
            <div class="container">
                <div class="content pt-60 pb-60 border-top border-1 brd-gray">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <a href="home-food.html#" class="d-block img-cover">
                                <img src="https://newzin-html.themescamp.com/assets/img/banner10.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end banner10 ====== -->


        <!-- ====== start tc-post-grid-style2 ====== -->
        <div class="tc-post-grid-style2">
            <div class="container">
                <div class="content">
                    <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">editor’s pick</p>
                    <div class="tc-editors-pick-slider">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="item">
                                        <a href="https://newzin-html.themescamp.com/assets/img/edit_choice/5.png" class="img th-230 img-cover d-block" data-fancybox="editors_pick">
                                            <img src="https://newzin-html.themescamp.com/assets/img/edit_choice/5.png" alt="">
                                        </a>
                                        <div class="info">
                                            <h3 class="title mt-30">
                                                <a href="page-single-post-creative.html">Start a new day with a simple breakfast</a>
                                            </h3>
                                            <span class="color-666 fsz-12px text-uppercase mt-15">receipes, breakfast</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <a href="https://newzin-html.themescamp.com/assets/img/edit_choice/6.png" class="img th-230 img-cover d-block" data-fancybox="editors_pick">
                                            <img src="https://newzin-html.themescamp.com/assets/img/edit_choice/6.png" alt="">
                                        </a>
                                        <div class="info">
                                            <h3 class="title mt-30">
                                                <a href="page-single-post-creative.html">Stories give inspiration amd feel about art of food by Japan’s chefs</a>
                                            </h3>
                                            <span class="color-666 fsz-12px text-uppercase mt-15">cuisine, news</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <a href="https://youtu.be/pGbIOC83-So?t=21" class="img th-230 img-cover d-block" data-lity="editors_pick">
                                            <img src="https://newzin-html.themescamp.com/assets/img/edit_choice/7.png" alt="">
                                            <span class="video_icon icon-70">
                                                <i class="ion-play"></i>
                                            </span>
                                        </a>
                                        <div class="info">
                                            <h3 class="title mt-30">
                                                <a href="page-single-post-features.html">Poseidon Sea Foods</a>
                                            </h3>
                                            <span class="color-666 fsz-12px text-uppercase mt-15">receipes, videos</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <a href="https://newzin-html.themescamp.com/assets/img/edit_choice/6.png" class="img th-230 img-cover d-block" data-fancybox="editors_pick">
                                            <img src="https://newzin-html.themescamp.com/assets/img/edit_choice/6.png" alt="">
                                        </a>
                                        <div class="info">
                                            <h3 class="title mt-30">
                                                <a href="page-single-post-creative.html">Start a new day with a simple breakfast</a>
                                            </h3>
                                            <span class="color-666 fsz-12px text-uppercase mt-15">receipes, breakfast</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== end tc-post-grid-style2 ====== -->

        <!-- ====== start Latest news ====== -->
        <section class="tc-latest-news-style1">
            <div class="container">
                <div class="section-content pt-50 pb-50 border-bottom border-1 brd-gray">
                    <div class="row gx-5">
                        <div class="col-lg-9">
                            <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">top favourite posts</p>
                            <div class="row gx-5">
                                <div class="col-lg-6 border-end brd-gray border-1">
                                    <div class="tc-post-grid-style3">
                                        <div class="item">
                                            <div class="img img-cover th-300">
                                                <img src="https://newzin-html.themescamp.com/assets/img/top_fav/1.png" alt="">
                                            </div>
                                            <div class="content pt-30">
                                                <h2 class="title ltspc--1 mb-20 fw-normal">
                                                    <a href="page-single-post-creative.html">
                                                        How to make a pizza with bacoon at home
                                                    </a>
                                                </h2>
                                                <div class="meta-bot mt-20 fsz-12px color-666 text-uppercase">
                                                    receipes, fast food
                                                </div>
                                                <div class="text mt-30">
                                                    As a rule of thumb, all spices and dried herbs should be stored in any cool, dark place. Is there a way to make a creamy, rich in taste [...]
                                                </div>
                                                <a href="home-food.html#" class="fsz-14px fw-bold color-000 mt-40">Continue</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 border-end brd-gray border-1">
                                    <div class="tc-post-list-style2">
                                        <div class="items">
                                            <div class="item">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h4 class="title">
                                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                                    How to make an Italian Spaghetti
                                                                </a>
                                                            </h4>
                                                            <div class="news-cat color-666 fsz-11px text-uppercase mt-20">Receipe, cuisine, video</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img th-80 img-cover">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/top_fav/2.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h4 class="title">
                                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                                    Do you know how to choose fresh salmon?
                                                                </a>
                                                            </h4>
                                                            <div class="news-cat color-666 fsz-11px text-uppercase mt-20">receipes, guide</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img th-80 img-cover">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/top_fav/3.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h4 class="title">
                                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                                    Failure is the successful
                                                                </a>
                                                            </h4>
                                                            <div class="news-cat color-666 fsz-11px text-uppercase mt-20">share</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img th-80 img-cover">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/top_fav/4.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h4 class="title">
                                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                                    Benefits from Raspberries
                                                                </a>
                                                            </h4>
                                                            <div class="news-cat color-666 fsz-11px text-uppercase mt-20">receipes, breakfast</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img th-80 img-cover">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/top_fav/5.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item border-0">
                                                <div class="row gx-3 align-items-center">
                                                    <div class="col-8">
                                                        <div class="content">
                                                            <h4 class="title">
                                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                                    How to choose organes super quality
                                                                </a>
                                                            </h4>
                                                            <div class="news-cat color-666 fsz-11px text-uppercase mt-20">receipes, breakfast</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="img th-80 img-cover">
                                                            <img src="https://newzin-html.themescamp.com/assets/img/top_fav/6.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="page-blog.html" class="fsz-12px text-uppercase mt-30">
                                                <span>See more</span>
                                                <i class="las la-angle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">stay connected</p>
                            <div class="tc-widget-social-style4">
                                <div class="item">
                                    <a href="home-food.html#" class="icon">
                                        <i class="la la-facebook-f facebook-icon"></i>
                                        <span>Facebook</span>
                                    </a>
                                    <div class="followers">
                                        <strong> <span class="counter">57</span>K </strong> <span>Followers</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <a href="home-food.html#" class="icon">
                                        <i class="la la-twitter twitter-icon"></i>
                                        <span>Twitter</span>
                                    </a>
                                    <div class="followers">
                                        <strong> <span class="counter">74</span>K </strong> <span>Followers</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <a href="home-food.html#" class="icon">
                                        <i class="la la-instagram instagram-icon"></i>
                                        <span>Instagram</span>
                                    </a>
                                    <div class="followers">
                                        <strong> <span class="counter">41</span>K </strong> <span>Followers</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <a href="home-food.html#" class="icon">
                                        <i class="la la-youtube youtube-icon"></i>
                                        <span>Youtube</span>
                                    </a>
                                    <div class="followers">
                                        <strong> <span class="counter">15</span>K </strong> <span>Followers</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-widget-tags-style3">
                                <p class="color-000 text-uppercase mb-20 ltspc-1 fw-bold">hot tags</p>
                                <div class="content">
                                    <a href="home-food.html#">Covid-19</a>
                                    <a href="home-food.html#">Bitcoin</a>
                                    <a href="home-food.html#">Wordpress</a>
                                    <a href="home-food.html#">Elon Musk</a>
                                    <a href="home-food.html#">Google Cloud</a>
                                    <a href="home-food.html#">Figma</a>
                                    <a href="home-food.html#">Crypto</a>
                                    <a href="home-food.html#">Marketplace</a>
                                    <a href="home-food.html#">Graphicriver</a>
                                    <a href="home-food.html#">Game Consoles</a>
                                    <a href="home-food.html#">Robotics</a>
                                    <a href="home-food.html#">Psd</a>
                                    <a href="home-food.html#">Hackers</a>
                                    <a href="home-food.html#">Foody</a>
                                    <a href="home-food.html#">Breakfast</a>
                                    <a href="home-food.html#">Dessert</a>
                                    <a href="home-food.html#">Soup</a>
                                    <a href="home-food.html#">Cuisine</a>
                                    <a href="home-food.html#">Vegan</a>
                                    <a href="home-food.html#">Restaurant</a>
                                    <a href="home-food.html#">Beef</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end Latest news ====== -->


        <!-- ====== start subscribe  ====== -->
        <section class="tc-subscribe-style4">
            <div class="container">
                <div class="content text-center pt-60 pb-60 border-1 border-bottom brd-gray">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <p class="color-000 text-uppercase mb-30 ltspc-1 fw-bold">subscribe our newsletter</p>
                            <div class="text fsz-14px color-666 mb-30">
                                Subscribe our newsletter to get the latest about receipes, deal & more
                            </div>
                            <form class="form">
                                <div class="form-group">
                                    <i class="la la-envelope icon"></i>
                                    <input type="text" class="form-control" placeholder="Email Address">
                                    <button type="submit">subscribe</button>
                                </div>
                            </form>
                            <p class="fsz-12px color-666 text-capitalize mt-20">By subscribing, you accepted our <a href="home-food.html#" class="color-000 text-decoration-underline">Policy</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end subscribe  ====== -->


        <!-- ====== start tabs ====== -->
        <section class="tc-posts-tabs-style4 pt-60 pb-60">
            <div class="container">
                <div class="tc-tabs-head">
                    <a href="home-food.html#0" class="active" data-filter="all">All</a>
                    <a href="home-food.html#0" data-filter=".latest">latest</a>
                    <a href="home-food.html#0" data-filter=".breakfast">breakfast</a>
                    <a href="home-food.html#0" data-filter=".dessert">dessert</a>
                    <a href="home-food.html#0" data-filter=".fastfood">fast food</a>
                    <a href="home-food.html#0" data-filter=".vegan">vegan</a>
                    <a href="home-food.html#0" data-filter=".soup">soup</a>
                    <a href="home-food.html#0" data-filter=".drink">drink</a>
                    <a href="home-food.html#0" data-filter=".asia">asia</a>
                    <a href="home-food.html#0" data-filter=".europe">europe</a>
                    <a href="home-food.html#0" data-filter=".usa">usa</a>
                    <a href="home-food.html#0" data-filter=".videos">videos</a>
                    <a href="home-food.html#0" data-filter=".guide">guide</a>
                </div>
                <div class="tc-tabs-body tc-post-grid-style4 mt-50">
                    <div class="row gx-0">

                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <div class="item mix latest soup asia">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/12.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/12.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Pumpkin soup for a warm winter</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">latest,</a>
                                        <a href="home-food.html#">soup,</a>
                                        <a href="home-food.html#">asia</a>
                                    </div>
                                    <div class="text">
                                        As a rule of thumb, all spices and dried herbs should be stored in any cool, dark place [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix dessert vegan">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/13.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/13.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">The wonderful effects of delicious dishes from coconut</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">dessert,</a>
                                        <a href="home-food.html#">vegan</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup without adding a cre no cheese, nor any dairy? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/14.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/14.png" alt="">
                                    <span class="tag-float">sponsored</span>
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Iveruli Wine - Taste for party pinic</a>
                                    </h4>
                                    <a href="home-food.html#" class="link fsz-12px mt-20 color-666">
                                        iveruliwine.com
                                        <i class="la la-external-link ms-2"></i>                                    </a>
                                </div>
                            </div>
                            <div class="item mix breakfast asia">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/15.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/15.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">The Japanese Art of Tea Ceremony</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">breakfast,</a>
                                        <a href="home-food.html#">asia</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <div class="item mix latest europe">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/16.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/16.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">25 Cafe Bar with street view in Boston, ready to chill?</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">latest,</a>
                                        <a href="home-food.html#">europe</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup without adding a cre no cheese, nor any dairy? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix breakfast europe">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/17.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/17.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">5 Benefits from Eggs</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">Europe,</a>
                                        <a href="home-food.html#">breakfast</a>
                                    </div>
                                    <div class="text">
                                        When I do, I usually turn to making the chocolate mounds. [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix dessert asia">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/18.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/18.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">How to make cheese ice cream with slices strawberries</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">dessert,</a>
                                        <a href="home-food.html#">asia</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup without adding a cre no cheese, nor any dairy? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix europe videos guide">
                                <a href="https://youtu.be/pGbIOC83-So?t=21" class="img img-cover" data-lity="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/19.png" alt="">
                                    <span class="video_icon icon-60">
                                        <i class="ion-play"></i>
                                    </span>
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-features.html">Sapo Cake Tutorial</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">europe,</a>
                                        <a href="home-food.html#">videos,</a>
                                        <a href="home-food.html#">guide</a>
                                    </div>
                                    <div class="text">
                                        When I do, I usually turn to making the chocolate mounds. [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <div class="item mix receipes breakfast">
                                <a href="https://youtu.be/pGbIOC83-So?t=21" class="img img-cover" data-lity="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/20.png" alt="">
                                    <span class="video_icon icon-60">
                                        <i class="ion-play"></i>
                                    </span>
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-features.html">How to make grilled cake with blueberries greasy</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">receipes,</a>
                                        <a href="home-food.html#">breakfast</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup without adding a cre no cheese, nor any dairy? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix fastfood drink">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/21.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/21.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Fastfood Party!</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">fastfood,</a>
                                        <a href="home-food.html#">drink</a>
                                    </div>
                                    <div class="text">
                                        When I do, I usually turn to making the chocolate mounds. [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix Europe breakfast">
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Sample Post with no images and three lines text content</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">Europe,</a>
                                        <a href="home-food.html#">breakfast</a>
                                    </div>
                                    <div class="text">
                                        When I do, I usually turn to making the chocolate mounds. [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix fastfood guide">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/22.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/22.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">How to choose fresh beef, you know?</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">guide</a>
                                    </div>
                                    <div class="text">
                                        When I do, I usually turn to making the chocolate mounds. [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="item mix latest videos">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/23.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/23.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">[Talk Show] Kitchen Corner #5, Masterchef Robert Ederson share about the taste</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">latest,</a>
                                        <a href="home-food.html#">video</a>
                                    </div>
                                    <div class="text">
                                        Interested in making homemade fluffy, yet stiff bagels? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix vegan asia">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/24.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/24.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Vegan Restaurant with Japan’s style</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">vegan,</a>
                                        <a href="home-food.html#">asia</a>
                                    </div>
                                    <div class="text">
                                        Interested in making homemade fluffy, yet stiff bagels? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                            <div class="item mix">
                                <a href="home-food.html#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/banner11.png" alt="">
                                </a>
                            </div>
                            <div class="item mix asia">
                                <a href="https://newzin-html.themescamp.com/assets/img/tabs/25.png" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/25.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="page-single-post-creative.html">Unpleasant taste but extremely wonderful benefits of durian fruit, did you know?</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="home-food.html#">asia</a>
                                    </div>
                                    <div class="text">
                                        Is there a way to make a creamy, rich in taste soup without adding a cre no cheese, nor any dairy? [...]
                                    </div>
                                    <a href="home-food.html#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="more mt-60">
                    <a href="page-blog.html">
                        Load more
                    </a>
                </div>
            </div>
        </section>
        <!-- ====== end tabs ====== -->

>>>>>>> dadf66f2 (có trang tag)

        <!-- ====== start modals ====== -->

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
<<<<<<< HEAD
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4.png" alt=""
                        class="dark-none">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4_lt.png" alt=""
                        class="light-none">
=======
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4.png" alt="" class="dark-none">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4_lt.png" alt="" class="light-none">
>>>>>>> dadf66f2 (có trang tag)
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i> </h6>
                <div class="text">
<<<<<<< HEAD
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae. Soluta
                    corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i>
                    </h6>
=======
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae. Soluta corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i> </h6>
>>>>>>> dadf66f2 (có trang tag)
                    <a href="home-food.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="https://newzin-html.themescamp.com/assets/img/bussines/1.png" alt="">
                        </div>
                        <div class="info">
                            <h5>bussines</h5>
                            <span class="num">12</span>
                        </div>
                    </a>
                    <a href="home-food.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="https://newzin-html.themescamp.com/assets/img/trend/3.png" alt="">
                        </div>
                        <div class="info">
                            <h5>technology</h5>
                            <span class="num">14</span>
                        </div>
                    </a>
                    <a href="home-food.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="https://newzin-html.themescamp.com/assets/img/must_read/3.png" alt="">
                        </div>
                        <div class="info">
                            <h5>culture</h5>
                            <span class="num">20</span>
                        </div>
                    </a>
                    <a href="home-food.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="https://newzin-html.themescamp.com/assets/img/videos/1.png" alt="">
                        </div>
                        <div class="info">
                            <h5>videos</h5>
                            <span class="num">14</span>
                        </div>
                    </a>
                </div>
                <div class="sidebar-contact-info mt-50">
<<<<<<< HEAD
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i
                            class="la la-angle-right ms-1"></i> </h6>
=======
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i class="la la-angle-right ms-1"></i> </h6>
>>>>>>> dadf66f2 (có trang tag)
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="home-food.html#">streat name 12, hollywood City, USA</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="home-food.html#">Newzin@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="home-food.html#">+12 123 456 789</a>
                        </li>
                    </ul>
                    <div class="social-links">
                        <a href="home-food.html#">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="home-food.html#">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="home-food.html#">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="home-food.html#">
                            <i class="la la-youtube"></i>
                        </a>
                        <a href="home-food.html#">
                            <i class="la la-spotify"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== end modals ====== -->

    </main>
<<<<<<< HEAD
@endsection
=======

@endsection
>>>>>>> dadf66f2 (có trang tag)

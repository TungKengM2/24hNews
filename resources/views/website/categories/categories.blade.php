@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start category header ====== -->
        <section class="tc-category-header py-4 bg-light border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="mb-2">{{ $category->name }}</h1>

                        <p class="text-muted mb-0">
                            {{ $category->description ?? ($category->parent->description ?? 'Khám phá các bài viết trong danh mục này') }}
                        </p>
                    </div>

                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="#">Danh mục</a></li>

                                @if ($category->parent)
                                    <!-- Nếu là danh mục con thì hiển thị cate cha -->
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('client.category.show', $category->parent->slug) }}">
                                            {{ $category->parent->name }}
                                        </a>
                                    </li>
                                    <!-- Sau đó hiển thị cate con (hiện tại) -->
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $category->name }}
                                    </li>
                                @else
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $category->name }}
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end category header ====== -->

        {{-- <!-- ====== start articles by views ====== -->
        <section class="tc-articles-by-views py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h4 class="fw-bold text-uppercase mb-4 border-start border-primary border-4 ps-3">Bài Viết Nổi Bật
                        </h4>
                        <div class="tc-post-grid-default">
                            <div class="tc-slider-style1">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @if (isset($articlesViews) && $articlesViews->count() > 0)
                                            @foreach ($articlesViews as $articleviews)
                                                <div class="swiper-slide">
                                                    <div class="item d-block">
                                                        <div class="row gx-4 align-items-center">
                                                            <div class="col-6">
                                                                <a href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}"
                                                                    class="img img-cover rounded overflow-hidden">
                                                                    <img src="{{ asset('storage/' . $articleviews->thumbnail_url) }}"
                                                                        alt="{{ $articleviews->title }}" class="w-100"
                                                                        style="height: calc(50vh - 80px); object-fit: cover;">
                                                                </a>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="content">
                                                                    <h5 class="title mb-3">
                                                                        <a href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}"
                                                                            class="text-dark hover-primary text-decoration-none">
                                                                            {{ $articleviews->title }}
                                                                        </a>
                                                                    </h5>
                                                                    <div
                                                                        class="meta-bot mt-3 text-muted d-flex align-items-center">
                                                                        <i class="la la-clock me-1"></i>
                                                                        <span>{{ $articleviews->created_at->diffForHumans() }}</span>
                                                                        <span class="mx-2">|</span>
                                                                        <i class="la la-eye me-1"></i>
                                                                        <span>{{ $articleviews->views ?? 0 }} lượt
                                                                            xem</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="swiper-slide">
                                                <div class="alert alert-info m-0">Không có bài viết nào được hiển thị.</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- arrows -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end articles by views ====== --> --}}

        <!-- ====== start breaking news ====== -->
        <section class="tc-breaking-news-style5 pt-50 pb-50">
            <div class="container">
                <div class="content">
                    <div class="breaking-title">
                        <strong> <i class="ion-flash me-2"></i> Tin Mới</strong>
                    </div>
                    <div class="breaking-body">
                        <div class="tc-breaking-news-slider5">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($breakingNews as $article)
                                        <div class="swiper-slide">
                                            <div class="item">
                                                <a href="{{ route('articles.article', ['slug' => $article->slug]) }}"
                                                    class="hover-underline">
                                                    {{ $article->title }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- arrows -->
                        <div class="arrows">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end breaking news ====== -->



        <!-- ====== start trends news ====== -->
        <section class="tc-post-grid-style5 overflow-hidden">
            <div class="container">
                <div class="content pb-50 border-1 border-bottom brd-gray">
                    <div class="row gx-5">
                        <!-- Hiển thị highlightedArticle -->
                        @if ($highlightedArticle)
                            <div class="col-lg-6 border-1 border-end brd-gray mb-5 mb-lg-0">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">
                                            <a href="#">
                                                {{ $highlightedArticle->category->name }}
                                            </a>
                                        </div>
                                        <h2 class="title mb-20">
                                            <a
                                                href="{{ route('articles.article', ['slug' => $highlightedArticle->slug]) }}">
                                                {{ $highlightedArticle->title }}
                                            </a>
                                        </h2>
                                        <div class="text color-666 mb-20">
                                            {{ Str::limit($highlightedArticle->preview_content ?? strip_tags($highlightedArticle->content), 180) }}
                                        </div>
                                        <div class="meta-bot fsz-13px color-666 mb-40">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <i class="la la-calendar me-2"></i>
                                                    {{ time_ago($highlightedArticle->created_at) }}
                                                </li>
                                                <li class="author me-5">
                                                    <i class="la la-user me-2"></i> by <span class="color-000">
                                                        {{ $highlightedArticle->author->name ?? 'Admin' }}
                                                    </span>
                                                </li>
                                                <li class="comment">
                                                    <i class="la la-comment me-2"></i>
                                                    {{ $highlightedArticle->comments_count }} Bình luận
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', ['slug' => $highlightedArticle->slug]) }}"
                                        class="img img-cover d-block th-380">
                                        <img src="{{ asset('storage/' . $highlightedArticle->thumbnail_url) }}"
                                            alt="{{ $highlightedArticle->title }}">
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Hiển thị thông báo nếu không có bài viết cho highlightedArticle -->
                            <div class="col-lg-6">
                                <p>Chưa có bài viết nổi bật nào.</p>
                            </div>
                        @endif

                        <!-- Hiển thị secondaryArticle -->
                        @if ($secondaryArticle)
                            <div class="col-lg-6">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">
                                            <a href="">
                                                {{ $secondaryArticle->category->name }}
                                            </a>
                                        </div>
                                        <h2 class="title mb-20">
                                            <a href="{{ route('articles.article', ['slug' => $secondaryArticle->slug]) }}">
                                                {{ $secondaryArticle->title }}
                                            </a>
                                        </h2>
                                        <div class="text color-666 mb-20">
                                            {{ Str::limit($secondaryArticle->preview_content ?? strip_tags($secondaryArticle->content), 180) }}
                                        </div>
                                        <div class="meta-bot fsz-13px color-666 mb-40">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <i class="la la-calendar me-2"></i>
                                                    {{ time_ago($secondaryArticle->created_at) }}
                                                </li>
                                                <li class="author me-5">
                                                    <i class="la la-user me-2"></i> by <span class="color-000">
                                                        {{ $secondaryArticle->author->name ?? 'Admin' }}
                                                    </span>
                                                </li>
                                                <li class="comment">
                                                    <i class="la la-comment me-2"></i>
                                                    {{ $secondaryArticle->comments_count }} Bình luận
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', ['slug' => $secondaryArticle->slug]) }}"
                                        class="img img-cover d-block th-380">
                                        <img src="{{ asset('storage/' . $secondaryArticle->thumbnail_url) }}"
                                            alt="{{ $secondaryArticle->title }}">
                                    </a>
                                </div>
                            </div>
                        @else
                            <!-- Hiển thị thông báo nếu không có bài viết cho secondaryArticle -->
                            <div class="col-lg-6">
                                <p>Chưa có bài viết phụ nào.</p>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="content pb-50 pt-50 brd-gray border-bottom">
                    <div class="row gx-5">
                        @foreach ($nebulaNuggets as $nugget)
                            <div class="col-lg-4 border-1 {{ !$loop->last ? 'border-end' : '' }} brd-gray mb-5 mb-lg-0">
                                <div class="item">
                                    <div class="content">
                                        <div class="tags mb-20">
                                            @if ($nugget->is_live ?? false)
                                                <a href="#" class="live">
                                                    <span class="icon-6 bg-gray1 rounded-circle"></span>
                                                    live
                                                </a>
                                            @endif
                                            @if ($nugget->category)
                                                <a href="">
                                                    {{ $nugget->category->name }}
                                                </a>
                                            @endif
                                        </div>
                                        <h3 class="title mb-20">
                                            <a href="{{ route('articles.article', $nugget->slug) }}">
                                                {{ $nugget->title }}
                                            </a>
                                        </h3>
                                        <div class="meta-bot fsz-13px color-666 mb-30">
                                            <ul class="d-flex">
                                                <li class="date me-5">
                                                    <a href="#">
                                                        <i class="la la-calendar me-2"></i>
                                                        {{ $nugget->created_at->format('M d, Y') }}
                                                    </a>
                                                </li>
                                                <li class="comment">
                                                    <a href="#">
                                                        <i class="la la-comment me-2"></i>
                                                        {{ $nugget->comments_count }} Bình luận
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{ route('articles.article', $nugget->slug) }}"
                                        class="img img-cover d-block th-250">
                                        <img src="{{ asset('storage/' . $nugget->thumbnail_url) }}"
                                            alt="{{ $nugget->title }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



                <div class="content pb-50 pt-50">
                    <section class="pb-5">
                        <div class="container">
                            <div class="row">
                                <!-- Main content -->
                                <div class="col-lg-8">
                                    <div class="features-content mb-5">
                                        <div class="tc-latest-news-style5">
                                            <a href="page-blog.html" class="color-000 text-uppercase mb-30">Bài Viết Nổi Bật<i
                                                    class="la la-angle-right ms-1"></i></a>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <div class="tc-post-overlay-style5 mb-5 mb-lg-0">
                                                        <div class="tc-post-overlay-slider5">
                                                            <div class="swiper-container">
                                                                <div class="swiper-wrapper">
                                                                    @foreach ($topMainArticle as $topMainArticles)
                                                                        <div class="swiper-slide">
                                                                            <div class="item">
                                                                                <div class="img th-525 img-cover">
                                                                                    <img src="{{ asset('storage/' . $topMainArticles->thumbnail_url) }}"
                                                                                        alt="{{ $topMainArticles->title }}">
                                                                                    <div class="tags">
                                                                                        <a
                                                                                            href="{{ route('articles.article', $topMainArticles->slug) }}">
                                                                                            {{ $topMainArticles->title }}
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="info">
                                                                                    <h2 class="title mb-20">
                                                                                        <a
                                                                                            href="{{ route('articles.article', $topMainArticles->slug) }}">
                                                                                            {{ $topMainArticles->title }}
                                                                                        </a>
                                                                                    </h2>
                                                                                    <div class="text mb-40 fsz-16px">
                                                                                        {{ Str::limit(strip_tags($topMainArticles->description), 100) }}
                                                                                    </div>
                                                                                    <div
                                                                                        class="meta-bot fsz-13px text-white">
                                                                                        <ul class="d-flex">
                                                                                            <li class="date me-4">
                                                                                                <i
                                                                                                    class="la la-calendar me-2"></i>
                                                                                                {{ $topMainArticles->created_at->format('M d, Y') }}
                                                                                            </li>
                                                                                            <li class="author me-4">
                                                                                                <i
                                                                                                    class="la la-user me-2"></i>
                                                                                                {{ $topMainArticles->author->name ?? 'Admin' }}
                                                                                            </li>
                                                                                            <li class="comment">
                                                                                                <i
                                                                                                    class="la la-views me-2"></i>
                                                                                                {{ $topMainArticles->views ?? 0 }}
                                                                                                lượt xem
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                            <!-- arrows -->
                                                            <div class="arrows">
                                                                <div class="swiper-button-next"></div>
                                                                <div class="swiper-button-prev"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="tc-post-list-style5">
                                                        <div class="items">
                                                            @foreach ($topSideArticles as $article)
                                                                <div class="item {{ $loop->first ? 'pt-0' : '' }}">
                                                                    <div class="row gx-0">
                                                                        <div class="col-8 pe-10">
                                                                            <div class="content">
                                                                                <div class="tags mb-15">
                                                                                    <a
                                                                                        href="{{ route('categories.show', $article->category->slug ?? '#') }}">
                                                                                        {{ $article->category->name ?? 'Danh mục' }}
                                                                                    </a>
                                                                                </div>
                                                                                <h5 class="title">
                                                                                    <a href="{{ route('articles.article', $article->slug) }}"
                                                                                        class="hover-underline">
                                                                                        {{ $article->title }}
                                                                                    </a>
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="img th-80 img-cover">
                                                                                <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                                    alt="{{ $article->title }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <a href="{{ route('articles.index') }}"
                                                                class="fsz-13px text-capitalize color-666 mt-30">
                                                                <span>Xem tất cả bài viết</span>
                                                                <i class="las la-angle-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <br>
                                        <hr><br>

                                        <!-- Related articles -->
                                        <div class="related-articles">
                                            <div class="row">
                                                @if (isset($relatedArticles) && $relatedArticles->count() > 0)
                                                    @foreach ($relatedArticles as $article)
                                                        <div class="col-md-6 mb-4">
                                                            <div class="card h-100 border-0 shadow-sm">
                                                                <div class="item">
                                                                    
                                                                        <div class="tags mb-20">
                                                                            <a href="">
                                                                                @if ($secondaryArticle)
                                                                                    {{ $secondaryArticle->category->name }}
                                                                                @endif

                                                                            </a>
                                                                        </div>
                                                                    
                                                                </div>

                                                                <div class="position-relative">
                                                                   
                                                                    <a
                                                                        href="{{ route('articles.article', ['slug' => $article->slug]) }}">
                                                                        <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                            alt="{{ $article->title }}"
                                                                            class="card-img-top"
                                                                            style="height: 200px; object-fit: cover;">
                                                                    </a>

                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title mb-3">
                                                                        <a href="{{ route('articles.article', ['slug' => $article->slug]) }}"
                                                                            class="text-decoration-none text-dark hover-primary">
                                                                            {{ $article->title }}
                                                                        </a>
                                                                    </h5>
                                                                    <p class="card-text text-muted">
                                                                        {{ Str::limit(trim(strip_tags(html_entity_decode($article->content))), 200, '...') }}
                                                                    </p>

                                                                </div>
                                                                <div class="card-footer bg-white border-0">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center text-muted small">
                                                                        <span><i class="la la-calendar me-1"></i>
                                                                            {{ $article->created_at->format('d/m/Y') }}</span>
                                                                        <span><i class="la la-eye me-1"></i>
                                                                            {{ $article->views ?? 0 }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-12">
                                                        <div class="alert alert-info">Không có bài viết liên quan.</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sidebar -->
                                <div class="col-lg-4">
                                    <div class="sidebar">
                                        <!-- Popular tags -->
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-header bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Thẻ Phổ Biến</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap gap-2">

                                                    @foreach ($tags as $tag)
                                                        <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}"
                                                            class="btn btn-sm btn-outline-secondary">{{ $tag->name }}
                                                            ({{ $tag->published_articles_count }})
                                                        </a>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Categories list -->
                                        <div class="card border-0 shadow-sm mb-4">
                                            <div class="card-header bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Danh Mục Hàng Đầu</h5>
                                            </div>
                                            <div class="list-group list-group-flush">
                                                @if (isset($categories) && $categories->count() > 0)
                                                    @foreach ($categories as $cat)
                                                        <a href="{{ route('client.category.show', $cat->slug) }}"
                                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i class="la la-folder me-2 text-primary"></i>
                                                                <span>{{ $cat->name }}</span>
                                                            </div>
                                                            <span class="badge bg-light text-dark">
                                                                {{ $cat->articles_count ?? 0 }} bài viết
                                                            </span>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <div class="list-group-item">Không có danh mục nào.</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Recent articles -->
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-header bg-white border-bottom border-primary border-3">
                                                <h5 class="mb-0 fw-bold text-uppercase">Bài Viết Đã Xem </h5>
                                            </div>
                                            <div class="list-group list-group-flush">
                                                @if (isset($recentArticles) && $recentArticles->count() > 0)
                                                    @foreach ($recentArticles as $recentArticle)
                                                        <a href="{{ route('articles.article', $recentArticle->slug) }}"
                                                            class="list-group-item list-group-item-action d-flex align-items-center p-3">
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    {{ Str::limit($recentArticle->title, 100) }}</h6>
                                                                <small class="text-muted">
                                                                    <i class="la la-calendar me-1"></i>
                                                                    {{ $recentArticle->created_at->format('d/m/Y') }}
                                                                </small>
                                                            </div>
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <div class="list-group-item">Không có bài viết gần đây.</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- ====== end main content ====== -->
                </div>
            </div>
        </section>
        <!-- ====== end trends news ====== -->




    </main>
@endsection

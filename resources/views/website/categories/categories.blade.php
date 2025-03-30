@extends('website.layouts.master')

@section('content')
    <main>
        <section class="tc-breaking-news-style6 pb-50 mt-4 mt-lg-0" style="padding-top: 50px">
            <div class="container">
                <div class="content">
                    <div class="breaking-title">
                        <strong> <i class="ion-flash me-2"></i> Tin mới nhất</strong>
                    </div>
                    <div class="breaking-body">
                        <div class="tc-breaking-news-slider6">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="item ">
                                            <a href="page-single-post-creative.html" class="hover-underline">Những điểm
                                                chính đáng chú ý nhất từ phiên điều trần đầu tiên
                                                ngày 6 tháng 1 </a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="item ">
                                            <a href="page-single-post-creative.html" class="hover-underline">Những điểm
                                                chính đáng chú ý nhất từ phiên điều trần đầu tiên
                                                ngày 6 tháng 1 </a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide">
                                            <div class="item ">
                                                <a href="page-single-post-creative.html" class="hover-underline">Những điểm
                                                    chính đáng chú ý nhất từ phiên điều trần đầu tiên
                                                    ngày 6 tháng 1 </a>
                                            </div>
                                        </div>
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
        <section class="tc-trends-news-style6">
            <div class="container">
                <div class="content pb-50">
                    <strong class="color-000 text-uppercase mb-30 d-block pt-15 border-2 border-top border-dark">
                        Bài viết thịnh hành
                    </strong>
                    <div class="tc-post-grid-style6">
                        <div class="tc-trends-news-slider6 tc-slider-style1">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @if ($articlesViews->count() > 0)
                                        @foreach ($articlesViews as $index => $articleviews)
                                            <div class="swiper-slide">
                                                <div class="item">
                                                    <div class="row gx-4 align-items-center">
                                                        <div class="col-2">
                                                            <h4 class="number">{{ $index + 1 }}</h4>
                                                        </div>
                                                        <div class="col-4">
                                                            <a
                                                                href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}">
                                                                <img src="{{ asset('storage/' . $articleviews->thumbnail_url) }}"
                                                                    alt="{{ $articleviews->title }}">
                                                            </a>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="content">
                                                                <h5 class="title">
                                                                    <a
                                                                        href="{{ Auth::check() ? route('articles.article', ['slug' => $articleviews->slug]) : url('/login-user') }}">
                                                                        {{ $articleviews->title }}
                                                                    </a>
                                                                </h5>
                                                                <div
                                                                    class="meta-bot mt-10 color-666 fsz-11px text-uppercase">
                                                                    <ul>
                                                                        <li class="date"><i class="la la-clock"></i>
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
                                    @else
                                        <p class="text-center text-muted">Không có bài viết nào được hiển thị.</p>
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
                                                    <a href="home-politic.html#">Được tài trợ</a>
                                                </div>
                                                <h4 class="title fw-bold">
                                                    <a href="page-single-post-creative.html" class="hover-underline">
                                                        Tivi LG Oled 4K Ultra HD, Giảm giá 10% trên Amazon
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
                                <p class="fw-bold text-uppercase fsz-14px">Bài viết nổi bật</p>
                                <a href="page-blog.html" class="fsz-13px">Xem thêm <i
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
                                                class="news-cat fsz-13px text-uppercase mb-2 fw-bold color-main">Kinh
                                                doanh</a>
                                            <h5 class="title">
                                                <a href="page-single-post-creative.html" class="hover-underline">
                                                    Tập 15: Ngày của Mike Pence tại Ủy ban ngày 6 tháng 1
                                                </a>
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




        <!-- ====== start columnist ====== -->
        <section class="tc-columnist-style1 pt-60 pb-60">
            <div class="container">
                <div class="content">
                    <p class="fw-bold text-uppercase fsz-14px mb-30 pt-15 border-2 border-top border-dark">Các tác giả nổi
                        bật nhất </p>
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
                                            <small class="fsz-13px color-999">Danh Mục Chuyên Môn</small>
                                            <p class="fsz-13px text-uppercase">Giải Trí , Thể Thao , Kinh Doanh </p>
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
                                            <small class="fsz-13px color-999">Danh Mục Chuyên Môn</small>
                                            <p class="fsz-13px text-uppercase">Giải Trí , Thể Thao  </p>
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
                                            <small class="fsz-13px color-999">Danh Mục Chuyên Môn</small>
                                            <p class="fsz-13px text-uppercase">Giải Trí , Thể Thao , Kinh Doanh  </p>
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
                                    <p class="fw-bold text-uppercase fsz-14px mb-30"> Phải Đọc</p>
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
                                                            class="news-cat color-main fsz-13px text-uppercase mb-15 fw-bold">Nhà Trắng</a>
                                                        <h2 class="title mb-20">
                                                            <a href="page-single-post-creative.html">
                                                                Manoah áp đảo, tiến gần đến lịch sử của Blue Jays
                                                            </a>
                                                        </h2>
                                                        <div class="text color-666">
                                                            Công ty truyền thông xã hội đang trong quá trình đàm phán để bán lại cho
                                                            Elon, một bước ngoặt đầy kịch tính chỉ sau 11 ngày kể từ khi [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 mt-40">
                                                            <a href="home-politic.html#"
                                                                class="fsz-11px color-000 text-uppercase"> 2 ngày trước <span
                                                                    class="color-999">bởi</span> Moreno </a>
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
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Pháp luật</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    Bài viết tài trợ với tiêu đề hai dòng
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
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Quốc hội</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    "Jupiter của Pháp" có thể sắp khám phá văn hóa thỏa hiệp
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
                                                                class="news-cat color-main fsz-13px text-capitalize mb-10 fw-bold">Bầu cử</a>
                                                            <h4 class="title ltspc--1">
                                                                <a href="page-single-post-creative.html"
                                                                    class="hover-underline">
                                                                    "Một thế giới không có rủi ro"
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
                                    pháp luật
                                </p>
                                <div class="pb-30 border-1 border-bottom brd-gray">
                                    <div class="row">
                                        <div class="col-lg-8 border-1 border-end brd-gray">
                                            <div class="tc-post-overlay-default">
                                                <div class="img th-400 img-cover">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/64.png" alt="">
                                                    <div class="tags">
                                                        <a href="home-politic.html#" class="text-capitalize color-main fw-bold">pháp luật</a>
                                                    </div>
                                                </div>
                                                <div class="content p-40">
                                                    <h3 class="title mb-30">
                                                        <a href="page-single-post-creative.html">Thỏa thuận về phá thai của Roberts có thể trông như thế nào</a>
                                                    </h3>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#">25 phút trước <span class="color-999">bởi</span> Cornor Bradley</a>
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
                                                                <a href="page-single-post-creative.html">Thị trường tài chính toàn cầu sau COVID 2022</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">15 giờ trước <span class="color-999">bởi</span> Luis Diaz</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">Thị trường chứng khoán Mỹ hôm nay</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">1 ngày trước <span class="color-999">bởi</span> Admin</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">Bơi lội thế giới cấm vận động viên chuyển giới tham gia nội dung nữ</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">15 giờ trước <span class="color-999">bởi</span> Luis Diaz</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item pb-20 border-0">
                                                        <div class="content">
                                                            <h5 class="title">
                                                                <a href="page-single-post-creative.html">Những câu chuyện thành công của Starbucks</a>
                                                            </h5>
                                                            <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                <a href="home-politic.html#">2 ngày trước <span class="color-999">bởi</span> Cornor Bradley</a>
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
                                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/35.png" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="content">
                                                                <h5 class="title">
                                                                    <a href="page-single-post-creative.html">Cưỡi ngựa, <br> Một sở thích đẳng cấp doanh nhân</a>
                                                                </h5>
                                                                <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                    <a href="home-politic.html#">1 ngày trước <span class="color-999">bởi</span> Admin</a>
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
                                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/40.png" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="content">
                                                                <h5 class="title">
                                                                    <a href="page-single-post-creative.html">Báo cáo tài chính của Ngân hàng ABC có dấu hiệu đáng ngờ</a>
                                                                </h5>
                                                                <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                                    <a href="home-politic.html#">15 giờ trước <span class="color-999">bởi</span> Luis Diaz</a>
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
                                    pháp luật
                                </p>
                                <div class="tc-post-grid-default pb-30 border-2 border-bottom brd-gray">
                                    <div class="row gx-5">
                                        <div class="col-lg-6 border-1 border-end brd-gray">
                                            <div class="item">
                                                <a href="page-single-post-creative.html" class="img img-cover th-280 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/65.png" alt="">
                                                </a>
                                                <div class="content pt-30">
                                                    <h3 class="title ltspc--1 mb-20">
                                                        <a href="page-single-post-creative.html">
                                                            DeSantis thu hút khoản tiền khổng lồ từ các nhà tài trợ của Trump
                                                        </a>
                                                    </h3>
                                                    <div class="text color-666">
                                                        Công ty mạng xã hội đang thảo luận về việc bán mình cho Elon, một bước ngoặt đầy kịch tính chỉ sau 11 ngày [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-40">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            2 ngày trước <span class="color-999">bởi</span> Moreno
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="item">
                                                <a href="page-single-post-creative.html" class="img img-cover th-280 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/66.png" alt="">
                                                </a>
                                                <div class="content pt-30">
                                                    <h3 class="title ltspc--1 mb-20">
                                                        <a href="page-single-post-creative.html">
                                                            Deese nói rằng chuyến đi của Biden đến Ả Rập Xê Út không phải vì tuyệt vọng
                                                        </a>
                                                    </h3>
                                                    <div class="text color-666">
                                                        Công ty mạng xã hội đang thảo luận về việc bán mình cho Elon, một bước ngoặt đầy kịch tính chỉ sau 11 ngày [...]
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-40">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            2 ngày trước <span class="color-999">bởi</span> Admin
                                                        </a>
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
                                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/50.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="content mt-4 mt-lg-0">
                                                        <h4 class="title">
                                                            <a href="page-single-post-creative.html">FBI, Cảnh sát điều tra những bức thư ‘đáng lo ngại’ tại các nhà thờ ở Tennessee</a>
                                                        </h4>
                                                        <div class="text color-666 mt-20">
                                                            Báo cáo của "Do No Harm" kết luận rằng sự hội nhập ngày càng tăng của chính trị sắc tộc vào trường y UCSD là một trường hợp [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                            <a href="home-politic.html#">1 ngày trước <span class="color-999">bởi</span> Thiago</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item border-0 pb-0">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="img th-190 img-cover">
                                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/67.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="content mt-4 mt-lg-0">
                                                        <h4 class="title">
                                                            <a href="page-single-post-creative.html">Chủ tịch Liên minh Châu Phi kêu gọi EU hỗ trợ thanh toán thực phẩm cho Nga</a>
                                                        </h4>
                                                        <div class="text color-666 mt-20">
                                                            Báo cáo của "Do No Harm" kết luận rằng sự hội nhập ngày càng tăng của chính trị sắc tộc vào trường y UCSD là một trường hợp [...]
                                                        </div>
                                                        <div class="meta-bot lh-1 fsz-11px color-000 mt-15">
                                                            <a href="home-politic.html#">1 ngày trước <span class="color-999">bởi</span> Thiago</a>
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
                                        thẻ phổ biến
                                    </p>
                                    <div class="tags-content">
                                        <a href="home-politic.html#">Covid-19</a>
                                        <a href="home-politic.html#">Bitcoin</a>
                                        <a href="home-politic.html#">WordPress</a>
                                        <a href="home-politic.html#">Elon Musk</a>
                                        <a href="home-politic.html#">Google Cloud</a>
                                        <a href="home-politic.html#">Figma</a>
                                        <a href="home-politic.html#">Tiền điện tử</a>
                                        <a href="home-politic.html#">Chợ trực tuyến</a>
                                        <a href="home-politic.html#">Graphicriver</a>
                                        <a href="home-politic.html#">Máy chơi game</a>
                                        <a href="home-politic.html#">Robot</a>
                                        <a href="home-politic.html#">Psd</a>
                                        <a href="home-politic.html#">Hacker</a>
                                        <a href="home-politic.html#">Ẩm thực</a>
                                        <a href="home-politic.html#">Bữa sáng</a>
                                        <a href="home-politic.html#">Tráng miệng</a>
                                        <a href="home-politic.html#">Súp</a>
                                        <a href="home-politic.html#">Nấu ăn</a>
                                        <a href="home-politic.html#">Ăn chay</a>
                                        <a href="home-politic.html#">Nhà hàng</a>
                                        <a href="home-politic.html#">Thịt bò</a>
                                    </div>
                                </div>

                                <!-- widget-videos -->
                                <div class="tc-widget-videos-style6">
                                    <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                        video nổi bật
                                    </p>
                                    <div class="videos-content">
                                        <div class="main-card">
                                            <div class="img th-300 img-cover">
                                                <img src="https://newzin-html.themescamp.com/assets/img/latest/68.png" alt="">
                                                <div class="tags">
                                                    <a href="home-politic.html#">Chính trị</a>
                                                </div>
                                            </div>
                                            <div class="info">
                                                <a href="https://youtu.be/pGbIOC83-So?t=21" data-lity="" class="video_icon icon-60 mb-30">
                                                    <i class="ion-play fs-5"></i>
                                                </a>
                                                <h5 class="title mb-15">
                                                    <a href="page-single-post-features.html">
                                                        Tiêu đề lớn cho bài viết nổi bật với tiêu đề kép
                                                    </a>
                                                </h5>
                                                <div class="meta-bot">
                                                    <a href="home-politic.html#" class="fsz-11px text-uppercase">
                                                        2 ngày trước <span class="color-999">bởi</span> Moreno
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sub-cards">
                                            <a href="page-single-post-creative.html" class="item">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/69.png" alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        Điều cấm kỵ về tuổi tác của Biden được gỡ bỏ
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html" class="item">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/70.png" alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        Năm nay, Florida không còn là bang dao động
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-single-post-creative.html" class="item border-0">
                                                <div class="img">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/71.png" alt="">
                                                </div>
                                                <div class="info">
                                                    <h6 class="title">
                                                        Tại sao ngân hàng trung ương lại tăng lãi suất?
                                                    </h6>
                                                </div>
                                            </a>
                                            <a href="page-blog.html" class="fsz-13px mt-15">
                                                <span>Xem thêm</span>
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
                                        danh mục hàng đầu
                                    </p>
                                    <div class="categories-content">
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-fist-raised"></i>
                                                </span>
                                                <strong class="title">Chính trị</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">24 bài viết</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-landmark"></i>
                                                </span>
                                                <strong class="title">Nhà Trắng</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">15 bài viết</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-balance-scale"></i>
                                                </span>
                                                <strong class="title">Pháp lý</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">17 bài viết</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-globe"></i>
                                                </span>
                                                <strong class="title">Thế giới</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">9 bài viết</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-suitcase"></i>
                                                </span>
                                                <strong class="title">Kinh doanh</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">16 bài viết</small>
                                            </div>
                                        </a>
                                        <a href="page-blog.html" class="item">
                                            <div class="icon-title">
                                                <span class="icon">
                                                    <i class="la la-chart-pie"></i>
                                                </span>
                                                <strong class="title">Kinh tế</strong>
                                            </div>
                                            <div class="numbs">
                                                <small class="fsz-13px color-666">2 bài viết</small>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="page-blog.html" class="fsz-13px mt-15">
                                        <span>Xem thêm</span>
                                        <i class="las la-angle-right"></i>
                                    </a>
                                </div>

                              <!-- widget-survey -->
<div class="tc-widget-survey-style6 mt-60">
    <p class="text-uppercase ltspc-1 mb-20">Khảo sát nhanh</p>
    <div class="title fsz-16px fw-bold mb-15">
        Trải nghiệm của bạn trên Newzin thế nào?
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="survey" id="survey1">
        <label class="form-check-label fsz-13px color-666 lh-5" for="survey1">
            Tuyệt vời, tôi rất hài lòng!
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="survey" id="survey2">
        <label class="form-check-label fsz-13px color-666 lh-5" for="survey2">
            Bình thường
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="survey" id="survey3">
        <label class="form-check-label fsz-13px color-666 lh-5" for="survey3">
            Tệ! Cần cải thiện thêm
        </label>
    </div>
    <div class="btns">
        <button class="butn btn_color"> Gửi </button>
        <button class="butn"> Kết quả </button>
    </div>
    <p class="fsz-12px color-666"> <span class="fw-bold color-000">24,562</span> người đã tham gia</p>
</div>

<!-- widget-survey -->
<div class="tc-widget-webStories-style5 mt-60">
    <p class="fw-bold text-uppercase fsz-14px mb-15 border-2 border-top border-dark pt-15">
        Câu chuyện trên Google Web
    </p>
    <div class="web-content">
        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card pt-0" data-fancybox="">
            <div class="img img-cover">
                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/1.png" alt="">
            </div>
            <div class="cont">
                <h6>Câu chuyện về Kayak</h6>
            </div>
        </a>
        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card seen" data-fancybox="">
            <div class="img img-cover">
                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/2.png" alt="">
            </div>
            <div class="cont">
                <h6>6 mẹo thành công cho lập trình viên</h6>
            </div>
        </a>
        <a href="https://youtu.be/pGbIOC83-So?t=21" class="story-card pb-0 border-0" data-fancybox="">
            <div class="img img-cover">
                <img src="https://newzin-html.themescamp.com/assets/img/google-stories/3.png" alt="">
            </div>
            <div class="cont">
                <h6>Tay cầm PS</h6>
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
                                    Quốc hội
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                    Bầu cử
                                </p>
                            </div>
                            <div class="col-lg-4">
                                <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15">
                                    Kinh doanh
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-4 border-1 border-end brd-gray">
                            <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                Quốc hội
                            </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/72.png" alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                Mitch Daniels cân nhắc trở lại chính trị
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            Công ty truyền thông xã hội đang thảo luận về việc bán cho Elon, một bước ngoặt đáng chú ý chỉ sau 11 ngày [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                2 ngày trước <span class="color-999">bởi</span> Moreno
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/73.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Thượng nghị sĩ bổ sung 45 tỷ USD vào ngân sách quốc phòng của Biden</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            2 ngày trước <span class="color-999">bởi</span> Moreno
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/74.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Thượng viện thông qua dự luật chăm sóc cựu chiến binh bị ảnh hưởng bởi hố đốt chất độc</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            1 ngày trước <span class="color-999">bởi</span> Admin
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 border-1 border-end brd-gray mt-5 mt-lg-0">
                            <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                Bầu cử
                            </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/75.png" alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                Nhóm tái phân chia khu vực của Đảng Dân chủ đặt mục tiêu rộng lớn cho cuộc bầu cử 2022
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            Công ty truyền thông xã hội đang thảo luận về việc bán cho Elon, một bước ngoặt đáng chú ý chỉ sau 11 ngày [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                2 ngày trước <span class="color-999">bởi</span> Moreno
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/76.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Ủy ban ngày 6/1 triệu tập Ginni Thomas ra làm chứng</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            2 ngày trước <span class="color-999">bởi</span> Moreno
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/77.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content h-auto">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Chính sách an toàn súng của Connell</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            1 ngày trước <span class="color-999">bởi</span> Admin
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 mt-5 mt-lg-0">
                            <p class="fw-bold text-uppercase fsz-14px mb-30 border-2 border-top border-dark pt-15 d-block d-lg-none">
                                Kinh doanh
                            </p>
                            <div class="tc-post-grid-default">
                                <div class="item border-1 border-bottom brd-gray pb-30">
                                    <a href="page-single-post-creative.html" class="img img-cover th-250 d-block">
                                        <img src="https://newzin-html.themescamp.com/assets/img/latest/78.png" alt="">
                                    </a>
                                    <div class="content pt-30">
                                        <h3 class="title ltspc--1 mb-10 fs-4">
                                            <a href="page-single-post-creative.html">
                                                Chương trình lũ lụt của FEMA có thể vi phạm luật dân quyền
                                            </a>
                                        </h3>
                                        <div class="text color-666">
                                            Công ty truyền thông xã hội đang thảo luận về việc bán cho Elon, một bước ngoặt đáng chú ý chỉ sau 11 ngày [...]
                                        </div>
                                        <div class="meta-bot lh-1 mt-30">
                                            <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                1 ngày trước <span class="color-999">bởi</span> admin
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tc-post-list-style2">
                                <div class="items">
                                    <div class="item pt-30 pb-30">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/79.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content pb-20">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Sự xuất hiện của Fiscal Arberto</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            2 ngày trước <span class="color-999">bởi</span> Moreno
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item pt-30 pb-0 border-0">
                                        <div class="row gx-3">
                                            <div class="col-4">
                                                <a href="page-single-post-creative.html" class="img img-cover th-70 d-block">
                                                    <img src="https://newzin-html.themescamp.com/assets/img/latest/80.png" alt="">
                                                </a>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h6 class="title fsz-18px mb-10 ltspc--1 lh-3">
                                                        <a href="page-single-post-creative.html">Geoff Dyer: Cách để già đi ở Mỹ</a>
                                                    </h6>
                                                    <div class="meta-bot lh-1">
                                                        <a href="home-politic.html#" class="fsz-11px color-000 text-uppercase">
                                                            1 ngày trước <span class="color-999">bởi</span> Admin
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
                </div>
            </div>
        </section>

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <img src="client/assets/img/logo_home1.png" alt="" class="dark-none">
                    <img src="client/assets/img/logo_home1_lt.png" alt="" class="light-none">
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i>
                </h6>
                <div class="text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae.
                    Soluta corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i>
                    </h6>

                    @foreach ($category2 as $category)
                        <a href="{{ route('client.category.show', $category->slug) }}" class="cat-card">
                            <div class="img img-cover ">

                                <div class="info">
                                    <h5 href="{{ route('client.category.show', $category->slug) }}">
                                        {{ $category->name }}
                                    </h5>
                                    <span class="num">{{ $loop->iteration }}</span> <!-- Số thứ tự danh mục -->
                                </div>
                            </div>
                        </a>
                    @endforeach


                </div>
                <div class="sidebar-contact-info mt-50">
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i
                            class="la la-angle-right ms-1"></i></h6>
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="home-default.html#">streat name 12, hollywood City, USA</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="home-default.html#">Newzin@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="home-default.html#">+12 123 456 789</a>
                        </li>
                    </ul>
                    <div class="social-links">
                        <a href="home-default.html#">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="home-default.html#">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="home-default.html#">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="home-default.html#">
                            <i class="la la-youtube"></i>
                        </a>
                        <a href="home-default.html#">
                            <i class="la la-spotify"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>



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

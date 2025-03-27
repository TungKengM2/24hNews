@extends('website.layouts.master')

@section('content')
    <main>
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
        <section class="tc-latest-news-style1">
            <div class="container">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>Hiện tại không có bài viết nào</p>
                            @endif





                        </div>
                        <div class="col-lg-3">
                            <div class="tc-widget-tags-style3">
                                <p class="color-000 text-uppercase mb-20 ltspc-1 fw-bold">Thẻ nóng</p>
                                <div class="content">
                                    @foreach ($tags as $tag)
                                        <a href="{{ route('tags.show', ['tag' => $tag->tag_id]) }}"
                                            class="btn border border-1 mt-20 py-2 px-3">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ====== end Latest news ====== -->


        <!-- ====== start tabs ====== -->
        <section class="tc-posts-tabs-style4 pt-60 pb-60">
            <div class="container">
                <div class="tc-tabs-head">
                    <a href="#" class="active" data-filter="all">All</a>
                    <a href="#" data-filter="latest">latest</a>
                    <a href="#" data-filter="breakfast">breakfast</a>
                    <a href="#" data-filter="dessert">dessert</a>
                    <a href="#" data-filter="fastfood">fast food</a>
                    <a href="#" data-filter="vegan">vegan</a>
                    <a href="#" data-filter="soup">soup</a>
                    <a href="#" data-filter="drink">drink</a>
                    <a href="#" data-filter="asia">asia</a>
                    <a href="#" data-filter="europe">europe</a>
                    <a href="#" data-filter="usa">usa</a>
                    <a href="#" data-filter="videos">videos</a>
                    <a href="#" data-filter="guide">guide</a>
                </div>
                <div class="tc-tabs-body tc-post-grid-style4 mt-50">
                    <div class="row gx-0">
                        <!-- Cột 1 -->
                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <!-- Item 1 -->
                            <div class="item mix latest soup asia">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/12.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Pumpkin soup for a warm winter</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">lateaduuuust,</a>
                                        <a href="#">soup,</a>
                                        <a href="#">asia</a>
                                    </div>
                                    <div class="text">
                                        As a rule of thumb, all spices and dried herbs should be stored in any cool, dark place [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="item mix dessert vegan">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/13.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Delicious dessert from coconut</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">dessert,</a>
                                        <a href="#">vegan</a>
                                    </div>
                                    <div class="text">
                                        Discover how coconut can transform your dessert into something extraordinary [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>
        
                        <!-- Cột 2 -->
                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <!-- Item 1 -->
                            <div class="item mix latest europe">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/16.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">25 Cafe Bars in Boston</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">latest,</a>
                                        <a href="#">europe</a>
                                    </div>
                                    <div class="text">
                                        Check out these trendy cafe bars with an amazing street view in Boston [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="item mix breakfast europe">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/17.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">5 Benefits from Eggs</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">Europe,</a>
                                        <a href="#">breakfast</a>
                                    </div>
                                    <div class="text">
                                        Eggs are not only nutritious but also versatile in many breakfast recipes [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>
        
                        <!-- Cột 3 -->
                        <div class="col-lg-3 border-1 border-end brd-gray">
                            <!-- Item 1 -->
                            <div class="item mix dessert asia">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/18.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Cheese Ice Cream with Strawberries</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">dessert,</a>
                                        <a href="#">asia</a>
                                    </div>
                                    <div class="text">
                                        A creative twist on ice cream that combines rich cheese flavors with fresh strawberries [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="item mix europe videos guide">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/19.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Sapo Cake Tutorial</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">europe,</a>
                                        <a href="#">videos,</a>
                                        <a href="#">guide</a>
                                    </div>
                                    <div class="text">
                                        Learn how to create a stunning Sapo Cake with this easy-to-follow tutorial [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>
        
                        <!-- Cột 4 -->
                        <div class="col-lg-3">
                            <!-- Item 1 -->
                            <div class="item mix fastfood drink">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/21.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Fastfood Party!</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">fastfood,</a>
                                        <a href="#">drink</a>
                                    </div>
                                    <div class="text">
                                        Get ready for a party with these fastfood favorites and refreshing drinks [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="item mix asia">
                                <a href="#" class="img img-cover" data-fancybox="tabs">
                                    <img src="https://newzin-html.themescamp.com/assets/img/tabs/25.png" alt="">
                                </a>
                                <div class="info">
                                    <h4 class="title">
                                        <a href="#">Unusual Durian Benefits</a>
                                    </h4>
                                    <div class="tags">
                                        <a href="#">asia</a>
                                    </div>
                                    <div class="text">
                                        Discover the unexpected benefits of durian, a fruit known for its unique aroma [...]
                                    </div>
                                    <a href="#" class="more">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="more mt-60">
                    <a href="page-blog.html">Load more</a>
                </div>
            </div>
        </section>
        
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.tc-tabs-head a').on('click', function(e){
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


        <!-- ====== start modals ====== -->

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4.png" alt=""
                        class="dark-none">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4_lt.png" alt=""
                        class="light-none">
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i> </h6>
                <div class="text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae. Soluta
                    corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i>
                    </h6>
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
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i
                            class="la la-angle-right ms-1"></i> </h6>
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
@endsection

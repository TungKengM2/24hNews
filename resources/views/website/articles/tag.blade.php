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
        

        <!-- ====== start modals ====== -->

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4.png" alt="" class="dark-none">
                    <img src="https://newzin-html.themescamp.com/assets/img/logo_home4_lt.png" alt="" class="light-none">
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1"> about us <i class="la la-angle-right ms-1"></i> </h6>
                <div class="text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae. Soluta corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i> </h6>
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
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1"> Contact & follow <i class="la la-angle-right ms-1"></i> </h6>
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
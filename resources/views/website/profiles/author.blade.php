@extends('website.layouts.master')

@section('content')
    <main>
        <!-- ====== start author header ====== -->
        <section class="tc-author-header">
            <div class="container">
                <div class="content">
                    <div class="title">
                        @if ($author->role)
                            <p class="fsz-14px color-fff op-5 mb-2">{{ ucfirst($author->role->name) }}</p>
                        @endif
                        <h2> {{ $author->username }} </h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author header ====== -->


        <!-- ====== start author-details ====== -->
        <section class="tc-author-details">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="content">
                            <div class="author-img img-cover">
                                <img src="{{ asset('storage/' . $author->image ?? 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg') }}"
                                    alt="{{ $author->username }}">
                            </div>
                            <div class="info">
                                <p class="color-666 mb-20"> {{ $author->description ?? 'No description available' }} </p>
                                <p class="color-666 mb-20"> <i class="la la-book"></i> {{ $author->articles_count }} Posts
                                    <span class="mx-3"> |
                                    </span> <i class="la la-comments"></i> 100 Comment
                                </p>
                                {{-- <div class="social-links">
                                        <a href="page-author.html#"> <i class="la la-facebook-f"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-twitter"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-behance"></i> </a>
                                        <a href="page-author.html#"> <i class="la la-youtube"></i> </a>
                                    </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end author-details ====== -->
        <section class="tc-author-posts pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="posts-side">
                            <p class="color-000 text-uppercase mb-30 ltspc-1">
                                <a href="{{ route('articles.index') }}">Recently Added</a>
                                <i class="la la-angle-right ms-1"></i>
                            </p>

                            @if ($author->articles->count() > 0)
                                @foreach ($author->articles as $article)
                                    <div class="tc-post-overlay-default">
                                        <div class="img th-600 img-cover">
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}">
                                            <div class="tags">
                                                <a href="{{ route('categories.show', $article->category_id) }}">
                                                    {{ $article->category->name ?? 'Uncategorized' }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="content ps-40 pe-40 pb-40">
                                            <h2 class="title mb-30">
                                                <a href="{{ route('articles.article', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h2>
                                            <div class="meta-bot lh-1">
                                                <ul class="d-flex">
                                                    <li class="date me-5">
                                                        <a href="#">
                                                            <i class="la la-calendar me-2"></i>
                                                            {{ $article->created_at->format('M d, Y') }}
                                                        </a>
                                                    </li>
                                                    <li class="author me-5">
                                                        <a href="{{ route('website.profile', $article->author_id) }}">
                                                            <i class="la la-user me-2"></i>
                                                            by {{ $article->author->username }}
                                                        </a>
                                                    </li>
                                                    <li class="comment">
                                                        <a href="{{ route('articles.show', $article->slug) }}#comments">
                                                            <i class="la la-comment me-2"></i>
                                                            {{ $article->comments->count() }} Comments
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>Chưa có bài viết nào.</p>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="col-lg-3">
                        <div class="tc-side-widgets mt-5 mt-lg-0">
                            <!-- widget-social -->
                            <div class="tc-widget-social-style1">
                                <p class="color-000 text-uppercase mb-30 ltspc-1 lh-2"> stay connected </p>
                                <div class="content">
                                    <a href="page-author.html#" class="social-card">
                                        <div class="icon facebook-icon">
                                            <i class="lab la-facebook-f"></i>
                                        </div>
                                        <h6>1,5M</h6>
                                    </a>
                                    <a href="page-author.html#" class="social-card">
                                        <div class="icon twitter-icon">
                                            <i class="lab la-twitter"></i>
                                        </div>
                                        <h6>920K</h6>
                                    </a>
                                    <a href="page-author.html#" class="social-card">
                                        <div class="icon insta-icon">
                                            <i class="lab la-instagram"></i>
                                        </div>
                                        <h6>25,7K</h6>
                                    </a>
                                    <a href="page-author.html#" class="social-card mb-0">
                                        <div class="icon youtube-icon">
                                            <i class="lab la-youtube"></i>
                                        </div>
                                        <h6>1,5M</h6>
                                    </a>
                                    <a href="page-author.html#" class="social-card mb-0">
                                        <div class="icon spotify-icon">
                                            <i class="lab la-spotify"></i>
                                        </div>
                                        <h6>1,5M</h6>
                                    </a>
                                </div>
                            </div>
                            <!-- widget-podcast -->
                            <div class="tc-widget-podcast">
                                <p class="color-000 text-uppercase mb-30 ltspc-1 lh-2"> new podcasts <i
                                        class="la la-angle-right ms-1"></i> </p>
                                <div class="main-card">
                                    <div class="img img-cover">
                                        <img src="{{ asset('client/assets/img/pdc1.png') }}" alt="">
                                    </div>
                                    <div class="info pt-10">
                                        <small>2 Hours ago</small>
                                        <h5>
                                            <a href="page-author.html#" class="title">
                                                Start A New Day with A Smile
                                            </a>
                                        </h5>
                                    </div>
                                    <audio controls class="audio">
                                        <source src="client/assets/img/audio1.mp3" type="audio/mpeg">
                                    </audio>
                                </div>
                                <div class="podcast-list">
                                    <div class="item">
                                        <a href="page-author.html#" class="img">
                                            <img src="{{ asset('client/assets/img/pdc1.png') }}" alt="">
                                        </a>
                                        <div class="info">
                                            <small> 3 Hours ago </small>
                                            <h6 class="title">
                                                <a href="page-author.html#">
                                                    Release energy and activity
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <a href="https://www.youtube.com/watch?v=pGbIOC83-So&t=21s" data-fancybox="video"
                                            class="img img-vid">
                                            <img src="{{ asset('client/assets/img/pdc2.png') }}" alt="">
                                            <i class="ion-arrow-right-b play-icon"></i>
                                        </a>
                                        <div class="info">
                                            <small> 3 Hours ago </small>
                                            <h6 class="title">
                                                <a href="page-author.html#">
                                                    Cafe, Chill and focus to study
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="item mb-0">
                                        <a href="page-author.html#" class="img">
                                            <img src="{{ asset('client/assets/img/pdc3.png') }}" alt="">
                                        </a>
                                        <div class="info">
                                            <small> 3 Hours ago </small>
                                            <h6 class="title">
                                                <a href="page-author.html#">
                                                    A long day mood
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- widget-sponsored -->
                            <div class="tc-widget-sponsored-style1">
                                <div class="img img-cover">
                                    <img src="{{ asset('client/assets/img/sponsored/1.png') }}" alt="">
                                </div>
                                <div class="info pt-10">
                                    <div class="spon-cat"> Sponsored Content </div>
                                    <h6 class="title">
                                        <a href="page-author.html#">
                                            Dile & Kamine Soap from pure natura 100%
                                        </a>
                                    </h6>
                                    <a href="page-author.html#">
                                        <small>dileandkamina.com <i
                                                class="las la-external-link-square-alt ms-2"></i></small>
                                    </a>
                                </div>
                            </div>
                            <!-- popular posts -->
                            <div class="tc-widget-popular-style1">
                                <p class="color-000 text-uppercase mb-20 ltspc-1"> popular posts </p>
                                <div class="main-card">
                                    <div class="img th-300 img-cover">
                                        <img src="{{ asset('client/assets/img/wid_popular/1.png') }}" alt="">
                                        <div class="tags">
                                            <a href="page-author.html#">business</a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">
                                            <a href="page-single-post-creative.html">Big Title for featured post with
                                                double</a>
                                        </h4>
                                        <div class="meta-bot">
                                            <ul class="d-flex">
                                                <li class="date me-4">
                                                    <a href="page-author.html#"><i class="la la-calendar me-1"></i> Dec
                                                        14, 2022</a>
                                                </li>
                                                <li class="comment">
                                                    <a href="page-author.html#"><i class="la la-comment me-1"></i> 55 </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tc-widget-popular-list">
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="{{ asset('client/assets/img/wid_popular/2.png') }}" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Joe Biden did not participate in the war
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="{{ asset('client/assets/img/wid_popular/3.png') }}" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Mindset to Succesful, Become Lion King
                                            </h6>
                                        </div>
                                    </a>
                                    <a href="page-single-post-creative.html" class="item">
                                        <div class="img img-cover">
                                            <img src="{{ asset('client/assets/img/wid_popular/4.png') }}" alt="">
                                        </div>
                                        <div class="info">
                                            <h6 class="title">
                                                Experience ballon balls in Turkey
                                            </h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- widget-adbox -->
                            <div class="tc-widget-adbox-style1">
                                <a href="page-author.html#" class="img">
                                    <img src="{{ asset('client/assets/img/banner12.png') }}" alt=""
                                        class="">
                                </a>
                            </div>
                            <!-- widget-survey -->
                            <div class="tc-widget-survey-style1">
                                <p class="color-000 text-uppercase mb-20 ltspc-1"> quick survey </p>
                                <div class="ques-title lh-4">
                                    How was your experience on Newzin?
                                </div>
                                <div class="ansr-content">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck1">
                                        <label class="form-check-label" for="quesCheck1">
                                            Awesome, I’m satisfied!
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck2">
                                        <label class="form-check-label" for="quesCheck2">
                                            Normal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="quesCheck" id="quesCheck3">
                                        <label class="form-check-label" for="quesCheck3">
                                            Bad! Need improve more
                                        </label>
                                    </div>
                                </div>
                                <div class="btns">
                                    <a href="page-author.html#" class="btn active me-2">
                                        Submit
                                    </a>
                                    <a href="page-author.html#" class="btn">
                                        Result
                                    </a>
                                </div>

                                <small class="pl-num">
                                    <span class="color-000">24,562 </span> Peoples joined
                                </small>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </section>
        <!-- ====== End author-posts ====== -->




        <!-- ====== start modals ====== -->

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <img src="client/assets/img/logo_home1.png" alt="" class="dark-none">
                    <img src="client/assets/img/logo_home1_lt.png" alt="" class="light-none">
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-10 ltspc-1"> about us <i class="la la-angle-right ms-1"></i> </h6>
                <div class="text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem optio tempora quia iure quae. Soluta
                    corporis quidem aperiam amet nihil.
                </div>

                <div class="sidebar-categories mt-40">
                    <h6 class="color-000 text-uppercase mb-30 ltspc-1"> categories <i class="la la-angle-right ms-1"></i>
                    </h6>
                    <a href="page-author.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="client/assets/img/bussines/1.png" alt="">
                        </div>
                        <div class="info">
                            <h5>bussines</h5>
                            <span class="num">12</span>
                        </div>
                    </a>
                    <a href="page-author.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="client/assets/img/trend/3.png" alt="">
                        </div>
                        <div class="info">
                            <h5>technology</h5>
                            <span class="num">14</span>
                        </div>
                    </a>
                    <a href="page-author.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="client/assets/img/must_read/3.png" alt="">
                        </div>
                        <div class="info">
                            <h5>culture</h5>
                            <span class="num">20</span>
                        </div>
                    </a>
                    <a href="page-author.html#" class="cat-card">
                        <div class="img img-cover">
                            <img src="client/assets/img/videos/1.png" alt="">
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
                            <a href="page-author.html#">streat name 12, hollywood City, USA</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="page-author.html#">Newzin@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="page-author.html#">+12 123 456 789</a>
                        </li>
                    </ul>
                    <div class="social-links">
                        <a href="page-author.html#">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="page-author.html#">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="page-author.html#">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="page-author.html#">
                            <i class="la la-youtube"></i>
                        </a>
                        <a href="page-author.html#">
                            <i class="la la-spotify"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== end modals ====== -->

    </main>
@endsection

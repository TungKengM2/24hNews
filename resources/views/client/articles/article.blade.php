
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
    <style>
        .article-image {
    height: 400px;
    object-fit: cover;
    width: 100%;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
    border-radius: 10px;
}

.position-relative:hover .overlay {
    opacity: 1;
}
.like-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    border: none;
    background: transparent;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 8px;
    transition: background-color 0.3s ease, transform 0.2s ease-in-out;
}

.like-btn i {
    font-size: 20px;
    transition: color 0.3s ease, transform 0.2s ease;
}

/* Khi hover vào nút */
.like-btn:hover {
    background-color: rgba(0, 0, 0, 0.1);
    transform: scale(1.05);
}

/* Khi đã like */
.liked {
    background-color: rgba(0, 123, 255, 0.2);
    border-radius: 8px;
}

.liked i {
    color: #007bff;  /* Màu xanh dương */
    transform: scale(1.2);
}

.liked span {
    color: #007bff;
}

    </style>
</head>

<body class="home-style1">

    <!-- ====== start loading page ====== -->
    @include('website.layouts.partials.loadingpage')
    <!-- ====== end loading page ====== -->

    <!-- ====== start navbar-container ====== -->
    @include('website.layouts.partials.header')
    <!-- ====== start navbar-container ====== -->

    <!--Contents-->
    <main class="product-page">
        <!-- ====== start product ====== -->
        <section class="product pt-50">
            <div class="container">
                    
<div class="container mt-4">
    <div class="row">
        <!-- Bài viết chính -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" class="card-img-top rounded-top article-image" alt="{{ $article->title }}">
                    <div class="overlay d-flex align-items-center justify-content-center">
                        <h2 class="text-white text-center">{{ $article->title }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="card-title">{{ $article->title }}</h2>
                    <p class="text-muted">
                        <i class="fa fa-eye"></i> {{ $article->views }} lượt xem | 
                        <i class="fa fa-user"></i> {{ $article->author->username ?? 'N/A' }}
                    </p>
        
                    <!-- Nút Like -->
                    <button id="likeButton" class="like-btn" data-article-id="{{ $article->article_id }}" data-liked="{{ $isLiked ? 'true' : 'false' }}">
                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-thumbs-up" style="color: {{ $isLiked ? '#007bff' : 'black' }};"></i>
                        <span id="likeText" style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $isLiked ? 'Đã thích' : 'Thích' }}</span>
                        <span id="likeCount" style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $likeCount }}</span>
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
            

            
        </div>
    </div>
</div>
                
            </div>
        </section>
        <!-- ====== end product ====== -->


        <!-- ====== start product details ====== -->
        <section class="product-details pt-100">
            <div class="container">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews"
                            aria-selected="false">Reviews (3)</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                        <div class="content-info text-center pb-0">
                            <div class="text mb-30">
                                In today's fast-paced world, maintaining a balance between work and health has become a top priority. Studies show that daily habits and living environments play a crucial role in enhancing quality of life.  
                            </div>
                            <div class="text">
                                Experts suggest that regular physical activity not only improves fitness but also boosts mental well-being. Additionally, a well-designed work environment enhances productivity and mental health, contributing to a sustainable and healthy lifestyle.
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                        <div class="product-reviews pt-30">
                            <div class="row gx-5">
                                <div class="col-lg-7">
                                    <div class="reviews-content pt-30">
                                        <h5 class="color-000 mb-40 text-capitalize"> 02 reviews </h5>
                                        <div class="comment-replay-cont bg-light py-5 px-4 mb-20">
                                            <div class="d-flex comment-cont">
                                                <div class="icon-60 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                                                    <img src="assets/img/colums/1.png" alt="">
                                                </div>
                                                <div class="inf">
                                                    <div class="title d-flex justify-content-between">
                                                        <h6 class="fw-bold fs-14px">Robert Downey Jr</h6>
                                                        <div class="time fs-12px text-uppercase d-inline-block">
                                                            <div class="rate">
                                                                <div class="stars">
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text color-000 fs-12px mt-10">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Atume nusaate staman utra phone limo sumeria                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment-replay-cont bg-light py-5 px-4 mb-20">
                                            <div class="d-flex comment-cont">
                                                <div class="icon-60 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                                                    <img src="assets/img/colums/2.png" alt="">
                                                </div>
                                                <div class="inf">
                                                    <div class="title d-flex justify-content-between">
                                                        <h6 class="fw-bold fs-14px">Ben Chiwell</h6>
                                                        <div class="time fs-12px text-uppercase">
                                                            <div class="rate">
                                                                <div class="stars">
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star active"></i>
                                                                    <i class="la la-star"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text color-000 fs-12px mt-10">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Atume nusaate staman utra phone limo sumeria                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <form class="comment-form d-block pt-30">
                                        <h5 class="color-000 mb-40 text-capitalize"> Add a review </h5>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="text-uppercase mb-1">
                                                    your rating
                                                </label>
                                                <div class="rate-stars">
                                                    <input type="radio" name="star" value="5">
                                                    <input type="radio" name="star" value="4">
                                                    <input type="radio" name="star" value="3">
                                                    <input type="radio" name="star" value="2">
                                                    <input type="radio" name="star" value="1">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-30">
                                                    <textarea class="form-control radius-4 fs-12px p-3" rows="6" placeholder="Write your comment here"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4 mb-lg-0">
                                                    <input type="text" class="form-control fs-12px radius-4 p-3" placeholder="Your Name *">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control fs-12px radius-4 p-3" placeholder="Your Email *">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-check mt-20">
                                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label fs-12px" for="flexCheckDefault">
                                                        Save my name &amp; email in this browser for next time I comment
                                                    </label>
                                                  </div>
                                            </div>
                                            <div class="col-12">
                                                <a href="page-product.html#" class="btn rounded-pill bg-main text-white sm-butn fw-bold mt-40">
                                                    <span>Submit Comment </span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
        <!-- ====== end product details ====== -->


        <!-- ====== start Related products ====== -->
        <section class="tc-products-content section-padding">
            <div class="container">
                <div class="title mb-30">
                    <h4>Related Articles</h4>
                </div>
                <div class="related-products-slider tc-products position-relative tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($relatedArticles as $related)
                                <div class="swiper-slide">
                                    <div class="product-card">
                                        <div class="img">
                                            <img src="{{ asset('storage/' . $related->thumbnail_url) }}" alt="{{ $related->title }}">
                                            <div class="btns">

                                                <a href="{{ route('client.articles.article', $related->article_id) }}" class="butn">
                                                    <span><i class="la la-eye me-2"></i> Read More</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info pt-30">
                                            <a href="{{ route('client.articles.article', $related->article_id) }}" class="title">{{ $related->title }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        <!-- ====== end Related products ====== -->

    </main>



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
        document.addEventListener("DOMContentLoaded", function () {
    let likeButton = document.getElementById("likeButton");
    let likeText = document.getElementById("likeText");
    let likeCount = document.getElementById("likeCount");
    let icon = likeButton.querySelector("i");

    let isLiked = likeButton.getAttribute("data-liked") === "true";

    // Cập nhật trạng thái ban đầu khi load trang
    if (isLiked) {
        updateLikeUI(true);
    }

    likeButton.addEventListener("click", function () {
        let articleId = likeButton.getAttribute("data-article-id");

        fetch(`/client/articles/${articleId}/like`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                likeButton.setAttribute("data-liked", data.liked ? "true" : "false");
                likeText.textContent = data.liked ? "Đã thích" : "Thích";
                likeCount.textContent = data.likeCount;

                // Cập nhật giao diện theo trạng thái like
                updateLikeUI(data.liked);
            } else {
                alert("Lỗi: " + data.message);
            }
        });
    });

    // Hàm cập nhật UI
    function updateLikeUI(liked) {
        if (liked) {
            likeText.style.color = "#007bff"; // Màu xanh 💙
            likeCount.style.color = "#007bff"; // Màu xanh 💙
            icon.classList.remove("fa-regular");
            icon.classList.add("fa-solid");
            icon.style.color = "#007bff"; // Màu xanh 💙
        } else {
            likeText.style.color = "black"; // Màu đen 🖤
            likeCount.style.color = "black"; // Màu đen 🖤
            icon.classList.remove("fa-solid");
            icon.classList.add("fa-regular");
            icon.style.color = "black"; // Màu đen 🖤
        }
    }
});



    </script>

</body>

</html>




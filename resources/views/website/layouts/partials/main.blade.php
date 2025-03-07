<main>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- ====== start breaking news ====== -->
    <section class="tc-breaking-news-style1 pt-50 pb-50">
        <div class="container">
            <p class="color-999 text-uppercase mb-30 ltspc-1">Báo Mới</p>
            <div class="tc-post-grid-default">
                <div class="tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($featuredArticles as $article)
                                <div class="swiper-slide">
                                    <a href="{{ Auth::check() ? route('client.articles.article', $article->article_id) : route('login') }}"
                                        class="item d-block">
                                        <div class="row gx-4 align-items-center">
                                            <div class="col-4">
                                                <div class="img th-70 img-cover">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="{{ $article->title }}">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="content">
                                                    <h5 class="title">{{ $article->title }}</h5>
                                                    <div class="meta-bot mt-10">
                                                        <ul>
                                                            <li class="date"> <i class="la la-clock"></i>
                                                                {{ $article->created_at->diffForHumans() }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
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
    </section>
    <!-- ====== end breaking news ====== -->

    <!-- ====== start trends news ====== -->
    <section class="tc-trends-news-style1 pt-50 pb-50 bg-gray1">
        <div class="container">
            <div class="hot-trends-tabs-style1 mb-4">
                <p class="color-999 text-uppercase ltspc-1 flex-shrink-0 me-4 pt-1"> <i
                        class="ion-arrow-graph-up-right me-2"></i> Hot Nhất Hiện Nay </p>
                <div class="links">
                    {{-- @foreach ($hottrendsArticles as $article)
                <a class="link" href="{{ Auth::check() ? route('client.articles.article', $article->id) : route('login') }}" class="item d-block">{{ $article->preview_contentt }}
                </a>
                @endforeach --}}
                </div>
            </div>
            <div class="section-content">
                <div class="row">

                    <div class="col-lg-8">
                        <div class="tc-trends-news-slider1 tc-slider-style2">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($D1Articles as $article)
                                        <div class="swiper-slide">
                                            <div class="tc-post-overlay-default">
                                                <div class="img th-650 img-cover">
                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                        alt="{{ $article->title }}">
                                                    <div class="tags">
                                                        <a href="">
                                                            {{ $article->category->name ?? 'Uncategorized' }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="content ps-40 pe-40 pb-40">
                                                    <h2 class="title mb-20">
                                                        <a
                                                            href="{{ Auth::check() ? route('client.articles.article', $article->article_id) : route('login') }}">

                                                            {{ $article->title }}
                                                        </a>
                                                    </h2>
                                                    <div class="text mb-40">
                                                        {{ Str::limit($article->preview_content, 100, '...') }}
                                                    </div>
                                                    <div class="meta-bot lh-1">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="#"><i class="la la-calendar me-2"></i>
                                                                    {{ $article->created_at->format('M d, Y') }}</a>
                                                            </li>
                                                            <li class="author me-5">
                                                                <a href="#"><i class="la la-user me-2"></i> by
                                                                    {{ $article->author->name ?? 'Admin' }}</a>
                                                            </li>
                                                            <li class="views">
                                                                <a href="#"><i
                                                                        class="la la-eye me-2"></i>{{ $article->views }}</a>
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
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tc-post-list-style1 bg-white p-3 rounded shadow">
                            <div class="tc-post-title-style1">
                                <a href="#" class="text-dark fw-bold">Top Bài Viết Bàn Luận</a>
                            </div>

                            @if ($trendingPosts->isNotEmpty())
                                @foreach ($trendingPosts as $index => $post)
                                    <a href="{{ Auth::check() ? route('client.articles.article', $post->article_id) : route('login') }}"
                                        class="item hover-main d-block p-2 text-dark">
                                        <h2 class="num">{{ $index + 1 }}</h2>
                                        <div class="content">
                                            <span class="fsz-12px text-muted text-uppercase mb-2">
                                                {{ $post->category->name ?? 'Uncategorized' }}
                                            </span>
                                            <h6 class="title">{{ $post->title }}</h6>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-center text-muted">Chưa có bài viết thịnh hành.</p>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
    <!-- ====== end trends news ====== -->


    <div class="container">
        <div class="tc-breaking-news-style8 bg-main mb-30">
            <div class="tc-breaking-title">
                <h5>Tin Thể Thao</h5>
            </div>
            <div class="tc-post-grid-style9">
                <div class="tc-breaking-news-slider8">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($sportsArticles as $article)
                                <div class="swiper-slide">
                                    <div class="item text-white">
                                        <div class="tags mb-20">
                                            <a class="blue" href="#">{{ $article->category->name }}</a>
                                        </div>
                                        <div class="img img-cover th-230">
                                            <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                alt="">
                                        </div>
                                        <div class="info mt-20">
                                            <h6 class="title">
                                                <a href="{{ Auth::check() ? route('client.articles.article', $article->article_id) : route('login') }}"
                                                    class="item hover-main d-block p-2 text-dark">
                                                    {{ $article->title }}
                                                </a>
                                            </h6>
                                            <div class="meta-bot lh-1 mt-20">
                                                <span class="fsz-13px text-white">
                                                    <i class="la la-clock me-1"></i>
                                                    {{ $article->created_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- ====== Tin mỗi danh mục lấy 1====== -->



    <div class="container">
        <div class="tc-whatsnew-news-style8 bg-white p-30 mb-30">
            <div class="tc-posts-tabs-style3">
                <div class="section-title-style2 mb-30 align-items-center justify-content-between">
                    <div class="d-flex align-items-end flex-wrap mb-3 mb-lg-0">
                        <h4 class="me-30 color-000">Tin mới nhất</h4>
                        <ul class="nav nav-pills rounded-0 bg-transparent" id="pills-tab" role="tablist">
                            @foreach ($categories as $key => $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link category-button {{ $key == 0 ? 'active' : '' }}"
                                        data-category-id="{{ $category->id }}">
                                        {{ $category->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <div class="tc-post-grid-style9">
                        <div class="row gx-5" id="post-container">
                            <!-- Bài viết sẽ được load vào đây -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryButtons = document.querySelectorAll('.category-button');
        const postContainer = document.getElementById('post-container');

        // Gán sự kiện click cho từng nút danh mục
        categoryButtons.forEach(button => {
            button.addEventListener('click', function () {
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                let categoryId = this.getAttribute('data-category-id');
                if (categoryId) fetchPostsByCategory(categoryId);
            });
        });

        // Tự động load bài viết của danh mục đầu tiên khi trang mở
        let firstCategory = document.querySelector('.category-button.active') || categoryButtons[0];
        if (firstCategory) {
            firstCategory.classList.add('active');
            let firstCategoryId = firstCategory.getAttribute('data-category-id');
            if (firstCategoryId) fetchPostsByCategory(firstCategoryId);
        }

        // Hàm gọi API để lấy bài viết theo danh mục
        function fetchPostsByCategory(categoryId) {
            fetch("{{ route('get.posts.by.category') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ category_id: categoryId })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Dữ liệu từ API:", data);
                postContainer.innerHTML = "";

                if (!Array.isArray(data) || data.length === 0) {
                    postContainer.innerHTML = `<p class="text-muted text-center">Không có bài viết nào trong danh mục này.</p>`;
                    return;
                }

                postContainer.innerHTML = `
                    <div class="row gx-5">
                        <div class="col-lg-6 border-1 border-end brd-gray">
                            ${data[0] ? createLargePost(data[0]) : ''}
                        </div>
                        <div class="col-lg-3 border-1 border-end brd-gray">
                            ${data[1] ? createSmallPost(data[1]) : ''}
                            ${data[2] ? createSmallPost(data[2]) : ''}
                        </div>
                        <div class="col-lg-3">
                            ${data[3] ? createSmallPost(data[3]) : ''}
                            ${data[4] ? createSmallPost(data[4]) : ''}
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error("Lỗi tải bài viết:", error);
                postContainer.innerHTML = `<p class="text-danger text-center">Đã xảy ra lỗi khi tải bài viết.</p>`;
            });
        }

        // Hàm tạo bài viết lớn
        function createLargePost(post) {
            return `
                <div class="item mb-4 mb-lg-0">
                    <div class="img img-cover th-350">
                        <img src="${post.thumbnail_url}" alt="${post.title}">
                    </div>
                    <div class="info mt-30">
                        <div class="tags">
                            <a class="blue" href="#">${post.category_name}</a>
                        </div>
                        <h4 class="title mt-15"> 
                            <a href="/article/${post.slug}" class="hover-underline">${post.title}</a>    
                        </h4>
                        <div class="text color-666 mt-20">
                            ${post.preview_content}
                        </div>
                        <div class="meta-bot lh-1 mt-30">
                            <span class="fsz-13px"><i class="la la-clock me-1"></i> ${post.created_at}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        // Hàm tạo bài viết nhỏ
        function createSmallPost(post) {
            return `
                <div class="item pb-30 mb-30 border-1 border-bottom brd-gray">
                    <div class="img img-cover th-160">
                        <img src="${post.thumbnail_url}" alt="${post.title}">
                    </div>
                    <div class="info mt-20">
                        <div class="tags">
                            <a class="green" href="#">${post.category_name}</a>
                        </div>
                        <h6 class="title mt-10 ltspc--1"> 
                            <a href="/article/${post.slug}" class="hover-underline">${post.title}</a>    
                        </h6>
                    </div>
                </div>
            `;
        }
    });
</script>

    
    
    
    




    <!-- ====== Top Nhà Báo Nổi Bật ====== -->

    <section class="tc-columnist-style1">
        <div class="container">
            <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                <p class="color-000 text-uppercase mb-40 ltspc-1 lh-1">Nhà Báo Mới<i
                        class="la la-angle-right ms-1"></i> </p>
                <div class="columnist-slider1 tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($journalists as $journalist)
                                <div class="swiper-slide">
                                    <div class="columnist-card d-flex align-items-center">
                                        <div
                                            class="img img-cover icon-100 rounded-circle overflow-hidden flex-lg-shrink-0 me-4">
                                            <img src="{{ $journalist->image ? asset('storage/' . $journalist->image) : 'https://i.pravatar.cc/150?img=4' }}"
                                                alt="{{ $journalist->username }}">

                                        </div>
                                        <div class="info">
                                            <h6 class="name fsz-20px mb-10">
                                                {{ $journalist->username }}
                                            </h6>
                                            <div class="jop-title">
                                                <small class="fsz-13px color-999">Specialize in</small>
                                                <p class="fsz-13px text-uppercase">
                                                    {{ $journalist->specializations ?? 'Unknown' }}</p>
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
    </section>
    <!-- ====== end another-news ====== -->

    <!-- ====== start download ====== -->
    <section class="tc-download-style1 pb-50">
        <div class="container">
            <div class="content">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="info">
                            <strong class="title">Download Newzin App</strong>
                            <div class="text">
                                Easy to update latest news, daily podcast and everything in your hand
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="img">
                            <a href="home-default.html#">
                                <img src="client/img/apple1.png" alt="">
                            </a>
                            <a href="home-default.html#">
                                <img src="client/img/android1.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== end download ====== -->

    <!-- ====== start modals ====== -->

    <section class="tc-news-style1">
        <div class="container">
            <div class="content pt-50 pb-50 border-1 border-top brd-gray">
                <p class="color-000 text-uppercase mb-40 ltspc-1">Tin Tức Có Thể Quan Tâm<i
                        class="la la-angle-right ms-1"></i></p>
                <div class="row">
                    @foreach ($newsData as $data)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="news-card">
                                <div class="img img-cover rounded">
                                    <img src="{{ $data['article']->thumbnail_url ? asset('storage/' . $data['article']->thumbnail_url) : 'https://via.placeholder.com/400' }}"
                                        alt="{{ $data['article']->title }}">



                                </div>
                                <div class="info p-3">
                                    <h6 class="category text-uppercase text-primary mb-2">
                                        {{ $data['category']->name }}
                                    </h6>
                                    <h5 class="title mb-2">{{ $data['article']->title }}</h5>


                                    <a href="{{ Auth::check() ? route('client.articles.article', $data['article']->article_id) : route('login') }}"
                                        class="item hover-main d-block p-2 text-dark">
                                        Xem chi tiết <i class="la la-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>





</main>

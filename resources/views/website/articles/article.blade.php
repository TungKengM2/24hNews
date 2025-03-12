@extends('website.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        .reply-content {
            white-space: pre-line;
        }

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
            color: #007bff;
            /* Màu xanh dương */
            transform: scale(1.2);
        }

        .liked span {
            color: #007bff;
        }
    </style>

    <!--Contents-->
    <main class="product-page">
        <!-- ====== start product ====== -->
        <section class="product pt-100 pb-100">
            <div class="container">
                {{-- Thông báo đã lưu bài viết --}}
                @if (session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('message') }}

                    </div>
                @endif

                <div class="container mt-5">
                    <div class="row">
                        <!-- Bài viết chính -->
                        <div class="col-12">
                            <div class="card shadow-sm mb-5 border-0">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                        class="card-img-top rounded-top article-image" alt="{{ $article->title }}">
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
                                    <button id="likeButton" class="like-btn" data-article-id="{{ $article->article_id }}"
                                        data-liked="{{ $isLiked ? 'true' : 'false' }}">
                                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-thumbs-up"
                                            style="color: {{ $isLiked ? '#007bff' : 'black' }};"></i>
                                        <span id="likeText"
                                            style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $isLiked ? 'Đã thích' : 'Thích' }}</span>
                                        <span id="likeCount"
                                            style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $likeCount }}</span>
                                    </button>
                                    {{-- BookMark By TungKeng --}}
                                    <a href="" id="bookmarkButton" class="me-40"
                                        data-article-id="{{ $article->article_id }}"
                                        onclick="toggleBookmark(this, {{ $article->article_id }})">
                                        <i class="la la-bookmark me-1" id="bookmarkIcon"
                                            style="color: {{ $isBookmarked ? 'gold' : 'inherit' }};">
                                        </i>
                                        {{ $isBookmarked ? 'Đã lưu' : 'Bookmark' }}
                                    </a>

                                    <div class="article-content mt-4">{!! $article->content !!}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Quảng cáo -->

                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end product ====== -->
        

        <!-- ====== start product details ====== -->
        <section class="product-details pt-20">
            <div class="container">
                <ul class="nav nav-pills" id="pills-tab" role="tablist"></ul>
                <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                    aria-labelledby="pills-description-tab">
                    <div class="product-reviews pt-30">
                        <div class="row gx-5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="reviews-content pt-30">
                                        <div class="comments-filter">
                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <p class="text-uppercase">{{ $comments->total() }} Bình Luận</p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <br>
                                        <?php foreach ($comments as $comment): ?>
                                        <?php if (!$comment->parent_id): ?>
                                        <div class="comment-reply-cont bg-light py-3 px-4 mb-3 rounded shadow-sm">
                                            <div class="d-flex align-items-start">
                                                <div
                                                    class="icon-60 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                                                    <img src="<?= !empty($comment->user->image) 
                                                    ? asset('storage/' . $comment->user->image) 
                                                    : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>" 
                                                    alt="User Avatar">
                                                </div>
                                                <div class="inf w-100">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="fw-bold">
                                                            <?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>
                                                        </h6>
                                                        <span class="fs-12px text-muted">
                                                            <i class="fas fa-clock"></i>
                                                            <?= date('F d, Y', strtotime($comment->created_at)) ?>
                                                        </span>
                                                    </div>
                                                    <div class="text color-000 fs-14px mt-2">
                                                        <?= nl2br(htmlspecialchars($comment->content)) ?>
                                                    </div>
                                                    <div class="mt-2">
                                                        <button class="btn reply-btn butn border border-1 mt-20 py-2 px-3"
                                                            data-comment-id="<?= $comment->comment_id ?>"
                                                            data-username="<?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>">

                                                            <span class="fw-bold">Trả lời</span>

                                                        </button>
                                                    </div>
                                                    <!-- Danh sách replies -->
                                                    <div class="replies ms-5 mt-3"
                                                        data-reply-count="<?= count($comment->replies) ?>">
                                                        <?php
                                                        $replyCount = count($comment->replies);
                                                        $visibleReplies = 3; // Số phản hồi hiển thị ban đầu
                                                        $index = 0;
                                                        ?>
                                                        <?php foreach ($comment->replies as $reply): ?>
                                                        <div
                                                            class="comment-reply-cont bg-white py-2 px-3 mb-2 rounded shadow-sm reply-item <?= $index >= $visibleReplies ? 'd-none' : '' ?>">
                                                            <div class="d-flex align-items-start">
                                                                <div
                                                                    class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                                                                    <img src="<?= $reply->user->image 
                                                                    ? asset('storage/' . $reply->user->image) 
                                                                    : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>" 
                                                                    alt="User Avatar">
                                                                </div>
                                                                <div class="inf w-100">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <h6 class="fw-bold">
                                                                            <?= htmlspecialchars($reply->user->username ?? 'Anonymous') ?>
                                                                        </h6>
                                                                        <span class="fs-12px text-muted">
                                                                            <i class="fas fa-clock"></i>
                                                                            <?= date('F d, Y', strtotime($reply->created_at)) ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="text color-000 fs-14px mt-1">
                                                                        <?= nl2br(htmlspecialchars($reply->content)) ?>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <button
                                                                            class="btn reply-btn butn border border-1 mt-20 py-2 px-3 reply-btn "
                                                                            data-comment-id="<?= $comment->comment_id ?>"
                                                                            data-username="<?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>">

                                                                            <span class="fw-bold">Trả lời</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $index++; ?>
                                                        <?php endforeach; ?>
                                                        <?php if ($replyCount > $visibleReplies): ?>
                                                        <button
                                                            class="btn btn-link text-primary px-0 show-more-replies text-decoration-none">Xem
                                                            thêm
                                                        </button>
                                                        <?php endif; ?>
                                                    </div>
                                                    <!-- JavaScript để hiển thị form khi nhấn nút Reply -->
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            document.querySelectorAll(".replies").forEach(replyContainer => {
                                                                const showMoreBtn = replyContainer.querySelector(".show-more-replies");
                                                                const hiddenReplies = replyContainer.querySelectorAll(".reply-item.d-none");

                                                                if (showMoreBtn) {
                                                                    showMoreBtn.addEventListener("click", function() {
                                                                        hiddenReplies.forEach(reply => reply.classList.remove("d-none"));
                                                                        showMoreBtn.style.display = "none"; // Ẩn nút sau khi mở rộng
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                    <!-- Form Reply -->
                                                    <div class="reply-form-container mt-2 d-none"
                                                        id="reply-form-{{ $comment->comment_id }}">
                                                        <form class="reply-form">
                                                            @csrf
                                                            <input type="hidden" name="comment_id"
                                                                value="{{ $comment->comment_id }}">
                                                            <input type="hidden" name="article_id"
                                                                value="{{ $comment->article_id }}">

                                                            <div
                                                                class="d-flex align-items-start bg-white p-3 rounded shadow-sm border">
                                                                <!-- Ảnh đại diện -->
                                                                <div
                                                                    class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                                                                    <img src="{{ $currentUser->image ?? asset('assets/img/colums/default.png') }}"
                                                                        alt="Your Avatar">
                                                                </div>

                                                                <div class="w-100">
                                                                    <!-- Ô nhập nội dung trả lời -->
                                                                    <textarea class="form-control form-control-sm reply-content" name="content" rows="2" required
                                                                        placeholder="Trả lời: {{ '@' . ($comment->user->username ?? 'Người dùng ẩn danh') }}"
                                                                        onclick="addUsernameToReply(this, '{{ $comment->user->username ?? 'Người dùng ẩn danh' }}')">
                                                                    </textarea>

                                                                    <script>
                                                                        function addUsernameToReply(textarea, username) {
                                                                            username = '@' + username.trim();
                                                                            let currentValue = textarea.value.trim();

                                                                            // Nếu chưa có @username ở đầu, mới thêm vào
                                                                            if (!currentValue.startsWith(username)) {
                                                                                textarea.value = username + ' ' + currentValue;
                                                                            }

                                                                            textarea.focus();
                                                                        }
                                                                    </script>

                                                                    <!-- Nút hành động -->
                                                                    <div class="d-flex justify-content-end gap-2 mt-2">
                                                                        <button type="button"
                                                                            class="btn butn border border-1 mt-20 py-2 px-3 cancel-reply">Hủy</button>
                                                                        <button type="button"
                                                                            class="btn butn border border-1 mt-20 py-2 px-3 send-reply"
                                                                            data-comment-id="{{ $comment->comment_id }}"
                                                                            data-article-id="{{ $comment->article_id }}">
                                                                            Trả lời
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>

                                        <!-- THÊM PHÂN TRANG -->
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $comments->links() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <form class="comment-form pt-30" method="POST"
                                        action="<?= route('articles.comment', ['article_id' => $article->article_id]) ?>">
                                        <?= csrf_field() ?>
                                        <h5 class="color-000 mb-40 text-capitalize"> Thêm bình luận </h5>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-30">
                                                    <textarea class="form-control radius-4 fs-12px p-3" name="content" rows="6"
                                                        placeholder="Viết bình luận của bạn ở đây" required></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="article_id" value="<?= $article->article_id ?>">
                                            <div class="col-12">
                                                <button type="submit"
                                                    class="btn rounded-pill bg-main text-white sm-butn fw-bold mt-40">
                                                    Gửi bình luận
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
                    <h4>Bài viết liên quan</h4>
                </div>
                <div class="related-products-slider tc-products position-relative tc-slider-style1">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($relatedArticles as $related)
                                <div class="swiper-slide">
                                    <div class="product-card">
                                        <div class="img">
                                            <img src="{{ asset('storage/' . $related->thumbnail_url) }}"
                                                alt="{{ $related->title }}">
                                            <div class="btns">

                                                <a href="{{ route('articles.article', $related->slug) }}"
                                                    class="butn">
                                                    <span><i class="la la-eye me-2"></i>Đọc thêm</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info pt-30">
                                            <a href="{{ route('articles.article', $related->slug) }}"
                                                class="title">{{ $related->title }}</a>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let likeButton = document.getElementById("likeButton");
            let likeText = document.getElementById("likeText");
            let likeCount = document.getElementById("likeCount");
            let icon = likeButton.querySelector("i");

            let isLiked = likeButton.getAttribute("data-liked") === "true";

            // Cập nhật trạng thái ban đầu khi load trang
            if (isLiked) {
                updateLikeUI(true);
            }

            likeButton.addEventListener("click", function() {
                let articleId = likeButton.getAttribute("data-article-id");

                fetch(`/articles/${articleId}/like`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Script loaded!");

            /** 🟢 1️⃣ Xử lý gửi Comment thường **/
            document.querySelector(".comment-form").addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let url = this.getAttribute("action");

                fetch(url, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                            document.querySelector(".reviews-content").insertAdjacentHTML("beforeend",
                                newComment);
                            e.target.reset();
                        } else {
                            alert("Lỗi khi gửi comment!");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            // Mở form trả lời khi nhấn "Reply"
            document.querySelectorAll(".reply-btn").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    let commentId = this.getAttribute("data-comment-id");
                    let replyForm = document.getElementById(`reply-form-${commentId}`);
                    if (replyForm) {
                        replyForm.classList.toggle("d-none");
                    }
                });
            });

            // Ẩn form khi nhấn "Cancel"
            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("cancel-reply")) {
                    let form = e.target.closest(".reply-form-container");
                    if (form) {
                        form.classList.add("d-none");
                    }
                }
            });



            $(document).ready(function() {
                $(".send-reply").click(function() {
                    var btn = $(this);
                    var form = btn.closest("form");
                    var content = form.find(".reply-content").val();
                    var articleId = btn.data("article-id");
                    var commentId = btn.data("comment-id");

                    if (content.trim() === "") {
                        alert("Nội dung không được để trống!");
                        return;
                    }

                    $.ajax({
                        url: "{{ route('articles.replyComment', ['article_id' => '__ARTICLE_ID__', 'comment_id' => '__COMMENT_ID__']) }}"
                            .replace("__ARTICLE_ID__", articleId)
                            .replace("__COMMENT_ID__", commentId),
                        type: "POST",
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                window.location.reload();



                                // Chèn bình luận mới vào giao diện
                                $("#reply-form-" + commentId).before(newReply);

                                // Ẩn form & xóa nội dung nhập vào
                                form.find(".reply-content").val("");
                                $("#reply-form-" + commentId).addClass("d-none");
                            }
                        },
                        error: function() {
                            alert("Có lỗi xảy ra, vui lòng thử lại!");
                        }
                    });
                });

                // Nút hủy: Ẩn form khi nhấn "Hủy"
                $(".cancel-reply").click(function() {
                    $(this).closest(".reply-form-container").addClass("d-none");
                });
            });
        });
    </script>
@endsection

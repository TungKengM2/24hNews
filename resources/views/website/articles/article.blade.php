@extends('website.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="article-id" content="{{ $article->article_id }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!--Contents-->
    <main class="product-page">
        @if (session('message'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('message') }}

            </div>
        @endif
        <!--Contents-->

        <!-- ====== start tc-main-post-style1 ====== -->
        <section class="tc-main-post-style1 pb-60">
            <div class="container">
                <div class="tc-main-post-title pt-40 pb-40">
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="text-uppercase mb-15">{{ $article->category->name }}</p>
                            <h2 class="title">{{ $article->title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="meta-nav pt-30 pb-30 border-top border-1 brd-gray">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="author-side color-666 fsz-13px">
                                <div class="author me-40 d-flex d-lg-inline-flex align-items-center">
                                    <span class="icon-30 rounded-circle overflow-hidden me-10">
                                        <img src="<?= !empty($article->author->image) ? asset('storage/' . $article->author->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>"
                                            alt="User Avatar">
                                    </span>
                                    <span>By</span>
                                    <a href="{{ route('website.profileAuth', ['id' => $article->author->user_id]) }}"
                                        class="text-decoration-underline text-primary ms-1">{{ $article->author->username }}</a>
                                </div>

                                <span class="me-40">
                                    <a href="#"><i class="la la-calendar me-1"></i>
                                        <?= date('F d, Y', strtotime($article->created_at)) ?></a>
                                </span>

                                <span class="me-40">
                                    <a href="#"><i class="la la-eye me-1"></i>
                                        {{ $article->views }} Lượt xem </a>
                                </span>

                                <span class="me-40">
                                    <a href="#"><i class="la la-comment me-1"></i>
                                        {{ $comments->total() }}
                                        Bình luận</a>
                                </span>



                            </div>
                        </div>
                        <div class="col-lg-6 text-lg-end">
                            <div class="links-side color-000 fsz-13px">
                                <span class="me-40 d-flex align-items-center">
                                    @php
                                        $fullStars = floor($article->rating_star);
                                        $halfStar = $article->rating_star - $fullStars >= 0.5;
                                    @endphp

                                    <div class="rating-stars">
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor

                                        @if ($halfStar)
                                            <i class="fas fa-star-half-alt text-warning"></i>
                                        @endif

                                        @for ($i = $fullStars + $halfStar; $i < 5; $i++)
                                            <i class="far fa-star text-muted"></i>
                                        @endfor
                                    </div>

                                    <div class="m-2 small text-muted">
                                        {{ number_format($article->rating_star, 1) }} / 5
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tc-main-post-img img-cover mb-50">
                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}" alt="{{ $article->title }}">
                </div>
                <div class="tc-main-post-content color-000">
                    <div class="row">
                        <div class="col-lg-1">
                            <div class="sharing d-flex flex-column align-items-center gap-4 sticky-top"
                                style="top: 100px; padding-top: 20px;">
                                <!-- Nút Like -->
                                <button id="likeButton"
                                    class="d-flex flex-column align-items-center gap-1 border-0 bg-transparent mb-3"
                                    data-article-id="{{ $article->article_id }}"
                                    data-liked="{{ $isLiked ? 'true' : 'false' }}"
                                    style="outline: none; box-shadow: none; cursor: pointer;">
                                    <i id="likeIcon" class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart"
                                        style="font-size: 28px; {{ $isLiked ? 'color: #e60023;' : 'color: black;' }}">
                                    </i>
                                    <span id="likeCount"
                                        style="font-size: 14px; font-weight: bold; color: {{ $isLiked ? '#e60023' : 'black' }};">
                                        {{ $likeCount }}
                                    </span>
                                </button>

                                <!-- Nút Bookmark -->
                                <a href="" id="bookmarkButton"
                                    class="d-flex flex-column align-items-center gap-1 text-decoration-none mb-3"
                                    data-article-id="{{ $article->article_id }}"
                                    onclick="toggleBookmark(this, {{ $article->article_id }}); return false;">
                                    <i class="la la-bookmark" id="bookmarkIcon"
                                        style="font-size: 28px; color: {{ $isBookmarked ? 'gold' : '#555' }};">
                                    </i>
                                    <span
                                        style="font-size: 14px; font-weight: bold; color: {{ $isBookmarked ? 'gold' : '#555' }};">
                                        {{ $isBookmarked ? 'Đã lưu' : 'Lưu' }}
                                    </span>
                                </a>

                                <!-- Nút Report -->
                                <button type="button"
                                    class="report-article-btn d-flex flex-column align-items-center gap-1 border-0 bg-transparent"
                                    data-article-id="{{ $article->article_id }}"
                                    style="outline: none; box-shadow: none; cursor: pointer;">
                                    <i class="la la-exclamation-triangle" style="font-size: 28px; color: #777;"></i>
                                    <span style="font-size: 14px; font-weight: bold; color: #777;">Báo cáo</span>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-11">
                            <div class="content">
                                @foreach (explode("\n", $article->content) as $paragraph)
                                    @if (trim($paragraph) !== '')
                                        <p class="info-text xm-content-width mt-30">{!! $paragraph !!}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end tc-main-post-style ====== -->

        <!-- ====== start banner18 ====== -->
        <section class="banner18">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="content border-1 border-top border-bottom brd-gray pt-50 pb-50">
                            <a href="page-single-post-creative.html#" class="d-block img-cover">
                                <img src="https://newzin-html.themescamp.com/assets/img/banner18.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== end banner18 ====== -->

        <!-- ====== start video content ====== -->
        <section class="tc-main-post-style1 pt-20 pb-20">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="btm-share-post mt-30">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="btm-tags d-flex flex-wrap justify-content-center gap-2">
                                        @foreach ($article->tags as $tag)
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
            </div>
        </section>
        <!-- ====== end next prev post slider ====== -->

        <!-- ====== start author info ====== -->
        @if ($article->author)
            <section class="tc-author-info-style1 pb-50">
                <div class="container">
                    <div class="tc-author-card border-1 border-top brd-gray">
                        <div class="content mt-50 p-50 d-block d-lg-flex bg-gray1">
                            <div class="img img-cover icon-85 rounded-circle overflow-hidden flex-shrink-0 me-30">
                                <img src="{{ $article->author->avatar ?? 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' }}"
                                    alt="{{ $article->author->username }}">
                            </div>
                            <div class="info">
                                <h5 class="title fsz-24px fw-bold">{{ $article->author->username }}</h5>
                                <small class="fsz-12px color-main text-uppercase">Tác giả </small>
                                <div class="text fsz-15px color-666 mt-20">
                                    {{ $article->author->description ?? 'Không có mô tả.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- ====== end author info ====== -->

        <!-- ====== start comments ====== -->
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
                                                    <img src="<?= !empty($comment->user->image) ? asset('storage/' . $comment->user->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>"
                                                        alt="User Avatar">
                                                </div>
                                                <div class="inf w-100">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="fw-bold mb-0">
                                                            <a
                                                                href="{{ route('website.profileAuth', ['id' => $comment->user->user_id]) }}">
                                                                <?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>
                                                            </a>
                                                        </h6>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="fs-12px text-muted">
                                                                <i class="fas fa-clock me-1"></i>
                                                                <?= date('F d, Y', strtotime($comment->created_at)) ?>
                                                            </span>

                                                            @if (auth()->check() && auth()->id() === $comment->user_id)
                                                                <!-- Trash can icon button -->
                                                                <form method="POST"
                                                                    action="{{ route('comments.destroy', $comment->comment_id) }}"
                                                                    onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn trash-can-btn butn border border-1 py-2 px-3 ms-2"
                                                                        title="Xóa bình luận">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <?php if ($comment->user_id !== auth()->id()): ?>
                                                            <!-- Repost button -->
                                                            <button
                                                                class="btn repost-btn butn border border-1 py-2 px-3 ms-2"
                                                                data-comment-id="{{ $comment->comment_id }}"
                                                                data-content="{{ htmlspecialchars($comment->content, ENT_QUOTES, 'UTF-8') }}"
                                                                title="Repost bình luận này">
                                                                <i class="la la-exclamation-triangle"
                                                                    style=" color: red;"></i>

                                                                <!-- Icon repost dạng tam giác -->
                                                            </button>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>

                                                    <div id="comment-<?= $comment->comment_id ?>"
                                                        class="text color-000 fs-14px mt-2">
                                                        <?= nl2br(htmlspecialchars($comment->content)) ?>
                                                    </div>

                                                    <div class="mt-2">
                                                        <button
                                                            class="btn reply-btn butn border border-1 py-2 px-3 d-inline-block"
                                                            data-comment-id="<?= $comment->comment_id ?>"
                                                            data-username="<?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>">
                                                            <span class="fw-bold">Trả lời</span>
                                                        </button>


                                                    </div>

                                                    <!-- Delete form (ẩn/hiện khi bấm vào icon thùng rác) -->
                                                    @if (auth()->check() && auth()->id() === $comment->user_id)
                                                        <div id="delete-options-{{ $comment->comment_id }}"
                                                            class="mt-2" style="display: none;">
                                                            <form method="POST"
                                                                action="{{ route('comments.destroy', $comment->comment_id) }}"
                                                                class="d-inline-block">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif

                                                    @if (session('success'))
                                                        <script>
                                                            alert("{{ session('success') }}");
                                                            window.location.reload();
                                                        </script>
                                                    @endif

                                                    <script>
                                                        function toggleDeleteOptions(commentId) {
                                                            const options = document.getElementById('delete-options-' + commentId);
                                                            options.style.display = (options.style.display === 'none') ? 'block' : 'none';
                                                        }
                                                    </script>


                                                    <!-- Danh sách replies -->
                                                    <div class="replies ms-5 mt-3"
                                                        data-reply-count="<?= count($comment->replies) ?>">
                                                        <?php
                                                        $replyCount = count($comment->replies);
                                                        $visibleReplies = 3; // Initial number of replies to show
                                                        $index = 0;
                                                        ?>
                                                        <?php foreach ($comment->replies as $reply): ?>
                                                        <div
                                                            class="comment-reply-cont bg-white py-2 px-3 mb-2 rounded shadow-sm reply-item <?= $index >= $visibleReplies ? 'd-none' : '' ?>">
                                                            <div class="d-flex align-items-start">
                                                                <div
                                                                    class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                                                                    <img src="<?= $reply->user->image ? asset('storage/' . $reply->user->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>"
                                                                        alt="User Avatar">
                                                                </div>
                                                                <div class="inf w-100">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <h6 class="fw-bold">
                                                                            <?= htmlspecialchars($reply->user->username ?? 'Anonymous') ?>
                                                                        </h6>
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="fs-12px text-muted">
                                                                                <i class="fas fa-clock"></i>
                                                                                <?= date('F d, Y', strtotime($reply->created_at)) ?>
                                                                            </span>
                                                                            @if (auth()->check() && auth()->id() === $reply->user_id)
                                                                                <!-- Kiểm tra ID người dùng với bình luận con -->
                                                                                <button
                                                                                    class="btn trash-can-btn butn border border-1 py-2 px-3 ms-2"
                                                                                    onclick="confirmDelete(event, {{ $reply->comment_id }})">
                                                                                    <!-- Sử dụng comment_id của reply -->
                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                    <!-- Trash can icon -->
                                                                                </button>
                                                                            @endif
                                                                            @if (auth()->check() && auth()->id() !== $reply->user_id)
                                                                                <!-- Nếu không phải là chủ bình luận -->
                                                                                <button
                                                                                    class="btn repost-btn butn border border-1 py-2 px-3 ms-2"
                                                                                    data-comment-id="{{ $reply->comment_id }}"
                                                                                    data-content="{{ htmlspecialchars($comment->content, ENT_QUOTES, 'UTF-8') }}">
                                                                                    <i class="la la-exclamation-triangle"
                                                                                        style=" color: #fa0000;"></i>
                                                                                    <span class="fw-bold"></span>
                                                                                </button>
                                                                            @endif


                                                                        </div>
                                                                    </div>
                                                                    <div id="comment-<?= $reply->comment_id ?>"
                                                                        class="text color-000 fs-14px mt-1">
                                                                        <?= nl2br(htmlspecialchars($reply->content)) ?>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <button
                                                                            class="btn reply-btn butn border border-1 py-2 px-3 d-inline-block"
                                                                            data-comment-id="<?= $reply->comment_id ?>"
                                                                            data-username="<?= htmlspecialchars($reply->user->username ?? 'Anonymous') ?>">
                                                                            <span class="fw-bold">Trả lời</span>
                                                                        </button>


                                                                        <!-- Delete options (hidden initially) -->
                                                                        @if (auth()->check() && auth()->id() === $comment->user_id)
                                                                            <div id="delete-options-{{ $reply->comment_id }}"
                                                                                class="delete-options"
                                                                                style="display: none;">
                                                                                <form method="POST"
                                                                                    action="{{ route('comments.destroy', $reply->comment_id) }}"
                                                                                    class="d-inline-block">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-danger btn-sm">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                        Xóa
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        @endif
                                                                        <script>
                                                                            function confirmDelete(event, commentId) {
                                                                                event.preventDefault(); // Prevent the default form submission behavior

                                                                                // Ask for confirmation
                                                                                if (confirm("Bạn có chắc chắn muốn xóa bình luận này không?")) {
                                                                                    // If confirmed, submit the form
                                                                                    var form = document.querySelector(`#delete-options-${commentId} form`);
                                                                                    if (form) {
                                                                                        form.submit(); // Submit the form to delete the comment
                                                                                    }
                                                                                }
                                                                            }
                                                                        </script>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $index++; ?>
                                                        <?php endforeach; ?>
                                                        <?php if ($replyCount > $visibleReplies): ?>
                                                        <button
                                                            class="btn btn-link text-primary px-0 show-more-replies text-decoration-none">Xem
                                                            thêm</button>
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
                                                                    <img src="{{ $currentUser->image ?? asset('https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg') }}"
                                                                        alt="Your Avatar">
                                                                </div>

                                                                <div class="w-100">
                                                                    <!-- Ô nhập nội dung trả lời -->
                                                                    <textarea class="form-control form-control-sm reply-content" name="content" rows="2" required
                                                                        data-username="@{{ $comment - > user - > username ?? 'Anonymous' }}" placeholder="Trả lời: ..." onclick="addUsernameToReply(this)">
                                                                </textarea>


                                                                    <script>
                                                                        function addUsernameToReply(textarea, commentId) {
                                                                            console.log("Textarea clicked for comment ID: " + commentId);

                                                                            fetch(`/get-username-by-comment-id/${commentId}`)
                                                                                .then(response => response.json())
                                                                                .then(data => {
                                                                                    let username = data.username ?? 'Người dùng ẩn danh';
                                                                                    username = '@' + username.trim();

                                                                                    // Luôn đặt lại nội dung với @username ở đầu
                                                                                    let currentText = textarea.value.trim();
                                                                                    textarea.value = username + ' ' + currentText;

                                                                                    console.log("Inserted username:", username);
                                                                                    textarea.focus();
                                                                                })
                                                                                .catch(error => {
                                                                                    console.error('Error fetching username:', error);
                                                                                });
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
        <!-- ====== end comments ====== -->



        <!-- ====== start another posts ====== -->
        <section class="another-news" style="padding-top: 100px">
            <div class="container">
                <div class="content pt-50 pb-50 border-1 border-top border-dark">
                    <div class="row">
                        <div class="col-lg-4 mb-5 mb-lg-0">
                            <a href="" class="color-000 text-uppercase mb-30 ltspc-1"> Xem thêm từ tác giả này
                                <i class="la la-angle-right ms-1"></i>
                            </a>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    @if ($relatedAuthorArticles->isNotEmpty())
                                        {{-- Bài đầu tiên --}}
                                        <div class="tc-post-grid-default">
                                            @php $firstArticle = $relatedAuthorArticles->shift(); @endphp
                                            <div class="item">
                                                <div class="img img-cover th-250">
                                                    <img src="{{ asset('storage/' . $firstArticle->thumbnail_url) }}"
                                                        alt="{{ $firstArticle->title }}">
                                                </div>
                                                <div class="content pt-20">
                                                    <a href="#"
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                        {{ $firstArticle->category->name ?? 'Uncategorized' }}
                                                    </a>
                                                    <h4 class="title ltspc--1 mb-10">
                                                        <a
                                                            href="{{ Auth::check() ? route('articles.article', $firstArticle->slug) : url('/login-user') }}">
                                                            {{ $firstArticle->title }}
                                                        </a>
                                                    </h4>
                                                    <div class="text color-666">
                                                        {{ Str::limit($firstArticle->preview_content, 100, '...') }}
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-20">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="#"><i class="la la-calendar me-2"></i>
                                                                    {{ $firstArticle->created_at->format('M d, Y') }}</a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="#"><i class="la la-comment me-2"></i>
                                                                    {{ $firstArticle->comments_count }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Các bài còn lại --}}
                                        <div class="tc-post-list-style2">
                                            <div class="items">
                                                @foreach ($relatedAuthorArticles->skip(1)->take(2) as $article)
                                                    <a href="{{ Auth::check() ? route('articles.article', $article->slug) : url('/login-user') }}"
                                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15">
                                                        <div class="row gx-3 align-items-center">
                                                            <div class="col-4">
                                                                <div class="img th-70 img-cover">
                                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) ?? 'default-image.jpg' }}"
                                                                        alt="{{ $article->title }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="content">
                                                                    <small
                                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                                        {{ $article->category->name ?? 'Uncategorized' }}
                                                                    </small>
                                                                    <h5 class="title ltspc--1">
                                                                        {{ $article->title }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">Hiện tại chưa có bài viết nào.</p>
                                    @endif
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 mb-5 mb-lg-0">
                            <a href="page-blog.html" class="color-000 text-uppercase mb-30 ltspc-1">
                                {{ $article->category->name }} <i class="la la-angle-right ms-1"></i> </a>
                            <div class="row">
                                <div class="col-12 border-1 border-end brd-gray">
                                    @if ($relatedCategoryArticles->isNotEmpty())
                                        <div class="tc-post-grid-default">
                                            @if ($relatedCategoryArticles->isNotEmpty())
                                                @php $firstRelated = $relatedCategoryArticles->first(); @endphp
                                                <div class="item">
                                                    <div class="img img-cover th-250">
                                                        <img src="{{ asset('storage/' . $firstRelated->thumbnail_url) }}"
                                                            alt="{{ $firstRelated->title }}">
                                                    </div>
                                                    <div class="content pt-20">
                                                        <a href="{{ Auth::check() ? route('articles.article', $firstRelated->slug) : url('/login-user') }}"
                                                            class="item d-block">
                                                            {{ $firstRelated->category->name ?? 'Uncategorized' }}
                                                        </a>
                                                        <h4 class="title ltspc--1 mb-10">
                                                            <a href="{{ Auth::check() ? route('articles.article', $firstRelated->slug) : url('/login-user') }}"
                                                                class="item d-block">
                                                                {{ $firstRelated->title }}
                                                            </a>
                                                        </h4>
                                                        <div class="text color-666">
                                                            {{ Str::limit($firstRelated->preview_content, 100, ' [...]') }}
                                                        </div>
                                                        <div class="meta-bot lh-1 mt-20">
                                                            <ul class="d-flex">
                                                                <li class="date me-5">
                                                                    <a href="{{ Auth::check() ? route('articles.article', $firstRelated->slug) : url('/login-user') }}"
                                                                        class="item d-block">
                                                                        <i class="la la-calendar me-2"></i>
                                                                        {{ $firstRelated->created_at->format('M d, Y') }}
                                                                    </a>
                                                                </li>
                                                                <li class="comment">
                                                                    <a href="{{ Auth::check() ? route('articles.article', $firstRelated->slug) : url('/login-user') }}"
                                                                        class="item d-block">
                                                                        <i class="la la-comment me-2"></i>
                                                                        {{ $firstRelated->comments_count ?? 0 }}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="tc-post-list-style2">
                                            <div class="items">
                                                @foreach ($relatedCategoryArticles->skip(1)->take(2) as $related)
                                                    <a href="{{ Auth::check() ? route('articles.article', $related->slug) : url('/login-user') }}"
                                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15 brd-gray">
                                                        <div class="row gx-3 align-items-center">
                                                            <div class="col-4">
                                                                <div class="img th-70 img-cover">
                                                                    <img src="{{ asset('storage/' . $related->thumbnail_url) ?? 'default-thumbnail.jpg' }}"
                                                                        alt="{{ $related->title }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="content">
                                                                    <small
                                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">{{ $related->category->name ?? 'Uncategorized' }}</small>
                                                                    <h5 class="title ltspc--1">
                                                                        {{ $related->title }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">Hiện tại chưa có bài viết nào.</p>
                                    @endif
                                </div>

                            </div>
                        </div>


                        <div class="col-lg-4">
                            <a href="page-blog.html" class="color-000 text-uppercase mb-30 ltspc-1"> Khuyến cáo <i
                                    class="la la-angle-right ms-1"></i> </a>
                            <div class="row">
                                <div class="col-12">
                                    @if ($khuyencao->isNotEmpty())
                                        {{-- Hiển thị bài viết nổi bật đầu tiên --}}
                                        <div class="tc-post-grid-default">
                                            @php
                                                $firstArticle = $khuyencao->shift();
                                            @endphp
                                            <div class="item">
                                                <div class="img img-cover th-250">
                                                    <img src="{{ asset('storage/' . $firstArticle->thumbnail_url) }}"
                                                        alt="{{ $firstArticle->title }}">
                                                </div>
                                                <div class="content pt-20">
                                                    <a href="{{ route('articles.article', $firstArticle->slug) }}"
                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                        {{ $firstArticle->category->name ?? 'Uncategorized' }}
                                                    </a>
                                                    <h4 class="title ltspc--1 mb-10">
                                                        <a href="{{ route('articles.article', $firstArticle->slug) }}">
                                                            {{ $firstArticle->title }}
                                                        </a>
                                                    </h4>
                                                    <div class="text color-666">
                                                        {{ Str::limit($firstArticle->preview_content, 100, '...') }}
                                                    </div>
                                                    <div class="meta-bot lh-1 mt-20">
                                                        <ul class="d-flex">
                                                            <li class="date me-5">
                                                                <a href="#">
                                                                    <i class="la la-calendar me-2"></i>
                                                                    {{ $firstArticle->created_at->format('M d, Y') }}
                                                                </a>
                                                            </li>
                                                            <li class="comment">
                                                                <a href="#">
                                                                    <i class="la la-comment me-2"></i>
                                                                    {{ $firstArticle->comments_count }}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Hiển thị các bài còn lại ở dạng danh sách --}}
                                        <div class="tc-post-list-style2">
                                            <div class="items">
                                                @foreach ($khuyencao->skip(1)->take(2) as $article)
                                                    <a href="{{ route('articles.article', $article->slug) }}"
                                                        class="item d-block border-1 border-top border-bottom-0 brd-gray pt-15 mt-15">
                                                        <div class="row gx-3 align-items-center">
                                                            <div class="col-4">
                                                                <div class="img th-70 img-cover">
                                                                    <img src="{{ asset('storage/' . $article->thumbnail_url) }}"
                                                                        alt="{{ $article->title }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="content">
                                                                    <small
                                                                        class="news-cat color-999 fsz-13px text-uppercase mb-10">
                                                                        {{ $article->category->name ?? 'Uncategorized' }}
                                                                    </small>
                                                                    <h5 class="title ltspc--1">
                                                                        {{ $article->title }}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-center text-muted">Hiện tại chưa có bài viết nào !</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ====== start another posts ====== -->





        <!-- ====== start modals ====== -->

        <div class="offcanvas offcanvas-start sidebar-popup-style1" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <h1>News24h</h1>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mt-4">
                <h6 class="color-000 text-uppercase mb-15 ltspc-1 fw-bold"> Giới Thiệu News24h <i
                        class="la la-angle-right ms-1"></i>
                </h6>
                <div class="text mb-4">
                    News24h là nền tảng tin tức hàng đầu Việt Nam, cung cấp thông tin chính xác, đa dạng và cập nhật 24/7.
                    Chúng tôi cam kết mang đến cho độc giả những tin tức chất lượng và đáng tin cậy từ mọi lĩnh vực.
                </div>

                <div class="mt-4">
                    <h6 class="color-000 mb-3 fw-bold">Tại sao chọn News24h?</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-newspaper-o text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Tin tức chính xác, đa chiều</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-bolt text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cập nhật tin tức 24/7</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box me-3 bg-light rounded p-2" style="color: var(--bs-primary);">
                            <i class="la la-users text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Cộng đồng độc giả lớn mạnh</p>
                        </div>
                    </div>
                </div>

                <div class="sidebar-contact-info mt-4 pt-4 border-top">
                    <h6 class="color-000 text-uppercase mb-20 ltspc-1 fw-bold"> Liên Hệ & Theo Dõi <i
                            class="la la-angle-right ms-1"></i> </h6>
                    <ul class="m-0">
                        <li class="mb-3">
                            <i class="las la-map-marker me-2 color-main fs-5"></i>
                            <a href="#">Tòa nhà FPT Polytechnic., Cổng số 2, 13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ
                                Liêm, Hà Nội</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-envelope me-2 color-main fs-5"></i>
                            <a href="#">bayanhtai@gmail.com</a>
                        </li>
                        <li class="mb-3">
                            <i class="las la-phone-volume me-2 color-main fs-5"></i>
                            <a href="#">0981 725 836</a>
                        </li>
                    </ul>
                    <div class="social-links mt-3">
                        <a href="#" class="me-2">
                            <i class="la la-twitter"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-facebook-f"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-instagram"></i>
                        </a>
                        <a href="#" class="me-2">
                            <i class="la la-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ====== end modals ====== -->

        <!-- Modal báo cáo bài viết -->
        <div id="reportArticleModal" class="modal fade" tabindex="-1" aria-labelledby="reportArticleLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="reportArticleLabel">Báo cáo bài viết</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="report-article-id">
                        <div class="mb-3">
                            <label for="report-article-reason" class="form-label">Lý do báo cáo:</label>

                            <!-- Gợi ý (Cách đều với textarea) -->
                            <div class="mt-2 mb-2 d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary suggestion">Nội dung không phù hợp</span>
                                <span class="badge bg-secondary suggestion">Spam hoặc lừa đảo</span>
                                <span class="badge bg-secondary suggestion">Thông tin sai lệch</span>
                                <span class="badge bg-secondary suggestion">Ngôn từ kích động</span>
                            </div>

                            <!-- Textarea nhập lý do -->
                            <textarea id="report-article-reason" class="form-control" rows="4"
                                placeholder="Nhập lý do hoặc chọn từ danh sách gợi ý..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirmReportArticle">Gửi báo cáo</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".suggestion").forEach(item => {
                    item.addEventListener("click", function() {
                        let textarea = document.getElementById("report-article-reason");
                        let reason = this.textContent;

                        // Nếu textarea chưa có nội dung, đặt giá trị mới
                        if (!textarea.value) {
                            textarea.value = reason;
                        } else {
                            // Nếu đã có nội dung, thêm xuống dòng để không ghi đè
                            textarea.value += "\n" + reason;
                        }
                    });
                });
            });
        </script>


        <!-- Modal nhập lý do RepostComment -->
        <div id="repostModal" class="modal fade" tabindex="-1" aria-labelledby="repostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="repostModalLabel">
                            <i class="fas fa-retweet me-2"></i> Repost bình luận
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="repost-comment-id">
                        <div class="mb-3">
                            <label for="repost-reason" class="form-label fw-bold">Lý do repost :</label>
                            <div class="mt-2 mb-2 d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary suggestion">Bình luận vi phạm</span>
                                <span class="badge bg-secondary suggestion">Ngôn từ xúc phạm</span>
                                <span class="badge bg-secondary suggestion">Spam hoặc quảng cáo</span>
                                <span class="badge bg-secondary suggestion">Thông tin sai lệch</span>
                            </div>

                            <!-- Textarea nhập lý do -->
                            <textarea id="repost-reason" class="form-control border-primary shadow-sm" rows="4"
                                placeholder="Nhập nội dung repost ..."></textarea>

                            <!-- Gợi ý ngay bên dưới textarea -->

                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" id="confirmRepost">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".suggestion").forEach(item => {
                    item.addEventListener("click", function() {
                        let textarea = document.getElementById("repost-reason");
                        let reason = this.textContent;

                        // Nếu textarea chưa có nội dung, đặt giá trị mới
                        if (!textarea.value) {
                            textarea.value = reason;
                        } else {
                            // Nếu đã có nội dung, thêm xuống dòng để không ghi đè
                            textarea.value += "\n" + reason;
                        }
                    });
                });
            });
        </script>


        <!-- ====== end Related products ====== -->
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let likeButton = document.getElementById("likeButton");
            let likeCount = document.getElementById("likeCount");
            let likeIcon = document.getElementById("likeIcon");

            likeButton.addEventListener("click", function() {
                let articleId = likeButton.getAttribute("data-article-id");
                let isLiked = likeButton.getAttribute("data-liked") === "true";

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
                            likeCount.textContent = data.likeCount;

                            if (data.liked) {
                                likeIcon.classList.remove("fa-regular");
                                likeIcon.classList.add("fa-solid");
                                likeIcon.style.color = "#e60023";
                            } else {
                                likeIcon.classList.remove("fa-solid");
                                likeIcon.classList.add("fa-regular");
                                likeIcon.style.color = "black";
                            }
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
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
                            alert("Lỗi khi gửi comment có thể là do có những từ không chuẩn đạo đức !");
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




        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Script loaded!");
            let buttons = document.querySelectorAll(".send-reply");
            console.log("Found", buttons.length, "send-reply buttons");

            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    console.log("Clicked send-reply button!");
                    let commentId = this.getAttribute("data-comment-id");
                    let articleId = this.getAttribute("data-article-id");
                    let replyForm = document.querySelector(`#reply-form-${commentId} .reply-form`);
                    let content = replyForm.querySelector(".reply-content").value.trim();

                    console.log("articleId =", articleId, "commentId =", commentId);
                    console.log("content =", content);

                    // Kiểm tra xem form có input CSRF hay meta CSRF không
                    let csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute(
                        "content");

                    if (content === "") {
                        alert("Vui lòng nhập nội dung bình luận!");
                        return;
                    }

                    fetch(`/articles/${articleId}/comments/${commentId}/reply`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: JSON.stringify({
                                content: content,
                                article_id: articleId,
                                parent_id: commentId
                            })
                        })
                        .then(response => {
                            console.log("Response status:", response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log("Server data:", data);
                            if (data.success) {
                                // Reload trang
                                location.reload();
                            } else {
                                alert(data.message || "Có lỗi xảy ra, vui lòng thử lại!");
                            }
                        })
                        .catch(error => {
                            console.error("Lỗi khi gửi bình luận:", error);
                            alert("Lỗi khi gửi bình luận!");
                        });
                });
            });
        });
    </script>


    {{-- TungKeng làm tìm comment --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.location.hash) {
                let target = document.querySelector(window.location.hash);
                if (target) {
                    setTimeout(() => {
                        let offset = 400; // Điều chỉnh khoảng cách (px) tùy theo giao diện
                        let elementPosition = target.getBoundingClientRect().top + window.scrollY;
                        window.scrollTo({
                            top: elementPosition - offset,
                            behavior: "smooth"
                        });
                    }, 500);
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mở modal báo cáo bài viết khi nhấn vào nút có class .report-article-btn
            document.querySelectorAll(".report-article-btn").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định nếu button hoặc link
                    let articleId = this.getAttribute("data-article-id");
                    console.log("Article ID:", articleId); // Debug: kiểm tra giá trị articleId
                    if (!articleId) {
                        console.error("Không tìm thấy article id!");
                        return;
                    }

                    document.getElementById("report-article-id").value = articleId;

                    document.getElementById("report-article-reason").value = "";
                    new bootstrap.Modal(document.getElementById("reportArticleModal")).show();
                });
            });

            // Gửi báo cáo bài viết khi nhấn nút "Gửi báo cáo"
            document.getElementById("confirmReportArticle").addEventListener("click", function(event) {
                event.preventDefault();
                let articleId = document.getElementById("report-article-id").value;
                let reason = document.getElementById("report-article-reason").value.trim();

                // Kiểm tra giá trị articleId
                if (!articleId) {
                    console.error("Không tìm thấy article id trước khi gửi request!");
                    return;
                }

                fetch(`/articles/${articleId}/report`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            reason: reason
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch(error => console.error("Lỗi:", error));
            });
        });
    </script>

    <script>
        //reportcommet
        document.addEventListener("DOMContentLoaded", function() {
            // Khi nhấn nút Repost, hiển thị modal và prefill nội dung ban đầu
            document.querySelectorAll(".repost-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let commentId = this.getAttribute("data-comment-id");
                    let content = this.getAttribute("data-content");

                    document.getElementById("repost-comment-id").value = commentId;
                    // ✅ Xóa nội dung lý do báo cáo cũ nếu có
                    document.getElementById("repost-reason").value = "";


                    let modal = new bootstrap.Modal(document.getElementById("repostModal"));
                    modal.show();
                });
            });

            // Khi người dùng xác nhận Repost
            document.getElementById("confirmRepost").addEventListener("click", function() {
                let commentId = document.getElementById("repost-comment-id").value;
                let reason = document.getElementById("repost-reason").value.trim();
                // Lấy article_id từ meta tag
                let articleMeta = document.querySelector("meta[name='article-id']");
                if (!articleMeta || !articleMeta.getAttribute("content")) {
                    console.error("Không tìm thấy article ID!");
                    return;
                }
                let articleId = articleMeta.getAttribute("content").trim();

                // Gửi request đến route: /articles/{article_id}/comments/{comment_id}/repost
                fetch(`/articles/${articleId}/comments/${commentId}/report`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            reason: reason
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Repost thành công!");
                            location.reload();
                        } else {
                            alert("Repost thất bại: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi fetch:", error);
                        alert("Có lỗi xảy ra khi repost!");
                    });
            });
        });
    </script>
@endsection

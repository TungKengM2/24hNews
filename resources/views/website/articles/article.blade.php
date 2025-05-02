@extends('website.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="article-id" content="{{ $article->article_id }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Thêm Toastify vào head của trang -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.11.2/toastify.min.js"></script>


    <!-- CSS Tùy chỉnh -->
    <style>
        /* Áp dụng cho cả hai chế độ: reset nền trắng của TinyMCE */
        .content1 * {
            background-color: transparent !important;
        }

        /* Chỉ khi nền dark: ép màu chữ trắng để dễ đọc */
        body.dark-theme .content1 * {
            color: #ffffff !important;
        }





        .show-more-replies-btn {
            text-decoration: none !important;
            /* Gỡ gạch chân */
            color: #0d6efd;
            /* Màu chữ mặc định (Bootstrap primary) */
            font-weight: bold;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .show-more-replies-btn:hover {
            color: white !important;
            /* Chữ trắng khi hover */
            background-color: #0d6efd;
            /* Tùy: có thể thêm nền xanh khi hover */
            border-radius: 4px;
            padding: 2px 6px;
            text-decoration: none !important;
            /* Chắc chắn gỡ underline luôn */
        }

        .btn.like-btn {
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
        }

        .like-text,
        .like-count {
            font-weight: bold;
            color: #6c757d;
            /* Màu xám mặc định */
            transition: color 0.3s;
        }

        .like-text.liked,
        .like-count.liked {
            color: #007bff;
            /* Màu xanh khi đã like */
        }

        .like-count.liked {
            color: #1877F2;
            transition: color 0.2s ease;
        }
    </style>
    <style>
        .reply-item {
            position: relative;
        }

        .reply-item .thread-line {
            position: absolute;
            top: 40px;
            left: 18px;
            width: 2px;
            height: calc(100% - 40px);
            background: #e0e0e0;
            z-index: 0;
        }

        .reply-avatar img {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border-radius: 50%;
        }

        .reply-box {
            background: #f0f2f5;
            border-radius: 18px;
            padding: 10px 15px;
            margin-left: 10px;
            display: inline-block;
            max-width: 90%;
        }

        .reply-meta {
            font-size: 13px;
            color: #65676b;
        }

        .reply-actions {
            font-size: 13px;
            margin-top: 5px;
            color: #65676b;
        }

        .reply-actions button {
            background: transparent;
            border: none;
            color: #65676b;
            cursor: pointer;
            padding: 0 6px;
        }

        .reply-actions button:hover {
            text-decoration: underline;
        }
    </style>
    <style>
        .small-action-buttons button {
            font-family: 'Arial', sans-serif;
            /* Đảm bảo font chung */
            font-size: 14px;
            /* Kích thước chữ đồng đều */
            font-weight: 600;
            /* Đảm bảo chữ đậm giống nhau */
            text-transform: none;
            /* Ngừng chuyển chữ thành in hoa nếu có */
        }

        /* Đảm bảo các nút có cùng kiểu chữ và định dạng */
        .small-action-buttons button {
            font-family: 'Arial', sans-serif;
            /* Font chữ chung */
            font-size: 14px;
            /* Kích thước chữ đồng đều */
            font-weight: 600;
            /* Đảm bảo chữ đậm giống nhau */
            text-transform: none;
            /* Không tự động chuyển chữ thành in hoa */
        }

        /* Đảm bảo các nút không bị chênh lệch với padding */
        .small-action-buttons button.btn {
            padding: 0;
        }


        .reply-content-box {
            background-color: #f0f2f5;
            /* Light background, like Facebook's comment section */
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            /* Rounded corners */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            /* Light shadow for depth */
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .reply-username {
            font-weight: bold;
            color: #1c1e21;
            /* Dark text for the username */
        }

        .reply-meta {
            font-size: 12px;
            color: #65676b;
            /* Light grey for the date */
            text-align: right;
        }

        .mt-1 {
            font-size: 14px;
            /* Standard size for the content */
            color: #1c1e21;
            /* Dark text for the content */
        }

        .reply-meta,
        .reply-username {
            display: inline-block;
        }

        .comment-reply-cont {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .icon-60 img,
        .icon-40 img {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border-radius: 50%;
        }

        .reply-item {
            position: relative;
        }

        .reply-item .thread-line {
            position: absolute;
            top: 40px;
            left: 18px;
            width: 2px;
            height: calc(100% - 40px);
            background: #e0e0e0;
            z-index: 0;
        }

        .reply-content-box {
            background: #f0f2f5;
            border-radius: 18px;
            padding: 10px 15px;
            display: inline-block;
            max-width: 100%;
            word-break: break-word;
        }

        .reply-meta {
            font-size: 13px;
            color: #65676b;
        }

        .reply-actions {
            font-size: 13px;
            margin-top: 5px;
            color: #65676b;
        }

        .reply-actions button {
            background: transparent;
            border: none;
            color: #65676b;
            cursor: pointer;
            padding: 0 6px;
        }

        .reply-actions button:hover {
            text-decoration: underline;
        }

        .r {
            font-size: 14px;

        }
    </style>


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
                        <div class="col-lg-8">
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
                                        {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d \t\há\n\g m, Y') }}
                                    </a>
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
                        <div class="col-lg-4" style="margin-top: -4px; margin-left: -200px">
                            <div class="links-side color-000 fsz-13px">
                                {{-- <span class="me-40 d-flex align-items-center">
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
                                </span> --}}
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
                                        style="font-size: 28px; {{ $isLiked ? 'color: #e60023;' : 'color: #777777;' }}">
                                    </i>
                                    <span id="likeCount"
                                        style="font-size: 14px; font-weight: bold; color: {{ $isLiked ? '#e60023' : '#777777' }};">
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
                            <div class="content1">
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
        {{-- <section class="banner18">
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
        </section> --}}
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
                                            <a href="{{ route('tags.shows', ['tag' => $tag->tag_id]) }}"
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
                                                    <p class="text-uppercase"> Bình Luận</p>
                                                </div>

                                            </div>
                                        </div>

                                        <br>
                                        <?php foreach ($comments as $comment): ?>
                                        <?php if (!$comment->parent_id): ?>
                                        <div class="comment-reply-cont bg-white py-3 px-4 mb-3 rounded shadow-sm">
                                            <div class="d-flex align-items-start">
                                                <!-- Avatar -->
                                                <div class="icon-60 rounded-circle img-cover me-3 flex-shrink">
                                                    <img src="<?= !empty($comment->user->image) ? asset('storage/' . $comment->user->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>"
                                                        alt="User Avatar">
                                                </div>
                                                <!-- Nội dung comment -->
                                                <div class="inf w-100">
                                                    <div class="reply-content-box">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="fw-bold mb-0">
                                                                <a
                                                                    href="{{ route('website.profileAuth', ['id' => $comment->user->user_id]) }}">
                                                                    <?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>
                                                                </a>
                                                            </h6>
                                                        </div>
                                                        <div id="comment-<?= $comment->comment_id ?>"
                                                            class="text color-000 fs-14px mt-2">
                                                            <?= nl2br(htmlspecialchars($comment->content)) ?>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="mt-2 d-flex align-items-center flex-wrap gap-3 small-action-buttons">
                                                        <button type="button"
                                                            class="btn btn-link p-0 text-decoration-none text-gray reply-btn"
                                                            data-comment-id="{{ $comment->comment_id }}"
                                                            data-username="{{ '@' . ($comment->user->username ?? 'Anonymous') }}"
                                                            data-article-id="<?= $comment->article_id ?>"
                                                            onclick="openReplyModal(this)">
                                                            <span class="fw-bold">Trả lời</span>
                                                        </button>


                                                        <!-- Nút Like -->
                                                        <button type="button" class="btn like-btn"
                                                            data-comment-id="{{ $comment->comment_id }}">
                                                            <span
                                                                class="like-text @if ($comment->likesUsers->contains(auth()->id())) text-primary @endif">
                                                                Thích
                                                            </span>
                                                        </button>


                                                        @if (auth()->check() && auth()->id() === $comment->user_id)
                                                            <form method="POST"
                                                                action="{{ route('comments.destroy', $comment->comment_id) }}"
                                                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');"
                                                                class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-link p-0 text-decoration-none text-gray fw-bold">
                                                                    Xóa
                                                                </button>
                                                            </form>
                                                        @else
                                                            <?php if ($comment->user_id !== auth()->id()): ?>
                                                            <button type="button"
                                                                class="btn btn-link p-0 text-decoration-none text-gray repost-btn fw-bold"
                                                                data-comment-id="{{ $comment->comment_id }}"
                                                                data-content="<?= htmlspecialchars($comment->content, ENT_QUOTES, 'UTF-8') ?>"
                                                                title="Báo cáo bình luận này">
                                                                Báo cáo
                                                            </button>
                                                            <?php endif; ?>
                                                        @endif
                                                        <div class="reply-meta text-muted small">
                                                            <?= time_ago($comment->created_at) ?>
                                                        </div>
                                                        <!-- Hiển thị icon + số lượt like -->
                                                        <span id="like-count-{{ $comment->comment_id }}"
                                                            class="like-count @if ($comment->likesUsers->contains(auth()->id())) liked @endif">
                                                            @if ($comment->likes > 0)
                                                                <i class="fas fa-thumbs-up"></i> {{ $comment->likes }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <!-- Danh sách replies -->
                                                    <div class="replies  mt-3"
                                                        data-reply-count="<?= count($comment->replies) ?>">
                                                        <?php
                                                        $replyCount = count($comment->replies);
                                                        $visibleReplies = 0;
                                                        $index = 0;
                                                        ?>
                                                        <?php foreach ($comment->replies as $reply): ?>
                                                        <div
                                                            class="reply-item d-flex mb-3 position-relative <?= $index >= $visibleReplies ? 'd-none' : '' ?>">
                                                            <!-- Avatar và Line -->
                                                            <div class="position-relative me-2">
                                                                <div
                                                                    class="icon-40 rounded-circle img-cover overflow-hidden">
                                                                    <img src="<?= $reply->user->image ? asset('storage/' . $reply->user->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>"
                                                                        alt="User Avatar">
                                                                </div>
                                                                <?php if ($index < $replyCount - 1): ?>
                                                                <div class="thread-line"></div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <!-- Nội dung reply -->
                                                            <div class="flex-grow-1">
                                                                <div class="reply-content-box">
                                                                    <div class="reply-header">
                                                                        <strong class="reply-username">
                                                                            <?= htmlspecialchars($reply->user->username ?? 'Người dùng ẩn danh') ?>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="mt-1">
                                                                        <?= nl2br(htmlspecialchars($reply->content)) ?>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="mt-2 d-flex align-items-center flex-wrap gap-3 small-action-buttons">
                                                                    <button type="button"
                                                                        class="btn btn-link p-0 text-decoration-none text-gray reply-btn"
                                                                        data-comment-id="{{ $reply->comment_id }}"
                                                                        data-username="{{ '@' . ($reply->user->username ?? 'Anonymous') }}"
                                                                        data-article-id="<?= $reply->article_id ?>"
                                                                        onclick="openReplyModal(this)">
                                                                        <span class="fw-bold">Trả lời</span>
                                                                    </button>
                                                                    <!-- Nút Like -->
                                                                    <button type="button" class="btn like-btn"
                                                                        data-comment-id="{{ $reply->comment_id }}">
                                                                        <span
                                                                            class="like-text @if ($reply->likesUsers->contains(auth()->id())) text-primary @endif">
                                                                            Thích
                                                                        </span>
                                                                    </button>
                                                                    @if (auth()->check() && auth()->id() === $reply->user_id)
                                                                        <form method="POST"
                                                                            action="{{ route('comments.destroy', $reply->comment_id) }}"
                                                                            onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');"
                                                                            class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-link p-0 text-decoration-none text-gray">
                                                                                <span class="fw-bold">Xóa</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <?php if ($reply->user_id !== auth()->id()): ?>
                                                                        <button type="button"
                                                                            class="btn btn-link p-0 text-decoration-none text-gray repost-btn fw-bold"
                                                                            data-comment-id="{{ $reply->comment_id }}"
                                                                            data-content="<?= htmlspecialchars($reply->content, ENT_QUOTES, 'UTF-8') ?>"
                                                                            title="Báo cáo bình luận này">
                                                                            Báo cáo
                                                                        </button>
                                                                        <?php endif; ?>
                                                                    @endif
                                                                    <div class="reply-meta text-muted small">
                                                                        <?= time_ago($reply->created_at) ?>
                                                                    </div>
                                                                    <!-- Hiển thị icon + số lượt like -->
                                                                    <span id="like-count-{{ $reply->comment_id }}"
                                                                        class="like-count @if ($reply->likesUsers->contains(auth()->id())) liked @endif">
                                                                        @if ($reply->likes > 0)
                                                                            <i class="fas fa-thumbs-up"></i>
                                                                            {{ $reply->likes }}
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <!-- Sub-replies -->
                                                                <div class="sub-replies mt-2 ms-5">

                                                                    @include('components.sub-reply', [])
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php $index++; ?>
                                                        <?php endforeach; ?>

                                                        <?php if ($replyCount > $visibleReplies): ?>
    <button
        class="btn btn-link p-0 text-primary fw-bold show-more-replies-btn mt-2"
        onclick="toggleReplies(this)"
        data-collapsed="true"
        data-replies-container-id="replies-container-{{ $comment->comment_id }}">
        Xem thêm
    </button>
<?php endif; ?>

<script>
    function toggleReplies(button) {
        const repliesContainer = button.closest('.replies');
        const allReplies = repliesContainer.querySelectorAll('.reply-item');
        const isCollapsed = button.getAttribute('data-collapsed') === 'true';
        const visibleCount = 0; // Set this to the number of replies you want visible initially (0 hides all)

        if (isCollapsed) {
            // Show all replies
            allReplies.forEach(reply => reply.classList.remove('d-none'));
            button.innerText = 'Thu gọn'; // Change button text to "Collapse"
            button.setAttribute('data-collapsed', 'false'); // Update the collapsed state
        } else {
            // Hide extra replies
            allReplies.forEach((reply, index) => {
                if (index >= visibleCount) {
                    reply.classList.add('d-none'); // Hide replies exceeding the visibleCount
                }
            });
            button.innerText = 'Xem thêm'; // Change button text to "Show more"
            button.setAttribute('data-collapsed', 'true'); // Update the collapsed state
        }
    }
</script>


                                                    </div>
                                                    <!-- End danh sách replies -->
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; ?>





                                        <script>
                                            function toggleDeleteOptions(commentId) {
                                                const options = document.getElementById('delete-options-' + commentId);
                                                options.style.display = (options.style.display === 'none') ? 'block' : 'none';
                                            }
                                        </script>
                                        <script>
                                            function confirmDelete(event, commentId) {
                                                event.preventDefault();
                                                if (confirm("Bạn có chắc chắn muốn xóa bình luận này không?")) {
                                                    var form = document.querySelector(`#delete-options-${commentId} form`);
                                                    if (form) {
                                                        form.submit();
                                                    }
                                                }
                                            }
                                        </script>



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

        <!-- Modal dùng chung cho Reply -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-sm">
                    <!-- Form bao bọc toàn bộ modal -->
                    <form id="replyForm">
                        @csrf
                        <!-- Các trường ẩn để lưu comment_id và article_id -->
                        <input type="hidden" name="comment_id" value="">
                        <input type="hidden" name="article_id" value="">
                        <!-- Modal Header -->
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="replyModalLabel">Trả lời</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="d-flex align-items-start bg-light p-3 rounded shadow-sm mb-3">
                                <!-- Ảnh đại diện của user hiện tại -->
                                <div class="icon-40 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                                    <img src="{{ $currentUser->image ?? asset('https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg') }}"
                                        alt="Your Avatar" class="w-100 h-100">
                                </div>
                                <!-- Nội dung reply -->
                                <div class="w-100">
                                    <textarea id="replyTextarea" class="form-control border-0 shadow-none p-2" name="content" rows="4" required
                                        placeholder="Nhập nội dung trả lời..."></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                            <!-- Nút gửi sẽ không có data-bs-dismiss, modal sẽ được đóng sau khi gửi thành công -->
                            <button type="button" class="btn btn-primary send-reply">Gửi trả lời</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript: Hàm mở modal và cập nhật dữ liệu từ button -->
        <script>
            // Hàm mở modal và cập nhật dữ liệu từ button "Trả lời"
            function openReplyModal(button) {
                // Lấy các giá trị từ thuộc tính data của button
                const username = button.getAttribute('data-username');
                const commentId = button.getAttribute('data-comment-id');
                const articleId = button.getAttribute('data-article-id') || '';

                // Cập nhật tiêu đề modal (vd: "Trả lời @username")
                document.getElementById('replyModalLabel').innerText = "Trả lời " + username;

                // Reset nội dung textarea với @username và focus
                const textarea = document.getElementById('replyTextarea');
                if (textarea) {
                    textarea.value = username + ' ';
                    textarea.focus();
                }

                // Cập nhật giá trị các input ẩn trong form
                const replyForm = document.getElementById('replyForm');
                replyForm.querySelector("input[name='comment_id']").value = commentId;
                replyForm.querySelector("input[name='article_id']").value = articleId;

                // Hiển thị modal sử dụng Bootstrap
                const replyModalEl = document.getElementById('replyModal');
                const replyModal = new bootstrap.Modal(replyModalEl);
                replyModal.show();
            }

            // Xử lý gửi bình luận qua AJAX khi nhấn nút "Gửi trả lời" trong modal
            document.addEventListener("DOMContentLoaded", function() {
                console.log("Script loaded!");
                let sendReplyBtn = document.querySelector("#replyModal .send-reply");
                console.log("Found send-reply button", sendReplyBtn);

                if (sendReplyBtn) {
                    sendReplyBtn.addEventListener("click", function() {
                        console.log("Clicked send-reply button!");
                        let replyForm = document.getElementById("replyForm");
                        let commentId = replyForm.querySelector("input[name='comment_id']").value;
                        let articleId = replyForm.querySelector("input[name='article_id']").value;
                        let content = replyForm.querySelector("textarea[name='content']").value.trim();

                        console.log("articleId =", articleId, "commentId =", commentId);
                        console.log("content =", content);

                        // Lấy CSRF token từ meta
                        let csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute(
                            "content");

                        if (content === "") {
                            alert("Vui lòng nhập nội dung bình luận!");
                            return;
                        }

                        // Disable button và hiển thị loading
                        sendReplyBtn.disabled = true;
                        sendReplyBtn.textContent = "Đang gửi...";
                        showLoading(true);

                        // Gửi dữ liệu qua fetch
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
                                showLoading(false);

                                if (data.success) {
                                    // Hiển thị thông báo thành công với Toastify
                                    Toastify({
                                        text: data.message || "Trả lời của bạn đã được đăng!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "center",
                                        backgroundColor: "#4CAF50", // Màu xanh cho thành công
                                    }).showToast();

                                    // Đóng modal
                                    const replyModalEl = document.getElementById('replyModal');
                                    const modalInstance = bootstrap.Modal.getInstance(replyModalEl);
                                    modalInstance.hide();

                                    // Reload page sau 1 giây
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    // Hiển thị thông báo lỗi
                                    Toastify({
                                        text: data.message || "Có lỗi xảy ra, vui lòng thử lại!",
                                        duration: 3000,
                                        gravity: "top",
                                        position: "center",
                                        backgroundColor: "#F44336", // Màu đỏ cho lỗi
                                    }).showToast();

                                    // Enable lại button
                                    sendReplyBtn.disabled = false;
                                    sendReplyBtn.textContent = "Gửi trả lời";
                                }
                            })
                            .catch(error => {
                                console.error("Lỗi khi gửi bình luận:", error);

                                // Hiển thị thông báo lỗi
                                Toastify({
                                    text: "Đã xảy ra lỗi khi gửi trả lời (network / server).",
                                    duration: 3000,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "#F44336",
                                }).showToast();

                                // Ẩn loading, enable lại button
                                showLoading(false);
                                sendReplyBtn.disabled = false;
                                sendReplyBtn.textContent = "Gửi trả lời";
                            });
                    });
                }
            });

            // Make openReplyModal global
            window.openReplyModal = openReplyModal;
        </script>




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

    </main>

    <script>
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

    {{-- like cmt nhé --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-btn');

            likeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    button.disabled = true;

                    const commentId = button.getAttribute('data-comment-id');
                    const url = `/comments/${commentId}/like`;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'Success') {
                                const likeText = button.querySelector('.like-text');
                                const likeCountElem = document.getElementById(
                                    `like-count-${commentId}`);

                                // Cập nhật màu chữ "Thích"
                                if (data.liked) {
                                    likeText.classList.add('text-primary');
                                    likeCountElem.classList.add(
                                        'liked'); // 💙 Thêm màu cho số like
                                } else {
                                    likeText.classList.remove('text-primary');
                                    likeCountElem.classList.remove(
                                        'liked'); // Gỡ màu nếu unlike
                                }

                                // Cập nhật nội dung số like + icon
                                if (data.likes > 0) {
                                    likeCountElem.innerHTML =
                                        `<i class="fas fa-thumbs-up"></i> ${data.likes}`;
                                } else {
                                    likeCountElem.innerHTML = ''; // Ẩn nếu like = 0
                                }
                            } else if (data.message === 'Unauthorized') {
                                alert('Bạn cần đăng nhập để thực hiện thao tác này!');
                            }
                        })
                        .catch(error => {
                            console.error('Có lỗi xảy ra:', error);
                        })
                        .finally(() => {
                            button.disabled = false;
                        });
                });
            });
        });
    </script>



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

            const commentForm = document.querySelector(".comment-form");

            if (commentForm) {
                commentForm.addEventListener("submit", function(e) {
                    e.preventDefault();

                    const submitButton = commentForm.querySelector("button[type='submit']");

                    // Disable the button to prevent multiple clicks
                    submitButton.disabled = true;
                    submitButton.textContent =
                        "Đang gửi..."; // Change text to indicate the form is being submitted

                    // Show loading spinner
                    showLoading(true);

                    const formData = new FormData(this);
                    const url = this.getAttribute("action");

                    // Send AJAX request
                    fetch(url, {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Handle success or error
                            if (data.success) {
                                // Success Toast
                                Toastify({
                                    text: data.message || "Bình luận của bạn đã được đăng!",
                                    duration: 3000, // Duration in ms
                                    gravity: "top", // Top or Bottom
                                    position: "center", // Left, Right, Center
                                    backgroundColor: "#4CAF50", // Green for success
                                }).showToast();
                            } else {
                                // Error Toast
                                Toastify({
                                    text: data.message || "Có lỗi xảy ra khi gửi bình luận.",
                                    duration: 3000,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "#F44336", // Red for error
                                }).showToast();
                            }

                            // Reload the page to show updated content
                            setTimeout(function() {
                                location.reload(); // Reload the page to show the new comment
                            }, 1000); // Delay for 1 second before reloading the page

                            // Hide loading spinner
                            showLoading(false);

                            // Enable the button again
                            submitButton.disabled = false;
                            submitButton.textContent = "Gửi Bình Luận"; // Reset button text
                        })
                        .catch(error => {
                            // Handle network or server error
                            console.error("Error:", error);

                            // Error Toast
                            Toastify({
                                text: "Đã xảy ra lỗi khi gửi bình luận (network / server).",
                                duration: 3000,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#F44336", // Red for error
                            }).showToast();

                            // Hide loading spinner
                            showLoading(false);

                            // Enable the button again
                            submitButton.disabled = false;
                            submitButton.textContent = "Gửi Bình Luận"; // Reset button text
                        });
                });
            }

        });

        // Function to show or hide loading spinner
        function showLoading(isLoading) {
            const loadingSpinner = document.querySelector(".loading-spinner");
            if (isLoading) {
                loadingSpinner.style.display = "flex";
            } else {
                loadingSpinner.style.display = "none";
            }
        }
    </script>

    <style>
        /* Custom Toast Styles */
        .custom-toast {
            position: fixed;
            top: 50%;
            /* Center vertically */
            left: 50%;
            transform: translate(-50%, -50%);
            /* Center horizontally */
            padding: 20px 40px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            opacity: 0;
            /* Initially hidden */
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            z-index: 9999;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            background-color: #4CAF50;
            /* Default green background */
            transform: translateY(-30px);
            /* Start off the screen */
        }

        /* Class for showing the notification */
        .custom-toast.show {
            opacity: 1;
            transform: translateY(0);
            /* Slide down into view */
        }

        /* Loading Spinner */
        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9998;
        }

        /* Spinner itself */
        .loading-spinner .spinner {
            border: 4px solid transparent;
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Styling for submit button when disabled */
        button[type='submit']:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }
    </style>

    <!-- Loading Spinner HTML -->
    <div class="loading-spinner">
        <div class="spinner"></div>
    </div>



    <!-- Toastify CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>







    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".send-reply");
            buttons.forEach(button => {
                button.addEventListener("click", function() {
                    const commentId = this.getAttribute("data-comment-id");
                    const articleId = this.getAttribute("data-article-id");
                    const replyForm = document.querySelector(
                        `#reply-form-${commentId} .reply-form`);
                    const content = replyForm.querySelector(".reply-content").value.trim();
                    const csrfToken = document.querySelector("meta[name='csrf-token']")
                        .getAttribute("content");

                    // Kiểm tra nếu nội dung bình luận rỗng
                    if (content === "") {
                        Toastify({
                            text: "Vui lòng nhập nội dung bình luận!",
                            duration: 3000,
                            gravity: "top", // Vị trí ở trên cùng
                            position: "center", // Vị trí giữa màn hình
                            backgroundColor: "#F44336", // Màu nền đỏ cho lỗi
                        }).showToast();
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
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Thông báo trả lời thành công
                                Toastify({
                                    text: data.message || 'Trả lời thành công!',
                                    duration: 3000,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "#4CAF50", // Màu nền xanh lá cho thành công
                                }).showToast();

                                // Reload lại trang sau khi trả lời thành công
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else {
                                // Thông báo khi có lỗi
                                Toastify({
                                    text: data.message || 'Có lỗi xảy ra!',
                                    duration: 3000,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "#F44336", // Màu nền đỏ cho lỗi
                                }).showToast();
                            }
                        })
                        .catch(error => {
                            console.error("Lỗi:", error);
                            // Thông báo lỗi khi có sự cố kết nối
                            Toastify({
                                text: "Lỗi kết nối, vui lòng thử lại!",
                                duration: 3000,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#F44336",
                            }).showToast();
                        });
                });
            });
        });
    </script>





@endsection

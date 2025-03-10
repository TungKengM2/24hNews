@extends('website.layouts.master')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        <section class="product pt-50">
            <div class="container">

                <div class="container mt-4">
                    <div class="row">
                        <!-- Bài viết chính -->
                        <div class="col-lg-8">
                            <div class="card shadow-sm mb-4 border-0">
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
                                    <button id="likeButton" class="like-btn"
                                            data-article-id="{{ $article->article_id }}"
                                            data-liked="{{ $isLiked ? 'true' : 'false' }}">
                                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-thumbs-up"
                                           style="color: {{ $isLiked ? '#007bff' : 'black' }};"></i>
                                        <span id="likeText"
                                              style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $isLiked ? 'Đã thích' : 'Thích' }}</span>
                                        <span id="likeCount"
                                              style="color: {{ $isLiked ? '#007bff' : 'black' }};">{{ $likeCount }}</span>
                                    </button>

                                    <div class="article-content mt-3">{!! $article->content !!}</div>
                                </div>
                            </div>
                        </div>


                        <!-- Quảng cáo -->
                        <div class="col-lg-4">
                            <div class="advertisement fade-in"><a href="https://shop.mixigaming.com/">
                                    <img
                                        src="https://th.bing.com/th/id/R.638f0378be501384598c313b9254a074?rik=4q27eEjjmHzVeA&riu=http%3a%2f%2fintemnhandecal.net%2fwp-content%2fuploads%2f2019%2f07%2fcac-mau-in-poster-quang-cao.jpg&ehk=xEa19xG1SoAREwQ5DcFB6e7uJVPbPgG6cHVQGMLTuvA%3d&risl=&pid=ImgRaw&r=0"
                                        class="w-100" alt="Quảng cáo">
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
                                data-bs-target="#pills-description" type="button" role="tab"
                                aria-controls="pills-description" aria-selected="true">Mô tả
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews"
                                aria-selected="false">Bình Luận
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                         aria-labelledby="pills-description-tab">
                        <div class="content-info text-center pb-0">
                            <div class="text mb-30">
                                Trong thế giới hiện đại ngày nay, việc duy trì sự cân bằng giữa công việc và sức khỏe đã
                                trở thành một
                                ưu tiên hàng đầu. Các nghiên cứu cho thấy rằng thói quen hàng ngày và môi trường sống
                                đóng vai trò quan trọng
                                trong việc nâng cao chất lượng cuộc sống.
                            </div>
                            <div class="text">
                                Các chuyên gia khuyến nghị rằng hoạt động thể chất thường xuyên không chỉ cải thiện thể
                                lực mà còn tăng cường
                                sức khỏe tinh thần. Ngoài ra, một môi trường làm việc được thiết kế hợp lý giúp nâng cao
                                năng suất và tinh thần,
                                góp phần tạo nên một lối sống lành mạnh và bền vững.
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-reviews" role="tabpanel"
                         aria-labelledby="pills-reviews-tab">
                        <div class="product-reviews pt-30">
                            <div class="row gx-5">
                                <div class="row">

                                    <div class="col-lg-7">
                                        <div class="reviews-content pt-30">
                                            <h5 class="color-000 mb-40 text-capitalize">
                                                Bình luận</h5>

                                            <?php foreach ($comments as $comment) { ?>
                                                <?php if (! $comment->parent_id) { ?>
                                            <div class="comment-reply-cont bg-light py-3 px-4 mb-3 rounded shadow-sm">
                                                <div class="d-flex align-items-start">
                                                    <div
                                                        class="icon-60 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                                                        <img
                                                            src="<?= $comment->user->image ?? 'assets/img/colums/default.png' ?>"
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
                                                            <button
                                                                class="btn btn-sm btn-outline-primary reply-btn d-flex align-items-center gap-1 px-3 py-1"
                                                                data-comment-id="<?= $comment->comment_id ?>"
                                                                data-username="<?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>">
                                                                <i class="fas fa-reply fa-flip-horizontal"></i> <span
                                                                    class="fw-bold">Trả lời</span>
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
                                                                <?php foreach ($comment->replies as $reply) { ?>
                                                            <div
                                                                class="comment-reply-cont bg-white py-2 px-3 mb-2 rounded shadow-sm reply-item <?= $index >= $visibleReplies ? 'd-none' : '' ?>">
                                                                <div class="d-flex align-items-start">
                                                                    <div
                                                                        class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                                                                        <img
                                                                            src="<?= $reply->user->image ?? 'assets/img/colums/default.png' ?>"
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
                                                                                <?= date('F d, Y',
                                                                                    strtotime($reply->created_at)) ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="text color-000 fs-14px mt-1">
                                                                                <?= nl2br(htmlspecialchars($reply->content)) ?>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary reply-btn d-flex align-items-center gap-1 px-3 py-1"
                                                                                data-comment-id="<?= $comment->comment_id ?>"
                                                                                data-username="<?= htmlspecialchars($comment->user->username ?? 'Anonymous') ?>">
                                                                                <i
                                                                                    class="fas fa-reply fa-flip-horizontal"></i>
                                                                                <span class="fw-bold">Trả lời</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <?php $index++; ?>
                                                            <?php } ?>

                                                                <?php if ($replyCount > $visibleReplies) { ?>
                                                            <button
                                                                class="btn btn-link text-primary px-0 show-more-replies text-decoration-none">
                                                                Xem
                                                                thêm
                                                            </button>
                                                            <?php } ?>

                                                        </div>


                                                        <!-- JavaScript để hiển thị form khi nhấn nút Reply -->
                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', function () {
                                                                document.querySelectorAll('.replies').forEach(replyContainer => {
                                                                    const showMoreBtn = replyContainer.querySelector('.show-more-replies');
                                                                    const hiddenReplies = replyContainer.querySelectorAll('.reply-item.d-none');

                                                                    if (showMoreBtn) {
                                                                        showMoreBtn.addEventListener('click', function () {
                                                                            hiddenReplies.forEach(reply => reply.classList.remove('d-none'));
                                                                            showMoreBtn.style.display = 'none'; // Ẩn nút sau khi mở rộng
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
                                                                    class="d-flex align-items-start bg-white p-3 rounded shadow-sm">
                                                                    <!-- Ảnh đại diện -->
                                                                    <div
                                                                        class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                                                                        <img
                                                                            src="{{ $currentUser->image ?? asset('assets/img/colums/default.png') }}"
                                                                            alt="Your Avatar">
                                                                    </div>

                                                                    <div class="w-100">
                                                                        <!-- Ô nhập nội dung trả lời -->
                                                                        <textarea
                                                                            class="form-control form-control-sm reply-content"
                                                                            name="content" rows="2" required
                                                                            placeholder="Trả lời: @php echo $comment->user->username ?? 'Người dùng ẩn danh'; @endphp"
                                                                            onfocus="addUsernameToReply(this, '{{ $comment->user->username ?? 'Người dùng ẩn danh' }}')">
                                                                        </textarea>

                                                                        <script>
                                                                            function addUsernameToReply(textarea, username) {
                                                                                if (textarea.value.trim() === '') {
                                                                                    textarea.value = '@' + username + ' ';
                                                                                }
                                                                            }
                                                                        </script>


                                                                        <!-- Nút hành động -->
                                                                        <div
                                                                            class="d-flex justify-content-end gap-2 mt-2">
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-outline-secondary cancel-reply">
                                                                                Hủy
                                                                            </button>
                                                                            <button type="button"
                                                                                    class="btn btn-sm btn-primary send-reply"
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
                                            <?php } ?>
                                            <?php } ?>

                                                <!-- THÊM PHÂN TRANG -->
                                            <div class="d-flex justify-content-center mt-4">
                                                {{ $comments->links() }}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-5">
                                        <form class="comment-form pt-30" method="POST"
                                              action="<?= route('client.articles.comment', ['article_id' => $article->article_id]) ?>">
                                            <?= csrf_field() ?>
                                            <h5 class="color-000 mb-40 text-capitalize"> Thêm bình luận </h5>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-30">
                                                        <textarea class="form-control radius-4 fs-12px p-3"
                                                                  name="content" rows="6"
                                                                  placeholder="Viết bình luận của bạn ở đây"
                                                                  required></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="article_id"
                                                       value="<?= $article->article_id ?>">
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

                                                <a href="{{ route('client.articles.article', $related->article_id) }}"
                                                   class="butn">
                                                    <span><i class="la la-eye me-2"></i>Đọc thêm</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="info pt-30">
                                            <a href="{{ route('client.articles.article', $related->article_id) }}"
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
        document.addEventListener('DOMContentLoaded', function () {
            // === Like Button ===
            const likeButton = document.getElementById('likeButton');
            if (likeButton) {
                const likeText = document.getElementById('likeText');
                const likeCount = document.getElementById('likeCount');
                const icon = likeButton.querySelector('i');
                let isLiked = likeButton.getAttribute('data-liked') === 'true';

                // Cập nhật UI ban đầu
                updateLikeUI(isLiked);

                likeButton.addEventListener('click', function () {
                    const articleId = likeButton.getAttribute('data-article-id');
                    fetch(`/client/articles/${articleId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({}),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                isLiked = data.liked;
                                likeButton.setAttribute('data-liked', isLiked ? 'true' : 'false');
                                likeText.textContent = isLiked ? 'Đã thích' : 'Thích';
                                likeCount.textContent = data.likeCount;
                                updateLikeUI(isLiked);
                            } else {
                                alert('Lỗi: ' + data.message);
                            }
                        })
                        .catch(err => console.error(err));
                });

                function updateLikeUI(liked) {
                    if (liked) {
                        likeText.style.color = '#007bff';
                        likeCount.style.color = '#007bff';
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                        icon.style.color = '#007bff';
                    } else {
                        likeText.style.color = 'black';
                        likeCount.style.color = 'black';
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                        icon.style.color = 'black';
                    }
                }
            }

            // === Comment Form ===
            const commentForm = document.querySelector('.comment-form');
            if (commentForm) {
                commentForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newComment = `
              <div class="comment-reply-cont bg-light py-3 px-4 mb-3 rounded shadow-sm">
                <div class="d-flex align-items-start">
                  <div class="icon-60 rounded-circle img-cover overflow-hidden me-3 flex-shrink-0">
                    <img src="${data.comment.user_image}" alt="User Avatar">
                  </div>
                  <div class="inf w-100">
                    <div class="d-flex justify-content-between align-items-center">
                      <h6 class="fw-bold">${data.comment.username}</h6>
                      <span class="fs-12px text-muted"><i class="fas fa-clock"></i> ${data.comment.created_at}</span>
                    </div>
                    <div class="text color-000 fs-14px mt-2">${data.comment.content}</div>
                    <div class="mt-2">
                      <a href="#" class="text-primary fw-bold reply-link" data-comment-id="${data.comment.comment_id}">
                        <i class="fas fa-reply"></i> Reply
                      </a>
                    </div>
                    <div class="reply-form-container mt-2 d-none" id="reply-form-${data.comment.comment_id}">
                      <form class="reply-form" data-comment-id="${data.comment.comment_id}">
                        <div class="d-flex align-items-start bg-white p-3 rounded shadow-sm">
                          <div class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                            <img src="${data.comment.user_image}" alt="Your Avatar">
                          </div>
                          <div class="w-100">
                            <textarea class="form-control reply-content" name="content" rows="2" placeholder="Reply to @${data.comment.username}..."></textarea>
                            <input type="hidden" name="article_id" value="${data.comment.article_id}">
                            <input type="hidden" name="parent_id" value="${data.comment.comment_id}">
                            <div class="d-flex justify-content-end mt-2">
                              <button type="button" class="btn btn-sm btn-secondary cancel-reply me-2">
                                <i class="fas fa-times"></i> Cancel
                              </button>
                              <button type="button" class="btn btn-sm btn-primary send-reply" data-article-id="${data.comment.article_id}" data-comment-id="${data.comment.comment_id}">
                                <i class="fas fa-paper-plane"></i> Trả lời
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            `;
                                document.querySelector('.reviews-content').insertAdjacentHTML('beforeend', newComment);
                                commentForm.reset();
                            } else {
                                alert('Lỗi khi gửi comment!');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            }

            // === Event Delegation cho Reply & Cancel Reply ===
            document.addEventListener('click', function (e) {
                // Mở/đóng form reply khi nhấn "Reply" hoặc nút reply được tạo động
                const replyBtn = e.target.closest('.reply-link, .reply-btn');
                if (replyBtn) {
                    e.preventDefault();
                    const commentId = replyBtn.getAttribute('data-comment-id');
                    const replyForm = document.getElementById(`reply-form-${commentId}`);
                    if (replyForm) {
                        replyForm.classList.toggle('d-none');
                    }
                    return;
                }

                // Ẩn form reply khi nhấn "Cancel"
                if (e.target.classList.contains('cancel-reply')) {
                    const formContainer = e.target.closest('.reply-form-container');
                    if (formContainer) {
                        formContainer.classList.add('d-none');
                    }
                    return;
                }

                // Gửi reply comment khi nhấn nút "Trả lời"
                const sendReplyBtn = e.target.closest('.send-reply');
                if (sendReplyBtn) {
                    e.preventDefault();
                    const btn = sendReplyBtn;
                    const form = btn.closest('form');
                    const commentId = btn.getAttribute('data-comment-id');
                    const articleId = btn.getAttribute('data-article-id');
                    const replyContentElem = form.querySelector('.reply-content');
                    if (!replyContentElem.value.trim()) {
                        alert('Nội dung không được để trống!');
                        return;
                    }
                    const formData = new FormData(form);
                    // Giả sử route cho reply comment có dạng: /client/articles/{articleId}/reply-comment/{commentId}
                    const url = `/client/articles/${articleId}/reply-comment/${commentId}`;
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const newReply = `
              <div class="replies ms-5 mt-3">
                <div class="comment-reply-cont bg-white py-2 px-3 mb-2 rounded shadow-sm">
                  <div class="d-flex align-items-start">
                    <div class="icon-40 rounded-circle img-cover overflow-hidden me-2 flex-shrink-0">
                      <img src="${data.reply.user_image}" alt="User Avatar">
                    </div>
                    <div class="inf w-100">
                      <div class="d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold">${data.reply.username}</h6>
                        <span class="fs-12px text-muted"><i class="fas fa-clock"></i> ${data.reply.created_at}</span>
                      </div>
                      <div class="text color-000 fs-14px mt-1">
                        ${data.reply.content.replace(/\n/g, '<br>')}
                      </div>
                      <div class="mt-2">
                        <button class="btn btn-sm btn-outline-primary reply-btn d-flex align-items-center gap-1 px-3 py-1" data-comment-id="${commentId}">
                          <i class="fas fa-reply fa-flip-horizontal"></i>
                          <span class="fw-bold">Trả lời</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            `;
                                const replyFormContainer = document.getElementById(`reply-form-${commentId}`);
                                if (replyFormContainer) {
                                    replyFormContainer.insertAdjacentHTML('beforebegin', newReply);
                                    form.reset();
                                    replyFormContainer.classList.add('d-none');
                                }
                            } else {
                                alert('Có lỗi xảy ra, vui lòng thử lại!');
                            }
                        })
                        .catch(err => console.error(err));

                }
            });
        });
    </script>

@endsection

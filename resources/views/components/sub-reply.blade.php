<!-- CSS cho giao diện giống Facebook -->
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
    font-family: 'Arial', sans-serif; /* Đảm bảo font chung */
    font-size: 14px; /* Kích thước chữ đồng đều */
    font-weight: 600; /* Đảm bảo chữ đậm giống nhau */
    text-transform: none; /* Ngừng chuyển chữ thành in hoa nếu có */
}

        /* Đảm bảo các nút có cùng kiểu chữ và định dạng */
.small-action-buttons button {
    font-family: 'Arial', sans-serif; /* Font chữ chung */
    font-size: 14px; /* Kích thước chữ đồng đều */
    font-weight: 600; /* Đảm bảo chữ đậm giống nhau */
    text-transform: none; /* Không tự động chuyển chữ thành in hoa */
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

    .r{
        font-size: 14px;

    }
</style>




<?php
if (!function_exists('renderSubReplies')) {
    function renderSubReplies($subReplies, $depth = 1)
    {
        foreach ($subReplies as $index => $subReply): ?>
            <div class="reply-item d-flex position-relative mb-3">
                <div class="position-relative me-2">
                    <div class="reply-avatar">
                        <img src="<?= $subReply->user->image ? asset('storage/' . $subReply->user->image) : 'https://cdn.sforum.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg' ?>">
                    </div>
                    <?php if ($index < count($subReplies) - 1): ?>
                        <div class="thread-line"></div>
                    <?php endif; ?>
                </div>

                <div>
                    <div class="reply-box">
                        <strong><?= htmlspecialchars($subReply->user->username ?? 'Anonymous') ?></strong>
                       
                        <div class="mt-2">
                            <?= nl2br(htmlspecialchars($subReply->content)) ?>
                        </div>
                    </div>

                    <div class="reply-actions mt-1 d-flex align-items-center flex-wrap gap-3 small-action-buttons">
                        <button type="button"
                            class="btn btn-link p-0 text-decoration-none text-gray reply-btn"
                            onclick="openReplyModal(this)"
                            data-comment-id="<?= $subReply->comment_id ?>"
                            data-username="@<?= htmlspecialchars($subReply->user->username ?? 'Anonymous') ?>"
                            data-article-id="<?= $subReply->article_id ?>">
                            <span class="fw-bold">Trả lời</span>
                        </button>
                    
                        <!-- Nút Like -->
                        <button type="button" class="btn like-btn"
                        data-comment-id="{{ $subReply->comment_id }}">
                        <span
                            class="like-text @if ($subReply->likesUsers->contains(auth()->id())) text-primary @endif">
                            Thích
                        </span>
                    </button>

                    
                    
                        @if (auth()->check() && auth()->id() === $subReply->user_id)
                            <form method="POST"
                                action="{{ route('comments.destroy', $subReply->comment_id) }}"
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
                            <?php if ($subReply->user_id !== auth()->id()): ?>
                            <button type="button"
                                class="btn btn-link p-0 text-decoration-none text-gray repost-btn"
                                data-comment-id="{{ $subReply->comment_id }}"
                                data-content="{{ htmlspecialchars($subReply->content, ENT_QUOTES, 'UTF-8') }}"
                                title="Báo cáo bình luận này">
                                <span class="fw-bold">Báo cáo</span>
                            </button>
                            <?php endif; ?>
                        @endif
                    
                        <div class="reply-meta text-muted small">
                            <?= time_ago($subReply->created_at) ?>
                        </div>
                        <!-- Hiển thị icon + số lượt like -->
                    <span id="like-count-{{ $subReply->comment_id }}"
                        class="like-count @if ($subReply->likesUsers->contains(auth()->id())) liked @endif">
                        @if ($subReply->likes > 0)
                            <i class="fas fa-thumbs-up"></i> {{ $subReply->likes }}
                        @endif
                    </span>
                    </div>
                    

                    <?php if (!empty($subReply->subReplies)): ?>
                        <div class="sub-replies mt-2 ms-5">
                            <?php renderSubReplies($subReply->subReplies, $depth + 1); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach;
    }
}
?>


<!-- Gọi hiển thị subReplies -->
<div class="sub-replies mt-3 ms-5">
        <?php renderSubReplies($reply->subReplies); ?>
</div>









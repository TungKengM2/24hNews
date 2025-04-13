<!-- CSS cho giao diện giống Facebook -->




<?php
if (!function_exists('renderSubReplies')) {
    function renderSubReplies($subReplies)
    {
        foreach ($subReplies as $index => $subReply): ?>
           
            <div class="position-relative" style="min-width: 40px">
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
                    <div class="mt-2"><?= nl2br(htmlspecialchars($subReply->content)) ?></div>
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

                    <button type="button" class="btn like-btn"
                        data-comment-id="<?= $subReply->comment_id ?>">
                        <span class="like-text <?= $subReply->likesUsers->contains(auth()->id()) ? 'text-primary' : '' ?>">
                            Thích
                        </span>
                    </button>

                    <?php if (auth()->check() && auth()->id() === $subReply->user_id): ?>
                        <form method="POST"
                            action="<?= route('comments.destroy', $subReply->comment_id) ?>"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');"
                            class="d-inline">
                            <?= csrf_field() ?>
                            <?= method_field('DELETE') ?>
                            <button type="submit"
                                class="btn btn-link p-0 text-decoration-none text-gray">
                                <span class="fw-bold">Xóa</span>
                            </button>
                        </form>
                    <?php else: ?>
                        <button type="button"
                            class="btn btn-link p-0 text-decoration-none text-gray repost-btn"
                            data-comment-id="<?= $subReply->comment_id ?>"
                            data-content="<?= htmlspecialchars($subReply->content, ENT_QUOTES, 'UTF-8') ?>">
                            <span class="fw-bold">Báo cáo</span>
                        </button>
                    <?php endif; ?>

                    <div class="reply-meta text-muted small"><?= time_ago($subReply->created_at) ?></div>

                    <span id="like-count-<?= $subReply->comment_id ?>"
                          class="like-count <?= $subReply->likesUsers->contains(auth()->id()) ? 'liked' : '' ?>">
                        <?php if ($subReply->likes > 0): ?>
                            <i class="fas fa-thumbs-up"></i> <?= $subReply->likes ?>
                        <?php endif; ?>
                    </span>
                </div>

                <?php if (!empty($subReply->subReplies)): ?>
                    <?php renderSubReplies($subReply->subReplies); ?>
                <?php endif; ?>
            </div>
            
        <?php endforeach;
    }
}
?>



<!-- Gọi hiển thị subReplies -->
<div class="sub-replies mt-3 ms-5">
        <?php renderSubReplies($reply->subReplies); ?>
</div>









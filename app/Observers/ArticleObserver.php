<?php 

namespace App\Observers;

use App\Models\Article;
use App\Notifications\ArticleStatusChangedNotification;

class ArticleObserver
{
    public function updated(Article $article)
    {
        // Kiểm tra nếu cột status đã thay đổi
        if ($article->wasChanged('status')) {
            // Giả sử bạn muốn thông báo cho tác giả bài viết
            $article->author->notify(new ArticleStatusChangedNotification($article));

            // Nếu cần gửi cho nhiều người dùng:
            // Notification::send($users, new ArticleStatusChangedNotification($article));
        }
    }
}

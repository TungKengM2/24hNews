<?php 

namespace App\Observers;

use App\Models\Article;

use App\Notifications\NewArticleFromFollowedAuthor;
use App\Notifications\ArticleStatusChangedNotification;

class ArticleObserver
{
    public function updatedd(Article $article)
    {
        
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article)
    {
        // Kiểm tra nếu cột status đã thay đổi
        if ($article->wasChanged('draft')) {
            // Giả sử bạn muốn thông báo cho tác giả bài viết
            $article->author->notify(new ArticleStatusChangedNotification($article));

            // Nếu cần gửi cho nhiều người dùng:
            // Notification::send($users, new ArticleStatusChangedNotification($article));
        }
        // Gửi thông báo khi bài viết chuyển sang trạng thái published
        if ($article->status === 'published' && $article->wasChanged('status')) {
            $author = $article->author;
            $author->followers()->chunk(200, function ($followers) use ($article, $author) {
                foreach ($followers as $follower) {
                    $follower->notify(new NewArticleFromFollowedAuthor($article, $author));
                }
            });
        }
    }

    
    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }

}

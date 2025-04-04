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
        if ($article->wasChanged('status')) {
            if ($article->status === 'published') {
                // Gửi thông báo cho followers
                $author = $article->author;
                $author->followers()->chunk(200, function ($followers) use ($article, $author) {
                    foreach ($followers as $follower) {
                        $follower->notify(new NewArticleFromFollowedAuthor($article, $author));
                    }
                });
            } else {
                // Gửi thông báo cho chính tác giả nếu không phải published (giả sử là draft)
                $article->author->notify(new ArticleStatusChangedNotification($article));
            }
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

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
                        $authorName = $author->fullname ?? $author->username;
                        \App\Helpers\NotificationHelper::sendCustomNotification(
                            $follower,
                            'Bài viết mới từ tác giả bạn theo dõi',
                            "{$authorName} vừa đăng bài viết mới: {$article->title}",
                            'new_article_from_followed_author',
                            [
                                'article_id' => $article->article_id,
                                'article_slug' => $article->slug,
                                'author_id' => $author->user_id,
                                'author_name' => $authorName,
                                'author_avatar' => $author->image ?? asset('images/default-avatar.png'),
                                'published_at' => now()->toDateTimeString(),
                                'thumbnail_url' => $article->thumbnail_url ?? asset('images/default-thumbnail.jpg'),
                                'url' => route('articles.show', $article->slug)
                            ]
                        );
                    }
                });
            } else {
                // Gửi thông báo cho chính tác giả nếu không phải published (giả sử là draft)
                \App\Helpers\NotificationHelper::sendCustomNotification(
                    $article->author,
                    'Trạng thái bài viết đã thay đổi',
                    "Bài viết '{$article->title}' đã thay đổi trạng thái thành {$article->status}.",
                    'article_status_changed',
                    [
                        'article_id' => $article->article_id
                    ]
                );
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

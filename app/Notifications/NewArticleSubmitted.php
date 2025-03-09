<?php

// app/Notifications/NewArticleSubmitted.php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use App\Models\Article;

class NewArticleSubmitted extends Notification
{
    use Queueable;

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Bài viết mới đang chờ duyệt: {$this->article->title}",
            'article_id' => $this->article->id,
            'status' => $this->article->status,
            'pending_count' => Article::where('status', 'pending')->count()
        ];
    }
}




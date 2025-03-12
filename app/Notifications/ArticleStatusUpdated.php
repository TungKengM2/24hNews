<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\Article;

class ArticleStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $article;
    protected $message;

    public function __construct(Article $article, string $message)
    {
        $this->article = $article;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'article_id' => $this->article->article_id,
            'title' => $this->article->title,
            'message' => $this->message,
            'status' => $this->article->status,
            'updated_at' => now(),
        ];
    }
}

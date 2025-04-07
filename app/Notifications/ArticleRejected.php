<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $article;
    protected $reason;

    public function __construct(Article $article, $reason)
    {
        $this->article = $article;
        $this->reason = $reason;
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
            'message' => "Bài viết '{$this->article->title}' của bạn đã bị từ chối. Lý do: {$this->reason}",
            'type' => 'article_rejected',
            'reason' => $this->reason
        ];
    }
}

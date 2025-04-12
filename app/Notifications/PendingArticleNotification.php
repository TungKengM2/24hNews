<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PendingArticleNotification extends Notification
{
    use Queueable;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable)
    {
        return ['database']; // Chỉ lưu vào database
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Bài viết mới cần duyệt',
            'message' => 'Bài viết mới cần duyệt: ' . $this->article->title,
            'article_id' => $this->article->article_id,
            'link' => route('moderator.articles.show', $this->article)
        ];
    }
}

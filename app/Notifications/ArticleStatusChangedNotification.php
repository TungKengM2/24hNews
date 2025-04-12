<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ArticleStatusChangedNotification extends Notification
{
    use Queueable;

    protected $article;

    public function __construct($article)
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
            'title' => 'Trạng thái bài viết đã thay đổi',
            'message' => "Bài viết '{$this->article->title}' đã thay đổi trạng thái thành {$this->article->status}.",
            'article_id' => $this->article->id,
        ];
    }
}

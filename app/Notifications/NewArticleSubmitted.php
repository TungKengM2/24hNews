<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Bus\Queueable;

class NewArticleSubmitted extends Notification
{
    use Queueable;

    protected $article;

    public function __construct($article)
    {
        $this->article = $article;
    }
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Có một bài viết mới cần duyệt!',
            'article_id' => $this->article->article_id, // Thêm ID bài viết
            'status' => $this->article->status  // Thêm trạng thái bài viết
        ];
    }

    public function via($notifiable)
    {
        return ['database']; // Lưu vào database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Bài viết mới cần duyệt: " . $this->article->title,
            'article_id' => $this->article->id
        ];
    }


}

<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleEditingExpired extends Notification implements ShouldQueue
{
    use Queueable;

    protected $article;

    /**
     * Create a new notification instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Thời gian chỉnh sửa đã hết hạn',
            'message' => 'Bài viết "' . $this->article->title . '" đã bị từ chối do không được duyệt lại kịp thời sau khi chỉnh sửa.',
            'type' => 'editing_expired',
            'data' => [
                'article_id' => $this->article->article_id
            ]
        ];
    }
}

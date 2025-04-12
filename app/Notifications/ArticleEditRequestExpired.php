<?php

namespace App\Notifications;

use App\Models\ArticleEditRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleEditRequestExpired extends Notification implements ShouldQueue
{
    use Queueable;

    protected $editRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ArticleEditRequest $editRequest)
    {
        $this->editRequest = $editRequest;
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
            'title' => 'Yêu cầu chỉnh sửa đã hết hạn',
            'message' => 'Yêu cầu chỉnh sửa bài viết "' . $this->editRequest->article->title . '" đã hết hạn do không được xử lý kịp thời.',
            'type' => 'edit_request_expired',
            'data' => [
                'article_id' => $this->editRequest->article_id,
                'request_id' => $this->editRequest->id
            ]
        ];
    }
}

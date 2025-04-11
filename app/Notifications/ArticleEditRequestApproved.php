<?php

namespace App\Notifications;

use App\Models\ArticleEditRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleEditRequestApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $editRequest;

    public function __construct(ArticleEditRequest $editRequest)
    {
        $this->editRequest = $editRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Yêu cầu chỉnh sửa được chấp nhận',
            'message' => 'Yêu cầu chỉnh sửa bài viết "' . $this->editRequest->article->title . '" đã được chấp nhận.',
            'type' => 'edit_request_approved',
            'data' => [
                'article_id' => $this->editRequest->article_id,
                'request_id' => $this->editRequest->id
            ]
        ];
    }
}

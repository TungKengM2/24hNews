<?php

namespace App\Notifications;

use App\Models\EditRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EditRequestNotification extends Notification
{
    use Queueable;

    protected $editRequest;

    public function __construct(EditRequest $editRequest)
    {
        $this->editRequest = $editRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $message = '';
        $title = '';

        switch ($this->editRequest->status) {
            case 'pending':
                $title = 'Yêu cầu chỉnh sửa mới';
                $message = "Có yêu cầu chỉnh sửa mới cho bài viết '{$this->editRequest->article->title}'";
                break;
            case 'approved':
                $title = 'Yêu cầu chỉnh sửa được chấp nhận';
                $message = "Yêu cầu chỉnh sửa của bạn cho bài viết '{$this->editRequest->article->title}' đã được chấp nhận";
                break;
            case 'rejected':
                $title = 'Yêu cầu chỉnh sửa bị từ chối';
                $message = "Yêu cầu chỉnh sửa của bạn cho bài viết '{$this->editRequest->article->title}' đã bị từ chối";
                break;
        }

        return [
            'title' => $title,
            'message' => $message,
            'edit_request_id' => $this->editRequest->id,
            'article_id' => $this->editRequest->article_id,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AuthorUpgradeRequest extends Notification
{
    use Queueable;

    protected $requestingUser;

    /**
     * Create a new notification instance.
     */
    public function __construct($requestingUser)
    {
        $this->requestingUser = $requestingUser;
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
            'title' => 'Yêu cầu nâng cấp tài khoản',
            'message' => "Có " . \App\Models\Approval::where('type', 'role_upgrade')
                ->where('status', 'pending')
                ->count() . " yêu cầu nâng cấp lên tác giả đang chờ duyệt",
            'user_id' => $this->requestingUser->user_id,
        ];
    }
}

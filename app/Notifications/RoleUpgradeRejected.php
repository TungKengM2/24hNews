<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Approval;

class RoleUpgradeRejected extends Notification implements ShouldQueue
{
    use Queueable;

    protected $approval;

    public function __construct(Approval $approval)
    {
        $this->approval = $approval;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Yêu cầu nâng cấp vai trò của bạn đã bị từ chối',
            'reason' => $this->approval->reject_reason,
            'link' => route('home'),
            'type' => 'role_upgrade_rejected'
        ];
    }
}

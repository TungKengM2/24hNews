<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UserViolationAlert extends Notification
{
    use Queueable;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = '';
        if ($this->user->violation_count == 3) {
            $message = "Người dùng {$this->user->fullname} đã vi phạm 3 lần – sẽ bị khóa 24 giờ.";
        } elseif ($this->user->violation_count == 5) {
            $message = "Người dùng {$this->user->fullname} đã vi phạm 5 lần – sẽ bị khóa 3 ngày.";
        }

        return [
            'message' => $message,
            'user_id' => $this->user->id,
            'violation_count' => $this->user->violation_count,
            'last_violation_at' => $this->user->last_violation_at,
        ];
    }
}

<?php 
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViolationDetected extends Notification
{
    use Queueable;

    protected $violation;

    public function __construct($violation)
    {
        $this->violation = $violation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->violation->type,
            'reference_id' => $this->violation->reference_id,
            'detected_word' => $this->violation->detected_word,
            'detected_at' => $this->violation->detected_at,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id == auth()->id()) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

}

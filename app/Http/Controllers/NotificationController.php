<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\DatabaseNotification;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Đánh dấu một thông báo là đã đọc
    public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->where('id', $id)->first();

    if ($notification) {
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
}

   public function clear()
{
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
}


}

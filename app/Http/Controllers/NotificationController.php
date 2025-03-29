<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Hiển thị trang danh sách thông báo
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->where('type', 'App\Notifications\NewArticleFromFollowedAuthor')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Đánh dấu một thông báo cụ thể là đã đọc
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy thông báo'
        ], 404);
    }

    /**
     * Đánh dấu tất cả thông báo là đã đọc
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    /**
     * Lấy số lượng thông báo chưa đọc (API)
     */
    public function countUnread()
    {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }
}

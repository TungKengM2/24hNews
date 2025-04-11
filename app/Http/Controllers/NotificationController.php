<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Hiển thị trang danh sách thông báo
     */
    public function index()
    {
        $user = Auth::user();

        // Lấy thông báo từ bảng notifications
        $notifications = Notification::where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Đánh dấu thông báo đã đọc
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Xóa tất cả thông báo
     */
    public function clearAll()
    {
        Notification::where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Đếm số thông báo chưa đọc
     */
    public function countUnread()
    {
        $count = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Lấy thông báo bài viết cần duyệt (API)
     */
    public function pendingArticles()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('type', 'App\Notifications\PendingArticleNotification')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'],
                    'link' => $notification->data['link'],
                    'read_at' => $notification->read_at,
                    'time' => $notification->created_at->diffForHumans()
                ];
            });

        return response()->json($notifications);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PendingArticleNotification;

class NotificationController extends Controller
{
    /**
     * Hiển thị trang danh sách thông báo
     */
    public function index()
    {
        $user = Auth::user();

        // Lấy cả 2 loại thông báo
        $notifications = $user->notifications()
            ->where(function($query) {
                $query->where('type', 'App\Notifications\NewArticleFromFollowedAuthor')
                      ->orWhere('type', 'App\Notifications\PendingArticleNotification');
            })
            ->orderBy('created_at', 'desc')
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

    /**
     * Lấy thông báo bài viết cần duyệt (API)
     */
    public function pendingArticles()
    {
        $notifications = Auth::user()
            ->notifications()
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

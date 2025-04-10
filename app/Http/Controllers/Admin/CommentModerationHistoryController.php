<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ModerationLog;
use Illuminate\Http\Request;

class CommentModerationHistoryController extends Controller
{
    /**
     * Display the moderation history for a specific comment
     */
    public function show(Comment $comment)
    {
        try {
            // Get all moderation logs for this comment
            $logs = ModerationLog::where('content_type', 'comment')
                ->where('content_id', $comment->comment_id)
                ->with('moderator')
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            // If there's an error (e.g., table doesn't exist), return empty collection
            \Illuminate\Support\Facades\Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt bình luận: ' . $e->getMessage());
            $logs = collect([]);
        }

        return view('admin.comments.moderation-history', compact('comment', 'logs'));
    }
}

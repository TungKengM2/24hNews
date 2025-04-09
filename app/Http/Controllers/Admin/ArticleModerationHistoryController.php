<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ModerationLog;
use Illuminate\Http\Request;

class ArticleModerationHistoryController extends Controller
{
    /**
     * Display the moderation history for a specific article
     */
    public function show(Article $article)
    {
        try {
            // Get all moderation logs for this article
            $logs = ModerationLog::where('content_type', 'article')
                ->where('content_id', $article->article_id)
                ->with('moderator')
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Nếu có lỗi (ví dụ bảng chưa tồn tại), trả về collection rỗng
            \Illuminate\Support\Facades\Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt: ' . $e->getMessage());
            $logs = collect([]);
        }

        return view('admin.articles.moderation-history', compact('article', 'logs'));
    }
}

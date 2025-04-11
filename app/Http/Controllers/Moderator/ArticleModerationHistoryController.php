<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ModerationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            // If there's an error (e.g., table doesn't exist), return empty collection
            Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt bài viết: ' . $e->getMessage());
            $logs = collect([]);
        }

        return view('moderator.articles.moderation-history', compact('article', 'logs'));
    }

    /**
     * Display a listing of moderation history and pending articles for the current moderator
     */
    public function index(Request $request)
    {
        try {
            // Lấy ID của moderator hiện tại
            $currentModeratorId = Auth::id();
            $moderator = Auth::user();

            // Lấy danh sách danh mục mà moderator này quản lý
            $categoryIds = $moderator->categories()->pluck('category_id');

            // 1. Lấy lịch sử kiểm duyệt
            $query = ModerationLog::query()
                ->where('content_type', 'article')
                ->where('moderator_id', $currentModeratorId) // Chỉ lấy lịch sử của moderator hiện tại
                ->with(['moderator']);

            // Lọc theo loại hành động
            if ($request->has('action_type') && !empty($request->action_type)) {
                $query->where('action_type', $request->action_type);
            }

            // Lọc theo khoảng thời gian
            if ($request->has('date_from') && !empty($request->date_from)) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to') && !empty($request->date_to)) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Sắp xếp theo thời gian tạo, mới nhất lên đầu
            $logs = $query->orderBy('created_at', 'desc')
                ->get();

            // 2. Lấy các bài viết đang chờ duyệt thuộc danh mục của moderator
            $pendingArticles = Article::with(['author', 'category'])
                ->where('status', 'pending')
                ->whereIn('category_id', $categoryIds)
                ->orderBy('created_at', 'desc')
                ->get();

            // 3. Lấy thông tin bài viết cho mỗi log
            $articleIds = $logs->pluck('content_id')->unique()->toArray();
            $articles = Article::whereIn('article_id', $articleIds)
                ->get()
                ->keyBy('article_id');

            // 4. Kết hợp dữ liệu để hiển thị
            // Phân trang thủ công
            $page = $request->input('page', 1);
            $perPage = 15;
            $offset = ($page - 1) * $perPage;

            // Tổng số mục
            $totalItems = $logs->count() + $pendingArticles->count();
            $totalPages = ceil($totalItems / $perPage);

            // Phân trang
            $paginatedLogs = $logs->slice($offset, $perPage);
            $paginatedPendingArticles = collect();

            // Nếu logs không đủ để điền trang hiện tại, thêm các bài viết đang chờ duyệt
            if ($paginatedLogs->count() < $perPage) {
                $remainingSlots = $perPage - $paginatedLogs->count();
                $paginatedPendingArticles = $pendingArticles->slice(0, $remainingSlots);
            }

        } catch (\Exception $e) {
            Log::error('Lỗi khi truy vấn danh sách lịch sử kiểm duyệt: ' . $e->getMessage());
            $logs = collect([]);
            $articles = collect([]);
            $pendingArticles = collect([]);
            $paginatedLogs = collect([]);
            $paginatedPendingArticles = collect([]);
            $totalPages = 1;
            $page = 1;
        }

        return view('moderator.articles.moderation-history-list', compact(
            'logs',
            'articles',
            'pendingArticles',
            'paginatedLogs',
            'paginatedPendingArticles',
            'totalPages',
            'page'
        ));
    }
}

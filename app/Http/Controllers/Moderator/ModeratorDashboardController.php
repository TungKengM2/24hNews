<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use App\Models\ArticleLike; // Add this line to import the ArticleLike model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Follow;

class ModeratorDashboardController extends Controller
{
    public function getUserComments($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $comments = Comment::where('user_id', $userId)
            ->whereNotNull('article_id')
            ->with('article')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('moderator.comments', compact('user', 'comments'));
    }


    public function index(Request $request)
    {
        $moderatorId = Auth::id();

        // Lấy ngày bắt đầu, ngày kết thúc và kiểu hiển thị
        $dateFrom = $request->input('date_from') ? Carbon::parse($request->input('date_from'))->startOfDay() : now()->subDays(30)->startOfDay();
        $dateTo = $request->input('date_to') ? Carbon::parse($request->input('date_to'))->endOfDay() : now()->endOfDay();
        $viewType = $request->input('view_type', 'daily'); // daily, monthly, yearly

        // Tạo danh sách khoảng thời gian
        $allDates = [];
        $currentDate = $dateFrom->copy();

        if ($viewType === 'daily') {
            while ($currentDate->lte($dateTo)) {
                $allDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }
        } elseif ($viewType === 'monthly') {
            $currentDate = $dateFrom->copy()->startOfMonth();
            $endDate = $dateTo->copy()->endOfMonth();
            while ($currentDate->lte($endDate)) {
                $allDates[] = $currentDate->format('Y-m');
                $currentDate->addMonth();
            }
        } elseif ($viewType === 'yearly') {
            $currentYear = $dateFrom->year;
            $endYear = $dateTo->year;
            while ($currentYear <= $endYear) {
                $allDates[] = (string)$currentYear;
                $currentYear++;
            }
        }

        // Lấy dữ liệu bài viết theo thời gian (chỉ những bài viết đã được moderator này duyệt)
        $rawArticleStats = DB::table('moderation_logs')
            ->join('articles', 'moderation_logs.content_id', '=', 'articles.article_id')
            ->where('moderation_logs.moderator_id', $moderatorId)
            ->where('moderation_logs.content_type', 'article')
            ->whereBetween('moderation_logs.created_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(moderation_logs.created_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(moderation_logs.created_at, "%Y-%m")' : 'YEAR(moderation_logs.created_at)')) . ' as date,
                COUNT(DISTINCT articles.article_id) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Lấy dữ liệu bình luận theo thời gian (chỉ những bài viết đã được moderator này duyệt)
        $rawCommentsStats = Comment::whereIn('article_id', function($query) use ($moderatorId) {
                $query->select('content_id')
                    ->from('moderation_logs')
                    ->where('moderator_id', $moderatorId)
                    ->where('content_type', 'article');
            })
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(created_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(created_at, "%Y-%m")' : 'YEAR(created_at)')) . ' as date, COUNT(*) as comments')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Lấy dữ liệu lượt thích theo thời gian (chỉ những bài viết đã được moderator này duyệt)
        if (Schema::hasTable('article_likes')) {
            $rawLikesStats = ArticleLike::whereIn('article_id', function($query) use ($moderatorId) {
                    $query->select('content_id')
                        ->from('moderation_logs')
                        ->where('moderator_id', $moderatorId)
                        ->where('content_type', 'article');
                })
                ->whereBetween('liked_at', [$dateFrom, $dateTo])
                ->selectRaw(($viewType === 'daily' ? 'DATE(liked_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(liked_at, "%Y-%m")' : 'YEAR(liked_at)')) . ' as date, COUNT(*) as likes')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->keyBy('date');
        } else {
            $rawLikesStats = collect();
        }

        // Lấy dữ liệu tương tác theo thời gian (chỉ những bài viết đã được moderator này duyệt)
        $rawInteractionStats = ArticleView::whereIn('article_id', function($query) use ($moderatorId) {
                $query->select('content_id')
                    ->from('moderation_logs')
                    ->where('moderator_id', $moderatorId)
                    ->where('content_type', 'article');
            })
            ->whereBetween('viewed_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(viewed_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(viewed_at, "%Y-%m")' : 'YEAR(viewed_at)')) . ' as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Tính toán thống kê bài viết
        $timeBasedArticleStats = [];
        foreach ($allDates as $date) {
            $timeBasedArticleStats[] = [
                'date' => $date,
                'total' => $rawArticleStats[$date]->total ?? 0
            ];
        }

        // Tính toán thống kê tương tác
        $timeBasedInteractionStats = [];
        foreach ($allDates as $date) {
            $timeBasedInteractionStats[] = [
                'date' => $date,
                'views' => $rawInteractionStats[$date]->views ?? 0,
                'comments' => $rawCommentsStats[$date]->comments ?? 0,
                'likes' => $rawLikesStats[$date]->likes ?? 0,
            ];
        }

        // Tính toán thống kê bình luận
        $timeBasedCommentsStats = [];
        foreach ($allDates as $date) {
            $timeBasedCommentsStats[] = [
                'date' => $date,
                'comments' => $rawCommentsStats[$date]->comments ?? 0,
            ];
        }

        // Tính toán thống kê lượt thích
        $timeBasedLikesStats = [];
        foreach ($allDates as $date) {
            $timeBasedLikesStats[] = [
                'date' => $date,
                'likes' => $rawLikesStats[$date]->likes ?? 0,
            ];
        }

        // Tổng quan bài viết (chỉ những bài viết đã được moderator này duyệt)
        $articleStatsSummary = [
            'total' => DB::table('moderation_logs')
                ->join('articles', 'moderation_logs.content_id', '=', 'articles.article_id')
                ->where('moderation_logs.moderator_id', $moderatorId)
                ->where('moderation_logs.content_type', 'article')
                ->select(DB::raw('COUNT(DISTINCT articles.article_id) as total'))
                ->first()
                ->total
        ];

        // Lấy danh sách tag và số lượng bài viết đã xuất bản (chỉ những bài viết đã được moderator này duyệt)
        $tags = Tag::whereHas('articles', function($query) use ($moderatorId) {
                $query->whereIn('articles.article_id', function($q) use ($moderatorId) {
                    $q->select('content_id')
                        ->from('moderation_logs')
                        ->where('moderator_id', $moderatorId)
                        ->where('content_type', 'article');
                });
            })
            ->withCount(['articles' => function($query) use ($moderatorId) {
                $query->whereIn('articles.article_id', function($q) use ($moderatorId) {
                    $q->select('content_id')
                        ->from('moderation_logs')
                        ->where('moderator_id', $moderatorId)
                        ->where('content_type', 'article');
                })->where('articles.status', 'published');
            }])
            ->orderByDesc('articles_count')
            ->get();

        // Nếu là AJAX request, trả về JSON
        if ($request->ajax()) {
            return response()->json([
                'timeBasedArticleStats' => $timeBasedArticleStats,
                'timeBasedInteractionStats' => $timeBasedInteractionStats,
                'timeBasedCommentsStats' => $timeBasedCommentsStats,
                'timeBasedLikesStats' => $timeBasedLikesStats,
                'articleStatsSummary' => $articleStatsSummary,
                'tags' => $tags,
            ]);
        }

        // Nếu không phải AJAX, trả về view
        return view('moderator.dashboard', compact(
            'articleStatsSummary',
            'tags',
            'timeBasedArticleStats',
            'timeBasedInteractionStats',
            'timeBasedCommentsStats',
            'timeBasedLikesStats',
            'dateFrom',
            'dateTo',
            'viewType'
        ));
    }




}

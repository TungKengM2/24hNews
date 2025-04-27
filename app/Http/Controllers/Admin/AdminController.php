<?php

namespace App\Http\Controllers\Admin;

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

class AdminController extends Controller
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

        return view('admin.comments', compact('user', 'comments'));
    }


    public function dashboard(Request $request)
    {
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
            // Lấy 12 tháng gần nhất
            $currentDate = now()->startOfMonth()->subMonths(11); // Bắt đầu từ 11 tháng trước
            while ($currentDate->lte(now()->endOfMonth())) {
                $allDates[] = $currentDate->format('Y-m');
                $currentDate->addMonth();
            }
        } elseif ($viewType === 'yearly') {
            while ($currentDate->lte($dateTo)) {
                $allDates[] = $currentDate->format('Y');
                $currentDate->addYear();
            }
        }

        // Lấy dữ liệu bài viết theo thời gian
        $rawArticleStats = Article::whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(created_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(created_at, "%Y-%m")' : 'YEAR(created_at)')) . ' as date,
                SUM(CASE WHEN status = "published" THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected,
                SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft,
                SUM(CASE WHEN status = "archived" THEN 1 ELSE 0 END) as archived')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $timeBasedArticleStats = [];
        foreach ($allDates as $date) {
            $timeBasedArticleStats[] = [
                'date' => $date,
                'published' => $rawArticleStats[$date]->published ?? 0,
                'pending' => $rawArticleStats[$date]->pending ?? 0,
                'rejected' => $rawArticleStats[$date]->rejected ?? 0,
                'draft' => $rawArticleStats[$date]->draft ?? 0,
                'archived' => $rawArticleStats[$date]->archived ?? 0,
            ];
        }

        // Lấy dữ liệu tương tác theo thời gian
        $rawInteractionStats = ArticleView::whereBetween('viewed_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(viewed_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(viewed_at, "%Y-%m")' : 'YEAR(viewed_at)')) . ' as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

       // Tính timeBasedInteractionStats gộp 3 loại
$timeBasedInteractionStats = [];
foreach ($allDates as $date) {
    $timeBasedInteractionStats[] = [
        'date' => $date,
        'views' => $rawInteractionStats[$date]->views ?? 0,
        'comments' => $rawCommentsStats[$date]->comments ?? 0,
        'likes' => $rawLikesStats[$date]->likes ?? 0,
    ];
}


        // Lấy dữ liệu bình luận theo thời gian
        $rawCommentsStats = Comment::whereBetween('created_at', [$dateFrom, $dateTo])
            ->selectRaw(($viewType === 'daily' ? 'DATE(created_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(created_at, "%Y-%m")' : 'YEAR(created_at)')) . ' as date, COUNT(*) as comments')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $timeBasedCommentsStats = [];
        foreach ($allDates as $date) {
            $timeBasedCommentsStats[] = [
                'date' => $date,
                'comments' => $rawCommentsStats[$date]->comments ?? 0,
            ];
        }

        // Lấy dữ liệu lượt thích theo thời gian
        if (Schema::hasTable('article_likes')) {
            $rawLikesStats = ArticleLike::whereBetween('liked_at', [$dateFrom, $dateTo])
                ->selectRaw(($viewType === 'daily' ? 'DATE(liked_at)' : ($viewType === 'monthly' ? 'DATE_FORMAT(liked_at, "%Y-%m")' : 'YEAR(liked_at)')) . ' as date, COUNT(*) as likes')
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->keyBy('date');
        } else {
            $rawLikesStats = collect();
        }

        $timeBasedLikesStats = [];
        foreach ($allDates as $date) {
            $timeBasedLikesStats[] = [
                'date' => $date,
                'likes' => $rawLikesStats[$date]->likes ?? 0,
            ];
        }

        // Tổng quan bài viết
        $articleStatsSummary = [
            'total' => Article::count(),
            'archived' => Article::where('status', 'archived')->count(),
            'pending' => Article::where('status', 'pending')->count(),
            'published' => Article::where('status', 'published')->count(),
            'rejected' => Article::where('status', 'rejected')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Tổng quan người dùng
        $userCount = [
            'total' => User::where('role_id', '!=', 1)->count(), // Exclude admin
            'user' => User::where('role_id', 4)->count(), // Regular users
            'moderators' => User::where('role_id', 3)->count(), // Moderators
            'authors' => User::where('role_id', 2)->count(), // Authors
        ];

        // Tổng số người theo dõi admin
        $user = Auth::user();
        $totalFollowers = $user->followers()->count(); // Count followers of the logged-in admin

        // Lấy danh sách tag và số lượng bài viết đã xuất bản
        $tags = Tag::whereHas('publishedArticles') // Only tags with published articles
            ->withCount(['publishedArticles']) // Count published articles
            ->orderByDesc('published_articles_count') // Sort by count descending
            ->get();

        // Nếu là AJAX request, trả về JSON
        if ($request->ajax()) {
            return response()->json([
                'timeBasedArticleStats' => $timeBasedArticleStats,
                'timeBasedInteractionStats' => $timeBasedInteractionStats,
                'timeBasedCommentsStats' => $timeBasedCommentsStats,
                'timeBasedLikesStats' => $timeBasedLikesStats,
                'articleStatsSummary' => $articleStatsSummary,
                'userCount' => $userCount,
                'totalFollowers' => $totalFollowers,
            ]);
        }

        // Nếu không phải AJAX, trả về view
        return view('admin.dashboard', compact(
            'articleStatsSummary', // Renamed to avoid conflict
            'userCount',
            'totalFollowers',
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

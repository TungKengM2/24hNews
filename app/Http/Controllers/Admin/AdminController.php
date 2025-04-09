<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment; // dat them
use App\Models\User; // dat them
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // dat them
use Carbon\Carbon; // dat them
use Illuminate\Support\Facades\Schema; // dat them
use Illuminate\Http\Request;
use App\Models\Tag;

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


        $type = $request->input('article_type', 'daily');
        $interactionType = $request->input('interaction_type', $type);

        // // Tổng quan bài viết
        $articleStats = [
            'total' => Article::count(),
            'archived' => Article::where('status', 'archived')->count(),
            'pending' => Article::where('status', 'pending')->count(),
            'published' => Article::where('status', 'published')->count(),
            'reject' => Article::where('status', 'rejected')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Thống kê bài viết theo thời gian
        $timeBasedArticleStats = $this->getTimeBasedArticleStats($type);

        // Thống kê tương tác theo thời gian
        $timeBasedInteractionStats = $this->getTimeBasedInteractionStats($interactionType);

        // // Tổng số người dùng
        // $userCount = User::count();
        // Lấy số lượng người dùng theo vai trò
            $userCount = [
            'total' => User::where('role_id', '!=', 1)->count(), // Tổng số người dùng (không bao gồm admin)
                'user' => User::where('role_id', 4)->count(), // Người dùng
                'moderators' => User::where('role_id', 3)->count(), // Kiểm duyệt viên
                'authors' => User::where('role_id', 2)->count(),    // Tác giả
            ];

        // Tổng lượt xem
        $totalViews = ArticleView::count();

        // Tổng lượt bình luận
        $totalComments = Comment::count();

        // Tổng lượt thích
        $totalLikes = Schema::hasTable('article_likes') ? DB::table('article_likes')->count() : 0;
        //   // Lấy danh sách tag và số lượng bài viết theo từng tag
       // Lấy danh sách tag và số lượng bài viết đã xuất bản
       $tags = Tag::withCount(['publishedArticles'])->get();


        return view('admin.dashboard', compact(

            'tags',
            'articleStats',
            'userCount',
            'totalViews',
            'totalComments',
            'totalLikes',
            'type',
            'interactionType',
            'timeBasedArticleStats',
            'timeBasedInteractionStats'
        ));
    }

    private function getTimeBasedArticleStats($type)
    {
        $query = Article::query();

        if ($type === 'daily') {
            return $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereDate('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->toArray();
        } elseif ($type === 'monthly') {
            return $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->whereDate('created_at', '>=', now()->subMonths(12))
                ->groupBy('year', 'month')
                ->orderBy('year')
                ->orderBy('month')
                ->get()
                ->toArray();
        } else {
            return $query->selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                ->groupBy('year')
                ->orderBy('year')
                ->get()
                ->toArray();
        }
    }

    private function getTimeBasedInteractionStats($type)
    {
        $articleIds = Article::pluck('article_id');

        if ($type === 'daily') {
            return $this->getInteractionStats($articleIds, now()->subDays(30), 'daily');
        } elseif ($type === 'monthly') {
            return $this->getInteractionStats($articleIds, now()->subMonths(12), 'monthly');
        } else {
            return $this->getInteractionStats($articleIds, now()->subYears(5), 'yearly');
        }
    }

    private function getInteractionStats($articleIds, $period, $type)
    {
        $stats = [];

        if ($type === 'daily') {
            $dates = $period->daysUntil(now());
            foreach ($dates as $date) {
                $stats[] = $this->getDailyStats($date, $articleIds);
            }
        } elseif ($type === 'monthly') {
            $months = $period->monthsUntil(now());
            foreach ($months as $month) {
                $stats[] = $this->getMonthlyStats($month, $articleIds);
            }
        } else {
            $years = $period->yearsUntil(now());
            foreach ($years as $year) {
                $stats[] = $this->getYearlyStats($year, $articleIds);
            }
        }

        return $stats;
    }

    private function getDailyStats($date, $articleIds)
    {
        return [
            'date' => $date->format('Y-m-d'),
            'views' => ArticleView::whereIn('article_id', $articleIds)->whereDate('viewed_at', $date)->count(),
            'likes' => DB::table('article_likes')->whereIn('article_id', $articleIds)->whereDate('liked_at', $date)->count(),
            'comments' => Comment::whereIn('article_id', $articleIds)->whereDate('created_at', $date)->count(),
        ];
    }

    private function getMonthlyStats($month, $articleIds)
    {
        return [
            'month' => $month->format('Y-m'),
            'views' => ArticleView::whereIn('article_id', $articleIds)->whereYear('viewed_at', $month->year)->whereMonth('viewed_at', $month->month)->count(),
            'likes' => DB::table('article_likes')->whereIn('article_id', $articleIds)->whereYear('liked_at', $month->year)->whereMonth('liked_at', $month->month)->count(),
            'comments' => Comment::whereIn('article_id', $articleIds)->whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->count(),
        ];
    }

    private function getYearlyStats($year, $articleIds)
    {
        return [
            'year' => $year->format('Y'),
            'views' => ArticleView::whereIn('article_id', $articleIds)->whereYear('viewed_at', $year)->count(),
            'likes' => DB::table('article_likes')->whereIn('article_id', $articleIds)->whereYear('liked_at', $year)->count(),
            'comments' => Comment::whereIn('article_id', $articleIds)->whereYear('created_at', $year)->count(),
        ];
    }

    }

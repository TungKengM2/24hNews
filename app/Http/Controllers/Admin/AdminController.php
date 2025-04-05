<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $type = $request->query('type', 'daily');
        // tổng quan bài viết
        // Thống kê bài viết
        if ($type === 'daily') {
            $articleStatsChart = DB::table('articles')
                ->select(DB::raw('DATE(created_at) as date, CAST(COUNT(*) as UNSIGNED) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $articleStatsChart = DB::table('articles')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, CAST(COUNT(*) as UNSIGNED) as count'))
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();
        } else {
            $articleStatsChart = DB::table('articles')
                ->select(DB::raw('YEAR(created_at) as year, CAST(COUNT(*) as UNSIGNED) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        // Thống kê người dùng
        if ($type === 'daily') {
            $userStats = DB::table('users')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->where('role_id', 4)
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $authorStats = DB::table('users')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->where('role_id', 2)
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            $moderatorStats = DB::table('users')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->where('role_id', 3)
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $userStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('role_id', 4)
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();

            $authorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('role_id', 2)
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();

            $moderatorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('role_id', 3)
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();
        } else {
            $userStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->where('role_id', 4)
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            $authorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->where('role_id', 2)
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            $moderatorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->where('role_id', 3)
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        // Thống kê lượt thích
        if ($type === 'daily') {
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('DATE(liked_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, MONTH(liked_at) as month, COUNT(*) as count'))
                ->groupBy(DB::raw('YEAR(liked_at)'), DB::raw('MONTH(liked_at)'))
                ->orderByRaw('YEAR(liked_at), MONTH(liked_at)')
                ->get();
        } else {
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        // Thống kê bình luận
        if ($type === 'daily') {
            $commentStats = DB::table('comments')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $commentStats = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->orderByRaw('YEAR(created_at), MONTH(created_at)')
                ->get();
        } else {
            $commentStats = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        // Thống kê lượt xem
        if ($type === 'daily') {
            $viewsStats = DB::table('article_views')
                ->select(DB::raw('DATE(viewed_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $viewsStats = DB::table('article_views')
                ->select(DB::raw('YEAR(viewed_at) as year, MONTH(viewed_at) as month, COUNT(*) as count'))
                ->groupBy(DB::raw('YEAR(viewed_at)'), DB::raw('MONTH(viewed_at)'))
                ->orderByRaw('YEAR(viewed_at), MONTH(viewed_at)')
                ->get();
        } else {
            $viewsStats = DB::table('article_views')
                ->select(DB::raw('YEAR(viewed_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        return view('admin.dashboard', compact(
             'likeStats', 'commentStats', 'viewsStats',
            'articleStatsChart', 'userStats', 'authorStats', 'moderatorStats', 'type'
        ));
    }
}
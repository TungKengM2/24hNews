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

    // dat them
    public function dashboard( Request $request)

    {
        // Thống kê bài viết
        $articleStats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'pending' => Article::where('status', 'pending')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Lấy các bài viết gần đây
        $recentArticles = Article::with('author')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Các dữ liệu khác cho biểu đồ thống kê
        // ... code hiện tại của bạn ...

        // thống kê bài viết theo ngày tháng năm dạng biểu đồ
         // Kiểm tra kiểu thống kê: theo ngày, theo tháng hoặc theo năm
     $type = $request->query('type', 'daily'); // Mặc định theo ngày

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
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
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
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();

            $authorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('role_id', 2)
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();

            $moderatorStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->where('role_id', 3)
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
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
        // Thống kê lượt thích theo ngày tháng năm
        if ($type === 'daily') {
            $likeStatsChart = DB::table('article_likes')
                ->select(DB::raw('DATE(liked_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $likeStatsChart = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, MONTH(liked_at) as month, COUNT(*) as count'))
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
            $likeStatsChart = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }
        // Thống Kê Bình Luận
        if ($type === 'daily') {
            $commentStatsChart = DB::table('comments')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $commentStatsChart = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
            $commentStatsChart = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }


        return view('admin.dashboard', compact(
            'articleStats',
            'recentArticles', 'articleStatsChart' ,'userStats','authorStats','moderatorStats', 'likeStatsChart','commentStatsChart','type',
            // ... các biến khác bạn đã có ...
        ));
    }
}

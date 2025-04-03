<?php

namespace App\Http\Controllers\Moderator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // Sử dụng DB facade

class ModeratorDashboardController extends Controller
{
    public function index(Request $request)
    {
     // Kiểm tra kiểu thống kê: theo ngày, theo tháng hoặc theo năm
     $type = $request->query('type', 'daily'); // Mặc định theo ngày

     // Thống kê bài viết
     if ($type === 'daily') {
         $articleStats = DB::table('articles')
             ->select(DB::raw('DATE(created_at) as date, CAST(COUNT(*) as UNSIGNED) as count'))
             ->groupBy('date')
             ->orderBy('date', 'asc')
             ->get();
     } elseif ($type === 'monthly') {
         $articleStats = DB::table('articles')
             ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, CAST(COUNT(*) as UNSIGNED) as count'))
             ->groupBy('year', 'month')
             ->orderByRaw('year, month')
             ->get();
     } else { // yearly
         $articleStats = DB::table('articles')
             ->select(DB::raw('YEAR(created_at) as year, CAST(COUNT(*) as UNSIGNED) as count'))
             ->groupBy('year')
             ->orderBy('year', 'asc')
             ->get();
     }
        // Thống kê người dùng
        if ($type === 'daily') {
            $userStats = DB::table('users')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $userStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
            $userStats = DB::table('users')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }
        // thông kê lượt thích theo ngày tháng năm
        if ($type === 'daily') {
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('DATE(liked_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, MONTH(liked_at) as month, COUNT(*) as count'))
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
            $likeStats = DB::table('article_likes')
                ->select(DB::raw('YEAR(liked_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }
        // thống kê bình luận theo ngày tháng năm
        if ($type === 'daily') {
            $commentStats = DB::table('comments')
                ->select(DB::raw('DATE(created_at) as date, COUNT(*) as count'))
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } elseif ($type === 'monthly') {
            $commentStats = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count'))
                ->groupBy('year', 'month')
                ->orderByRaw('year, month')
                ->get();
        } else { // yearly
            $commentStats = DB::table('comments')
                ->select(DB::raw('YEAR(created_at) as year, COUNT(*) as count'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        return view('moderator.dashboard', compact('articleStats', 'userStats', 'likeStats' ,'commentStats', 'type'));

    }
}

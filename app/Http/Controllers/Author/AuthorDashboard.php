<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment; // dat them
use App\Models\User; // dat them
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // dat them
use Carbon\Carbon; // dat them
use Illuminate\Support\Facades\Schema; // dat them

class AuthorDashboard extends Controller
{
    //        public function __construct()
    //        {
    //            $this->middleware('auth');
    //            $this->middleware('role:author');
    //        }

    public function index()
    {
        $user = Auth::user();
        $articleStats = [
            'total' => Article::where('author_id', $user->user_id)->count(),
            'published' => Article::where('author_id', $user->user_id)
                ->where('status', 'published')
                ->count(),
            'pending' => Article::where('author_id', $user->user_id)
                ->where('status', 'pending')
                ->count(),
            'draft' => Article::where('author_id', $user->user_id)
                ->where('status', 'draft')
                ->count(),
        ];

        $viewsData = ArticleView::where('user_id', $user->user_id)
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->date => $item->views];
            });

        // thêm vào
        // Lấy số lượng người theo dõi
        $followerCount = DB::table('follows')
            ->where('following_id', $user->user_id)
            ->count();
            
        // Lấy bài viết gần đây
        $recentArticles = Article::where('author_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Lấy ID bài viết của tác giả này
        $articleIds = Article::where('author_id', $user->user_id)->pluck('article_id');
        
        // Lấy tổng số lượt xem
        $totalViews = 0;
        if (Schema::hasTable('article_views')) {
            $totalViews = DB::table('article_views')
                ->whereIn('article_id', $articleIds)
                ->count();
        } else {
            // Nếu không có, tính tổng lượt xem trong bảng bài viết
            $totalViews = Article::where('author_id', $user->user_id)->sum('views');
        }
        
        // Lấy tổng số bình luận
        $totalComments = Comment::whereIn('article_id', $articleIds)->count();
        
        // Lấy tổng số lượt thích
        $totalLikes = 0;
        if (Schema::hasTable('article_likes')) {
            $totalLikes = DB::table('article_likes')
                ->whereIn('article_id', $articleIds)
                ->count();
        }

        return view('author.dashboard', compact(
            'articleStats', 
            'viewsData', 
            'followerCount',
            'recentArticles',
            'totalViews',
            'totalComments',
            'totalLikes'
        ));
    }
    
    /**
     * Hiển thị danh sách người theo dõi của tác giả đã xác thực
     */
    public function followers()
    {
        $user = Auth::user();
        
        // Lấy người theo dõi với phân trang
        $followers = DB::table('follows')
            ->join('users', 'follows.follower_id', '=', 'users.user_id')
            ->where('follows.following_id', $user->user_id)
            ->select('users.*', 'follows.created_at as followed_at')
            ->orderBy('follows.created_at', 'desc')
            ->paginate(20);
            
        return view('author.followers', compact('followers'));
    }
}

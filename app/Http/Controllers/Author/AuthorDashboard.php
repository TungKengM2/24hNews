<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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

        // Get follower count
        $followerCount = DB::table('follows')
            ->where('following_id', $user->user_id)
            ->count();
            
        // Get recent articles
        $recentArticles = Article::where('author_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // Get article IDs by this author
        $articleIds = Article::where('author_id', $user->user_id)->pluck('article_id');
        
        // Get total views
        $totalViews = 0;
        if (Schema::hasTable('article_views')) {
            $totalViews = DB::table('article_views')
                ->whereIn('article_id', $articleIds)
                ->count();
        } else {
            // Fallback to sum of views in articles table
            $totalViews = Article::where('author_id', $user->user_id)->sum('views');
        }
        
        // Get total comments
        $totalComments = Comment::whereIn('article_id', $articleIds)->count();
        
        // Get total likes
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
     * Display the list of followers for the authenticated author
     */
    public function followers()
    {
        $user = Auth::user();
        
        // Get followers with pagination
        $followers = DB::table('follows')
            ->join('users', 'follows.follower_id', '=', 'users.user_id')
            ->where('follows.following_id', $user->user_id)
            ->select('users.*', 'follows.created_at as followed_at')
            ->orderBy('follows.created_at', 'desc')
            ->paginate(20);
            
        return view('author.followers', compact('followers'));
    }
}

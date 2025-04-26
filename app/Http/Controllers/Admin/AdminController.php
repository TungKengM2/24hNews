<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Tag;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $type = $request->input('article_type', 'daily');
        $interactionType = $request->input('interaction_type', $type);

        // Lọc theo ngày bắt đầu và ngày kết thúc
        $dateFrom = $request->input('date_from') ? Carbon::parse($request->input('date_from')) : null;
        $dateTo = $request->input('date_to') ? Carbon::parse($request->input('date_to')) : null;

        // Lọc bài viết dựa trên khoảng thời gian
        $articlesQuery = Article::query();
        if ($dateFrom) {
            $articlesQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $articlesQuery->where('created_at', '<=', $dateTo);
        }

        $articleStats = [
            'total' => $articlesQuery->count(),
            'archived' => (clone $articlesQuery)->where('status', 'archived')->count(),
            'pending' => (clone $articlesQuery)->where('status', 'pending')->count(),
            'published' => (clone $articlesQuery)->where('status', 'published')->count(),
            'reject' => (clone $articlesQuery)->where('status', 'rejected')->count(),
            'draft' => (clone $articlesQuery)->where('status', 'draft')->count(),
        ];

        // Lọc dữ liệu tương tác theo khoảng thời gian
        $interactionQuery = ArticleView::query();
        if ($dateFrom) {
            $interactionQuery->where('viewed_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $interactionQuery->where('viewed_at', '<=', $dateTo);
        }

        $totalViews = $interactionQuery->count();

        $commentQuery = Comment::query();
        if ($dateFrom) {
            $commentQuery->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $commentQuery->where('created_at', '<=', $dateTo);
        }

        $totalComments = $commentQuery->count();

        $likeQuery = Schema::hasTable('article_likes') ? DB::table('article_likes') : null;
        $totalLikes = 0;
        if ($likeQuery) {
            if ($dateFrom) {
                $likeQuery->where('liked_at', '>=', $dateFrom);
            }
            if ($dateTo) {
                $likeQuery->where('liked_at', '<=', $dateTo);
            }
            $totalLikes = $likeQuery->count();
        }

        // Tổng số người theo dõi người dùng đang đăng nhập
        $user = Auth::user();
        $totalFollowers = $user ? $user->followers()->count() : 0;

        // Lấy danh sách tag và số lượng bài viết theo từng tag
        $tags = Tag::whereHas('publishedArticles')
            ->withCount(['publishedArticles'])
            ->orderByDesc('published_articles_count')
            ->get();

        // Tổng số người dùng
        $userCount = [
            'total' => User::where('role_id', '!=', 1)->count(),
            'user' => User::where('role_id', 4)->count(),
            'moderators' => User::where('role_id', 3)->count(),
            'authors' => User::where('role_id', 2)->count(),
        ];

        return view('admin.dashboard', compact(
            'tags',
            'articleStats',
            'userCount',
            'totalViews',
            'totalComments',
            'totalLikes',
            'totalFollowers',
            'type',
            'interactionType',
            'dateFrom',
            'dateTo'
        ));
    }
}
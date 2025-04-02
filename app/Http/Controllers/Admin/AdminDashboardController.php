<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Like;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Thống kê bài viết
        $articleStats = [
            'total' => Article::count(),
            'published' => Article::where('status', 'published')->count(),
            'pending' => Article::where('status', 'pending')->count(),
            'draft' => Article::where('status', 'draft')->count(),
        ];

        // Thống kê người dùng - Sử dụng DB facade trực tiếp
        $userCount = DB::table('users')->count();
        
        // Log để kiểm tra
        \Log::info('User count: ' . $userCount);

        // Thống kê tương tác
        $totalViews = Article::sum('views');
        $totalComments = Comment::count();
        $totalLikes = Like::count();

        return view('admin.dashboard', compact(
            'articleStats',
            'userCount',
            'totalViews',
            'totalComments',
            'totalLikes'
        ));
    }

    public function getArticleStats()
    {
        $data = [
            'likes' => ArticleLike::count(),
            'comments' => Comment::count(),
            'views' => ArticleView::count()
        ];

        return response()->json($data);
    }


    public function getUserStats()
    {
        $users = User::join('roles', 'users.role_id', '=', 'roles.role_id')
            ->selectRaw("DATE_FORMAT(users.created_at, '%Y-%m') as period,
                COUNT(CASE WHEN roles.name = 'user' THEN 1 END) as users,
                COUNT(CASE WHEN roles.name = 'author' THEN 1 END) as authors,
                COUNT(CASE WHEN roles.name = 'moderator' THEN 1 END) as moderators")
            ->groupBy('period')
            ->orderBy('period', 'asc')
            ->get();

        return response()->json($users);
    }





    public function showListPost()
    {
        return view('admin.articles.index');
    }

    public function showCreatePost()
    {
        return view('admin.articles.create');
    }

    public function showEditPost()
    {
        return view('admin.articles.edit');
    }

    // duyệt bài viết
    public function Approves()
    {
        return view('admin.articles.approve');
    }

    // CATEGORY
    public function showListCategory()
    {
        return view('admin.categories.listcategories');
    }

    public function showCreateCategory()
    {
        return view('admin.categories.createcategories');
    }

    public function showEditCategory()
    {
        return view('admin.categories.editcategories');
    }

    public function roleUpgradeRequests()
    {
        $requests = Approval::where('type', 'role_upgrade')
            ->where('status', 'pending')
            ->with('user')
            ->paginate(10);

        return view('admin.users.index', compact('requests'));
    }

    public function approveRoleUpgrade(Approval $approval)
    {
        DB::transaction(function () use ($approval) {
            $user = $approval->user;
            $role = Role::where('name', $approval->requested_role)
                ->firstOrFail();

            $user->update(['role_id' => 2]);

            $approval->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.user-role-requests')
            ->with('success', 'Đã duyệt yêu cầu nâng cấp vai trò');
    }

    public function rejectRoleUpgrade(Approval $approval)
    {
        $approval->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.user-role-requests')
            ->with('warning', 'Đã từ chối yêu cầu nâng cấp vai trò');
    }
}

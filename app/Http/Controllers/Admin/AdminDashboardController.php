<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    // POST
    {
        // return view('admin.layouts.dashboard');
        return view('admin.dashboard');
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
            ->get();

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

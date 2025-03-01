<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Role;
use App\Models\User;

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

        return view('admin.users.userRoleRequests', compact('requests'));
    }

    public function approveRoleUpgrade($approval_id)
    {
        $approval = Approval::findOrFail($approval_id);

        // Cập nhật vai trò của người dùng
        $user = User::find($approval->user_id);
        $role = Role::where('name', $approval->requested_role)
            ->first();
        $user->role_id = $role->role_id;
        $user->save();

        // Cập nhật trạng thái phê duyệt
        $approval->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.role-upgrade-requests')
            ->with('status', 'Role upgrade approved successfully.');
    }

    public function rejectRoleUpgrade($approval_id)
    {
        $approval = Approval::findOrFail($approval_id);

        $approval->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.role-upgrade-requests')
            ->with('status', 'Role upgrade rejected successfully.');
    }
}

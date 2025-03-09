<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        $role_id = $request->input('role_id');

        $users = User::with('role')
            ->when($role_id, function ($query) use ($role_id) {
                return $query->where('role_id', $role_id);
            })
            ->paginate(10);

        return view('admin.users.index',
            compact('users', 'roles', 'role_id'));
    }

    public function roleUpgradeRequests(Request $request)
    {
        $roles = Role::all();
        $role_id = $request->input('role_id');

        $approvals = Approval::with('user.role')
            ->where('type', 'role_upgrade')
            ->when($role_id, function ($query) use ($role_id) {
                return $query->whereHas('user',
                    function ($q) use ($role_id) {
                        $q->where('role_id', $role_id);
                    });
            })
            ->paginate(10);

        return view('admin.users.upgrade-requests',
            compact('approvals', 'roles', 'role_id'));
    }

    public function approve(Request $request, $id)
    {
        $approval = Approval::findOrFail($id);
        $user = $approval->user;

        $role = Role::where('name', $approval->requested_role)->first();
        if ($role) {
            $user->update(['role_id' => $role->role_id]);
        }

        $approval->update(['status' => 'approved']);

        return redirect()
            ->back()
            ->with('success', 'Duyệt yêu cầu thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function reject(Request $request, $id)
    {
        $approval = Approval::findOrFail($id);
        $approval->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', 'Từ chối yêu cầu thành công!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

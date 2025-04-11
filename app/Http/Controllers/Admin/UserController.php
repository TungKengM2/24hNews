<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view(
            'admin.users.index',
            compact('users', 'roles', 'role_id')
        );
    }
    public function showApprovalDetail($id)
    {
        $approval = Approval::with('user')->findOrFail($id);
        $user = $approval->user;
    
        // Tính số ngày hoạt động
        $accountAge = now()->diffInDays($user->created_at);
    
        // Kiểm tra tình trạng cấm tài khoản
        $isBanned = $user->banned_until !== null && now()->lessThan($user->banned_until);
        $banMessage = $isBanned ? "Bị cấm đến " . $user->banned_until->format('d/m/Y') : "Không bị cấm";
    
        // Lấy danh sách chứng chỉ
        $certificates = json_decode($approval->certificates, true) ?? [];
    
        return view('admin.users.show', compact('approval', 'user', 'accountAge', 'isBanned', 'banMessage', 'certificates'));
    }
    
    

    public function roleUpgradeRequests(Request $request)
    {
        $roles = Role::all();
        $role_id = $request->input('role_id');

        $approvals = Approval::with('user.role')
            ->where('type', 'role_upgrade')
            ->when($role_id, function ($query) use ($role_id) {
                return $query->whereHas(
                    'user',
                    function ($q) use ($role_id) {
                        $q->where('role_id', $role_id);
                    }
                );
            })
            ->paginate(10);

        return view(
            'admin.users.upgrade-requests',
            compact('approvals', 'roles', 'role_id')
        );
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
        try {
            $approval = Approval::findOrFail($id);
            
            // Kiểm tra xem yêu cầu đã được xử lý chưa
            if ($approval->status !== 'pending') {
                return redirect()->back()->with('error', 'Yêu cầu này đã được xử lý trước đó.');
            }

            // Validate lý do từ chối
            $request->validate([
                'reject_reason' => 'required|string|min:10|max:500'
            ]);

            // Cập nhật trạng thái yêu cầu
            $approval->status = 'rejected';
            $approval->reject_reason = $request->reject_reason;
            $approval->processed_at = now();
            $approval->processed_by = auth()->id();
            $approval->save();

            // Ghi log kiểm duyệt
            DB::table('moderation_logs')->insert([
                'content_type' => 'role_upgrade',
                'content_id' => $approval->user_id,
                'action_type' => 'reject',
                'moderator_id' => auth()->id(),
                'reason' => $request->reject_reason,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Gửi thông báo cho người dùng
            if ($approval->user) {
                $approval->user->notify(new \App\Notifications\RoleUpgradeRejected($approval));
            }

            return redirect()->back()->with('success', 'Đã từ chối yêu cầu nâng cấp vai trò.');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi từ chối yêu cầu nâng cấp vai trò: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi từ chối yêu cầu: ' . $e->getMessage());
        }
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

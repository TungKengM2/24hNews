<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ModerationLog;
use Illuminate\Http\Request;

class UserModerationHistoryController extends Controller
{
    /**
     * Display the moderation history for a specific user's role upgrades
     */
    public function show(User $user)
    {
        try {
            // Get all moderation logs for this user's role upgrades
            $logs = ModerationLog::where('content_type', 'role_upgrade')
                ->where('content_id', $user->user_id)
                ->with('moderator')
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            // If there's an error (e.g., table doesn't exist), return empty collection
            \Illuminate\Support\Facades\Log::error('Lỗi khi truy vấn lịch sử kiểm duyệt nâng cấp vai trò: ' . $e->getMessage());
            $logs = collect([]);
        }

        return view('admin.users.moderation-history', compact('user', 'logs'));
    }
}

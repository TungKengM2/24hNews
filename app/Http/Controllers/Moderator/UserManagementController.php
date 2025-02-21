<?php

    namespace App\Http\Controllers\Moderator;

    use App\Http\Controllers\Controller;
    use App\Models\Approval;
    use Illuminate\Http\Request;
    use App\Models\User;

    class UserManagementController extends Controller
    {

        public function index()
        {
            return view('moderator.pages.users.index');
        }

        public function approveUpgrade($approval_id)
        {
            $approval = Approval::findOrFail($approval_id);

            if ($approval->status !== 'pending') {
                return redirect()->route('moderator.dashboard')
                    ->with('error', 'Yêu cầu này đã được xử lý trước đó.');
            }

            $user = User::find($approval->user_id);
            if ($user) {
                $user->role_id = config('roles.author');
                $user->save();
            }

            $approval->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
            ]);

            return redirect()->route('moderator.dashboard')
                ->with('status',
                    'Yêu cầu nâng cấp đã được chấp nhận thành công.');
        }

        public function rejectUpgrade($approval_id)
        {
            $approval = Approval::findOrFail($approval_id);

            if ($approval->status !== 'pending') {
                return redirect()->route('moderator.dashboard')
                    ->with('error', 'Yêu cầu này đã được xử lý trước đó.');
            }

            $approval->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
            ]);

            return redirect()->route('moderator.dashboard')
                ->with('status', 'Yêu cầu nâng cấp đã bị từ chối.');
        }

    }

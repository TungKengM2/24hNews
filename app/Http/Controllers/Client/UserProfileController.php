<?php

    namespace App\Http\Controllers\Client;

    use App\Http\Controllers\Controller;
    use App\Models\Approval;
    use Illuminate\Http\Request;

    class UserProfileController extends Controller
    {

        public function index()
        {
            $user = auth()->user();
            return view('client.profile.layouts.home', ['user' => $user]);
        }

        public function requestAuthorRole(Request $request)
        {
            $existingRequest = Approval::where('type', 'role_upgrade')
                ->where('status', 'pending')
                ->where('user_id', auth()->id())
                ->exists();

            if ($existingRequest) {
                return redirect()
                    ->route('user.dashboard')
                    ->with('error', 'You have already submitted a request.');
            }

            Approval::create([
                'type' => 'role_upgrade',
                'article_id' => null,
                'user_id' => auth()->id(),
                'approved_by' => null,
                'status' => 'pending',
                'requested_role' => 'author',
                'remarks' => 'Yêu cầu nâng cấp lên tác giả',
                'auto_reviewed' => 0,
            ]);

            return redirect()
                ->route('user.dashboard')
                ->with('status',
                    'Yêu cầu nâng cấp của bạn đã được gửi thành công!');
        }

    }

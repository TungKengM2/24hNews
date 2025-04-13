<?php

namespace App\Http\Controllers;

use App\Models\EditRequest;
use App\Models\Article;
use App\Models\User;
use App\Notifications\EditRequestNotification;
use Illuminate\Http\Request;

class EditRequestController extends Controller
{
    public function index()
    {
        $editRequests = EditRequest::with(['article', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.edit-requests.index', compact('editRequests'));
    }

    public function store(Request $request, Article $article)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $editRequest = EditRequest::create([
            'article_id' => $article->id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        // Notify moderators and admins
        $moderators = User::whereIn('role', ['moderator', 'admin'])->get();
        foreach ($moderators as $moderator) {
            $moderator->notify(new EditRequestNotification($editRequest));
        }

        return redirect()->back()->with('success', 'Yêu cầu chỉnh sửa đã được gửi.');
    }

    public function approve(EditRequest $editRequest)
    {
        $editRequest->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        // Notify the article author
        $editRequest->user->notify(new EditRequestNotification($editRequest));

        return response()->json(['success' => true]);
    }

    public function reject(Request $request, EditRequest $editRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $editRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now()
        ]);

        // Notify the article author
        $editRequest->user->notify(new EditRequestNotification($editRequest));

        return redirect()->back()->with('success', 'Yêu cầu chỉnh sửa đã bị từ chối.');
    }
}

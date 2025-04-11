<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleEditRequest;
use App\Models\Article;
use App\Notifications\ArticleEditRequestApproved;
use App\Notifications\ArticleEditRequestRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleEditRequestController extends Controller
{
    public function index()
    {
        try {
            $requests = ArticleEditRequest::with(['article', 'author'])
                ->where('status', 'pending')
                ->latest()
                ->paginate(10);

            return view('admin.article-edit-requests.index', compact('requests'));
        } catch (\Exception $e) {
            Log::error('Error fetching article edit requests: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải danh sách yêu cầu chỉnh sửa.');
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $editRequest = ArticleEditRequest::findOrFail($id);

            if ($editRequest->status !== 'pending') {
                return back()->with('error', 'Yêu cầu này không còn ở trạng thái chờ duyệt.');
            }

            // Update edit request status
            $editRequest->update([
                'status' => 'approved',
                'admin_note' => $request->admin_note,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // Update article status
            $article = $editRequest->article;
            $article->status = 'editing';
            $article->save();

            // Send notification to author
            try {
                $editRequest->author->notify(new ArticleEditRequestApproved($editRequest));
            } catch (\Exception $e) {
                Log::error('Failed to send approval notification: ' . $e->getMessage());
            }

            DB::commit();
            return back()->with('success', 'Đã phê duyệt yêu cầu chỉnh sửa.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving edit request: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi phê duyệt yêu cầu.');
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ], [
            'admin_note.required' => 'Vui lòng nhập lý do từ chối.',
            'admin_note.max' => 'Lý do từ chối không được vượt quá 500 ký tự.',
        ]);

        try {
            DB::beginTransaction();

            $editRequest = ArticleEditRequest::findOrFail($id);

            if ($editRequest->status !== 'pending') {
                return back()->with('error', 'Yêu cầu này không còn ở trạng thái chờ duyệt.');
            }

            // Update edit request status
            $editRequest->update([
                'status' => 'rejected',
                'admin_note' => $request->admin_note,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);

            // Send notification to author
            try {
                $editRequest->author->notify(new ArticleEditRequestRejected($editRequest));
            } catch (\Exception $e) {
                Log::error('Failed to send rejection notification: ' . $e->getMessage());
            }

            DB::commit();
            return back()->with('success', 'Đã từ chối yêu cầu chỉnh sửa.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error rejecting edit request: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi từ chối yêu cầu.');
        }
    }
}

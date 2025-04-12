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
                return back()->with('sweet_alert', [
                'type' => 'warning',
                'title' => 'Không thể phê duyệt!',
                'text' => 'Yêu cầu này không còn ở trạng thái chờ duyệt.'
            ]);
            }

            // Update edit request status
            $editRequest->update([
                'status' => 'approved',
                'admin_note' => $request->admin_note,
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'edit_expires_at' => now()->addMinutes(30) // Thời gian chỉnh sửa hết hạn sau 30 phút
            ]);

            // Update article status
            $article = $editRequest->article;
            $article->status = 'editing';
            $article->save();

            // Send notification to author
            try {
                \App\Helpers\NotificationHelper::sendCustomNotification(
                    $editRequest->author,
                    'Yêu cầu chỉnh sửa được chấp nhận',
                    'Yêu cầu chỉnh sửa bài viết "' . $editRequest->article->title . '" đã được chấp nhận. Bạn có 30 phút để chỉnh sửa trường ' . $editRequest->field_to_edit . '.',
                    'edit_request_approved',
                    [
                        'article_id' => $editRequest->article_id,
                        'request_id' => $editRequest->id,
                        'field_to_edit' => $editRequest->field_to_edit,
                        'edit_expires_at' => $editRequest->edit_expires_at
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to send approval notification: ' . $e->getMessage());
            }

            DB::commit();
            return back()->with('sweet_alert', [
                'type' => 'success',
                'title' => 'Phê duyệt thành công!',
                'text' => 'Đã phê duyệt yêu cầu chỉnh sửa. Tác giả có 30 phút để chỉnh sửa bài viết.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error approving edit request: ' . $e->getMessage());
            return back()->with('sweet_alert', [
                'type' => 'error',
                'title' => 'Lỗi!',
                'text' => 'Có lỗi xảy ra khi phê duyệt yêu cầu: ' . $e->getMessage()
            ]);
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
                \App\Helpers\NotificationHelper::sendCustomNotification(
                    $editRequest->author,
                    'Yêu cầu chỉnh sửa bị từ chối',
                    'Yêu cầu chỉnh sửa bài viết "' . $editRequest->article->title . '" đã bị từ chối.',
                    'edit_request_rejected',
                    [
                        'article_id' => $editRequest->article_id,
                        'request_id' => $editRequest->id,
                        'reason' => $editRequest->admin_note
                    ]
                );
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

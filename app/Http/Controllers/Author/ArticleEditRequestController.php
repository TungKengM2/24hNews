<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleEditRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ArticleEditRequestController extends Controller
{
    public function index()
    {
        $requests = ArticleEditRequest::with(['article', 'author'])
            ->where('author_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('author.article-edit-requests.index', compact('requests'));
    }

    /**
     * Kiểm tra trạng thái yêu cầu chỉnh sửa của bài viết
     *
     * @param int $article_id
     * @return array Trạng thái yêu cầu chỉnh sửa và yêu cầu nếu có
     */
    public static function getEditStatus($article_id)
    {
        $request = ArticleEditRequest::where('article_id', $article_id)
            ->where('author_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$request) {
            return [
                'status' => 'none',
                'request' => null
            ];
        }

        return [
            'status' => $request->status,
            'request' => $request
        ];
    }

    public function store(Request $request, $article_id)
    {
        Log::info('Receiving edit request for article: ' . $article_id);
        Log::info('Request data:', $request->all());

        try {
            DB::beginTransaction();

            // Kiểm tra xem bài viết có tồn tại không
            $article = Article::findOrFail($article_id);
            Log::info('Found article:', ['article' => $article->toArray()]);

            // Kiểm tra xem đã có yêu cầu pending nào chưa
            $existingRequest = ArticleEditRequest::where('article_id', $article_id)
                ->where('author_id', Auth::id())
                ->where('status', 'pending')
                ->first();

            if ($existingRequest) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Bạn đã có một yêu cầu chỉnh sửa đang chờ xử lý cho bài viết này.');
            }

            // Tạo yêu cầu mới
            $editRequest = new ArticleEditRequest();
            $editRequest->article_id = $article_id;
            $editRequest->author_id = Auth::id();
            $editRequest->reason = $request->input('reason');
            $editRequest->status = 'pending';
            $editRequest->save();

            Log::info('Created edit request:', ['editRequest' => $editRequest->toArray()]);

            // Tạo thông báo cho admin
            $admins = User::where('role', 1)->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->user_id,
                    'title' => 'Yêu cầu chỉnh sửa bài viết mới',
                    'message' => 'Tác giả ' . Auth::user()->name . ' đã yêu cầu chỉnh sửa bài viết: ' . $article->title,
                    'type' => 'new_edit_request',
                    'data' => json_encode([
                        'article_id' => $article_id,
                        'request_id' => $editRequest->id,
                        'author_id' => Auth::id()
                    ]),
                    'read_at' => null
                ]);
            }

            DB::commit();
            Log::info('Edit request process completed successfully');

            return redirect()->back()->with('success', 'Yêu cầu chỉnh sửa đã được gửi thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ArticleEditRequestController@store: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi gửi yêu cầu: ' . $e->getMessage());
        }
    }

    public function cancel(ArticleEditRequest $request)
    {
        if ($request->author_id !== Auth::id()) {
            return back()->with('error', 'Bạn không có quyền hủy yêu cầu này.');
        }

        if ($request->status !== 'pending') {
            return back()->with('error', 'Không thể hủy yêu cầu đã được xử lý.');
        }

        $request->delete();
        return back()->with('success', 'Yêu cầu chỉnh sửa đã được hủy.');
    }
}

<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleVersion;
use App\Models\ModerationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Notifications\ArticleStatusUpdated;
use App\Models\Approval;

class ModeratorArticleController extends Controller
{
    public function index(Request $request)
    {
        $moderator = auth()->user(); // Lấy kiểm duyệt viên đang đăng nhập

        // Lấy danh sách danh mục mà kiểm duyệt viên này quản lý
        $categoryIds = $moderator->categories()->pluck('category_id');

        // Lọc bài viết thuộc danh mục kiểm duyệt viên quản lý
        $articles = Article::with(['author', 'category', 'approver', 'tags'])
            ->where('status', 'pending')
            ->whereIn('category_id', $categoryIds) // Chỉ lấy bài viết thuộc danh mục của KDV
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('moderator.articles.index', compact('articles'));
    }

    /**
     * Hiển thị chi tiết bài viết
     */
    public function show(Article $article)
    {
        $moderator = auth()->user();
        $categoryIds = $moderator->categories()->pluck('category_id');

        // Kiểm tra xem bài viết có thuộc danh mục mà moderator quản lý không
        if (!in_array($article->category_id, $categoryIds->toArray())) {
            return redirect()->route('moderator.articles.index')
                ->with('error', 'Bạn không có quyền xem bài viết này.');
        }

        return view('moderator.articles.show', compact('article'));
    }



    public function approve(Article $article)
    {
        if ($article->status === 'published') {
            return redirect()->back()->with('error', 'Bài viết đã được duyệt trước đó.');
        }

        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để duyệt.');
        }

        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status,
            'approved_by' => $article->approved_by
        ];

        $article->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
        ]);

        // Cập nhật hoặc tạo bản ghi Approval
        $approval = Approval::where('article_id', $article->article_id)->first();
        if ($approval) {
            $approval->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'remarks' => 'Bài viết đã được duyệt',
            ]);
        } else {
            Approval::create([
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => $article->author_id,
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'remarks' => 'Bài viết đã được duyệt',
            ]);
        }

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => 'published',
            'approved_by' => auth()->id(),
            'published_at' => now()->toDateTimeString()
        ];

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                'approve',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => 'Phê duyệt bài viết'
                ],
                $beforeState,
                $afterState,
                'none'
            );
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn luồng
            Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
        }

        // Gửi thông báo cho tác giả
        if ($article->author) {
            $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã được duyệt."));
        }

        return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
    }


    // public function reject(Article $article, Request $request)
    // {
    //     if ($article->status !== 'pending') {
    //         return redirect()->back()->with('error', 'Bài viết không ở trạng thái chờ duyệt.');
    //     }

    //     // Lưu trạng thái trước khi cập nhật
    //     $beforeState = [
    //         'status' => $article->status
    //     ];

    //     $article->update([
    //         'status' => 'rejected',
    //     ]);

    //     // Lưu trạng thái sau khi cập nhật
    //     $afterState = [
    //         'status' => 'rejected',
    //         'rejected_at' => now()->toDateTimeString()
    //     ];

    //     // Lấy lý do từ chối nếu có
    //     $reason = $request->input('rejection_reason', 'Không đạt yêu cầu');

    //     // Tạo log kiểm duyệt
    //     try {
    //         ModerationLog::createLog(
    //             'reject',
    //             'article',
    //             $article->article_id,
    //             [
    //                 'title' => $article->title,
    //                 'author_id' => $article->author_id,
    //                 'category_id' => $article->category_id,
    //                 'action' => 'Từ chối bài viết',
    //                 'reason' => $reason
    //             ],
    //             $beforeState,
    //             $afterState,
    //             'medium'
    //         );
    //     } catch (\Exception $e) {
    //         // Ghi log lỗi nhưng không làm gián đoạn luồng
    //         Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
    //     }

    //     // Gửi thông báo cho tác giả
    //     if ($article->author) {
    //         $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối."));
    //     }

    //     return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
    // }

    /**
     * Hiển thị danh sách các phiên bản của bài viết
     */
    public function versions(Article $article)
    {

        $versions = ArticleVersion::where('article_id', $article->article_id)
            ->with(['user', 'category', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('moderator.articles.versions', compact('article', 'versions'));
    }

    // return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
    public function reject(Request $request, Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không ở trạng thái chờ duyệt.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status,
            'approved_by' => $article->approved_by
        ];

        $article->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Cập nhật hoặc tạo bản ghi Approval
        $approval = Approval::where('article_id', $article->article_id)->first();
        if ($approval) {
            $approval->update([
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'remarks' => $request->rejection_reason,
            ]);
        } else {
            Approval::create([
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => $article->author_id,
                'status' => 'rejected',
                'approved_by' => auth()->id(),
                'remarks' => $request->rejection_reason,
            ]);
        }

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason
        ];

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                'reject',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => 'Từ chối bài viết',
                    'reason' => $request->rejection_reason // Thêm lý do từ chối vào details
                ],
                $beforeState,
                $afterState,
                'medium' // Sửa thành giá trị severity hợp lệ
            );
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn luồng
            Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
        }

        // Gửi thông báo cho tác giả
        if ($article->author) {
            $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối. Lý do: {$request->rejection_reason}"));
        }

        return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
    }
}






<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
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



    public function approve(Article $article)
{
    if ($article->status === 'published') {
        return redirect()->back()->with('error', 'Bài viết đã được duyệt trước đó.');
    }

    if ($article->status !== 'pending') {
        return redirect()->back()->with('error', 'Bài viết không hợp lệ để duyệt.');
    }

    $article->update([
        'status' => 'published',
        'approved_by' => auth()->id(),
    ]);

    // Gửi thông báo cho tác giả
    if ($article->author) {
        $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn  đã được duyệt."));
    }

    return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
}


   public function reject(Request $request, Article $article)
{
    if ($article->status !== 'pending') {
        return redirect()->back()->with('error', 'Bài viết không ở trạng thái chờ duyệt.');
    }

    $request->validate([
        'rejection_reason' => 'required|string|max:500',
    ]);

    $article->update([
        'status' => 'rejected',
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

    // Gửi thông báo cho tác giả
    if ($article->author) {
        $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối. Lý do: {$request->rejection_reason}"));
    }

    return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
}

}

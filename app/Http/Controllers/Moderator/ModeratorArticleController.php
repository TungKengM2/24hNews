<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;


class ModeratorArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['author', 'category', 'approver', 'tags'])
            ->where('status', 'pending') // Chỉ lấy bài viết có trạng thái pending
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

        return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
    }

    public function reject(Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không ở trạng thái chờ duyệt.');
        }

        // Đảm bảo 'rejected' nằm trong dấu nháy đơn
        $article->update([
            'status' => 'rejected',
        ]);

        return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
    }

}

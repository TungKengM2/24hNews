<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;



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
    public function show(Article $article)
    {
        return view('moderator.articles.show', compact('article'));
    }
}

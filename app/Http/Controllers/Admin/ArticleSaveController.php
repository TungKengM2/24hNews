<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleSaveController extends Controller
{
    /**
     * Lưu bài viết vào danh sách đã lưu
     */
    public function saveArticle(Request $request)
    {
        $user = Auth::user();
        $articleId = $request->article_id;

        // Kiểm tra xem bài viết đã được lưu chưa
        $existingSave = ArticleSave::where('user_id', $user->user_id)
            ->where('article_id', $articleId)
            ->first();

        if ($existingSave) {
            return response()->json([
                'message' => 'Bạn đã lưu bài viết này rồi!',
                'saved' => true
            ]);
        }

        // Lưu bài viết
        ArticleSave::create([
            'user_id' => $user->user_id,
            'article_id' => $articleId
        ]);

        return response()->json([
            'message' => 'Đã lưu bài viết thành công!',
            'saved' => true
        ]);
    }

    public function toggleBookmark($article_id)
    {
        $user = Auth::user();
        $existingBookmark = ArticleSave::where('user_id', $user->user_id)
            ->where('article_id', $article_id)
            ->first();

        if (!$existingBookmark) {
            // Nếu chưa lưu, thì lưu bài viết
            ArticleSave::create([
                'user_id' => $user->user_id,
                'article_id' => $article_id
            ]);
            session()->flash('message', 'Bài viết đã được lưu thành công!');
        }
        return back()->with('message', 'Bài viết đã được lưu thành công!');
    }



    /**
     * Lấy danh sách bài viết đã lưu của user
     */
    public function savedArticles()
    {
        $user = Auth::user();

        // Lấy danh sách bài viết đã lưu kèm thông tin bài viết
        $savedArticles = ArticleSave::where('user_id', $user->user_id)
            ->with('article') // Load thông tin bài viết
            ->latest()
            ->paginate(10);

        return view('admin.saved', compact('savedArticles'));
    }

    public function removeSavedArticle($id)
    {
        $userId = auth()->id();
        $savedArticle = ArticleSave::where('id', $id)->where('user_id', $userId)->first();

        if (!$savedArticle) {
            return redirect()->back()->with('error', 'Bài viết không tồn tại hoặc bạn không có quyền xóa!');
        }

        $savedArticle->delete();

        return redirect()->back()->with('success', 'Bài viết đã được xoá thành công!');
    }
}

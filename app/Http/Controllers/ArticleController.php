<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('author', 'category', 'approver')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get(); // Lấy danh sách users
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get(); // Lọc người duyệt bài

        return view('admin.articles.create', compact('categories', 'authors', 'approvers'));
    }
    public function approve(Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để duyệt.');
        }

        $article->update([
            'status' => 'published',
            'approved_by' => auth()->id(), // Lưu ID admin duyệt bài
        ]);

        return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
    }


    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:255',
             'slug' => 'required|string|max:255|unique:articles,slug',
             'content' => 'required',
             'category_id' => 'required|exists:categories,category_id',
             'thumbnail_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'status' => 'required|in:draft,pending',
         ]);

         $article = new Article();
         $article->title = $request->title;
         $article->slug = $request->slug;
         $article->content = $request->input('content');
         $article->category_id = $request->category_id;
         $article->status = $request->status;
         $article->author_id = auth()->id();

         if ($request->hasFile('thumbnail_url')) {
             $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
             $article->thumbnail_url = $path;
         }

         $article->save();

         if ($request->status == 'draft') {
             return redirect()->route('articles.index')->with('success', 'Bài viết đã lưu nháp!');
         }

         return redirect()->route('articles.index')->with('success', 'Bài viết đã gửi để chờ duyệt!');
     }




    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get(); // Lấy danh sách users
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get(); // Lọc người duyệt bài

        return view('admin.articles.edit', compact('article', 'categories', 'authors', 'approvers'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->article_id . ',article_id',
            'content' => '',
            'author_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
        ]);

        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->content = $request->input('content');
        $article->author_id = $request->author_id ?? $article->author_id;
        $article->category_id = $request->category_id;


        // Kiểm tra nếu có file mới thì cập nhật, không thì giữ ảnh cũ
        if ($request->hasFile('thumbnail_url')) {
            $file = $request->file('thumbnail_url');
            $path = $file->store('thumbnails', 'public'); // Lưu file mới
            $article->thumbnail_url = $path;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Bài viết đã bị xóa!');
    }
}

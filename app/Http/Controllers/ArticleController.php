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
            'preview_content' => 'nullable|string',
            'contains_sensitive_content' => 'nullable|boolean',
            'author_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mp3,wav|max:51200',
            'status' => 'required|in:draft,pending,published,archived',
            'views' => 'nullable|integer|min:0',
            'approved_by' => 'nullable|exists:users,user_id',
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->content = $request->content;
        $article->preview_content = $request->preview_content;
        $article->contains_sensitive_content = $request->contains_sensitive_content ?? false;
        $article->author_id = $request->author_id;
        $article->category_id = $request->category_id;
        $article->status = $request->status;
        $article->views = $request->views ?? 0;
        $article->approved_by = $request->approved_by;

        // Kiểm tra nếu có file upload
        if ($request->hasFile('thumbnail_url')) {
            $file = $request->file('thumbnail_url');
            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $folder = 'thumbnails';
            } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                $folder = 'videos';
            } elseif (in_array($extension, ['mp3', 'wav'])) {
                $folder = 'voices';
            } else {
                return redirect()->back()->withErrors(['thumbnail_url' => 'Invalid file format.']);
            }

            // Lưu file vào storage/public/{folder}
            $path = $file->store($folder, 'public');
            $article->thumbnail_url = $path;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
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
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'content' => 'required',
            'preview_content' => 'nullable|string',
            'contains_sensitive_content' => 'nullable|boolean',
            'author_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,mp3,wav|max:51200', 
            'status' => 'required|in:draft,pending,published,archived',
            'views' => 'nullable|integer|min:0',
            'approved_by' => 'nullable|exists:users,user_id',
        ]);

        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->content = $request->content;
        $article->preview_content = $request->preview_content;
        $article->contains_sensitive_content = $request->contains_sensitive_content ?? false;
        $article->author_id = $request->author_id;
        $article->category_id = $request->category_id;
        $article->status = $request->status;
        $article->views = $request->views ?? $article->views;
        $article->approved_by = $request->approved_by;


        if ($request->hasFile('thumbnail_url')) {
            $file = $request->file('thumbnail_url');
            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $folder = 'thumbnails';
            } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                $folder = 'videos';
            } elseif (in_array($extension, ['mp3', 'wav'])) {
                $folder = 'voices';
            } else {
                return redirect()->back()->withErrors(['thumbnail_url' => 'Invalid file format.']);
            }


            if ($article->thumbnail_url) {
                Storage::disk('public')->delete($article->thumbnail_url);
            }

            $path = $file->store($folder, 'public');
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

<?php

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticleSubmitted;

class ArticleController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $articles = Article::with(['author', 'category', 'approver', 'tags'])
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }


    /**
     *
     */
    public function create()
    {
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get();
        $tags = Tag::all();

        return view('admin.articles.create', compact('categories', 'authors', 'approvers', 'tags'));
    }

    /**
     *
     */
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

    /**
     *
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,pending',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,tag_id',
            'new_tags' => 'nullable|string',
        ];

        if ($request->status !== 'draft') {
            $rules['content'] = 'required';
        }

        $request->validate($rules);

        $article = Article::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content ?? '',
            'category_id' => $request->category_id,
            'status' => $request->status,
            'author_id' => auth()->id(),
        ]);

        if ($request->hasFile('thumbnail_url')) {
            $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
            $article->update(['thumbnail_url' => $path]);
        }

        $tagIds = $request->tags ?? [];

        if ($request->filled('new_tags')) {
            $newTagNames = explode(',', $request->new_tags);
            foreach ($newTagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->tag_id;
            }
        }

        $article->tags()->sync($tagIds);

        // Gửi thông báo cho admin nếu bài viết cần duyệt
        if ($article->status === 'pending') {
            $admins = User::where('role_id', 1)->get();
            Notification::send($admins, new NewArticleSubmitted($article));
        }

        return redirect()->route('articles.index')->with('success', 'Bài viết đã được tạo thành công!');
    }



    /**
     *
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     *
     */
    public function edit(Article $article)
    {
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get();
        $tags = Tag::all();
        $selectedTags = $article->tags->pluck('tag_id')->toArray();

        return view('admin.articles.edit', compact('article', 'categories', 'authors', 'approvers', 'tags', 'selectedTags'));
    }


    /**
     *
     */
    public function update(Request $request, Article $article)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->article_id . ',article_id',
            'content' => 'nullable',
            'author_id' => 'required|exists:users,user_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'array',
            'tags.*' => 'integer|exists:tags,tag_id',
            'new_tags' => 'nullable|string',
        ];

        $request->validate($rules);

        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('thumbnail_url')) {
            if ($article->thumbnail_url) {
                Storage::disk('public')->delete($article->thumbnail_url);
            }
            $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
            $article->update(['thumbnail_url' => $path]);
        }

        $tagIds = $request->tags ?? [];

        if ($request->filled('new_tags')) {
            $newTagNames = explode(',', $request->new_tags);
            foreach ($newTagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->tag_id;
            }
        }

        $article->tags()->sync($tagIds);

        return redirect()->route('articles.index')->with('success', 'Bài viết đã được cập nhật thành công!');
    }


    /**
     *
     */
    public function destroy(Article $article)
    {
        if ($article->thumbnail_url) {
            Storage::disk('public')->delete($article->thumbnail_url);
        }

        $article->tags()->detach();

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Bài viết đã bị xóa!');
    }
}

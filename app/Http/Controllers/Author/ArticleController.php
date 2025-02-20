<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:author');
    }

    public function index()
    {
        $articles = Article::where('author_id', Auth::id())
            ->with(['category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.article.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('author.article.create', compact('categories', 'tags'));
    }

    public function store(Request $request) {}

    public function edit($id)
    {
        $article = Article::where('author_id', Auth::id())
            ->with(['category', 'tags'])->findOrFail($id);

        $categories = Category::where('is_active', 1)->get();
        $tags = Tag::all();

        return view('author.articles.edit',
            compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, $id) {}

    public function destroy($id)
    {
        $article = Article::where('author_id', Auth::id())->findOrFail($id);
        $article->delete();

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bai viet da dc xoa');
    }
}

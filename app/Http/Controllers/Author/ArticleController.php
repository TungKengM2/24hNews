<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use App\Models\Article;
    use App\Models\Category;
    use App\Models\Tag;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class ArticleController extends Controller
    {

        // public function __construct()
        // {
        //     $this->middleware('auth');
        //     $this->middleware('role:author');
        // }

        public function index()
        {
            $articles = Article::where('author_id', Auth::id())
                ->with(['category', 'tags'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('author.articles.index', compact('articles'));
        }

        public function create()
        {
            $categories = Category::all();
            $tags = Tag::all();

            return view('author.articles.create', compact('categories', 'tags'));
        }

        public function edit(Article $articles)
        {
            $categories = Category::select('category_id', 'name')->get();

            return view('author.articles.edit',
                compact('articles', 'categories'));
        }

        public function update(Request $request, Article $article)
        {
            // Validation rules
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => $request->filled('slug') ? 'required|string|max:255|unique:articles,slug,' . $article->article_id . ',article_id' : 'nullable',
                'content' => 'required',
                'author_id' => 'required|exists:users,user_id',
                'category_id' => 'required|exists:categories,category_id',
                'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $article->title = $request->input('title', $article->title);
            $article->slug = $request->input('slug', $article->slug);
            $article->content = $request->input('content', $article->content);
            $article->author_id = $request->input('author_id',
                $article->author_id);
            $article->category_id = $request->input('category_id',
                $article->category_id);

            if ($request->hasFile('thumbnail_url')) {
                $file = $request->file('thumbnail_url');
                $path = $file->store('thumbnails', 'public');
                $article->thumbnail_url = $path;
            } else {
                $article->thumbnail_url = $article->thumbnail_url;
            }

            $article->save();

            return redirect()
                ->route('author.articles.index')
                ->with('success', 'Article updated successfully!');
        }

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
                $path = $request->file('thumbnail_url')
                    ->store('thumbnails', 'public');
                $article->thumbnail_url = $path;
            }

            $article->save();

            if ($request->status == 'draft') {
                return redirect()
                    ->route('author.articles.store')
                    ->with('success', 'Bài viết đã lưu nháp!');
            }

            return redirect()
                ->route('author.articles.store')
                ->with('success', 'Bài viết đã gửi để chờ duyệt!');
        }

        public function destroy($id)
        {
            $article = Article::where('author_id', Auth::id())->findOrFail($id);
            $article->delete();

            return redirect()
                ->route('author.articles')
                ->with('success', 'Bai viet da dc xoa');
        }

        public function show($id)
        {
            $article = Article::with(['category', 'author'])->findOrFail($id);

            return view('author.articles.show', compact('article'));
        }

    }
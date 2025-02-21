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

            return view('author.manageArticles', compact('articles'));
        }

        public function create()
        {
            $categories = Category::all();
            $tags = Tag::all();

            return view('author.create', compact('categories', 'tags'));
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

        public function edit(Article $article)
        {
            $categories = Category::select('category_id', 'name')->get();

            return view('author.edit',
                compact('article', 'categories'));
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

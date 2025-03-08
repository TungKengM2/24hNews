<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\ModerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function index()
    {
        $articles = Article::with([
            'author',
            'category',
            'approver',
            'tags',
        ])
            ->where('author_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        //        dd($articles->toArray());

        return view('author.articles.index', compact('articles'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error',
                    'Bạn không có quyền cập nhật bài viết này.');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,'.$article->article_id.',article_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,pending,published,archived,rejected',
            'content' => 'nullable',
        ];
        $request->validate($rules);

        if ($request->status === 'draft') {
            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->input('content') ?? '',
                'category_id' => $request->category_id,
                'status' => 'draft',
            ]);

            Approval::where('article_id', $article->article_id)->delete();

            if ($request->hasFile('thumbnail_url')) {
                if ($article->thumbnail_url) {
                    Storage::disk('public')
                        ->delete($article->thumbnail_url);
                }
                $path = $request->file('thumbnail_url')
                    ->store('thumbnails', 'public');
                $article->update(['thumbnail_url' => $path]);
            }

            $tagIds = $this->processTags($request->input('tags', []));
            $article->tags()->sync($tagIds);

            return redirect()
                ->route('author.articles.index')
                ->with('success', 'Bài viết đã được lưu nháp!');
        }

        $apiKey = env('GOOGLE_API_KEY');
        $moderationResult = $this->moderationService->moderateContent($request->input('content'),
            $apiKey);

        if ($moderationResult['status'] === 'error') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => 'Lỗi kiểm duyệt: '.$moderationResult['message']]);
        }

        if ($moderationResult['violation_level'] === 'high') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(', ',
                        $moderationResult['violations']),
                ])
                ->with('violation_reasons', $moderationResult['reason'])
                ->with('violations', $moderationResult['violations']);
        }

        $currentStatus = $article->status;
        $newStatus = $currentStatus;

        switch ($currentStatus) {
            case 'draft':
                $newStatus = match ($moderationResult['violation_level']) {
                    'none', 'low' => 'published',
                    'medium' => 'pending',
                    default => $currentStatus,
                };
                break;

            case 'pending':
                $newStatus = match ($moderationResult['violation_level']) {
                    'none', 'low' => 'published',
                    'medium' => 'pending',
                    default => $currentStatus,
                };
                break;

            case 'published':
            case 'archived':
            case 'rejected':
                $newStatus = match ($moderationResult['violation_level']) {
                    'none', 'low' => 'published',
                    'medium' => 'pending',
                    default => $currentStatus,
                };
                break;
        }

        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->input('content') ?? '',
            'category_id' => $request->category_id,
            'status' => $newStatus,
        ]);

        if ($request->hasFile('thumbnail_url')) {
            if ($article->thumbnail_url) {
                Storage::disk('public')->delete($article->thumbnail_url);
            }
            $path = $request->file('thumbnail_url')
                ->store('thumbnails', 'public');
            $article->update(['thumbnail_url' => $path]);
        }

        $tagIds = $this->processTags($request->input('tags', []));
        $article->tags()->sync($tagIds);

        $approver = User::where('username', 'ai')->first();
        $approvalData = [
            'type' => 'article',
            'status' => match ($moderationResult['violation_level']) {
                'none', 'low' => 'approved',
                'medium' => 'pending',
                default => 'pending',
            },
            'remarks' => $moderationResult['violation_level'] === 'high'
                ? 'Nội dung vi phạm nghiêm trọng: '.implode(', ',
                    $moderationResult['violations'])
                : ($moderationResult['violation_level'] === 'medium'
                    ? 'Nội dung vi phạm: '.implode(', ',
                        $moderationResult['violations'])
                    : 'Approved by AI'),
            'approved_by' => $moderationResult['violation_level'] === 'high' ? null : $approver?->user_id,
        ];

        $approval = Approval::where('article_id', $article->article_id)
            ->first();
        if ($approval) {
            $approval->update($approvalData);
        } else {
            Approval::create(array_merge(['article_id' => $article->article_id],
                $approvalData));
        }

        if ($moderationResult['violation_level'] === 'high') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(', ',
                        $moderationResult['violations']),
                ])
                ->with('violation_reasons', $moderationResult['reason'])
                ->with('violations', $moderationResult['violations']);
        }

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    public function store(Request $request)
    {
        $tagInputs = array_filter($request->input('tags', []),
            function ($tag) {
                return ! empty(trim($tag));
            });

        if (is_string($tagInputs)) {
            $tagInputs = explode(',', $tagInputs);
        }

        $tagIds = [];
        foreach ($tagInputs as $tag) {
            if (is_numeric($tag)) {
                $tagIds[] = (int) $tag;
            } else {
                $tag = trim($tag);
                if (! empty($tag)) {
                    $tagModel = Tag::firstOrCreate(['name' => $tag]);
                    $tagIds[] = $tagModel->tag_id;
                }
            }
        }

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,pending',
            'content' => $request->status !== 'draft' ? 'required' : 'nullable',
        ];

        $request->validate($rules);

        $apiKey = env('GOOGLE_API_KEY');
        $moderationResult = $this->moderationService->moderateContent($request->input('content'),
            $apiKey);

        if ($moderationResult['status'] === 'error') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => 'Lỗi kiểm duyệt nội dung: '.$moderationResult['message']]);
        }

        if ($moderationResult['violation_level'] === 'high') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(', ',
                        $moderationResult['violations']),
                ])
                ->with('violation_reasons', $moderationResult['reason'])
                ->with('violations', $moderationResult['violations']);
        }

        $status = match ($moderationResult['violation_level']) {
            'none', 'low' => 'published',
            'medium' => 'pending',
            default => 'pending',
        };

        $article = Article::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->input('content') ?? '',
            'category_id' => $request->category_id,
            'status' => $status,
            'author_id' => auth()->id(),
        ]);

        if ($request->hasFile('thumbnail_url')) {
            $path = $request->file('thumbnail_url')
                ->store('thumbnails', 'public');
            $article->update(['thumbnail_url' => $path]);
        }

        $article->tags()->sync($tagIds);
        $approver = User::where('username', 'ai')->first();
        $approvalData = [
            'article_id' => $article->article_id,
            'type' => 'article',
        ];

        if ($status === 'pending') {
            $approvalData['status'] = 'pending';
            $approvalData['remarks'] = 'Nội dung vi phạm: '.implode(', ',
                $moderationResult['reason']);
        } elseif ($status === 'published') {
            $approvalData['status'] = 'approved';
            $approvalData['remarks'] = 'Approved by AI';
            $approvalData['approved_by'] = $approver->user_id ? $approver->user_id : null;
        }

        Approval::create($approvalData);

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bài viết đã được tạo thành công!');
    }

    public function create()
    {
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();
        $tags = Tag::all();

        return view('author.articles.create',
            compact('categories', 'authors', 'approvers', 'tags'));
    }

    private function processTags($tags)
    {
        $tagIds = [];
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (is_numeric($tag)) {
                if (Tag::where('tag_id', $tag)->exists()) {
                    $tagIds[] = (int) $tag;
                }
            } else {
                if (! empty($tag)) {
                    $tagModel = Tag::firstOrCreate(['name' => $tag]);
                    $tagIds[] = $tagModel->tag_id;
                }
            }
        }

        return $tagIds;
    }

    public function show(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền xem bài viết này.');
        }
        $content = strip_tags($article->content);
        preg_match('/^[^.!?]*[.!?]/', $content, $matches);
        $preview_content = $matches[0] ?? '';

        //            dd($preview_content);
        return view('author.articles.show',
            compact('article', 'preview_content'));
    }

    public function edit(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error',
                    'Bạn không có quyền chỉnh sửa bài viết này.');
        }
        $categories = Category::select('category_id', 'name')->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();

        $tags = Tag::select('tag_id', 'name')->get();

        $selectedTags = $article->tags->pluck('tag_id')->toArray();

        return view('author.articles.edit',
            compact('article', 'categories', 'authors', 'approvers', 'tags',
                'selectedTags'));
    }

    public function destroy(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return response()->json(['message' => 'Bạn không có quyền xóa bài viết này.'],
                403);
        }

        if ($article->thumbnail_url) {
            Storage::disk('public')->delete($article->thumbnail_url);
        }

        $article->tags()->detach();
        $article->delete();

        return response()->json(['message' => 'Bài viết đã bị xóa!']);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads',
                'public');

            return response()->json([
                'location' => asset("storage/$path"),
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $articlesQuery = Article::with(['category', 'tags'])
            ->where('author_id', auth()->id())
            ->orderBy('created_at', 'desc');

        if ($query) {
            $articlesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            });
        }
        //            dd($articlesQuery);
        $articles = $articlesQuery->paginate(10);

        return response()->json([
            'data' => $articles->items(),
            'links' => $articles->links()->render(),
            'total' => $articles->total(),
        ]);
    }
}

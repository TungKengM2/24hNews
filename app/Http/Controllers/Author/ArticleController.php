<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\ArticleStatusUpdated;
use App\Services\ModerationService;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $articles = Article::with([
            'author',
            'category',
            'approver',
            'tags',
        ])
            ->where('author_id', auth()->id())
            ->when($filter !== 'all', function ($query) use ($filter) {
                if (in_array($filter, ['active', 'inactive'])) {
                    $query->whereHas(
                        'category',
                        function ($q) use ($filter) {
                            $q->where('is_active', $filter === 'active');
                        }
                    );
                } elseif ($filter === 'no_category') {
                    $query->whereNull('category_id');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.articles.index', compact('articles', 'filter'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Bạn không có quyền cập nhật bài viết này.'
                );
        }

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,'.$article->article_id.',article_id',
            'category_id' => 'required|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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

        if (($request->has_blocked_images === 'true' || session()->has('blocked_images'))
            && $request->confirmed_submit !== 'true'
            && $request->status !== 'draft') {
            $blockedImages = session('blocked_images', []);

            $errorMessage = 'Bài viết chứa hình ảnh không vượt qua kiểm duyệt. Vui lòng kiểm tra lại nội dung trước khi gửi.';

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => $errorMessage])
                ->with('blocked_images', $blockedImages);
        }

        $content = $request->input('content') ?? '';
        if ($request->has_blocked_images === 'true' || session()->has('blocked_images')) {
            $blockedUrls = [];
            $blockedImages = session('blocked_images', []);

            if ($request->blocked_images_list) {
                try {
                    $clientBlockedImages = json_decode($request->blocked_images_list,
                        true);
                    if (is_array($clientBlockedImages)) {
                        foreach ($clientBlockedImages as $url) {
                            $blockedUrls[] = $url;
                        }
                    }
                } catch (Exception $e) {
                    Log::error('Lỗi giải mã danh sách ảnh bị chặn: '.$e->getMessage());
                }
            }

            if (! empty($blockedUrls) || ! empty($blockedImages)) {
                $dom = new DOMDocument;
                @$dom->loadHTML(mb_convert_encoding($content,
                    'HTML-ENTITIES', 'UTF-8'),
                    LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $images = $dom->getElementsByTagName('img');

                $nodesToRemove = [];
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');

                    foreach ($blockedUrls as $blockedUrl) {
                        if (strpos($src, $blockedUrl) !== false) {
                            $nodesToRemove[] = $image;
                            break;
                        }
                    }
                }

                foreach ($nodesToRemove as $node) {
                    $node->parentNode->removeChild($node);
                }

                $content = $dom->saveHTML();
            }
        }

        $moderationResult = $this->moderationService->moderateContent($content);

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
                    'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(
                        ', ',
                        $moderationResult['violations']
                    ),
                ])
                ->with('violation_reasons', $moderationResult['reason'])
                ->with('violations', $moderationResult['violations']);
        }

        $thumbnailModerationResult = [
            'status' => 'success',
            'violation_level' => 'none',
            'violations' => [],
            'reason' => [],
        ];

        if ($request->hasFile('thumbnail_url')) {
            $thumbnailModerationResult = $this->moderationService->moderateImageFile($request->file('thumbnail_url'));

            if ($thumbnailModerationResult['status'] === 'error') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['thumbnail_url' => 'Lỗi kiểm duyệt ảnh đại diện: '.$thumbnailModerationResult['message']]);
            }

            if ($thumbnailModerationResult['violation_level'] === 'high') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'thumbnail_url' => 'Ảnh đại diện vi phạm quy định: '.implode(
                            ', ',
                            $thumbnailModerationResult['violations']
                        ),
                    ])
                    ->with('thumbnail_reasons', $thumbnailModerationResult['reason']);
            }
        }

        $finalViolationLevel = $moderationResult['violation_level'];
        if (in_array($thumbnailModerationResult['violation_level'], ['medium', 'high']) &&
            ($thumbnailModerationResult['violation_level'] === 'high' || $finalViolationLevel !== 'high')) {
            $finalViolationLevel = $thumbnailModerationResult['violation_level'];
        }

        $allViolations = $moderationResult['violations'];
        $allReasons = $moderationResult['reason'];

        if (! empty($thumbnailModerationResult['violations'])) {
            foreach ($thumbnailModerationResult['violations'] as $violation) {
                if (! in_array($violation, $allViolations)) {
                    $allViolations[] = $violation;
                }
            }
        }

        if (! empty($thumbnailModerationResult['reason'])) {
            foreach ($thumbnailModerationResult['reason'] as $key => $reason) {
                $allReasons['thumbnail_'.$key] = 'Ảnh đại diện: '.$reason;
            }
        }

        $article->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $content,
            'category_id' => $request->category_id,
            'status' => 'pending', 
        ]);

        if ($request->hasFile('thumbnail_url') && $thumbnailModerationResult['violation_level'] !== 'high') {
            $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
            $article->update(['thumbnail_url' => $path]);
        }

        $tagIds = $this->processTags($request->input('tags', []));
        $article->tags()->sync($tagIds);

        $approver = User::where('username', 'ai')->first();
        $approvalData = [
            'type' => 'article',
            'user_id' => auth()->id(),
            'status' => 'pending', 
            'remarks' => $finalViolationLevel === 'high'
                ? 'Nội dung vi phạm nghiêm trọng: '.implode(', ', $allViolations)
                : ($finalViolationLevel === 'medium'
                    ? 'Nội dung cần kiểm duyệt: '.implode(', ', $allViolations)
                    : 'Đã cập nhật, chờ kiểm duyệt lại'),
            'approved_by' => null, 
            'violation_level' => $finalViolationLevel,
            'violations' => ! empty($allViolations)
                ? json_encode($allViolations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : null,
            'violation_details' => ! empty($allReasons)
                ? json_encode($allReasons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : null,
        ];

        $approval = Approval::where('article_id', $article->article_id)
            ->first();
        if ($approval) {
            $approval->update($approvalData);
        } else {
            Approval::create(array_merge(
                ['article_id' => $article->article_id],
                $approvalData
            ));
        }

        session()->forget('blocked_images');

        if ($finalViolationLevel === 'high') {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(
                        ', ',
                        $allViolations
                    ),
                ])
                ->with('violation_reasons', $allReasons)
                ->with('violations', $allViolations);
        }

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bài viết đã được cập nhật thành công và đang chờ phê duyệt!');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug',
            'content' => 'required',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,pending,published,rejected,archived',
        ];

        $request->validate($rules);

        if ($request->status === 'draft') {
            $article = Article::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->input('content') ?? '',
                'author_id' => auth()->id(),
                'category_id' => $request->category_id,
                'status' => 'draft',
            ]);

            if ($request->hasFile('thumbnail_url')) {
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

        if (($request->has_blocked_images === 'true' || session()->has('blocked_images'))
            && $request->confirmed_submit !== 'true'
            && $request->status !== 'draft') {
            $blockedImages = session('blocked_images', []);

            $errorMessage = 'Bài viết chứa hình ảnh không vượt qua kiểm duyệt. Vui lòng kiểm tra lại nội dung trước khi gửi.';

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['content' => $errorMessage])
                ->with('blocked_images', $blockedImages);
        }

        $content = $request->input('content') ?? '';
        if ($request->has_blocked_images === 'true' || session()->has('blocked_images') || $request->blocked_images_list) {
            $blockedUrls = [];
            $blockedImages = session('blocked_images', []);

            foreach ($blockedImages as $blockedImage) {
                if (isset($blockedImage['url'])) {
                    $blockedUrls[] = $blockedImage['url'];
                }
            }

            if ($request->blocked_images_list) {
                try {
                    $clientBlockedImages = json_decode($request->blocked_images_list,
                        true);
                    if (is_array($clientBlockedImages)) {
                        foreach ($clientBlockedImages as $url) {
                            $blockedUrls[] = $url;
                        }
                    }
                } catch (Exception $e) {
                    Log::error('Lỗi giải mã danh sách ảnh bị chặn: '.$e->getMessage());
                }
            }

            if (! empty($blockedUrls)) {
                $dom = new DOMDocument;
                @$dom->loadHTML(mb_convert_encoding($content,
                    'HTML-ENTITIES', 'UTF-8'),
                    LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $images = $dom->getElementsByTagName('img');
                $nodesToRemove = [];
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');

                    foreach ($blockedUrls as $blockedUrl) {
                        if (strpos($src, $blockedUrl) !== false) {
                            $nodesToRemove[] = $image;
                            break;
                        }
                    }
                }

                foreach ($nodesToRemove as $node) {
                    $node->parentNode->removeChild($node);
                }

                $content = $dom->saveHTML();
            }
        }

        try {
            $moderationResult = $this->moderationService->moderateContent($content);

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
                        'content' => 'Nội dung vi phạm nghiêm trọng: '.implode(
                            ', ',
                            $moderationResult['violations']
                        ),
                    ])
                    ->with('violation_reasons', $moderationResult['reason'])
                    ->with('violations', $moderationResult['violations']);
            }

            $thumbnailModerationResult = [
                'status' => 'success',
                'violation_level' => 'none',
                'violations' => [],
                'reason' => [],
            ];

            if ($request->hasFile('thumbnail_url')) {
                $thumbnailModerationResult = $this->moderationService->moderateImageFile($request->file('thumbnail_url'));

                if ($thumbnailModerationResult['status'] === 'error') {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['thumbnail_url' => 'Lỗi kiểm duyệt ảnh đại diện: '.$thumbnailModerationResult['message']]);
                }

                if ($thumbnailModerationResult['violation_level'] === 'high') {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'thumbnail_url' => 'Ảnh đại diện vi phạm quy định: '.implode(
                                ', ',
                                $thumbnailModerationResult['violations']
                            ),
                        ])
                        ->with('thumbnail_reasons', $thumbnailModerationResult['reason']);
                }
            }

            $finalViolationLevel = $moderationResult['violation_level'];
            if (in_array($thumbnailModerationResult['violation_level'], ['medium', 'high']) &&
                ($thumbnailModerationResult['violation_level'] === 'high' || $finalViolationLevel !== 'high')) {
                $finalViolationLevel = $thumbnailModerationResult['violation_level'];
            }

            $allViolations = $moderationResult['violations'];
            $allReasons = $moderationResult['reason'];

            if (! empty($thumbnailModerationResult['violations'])) {
                foreach ($thumbnailModerationResult['violations'] as $violation) {
                    if (! in_array($violation, $allViolations)) {
                        $allViolations[] = $violation;
                    }
                }
            }

            if (! empty($thumbnailModerationResult['reason'])) {
                foreach ($thumbnailModerationResult['reason'] as $key => $reason) {
                    $allReasons['thumbnail_'.$key] = 'Ảnh đại diện: '.$reason;
                }
            }

            $article = Article::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $content,
                'author_id' => auth()->id(),
                'category_id' => $request->category_id,
                'status' => 'pending', 
            ]);

            if ($request->hasFile('thumbnail_url') && $thumbnailModerationResult['violation_level'] !== 'high') {
                $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
                $article->update(['thumbnail_url' => $path]);
            }

            $tagIds = $this->processTags($request->input('tags', []));
            $article->tags()->sync($tagIds);

            $approver = User::where('username', 'ai')->first();
            $approvalData = [
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => auth()->id(),
                'status' => 'pending',
                'remarks' => $finalViolationLevel === 'high'
                    ? 'Nội dung vi phạm nghiêm trọng: '.implode(', ', $allViolations)
                    : ($finalViolationLevel === 'medium'
                        ? 'Nội dung cần kiểm duyệt: '.implode(', ', $allViolations)
                        : 'Bài viết mới, chờ kiểm duyệt'),
                'approved_by' => null,
                'violation_level' => $finalViolationLevel,
                'violations' => ! empty($allViolations)
                    ? json_encode($allViolations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                    : null,
                'violation_details' => ! empty($allReasons)
                    ? json_encode($allReasons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                    : null,
            ];

            Approval::create($approvalData);

            session()->forget('blocked_images');

            return redirect()
                ->route('author.articles.index')
                ->with('success', 'Bài viết đã được tạo thành công và đang chờ phê duyệt!');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (Exception $e) {
            return redirect()
                ->route('author.articles.index')
                ->with(
                    'success',
                    'Bài viết của bạn đang được xét duyệt, vui lòng chờ trong giây lát.'
                );
        }
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();
        $tags = Tag::all();

        return view(
            'author.articles.create',
            compact('categories', 'authors', 'approvers', 'tags')
        );
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
        return view(
            'author.articles.show',
            compact('article', 'preview_content')
        );
    }

    public function edit(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Bạn không có quyền chỉnh sửa bài viết này.'
                );
        }
        $categories = Category::all();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();

        $tags = Tag::select('tag_id', 'name')->get();

        $selectedTags = $article->tags->pluck('tag_id')->toArray();

        return view(
            'author.articles.edit',
            compact(
                'article',
                'categories',
                'authors',
                'approvers',
                'tags',
                'selectedTags'
            )
        );
    }

    /**
     * Ẩn/hiện bài viết
     */
    public function toggleVisibility(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền thay đổi bài viết này.');
        }

        // Nếu trạng thái là published, đổi thành archived và ngược lại
        if ($article->status === 'published') {
            $article->update(['status' => 'archived']);
            $message = "Bài viết đã được ẩn thành công.";
        } elseif ($article->status === 'archived') {
            $article->update(['status' => 'published']);
            $message = "Bài viết đã được hiện thành công.";
        } else {
            return redirect()->back()->with('error', "Chỉ có thể ẩn/hiện bài viết đã xuất bản hoặc đã ẩn.");
        }

        return redirect()->route('author.articles.index')->with('success', $message);
    }
    
    public function destroy(Article $article)
    {
        if ($article->thumbnail_url) {
            Storage::disk('public')->delete($article->thumbnail_url);
        }

        $article->tags()->detach();

        $article->delete();

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bài viết đã bị xóa!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store(
                'uploads',
                'public'
            );

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

    public function updateStatus(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }

        $article->status = $request->status;
        $article->save();

        if (!$article->author) {
            Log::error("Không tìm thấy tác giả của bài viết ID: {$article->id}");
            return response()->json(['message' => 'Không tìm thấy tác giả'], 500);
        }

        $message = "Bài viết '{$article->title}' của bạn đã được " .
                   ($article->status === 'published' ? 'duyệt.' : 'từ chối.');

        try {
            $article->author->notify(new ArticleStatusUpdated($article, $message));
        } catch (\Exception $e) {
            Log::error("Lỗi khi gửi thông báo: " . $e->getMessage());
        }

        return response()->json(['message' => 'Trạng thái bài viết đã được cập nhật.']);
    }
}

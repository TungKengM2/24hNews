<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use App\Models\Approval;
use App\Services\ModerationService;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticleSubmitted;
use Illuminate\Support\Facades\Log;
use DOMDocument;
use Exception;
use App\Services\WritingGuidelineService;

class ArticleController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    /**
     *
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all'); // Mặc định hiển thị tất cả bài viết

        $query = Article::with(['author', 'category', 'approver', 'tags'])
            ->orderBy('created_at', 'desc');

        if ($filter === 'inactive') {
            $query->whereHas('category', function ($q) {
                $q->where('is_active', false);
            });
        } elseif ($filter === 'active') {
            $query->whereHas('category', function ($q) {
                $q->where('is_active', true);
            });
        } elseif ($filter === 'no_category') {
            $query->whereNull('category_id');
        } elseif ($filter === 'archived') {
            $query->where('status', 'archived');
        } elseif ($filter === 'published') {
            $query->where('status', 'published');
        } elseif ($filter === 'draft') {
            $query->where('status', 'draft');
        } elseif ($filter === 'pending') {
            $query->where('status', 'pending');
        }

        // Xử lý tìm kiếm theo từ khóa nếu có
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $articles = $query->paginate(10);

        return view('admin.articles.index', compact('articles', 'filter'));
    }

    /**
     *
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $tags = Tag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     *
     */
    public function approve(Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để duyệt.');
        }

        $article->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
        ]);

        // Gửi thông báo cho tác giả
        $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã được duyệt."));

        return redirect()->back()->with('success', 'Bài viết đã được duyệt.');
    }

    /**
     *
     */
    public function store(Request $request)
    {
        try {
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
                    'category_id' => $request->category_id,
                    'status' => 'draft',
                    'author_id' => $request->author_id ?? auth()->id(),
                ]);

                if ($request->hasFile('thumbnail_url')) {
                    $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
                    $article->update(['thumbnail_url' => $path]);
                }

                $tagIds = $this->processTags($request->input('tags', []));
                $article->tags()->sync($tagIds);

                // Log xác nhận session success đã được thiết lập
                Log::info('Session success đã được thiết lập: Bài viết đã được tạo thành công!');

                return redirect()->route('articles.index')->with('success', 'Bài viết đã được tạo thành công!');
            }

            if (($request->has_blocked_images === 'true' || session()->has('blocked_images'))
                && $request->confirmed_submit !== 'true'
                && $request->status !== 'draft'
            ) {
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
                        $clientBlockedImages = json_decode($request->blocked_images_list, true);
                        if (is_array($clientBlockedImages)) {
                            foreach ($clientBlockedImages as $url) {
                                $blockedUrls[] = $url;
                            }
                        }
                    } catch (Exception $e) {
                        Log::error('Lỗi giải mã danh sách ảnh bị chặn: ' . $e->getMessage());
                    }
                }

                if (! empty($blockedUrls)) {
                    $dom = new DOMDocument;
                    @$dom->loadHTML(
                        mb_convert_encoding(
                            $content,
                            'HTML-ENTITIES',
                            'UTF-8'
                        ),
                        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                    );

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
                        ->withErrors(['content' => 'Lỗi kiểm duyệt nội dung: ' . $moderationResult['message']]);
                }

                if ($moderationResult['violation_level'] === 'high') {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'content' => 'Nội dung vi phạm nghiêm trọng: ' . implode(
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
                            ->withErrors(['thumbnail_url' => 'Lỗi kiểm duyệt ảnh đại diện: ' . $thumbnailModerationResult['message']]);
                    }

                    if ($thumbnailModerationResult['violation_level'] === 'high') {
                        return redirect()
                            ->back()
                            ->withInput()
                            ->withErrors([
                                'thumbnail_url' => 'Ảnh đại diện vi phạm quy định: ' . implode(
                                    ', ',
                                    $thumbnailModerationResult['violations']
                                ),
                            ])
                            ->with('thumbnail_reasons', $thumbnailModerationResult['reason']);
                    }
                }

                $finalViolationLevel = $moderationResult['violation_level'];
                if (
                    in_array($thumbnailModerationResult['violation_level'], ['medium', 'high']) &&
                    ($thumbnailModerationResult['violation_level'] === 'high' || $finalViolationLevel !== 'high')
                ) {
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
                        $allReasons['thumbnail_' . $key] = 'Ảnh đại diện: ' . $reason;
                    }
                }

                $status = $request->status;
                if ($status === 'pending' && $finalViolationLevel === 'high') {
                    $status = 'rejected';
                }

                $article = Article::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $content,
                    'author_id' => $request->author_id ?? auth()->id(),
                    'category_id' => $request->category_id,
                    'status' => $status,
                ]);

                if ($request->hasFile('thumbnail_url') && $thumbnailModerationResult['violation_level'] !== 'high') {
                    $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
                    $article->update(['thumbnail_url' => $path]);
                }

                $tagIds = $this->processTags($request->input('tags', []));
                $article->tags()->sync($tagIds);

                // Tạo bản ghi Approval nếu status là pending
                if ($status === 'pending') {
                    $approvalData = [
                        'article_id' => $article->article_id,
                        'type' => 'article',
                        'user_id' => $request->author_id ?? auth()->id(),
                        'status' => 'pending',
                        'remarks' => $finalViolationLevel === 'high'
                            ? 'Nội dung vi phạm nghiêm trọng: ' . implode(', ', $allViolations)
                            : ($finalViolationLevel === 'medium'
                                ? 'Nội dung cần kiểm duyệt: ' . implode(', ', $allViolations)
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
                }

                session()->forget('blocked_images');

                // Gửi thông báo cho admin nếu bài viết cần duyệt
                if ($status === 'pending' && auth()->id() !== $request->author_id) {
                    $admins = User::where('role_id', 1)
                        ->where('user_id', '!=', auth()->id())
                        ->get();
                    Notification::send($admins, new NewArticleSubmitted($article));
                }

                return redirect()->route('articles.index')->with('success', 'Bài viết đã được tạo thành công!');
            } catch (Exception $e) {
                Log::error('Lỗi tạo bài viết: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Đã xảy ra lỗi khi tạo bài viết: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            Log::error('Lỗi tạo bài viết: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi tạo bài viết: ' . $e->getMessage());
        }
    }

    /**
     * Xử lý danh sách tags
     */
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
        $categories = Category::all();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get();

        // Lấy tất cả tags có trong database
        $tags = Tag::select('tag_id', 'name')->get();

        // Lấy danh sách tag đã chọn của bài viết
        $selectedTags = $article->tags->pluck('tag_id')->toArray();

        return view('admin.articles.edit', compact('article', 'categories', 'authors', 'approvers', 'tags', 'selectedTags'));
    }

    /**
     *
     */
    public function update(Request $request, Article $article)
    {
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:articles,slug,' . $article->article_id . ',article_id',
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
                    'author_id' => $request->author_id,
                    'category_id' => $request->category_id,
                    'status' => 'draft',
                ]);

                Approval::where('article_id', $article->article_id)->delete();

                if ($request->hasFile('thumbnail_url')) {
                    if ($article->thumbnail_url) {
                        Storage::disk('public')->delete($article->thumbnail_url);
                    }
                    $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
                    $article->update(['thumbnail_url' => $path]);
                }

                $tagIds = $this->processTags($request->input('tags', []));
                $article->tags()->sync($tagIds);

                // Log xác nhận session success đã được thiết lập
                Log::info('Session success đã được thiết lập sau khi cập nhật: Bài viết đã được cập nhật thành công!');

                return redirect()->route('articles.index')->with('success', 'Bài viết đã được cập nhật thành công!');
            }

            if (($request->has_blocked_images === 'true' || session()->has('blocked_images'))
                && $request->confirmed_submit !== 'true'
                && $request->status !== 'draft'
            ) {
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
                        $clientBlockedImages = json_decode($request->blocked_images_list, true);
                        if (is_array($clientBlockedImages)) {
                            foreach ($clientBlockedImages as $url) {
                                $blockedUrls[] = $url;
                            }
                        }
                    } catch (Exception $e) {
                        Log::error('Lỗi giải mã danh sách ảnh bị chặn: ' . $e->getMessage());
                    }
                }

                if (! empty($blockedUrls) || ! empty($blockedImages)) {
                    $dom = new DOMDocument;
                    @$dom->loadHTML(
                        mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'),
                        LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
                    );

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
                    ->withErrors(['content' => 'Lỗi kiểm duyệt nội dung: ' . $moderationResult['message']]);
            }

            if ($moderationResult['violation_level'] === 'high') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'content' => 'Nội dung vi phạm nghiêm trọng: ' . implode(
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
                        ->withErrors(['thumbnail_url' => 'Lỗi kiểm duyệt ảnh đại diện: ' . $thumbnailModerationResult['message']]);
                }

                if ($thumbnailModerationResult['violation_level'] === 'high') {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            'thumbnail_url' => 'Ảnh đại diện vi phạm quy định: ' . implode(
                                ', ',
                                $thumbnailModerationResult['violations']
                            ),
                        ])
                        ->with('thumbnail_reasons', $thumbnailModerationResult['reason']);
                }
            }

            $finalViolationLevel = $moderationResult['violation_level'];
            if (
                in_array($thumbnailModerationResult['violation_level'], ['medium', 'high']) &&
                ($thumbnailModerationResult['violation_level'] === 'high' || $finalViolationLevel !== 'high')
            ) {
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
                    $allReasons['thumbnail_' . $key] = 'Ảnh đại diện: ' . $reason;
                }
            }

            $status = $request->status;
            if ($status === 'pending' && $finalViolationLevel === 'high') {
                $status = 'rejected';
            }

            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $content,
                'author_id' => $request->author_id,
                'category_id' => $request->category_id,
                'status' => $status,
            ]);

            if ($request->hasFile('thumbnail_url')) {
                if ($article->thumbnail_url) {
                    Storage::disk('public')->delete($article->thumbnail_url);
                }
                $path = $request->file('thumbnail_url')->store('thumbnails', 'public');
                $article->update(['thumbnail_url' => $path]);
            }

            $tagIds = $this->processTags($request->input('tags', []));
            $article->tags()->sync($tagIds);

            $approvalData = [
                'type' => 'article',
                'user_id' => $article->author_id,
                'status' => $status === 'published' ? 'approved' : ($status === 'pending' ? 'pending' : 'rejected'),
                'remarks' => $finalViolationLevel === 'high'
                    ? 'Nội dung vi phạm nghiêm trọng: ' . implode(', ', $allViolations)
                    : ($finalViolationLevel === 'medium'
                        ? 'Nội dung cần kiểm duyệt: ' . implode(', ', $allViolations)
                        : 'Đã cập nhật, chờ kiểm duyệt lại'),
                'approved_by' => $status === 'published' ? auth()->id() : null,
                'violation_level' => $finalViolationLevel,
                'violations' => ! empty($allViolations)
                    ? json_encode($allViolations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                    : null,
                'violation_details' => ! empty($allReasons)
                    ? json_encode($allReasons, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                    : null,
            ];

            $approval = Approval::where('article_id', $article->article_id)->first();
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
                        'content' => 'Nội dung vi phạm nghiêm trọng: ' . implode(
                            ', ',
                            $allViolations
                        ),
                    ])
                    ->with('violation_reasons', $allReasons)
                    ->with('violations', $allViolations);
            }

            if ($status === 'published') {
                // Gửi thông báo cho tác giả
                $author = User::find($article->author_id);
                if ($author && $author->id !== auth()->id()) {
                    $author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã được duyệt và xuất bản."));
                }
            } elseif ($status === 'rejected') {
                // Gửi thông báo cho tác giả
                $author = User::find($article->author_id);
                if ($author && $author->id !== auth()->id()) {
                    $author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối."));
                }
            }

            // Log xác nhận session success đã được thiết lập
            Log::info('Session success đã được thiết lập sau khi cập nhật: Bài viết đã được cập nhật thành công!');

            return redirect()
                ->route('articles.index')
                ->with('success', 'Bài viết đã được cập nhật thành công!');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật bài viết: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật bài viết: ' . $e->getMessage());
        }
    }

    // duyệt bài viết
    public function Approves()
    {
        $articles = Article::with(['author', 'category', 'approver', 'tags'])
            ->where('status', 'pending') // Lọc bài viết có trạng thái pending
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.articles.approve', compact('articles'));
    }

    public function reject(Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để từ chối.');
        }

        $article->update([
            'status' => 'rejected',
        ]);

        // Gửi thông báo cho tác giả
        $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' của bạn đã bị từ chối."));

        return redirect()->back()->with('success', 'Bài viết đã bị từ chối.');
    }

    /**
     *
     */
    public function destroy(Article $article)
    {
        if ($article->thumbnail_url) {
            Storage::disk('public')->delete($article->thumbnail_url);
        }

        $article->comments()->delete();

        $article->tags()->detach();

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Bài viết đã bị xóa!');
    }

    /**
     * Ẩn/hiện bài viết
     */
    public function toggleVisibility(Article $article)
    {
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

        // Gửi thông báo cho tác giả nếu admin không phải là tác giả
        if ($article->author_id !== auth()->id()) {
            try {
                $article->author->notify(new ArticleStatusUpdated(
                    $article,
                    "Bài viết '{$article->title}' của bạn đã được " .
                        ($article->status === 'published' ? 'hiện' : 'ẩn') . "."
                ));
            } catch (\Exception $e) {
                Log::error("Không thể gửi thông báo: " . $e->getMessage());
            }
        }

        // Sử dụng redirect()->back() để đảm bảo tất cả tham số truy vấn được giữ lại
        return redirect()->back()->with('success', $message);
    }

    /**
     * Hiển thị trang hướng dẫn viết bài
     */
    public function writingGuidelines()
    {
        return view('admin.writing-guidelines');
    }
}

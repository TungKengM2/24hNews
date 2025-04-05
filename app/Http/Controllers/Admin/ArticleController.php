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

class ArticleController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    /**
     * Hiển thị danh sách bài viết cho admin
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all'); // Mặc định hiển thị tất cả bài viết
        $search = $request->input('search');

        $query = Article::with(['author', 'category', 'approver', 'tags'])
            ->orderBy('created_at', 'desc');

        // Áp dụng bộ lọc
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
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        }
        // Khi 'all' không áp dụng bộ lọc status để hiển thị tất cả bài viết

        // Áp dụng tìm kiếm nếu có
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
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
                'category_id' => 'nullable|exists:categories,category_id',
                'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'status' => 'required|in:draft,pending,published,rejected,archived',
                'content' => $request->status !== 'draft' ? 'required' : 'nullable',
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

                return redirect()->route('articles.index')->with('success', 'Bài viết đã được lưu nháp!');
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

            $approvalData = [
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => $article->author_id,
                'status' => $status,
                'remarks' => $finalViolationLevel === 'high'
                    ? 'Nội dung vi phạm nghiêm trọng: ' . implode(', ', $allViolations)
                    : ($finalViolationLevel === 'medium'
                        ? 'Nội dung cần kiểm duyệt: ' . implode(', ', $allViolations)
                        : 'Bài viết mới tạo bởi quản trị viên'),
                'approved_by' => $status === 'published' ? auth()->id() : null,
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

            try {
                // Gửi thông báo cho người liên quan nếu không phải là người tạo
                if ($article->author_id !== auth()->id()) {
                    $article->author->notify(new ArticleStatusUpdated($article, "Bài viết '{$article->title}' đã được tạo bởi quản trị viên."));
                }
            } catch (\Exception $e) {
                \Log::error("Không thể gửi thông báo: " . $e->getMessage());
            }

            return redirect()->route('articles.index')->with('success', 'Bài viết đã được tạo thành công!');
        } catch (Exception $e) {
            Log::error('Lỗi tạo bài viết (Admin): ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
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
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $article->article_id . ',article_id',
            'content' => 'nullable',
            'author_id' => 'required|exists:users,user_id',
            'category_id' => 'nullable|exists:categories,category_id',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,pending,published,rejected,archived',
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

            return redirect()->route('articles.index')->with('success', 'Bài viết đã được lưu nháp!');
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

        return redirect()->route('articles.index')->with('success', 'Bài viết đã được cập nhật thành công!');
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
}

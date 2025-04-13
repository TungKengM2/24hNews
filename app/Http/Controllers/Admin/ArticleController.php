<?php

namespace App\Http\Controllers\Admin;

use Exception;
use DOMDocument;
use App\Models\Tag;
use App\Models\User;
use App\Models\Article;
use App\Models\Approval;
use App\Models\Category;
use App\Helpers\CodeHelper;
use Illuminate\Http\Request;
use App\Models\ModerationLog;
use App\Models\ArticleVersion;
use App\Services\ModerationService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewArticleSubmitted;
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Support\Facades\Notification;

use App\Notifications\ArticleRejected;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage;

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

        $query = Article::with(['author', 'category', 'approver', 'tags'])
            ->where('author_id', auth()->id()) // Chỉ lấy bài viết của admin đang đăng nhập
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
            $query->where(function ($q) use ($searchTerm) {
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
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $childCategories = Category::whereNotNull('parent_id')->where('is_active', true)->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get();
        $tags = Tag::all();

        return view('admin.articles.create', compact('parentCategories', 'childCategories', 'authors', 'approvers', 'tags'));
    }

    /**
     *
     */
    public function approve(Article $article)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để duyệt.');
        }

        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status,
            'approved_by' => $article->approved_by
        ];

        $article->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
        ]);

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => 'published',
            'approved_by' => auth()->id(),
            'published_at' => now()->toDateTimeString()
        ];

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                'approve',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => 'Phê duyệt bài viết'
                ],
                $beforeState,
                $afterState,
                'none'
            );
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn luồng
            \Illuminate\Support\Facades\Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
        }

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
                'code' => 'nullable|string|max:255|unique:articles,code',
                'slug' => 'required|string|max:255|unique:articles,slug',
                'content' => 'required',
                'category_id' => 'required|exists:categories,category_id',
                'subcategory_id' => 'nullable|exists:categories,category_id',
                'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'status' => 'required|in:draft,pending,published,rejected,archived',
            ];

            if ($request->subcategory_id) {
                $subcategory = Category::find($request->subcategory_id);
                if (!$subcategory || $subcategory->parent_id != $request->category_id) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'Danh mục con phải thuộc danh mục cha đã chọn.');
                }
            }

            $request->validate($rules);

            if ($request->status === 'draft') {
                $article = Article::create([
                    'title' => $request->title,
                    'code' => CodeHelper::generateArticleCode(),
                    'slug' => $request->slug,
                    'content' => $request->input('content') ?? '',
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
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
                    'code' => CodeHelper::generateArticleCode(),
                    'slug' => $request->slug,
                    'content' => $content,
                    'author_id' => $request->author_id ?? auth()->id(),
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'status' => $status,
                ]);

                // Tạo phiên bản đầu tiên cho bài viết
                ArticleVersion::create([
                    'version_id' => $article->code . '-v1',
                    'article_id' => $article->article_id,
                    'user_id' => auth()->id(),
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $content,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'featured_image' => $request->hasFile('thumbnail_url') ? $request->file('thumbnail_url')->store('thumbnails', 'public') : null,
                    'tags' => $request->input('tags', []),
                    'change_reason' => 'Tạo bài viết mới'
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

            // Chỉ xử lý các tag không rỗng
            if (!empty($tag)) {
                $tagModel = Tag::firstOrCreate(['name' => $tag]);
                $tagIds[] = $tagModel->tag_id;
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

    public function rateArticle($article_id)
    {
        $article = Article::withCount(['likes', 'comments'])->findOrFail($article_id);

        $score = $article->interaction_score;
        $rating = $article->rating_star;

        return view('admin.articles.show', compact('article'));
    }


    /**
     *
     */
    public function edit(Article $article)
    {
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $childCategories = Category::whereNotNull('parent_id')->where('is_active', true)->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)->select('user_id', 'username')->get();

        // Lấy tất cả tags có trong database
        $tags = Tag::select('tag_id', 'name')->get();

        // Lấy danh sách tên tag đã chọn của bài viết
        $selectedTags = $article->tags->pluck('name')->toArray();

        // Lấy danh sách danh mục con thuộc danh mục cha đã chọn
        $selectedChildCategories = collect();
        if ($article->category_id) {
            $selectedChildCategories = Category::where('parent_id', $article->category_id)
                ->where('is_active', true)
                ->get();
        }

        return view('admin.articles.edit', compact('article', 'parentCategories', 'childCategories', 'selectedChildCategories', 'authors', 'approvers', 'tags', 'selectedTags'));
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
                'subcategory_id' => 'nullable|exists:categories,category_id',
                'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'status' => 'required|in:draft,pending,published,archived,rejected',
                'content' => 'nullable',
            ];

            // Kiểm tra nếu có subcategory_id, phải thuộc category_id đã chọn
            if ($request->subcategory_id) {
                $subcategory = Category::find($request->subcategory_id);
                if (!$subcategory || $subcategory->parent_id != $request->category_id) {
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'Danh mục con phải thuộc danh mục cha đã chọn.');
                }
            }

            $request->validate($rules);

            if ($request->status === 'draft') {
                $article->update([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request->input('content') ?? '',
                    'author_id' => $request->author_id,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
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
                'subcategory_id' => $request->subcategory_id,
                'status' => $status,
            ]);

            // Đếm số phiên bản hiện có và tạo số phiên bản mới
            $versionCount = ArticleVersion::where('article_id', $article->article_id)->count();
            $nextVersionNumber = $versionCount + 1;

            // Tạo version mới cho bài viết
            ArticleVersion::create([
                'version_id' => $article->code . '-v' . $nextVersionNumber,
                'article_id' => $article->article_id,
                'user_id' => auth()->id(),
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $content,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'featured_image' => $request->hasFile('thumbnail_url') ? $request->file('thumbnail_url')->store('thumbnails', 'public') : $article->thumbnail_url,
                'tags' => $request->input('tags', []),
                'change_reason' => 'Cập nhật bài viết'
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

    public function reject(Article $article, Request $request)
    {
        if ($article->status !== 'pending') {
            return redirect()->back()->with('error', 'Bài viết không hợp lệ để từ chối.');
        }

        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status
        ];

        $article->update([
            'status' => 'rejected',
        ]);

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => 'rejected',
            'rejected_at' => now()->toDateTimeString()
        ];

        // Lấy lý do từ chối nếu có
        $reason = $request->input('rejection_reason', 'Không đạt yêu cầu');

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                'reject',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => 'Từ chối bài viết',
                    'reason' => $reason
                ],
                $beforeState,
                $afterState,
                'medium'
            );
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn luồng
            \Illuminate\Support\Facades\Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
        }

        // Gửi thông báo cho tác giả
        $article->author->notify(new ArticleRejected($article, $request->rejection_reason));

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
        // Lưu trạng thái trước khi cập nhật
        $beforeState = [
            'status' => $article->status
        ];

        // Nếu trạng thái là published, đổi thành archived và ngược lại
        if ($article->status === 'published') {
            $article->update(['status' => 'archived']);
            $message = "Bài viết đã được ẩn thành công.";
            $action = "Ẩn bài viết đã xuất bản";
        } elseif ($article->status === 'archived') {
            $article->update(['status' => 'published']);
            $message = "Bài viết đã được hiện thành công.";
            $action = "Hiện lại bài viết đã ẩn";
        } else {
            return redirect()->back()->with('error', "Chỉ có thể ẩn/hiện bài viết đã xuất bản hoặc đã ẩn.");
        }

        // Lưu trạng thái sau khi cập nhật
        $afterState = [
            'status' => $article->status,
            'updated_at' => now()->toDateTimeString()
        ];

        // Tạo log kiểm duyệt
        try {
            ModerationLog::createLog(
                $article->status === 'published' ? 'restore' : 'flag',
                'article',
                $article->article_id,
                [
                    'title' => $article->title,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                    'action' => $action
                ],
                $beforeState,
                $afterState,
                'low'
            );
        } catch (\Exception $e) {
            // Ghi log lỗi nhưng không làm gián đoạn luồng
            \Illuminate\Support\Facades\Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
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
     * Hiển thị danh sách các phiên bản của bài viết
     */
    public function versions(Article $article)
    {

        $versions = ArticleVersion::where('article_id', $article->article_id)
            ->with(['user', 'category', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.articles.versions', compact('article', 'versions'));
    }

    /**
     * Hiển thị chi tiết một phiên bản cụ thể
     */
    public function showVersion(Article $article, $versionId)
    {

        $version = ArticleVersion::where('article_id', $article->article_id)
            ->where('version_id', $versionId)
            ->with(['user', 'category', 'subcategory'])
            ->firstOrFail();

        return view('admin.articles.version-detail', compact('article', 'version'));
    }
}

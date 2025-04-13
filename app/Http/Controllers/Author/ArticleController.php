<?php

namespace App\Http\Controllers\Author;

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
use App\Notifications\ArticleStatusUpdated;
use Illuminate\Validation\ValidationException;
use App\Notifications\PendingArticleNotification;

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
                } elseif ($filter === 'archived') {
                    $query->where('status', 'archived');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('author.articles.index', compact('articles', 'filter'));
    }

    public function update(Request $request, Article $article)
    {
        try {
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
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
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
                        $clientBlockedImages = json_decode(
                            $request->blocked_images_list,
                            true
                        );
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

            // Lưu trạng thái trước khi cập nhật
            $beforeState = [
                'status' => $article->status
            ];

            $article->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $content,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'status' => 'pending',
            ]);

            // Lưu trạng thái sau khi cập nhật
            $afterState = [
                'status' => 'pending',
                'submitted_at' => now()->toDateTimeString()
            ];

            // Tạo log kiểm duyệt
            try {
                ModerationLog::createLog(
                    'auto_moderate',
                    'article',
                    $article->article_id,
                    [
                        'title' => $article->title,
                        'author_id' => $article->author_id,
                        'category_id' => $article->category_id,
                        'action' => 'Bài viết được gửi lại để kiểm duyệt'
                    ],
                    $beforeState,
                    $afterState,
                    'none'
                );
            } catch (\Exception $e) {
                // Ghi log lỗi nhưng không làm gián đoạn luồng
                \Illuminate\Support\Facades\Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
            }

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
                    ? 'Nội dung vi phạm nghiêm trọng: ' . implode(', ', $allViolations)
                    : ($finalViolationLevel === 'medium'
                        ? 'Nội dung cần kiểm duyệt: ' . implode(', ', $allViolations)
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
                        'content' => 'Nội dung vi phạm nghiêm trọng: ' . implode(
                            ', ',
                            $allViolations
                        ),
                    ])
                    ->with('violation_reasons', $allReasons)
                    ->with('violations', $allViolations);
            }

            try {
                // Gửi thông báo cho moderator quản lý danh mục này
                $moderator = $article->category->moderator;
                if ($moderator) {
                    $moderator->notify(new PendingArticleNotification($article));
                }
            } catch (Exception $e) {
                Log::error('Lỗi gửi thông báo: ' . $e->getMessage());
            }

            // Log xác nhận session success đã được thiết lập
            Log::info('Session success đã được thiết lập sau khi cập nhật: Bài viết đã được cập nhật thành công và đang chờ phê duyệt!');

            return redirect()
                ->route('author.articles.index')
                ->with('success', 'Bài viết đã được cập nhật thành công và đang chờ phê duyệt!');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật bài viết: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật bài viết: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
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
                'author_id' => auth()->id(),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
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
                    $clientBlockedImages = json_decode(
                        $request->blocked_images_list,
                        true
                    );
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

            $article = Article::create([
                'title' => $request->title,
                'code' => CodeHelper::generateArticleCode(),
                'slug' => $request->slug,
                'content' => $content,
                'author_id' => auth()->id(),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'status' => 'pending',
            ]);

            // Tạo log kiểm duyệt cho bài viết mới
            try {
                ModerationLog::createLog(
                    'auto_moderate',
                    'article',
                    $article->article_id,
                    [
                        'title' => $article->title,
                        'author_id' => $article->author_id,
                        'category_id' => $article->category_id,
                        'action' => 'Bài viết mới được gửi để kiểm duyệt'
                    ],
                    null,
                    [
                        'status' => 'pending',
                        'created_at' => now()->toDateTimeString()
                    ],
                    'none'
                );
            } catch (\Exception $e) {
                // Ghi log lỗi nhưng không làm gián đoạn luồng
                \Illuminate\Support\Facades\Log::error('Lỗi khi tạo log kiểm duyệt: ' . $e->getMessage());
            }

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

            $approver = User::where('username', 'ai')->first();
            $approvalData = [
                'article_id' => $article->article_id,
                'type' => 'article',
                'user_id' => auth()->id(),
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

            session()->forget('blocked_images');

            // Log xác nhận session success đã được thiết lập
            Log::info('Session success đã được thiết lập: Bài viết đã được tạo thành công và đang chờ phê duyệt!');

            // Gửi thông báo cho moderator quản lý danh mục này
            $moderator = $article->category->moderator;
            if ($moderator) {
                $moderator->notify(new PendingArticleNotification($article));
            }

            return redirect()
                ->route('author.articles.index')
                ->with('success', 'Bài viết đã được tạo thành công và đang chờ phê duyệt!');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (Exception $e) {
            Log::error('Lỗi tạo bài viết: ' . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Đã xảy ra lỗi khi tạo bài viết: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $childCategories = Category::whereNotNull('parent_id')->where('is_active', true)->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();
        $tags = Tag::all();

        return view(
            'author.articles.create',
            compact('parentCategories', 'childCategories', 'authors', 'approvers', 'tags')
        );
    }

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
        $parentCategories = Category::whereNull('parent_id')->where('is_active', true)->get();
        $childCategories = Category::whereNotNull('parent_id')->where('is_active', true)->get();
        $authors = User::select('user_id', 'username')->get();
        $approvers = User::where('role_id', 1)
            ->select('user_id', 'username')
            ->get();

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

        return view(
            'author.articles.edit',
            compact(
                'article',
                'parentCategories',
                'childCategories',
                'selectedChildCategories',
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

        // Kiểm tra xem request có phải là ajax không
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        // Sử dụng redirect()->back() để đảm bảo tất cả tham số truy vấn được giữ lại
        return redirect()->back()->with('success', $message);
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
            $path = $file->store('uploads', 'public');

            return response()->json([
                'location' => asset("storage/$path"),
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
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
    }

    public function requestReview(Article $article)
    {
        // Kiểm tra quyền sở hữu bài viết
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền thực hiện hành động này.');
        }

        // Kiểm tra trạng thái bài viết
        if ($article->status !== 'rejected') {
            return redirect()
                ->back()
                ->with('error', 'Chỉ có thể xin duyệt lại các bài viết đã bị từ chối.');
        }

        // Cập nhật trạng thái bài viết thành 'pending'
        $article->update([
            'status' => 'pending'
        ]);


        $approvalData = [
            'type' => 'article',
            'user_id' => auth()->id(),
            'status' => 'pending',
            'remarks' => 'Bài viết đã được gửi lại để xin duyệt',
            'approved_by' => null,
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

        // Gửi thông báo cho moderator quản lý danh mục này nếu có
        if ($article->category && $article->category->moderator) {
            $article->category->moderator->notify(new PendingArticleNotification($article));
        }

        return redirect()
            ->route('author.articles.index')
            ->with('success', 'Bài viết đã được gửi lại để xin duyệt!');
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




    //    public function updateStatus(Request $request, $id)
    //    {
    //        $article = Article::find($id);
    //
    //        if (!$article) {
    //            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
    //        }
    //
    //        $article->status = $request->status;
    //        $article->save();
    //
    //        if (!$article->author) {
    //            Log::error("Không tìm thấy tác giả của bài viết ID: {$article->id}");
    //            return response()->json(['message' => 'Không tìm thấy tác giả'], 500);
    //        }
    //
    //        $message = "Bài viết '{$article->title}' của bạn đã được " .
    //            ($article->status === 'published' ? 'duyệt.' : 'từ chối.');
    //
    //        try {
    //            $article->author->notify(new ArticleStatusUpdated($article, $message));
    //        } catch (\Exception $e) {
    //            Log::error("Lỗi khi gửi thông báo: " . $e->getMessage());
    //        }
    //
    //        return response()->json(['message' => 'Trạng thái bài viết đã được cập nhật.']);
    //    }


    /**
     * Hiển thị danh sách các phiên bản của bài viết
     */
    public function writingGuidelines()
    {
        return view('author.writing-guidelines');
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $articlesQuery = Article::with(['category', 'tags'])
    //         ->where('author_id', auth()->id())
    //         ->orderBy('created_at', 'desc');

    //     if ($query) {
    //         $articlesQuery->where(function ($q) use ($query) {
    //             $q->where('title', 'like', "%{$query}%")
    //                 ->orWhere('content', 'like', "%{$query}%");
    //         });
    //     }

    //     $articles = $articlesQuery->paginate(10);

    //     return response()->json([
    //         'data' => $articles->items(),
    //         'links' => $articles->links()->render(),
    //         'total' => $articles->total(),
    //     ]);
    // }

    public function versions(Article $article)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền xem phiên bản của bài viết này.');
        }

        $versions = ArticleVersion::where('article_id', $article->article_id)
            ->with(['user', 'category', 'subcategory'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('author.articles.versions', compact('article', 'versions'));
    }

    public function showVersion(Article $article, $versionId)
    {
        if ($article->author_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền xem phiên bản của bài viết này.');
        }

        $version = ArticleVersion::where('article_id', $article->article_id)
            ->where('version_id', $versionId)
            ->with(['user', 'category', 'subcategory'])
            ->firstOrFail();

        return view('author.articles.version-detail', compact('article', 'version'));
    }
}

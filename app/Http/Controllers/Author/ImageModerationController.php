<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Services\ModerationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImageModerationController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function moderateImageUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'URL không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $startTime = microtime(true);
            $imageUrl = $request->input('image_url');

            $blockedImageHash = $this->checkBlockedImageUrl($imageUrl);
            if ($blockedImageHash) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hình ảnh đã từng bị chặn do vi phạm: '.($blockedImageHash['reason'] ?? 'Vi phạm quy định nội dung'),
                    'violation_level' => 'high',
                    'blocked_previously' => true,
                    'hash' => $blockedImageHash['hash'],
                ]);
            }

            $cacheKey = 'moderation_url_'.md5($imageUrl);
            $cachedResult = \Illuminate\Support\Facades\Cache::get($cacheKey);

            if ($cachedResult) {
                $endTime = microtime(true);
                $executionTime = ($endTime - $startTime) * 1000;
                if ($cachedResult['status'] === 'success' && $cachedResult['violation_level'] === 'none') {
                    $this->addLocationToResult($cachedResult, $imageUrl);
                }

                return response()->json($cachedResult);
            }
            $domain = $this->extractDomain($imageUrl);
            $result = null;
            $needDownloadDomains = [
                'vnexpress.net',
                'tuoitre.vn',
                'thanhnien.vn',
                'dantri.com.vn',
                'vietnamnet.vn',
                'facebook.com',
                'fb.com',
            ];
            $shouldDownloadFirst = false;
            foreach ($needDownloadDomains as $restrictedDomain) {
                if (strpos($domain, $restrictedDomain) !== false) {
                    $shouldDownloadFirst = true;
                    break;
                }
            }

            if ($shouldDownloadFirst) {
                $result = $this->moderationService->enhancedUrlModeration($imageUrl);
            } else {
                $result = $this->moderationService->fastUrlModeration($imageUrl);

                if ($result['status'] === 'error') {
                    $result = $this->moderationService->enhancedUrlModeration($imageUrl);
                }
            }

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000;
            if ($result['status'] === 'success' && $result['violation_level'] !== 'none') {
                $this->saveBlockedImageUrl($imageUrl, $result);
            }
            if ($result['status'] === 'success' && $result['violation_level'] === 'none') {
                $this->addLocationToResult($result, $imageUrl);
            }

            if ($result['status'] === 'success') {
                \Illuminate\Support\Facades\Cache::put($cacheKey, $result,
                    60 * 24 * 7);
            }

            return response()->json($result);
        } catch (Exception $e) {
            Log::error('Lỗi kiểm duyệt hình ảnh URL: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi khi kiểm duyệt hình ảnh',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function checkBlockedImageUrl($imageUrl)
    {
        $urlHash = md5($imageUrl);

        $blockedImage = \Illuminate\Support\Facades\Cache::get('blocked_image_'.$urlHash);

        if ($blockedImage) {
            return [
                'hash' => $urlHash,
                'reason' => $blockedImage['reason'] ?? 'Vi phạm quy định nội dung',
                'timestamp' => $blockedImage['timestamp'] ?? time(),
            ];
        }

        return null;
    }

    protected function addLocationToResult(&$result, $imageUrl)
    {
        if (isset($result['location']) && ! empty($result['location'])) {
            return;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n".
                        "Accept: image/webp,image/apng,image/*,*/*;q=0.8\r\n".
                        'Referer: '.parse_url($imageUrl,
                            PHP_URL_SCHEME).'://'.parse_url($imageUrl,
                                PHP_URL_HOST)."/\r\n".
                        "Accept-Language: en-US,en;q=0.9\r\n",
                    'timeout' => 5,
                    'follow_location' => 1,
                    'max_redirects' => 3,
                ],
            ]);

            $imageContent = @file_get_contents($imageUrl, false, $context);
            if ($imageContent !== false) {
                $filename = 'url_'.time().'_'.substr(md5($imageUrl),
                    0, 10).'.jpg';
                $path = 'uploads/'.$filename;
                \Illuminate\Support\Facades\Storage::disk('public')
                    ->put($path, $imageContent);
                $result['location'] = asset("storage/$path");
            }
        } catch (\Exception $e) {
            Log::error('Lỗi lưu ảnh từ URL: '.$e->getMessage());
        }
    }

    protected function extractDomain($url)
    {
        $parsedUrl = parse_url($url);
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        if (strpos($host, 'www.') === 0) {
            $host = substr($host, 4);
        }

        return $host;
    }

    protected function saveBlockedImageUrl($imageUrl, $result)
    {
        try {
            $urlHash = md5($imageUrl);
            $reason = 'Vi phạm quy định nội dung';
            if (! empty($result['reason'])) {
                $reasons = [];
                foreach ($result['reason'] as $key => $value) {
                    $reasons[] = $value;
                }
                $reason = implode(', ', $reasons);
            }

            \Illuminate\Support\Facades\Cache::put('blocked_image_'.$urlHash,
                [
                    'url' => $imageUrl,
                    'reason' => $reason,
                    'timestamp' => time(),
                    'violations' => $result['violations'] ?? [],
                ], 60 * 24 * 30);

            return true;
        } catch (\Exception $e) {
            Log::error('Lỗi khi lưu thông tin URL ảnh bị chặn: '.$e->getMessage());

            return false;
        }
    }

    public function moderateImageUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->moderationService->handleImageUploadModeration(
                $request->file('image')
            );

            return response()->json($result);
        } catch (Exception $e) {
            Log::error('Lỗi kiểm duyệt hình ảnh tải lên: '.$e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi khi kiểm duyệt hình ảnh',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkImageModeration(Request $request)
    {
        if (! $request->hasFile('image') || ! $request->file('image')
            ->isValid()) {
            return response()->json([
                'status' => 'error',
                'message' => 'File không hợp lệ',
                'violation_level' => 'none',
            ]);
        }

        return response()->json(
            $this->moderationService->handleImageUploadModeration($request->file('image'))
        );
    }

    public function moderateImage(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $imageUrl = $request->input('url');
        $startTime = microtime(true);

        try {
            $blockedImages = session('blocked_images', []);
            foreach ($blockedImages as $blockedImage) {
                if (isset($blockedImage['url']) && $blockedImage['url'] === $imageUrl) {
                    $endTime = microtime(true);
                    $executionTime = round(($endTime - $startTime) * 1000,
                        2);

                    return response()->json([
                        'success' => true,
                        'blocked' => true,
                        'reasons' => $blockedImage['reasons'] ?? ['Nội dung không phù hợp'],
                        'execution_time' => $executionTime,
                        'message' => 'Hình ảnh không vượt qua kiểm duyệt',
                    ]);
                }
            }

            $cacheKey = 'image_moderation_'.md5($imageUrl);
            if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                $result = \Illuminate\Support\Facades\Cache::get($cacheKey);
                $endTime = microtime(true);
                $executionTime = round(($endTime - $startTime) * 1000, 2);

                if (isset($result['violation']) && $result['violation']) {
                    $blockedImages = session('blocked_images', []);
                    $blockedImages[] = [
                        'url' => $imageUrl,
                        'reasons' => $result['reasons'] ?? ['Nội dung không phù hợp'],
                        'timestamp' => now()->timestamp,
                    ];
                    session(['blocked_images' => $blockedImages]);
                }

                return response()->json([
                    'success' => true,
                    'blocked' => $result['violation'] ?? false,
                    'reasons' => $result['reasons'] ?? [],
                    'execution_time' => $executionTime,
                    'message' => $result['message'] ?? 'Kiểm duyệt hình ảnh thành công',
                    'from_cache' => true,
                ]);
            }

            $parsedUrl = parse_url($imageUrl);
            $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';

            $restrictedDomains = [
                'vnexpress.net',
                'baomoi.com',
                'dantri.com.vn',
                'vietnamnet.vn',
                'tuoitre.vn',
                'thanhnien.vn',
                'afamily.vn',
                'cafef.vn',
                'kenh14.vn',
                'giaoducthoidai.vn',
                'vtv.vn',
                'suckhoedoisong.vn',
                'zing.vn',
                'zingnews.vn',
                'genk.vn',
            ];

            $isRestrictedDomain = false;
            foreach ($restrictedDomains as $restrictedDomain) {
                if (stripos($domain, $restrictedDomain) !== false) {
                    $isRestrictedDomain = true;
                    break;
                }
            }

            $moderationResult = null;

            if ($isRestrictedDomain) {
                $moderationResult = $this->moderationService->enhancedUrlModeration($imageUrl);
            } else {
                $moderationResult = $this->moderationService->fastUrlModeration($imageUrl);

                if (isset($moderationResult['status']) && $moderationResult['status'] === 'error') {
                    $moderationResult = $this->moderationService->enhancedUrlModeration($imageUrl);
                }
            }

            $violation = false;
            $reasons = [];
            $message = 'Kiểm duyệt hình ảnh thành công';

            if (isset($moderationResult['status']) && $moderationResult['status'] === 'error') {
                $message = $moderationResult['message'] ?? 'Lỗi kiểm duyệt';
                $endTime = microtime(true);
                $executionTime = round(($endTime - $startTime) * 1000, 2);

                return response()->json([
                    'success' => false,
                    'blocked' => false,
                    'execution_time' => $executionTime,
                    'message' => $message,
                ], 500);
            }

            if (isset($moderationResult['violation_level']) && $moderationResult['violation_level'] !== 'none') {
                $violation = true;
                $reasons = $moderationResult['violations'] ?? [];
                $message = 'Hình ảnh không vượt qua kiểm duyệt: '.
                    (is_array($moderationResult['reason']) ? implode(', ',
                        array_values($moderationResult['reason'])) :
                        ($moderationResult['reason'] ?? 'Nội dung không phù hợp'));

                $blockedImages = session('blocked_images', []);
                $blockedImages[] = [
                    'url' => $imageUrl,
                    'reasons' => $reasons,
                    'timestamp' => now()->timestamp,
                ];
                session(['blocked_images' => $blockedImages]);
            } elseif (isset($moderationResult['violation']) && $moderationResult['violation']) {
                $violation = true;
                $reasons = $moderationResult['reasons'] ?? ['Nội dung không phù hợp'];
                $message = 'Hình ảnh không vượt qua kiểm duyệt: '.implode(', ',
                    $reasons);

                $blockedImages = session('blocked_images', []);
                $blockedImages[] = [
                    'url' => $imageUrl,
                    'reasons' => $reasons,
                    'timestamp' => now()->timestamp,
                ];
                session(['blocked_images' => $blockedImages]);
            }

            $cacheResult = [
                'violation' => $violation,
                'reasons' => $reasons,
                'message' => $message,
            ];

            \Illuminate\Support\Facades\Cache::put($cacheKey, $cacheResult,
                now()->addDays(7));

            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000, 2);

            return response()->json([
                'success' => true,
                'blocked' => $violation,
                'reasons' => $reasons,
                'execution_time' => $executionTime,
                'message' => $message,
                'from_cache' => false,
            ]);
        } catch (\Exception $e) {
            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime) * 1000, 2);

            \Illuminate\Support\Facades\Log::error('Lỗi kiểm duyệt hình ảnh: '.$e->getMessage()."\n".$e->getTraceAsString());

            return response()->json([
                'success' => false,
                'blocked' => false,
                'execution_time' => $executionTime,
                'message' => 'Lỗi kiểm duyệt hình ảnh: '.$e->getMessage(),
            ], 500);
        }
    }
}

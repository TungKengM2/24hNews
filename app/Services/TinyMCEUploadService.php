<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TinyMCEUploadService
{
    protected $moderationService;
    
    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }
    
    /**
     * Xử lý tải lên và kiểm duyệt hình ảnh cho TinyMCE
     *
     * @param Request $request
     * @param string $userRole Role của người dùng (admin hoặc author)
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleImageUpload(Request $request, string $userRole = 'user')
    {
        if (! $request->hasFile('file')) {
            Log::warning("Không tìm thấy file trong yêu cầu upload ($userRole)");

            return response()->json([
                'message' => 'Không có file được upload',
                'success' => false,
            ], 400);
        }

        $file = $request->file('file');

        Log::info("Thông tin file upload ($userRole): ".json_encode([
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]));

        try {
            if (! $file->isValid()) {
                Log::error("File không hợp lệ ($userRole): ".$file->getErrorMessage());

                return response()->json([
                    'message' => 'File không hợp lệ: '.$file->getErrorMessage(),
                    'success' => false,
                ], 400);
            }

            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
            ];
            
            if (! in_array($file->getMimeType(), $allowedMimeTypes)) {
                Log::warning("File upload không hỗ trợ định dạng ($userRole): ".$file->getMimeType());
                return response()->json([
                    'message' => 'Chỉ chấp nhận các file hình ảnh: jpeg, png, gif, webp',
                    'success' => false,
                ], 415);
            }

            // Đầu tiên tải ảnh lên để có URL
            $uploadPath = $file->store('uploads', 'public');
            $filePath = storage_path('app/public/'.$uploadPath);
            $imageUrl = asset('storage/'.$uploadPath);

            // Kiểm tra xem file có tồn tại và có thể truy cập được không
            if (!file_exists($filePath)) {
                Log::error("File không tồn tại sau khi tải lên ($userRole): ".$filePath);
                return response()->json([
                    'message' => 'Lỗi: Không thể lưu file',
                    'success' => false,
                ], 500);
            }

            // Sử dụng phương thức enhancedUrlModeration để đảm bảo kiểm duyệt triệt để
            try {
                $moderationResult = $this->moderationService->enhancedUrlModeration($imageUrl);
                
                // Log kết quả kiểm duyệt để dễ debug
                Log::info("Kết quả kiểm duyệt ảnh ($userRole): ".json_encode($moderationResult));
                
                // Nếu không nhận được kết quả kiểm duyệt hợp lệ, sử dụng phương thức khác
                if ($moderationResult['status'] !== 'success') {
                    Log::warning("Kiểm duyệt enhancedUrlModeration thất bại ($userRole), sử dụng handleImageUploadModeration");
                    $moderationResult = $this->moderationService->handleImageUploadModeration($file);
                    Log::info("Kết quả kiểm duyệt thứ hai ($userRole): ".json_encode($moderationResult));
                }
            } catch (\Exception $e) {
                Log::error("Lỗi trong quá trình kiểm duyệt ($userRole): ".$e->getMessage());
                // Giữ lại file đã upload nhưng đánh dấu là có lỗi kiểm duyệt
                $moderationResult = [
                    'status' => 'success', // Vẫn trả về success để hiển thị ảnh
                    'violation_level' => 'none', // Không đánh dấu vi phạm
                    'moderation_method' => 'error_handled',
                    'message' => 'Lỗi kiểm duyệt: '.$e->getMessage()
                ];
            }

            if (isset($moderationResult['status']) && $moderationResult['status'] === 'success' && 
                isset($moderationResult['violation_level']) && $moderationResult['violation_level'] !== 'none') {
                
                Log::warning("Hình ảnh vi phạm ($userRole): ".$imageUrl.', Lý do: '.json_encode($moderationResult['reason'] ?? ['Nội dung không phù hợp']));
                
                $this->storeBlockedImage($imageUrl, $uploadPath, $moderationResult['reason'] ?? ['Nội dung không phù hợp']);
                Storage::disk('public')->delete($uploadPath);

                return response()->json([
                    'message' => 'Hình ảnh không vượt qua kiểm duyệt',
                    'location' => $imageUrl,
                    'blocked' => true,
                    'url' => $imageUrl,
                    'reasons' => $moderationResult['reason'] ?? ['Nội dung không phù hợp'],
                    'success' => false,
                ]);
            }

            // Thêm kiểm tra file_exists cuối cùng trước khi trả về kết quả
            if (!file_exists($filePath)) {
                Log::error("File không tồn tại trước khi trả kết quả ($userRole): ".$filePath);
                return response()->json([
                    'message' => 'Lỗi: File đã tải lên nhưng không thể truy cập',
                    'success' => false,
                ], 500);
            }

            return response()->json([
                'location' => $imageUrl,
                'blocked' => false,
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error("Lỗi khi upload hình ảnh TinyMCE ($userRole): ".$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());

            if (isset($uploadPath) && Storage::disk('public')->exists($uploadPath)) {
                Storage::disk('public')->delete($uploadPath);
            }

            return response()->json([
                'message' => 'Lỗi khi xử lý file: '.$e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    /**
     * Lưu thông tin ảnh bị chặn vào session
     * 
     * @param string $imageUrl
     * @param string $uploadPath
     * @param array $reasons
     * @return void
     */
    protected function storeBlockedImage(string $imageUrl, string $uploadPath, array $reasons): void
    {
        $blockedImages = session('blocked_images', []);
        $blockedImages[] = [
            'url' => $imageUrl,
            'file_path' => $uploadPath,
            'reasons' => $reasons,
            'timestamp' => now()->timestamp,
        ];
        
        session(['blocked_images' => $blockedImages]);
    }
    
    /**
     * Xóa danh sách ảnh bị chặn khỏi session
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearBlockedImages()
    {
        session()->forget('blocked_images');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa thông tin ảnh bị chặn',
        ]);
    }
} 
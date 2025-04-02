<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Services\ModerationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TinyMCEUploadController extends Controller
{
    protected $moderationService;

    public function __construct(ModerationService $moderationService)
    {
        $this->moderationService = $moderationService;
    }

    public function uploadImage(Request $request)
    {
        if (! $request->hasFile('file')) {
            Log::warning('Không tìm thấy file trong yêu cầu upload');

            return response()->json([
                'message' => 'Không có file được upload',
                'success' => false,
            ], 400);
        }

        $file = $request->file('file');

        Log::info('Thông tin file upload: '.json_encode([
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]));

        try {
            if (! $file->isValid()) {
                Log::error('File không hợp lệ: '.$file->getErrorMessage());

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
                Log::error('File không tồn tại sau khi tải lên: ' . $filePath);
                return response()->json([
                    'message' => 'Lỗi: Không thể lưu file',
                    'success' => false,
                ], 500);
            }

            // Sử dụng phương thức enhancedUrlModeration để đảm bảo kiểm duyệt triệt để
            try {
                $moderationResult = $this->moderationService->enhancedUrlModeration($imageUrl);
                
                // Log kết quả kiểm duyệt để dễ debug
                Log::info('Kết quả kiểm duyệt ảnh: ' . json_encode($moderationResult));
                
                // Nếu không nhận được kết quả kiểm duyệt hợp lệ, sử dụng phương thức khác
                if ($moderationResult['status'] !== 'success') {
                    Log::warning('Kiểm duyệt enhancedUrlModeration thất bại, sử dụng handleImageUploadModeration');
                    $moderationResult = $this->moderationService->handleImageUploadModeration($file);
                    Log::info('Kết quả kiểm duyệt thứ hai: ' . json_encode($moderationResult));
                }
            } catch (\Exception $e) {
                Log::error('Lỗi trong quá trình kiểm duyệt: ' . $e->getMessage());
                // Giữ lại file đã upload nhưng đánh dấu là có lỗi kiểm duyệt
                $moderationResult = [
                    'status' => 'success', // Vẫn trả về success để hiển thị ảnh
                    'violation_level' => 'none', // Không đánh dấu vi phạm
                    'moderation_method' => 'error_handled',
                    'message' => 'Lỗi kiểm duyệt: ' . $e->getMessage()
                ];
            }

            if (isset($moderationResult['status']) && $moderationResult['status'] === 'success' && isset($moderationResult['violation_level']) && $moderationResult['violation_level'] !== 'none') {
                Log::warning('Hình ảnh vi phạm: ' . $imageUrl . ', Lý do: ' . json_encode($moderationResult['reason'] ?? ['Nội dung không phù hợp']));
                $blockedImages = session('blocked_images', []);
                $blockedImages[] = [
                    'url' => $imageUrl,
                    'file_path' => $uploadPath,
                    'reasons' => $moderationResult['reason'] ?? ['Nội dung không phù hợp'],
                    'timestamp' => now()->timestamp,
                ];
                session(['blocked_images' => $blockedImages]);

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
                Log::error('File không tồn tại trước khi trả kết quả: ' . $filePath);
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
            Log::error('Lỗi khi upload hình ảnh TinyMCE: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());

            if (isset($uploadPath) && Storage::disk('public')
                ->exists($uploadPath)) {
                Storage::disk('public')->delete($uploadPath);
            }

            return response()->json([
                'message' => 'Lỗi khi xử lý file: '.$e->getMessage(),
                'success' => false,
            ], 500);
        }
    }

    public function clearBlockedImages()
    {
        session()->forget('blocked_images');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa thông tin ảnh bị chặn',
        ]);
    }
}

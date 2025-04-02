<?php

namespace App\Http\Controllers\Admin;

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
            Log::warning('Không tìm thấy file trong yêu cầu upload (Admin)');
            return response()->json([
                'message' => 'Không có file được upload',
                'success' => false,
            ], 400);
        }

        $file = $request->file('file');
        Log::info('Đang xử lý file upload (Admin): ' . $file->getClientOriginalName());

        try {
            if (! $file->isValid()) {
                Log::error('File không hợp lệ (Admin): ' . $file->getErrorMessage());
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
                Log::warning('File upload không hỗ trợ định dạng (Admin): ' . $file->getMimeType());
                return response()->json([
                    'message' => 'Chỉ chấp nhận các file hình ảnh: jpeg, png, gif, webp',
                    'success' => false,
                ], 415);
            }

            $uploadPath = $file->store('uploads', 'public');
            $fileUrl = asset('storage/'.$uploadPath);

            // Kiểm duyệt ảnh sử dụng API Sightengine trực tiếp
            $moderationResult = $this->moderationService->moderateImageFile($file);
            Log::info('Kết quả kiểm duyệt từ Sightengine (Admin): ' . json_encode($moderationResult));

            if ($moderationResult['violation_level'] !== 'none') {
                $blockedImages = session('blocked_images', []);
                $blockedImages[] = [
                    'url' => $fileUrl,
                    'file_path' => $uploadPath,
                    'reasons' => $moderationResult['reason'] ?? ['Nội dung không phù hợp'],
                    'timestamp' => now()->timestamp,
                ];
                session(['blocked_images' => $blockedImages]);

                Storage::disk('public')->delete($uploadPath);
                
                Log::warning('Ảnh không vượt qua kiểm duyệt (Admin): ' . $fileUrl);

                return response()->json([
                    'message' => 'Hình ảnh không vượt qua kiểm duyệt',
                    'location' => $fileUrl,
                    'blocked' => true,
                    'url' => $fileUrl,
                    'reasons' => $moderationResult['reason'] ?? ['Nội dung không phù hợp'],
                    'success' => false,
                ]);
            }

            Log::info('Ảnh vượt qua kiểm duyệt (Admin): ' . $fileUrl);
            return response()->json([
                'location' => $fileUrl,
                'blocked' => false,
                'success' => true,
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi upload hình ảnh TinyMCE (Admin): '.$e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

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
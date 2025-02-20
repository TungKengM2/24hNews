<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        // Kiểm tra nếu có file tải lên
        if (!$request->hasFile('upload')) {
            return response()->json([
                'error' => 'Không có file nào được tải lên'
            ], 400);
        }

        $file = $request->file('upload'); 
        $extension = $file->getClientOriginalExtension();
        $allowedImages = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $allowedVideos = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv'];

        // Xác thực file (tối đa 5MB cho ảnh, 50MB cho video)
        $validator = Validator::make($request->all(), [
            'upload' => [
                'required',
                function ($attribute, $value, $fail) use ($file, $extension, $allowedImages, $allowedVideos) {
                    if (!in_array($extension, array_merge($allowedImages, $allowedVideos))) {
                        $fail('Chỉ hỗ trợ tải lên ảnh và video.');
                    }
                    if (in_array($extension, $allowedImages) && $file->getSize() > 5 * 1024 * 1024) {
                        $fail('Ảnh không được vượt quá 5MB.');
                    }
                    if (in_array($extension, $allowedVideos) && $file->getSize() > 50 * 1024 * 1024) {
                        $fail('Video không được vượt quá 50MB.');
                    }
                }
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 400);
        }

        // Lưu file vào thư mục tương ứng
        $folder = in_array($extension, $allowedImages) ? 'ckeditor_images' : 'ckeditor_videos';
        $path = $file->store($folder, 'public');

        // Trả về đúng định dạng CKEditor 5 yêu cầu
        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }
}

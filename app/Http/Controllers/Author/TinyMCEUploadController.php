<?php

    namespace App\Http\Controllers\Author;

    use App\Http\Controllers\Controller;
    use App\Services\TinyMCEUploadService;
    use Illuminate\Http\Request;

    class TinyMCEUploadController extends Controller
    {
        protected $uploadService;

        public function __construct(TinyMCEUploadService $uploadService)
        {
            $this->uploadService = $uploadService;
        }

        /**
         * Xử lý upload hình ảnh từ TinyMCE (Author)
         *
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function uploadImage(Request $request)
        {
            return $this->uploadService->handleImageUpload($request, 'author');
        }

        /**
         * Xóa danh sách ảnh bị chặn trong session
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function clearBlockedImages()
        {
            return $this->uploadService->clearBlockedImages();
        }
    }

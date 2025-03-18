<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class GeminiOCRService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY_2');
    }

    public function extractTextFromImage($imagePath)
    {
        if (!file_exists($imagePath)) {
            throw new Exception('File không tồn tại: ' . $imagePath);
        }

        $mimeType = mime_content_type($imagePath);
        $fileSize = filesize($imagePath);

        // Bước 1: Khởi tạo tải lên
        $initResponse = $this->client->post(
            "https://generativelanguage.googleapis.com/upload/v1beta/files?key={$this->apiKey}",
            [
                'headers' => [
                    'X-Goog-Upload-Protocol' => 'resumable',
                    'X-Goog-Upload-Command' => 'start',
                    'X-Goog-Upload-Header-Content-Length' => $fileSize,
                    'X-Goog-Upload-Header-Content-Type' => $mimeType,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'file' => [
                        'display_name' => basename($imagePath),
                    ],
                ],
            ]
        );

        $uploadUrl = $initResponse->getHeaderLine('X-Goog-Upload-URL');

        if (empty($uploadUrl)) {
            throw new Exception('Không thể lấy URL tải lên');
        }

        // Bước 2: Upload ảnh lên Google
        $uploadResponse = $this->client->post($uploadUrl, [
            'headers' => [
                'Content-Length' => $fileSize,
                'X-Goog-Upload-Offset' => 0,
                'X-Goog-Upload-Command' => 'upload, finalize',
            ],
            'body' => fopen($imagePath, 'r'),
        ]);

        $fileData = json_decode($uploadResponse->getBody(), true);

        if (!isset($fileData['file']['uri'])) {
            throw new Exception('Tải lên file thất bại: ' . $uploadResponse->getBody());
        }

        $fileUri = $fileData['file']['uri'];

        // Bước 3: Gửi yêu cầu nhận diện văn bản từ ảnh
        $generateResponse = $this->client->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent?key={$this->apiKey}",
            [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Chuyển ảnh này thành text'],
                                ['file_data' => ['mime_type' => $mimeType, 'file_uri' => $fileUri]],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 2,
                        'top_p' => 0.95,
                        'top_k' => 64,
                        'max_output_tokens' => 8192,
                        'response_mime_type' => 'text/plain',
                    ],
                ],
            ]
        );

        $result = json_decode($generateResponse->getBody(), true);

        return $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}

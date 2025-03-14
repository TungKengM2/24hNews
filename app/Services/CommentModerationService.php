<?php

namespace App\Services;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Log;


class CommentModerationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('HUGGINGFACE_API_KEY');
    }

    public function checkComment($text)
    {
        Log::info("🔍 Đang kiểm tra bình luận: " . $text); // Debug xem hàm có chạy không

        try {
            $response = $this->client->post('https://api-inference.huggingface.co/models/unitary/toxic-bert', [
                'headers' => [
                    'Authorization' => 'Bearer ' . trim($this->apiKey), // Trim để tránh lỗi khoảng trắng
                    'Content-Type'  => 'application/json'
                ],
                'json' => ['inputs' => $text]
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info("📌 Kết quả từ API: " . json_encode($result)); // Ghi log kết quả

            // Kiểm tra nếu score > 0.8 thì là bình luận toxic
            return isset($result[0][0]['score']) ? $result[0][0]['score'] < 0.8 : true;
        } catch (\Exception $e) {
            Log::error("❌ Lỗi API Hugging Face: " . $e->getMessage());
            return true; // Nếu API lỗi, mặc định cho phép bình luận
        }
    }
}



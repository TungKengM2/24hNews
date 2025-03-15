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
        $this->apiKey = env('PERSPECTIVE_API_KEY'); // Lấy API Key từ .env
    }

    public function checkComment($text)
    {
        Log::info("🔍 Đang kiểm tra bình luận: " . $text); // Debug xem hàm có chạy không

        try {
            $response = $this->client->post('https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . $this->apiKey, [
                'json' => [
                    'comment' => ['text' => $text],
                    'languages' => ['vi'], // Hỗ trợ tiếng Việt
                    'requestedAttributes' => ['TOXICITY' => []]
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info("📌 Kết quả từ API: " . json_encode($result)); // Ghi log kết quả

            // Lấy điểm TOXICITY
            $toxicityScore = $result['attributeScores']['TOXICITY']['summaryScore']['value'] ?? 0;

            // Nếu score > 0 => Chặn 100%
            return $toxicityScore == 0;
        } catch (\Exception $e) {
            Log::error("❌ Lỗi API Perspective: " . $e->getMessage());
            return false; // Nếu API lỗi, mặc định từ chối bình luận
        }
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CommentModerationService
{
    protected Client $client;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('PERSPECTIVE_API_KEY');
    }

    public function checkComment(string $text): bool
    {
        if (!$this->apiKey) {
            Log::error("❌ PERSPECTIVE_API_KEY chưa được cấu hình trong .env");
            return false;
        }

        Log::info("🔍 Kiểm tra bình luận: {$text}");

        try {
            $response = $this->client->post("https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key={$this->apiKey}", [
                'json' => [
                    'comment' => ['text' => $text],
                    'languages' => ['vi'],
                    'requestedAttributes' => ['TOXICITY' => []],
                    'doNotStore' => true, // Tránh lưu dữ liệu trên server Google
                ],
                'timeout' => 5, // Tránh request treo quá lâu
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info("📌 API Response: " . json_encode($result));

            // Lấy điểm TOXICITY an toàn
            $toxicityScore = data_get($result, 'attributeScores.TOXICITY.summaryScore.value', 0);

            return $toxicityScore > 0.5;
        } catch (\Exception $e) {
            Log::error("❌ Lỗi gọi API Perspective: " . $e->getMessage());
            return false; // Nếu API lỗi, không chặn bình luận
        }
    }
}

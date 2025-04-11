<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class CommentModerationService
{
    protected Client $client;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEYY'); // Lấy API Key từ .env
    }

    public function checkComment(string $text, int $commentId = null, int $userId = null, int $articleId = null): bool
    {

        if (!$this->apiKey) {
            Log::error("❌ GEMINI_API_KEY chưa được cấu hình trong .env");
            return false;
        }


        Log::info("🔍 Kiểm tra bình luận với Gemini: {$text}");

        try {
            $response = $this->client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key={$this->apiKey}", [
                'json' => [
                    'contents' => [[
                        'parts' => [[
                            'text' => "Hãy phân tích câu sau và trả về JSON với định dạng {\"toxic\": true/false}.
                            Nếu bình luận có nội dung xúc phạm, thô tục, hãy đặt \"toxic\": true. Nếu không, đặt \"toxic\": false.
                            Bình luận: \"{$text}\""
                        ]]
                    ]],
                    'generationConfig' => [
                        'temperature' => 0, // Để AI trả về kết quả ổn định
                        'response_mime_type' => 'application/json'
                    ]
                ],
                'timeout' => 8,
            ]);

            $result = json_decode($response->getBody(), true);
            Log::info("📌 API Response: " . json_encode($result));

            // Lấy nội dung AI phản hồi
            $responseText = data_get($result, 'candidates.0.content.parts.0.text', '{}');
            $aiResponse = json_decode($responseText, true);

            if (!isset($aiResponse['toxic'])) {
                Log::error("⚠️ Không thể lấy được dữ liệu kiểm duyệt từ AI!");
                return false;
            }

            $isToxic = $aiResponse['toxic'];
            Log::info("🔍 AI đánh giá bình luận: " . ($isToxic ? "🚫 Xúc phạm" : "✅ Hợp lệ"));

            // Log moderation action if we have a comment ID
            if ($commentId && $isToxic) {
                try {
                    // Create moderation log for auto-rejected comment
                    \App\Models\ModerationLog::createLog(
                        'auto_moderate',
                        'comment',
                        $commentId,
                        [
                            'action' => 'Tự động từ chối bình luận',
                            'content' => $text,
                            'reason' => 'Nội dung không phù hợp',
                            'article_id' => $articleId,
                            'user_id' => $userId,
                        ],
                        null,
                        ['status' => 'rejected'],
                        'medium'
                    );
                } catch (\Exception $e) {
                    Log::error("❌ Lỗi khi tạo log kiểm duyệt: " . $e->getMessage());
                }
            }

            return !$isToxic; // Nếu toxic = true, chặn bình luận
        } catch (RequestException $e) {
            Log::error("❌ Lỗi gọi API Gemini: " . $e->getMessage(), [
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Lỗi không xác định: " . $e->getMessage());
        }

        Log::warning("⚠️ API gặp lỗi, mặc định CHẶN bình luận!");
        return false;
    }
}

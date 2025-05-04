<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DeepSeekModerationService
{
    private $apiKey;
    private $apiUrl = 'https://api.deepseek.com/chat/completions';
    private static $last_request_time = 0;
    private static $request_count = 0;

    public function __construct()
    {
        $this->apiKey = env('DEEPSEEK_API_KEY');
    }

    /**
     * Thực hiện kiểm soát delay giữa các request để tránh bị hạn chế kết nối
     *
     * @param int $min_delay Thời gian tối thiểu giữa các request (milliseconds)
     * @return void
     */
    private function throttleRequest($min_delay = null)
    {
        // Nếu không có tham số, lấy từ biến môi trường hoặc mặc định 500ms (giảm từ 1000ms)
        if ($min_delay === null) {
            $min_delay = (int) env('DEEPSEEK_REQUEST_DELAY', 500);
        }

        self::$request_count++;

        // Reset counter sau mỗi 20 request để không tích lũy quá nhiều (tăng từ 10)
        if (self::$request_count > 20) {
            self::$request_count = 1;
            self::$last_request_time = 0;
        }

        $current_time = microtime(true) * 1000; // convert to milliseconds
        $time_since_last = $current_time - self::$last_request_time;

        // Tăng delay chậm hơn khi có nhiều request liên tiếp
        // Thay đổi công thức để tăng chậm hơn: (1 + (self::$request_count / 10))
        $adaptive_delay = $min_delay * (1 + (self::$request_count / 10));

        if ($time_since_last < $adaptive_delay && self::$last_request_time > 0) {
            $sleep_time = ceil(($adaptive_delay - $time_since_last) / 1000); // convert to seconds

            // Giới hạn thời gian sleep tối đa là 2 giây
            $sleep_time = min($sleep_time, 2);

            if ($sleep_time > 0) {
                Log::debug("Throttling DeepSeek API request, sleeping {$sleep_time}s (request #" . self::$request_count . ")");
                sleep($sleep_time);
            }
        }

        self::$last_request_time = microtime(true) * 1000;
    }

    /**
     * Kiểm duyệt nội dung sử dụng DeepSeek API
     *
     * @param string $inputText Nội dung cần kiểm duyệt
     * @return array Kết quả kiểm duyệt
     */
    public function moderateContent($inputText): array
    {
        // Tạo cache key dựa trên hash của nội dung
        $contentHash = md5($inputText);
        $cacheKey = 'deepseek_moderation_' . $contentHash;

        // Đo thời gian kiểm tra cache
        $startCacheCheck = microtime(true);
        $cachedResult = Cache::get($cacheKey);
        $endCacheCheck = microtime(true);
        $cacheCheckTime = ($endCacheCheck - $startCacheCheck) * 1000;

        // Log thời gian kiểm tra cache
        Log::debug("DeepSeek cache check time: {$cacheCheckTime}ms");

        if ($cachedResult) {
            Log::info('Lấy kết quả kiểm duyệt nội dung từ DeepSeek cache (content hash: ' . substr($contentHash, 0, 8) . ')');
            return $cachedResult;
        }

        try {
            // Xử lý văn bản đầu vào
            $inputText = str_replace(['<br>', '<br />', '<br/>', '</p><p>'], "\n", $inputText);
            $inputText = preg_replace('/<blockquote[^>]*>(.*?)<\/blockquote>/is', "\n> $1\n", $inputText);
            $inputText = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $inputText);
            $plainText = strip_tags($inputText);
            $plainText = html_entity_decode($plainText);
            $plainText = preg_replace('/\s+/', ' ', $plainText);
            $plainText = trim($plainText);

            // Giới hạn độ dài văn bản để giảm thời gian xử lý
            $maxLength = 5000;
            if (mb_strlen($plainText) > $maxLength) {
                $plainText = mb_substr($plainText, 0, $maxLength) . '...';
            }

            if (empty($this->apiKey)) {
                Log::error('Thiếu DeepSeek API Key');
                return [
                    'status' => 'error',
                    'message' => 'Thiếu cấu hình DeepSeek API Key',
                    'violation_level' => 'none',
                    'violations' => [],
                    'reason' => [],
                ];
            }

            $prompt = <<<EOD
Bạn là hệ thống kiểm duyệt nội dung của VnExpress. Hãy phân tích đoạn văn bản sau dựa trên các tiêu chí sau và trả về JSON theo cấu trúc:
{
  "severity": {
    "level": "none|low|medium|high",
    "reason": "Lý do tổng quan về mức độ nghiêm trọng",
    "categories_affected": ["Danh mục vi phạm"]
  },
  "violations": [
    {
      "term": "từ vi phạm",
      "reason": "lý do"
    }
  ]
}
        **A. Tiêu chí vi phạm:**
        1. **Chính trị/Quốc phòng**:
           - Kích động chống đối nhà nước (ví dụ: 'lật đổ chính quyền', 'biểu tình đập phá').
           - Tiết lộ bí mật quốc gia (ví dụ: 'tài liệu mật', 'kế hoạch quân sự chưa công bố').
        2. **Xã hội/An ninh**:
           - Đe dọa tính mạng (ví dụ: 'giết người', 'nguy cơ tử vong').
           - Gây hoang mang dư luận (ví dụ: 'dịch bệnh nhân tạo', 'thực phẩm nhiễm độc').
        3. **Y tế/Sức khỏe**:
           - Lan truyền thông tin sai về vaccine (ví dụ: 'vaccine chứa chip', 'tiêm chủng gây hại').
           - Vu khống cơ quan y tế (ví dụ: 'bộ y tế lừa đảo').
        4. **Kinh tế/Tài chính**:
           - Loan tin khủng hoảng kinh tế giả (ví dụ: 'sập chứng khoán', 'nợ công vượt ngưỡng').
        5. **Văn hóa/Đạo đức**:
           - Lăng mạ cá nhân (ví dụ: 'đồ phản bội', 'thằng ngu').
           - Phân biệt chủng tộc/tôn giáo.

        **B. Ngoại lệ cho phép**:
        - Từ ngữ trong ngữ cảnh tin tức chính thống (ví dụ: 'quân đội tập trận', 'thả bom trong chiến dịch').
        - Trích dẫn ý kiến chuyên gia có kiểm chứng.

        **D. Văn bản cần kiểm tra**:
$plainText
EOD;

            // Thực hiện throttle request
            $this->throttleRequest();

            // Chuẩn bị dữ liệu cho API request
            $data = [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Bạn là hệ thống kiểm duyệt nội dung chuyên nghiệp. Nhiệm vụ của bạn là phân tích văn bản và trả về kết quả dưới dạng JSON.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0,
                'max_tokens' => 2048,
                'response_format' => ['type' => 'json_object']
            ];

            // Gọi API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
                'User-Agent: Mozilla/5.0 (compatible; 24hNews/1.0)',
                'Accept: application/json',
                'Connection: keep-alive' // Giúp tái sử dụng kết nối
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Giảm timeout từ 30s xuống 15s
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Giảm connect timeout từ 10s xuống 5s
            curl_setopt($ch, CURLOPT_TCP_NODELAY, true); // Tối ưu tốc độ truyền dữ liệu

            // Đo thời gian gọi API
            $startApiCall = microtime(true);
            $response = curl_exec($ch);
            $endApiCall = microtime(true);
            $apiCallTime = ($endApiCall - $startApiCall) * 1000; // Đổi sang milliseconds

            // Log thời gian gọi API để theo dõi hiệu suất
            Log::debug("DeepSeek API call time: {$apiCallTime}ms");

            // Kiểm tra lỗi cURL
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error('Lỗi gọi DeepSeek API: ' . $error);
                return [
                    'status' => 'error',
                    'message' => 'Không thể kết nối đến API kiểm duyệt: ' . $error,
                    'violation_level' => 'none',
                    'violations' => [],
                    'reason' => [],
                ];
            }

            curl_close($ch);

            // Xử lý kết quả
            $result = json_decode($response, true);
            if (!isset($result['choices']) || !is_array($result['choices']) || empty($result['choices']) || !isset($result['choices'][0]['message']['content'])) {
                Log::error('Lỗi phản hồi DeepSeek API không hợp lệ: ' . json_encode($result));
                return [
                    'status' => 'error',
                    'message' => 'Không nhận được kết quả kiểm duyệt hợp lệ từ DeepSeek API.',
                    'violation_level' => 'none',
                    'violations' => [],
                    'reason' => [],
                ];
            }

            $apiResponseText = $result['choices'][0]['message']['content'];

            // Ghi log để debug
            Log::debug('Phần text trả về từ DeepSeek API: ' . substr($apiResponseText, 0, 100));

            // Thử parse JSON
            $apiResponse = json_decode($apiResponseText, true);

            // Ghi log kết quả JSON đã giải mã
            Log::debug('Kết quả JSON đã giải mã từ DeepSeek: ' . json_encode($apiResponse));

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($apiResponse)) {
                Log::error('Lỗi JSON không hợp lệ từ DeepSeek API: ' . $apiResponseText);
                Log::error('Mã lỗi JSON: ' . json_last_error() . ' - ' . json_last_error_msg());

                // Thử xử lý lại JSON nếu có vấn đề với định dạng
                $cleanedJson = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $apiResponseText);
                $apiResponse = json_decode($cleanedJson, true);

                if (json_last_error() !== JSON_ERROR_NONE || !is_array($apiResponse)) {
                    // Nếu vẫn lỗi, trả về kết quả mặc định an toàn
                    return [
                        'status' => 'success',
                        'message' => 'Đã xử lý nội dung (mặc định an toàn do lỗi phân tích)',
                        'violation_level' => 'none',
                        'violations' => [],
                        'reason' => [],
                    ];
                }

                // Nếu xử lý lại thành công, ghi log
                Log::info('Đã xử lý lại JSON thành công sau khi làm sạch');
            }

            $violationTerms = [];
            $violationReasons = [];

            if (!empty($apiResponse['violations'])) {
                foreach ($apiResponse['violations'] as $violation) {
                    if (isset($violation['term']) && !empty($violation['term'])) {
                        $violationTerms[] = $violation['term'];
                        $violationReasons[$violation['term']] = $violation['reason'] ?? 'Vi phạm quy định';
                    }
                }
            }

            $result = [
                'status' => 'success',
                'violation_level' => $apiResponse['severity']['level'] ?? 'none',
                'violations' => $violationTerms,
                'reason' => $violationReasons,
            ];

            // Lưu kết quả vào cache để sử dụng lại với thời gian lưu trữ dài hơn (14 ngày)
            $cacheDuration = now()->addDays(14);
            Cache::put($cacheKey, $result, $cacheDuration);

            // Log thông tin về việc lưu cache
            Log::info('Đã lưu kết quả kiểm duyệt vào cache (content hash: ' . substr($contentHash, 0, 8) .
                      '), hết hạn: ' . $cacheDuration->format('Y-m-d H:i:s'));

            return $result;
        } catch (Exception $e) {
            Log::error('Lỗi trong quá trình kiểm duyệt nội dung với DeepSeek: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return [
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi trong quá trình kiểm duyệt nội dung: ' . $e->getMessage(),
                'violation_level' => 'none',
                'violations' => [],
                'reason' => [],
            ];
        }
    }
}

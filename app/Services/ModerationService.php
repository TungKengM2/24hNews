<?php

namespace App\Services;

use CURLFile;
use Exception;
use finfo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ModerationService
{
    public function moderateContent($inputText): array
    {
        $inputText = str_replace(['<br>', '<br />', '<br/>', '</p><p>'], "\n", $inputText);

        $inputText = preg_replace('/<blockquote[^>]*>(.*?)<\/blockquote>/is', "\n> $1\n", $inputText);

        $inputText = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $inputText);

        $plainText = strip_tags($inputText);

        $plainText = html_entity_decode($plainText);

        $plainText = preg_replace('/\s+/', ' ', $plainText);
        $plainText = trim($plainText);

        $API_KEY = env('GOOGLE_API_KEY');

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

        $data = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0,
                'topK' => 40,
                'topP' => 0.9,
                'maxOutputTokens' => 8192,
                'responseMimeType' => 'text/plain',
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent?key={$API_KEY}");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        if (
            ! isset($result['candidates']) ||
            ! is_array($result['candidates']) ||
            empty($result['candidates']) ||
            ! isset($result['candidates'][0]['content']['parts'][0]['text'])
        ) {
            return [
                'status' => 'error',
                'message' => 'Không nhận được kết quả kiểm duyệt hợp lệ từ API.',
            ];
        }

        $apiResponseText = $result['candidates'][0]['content']['parts'][0]['text'];
        $apiResponseText = trim(preg_replace('/^```json\s*|\s*```$/', '',
            $apiResponseText));

        $apiResponse = json_decode($apiResponseText, true);
        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($apiResponse)) {
            return [
                'status' => 'error',
                'message' => 'Kết quả kiểm duyệt không đúng định dạng JSON.',
            ];
        }

        $violationTerms = [];
        $violationReasons = [];

        if (! empty($apiResponse['violations'])) {
            foreach ($apiResponse['violations'] as $violation) {
                if (isset($violation['term']) && ! empty($violation['term'])) {
                    $violationTerms[] = $violation['term'];
                    $violationReasons[$violation['term']] = $violation['reason'] ?? 'Vi phạm quy định';
                }
            }
        }

        return [
            'status' => 'success',
            'violation_level' => $apiResponse['severity']['level'] ?? 'none',
            'reason' => $apiResponse['severity']['reason'] ?? 'Không có lý do',
            'violations' => $violationTerms,
            'reason' => $violationReasons,
        ];
    }

    public function handleImageUrlModeration($imageUrl)
    {
        if (empty($imageUrl) || ! filter_var($imageUrl,
            FILTER_VALIDATE_URL)) {
            return [
                'status' => 'error',
                'message' => 'URL không hợp lệ',
                'violation_level' => 'none',
            ];
        }

        $result = $this->fastUrlModeration($imageUrl);
        if ($result['status'] === 'error') {
            $result = $this->enhancedUrlModeration($imageUrl);
        }

        return $result;
    }

    public function fastUrlModeration($imageUrl)
    {
        if (empty($imageUrl) || ! filter_var($imageUrl,
            FILTER_VALIDATE_URL)) {
            return [
                'status' => 'error',
                'message' => 'URL không hợp lệ',
                'violation_level' => 'none',
            ];
        }

        $cacheKey = 'moderation_url_'.md5($imageUrl);
        $cachedResult = Cache::get($cacheKey);

        if ($cachedResult) {
            return $cachedResult;
        }

        $apiUser = env('SIGHTENGINE_API_USER');
        $apiSecret = env('SIGHTENGINE_API_SECRET');

        if (empty($apiUser) || empty($apiSecret)) {
            Log::error('Thiếu thông tin API Sightengine (SIGHTENGINE_API_USER, SIGHTENGINE_API_SECRET)');

            return [
                'status' => 'error',
                'message' => 'Cấu hình API kiểm duyệt thiếu thông tin',
                'violation_level' => 'none',
            ];
        }

        $params = [
            'url' => $imageUrl,
            'models' => 'nudity-2.1,offensive-2.0,text-content,gore-2.0,violence,self-harm,gambling,wad',
            'api_user' => $apiUser,
            'api_secret' => $apiSecret,
        ];

        $apiUrl = 'https://api.sightengine.com/1.0/check.json?'.http_build_query($params);

        $ch = curl_init($apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_HTTPHEADER => [
                'User-Agent: Mozilla/5.0 (compatible; 24hNews/1.0)',
                'Accept: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'status' => 'error',
                'message' => 'Lỗi kết nối API: '.$error,
                'violation_level' => 'none',
            ];
        }

        curl_close($ch);

        $output = json_decode($response, true);
        if ($output === null) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích JSON từ API.',
                'violation_level' => 'none',
            ];
        }

        if ($output['status'] != 'success') {
            return [
                'status' => 'error',
                'message' => 'API trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'),
                'violation_level' => 'none',
            ];
        }

        $violations = [];
        $reasons = [];
        $violationLevel = 'none';

        $nudityFlags = [
            'sexual_activity',
            'sexual_display',
            'erotica',
            'very_suggestive',
            'suggestive',
            'partial_nudity',
            'female_underwear',
            'male_underwear',
        ];

        $nudityDetails = [];
        foreach ($nudityFlags as $flag) {
            if (isset($output['nudity'][$flag])) {
                $nudityDetails[$flag] = $output['nudity'][$flag];
                if ($output['nudity'][$flag] > 0.2) {
                    $violations[] = 'nudity';
                    $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity) - '.$flag.': '.$output['nudity'][$flag];
                    $violationLevel = 'high';
                    break;
                }
            }
        }

        if (isset($output['nudity']['raw']) && $output['nudity']['raw'] > 0.2) {
            if (! in_array('nudity', $violations)) {
                $violations[] = 'nudity';
                $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity raw): '.$output['nudity']['raw'];
                $violationLevel = 'high';
            }
        }

        if (isset($output['violence']['prob']) && $output['violence']['prob'] > 0.2) {
            $violations[] = 'violence';
            $reasons['violence'] = 'Hình ảnh có nội dung bạo lực: '.$output['violence']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['text']) && (! empty($output['text']['profanity']) || ! empty($output['text']['extremism']))) {
            $violations[] = 'text_violation';
            $reasons['text_violation'] = 'Hình ảnh có văn bản vi phạm';
            $violationLevel = 'high';
        }

        if (isset($output['gore']['prob']) && $output['gore']['prob'] > 0.2) {
            $violations[] = 'gore';
            $reasons['gore'] = 'Hình ảnh có nội dung máu me, bạo lực: '.$output['gore']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['self_harm']['prob']) && $output['self_harm']['prob'] > 0.2) {
            $violations[] = 'self_harm';
            $reasons['self_harm'] = 'Hình ảnh có nội dung tự hại: '.$output['self_harm']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['gambling']['prob']) && $output['gambling']['prob'] > 0.2) {
            $violations[] = 'gambling';
            $reasons['gambling'] = 'Hình ảnh có nội dung cờ bạc: '.$output['gambling']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['wad']) && is_array($output['wad'])) {
            if (isset($output['wad']['weapon']) && $output['wad']['weapon'] > 0.2) {
                $violations[] = 'weapon';
                $reasons['weapon'] = 'Hình ảnh có nội dung vũ khí: '.$output['wad']['weapon'];
                $violationLevel = 'high';
            }

            if (isset($output['wad']['alcohol']) && $output['wad']['alcohol'] > 0.4) {
                $violations[] = 'alcohol';
                $reasons['alcohol'] = 'Hình ảnh có nội dung rượu bia: '.$output['wad']['alcohol'];
                $violationLevel = 'medium';
            }

            if (isset($output['wad']['drugs']) && $output['wad']['drugs'] > 0.2) {
                $violations[] = 'drugs';
                $reasons['drugs'] = 'Hình ảnh có nội dung ma túy: '.$output['wad']['drugs'];
                $violationLevel = 'high';
            }
        }

        Log::debug('Kết quả phân tích kiểm duyệt nhanh - Vi phạm: '.json_encode($violations).', Mức độ: '.$violationLevel);

        $result = [
            'status' => 'success',
            'violation_level' => $violationLevel,
            'violations' => $violations,
            'reason' => $reasons,
            'original_url' => $imageUrl,
            'raw_result' => $output,
            'moderation_method' => 'fast',
        ];

        Cache::put($cacheKey, $result,
            60 * 24 * 3);

        return $result;
    }

    public function enhancedUrlModeration($imageUrl)
    {
        if (empty($imageUrl) || ! filter_var($imageUrl,
            FILTER_VALIDATE_URL)) {
            return [
                'status' => 'error',
                'message' => 'URL không hợp lệ',
                'violation_level' => 'none',
            ];
        }

        $cacheKey = 'enhanced_moderation_'.md5($imageUrl);
        $cachedResult = Cache::get($cacheKey);

        if ($cachedResult) {
            Log::debug('Lấy kết quả kiểm duyệt tăng cường từ cache cho URL: '.$imageUrl);

            return $cachedResult;
        }

        Log::debug('Tăng cường kiểm duyệt URL ảnh: '.$imageUrl);

        try {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36\r\n".
                        "Accept: image/webp,image/apng,image/*,*/*;q=0.8\r\n".
                        "Accept-Language: en-US,en;q=0.9\r\n".
                        "Connection: keep-alive\r\n".
                        "Cache-Control: no-cache\r\n".
                        'Referer: '.parse_url($imageUrl,
                            PHP_URL_SCHEME).'://'.parse_url($imageUrl,
                                PHP_URL_HOST)."/\r\n",
                    'timeout' => 5,
                    'follow_location' => 1,
                    'max_redirects' => 3,
                ],
            ]);

            $startDownload = microtime(true);
            $imageContent = @file_get_contents($imageUrl, false, $context);
            $endDownload = microtime(true);
            $downloadTime = ($endDownload - $startDownload) * 1000;

            if ($imageContent === false) {
                return [
                    'status' => 'error',
                    'message' => 'Không thể tải ảnh từ URL cung cấp',
                    'violation_level' => 'none',
                    'moderation_method' => 'enhanced_failed',
                ];
            }

            if (strlen($imageContent) < 100) {
                return [
                    'status' => 'error',
                    'message' => 'File ảnh không hợp lệ hoặc quá nhỏ',
                    'violation_level' => 'none',
                    'moderation_method' => 'enhanced_failed',
                ];
            }

            $mimeType = $this->detectActualMimeType($imageContent);

            $isImage = $mimeType && strpos($mimeType, 'image/') === 0;
            if (! $isImage) {
                return [
                    'status' => 'error',
                    'message' => 'URL không phải là hình ảnh hợp lệ',
                    'violation_level' => 'none',
                    'moderation_method' => 'enhanced_failed',
                ];
            }

            $tempFile = tempnam(sys_get_temp_dir(), 'mod_');
            file_put_contents($tempFile, $imageContent);

            $result = $this->directFileModeration($tempFile,
                basename($imageUrl), $mimeType);

            @unlink($tempFile);

            if ($result['status'] === 'success') {
                $result['original_url'] = $imageUrl;
                $result['moderation_method'] = 'enhanced';
                Cache::put($cacheKey, $result,
                    60 * 24 * 3);
            }

            return $result;
        } catch (Exception $e) {
            Log::error('Lỗi tăng cường kiểm duyệt URL: '.$e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Lỗi xử lý kiểm duyệt ảnh: '.$e->getMessage(),
                'violation_level' => 'none',
                'moderation_method' => 'enhanced_error',
            ];
        }
    }

    public function detectActualMimeType($fileContent)
    {
        try {
            $tempFile = tempnam(sys_get_temp_dir(), 'mime_');
            file_put_contents($tempFile, $fileContent);

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($tempFile);
            @unlink($tempFile);

            return $mime;
        } catch (Exception $e) {
            Log::error('Lỗi xác định MIME type: '.$e->getMessage());

            return null;
        }
    }

    public function directFileModeration(
        $filePath,
        $fileName = 'image.jpg',
        $mimeType = 'image/jpeg'
    ) {
        $apiUser = env('SIGHTENGINE_API_USER');
        $apiSecret = env('SIGHTENGINE_API_SECRET');

        if (empty($apiUser) || empty($apiSecret)) {
            return [
                'status' => 'error',
                'message' => 'Cấu hình API kiểm duyệt thiếu thông tin',
                'violation_level' => 'none',
            ];
        }

        if (! file_exists($filePath) || ! is_readable($filePath)) {
            return [
                'status' => 'error',
                'message' => 'File không thể truy cập.',
                'violation_level' => 'none',
            ];
        }

        $params = [
            'models' => 'nudity-2.1,offensive-2.0,text-content,gore-2.0,violence,self-harm,gambling,wad',
            'api_user' => $apiUser,
            'api_secret' => $apiSecret,
        ];

        $ch = curl_init('https://api.sightengine.com/1.0/check.json');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TCP_NODELAY => true,
            CURLOPT_HTTPHEADER => [
                'User-Agent: Mozilla/5.0 (compatible; 24hNews/1.0)',
                'Accept: application/json',
            ],
        ]);

        $cfile = new CURLFile(
            $filePath,
            $mimeType,
            $fileName
        );

        $postData = $params;
        $postData['media'] = $cfile;

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $startApiCall = microtime(true);

        $response = curl_exec($ch);

        $endApiCall = microtime(true);
        $apiCallTime = ($endApiCall - $startApiCall) * 1000;

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'status' => 'error',
                'message' => 'Lỗi kết nối API: '.$error,
                'violation_level' => 'none',
            ];
        }
        curl_close($ch);

        $output = json_decode($response, true);
        if ($output === null) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích JSON từ API.',
                'violation_level' => 'none',
            ];
        }

        if ($output['status'] != 'success') {
            return [
                'status' => 'error',
                'message' => 'API trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'),
                'violation_level' => 'none',
            ];
        }
        $violations = [];
        $reasons = [];
        $violationLevel = 'none';

        $nudityFlags = [
            'sexual_activity',
            'sexual_display',
            'erotica',
            'very_suggestive',
            'suggestive',
            'partial_nudity',
            'female_underwear',
            'male_underwear',
        ];

        $nudityDetails = [];
        foreach ($nudityFlags as $flag) {
            if (isset($output['nudity'][$flag])) {
                $nudityDetails[$flag] = $output['nudity'][$flag];
                if ($output['nudity'][$flag] > 0.2) {
                    $violations[] = 'nudity';
                    $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity) - '.$flag.': '.$output['nudity'][$flag];
                    $violationLevel = 'high';
                    break;
                }
            }
        }

        if (isset($output['nudity']['raw']) && $output['nudity']['raw'] > 0.2) {
            if (! in_array('nudity', $violations)) {
                $violations[] = 'nudity';
                $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity raw): '.$output['nudity']['raw'];
                $violationLevel = 'high';
            }
        }

        if (isset($output['violence']['prob']) && $output['violence']['prob'] > 0.2) {
            $violations[] = 'violence';
            $reasons['violence'] = 'Hình ảnh có nội dung bạo lực: '.$output['violence']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['text']) && (! empty($output['text']['profanity']) || ! empty($output['text']['extremism']))) {
            $violations[] = 'text_violation';
            $reasons['text_violation'] = 'Hình ảnh có văn bản vi phạm';
            $violationLevel = 'high';
        }

        if (isset($output['gore']['prob']) && $output['gore']['prob'] > 0.2) {
            $violations[] = 'gore';
            $reasons['gore'] = 'Hình ảnh có nội dung máu me, bạo lực: '.$output['gore']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['self_harm']['prob']) && $output['self_harm']['prob'] > 0.2) {
            $violations[] = 'self_harm';
            $reasons['self_harm'] = 'Hình ảnh có nội dung tự hại: '.$output['self_harm']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['gambling']['prob']) && $output['gambling']['prob'] > 0.2) {
            $violations[] = 'gambling';
            $reasons['gambling'] = 'Hình ảnh có nội dung cờ bạc: '.$output['gambling']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['wad']) && is_array($output['wad'])) {
            if (isset($output['wad']['weapon']) && $output['wad']['weapon'] > 0.2) {
                $violations[] = 'weapon';
                $reasons['weapon'] = 'Hình ảnh có nội dung vũ khí: '.$output['wad']['weapon'];
                $violationLevel = 'high';
            }

            if (isset($output['wad']['alcohol']) && $output['wad']['alcohol'] > 0.4) {
                $violations[] = 'alcohol';
                $reasons['alcohol'] = 'Hình ảnh có nội dung rượu bia: '.$output['wad']['alcohol'];
                $violationLevel = 'medium';
            }

            if (isset($output['wad']['drugs']) && $output['wad']['drugs'] > 0.2) {
                $violations[] = 'drugs';
                $reasons['drugs'] = 'Hình ảnh có nội dung ma túy: '.$output['wad']['drugs'];
                $violationLevel = 'high';
            }
        }

        return [
            'status' => 'success',
            'violation_level' => $violationLevel,
            'violations' => $violations,
            'reason' => $reasons,
            'raw_result' => $output,
        ];
    }

    public function handleImageUploadModeration(
        $file,
        $saveTemp = false,
        $tempPath = 'temp_uploads'
    ) {
        if ($saveTemp) {
            $path = $file->store($tempPath, 'public');
            $result = $this->moderateImage(asset('storage/'.$path));

            Storage::disk('public')
                ->delete($path);

            return $result;
        }

        return $this->moderateImageFile($file);
    }

    public function moderateImage($url)
    {
        $apiUser = env('SIGHTENGINE_API_USER');
        $apiSecret = env('SIGHTENGINE_API_SECRET');

        if (empty($apiUser) || empty($apiSecret)) {
            return [
                'status' => 'error',
                'message' => 'Cấu hình API kiểm duyệt thiếu thông tin',
                'violation_level' => 'none',
            ];
        }

        $headers = @get_headers($url);
        if (! $headers || strpos($headers[0], '200') === false) {
            return [
                'status' => 'error',
                'message' => 'URL không hợp lệ hoặc không thể truy cập.',
                'violation_level' => 'none',
            ];
        }

        $params = [
            'url' => $url,
            'models' => 'nudity-2.1,offensive-2.0,text-content,gore-2.0,violence,self-harm,gambling',
            'api_user' => $apiUser,
            'api_secret' => $apiSecret,
        ];

        $ch = curl_init('https://api.sightengine.com/1.0/check.json?'.http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'status' => 'error',
                'message' => 'Lỗi kết nối API: '.$error,
                'violation_level' => 'none',
            ];
        }
        curl_close($ch);

        $output = json_decode($response, true);
        if ($output === null) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích JSON từ API.',
                'violation_level' => 'none',
            ];
        }

        if ($output['status'] != 'success') {
            Log::error('API Sightengine URL trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'));

            return [
                'status' => 'error',
                'message' => 'API trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'),
                'violation_level' => 'none',
            ];
        }

        $violations = [];
        $reasons = [];
        $violationLevel = 'none';

        $nudityFlags = [
            'sexual_activity',
            'sexual_display',
            'erotica',
            'very_suggestive',
        ];
        foreach ($nudityFlags as $flag) {
            if (isset($output['nudity'][$flag]) && $output['nudity'][$flag] > 0.3) {
                $violations[] = 'nudity';
                $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity)';
                $violationLevel = 'high';
                break;
            }
        }

        if (isset($output['violence']['prob']) && $output['violence']['prob'] > 0.4) {
            $violations[] = 'violence';
            $reasons['violence'] = 'Hình ảnh có nội dung bạo lực';
            $violationLevel = 'high';
        }

        if (isset($output['text']) && (! empty($output['text']['profanity']) || ! empty($output['text']['extremism']))) {
            $violations[] = 'text_violation';
            $reasons['text_violation'] = 'Hình ảnh có văn bản vi phạm';
            $violationLevel = 'high';
        }

        if (isset($output['gore']['prob']) && $output['gore']['prob'] > 0.4) {
            $violations[] = 'gore';
            $reasons['gore'] = 'Hình ảnh có nội dung máu me, bạo lực';
            $violationLevel = 'high';
        }

        if (isset($output['self_harm']['prob']) && $output['self_harm']['prob'] > 0.4) {
            $violations[] = 'self_harm';
            $reasons['self_harm'] = 'Hình ảnh có nội dung tự hại';
            $violationLevel = 'high';
        }

        if (isset($output['gambling']['prob']) && $output['gambling']['prob'] > 0.4) {
            $violations[] = 'gambling';
            $reasons['gambling'] = 'Hình ảnh có nội dung cờ bạc';
            $violationLevel = 'high';
        }

        Log::debug('Kết quả phân tích kiểm duyệt URL - Các vi phạm: '.json_encode($violations));

        return [
            'status' => 'success',
            'violation_level' => $violationLevel,
            'violations' => $violations,
            'reason' => $reasons,
            'original_url' => $url,
            'raw_result' => $output,
        ];
    }

    public function moderateImageFile($file)
    {
        $apiUser = env('SIGHTENGINE_API_USER');
        $apiSecret = env('SIGHTENGINE_API_SECRET');

        if (empty($apiUser) || empty($apiSecret)) {
            return [
                'status' => 'error',
                'message' => 'Cấu hình API kiểm duyệt thiếu thông tin',
                'violation_level' => 'none',
            ];
        }

        if (! $file || ! $file->isValid()) {
            return [
                'status' => 'error',
                'message' => 'File không hợp lệ.',
                'violation_level' => 'none',
            ];
        }

        $params = [
            'models' => 'nudity-2.1,offensive-2.0,text-content,gore-2.0,violence,self-harm,gambling',
            'api_user' => $apiUser,
            'api_secret' => $apiSecret,
        ];

        $ch = curl_init('https://api.sightengine.com/1.0/check.json');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $cfile = new CURLFile(
            $file->getPathname(),
            $file->getMimeType(),
            $file->getClientOriginalName()
        );

        $postData = $params;
        $postData['media'] = $cfile;

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $startApiCall = microtime(true);

        $response = curl_exec($ch);

        $endApiCall = microtime(true);
        $apiCallTime = ($endApiCall - $startApiCall) * 1000;

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'status' => 'error',
                'message' => 'Lỗi kết nối API: '.$error,
                'violation_level' => 'none',
            ];
        }
        curl_close($ch);

        $output = json_decode($response, true);
        if ($output === null) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích JSON từ API.',
                'violation_level' => 'none',
            ];
        }

        if ($output['status'] != 'success') {
            Log::error('API Sightengine File trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'));

            return [
                'status' => 'error',
                'message' => 'API trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'),
                'violation_level' => 'none',
            ];
        }

        $violations = [];
        $reasons = [];
        $violationLevel = 'none';

        $nudityFlags = [
            'sexual_activity',
            'sexual_display',
            'erotica',
            'very_suggestive',
            'suggestive',
            'partial_nudity',
            'female_underwear',
            'male_underwear',
        ];

        $nudityDetails = [];
        foreach ($nudityFlags as $flag) {
            if (isset($output['nudity'][$flag])) {
                $nudityDetails[$flag] = $output['nudity'][$flag];
                if ($output['nudity'][$flag] > 0.2) {
                    $violations[] = 'nudity';
                    $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity) - '.$flag.': '.$output['nudity'][$flag];
                    $violationLevel = 'high';
                    break;
                }
            }
        }

        if (isset($output['nudity']['raw']) && $output['nudity']['raw'] > 0.2) {
            if (! in_array('nudity', $violations)) {
                $violations[] = 'nudity';
                $reasons['nudity'] = 'Hình ảnh có yếu tố nhạy cảm (nudity raw): '.$output['nudity']['raw'];
                $violationLevel = 'high';
            }
        }

        if (isset($output['violence']['prob']) && $output['violence']['prob'] > 0.2) {
            $violations[] = 'violence';
            $reasons['violence'] = 'Hình ảnh có nội dung bạo lực: '.$output['violence']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['text']) && (! empty($output['text']['profanity']) || ! empty($output['text']['extremism']))) {
            $violations[] = 'text_violation';
            $reasons['text_violation'] = 'Hình ảnh có văn bản vi phạm';
            $violationLevel = 'high';
        }

        if (isset($output['gore']['prob']) && $output['gore']['prob'] > 0.2) {
            $violations[] = 'gore';
            $reasons['gore'] = 'Hình ảnh có nội dung máu me, bạo lực: '.$output['gore']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['self_harm']['prob']) && $output['self_harm']['prob'] > 0.2) {
            $violations[] = 'self_harm';
            $reasons['self_harm'] = 'Hình ảnh có nội dung tự hại: '.$output['self_harm']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['gambling']['prob']) && $output['gambling']['prob'] > 0.2) {
            $violations[] = 'gambling';
            $reasons['gambling'] = 'Hình ảnh có nội dung cờ bạc: '.$output['gambling']['prob'];
            $violationLevel = 'high';
        }

        if (isset($output['wad']) && is_array($output['wad'])) {
            if (isset($output['wad']['weapon']) && $output['wad']['weapon'] > 0.2) {
                $violations[] = 'weapon';
                $reasons['weapon'] = 'Hình ảnh có nội dung vũ khí: '.$output['wad']['weapon'];
                $violationLevel = 'high';
            }

            if (isset($output['wad']['alcohol']) && $output['wad']['alcohol'] > 0.4) {
                $violations[] = 'alcohol';
                $reasons['alcohol'] = 'Hình ảnh có nội dung rượu bia: '.$output['wad']['alcohol'];
                $violationLevel = 'medium';
            }

            if (isset($output['wad']['drugs']) && $output['wad']['drugs'] > 0.2) {
                $violations[] = 'drugs';
                $reasons['drugs'] = 'Hình ảnh có nội dung ma túy: '.$output['wad']['drugs'];
                $violationLevel = 'high';
            }
        }

        return [
            'status' => 'success',
            'violation_level' => $violationLevel,
            'violations' => $violations,
            'reason' => $reasons,
            'raw_result' => $output,
        ];
    }

    public function testConnection()
    {
        $apiUser = env('SIGHTENGINE_API_USER');
        $apiSecret = env('SIGHTENGINE_API_SECRET');

        if (empty($apiUser) || empty($apiSecret)) {
            return [
                'status' => 'error',
                'message' => 'Cấu hình API kiểm duyệt thiếu thông tin',
                'code' => 0,
            ];
        }

        $params = [
            'models' => 'nudity-2.1',
            'api_user' => $apiUser,
            'api_secret' => $apiSecret,
        ];

        $ch = curl_init('https://api.sightengine.com/1.0/check-account.json?'.http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            return [
                'status' => 'error',
                'message' => 'Lỗi kết nối API: '.$error,
                'code' => $httpCode,
            ];
        }

        curl_close($ch);

        $output = json_decode($response, true);
        if ($output === null) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích JSON từ API',
                'code' => $httpCode,
            ];
        }

        if ($output['status'] != 'success') {
            return [
                'status' => 'error',
                'message' => 'API trả về lỗi: '.($output['error']['message'] ?? 'Không xác định'),
                'code' => $httpCode,
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Kết nối thành công đến API kiểm duyệt',
            'account' => $output['account'] ?? [],
            'code' => $httpCode,
        ];
    }

    public function saveDebugImage($url, $source = 'url', $reason = 'debug')
    {
        try {
            $debugDir = storage_path('app/debug');
            if (! file_exists($debugDir)) {
                mkdir($debugDir, 0755, true);
            }

            $filename = 'debug_'.$source.'_'.date('Ymd_His').'_'.uniqid().'.jpg';
            $fullpath = $debugDir.'/'.$filename;

            if ($source === 'url') {
                $headers = @get_headers($url);
                if ($headers && strpos($headers[0], '200') !== false) {
                    file_put_contents($fullpath, file_get_contents($url));
                } else {
                    return false;
                }
            } elseif ($source === 'file' && file_exists($url)) {
                copy($url, $fullpath);
            } else {
                return false;
            }

            return $fullpath;
        } catch (Exception $e) {
            Log::error('Lỗi lưu ảnh debug: '.$e->getMessage());

            return false;
        }
    }
}

<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function showForm()
    {
        return view('moderation_form');
    }

    public function moderate(Request $request)
    {
        $text = $request->input('text');
        $apiKey = env('GOOGLE_API_KEY');

        $result = $this->moderateContent($text, $apiKey);

        return view('moderation_result', ['result' => $result]);
    }

    private function moderateContent($text, $apiKey)
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key='.$apiKey;

        $prompt = "
    Bạn là chuyên gia kiểm duyệt nội dung của VnExpress. Hãy phân tích đoạn văn bản sau:

    **Quy tắc:**
    1. Phát hiện các từ/cụm từ có ý nghĩa tiêu cực rõ ràng:
       - Đe dọa tính mạng ('giết người', 'nguy cơ tử vong')
       - Khủng bố ('đánh bom', 'khủng bố')
       - Kích động bạo lực ('biểu tình', 'phá hủy')
       - Nội dung che giấu thông tin hoặc gây hiểu nhầm nghiêm trọng
    2. Cho phép các từ ngữ trong ngữ cảnh tin tức chính thống:
       - 'thả bom' (ví dụ: máy bay thả bom trong tập trận)
       - 'binh sĩ', 'quân đội' (trong báo cáo quốc phòng)
    3. Không liệt kê từ không xuất hiện nguyên văn trong văn bản

    **Yêu cầu phản hồi:**
    - Định dạng: [Mức độ] | [Từ vi phạm 1]: [Lý do 1]; [Từ vi phạm 2]: [Lý do 2]; ...
    - Ví dụ:
       'Cao | giết người: Đe dọa tính mạng; đánh bom: Khủng bố'
       'Không vi phạm'

    **Văn bản cần kiểm tra:**
    \"$text\"
";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt,
                        ],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0,
                'maxOutputTokens' => 8192,
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['error'])) {
            return [
                'status' => 'error',
                'message' => $responseData['error']['message'],
            ];
        }

        $resultText = $responseData['candidates'][0]['content']['parts'][0]['text'];

        return $this->parseModerationResult($resultText);
    }

    private function parseModerationResult($resultText)
    {
        $resultText = trim(preg_replace('/\s+/', ' ',
            $resultText));

        if (stripos($resultText, 'không vi phạm') !== false) {
            return [
                'status' => 'success',
                'violation_level' => 'none',
                'violations' => [],
                'reason' => null,
            ];
        }

        $parts = explode('|', $resultText, 2);
        if (count($parts) < 2) {
            return [
                'status' => 'error',
                'message' => 'Định dạng phản hồi không hợp lệ',
            ];
        }

        $level = trim(strtolower($parts[0]));
        $violationLevel = match ($level) {
            'thấp' => 'low',
            'trung bình' => 'medium',
            'cao' => 'high',
            default => 'unknown'
        };

        $violationReasonPairs = array_map('trim', explode(';', $parts[1]));
        $violations = [];
        $reasons = [];

        foreach ($violationReasonPairs as $pair) {
            if (strpos($pair, ':') === false) {
                continue;
            }

            [$word, $reason] = array_map('trim', explode(':', $pair, 2));
            if (! empty($word) && ! empty($reason)) {
                $violations[] = $word;
                $reasons[$word] = $reason;
            }
        }

        return [
            'status' => 'success',
            'violation_level' => $violationLevel,
            'violations' => $violations,
            'reason' => $reasons,
        ];
    }
}

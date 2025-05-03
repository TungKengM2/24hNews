<?php

namespace App\Services;

class ModerationService
{
    public function moderateContent($text, $apiKey)
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent?key='.$apiKey;

        $prompt = "
    Bạn là hệ thống kiểm duyệt nội dung của VnExpress. Hãy phân tích đoạn văn bản sau dựa trên các tiêu chí sau:

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

    **C. Yêu cầu phản hồi**:
    - Định dạng: [Mức độ] | [Từ vi phạm 1]: [Lý do 1]; [Từ vi phạm 2]: [Lý do 2]
    - Ví dụ:
       'Cao | lật đổ chính quyền: Kích động chống đối; vaccine chứa chip: Thông tin sai sự thật'
       'Không vi phạm'

    **D. Văn bản cần kiểm tra**:
    \"$text\"
";
        //        echo $prompt;

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
        //        var_dump($responseData);
        //        exit();
        if (isset($responseData['error'])) {
            return [
                'status' => 'error',
                'message' => $responseData['error']['message'],
            ];
        }

        $resultText = $responseData['candidates'][0]['content']['parts'][0]['text'];

        return $this->parseModerationResult($resultText);
    }

    public function parseModerationResult($resultText)
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

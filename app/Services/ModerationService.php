<?php

namespace App\Services;

class ModerationService
{
    public function moderateContent($text, $apiKey)
    {
        $normalizedText = $this->normalizeText($text);

        $sentences = preg_split('/(?<=[.!?])\s+/', $normalizedText, -1,
            PREG_SPLIT_NO_EMPTY);

        $firstSentences = array_slice($sentences, 0,
            min(3, count($sentences)));
        foreach ($firstSentences as $sentence) {
            if (mb_strlen($sentence) > 10) {
                $sentenceResult = $this->callGeminiAPI($sentence, $apiKey);

                if (! isset($sentenceResult['violation_level'])) {
                    $sentenceResult['violation_level'] = 'none';
                }

                if ($sentenceResult['violation_level'] === 'high' || $sentenceResult['violation_level'] === 'medium') {
                    return [
                        'status' => 'success',
                        'violation_level' => 'high',
                        'violations' => $sentenceResult['violations'] ?? [],
                        'reason' => $sentenceResult['reason'] ?? [],
                        'original_text' => $text,
                        'normalized_text' => $normalizedText,
                        'detected_in' => 'first_sentence_analysis',
                    ];
                }
            }
        }

        $fullTextResult = $this->callGeminiAPI($normalizedText, $apiKey);

        if (! isset($fullTextResult['violation_level'])) {
            $fullTextResult['violation_level'] = 'none';
        }

        if ($fullTextResult['violation_level'] === 'high') {
            return $fullTextResult;
        }

        if (mb_strlen($normalizedText) > 500) {
            if (preg_match_all('/"([^"]+)"/', $normalizedText, $matches)) {
                foreach ($matches[1] as $quotedText) {
                    $quoteResult = $this->callGeminiAPI($quotedText,
                        $apiKey);

                    if (! isset($quoteResult['violation_level'])) {
                        $quoteResult['violation_level'] = 'none';
                    }

                    if ($quoteResult['violation_level'] === 'high') {
                        return $quoteResult;
                    }
                }
            }

            $highestViolationLevel = $fullTextResult['violation_level'];
            $allViolations = $fullTextResult['violations'] ?? [];
            $allReasons = $fullTextResult['reason'] ?? [];

            $sentenceGroups = [];
            $currentGroup = [];
            $currentLength = 0;

            foreach ($sentences as $sentence) {
                $sentenceLength = mb_strlen($sentence);

                if ($currentLength + $sentenceLength > 500) {
                    if (! empty($currentGroup)) {
                        $sentenceGroups[] = $currentGroup;
                    }

                    $currentGroup = [$sentence];
                    $currentLength = $sentenceLength;
                } else {
                    $currentGroup[] = $sentence;
                    $currentLength += $sentenceLength;
                }
            }

            if (! empty($currentGroup)) {
                $sentenceGroups[] = $currentGroup;
            }

            foreach ($sentenceGroups as $group) {
                $sentenceText = implode(' ', $group);

                $result = $this->callGeminiAPI($sentenceText, $apiKey);

                if ($result['status'] === 'error') {
                    continue;
                }

                if (! isset($result['violation_level'])) {
                    $result['violation_level'] = 'none';
                }

                if (
                    $this->getViolationLevelPriority($result['violation_level']) >
                    $this->getViolationLevelPriority($highestViolationLevel)
                ) {
                    $highestViolationLevel = $result['violation_level'];
                }

                if (isset($result['violations']) && ! empty($result['violations'])) {
                    $allViolations = array_merge($allViolations,
                        $result['violations']);
                    $allReasons = array_merge($allReasons,
                        $result['reason'] ?? []);
                }

                if ($highestViolationLevel === 'high') {
                    break;
                }
            }

            foreach ($firstSentences as $sentence) {
                if (mb_strlen($sentence) > 20) {
                    $sentenceResult = $this->callGeminiAPI($sentence,
                        $apiKey);

                    if (! isset($sentenceResult['violation_level'])) {
                        $sentenceResult['violation_level'] = 'none';
                    }

                    if (
                        $this->getViolationLevelPriority($sentenceResult['violation_level']) >
                        $this->getViolationLevelPriority($highestViolationLevel)
                    ) {
                        $highestViolationLevel = $sentenceResult['violation_level'];

                        if (isset($sentenceResult['violations']) && ! empty($sentenceResult['violations'])) {
                            $allViolations = array_merge($allViolations,
                                $sentenceResult['violations']);
                            $allReasons = array_merge($allReasons,
                                $sentenceResult['reason'] ?? []);
                        }
                    }

                    if ($highestViolationLevel === 'high') {
                        break;
                    }
                }
            }

            return [
                'status' => 'success',
                'violation_level' => $highestViolationLevel,
                'violations' => array_unique($allViolations),
                'reason' => $allReasons,
                'original_text' => $text,
                'normalized_text' => $normalizedText,
            ];
        }

        return $fullTextResult;
    }

    private function normalizeText($text)
    {
        $text = mb_strtolower($text, 'UTF-8');

        $replacements = [
            '0' => 'o',
            '1' => 'i',
            '3' => 'e',
            '4' => 'a',
            '5' => 's',
            '6' => 'g',
            '7' => 't',
            '8' => 'b',
            '9' => 'g',

            '@' => 'a',
            '$' => 's',
            '!' => 'i',
            '*' => 'a',
            '(' => 'c',
            ')' => 'o',
            '+' => 't',

            '.' => ' ',
            ',' => ' ',
            '-' => ' ',
            '_' => ' ',
            '/' => ' ',
            '\\' => ' ',
            '|' => ' ',

            '. ' => '. ',
            '! ' => '! ',
            '? ' => '? ',
        ];

        $text = str_replace(array_keys($replacements),
            array_values($replacements), $text);

        $text = preg_replace('/\s+/', ' ', $text);

        $text = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '',
            $text); // Emoji
        $text = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '',
            $text); // Biểu tượng và ký hiệu
        $text = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '',
            $text); // Biểu tượng giao thông và bản đồ
        $text = preg_replace('/[\x{2600}-\x{26FF}]/u', '',
            $text); // Ký hiệu khác

        return trim($text);
    }

    private function callGeminiAPI($text, $apiKey)
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
                'violation_level' => 'none',
            ];
        }

        if (! isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return [
                'status' => 'error',
                'message' => 'Không thể phân tích phản hồi từ API',
                'violation_level' => 'none',
            ];
        }

        $resultText = $responseData['candidates'][0]['content']['parts'][0]['text'];
        $result = $this->parseModerationResult($resultText);

        if (! isset($result['violation_level'])) {
            $result['violation_level'] = 'none';
        }

        return $result;
    }

    public function parseModerationResult($resultText)
    {
        $resultText = trim(preg_replace('/\s+/', ' ', $resultText));

        if (stripos($resultText,
            'không vi phạm') !== false || empty($resultText)) {
            return [
                'status' => 'success',
                'violation_level' => 'none',
                'violations' => [],
                'reason' => [],
            ];
        }

        $parts = explode('|', $resultText, 2);
        if (count($parts) < 2) {
            return [
                'status' => 'success',
                'violation_level' => 'none',
                'violations' => [],
                'reason' => [],
            ];
        }

        $level = trim(strtoupper($parts[0]));
        if (stripos($level, 'CAO') !== false) {
            $violationLevel = 'high';
        } elseif (stripos($level, 'TRUNG BÌNH') !== false) {
            $violationLevel = 'medium';
        } elseif (stripos($level, 'THẤP') !== false) {
            $violationLevel = 'low';
        } else {
            $violationLevel = 'none';
        }

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

    private function getViolationLevelPriority($level)
    {
        switch ($level) {
            case 'high':
                return 3;
            case 'medium':
                return 2;
            case 'low':
                return 1;
            case 'none':
            default:
                return 0;
        }
    }
}

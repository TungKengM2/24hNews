<?php

// Hàm kiểm duyệt nội dung sử dụng Google Generative AI
function moderateContent($text, $apiKey)
{
    // Endpoint của API
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent?key='.$apiKey;

    // Prompt mẫu
    $prompt = "
        Hãy kiểm tra đoạn văn bản sau và xác định mức độ vi phạm dựa trên các tiêu chí sau:
        1. Từ ngữ xúc phạm, lăng mạ, phân biệt chủng tộc, tôn giáo.
        2. Nội dung bạo lực, đe dọa, hoặc kích động thù hận.
        3. Tin tức giả (fake news), thông tin sai lệch.
        4. Các từ khóa nhạy cảm liên quan đến chính trị, tôn giáo, hoặc các vấn đề xã hội nhạy cảm.
        5. Từ ngữ tục tĩu, thiếu văn hóa.

        Phản hồi theo định dạng sau:
        - Nếu không vi phạm: \"Không vi phạm\".
        - Nếu có vi phạm: Trả về mức độ vi phạm (\"Thấp\", \"Trung bình\", \"Cao\") và liệt kê các từ vi phạm cụ thể trong dấu ngoặc kép. Ví dụ: \"Cao. \\\"từ vi phạm 1\\\", \\\"từ vi phạm 2\\\"\".

        Đoạn văn bản cần kiểm duyệt:
        \"$text\"
    ";

    // Dữ liệu gửi đến API
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
            'temperature' => 1,
            'topP' => 0.95,
            'topK' => 40,
            'maxOutputTokens' => 8192,
        ],
    ];

    // Khởi tạo cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    // Thực hiện request
    $response = curl_exec($ch);
    curl_close($ch);

    // Giải mã JSON response
    $responseData = json_decode($response, true);

    // Kiểm tra nếu có lỗi
    if (isset($responseData['error'])) {
        return [
            'status' => 'error',
            'message' => $responseData['error']['message'],
        ];
    }

    // Trích xuất kết quả từ phản hồi
    $resultText = $responseData['candidates'][0]['content']['parts'][0]['text'];

    // Phân tích kết quả
    return parseModerationResult($resultText);
}

// Hàm phân tích kết quả từ mô hình
function parseModerationResult($resultText)
{
    // Loại bỏ khoảng trắng thừa
    $resultText = trim($resultText);

    // Kiểm tra nếu không vi phạm
    if (strpos(strtolower($resultText), 'không vi phạm') !== false) {
        return [
            'status' => 'success',
            'violation_level' => 'none',
            'violations' => [],
        ];
    }

    // Tìm mức độ vi phạm
    $violationLevel = 'unknown';
    if (strpos(strtolower($resultText), 'thấp') !== false) {
        $violationLevel = 'low';
    } elseif (strpos(strtolower($resultText), 'trung bình') !== false) {
        $violationLevel = 'medium';
    } elseif (strpos(strtolower($resultText), 'cao') !== false) {
        $violationLevel = 'high';
    }

    // Tìm các từ vi phạm
    $violations = [];
    if (preg_match_all('/"(.*?)"/', $resultText, $matches)) {
        $violations = $matches[1];
    }

    return [
        'status' => 'success',
        'violation_level' => $violationLevel,
        'violations' => $violations,
    ];
}

// Ví dụ sử dụng
$apiKey = 'AIzaSyBT9gMM9h93EGpJH6wFClvbv3SUlswCB48'; // Thay bằng API key thực tế
$text = ' binh quốc gia và số vũ khí này đã được chôn xuống đất vào cuối chiến tranh.';
$result = moderateContent($text, $apiKey);

// In kết quả
if ($result['status'] === 'success') {
    if ($result['violation_level'] === 'none') {
        echo 'Không vi phạm.';
    } else {
        echo 'Mức độ vi phạm: '.$result['violation_level']."\n";
        echo 'Các từ vi phạm: '.implode(', ', $result['violations']);
    }
} else {
    echo 'Lỗi: '.$result['message'];
}

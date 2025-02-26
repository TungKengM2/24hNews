<?php

    $api_key = 'AIzaSyBT9gMM9h93EGpJH6wFClvbv3SUlswCB48';
    $text = <<<'TEXT'

tao muốn giết người.






TEXT;

    $text = trim(preg_replace('/\s+/', ' ', $text));
    if (empty($text)) {
        exit('⚠️ Nội dung trống');
    }

    $prompt = <<<PROMPT
Bạn là hệ thống kiểm duyệt nội dung cho báo điện tử tương tự VnExpress.
Phân tích nội dung sau và trả về JSON theo định dạng:

{
  "status": "Hợp lệ/Vi phạm",
  "violations": ["danh sách từ/cụm từ VI PHẠM TRỰC TIẾP trong nội dung"],
  "categories": ["bạo lực", "kích động", "chính trị nhạy cảm", "nội dung người lớn", "quảng cáo phản cảm"],
  "severity": "CAO/TRUNG_BÌNH/THẤP",
  "sentences": ["câu vi phạm"],
  "action": "auto_reject/auto_approve/manual_review"
}

Yêu cầu:
- Tuân thủ chính sách kiểm duyệt của báo chí Việt Nam <button class="citation-flag" data-index="2"><button class="citation-flag" data-index="9">
- Ưu tiên phát hiện:
  + Bạo lực trực tiếp (ví dụ: "giết người") <button class="citation-flag" data-index="9">
  + Kích động thù hận (ví dụ: "tiêu diệt nhóm X") <button class="citation-flag" data-index="2">
  + Nội dung chính trị nhạy cảm <button class="citation-flag" data-index="5">
  + Quảng cáo phản cảm <button class="citation-flag" data-index="1">
- Mức độ CAO: Từ chối tự động (ví dụ: hướng dẫn tự tử) <button class="citation-flag" data-index="10">
- Mức độ TRUNG_BÌNH: Chuyển kiểm duyệt thủ công (ví dụ: tranh cãi chính trị) <button class="citation-flag" data-index="4">
- Mức độ THẤP: Duyệt tự động (ví dụ: từ ngữ thô lỗ thông thường)
- Trả lời BẰNG TIẾNG VIỆT và CHỈ JSON

Nội dung cần kiểm tra: "$text"
PROMPT;

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
            'maxOutputTokens' => 2048,
            'responseMimeType' => 'application/json',
        ],
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$api_key",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    // Gửi request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Xử lý response
    if ($httpCode !== 200) {
        $error = json_decode($response, true);
        exit('❌ Lỗi API: ' . ($error['error']['message'] ?? 'Không xác định'));
    }

    $result = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        exit('⚠️ Lỗi JSON: ' . json_last_error_msg());
    }

    if (!empty($result['candidates'][0]['content']['parts'][0]['text'])) {
        $responseData = json_decode($result['candidates'][0]['content']['parts'][0]['text'],
            true);

        if ($responseData['status'] === 'Hợp lệ') {
            echo "✅ NỘI DUNG HỢP LỆ\n";
        } else {
            echo "❌ PHÁT HIỆN VI PHẠM:\n";
            echo '🔹 Từ vi phạm: ' . implode(', ',
                    $responseData['violations'] ?? []) . "\n";
            echo '🔹 Danh mục: ' . implode(', ',
                    $responseData['categories'] ?? []) . "\n";
            echo '🔹 Mức độ: ' . ($responseData['severity'] ?? 'Không xác định') . "\n";
            echo "🔹 Câu vi phạm:\n" . implode("\n",
                    $responseData['sentences'] ?? []) . "\n";
        }
    } else {
        echo "🔍 Raw Response:\n";
        print_r($result);
    }

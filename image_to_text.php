<?php

require 'vendor/autoload.php';

function extractTextFromImage(
    $imagePath = '',
    $apiKey = 'AIzaSyDj6T8PdifPa50gpLSI6NwETW2UfiidqtM'
) {
    if (empty($imagePath) && php_sapi_name() == 'cli') {
        global $argv;
        if (isset($argv) && count($argv) > 1) {
            $imagePath = $argv[1];
        } else {
            $imagePath = '/home/buihien9969/Downloads/tuong-ton-ngo-khong-13.jpg';
        }
    }

    if (! $apiKey) {
        throw new Exception('API key không được cung cấp.');
    }

    if (! file_exists($imagePath)) {
        throw new Exception('File không tồn tại: '.$imagePath);
    }

    $mimeType = mime_content_type($imagePath);
    $fileSize = filesize($imagePath);

    $client = new \GuzzleHttp\Client;

    $initResponse = $client->post('https://generativelanguage.googleapis.com/upload/v1beta/files?key='.$apiKey,
        [
            'headers' => [
                'X-Goog-Upload-Protocol' => 'resumable',
                'X-Goog-Upload-Command' => 'start',
                'X-Goog-Upload-Header-Content-Length' => $fileSize,
                'X-Goog-Upload-Header-Content-Type' => $mimeType,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'file' => [
                    'display_name' => basename($imagePath),
                ],
            ],
        ]);

    $uploadUrl = $initResponse->getHeaderLine('X-Goog-Upload-URL');

    if (empty($uploadUrl)) {
        throw new Exception('Không thể lấy URL tải lên');
    }

    $uploadResponse = $client->post($uploadUrl, [
        'headers' => [
            'Content-Length' => $fileSize,
            'X-Goog-Upload-Offset' => 0,
            'X-Goog-Upload-Command' => 'upload, finalize',
        ],
        'body' => fopen($imagePath, 'r'),
    ]);

    $fileData = json_decode($uploadResponse->getBody(), true);

    if (! isset($fileData['file']['uri'])) {
        throw new Exception('Tải lên file thất bại: '.$uploadResponse->getBody());
    }

    $fileUri = $fileData['file']['uri'];

    $generateClient = new \GuzzleHttp\Client;
    $generateResponse = $generateClient->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-pro-exp-02-05:generateContent?key='.$apiKey,
        [
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => 'chuyển ảnh này thành text',
                            ],
                            [
                                'file_data' => [
                                    'mime_type' => $mimeType,
                                    'file_uri' => $fileUri,
                                ],
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 2,
                    'top_p' => 0.95,
                    'top_k' => 64,
                    'max_output_tokens' => 8192,
                    'response_mime_type' => 'text/plain',
                ],
            ],
        ]);

    $result = json_decode($generateResponse->getBody(), true);

    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        return $result['candidates'][0]['content']['parts'][0]['text'];
    }

    return $generateResponse->getBody();
}

$res = extractTextFromImage('/home/buihien9969/Downloads/485008406_4001202440164347_7291724914882415176_n.jpg');
print_r($res);

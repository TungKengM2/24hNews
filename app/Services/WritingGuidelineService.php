<?php

namespace App\Services;

use App\Models\WritingGuideline;
use Illuminate\Support\Str;

class WritingGuidelineService
{
    /**
     * Kiểm tra tất cả các tiêu chí cho bài viết
     */
    public function validateArticle(array $data): array
    {
        $results = [
            'is_valid' => true,
            'errors' => [],
            'warnings' => []
        ];

        // Kiểm tra tiêu chí về nội dung
        $this->validateContent($data, $results);

        // Kiểm tra tiêu chí về SEO
        $this->validateSEO($data, $results);

        // Kiểm tra tiêu chí về hình ảnh
        $this->validateImages($data, $results);

        // Kiểm tra tiêu chí về bản quyền
        $this->validateCopyright($data, $results);

        return $results;
    }

    /**
     * Kiểm tra tiêu chí về nội dung
     */
    private function validateContent(array $data, array &$results): void
    {
        $contentGuidelines = WritingGuideline::getByCategory('content');

        foreach ($contentGuidelines as $guideline) {
            switch ($guideline->name) {
                case 'Độ dài tối thiểu':
                    $wordCount = str_word_count(strip_tags($data['content']));
                    if ($wordCount < $guideline->validation_rules['min_words']) {
                        $results['errors'][] = "Bài viết phải có ít nhất {$guideline->validation_rules['min_words']} từ. Hiện tại: {$wordCount} từ.";
                    }
                    break;

                case 'Cấu trúc bài viết':
                    $content = $data['content'];
                    $hasIntroduction = Str::contains($content, ['<h2>Mở bài</h2>', '<h2>Giới thiệu</h2>']);
                    $hasBody = Str::contains($content, ['<h2>Thân bài</h2>', '<h3>']);
                    $hasConclusion = Str::contains($content, ['<h2>Kết luận</h2>', '<h2>Kết bài</h2>']);

                    if (!$hasIntroduction || !$hasBody || !$hasConclusion) {
                        $results['errors'][] = "Bài viết phải có đầy đủ các phần: Mở bài, Thân bài và Kết luận";
                    }
                    break;

                case 'Hình ảnh tối thiểu':
                    $wordCount = str_word_count(strip_tags($data['content']));
                    $imageCount = substr_count($data['content'], '<img');
                    $requiredImages = ceil($wordCount / $guideline->validation_rules['min_images_per_words']);

                    if ($imageCount < $requiredImages) {
                        $results['warnings'][] = "Nên có ít nhất {$requiredImages} hình ảnh cho bài viết này";
                    }
                    break;
            }
        }
    }

    /**
     * Kiểm tra tiêu chí về SEO
     */
    private function validateSEO(array $data, array &$results): void
    {
        $seoGuidelines = WritingGuideline::getByCategory('seo');

        foreach ($seoGuidelines as $guideline) {
            switch ($guideline->name) {
                case 'Meta Description':
                    if (empty($data['meta_description'])) {
                        $results['errors'][] = "Meta description là bắt buộc";
                    } else {
                        $length = strlen($data['meta_description']);
                        if ($length < $guideline->validation_rules['min_length'] ||
                            $length > $guideline->validation_rules['max_length']) {
                            $results['errors'][] = "Meta description phải có độ dài từ {$guideline->validation_rules['min_length']} đến {$guideline->validation_rules['max_length']} ký tự";
                        }
                    }
                    break;

                case 'Từ khóa chính':
                    if (empty($data['keywords'])) {
                        $results['errors'][] = "Phải có ít nhất 1 từ khóa chính";
                    } else {
                        $keywordCount = count(explode(',', $data['keywords']));
                        if ($keywordCount > $guideline->validation_rules['max_keywords']) {
                            $results['warnings'][] = "Nên có tối đa {$guideline->validation_rules['max_keywords']} từ khóa chính";
                        }
                    }
                    break;
            }
        }
    }

    /**
     * Kiểm tra tiêu chí về hình ảnh
     */
    private function validateImages(array $data, array &$results): void
    {
        $imageGuidelines = WritingGuideline::getByCategory('image');

        foreach ($imageGuidelines as $guideline) {
            switch ($guideline->name) {
                case 'Kích thước hình ảnh':
                    if (!empty($data['thumbnail_url'])) {
                        $imageSize = getimagesize($data['thumbnail_url']);
                        if ($imageSize[0] < $guideline->validation_rules['thumbnail']['width'] ||
                            $imageSize[1] < $guideline->validation_rules['thumbnail']['height']) {
                            $results['warnings'][] = "Ảnh đại diện nên có kích thước tối thiểu {$guideline->validation_rules['thumbnail']['width']}x{$guideline->validation_rules['thumbnail']['height']}px";
                        }
                    }
                    break;

                case 'Alt Text':
                    $images = $data['content'];
                    preg_match_all('/<img[^>]+>/i', $images, $imgTags);
                    foreach ($imgTags[0] as $imgTag) {
                        if (!preg_match('/alt=["\'](.*?)["\']/i', $imgTag)) {
                            $results['errors'][] = "Tất cả hình ảnh phải có thuộc tính alt";
                            break;
                        }
                    }
                    break;
            }
        }
    }

    /**
     * Kiểm tra tiêu chí về bản quyền
     */
    private function validateCopyright(array $data, array &$results): void
    {
        $copyrightGuidelines = WritingGuideline::getByCategory('copyright');

        foreach ($copyrightGuidelines as $guideline) {
            switch ($guideline->name) {
                case 'Nguồn trích dẫn':
                    if (preg_match('/<blockquote|<cite/i', $data['content']) &&
                        !preg_match('/<cite.*?<\/cite>/i', $data['content'])) {
                        $results['errors'][] = "Khi trích dẫn phải ghi rõ nguồn";
                    }
                    break;

                case 'Bản quyền hình ảnh':
                    // Kiểm tra xem có thông tin về bản quyền hình ảnh không
                    if (preg_match('/<img[^>]+>/i', $data['content']) &&
                        !preg_match('/data-license/i', $data['content'])) {
                        $results['warnings'][] = "Nên ghi rõ nguồn và giấy phép sử dụng cho các hình ảnh";
                    }
                    break;
            }
        }
    }
}

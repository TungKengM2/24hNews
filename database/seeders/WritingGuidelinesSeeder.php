<?php

namespace Database\Seeders;

use App\Models\WritingGuideline;
use Illuminate\Database\Seeder;

class WritingGuidelinesSeeder extends Seeder
{
    public function run(): void
    {
        $guidelines = [
            // Tiêu chí về nội dung
            [
                'category' => 'content',
                'name' => 'Độ dài tối thiểu',
                'description' => 'Bài viết phải có độ dài tối thiểu để đảm bảo nội dung đầy đủ và chất lượng',
                'requirements' => 'Tối thiểu 500 từ',
                'is_required' => true,
                'validation_rules' => ['min_words' => 500],
                'order' => 1
            ],
            [
                'category' => 'content',
                'name' => 'Cấu trúc bài viết',
                'description' => 'Bài viết phải có cấu trúc rõ ràng với các phần mở bài, thân bài và kết luận',
                'requirements' => 'Bắt buộc có các phần: Mở bài, Thân bài (ít nhất 2-3 ý chính), Kết luận',
                'is_required' => true,
                'validation_rules' => ['required_sections' => ['introduction', 'body', 'conclusion']],
                'order' => 2
            ],
            [
                'category' => 'content',
                'name' => 'Hình ảnh tối thiểu',
                'description' => 'Số lượng hình ảnh tối thiểu trong bài viết',
                'requirements' => 'Tối thiểu 1 hình ảnh cho mỗi 500 từ',
                'is_required' => true,
                'validation_rules' => ['min_images_per_words' => 500],
                'order' => 3
            ],

            // Tiêu chí về SEO
            [
                'category' => 'seo',
                'name' => 'Meta Description',
                'description' => 'Mô tả ngắn gọn về nội dung bài viết cho SEO',
                'requirements' => 'Độ dài từ 150-160 ký tự, chứa từ khóa chính',
                'is_required' => true,
                'validation_rules' => ['min_length' => 150, 'max_length' => 160],
                'order' => 4
            ],
            [
                'category' => 'seo',
                'name' => 'Từ khóa chính',
                'description' => 'Từ khóa chính của bài viết',
                'requirements' => 'Tối thiểu 1 từ khóa chính, tối đa 3 từ khóa',
                'is_required' => true,
                'validation_rules' => ['min_keywords' => 1, 'max_keywords' => 3],
                'order' => 5
            ],

            // Tiêu chí về hình ảnh
            [
                'category' => 'image',
                'name' => 'Kích thước hình ảnh',
                'description' => 'Yêu cầu về kích thước hình ảnh',
                'requirements' => 'Ảnh đại diện: 1200x630px, Ảnh nội dung: tối thiểu 800px chiều rộng',
                'is_required' => true,
                'validation_rules' => [
                    'thumbnail' => ['width' => 1200, 'height' => 630],
                    'content_image' => ['min_width' => 800]
                ],
                'order' => 6
            ],
            [
                'category' => 'image',
                'name' => 'Alt Text',
                'description' => 'Mô tả hình ảnh cho SEO và accessibility',
                'requirements' => 'Mỗi hình ảnh phải có alt text mô tả nội dung',
                'is_required' => true,
                'validation_rules' => ['require_alt_text' => true],
                'order' => 7
            ],

            // Tiêu chí về bản quyền
            [
                'category' => 'copyright',
                'name' => 'Nguồn trích dẫn',
                'description' => 'Quy định về trích dẫn nguồn',
                'requirements' => 'Bắt buộc ghi nguồn khi trích dẫn từ nguồn khác',
                'is_required' => true,
                'validation_rules' => ['require_source_citation' => true],
                'order' => 8
            ],
            [
                'category' => 'copyright',
                'name' => 'Bản quyền hình ảnh',
                'description' => 'Quy định về sử dụng hình ảnh',
                'requirements' => 'Chỉ sử dụng hình ảnh có bản quyền hoặc giấy phép sử dụng',
                'is_required' => true,
                'validation_rules' => ['require_image_license' => true],
                'order' => 9
            ],

            // Tiêu chí về tương tác
            [
                'category' => 'interaction',
                'name' => 'Bình luận',
                'description' => 'Quy định về bình luận',
                'requirements' => 'Cho phép bình luận, nhưng phải được duyệt trước khi hiển thị',
                'is_required' => false,
                'validation_rules' => ['moderate_comments' => true],
                'order' => 10
            ]
        ];

        foreach ($guidelines as $guideline) {
            WritingGuideline::create($guideline);
        }
    }
}

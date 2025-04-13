<?php

namespace App\Services;

use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRService
{
    public function extractCCCDNumber($imagePath)
    {
        try {
            $ocr = new TesseractOCR();
            $ocr->image($imagePath);
            $ocr->lang('vie');
            $text = $ocr->run();
            
            // Tìm số CCCD trong text
            preg_match('/\b\d{12}\b/', $text, $matches);
            
            return $matches[0] ?? null;
        } catch (\Exception $e) {
            \Log::error('OCR Error: ' . $e->getMessage());
            return null;
        }
    }
} 
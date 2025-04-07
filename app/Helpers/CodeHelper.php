<?php

namespace App\Helpers;

class CodeHelper
{
    public static function generateArticleCode(): string
    {
        $date = now()->format('dmy'); // ddmmyy
        $random = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT); // 8 chữ số
        return "BV-{$date}-{$random}";
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WritingGuideline extends Model
{
    use HasFactory;

    protected $primaryKey = 'guideline_id';

    protected $fillable = [
        'category',
        'name',
        'description',
        'requirements',
        'is_required',
        'validation_rules',
        'order',
        'is_active'
    ];

    protected $casts = [
        'validation_rules' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean'
    ];

    // Lấy tất cả tiêu chí theo danh mục
    public static function getByCategory($category)
    {
        return self::where('category', $category)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    // Lấy tất cả tiêu chí bắt buộc
    public static function getRequired()
    {
        return self::where('is_required', true)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}

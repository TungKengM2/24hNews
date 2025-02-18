<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles'; // Đảm bảo tên bảng đúng

    protected $primaryKey = 'article_id'; // Khóa chính là 'article_id'

    protected $fillable = [
        'title',
        'slug',
        'content',
        'preview_content',
        'contains_sensitive_content',
        'author_id',
        'category_id',
        'thumbnail_url',
        'status',
        'views',
        'approved_by',
    ];

    /**
     * Quan hệ với bảng `users` (tác giả)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    /**
     * Quan hệ với bảng `categories`
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Quan hệ với `users` (người duyệt bài viết)
     */

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Lấy danh sách bài viết đã xuất bản
     */
    public static function published()
    {
        return self::where('status', 'published')->get();
    }

    /**
     * Tăng lượt xem bài viết
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

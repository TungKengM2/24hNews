<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\NewArticleSubmitted;


class Article extends Model
{

    use HasFactory;

    protected $table = 'articles';

    protected $primaryKey = 'article_id';

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

    protected $with = ['tags'];

    /**
     * Lấy danh sách bài viết đã xuất bản
     */
    public static function published()
    {
        return self::where('status', 'published')->get();
    }

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
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'article_tags',
            'article_id',
            'tag_id'
        );
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

    public function notifyAdmins(): void
    {
        $admins = User::where('role_id', 1)->get(); // Lấy danh sách admin
        Notification::send($admins, new NewArticleSubmitted($this)); // Gửi thông báo
    }

    /**
     * Tăng lượt xem bài viết
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NewArticleSubmitted;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $primaryKey = 'article_id';

    protected $fillable = [
        'title',
        'code',
        'slug',
        'content',
        'preview_content',
        'contains_sensitive_content',
        'author_id',
        'category_id',
        'subcategory_id',
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

    public function versions()
    {
        return $this->hasMany(ArticleVersion::class, 'article_id');
    }

    /**
     * Quan hệ với bảng `users` (tác giả)
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    /**
     * Quan hệ với bảng `categories` (danh mục chính - cha)
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    /**
     * Quan hệ với bảng `categories` (danh mục phụ - con)
     */
    public function subcategory()
    {
        return $this->belongsTo(
            Category::class,
            'subcategory_id',
            'category_id'
        );
    }

    public function getCategoryNameAttribute()
    {
        if (! $this->category) {
            return 'Không có danh mục';
        }

        return $this->category->is_active ? $this->category->name : 'Không hoạt động';
    }

    public function getSubcategoryNameAttribute()
    {
        if (! $this->subcategory) {
            return 'Không có danh mục con';
        }

        return $this->subcategory->is_active ? $this->subcategory->name : 'Không hoạt động';
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
        Notification::send(
            $admins,
            new NewArticleSubmitted($this)
        ); // Gửi thông báo
    }

    /**
     * Tăng lượt xem bài viết
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_active', true);
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id', 'article_id');
    }
    public function likes()
    {
        return $this->hasMany(ArticleLike::class, 'article_id', 'article_id');
    }
    public function getInteractionScoreAttribute()
    {
        // Dùng count từ withCount nếu có, nếu không fallback
        $likes = $this->likes_count ?? $this->likes()->count();
        $comments = $this->comments_count ?? $this->comments()->count();
        $views = $this->views ?? 0;

        // Tuỳ chỉnh trọng số nếu muốn
        $score = ($views * 5) + ($likes * 10) + ($comments * 20);
        return (int) round($score);
    }

    public function getRatingStarAttribute()
    {
        $score = $this->interaction_score;
        $maxScore = 100; // điểm tương tác tối đa để tính đủ 5 sao

        return round(min(5, 1 + 4 * ($score / $maxScore)), 1); // Từ 1 đến 5 sao
    }

    public function editRequests()
    {
        return $this->hasMany(EditRequest::class);
    }

    public function hasEditRequest()
    {
        return $this->editRequests()->where('status', 'pending')->exists();
    }
}

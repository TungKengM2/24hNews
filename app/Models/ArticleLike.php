<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    use HasFactory;
    protected $table = 'article_likes';
    protected $primaryKey = 'like_id';
    public $timestamps = false; // Bảng không có cột created_at và updated_at

    protected $fillable = ['article_id', 'user_id', 'liked_at'];

    // Quan hệ với bài viết
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}

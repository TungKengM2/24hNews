<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    protected $table = 'article_likes';
    protected $primaryKey = 'like_id';
    public $timestamps = false;

    protected $fillable = ['article_id', 'user_id', 'liked_at'];

    // Quan hệ với bài viết
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}

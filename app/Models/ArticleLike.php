<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleLike extends Model
{
    use HasFactory;

    protected $table = 'article_likes'; // Đảm bảo đúng tên bảng
    protected $primaryKey = 'like_id'; // Đặt khóa chính đúng với database
    public $timestamps = false; // Vì bạn đã có `liked_at`, không cần timestamps mặc định

    protected $fillable = ['article_id', 'user_id', 'liked_at'];

    // Quan hệ với bài viết
    public function article() {
        return $this->belongsTo(Article::class, 'article_id');
    }

    // Quan hệ với người dùng
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}

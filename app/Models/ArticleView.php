<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ArticleView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'user_id',
        'anonymous',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    // Liên kết với bảng Articles
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id', 'article_id');
    }
}

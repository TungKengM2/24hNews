<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    use HasFactory;

    protected $table = 'article_views';

    protected $fillable = [
        'anonymous',
        'article_id',
        'user_id',
        'viewed_at',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

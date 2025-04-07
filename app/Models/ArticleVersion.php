<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleVersion extends Model
{
    use HasFactory;

    protected $primaryKey = 'version_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'version_id',
        'article_id',
        'user_id',
        'title',
        'slug',
        'content',
        'change_reason',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

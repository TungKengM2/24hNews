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
        'category_id',
        'subcategory_id',
        'featured_image',
        'tags',
        'change_reason',
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id', 'category_id');
    }
}

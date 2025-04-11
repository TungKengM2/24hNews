<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'tag_id';

    protected $fillable = ['name', 'description'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($tag) {
            if (!$tag->description) {
                $tag->description = '';
            }
        });
    }

    public function publishedArticles()
    {
        return $this->belongsToMany(Article::class, 'article_tags', 'tag_id', 'article_id')
            ->where('status', 'published');
    }
}

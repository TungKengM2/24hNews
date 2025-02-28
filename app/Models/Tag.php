<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'tag_id';

    protected $fillable = ['name', 'description'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($tag) {
            if (!$tag->description) {
<<<<<<< HEAD
                $tag->description = '';
=======
                $tag->description = ''; 
>>>>>>> tungkeng
            }
        });
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags', 'tag_id', 'article_id');
    }
}

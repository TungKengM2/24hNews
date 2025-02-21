<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Tag extends Model
    {

        protected $primaryKey = 'tag_id';

        protected $fillable = [
            'name',
            'description',
        ];

        public function articles()
        {
            return $this->belongsToMany(Article::class, 'article_tags',
                'tag_id', 'article_id');
        }

    }

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleLike extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'liked_at'];

    public $timestamps = false;
}

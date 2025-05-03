<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'user_id',
        'anonymous',
        'viewed_at',
    ]; // Không cần timestamps vì đã có `viewed_at`

}

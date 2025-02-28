<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleView extends Model
{
    use HasFactory;

    protected $fillable = ['article_id', 'user_id', 'anonymous', 'viewed_at'];

    public $timestamps = false; // Không cần timestamps vì đã có `viewed_at`
}

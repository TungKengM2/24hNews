<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleHistory extends Model
{
    use HasFactory;

    protected $table = 'articlehistory'; 
    protected $fillable = ['user_id', 'article_id', 'viewed_at'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}

?>
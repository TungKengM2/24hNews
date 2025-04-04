<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    
    protected $primaryKey = 'category_id'; // Đặt khóa chính là category_id

    protected $fillable = [
        'name',
        'slug',
        'is_active'
    ];
    public function articles()
{
    return $this->hasMany(Article::class, 'category_id', 'category_id');
}

}

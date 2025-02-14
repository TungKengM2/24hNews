<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

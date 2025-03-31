<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'slug', 'is_active', 'moderator_id'];

    /**
     * Quan hệ với kiểm duyệt viên (Moderator).
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id', 'user_id');
    }

    /**
     * Gán kiểm duyệt viên cho danh mục theo vòng lặp.
     */
    public static function assignModerators()
    {
        $moderators = User::where('role_id', 3)->get();
        if ($moderators->isEmpty()) return;
    
        $categories = Category::all(); // Lấy tất cả danh mục
        if ($categories->isEmpty()) return;
    
        $modCount = $moderators->count();
        foreach ($categories as $index => $category) {
            $category->moderator_id = $moderators[$index % $modCount]->user_id;
            $category->save();
        }
    }
    
    
    
}

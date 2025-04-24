<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'slug', 'is_active', 'moderator_id', 'parent_id'];

    /**
     * Quan hệ với kiểm duyệt viên (Moderator).
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id', 'user_id');
    }


    public static function assignModerators()
    {
        $moderators = User::where('role_id', 3)->get();
        if ($moderators->isEmpty()) return;

        $parentCategories = Category::whereNull('parent_id')->get();
        if ($parentCategories->isEmpty()) return;

        $modCount = $moderators->count();
        foreach ($parentCategories as $index => $category) {
            $category->moderator_id = $moderators[$index % $modCount]->user_id;
            $category->save();
        }
    }
    /**
     * Quan hệ với danh mục cha.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }
    

    /**
     * Quan hệ với danh mục con.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }

    /**
     * Quan hệ với bài viết (danh mục chính).
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'category_id');
    }

    /**
     * Quan hệ với bài viết (danh mục phụ).
     */
    public function subArticles()
    {
        return $this->hasMany(Article::class, 'subcategory_id', 'category_id');
    }

    /**
     * Lấy kiểm duyệt viên cho danh mục.
     * Nếu là danh mục con và không có kiểm duyệt viên, sẽ lấy từ danh mục cha.
     *
     * @return \App\Models\User|null
     */
    public function getModerator()
    {
        // Nếu danh mục đã có kiểm duyệt viên, trả về kiểm duyệt viên đó
        if ($this->moderator_id) {
            return $this->moderator;
        }

        // Nếu là danh mục con, lấy kiểm duyệt viên từ danh mục cha
        if ($this->parent_id && $this->parent) {
            return $this->parent->getModerator();
        }

        return null;
    }
}

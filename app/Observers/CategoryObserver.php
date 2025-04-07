<?php

namespace App\Observers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    // public function updating(Category $category): void
    // {
    //     Log::info('Observer được gọi', [
    //         'category_id' => $category->category_id,
    //         'is_active' => $category->is_active
    //     ]);

    //     if ($category->isDirty('is_active')) {
    //         if (!$category->is_active) {
    //             Log::info("Cập nhật category_id của bài viết về NULL cho category_id = {$category->category_id}");

    //             // Lưu danh sách các bài viết bị ảnh hưởng
    //             Article::where('category_id', $category->category_id)
    //                 ->update(['category_id' => null]);
    //         } else {
    //             Log::info("Khôi phục category_id cho bài viết có danh mục {$category->category_id}");

    //             // Chỉ cập nhật lại các bài viết có category_id = null
    //             Article::whereNull('category_id')
    //                 ->update(['category_id' => $category->category_id]);
    //         }
    //     }
    // }

    public function updating(Category $category): void
    {
        Log::info('Observer được gọi', [
            'category_id' => $category->category_id,
            'is_active' => $category->is_active,
            'parent_id' => $category->parent_id
        ]);

        if ($category->isDirty('is_active')) {
            if (!$category->is_active) {
                Log::info("Danh mục {$category->category_id} bị vô hiệu hóa");

                // Nếu là danh mục cha, vô hiệu hóa tất cả danh mục con
                if ($category->parent_id === null) {
                    $childCategories = Category::where('parent_id', $category->category_id)->get();
                    foreach ($childCategories as $childCategory) {
                        $childCategory->is_active = false;
                        $childCategory->save();
                        Log::info("Danh mục con {$childCategory->category_id} bị vô hiệu hóa theo danh mục cha");
                    }
                }

                // Chuyển trạng thái bài viết có danh mục này thành draft
                if ($category->parent_id === null) {
                    // Nếu là danh mục cha, cập nhật bài viết có category_id
                    Article::where('category_id', $category->category_id)
                        ->where('status', 'published')
                        ->update(['status' => 'draft']);
                } else {
                    // Nếu là danh mục con, cập nhật bài viết có subcategory_id
                    Article::where('subcategory_id', $category->category_id)
                        ->where('status', 'published')
                        ->update(['status' => 'draft']);
                }
            } else {
                Log::info("Danh mục {$category->category_id} được kích hoạt lại");

                // Nếu là danh mục con, kiểm tra xem danh mục cha có đang hoạt động không
                if ($category->parent_id !== null) {
                    $parentCategory = Category::find($category->parent_id);
                    if ($parentCategory && !$parentCategory->is_active) {
                        $category->is_active = false; // Không cho phép kích hoạt nếu danh mục cha không hoạt động
                        Log::info("Không thể kích hoạt danh mục con {$category->category_id} vì danh mục cha không hoạt động");
                    }
                }
            }
        }
    }



    /**
     * Handle the Category "deleted" event.
     */
    public function deleting(Category $category): void
    {
        // Nếu là danh mục cha, vô hiệu hóa tất cả danh mục con
        if ($category->parent_id === null) {
            $childCategories = Category::where('parent_id', $category->category_id)->get();
            foreach ($childCategories as $childCategory) {
                $childCategory->is_active = false;
                $childCategory->save();
                Log::info("Danh mục con {$childCategory->category_id} bị vô hiệu hóa do danh mục cha bị xóa");
            }

            // Chuyển trạng thái bài viết có danh mục cha này thành draft
            Article::where('category_id', $category->category_id)
                ->where('status', 'published')
                ->update(['status' => 'draft']);

            // Chuyển trạng thái bài viết có danh mục con thuộc danh mục cha này thành draft
            $childCategoryIds = $childCategories->pluck('category_id')->toArray();
            if (!empty($childCategoryIds)) {
                Article::whereIn('subcategory_id', $childCategoryIds)
                    ->where('status', 'published')
                    ->update(['status' => 'draft']);
            }
        } else {
            // Nếu là danh mục con, chuyển trạng thái bài viết có danh mục con này thành draft
            Article::where('subcategory_id', $category->category_id)
                ->where('status', 'published')
                ->update(['status' => 'draft']);
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        Category::assignModerators();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}

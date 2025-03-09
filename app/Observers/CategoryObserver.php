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
            'is_active' => $category->is_active
        ]);

        if ($category->isDirty('is_active')) {
            if (!$category->is_active) {
                Log::info("Danh mục {$category->category_id} bị vô hiệu hóa, nhưng không cập nhật NULL.");
                // Không đặt category_id về NULL nữa
            } else {
                Log::info("Danh mục {$category->category_id} được kích hoạt lại.");
            }
        }
    }



    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
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

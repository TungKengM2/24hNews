<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Category;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($user->role_id == 3) { // Chỉ xử lý nếu là kiểm duyệt viên
            $this->assignCategoriesToModerators();
        }
    }
    
    private function assignCategoriesToModerators()
    {
        $moderators = User::where('role_id', 3)->get();
        if ($moderators->isEmpty()) return; // Không có kiểm duyệt viên nào

        $categories = Category::all();
        if ($categories->isEmpty()) return; // Không có danh mục nào

        $modCount = $moderators->count();
        foreach ($categories as $index => $category) {
            $category->moderator_id = $moderators[$index % $modCount]->user_id;
            $category->save();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleting(User $user)
    {
        if ($user->role_id == 3) { // Chỉ xử lý nếu là kiểm duyệt viên
            $moderators = User::where('role_id', 3)->where('user_id', '!=', $user->user_id)->get();
    
            if ($moderators->isNotEmpty()) {
                $modCount = $moderators->count();
                $categories = Category::where('moderator_id', $user->user_id)->get();
                
                foreach ($categories as $index => $category) {
                    // Chia lại danh mục cho các KDV còn lại
                    $category->moderator_id = $moderators[$index % $modCount]->user_id;
                    $category->save();
                }
            } else {
                // Nếu không còn KDV nào, đặt moderator_id = NULL
                Category::where('moderator_id', $user->user_id)->update(['moderator_id' => null]);
            }
        }
    }
    

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            [
                'author.articles.index',
                'author.articles.show',
                'author.articles.edit',
                'author.articles.create',
                'author.dashboard',
                'author.profile',
                'author.layouts.master',
                'author.layouts.partials.header-top',
                'user.dashboard',
                'user.layouts.master',
                'user.layouts.partials.header-top',
            ],
            function ($view) {
                $user = Auth::user();
                $view->with('username', $user->username ?? 'Tác Giả');
                $view->with('avatar',
                    $user->image ?? '/admin/main/../images/user5-128x128.jpg');
            }
        );
        Category::observe(CategoryObserver::class);
    }

    /**
     * Bootstrap any application services.
     */
}

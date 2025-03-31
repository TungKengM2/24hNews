<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Article;
use App\Observers\ArticleObserver;
use App\Observers\UserObserver;


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
                //dat them
                'website.layouts.partials.start-nav',
                'website.profiles.admin',
                'website.profiles.author',
                'website.profiles.moderator',
                'website.profiles.user',
                //dat them
            ],
            function ($view) {
                $user = Auth::user();
                $view->with('username', $user->username ?? 'Tác Giả');
                $view->with('avatar',
                    $user->image ?? '/admin/main/../images/user5-128x128.jpg');
                // dat them
                $view->with('categories', Category::where('is_active', 1)->get());
                $view->with('category2', Category::where('is_active', 1)->get());

                // dat them
            }

        );

        Category::observe(CategoryObserver::class);
        Article::observe(ArticleObserver::class);
        User::observe(UserObserver::class);

    }

    /**
     * Bootstrap any application services.
     */
}

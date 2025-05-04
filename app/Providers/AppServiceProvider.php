<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Article;

use App\Models\Category;
use App\Observers\UserObserver;
use App\Observers\ArticleObserver;
use App\Observers\CategoryObserver;
use App\Services\ModerationService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Services\TinyMCEUploadService;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

//tungkeng bổ sung thêm để chạy lại bảng
// use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\StringType;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Đăng ký ModerationService vào container
        $this->app->singleton(ModerationService::class, function ($app) {
            return new ModerationService();
        });

        // Đăng ký TinyMCEUploadService vào container
        $this->app->singleton(TinyMCEUploadService::class, function ($app) {
            return new TinyMCEUploadService($app->make(ModerationService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!Type::hasType('enum')) {
            Type::addType('enum', 'Doctrine\DBAL\Types\StringType'); // Hoặc bạn có thể tạo class custom nếu cần
        //Tùng keng bổ sung thêm để chạy lại bảng
        // if (DB::getDriverName() === 'mysql' && class_exists('Doctrine\DBAL\Types\Type')) {
        //     if (!Type::hasType('enum')) {
        //         Type::addType('enum', StringType::class);
        //     }

        //     DB::getDoctrineConnection()
        //         ->getDatabasePlatform()
        //         ->registerDoctrineTypeMapping('enum', 'string');
        // }
        //Tùng keng bổ sung thêm để chạy lại bảng
        // if (DB::getDriverName() === 'mysql') {
        //     if (!Type::hasType('enum')) {
        //         Type::addType('enum', StringType::class);
        //     }

        //     DB::getDoctrineConnection()
        //         ->getDatabasePlatform()
        //         ->registerDoctrineTypeMapping('enum', 'string');
        // }

        Article::observe(ArticleObserver::class);

        Paginator::useBootstrap();

        Carbon::setLocale('vi');
        setlocale(LC_TIME, 'vi_VN'); // Dành cho date/time truyền thống

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
                //dat them
                'website.layouts.partials.top-nav',
                'website.profiles.admin',
                'website.profiles.author',
                'website.profiles.moderator',
                'website.profiles.user',
                //dat them
            ],
            function ($view) {
                $user = Auth::user();
                $view->with('username', $user->username ?? 'Tác Giả');
                $view->with(
                    'avatar',
                    $user->image ?? '/admin/main/../images/user5-128x128.jpg'
                );
                // dat them
                $view->with('categories', Category::where('is_active', 1)->get());
                $view->with('category2', Category::where('is_active', 1)->get());

                // Thêm biến parentCategories cho top-nav.blade.php
                $parentCategories = Category::whereNull('parent_id')
                    ->where('is_active', 1)
                    ->get();

                $view->with('parentCategories', $parentCategories);
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

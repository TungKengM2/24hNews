<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ArticleUserController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\CategoryUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\User\ArticleSaveController;
use App\Http\Controllers\Moderator\ModeratorController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\User\ArticleViewUserController;
use App\Http\Controllers\Author\ArticleViewAuthorController;
use App\Http\Controllers\User\ArticleViewModeratorController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\Author\ArticleController as AuthorArticleController;
use App\Http\Controllers\Author\ArticleSaveController as AuthorArticleSaveController;
use App\Http\Controllers\Moderator\ArticleSaveController as ModeratorArticleSaveController;
use App\Http\Controllers\Moderator\ArticleViewModeratorController as ModeratorArticleViewModeratorController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\Controller;
use App\Models\User;

// 🌟 Trang chủ & bài viết chi tiết

Route::get('/', [HomeController::class, 'index'])->name('home');
// dat them
Route::post('/search', [HomeController::class, 'search'])->name('search');

// Client Articles
Route::get('/articles/{slug}', [ArticleUserController::class, 'show'])->name('articles.article');
Route::post('/articles/{article_id}/like', [ArticleUserController::class, 'likeArticle'])->name('articles.like');
Route::post('/articles/{article_id}/comments', [ArticleUserController::class, 'storeComment'])->middleware('auth')->name('articles.comment');
Route::post('/articles/{article_id}/comments/{comment_id}/reply', [ArticleUserController::class, 'storeReplyComment'])->middleware('auth')->name('articles.replyComment');

// Client Category
Route::get('/category/{category_id}', [CategoryUserController::class, 'index'])->name('client.category.show');


// 🚀 Auth dành cho User
Route::middleware('guest')
    ->controller(AuthUserController::class)
    ->group(function () {
        Route::get('/login-user', 'showLoginUserForm')->name('loginuser');
        Route::post('/login-user', 'login')->name('loginuser.process');
        Route::get('/signup-user', 'showSignupUserForm')
            ->name('signupuser');
        Route::post('/signup-user', 'processSignup')
            ->name('signupuser.process');
        Route::get('/verify-otp', 'showOtpForm')->name('otp.verify.form');
        Route::post('/verify-otp', 'verifyOtp')->name('otp.verify.process');
        Route::get('/forget-user', 'showForgetUserForm')
            ->name('forgetuser');
    });

// 🚀 Auth dành cho Admin
Route::middleware('guest')
    ->controller(AuthAdminController::class)
    ->group(function () {
        Route::get('/login-admin', 'showLoginAdminForm')
            ->name('loginadmin');
        Route::post('/login-admin', 'login')->name('loginadmin.process');
        Route::get('/forget-admin', 'showForgetAdminForm')
            ->name('forgetadmin');
        Route::post('/forget-admin', 'processForgetAdmin')
            ->name('forgetadmin.process');
    });

// 🔐 Quên mật khẩu chung
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showLinkRequestForm')
        ->name('password.request');
    Route::post('/forgot-password', 'sendResetLinkEmail')
        ->name('password.email');
    Route::get('/reset-password/{token}', 'showResetForm')
        ->name('password.reset');
    Route::post('/reset-password', 'reset')->name('password.update');
});

// 🚀 Profile dùng chung
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');
    Route::post(
        '/profile/update',
        [ProfileController::class, 'updateProfile']
    )
        ->name('profile.update');
    // Route::get(
    //     '/profile/change-password',
    //     [ProfileController::class, 'showChangePasswordForm']
    // )->name('profile.change-password');

    Route::post(
        '/profile/update-password',
        [ProfileController::class, 'updatePassword']
    )
        ->name('profile.update-password');
    Route::post(
        '/profile/upload-avatar',
        [ProfileController::class, 'uploadAvatar']
    )
        ->name('profile.upload-avatar');
});

// 🚀 Cài đặt profile riêng theo vai trò
Route::middleware(['auth', 'role:4'])
    ->get('/user/profile-setting', function () {
        return view('user.profile-setting');
    })
    ->name('user.profile-setting');


Route::middleware(['auth', 'role:3'])
    ->get('/moderator/profile-setting', function () {
        return view('moderator.profile-setting');
    })
    ->name('moderator.profile-setting');

Route::middleware(['auth', 'role:3'])
    ->get('/moderator/profile', function () {
        return view('moderator.profile');
    })
    ->name('moderator.profile');




Route::middleware(['auth', 'role:3'])
    ->get('/moderator/dashboard', function () {
        return view('moderator.dashboard');
    })
    ->name('moderator.dashboard');



// 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function () {
    Route::get(
        '/list-article',
        [ModeratorArticleController::class, 'index']
    )
        ->name('moderator.list-article');

    Route::get('/profile', [ProfileController::class, 'profileModerator'])
        ->name('moderator.profile');

    Route::get(
        '/change-password',
        [ProfileController::class, 'showChangePasswordFormModerator']
    )->name('moderator.change-password');
    Route::get('/articles', [ModeratorArticleController::class, 'index'])
        ->name('moderator.articles.index');

    Route::get('/articles/{article}', [ModeratorArticleController::class, 'show'])
        ->name('moderator.articles.show');

    Route::patch('/articles/{article}/approve', [ModeratorArticleController::class, 'approve'])
        ->name('moderator.articles.approve');

    // Sửa lại route reject (bỏ 'moderator/' trong URL)
    Route::patch('/articles/{article}/reject', [ModeratorArticleController::class, 'reject'])
        ->name('moderator.articles.reject');

    // Bookmark By TungKeng
    Route::post('/save-article', [ModeratorArticleSaveController::class, 'saveArticle'])->name('save.article');
    Route::get('/saved-articles', [ModeratorArticleSaveController::class, 'savedArticles'])->name('moderator.saved');
    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('moderator.article.detail');
    Route::delete('/user/remove-saved-article/{id}', [ModeratorArticleSaveController::class, 'removeSavedArticle'])->name('moderator.remove.saved');
    Route::post('/bookmark/{article_id}', [ModeratorArticleSaveController::class, 'toggleBookmark']);

    // Lịch sử bài viết đã xem của user
    Route::get('/viewed-articles', [ModeratorArticleViewModeratorController::class, 'index'])->name('moderator.viewed.articles');

    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [ModeratorController::class, 'getUserComments'])->name('moderator.comments');
});
// Route::prefix('moderator')->name('moderator.')->group(function () {
//     Route::get('/articles', [ModeratorArticleController::class, 'index'])
//         ->name('articles.index');

//     Route::get('/articles/{article}', [ModeratorArticleController::class, 'show'])
//         ->name('articles.show');

//     Route::patch('/articles/{article}/approve', [ModeratorArticleController::class, 'approve'])
//         ->name('articles.approve');

//     // Sửa lại route reject (bỏ 'moderator/' trong URL)
//     Route::patch('/articles/{article}/reject', [ModeratorArticleController::class, 'reject'])
//         ->name('articles.reject');
// });



// 🚀 Khu vực dành riêng cho Author (role_id = 2)
Route::middleware(['auth', 'role:2'])->prefix('author')->group(function () {
    Route::get('/dashboard', [AuthorDashboard::class, 'index'])
        ->name('author.dashboard');

    Route::get('/profile-setting', function () {
        return view('author.profile-setting');
    })->name('author.profile-setting');

    Route::get('/profile', [AuthorProfileController::class, 'index'])
        ->name('author.profile');
    Route::put(
        '/profile',
        [AuthorProfileController::class, 'update']
    )
        ->name('author.profile.update');

    Route::resource(
        'articles',
        AuthorArticleController::class
    )
        ->names('author.articles');

    Route::post('/articles/upload', [
        AuthorArticleController::class,
        'uploadImage',
    ])
        ->name('author.articles.upload');

    Route::get(
        '/articles/search',
        [AuthorArticleController::class, 'search']
    )
        ->name('author.articles.search');

    Route::get('/profile', [ProfileController::class, 'profileAuthor'])
        ->name('author.profile');

    Route::get(
        '/change-password',
        [ProfileController::class, 'showChangePasswordFormAuthor']
    )->name('author.change-password');
    //xóa thông báo khi đã đọc

    // Route::post('/notifications/{id}/read', function ($id, User $user): JsonResponse {
    //     $notification = $user->notifications()->find($id);

    // Bookmark By TungKeng
    Route::post('/save-article', [AuthorArticleSaveController::class, 'saveArticle'])->name('save.article');
    Route::get('/saved-articles', [AuthorArticleSaveController::class, 'savedArticles'])->name('author.saved');
    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('author.article.detail');
    Route::delete('/user/remove-saved-article/{id}', [AuthorArticleSaveController::class, 'removeSavedArticle'])->name('author.remove.saved');
    Route::post('/bookmark/{article_id}', [AuthorArticleSaveController::class, 'toggleBookmark']);

    // Lịch sử bài viết đã xem của user
    Route::get('/viewed-articles', [ArticleViewAuthorController::class, 'index'])->name('author.viewed.articles');

    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [AuthorController::class, 'getUserComments'])->name('author.comments');
    //     if ($notification) {
    //         $notification->markAsRead();
    //         return response()->json([
    //             'success' => true,
    //             'unreadCount' => $user->unreadNotifications()->count()
    //         ]);
    //     }

    //     return response()->json(['success' => false], 404);
    // })->middleware('auth');

});

Route::post('/notifications/{id}/read', function ($id) {
    $notification = User::find(auth()->id())->unreadNotifications()->find($id);

    if ($notification) {
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});

Route::post('/notifications/clear', function () {
    Auth::User()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
});

// 🚀 Khu vực dành riêng cho User (role_id = 4)
Route::middleware(['auth', 'role:4'])
    ->prefix('/user')
    ->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'dashboard'])
            ->name('user.dashboard');

        // Yêu cầu nâng cấp vai trò lên Author
        Route::get('/upgrade', function () {
            return view('user.upgrade');
        })->name('user.upgrade');
        Route::get('/upgrade-result', function () {
            return view('user.upgrade-result');
        })->name('user.upgrade.result');
        Route::post(
            '/upgrade',
            [ProfileController::class, 'requestAuthorRole']
        )
            ->name('user.upgrade.author');

        Route::get(
            '/change-password',
            [ProfileController::class, 'showChangePasswordForm']
        )->name('user.change-password');

        // Route::post('/articles/view', [ArticleViewUserController::class, 'store']);
        // Route::get('/articles/viewed', [ArticleViewUserController::class, 'index']);

        // Bookmark By TungKeng
        Route::post('/save-article', [ArticleSaveController::class, 'saveArticle'])->name('save.article');
        Route::get('/saved-articles', [ArticleSaveController::class, 'savedArticles'])->name('user.saved');
        Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('article.detail');
        Route::delete('/user/remove-saved-article/{id}', [ArticleSaveController::class, 'removeSavedArticle'])->name('user.remove.saved');
        Route::post('/bookmark/{article_id}', [ArticleSaveController::class, 'toggleBookmark']);

        // Lịch sử bài viết đã xem của user
        Route::get('/viewed-articles', [ArticleViewUserController::class, 'index'])->name('viewed.articles');

        // Hoạt động bình luận
        Route::get('/{user_id}/comments', [UserUserController::class, 'getUserComments'])->name('user.comments');
    });

// Khu vực dùng cho BookMark By TungKeng
Route::middleware(['auth'])->group(function () {
    Route::post('/save-article', [ArticleSaveController::class, 'saveArticle'])->name('save.article');
});


// 🚀 Khu vực dành riêng cho Admin (role_id = 1)
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    // 🏠 Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/user-stats', [AdminDashboardController::class, 'getUserStats'])->name('admin.userStats');
    Route::get('/article-stats', [AdminDashboardController::class, 'getArticleStats'])->name('admin.articleStats');

    // Quản lý yêu cầu nâng cấp vai trò
    Route::get(
        '/role-upgrade-requests',
        [UserController::class, 'roleUpgradeRequests']
    )
        ->name('admin.user-role-requests');
    Route::post('/admin/approve/{id}', [UserController::class, 'approve'])
        ->name('admin.approve.user');
    Route::delete('/admin/reject/{id}', [UserController::class, 'reject'])
        ->name('admin.reject.user');

    // Quản lý bài viết
    Route::get('/articles/approves', [ArticleController::class, 'Approves'])
        ->name('admin.articles.approves');
    Route::patch(
        '/articles/{article}/approve',
        [ArticleController::class, 'approve']
    )->name('articles.approve');
    Route::resource('articles', ArticleController::class);
    Route::patch('/articles/{article}/reject', [ArticleController::class, 'reject'])
        ->name('articles.reject');



    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);

    // Quản lý người dùng
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
    ]);
});

// 📤 Upload hình ảnh
Route::post('/upload/image', [UploadController::class, 'store'])
    ->name('upload.image');

// 🔐 Đăng xuất
Route::post('/logout', [AuthUserController::class, 'logout'])
    ->name('logout');

// 🌍 Đăng nhập với Google & Facebook
Route::get(
    'auth/{provider}',
    [SocialAuthController::class, 'redirectToProvider']
);
Route::get(
    'auth/{provider}/callback',
    [SocialAuthController::class, 'handleProviderCallback']
);

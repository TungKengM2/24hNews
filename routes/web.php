<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 🌟 Trang chủ & bài viết chi tiết
Route::view('/', 'welcome');
Route::view('/article-detail', 'website.pages.articledetail.homedetail');

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
    Route::get(
        '/profile/change-password',
        [ProfileController::class, 'showChangePasswordForm']
    )
        ->name('profile.change-password');
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

// Route::middleware(['auth', 'role:2'])->get('/author/profile-setting', function () {
//    return view('author.profile-setting');
// })->name('author.profile-setting');

Route::middleware(['auth', 'role:3'])
    ->get('/moderator/profile-setting', function () {
        return view('moderator.profile-setting');
    })
    ->name('moderator.profile-setting');

// 🚀 Dashboard cho từng vai trò
// Route::middleware(['auth', 'role:1'])->get('/admin/dashboard', function () {
//    return view('admin.dashboard');
// })->name('admin.dashboard');

Route::middleware(['auth', 'role:3'])
    ->get('/moderator/dashboard', function () {
        return view('moderator.dashboard');
    })
    ->name('moderator.dashboard');

// Route::middleware(['auth', 'role:4'])->get('/user/dashboard', function () {
//    return view('user.dashboard');
// })->name('user.dashboard');

// 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function () {
    Route::get(
        '/list-article',
        [ModeratorArticleController::class, 'index']
    )
        ->name('moderator.list-article');
});

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
        \App\Http\Controllers\Author\ArticleController::class
    )
        ->names('author.articles');

    Route::post('/articles/upload', [
        \App\Http\Controllers\Author\ArticleController::class,
        'uploadImage',
    ])
        ->name('author.articles.upload');

    Route::get(
        '/articles/search',
        [\App\Http\Controllers\Author\ArticleController::class, 'search']
    )
        ->name('author.articles.search');
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
    });

// 🚀 Khu vực dành riêng cho Admin (role_id = 1)
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    // 🏠 Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

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

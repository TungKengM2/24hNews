<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use Illuminate\Support\Facades\Route;

// 🌟 Giao diện trang chủ + bài viết
Route::get('/', function () {
    return view('welcome');
});

Route::get('/article-detail', function () {
    return view('website.pages.articledetail.homedetail');
});

// 🌟 Routes dành cho User (AuthUserController)
Route::middleware('guest')->controller(AuthUserController::class)->group(function () {
    Route::get('/login-user', 'showLoginUserForm')->name('loginuser');
    Route::post('/login-user', 'login')->name('loginuser.process');
    Route::get('/signup-user', 'showSignupUserForm')->name('signupuser');
    Route::post('/signup-user', 'processSignup')->name('signupuser.process');
    Route::get('/verify-otp', 'showOtpForm')->name('otp.verify.form');
    Route::post('/verify-otp', 'verifyOtp')->name('otp.verify.process');
    Route::get('/forget-user', 'showForgetUserForm')->name('forgetuser');
});

// 🚀 Khu vực dành riêng cho User (role_id = 4)
Route::middleware(['auth', 'role:4'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Yêu cầu nâng cấp vai trò lên Author
    Route::post('/profile/request-author-role', [ProfileController::class, 'requestAuthorRole'])
        ->name('profile.request-author-role');
});

// 🌟 Routes dành cho Admin (AuthAdminController)
Route::middleware('guest')->controller(AuthAdminController::class)->group(function () {
    Route::get('/login-admin', 'showLoginAdminForm')->name('loginadmin');
    Route::post('/login-admin', 'login')->name('loginadmin.process');
    Route::get('/forget-admin', 'showForgetAdminForm')->name('forgetadmin');
});

// 🚀 Khu vực dành riêng cho Admin (role_id = 1)
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/role-upgrade-requests', [AdminDashboardController::class, 'roleUpgradeRequests'])
        ->name('admin.user-role-requests');
    Route::post('/approve-role-upgrade/{approval_id}', [AdminDashboardController::class, 'approveRoleUpgrade'])
        ->name('admin.approve-role-upgrade');
    Route::post('/reject-role-upgrade/{approval_id}', [AdminDashboardController::class, 'rejectRoleUpgrade'])
        ->name('admin.reject-role-upgrade');

    // Quản lý bài viết
    Route::patch('/articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve');
    Route::resource('articles', ArticleController::class);

    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);
});

// 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function () {
    Route::get('/dashboard', [ModeratorDashboardController::class, 'index'])->name('moderator.dashboard');
    Route::get('/list-article', [ModeratorArticleController::class, 'index'])->name('moderator.list-article');
});

// 🔹 Quên mật khẩu chung
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'reset')->name('password.update');
});


Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');

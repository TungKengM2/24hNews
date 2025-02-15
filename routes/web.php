<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ForgotPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/client/articles/{article_id}', [ArticleUserController::class, 'show'])->name('client.articles.article');

// admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

//article
Route::patch('/articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve');
Route::prefix('admin')->group(function () {
    Route::resource('articles', ArticleController::class);
});

//category
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
});
//users
Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});


// Routes for login and signup
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'processSignup'])->name('signup.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
// Route xử lý OTP
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.process');


// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Hiển thị form nhập email để lấy lại mật khẩu
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

// Xử lý gửi email đặt lại mật khẩu
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Hiển thị form nhập mật khẩu mới
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Xử lý cập nhật mật khẩu mới
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

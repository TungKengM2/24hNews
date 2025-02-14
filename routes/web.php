<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});
// admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// post
// Route::get('/admin/post/createpost', [AdminDashboardController::class, 'showCreatePost'])->name('admin.post.createpost');
// Route::get('/admin/post/listpost', [AdminDashboardController::class, 'showListPost'])->name('admin.post.listpost');
// Route::get('/admin/post/editpost', [AdminDashboardController::class, 'showEditPost'])->name('admin.post.editpost');
Route::prefix('admin')->group(function () {
    Route::resource('articles', ArticleController::class);
});

// category
// Route::get('/admin/categories/listcategories', [AdminDashboardController::class, 'showListCategory'])->name('admin.categories.listcategories');
// Route::get('/admin/categories/createcategories', [AdminDashboardController::class, 'showCreateCategory'])->name('admin.categories.createcategory');
// Route::get('/admin/categories/editcategories', [AdminDashboardController::class, 'showEditCategory'])->name('admin.categories.editcategory');
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Route for profile
Route::get('user/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('user/profile', [ProfileController::class, 'update'])->name('profile.update');

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

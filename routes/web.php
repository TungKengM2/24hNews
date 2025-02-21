<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ResetPasswordController;
// use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Đây là nơi bạn có thể đăng ký các route cho ứng dụng của mình.
|
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Middleware guest - Chặn truy cập /login và /signup nếu đã đăng nhập
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'processSignup'])->name('signup.process');
});

// Đăng xuất - chỉ cho phép khi đã đăng nhập
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Xác thực OTP
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.process');

// Quên mật khẩu
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Quản lý admin (chỉ cho admin đã đăng nhập)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/role-upgrade-requests', [AdminDashboardController::class, 'roleUpgradeRequests'])->name('admin.user-role-requests');
    Route::post('/approve-role-upgrade/{approval_id}', [AdminDashboardController::class, 'approveRoleUpgrade'])->name('admin.approve-role-upgrade');
    Route::post('/reject-role-upgrade/{approval_id}', [AdminDashboardController::class, 'rejectRoleUpgrade'])->name('admin.reject-role-upgrade');

    // Quản lý bài viết
    Route::resource('articles', ArticleController::class);
    Route::patch('/articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve');

    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);
});

// Yêu cầu nâng cấp lên tác giả
Route::post('/profile/request-author-role', [ProfileController::class, 'requestAuthorRole'])->name('profile.request-author-role');

// Upload file (cho CKEditor)
Route::post('/upload-file', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        return response()->json([
            'url' => asset('uploads/' . $filename)
        ]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
})->name('upload.file');

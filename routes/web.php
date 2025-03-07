<?php

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\ArticleUserController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\CategoryUserController;

use App\Http\Controllers\Writer\WriterDashboard;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Client\UserProfileController;

use App\Http\Controllers\Moderator\UserManagementController;
use App\Http\Controllers\Moderator\ModeratorArticleController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');



// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/role-upgrade-requests', [AdminDashboardController::class, 'roleUpgradeRequests'])->name('admin.user-role-requests');
    Route::post('/admin/approve-role-upgrade/{approval_id}', [AdminDashboardController::class, 'approveRoleUpgrade'])->name('admin.approve-role-upgrade');
    Route::post('/admin/reject-role-upgrade/{approval_id}', [AdminDashboardController::class, 'rejectRoleUpgrade'])->name('admin.reject-role-upgrade');
});

// Article
Route::prefix('admin')->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Category
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'processSignup'])->name('signup.process');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Client Articles
Route::get('/client/articles/{article_id}', [ArticleUserController::class, 'show'])->name('client.articles.article');
Route::post('/client/articles/{article_id}/like', [ArticleUserController::class, 'likeArticle'])->name('client.articles.like');
Route::post('/client/articles/{article_id}/comments', [ArticleUserController::class, 'storeComment'])->middleware('auth')->name('client.articles.comment');
Route::post('/client/articles/{article_id}/comments/{comment_id}/reply', [ArticleUserController::class, 'storeReplyComment'])->middleware('auth')->name('client.articles.replyComment');

// Client Category
use App\Http\Controllers\Moderator\ModeratorDashboardController;

Route::get('client/category/{categorySlug}', [CategoryUserController::class, 'index'])->name('client.category.show');


// Author Routes
Route::prefix('author')->middleware(['auth', 'role:author'])->group(function () {
    Route::get('/dashboard', [AuthorDashboard::class, 'index'])->name('author.dashboard');
    Route::resource('articles', \App\Http\Controllers\Author\ArticleController::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('author.profile');
});

// Moderator Routes
Route::middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/moderator/dashboard', [ModeratorDashboardController::class, 'index'])->name('moderator.dashboard');
    Route::get('/moderator/articles', [ModeratorArticleController::class, 'index'])->name('moderator.articles');
    Route::post('/approve-upgrade/{approval_id}', [UserManagementController::class, 'approveUpgrade'])->name('approve.upgrade');
    Route::post('/reject-upgrade/{approval_id}', [UserManagementController::class, 'rejectUpgrade'])->name('reject.upgrade');
});

// Writer
Route::get('/writer/dashboard', [WriterDashboard::class, 'index'])->name('writer.dashboard');

// Upload File
Route::post('/upload-file', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        return response()->json(['url' => asset('uploads/' . $filename)]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
})->name('upload.file');
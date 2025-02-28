<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
<<<<<<< HEAD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\Author\AuthorDashboard;
use Illuminate\Support\Facades\Route;

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

// client
Route::get('/', function () {
    return view('welcome');
});
Route::get('/article-detail', function () {
    return view('website.pages.articledetail.homedetail');
});
// admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');
Route::get(
    '/admin/role-upgrade-requests',
    [AdminDashboardController::class, 'roleUpgradeRequests']
)
    ->name('admin.user-role-requests');
Route::post(
    '/admin/approve-role-upgrade/{approval_id}',
    [AdminDashboardController::class, 'approveRoleUpgrade']
)
    ->name('admin.approve-role-upgrade');
Route::post('/admin/reject-role-upgrade/{approval_id}', [AdminDashboardController::class, 'rejectRoleUpgrade'])
    ->name('admin.reject-role-upgrade');


// article
Route::patch(
    '/articles/{article}/approve',
    [ArticleController::class, 'approve']
)->name('articles.approve');
Route::prefix('admin')->group(function () {
=======
use App\Http\Controllers\ArticleUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\Author\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\UserProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
use App\Http\Controllers\Moderator\UserManagementController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ------------------------- Guest Routes (Login, Signup, Forgot Password) -------------------------
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

// Đăng xuất - chỉ cho phép khi đã đăng nhập
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ------------------------- Admin Routes -------------------------
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/role-upgrade-requests', [AdminDashboardController::class, 'roleUpgradeRequests'])->name('admin.user-role-requests');
    Route::post('/approve-role-upgrade/{approval_id}', [AdminDashboardController::class, 'approveRoleUpgrade'])->name('admin.approve-role-upgrade');
    Route::post('/reject-role-upgrade/{approval_id}', [AdminDashboardController::class, 'rejectRoleUpgrade'])->name('admin.reject-role-upgrade');

    // Quản lý bài viết
>>>>>>> tungkeng
    Route::resource('articles', ArticleController::class);

<<<<<<< HEAD


// category
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Routes for login and signup
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])
    ->name('signup');
Route::post('/signup', [AuthController::class, 'processSignup'])
    ->name('signup.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])
    ->name('otp.verify.form');
// Route xử lý OTP
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('otp.verify.process');



// Route login admin chinh lai
Route::get('/login-admin', [AuthAdminController::class, 'showLoginAdminForm'])
    ->name('loginadmin');

Route::get('/signup-admin', [AuthAdminController::class, 'showSignupAdminForm'])
    ->name('signupadmin');

Route::get('/forget-admin', [AuthAdminController::class, 'showForgetAdminForm'])
    ->name('forgetadmin');


//////////////////////////

// Route login user chinh lai
Route::get('/login-user', [AuthUserController::class, 'showLoginUserForm'])
    ->name('loginuser');

Route::get('/signup-user', [AuthUserController::class, 'showSignupUserForm'])
    ->name('signupuser');

Route::get('/forget-user', [AuthUserController::class, 'showForgetUserForm'])
    ->name('forgetuser');


// //////////////////////////






// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )
        ->name('admin.dashboard');
});

// Hiển thị form nhập email để lấy lại mật khẩu
Route::get(
    '/forgot-password',
    [ForgotPasswordController::class, 'showLinkRequestForm']
)
    ->name('password.request');

// Xử lý gửi email đặt lại mật khẩu
Route::post(
    '/forgot-password',
    [ForgotPasswordController::class, 'sendResetLinkEmail']
)
    ->name('password.email');

// Hiển thị form nhập mật khẩu mới

Route::get(
    '/reset-password/{token}',
    [ForgotPasswordController::class, 'showResetForm']
)
    ->name('password.reset');

// Xử lý cập nhật mật khẩu mới
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

Route::post(
    '/profile/request-author-role',
    [ProfileController::class, 'requestAuthorRole']
)
    ->name('profile.request-author-role');

// Author
  // Author routes
  Route::prefix('author')
//   ->middleware(['auth', 'role:author'])
  ->group(function () {
      Route::get('/dashboard', [AuthorDashboard::class, 'index'])
          ->name('author.dashboard');

      Route::controller(\App\Http\Controllers\Author\ArticleController::class)
          ->group(function () {
              Route::get('/articles', 'index')->name('author.articles');
              Route::get('/articles/create', 'create')
                  ->name('author.articles.create');
              Route::post('/articles', 'store')
                  ->name('author.articles.store');
              Route::get('/articles/{article}', 'show')
                  ->name('author.articles.show');
              Route::get('/articles/{article}/edit', 'edit')
                  ->name('author.articles.edit');
              Route::put('/articles/{article}', 'update')
                  ->name('author.articles.update');
              Route::delete('/articles/{article}', 'destroy')
                  ->name('author.articles.destroy');
          });

      Route::get('/profile', [ProfileController::class, 'index'])
          ->name('author.profile');
  });
=======
    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);

    // Quản lý người dùng
    Route::resource('users', UserController::class);
});

// ------------------------- Moderator Routes -------------------------
Route::prefix('moderator')->middleware(['auth', 'role:moderator'])->group(function () {
    Route::get('/dashboard', [ModeratorDashboardController::class, 'index'])->name('moderator.dashboard');

    Route::get('/approvals', [UserManagementController::class, 'index'])->name('moderator.approvals.index');
    Route::get('/approvals/{id}', [UserManagementController::class, 'show'])->name('moderator.approvals.show');
    Route::post('/approvals/{id}/approve', [UserManagementController::class, 'approve'])->name('moderator.approvals.approve');
    Route::post('/approvals/{id}/reject', [UserManagementController::class, 'reject'])->name('moderator.approvals.reject');

    Route::get('/articles', [ModeratorArticleController::class, 'index'])->name('moderator.articles');
});

// ------------------------- Author Routes -------------------------
Route::prefix('author')->middleware(['auth', 'role:author'])->group(function () {
    Route::get('/dashboard', [AuthorDashboard::class, 'index'])->name('author.dashboard');

    // Quản lý bài viết của tác giả
    Route::resource('articles', \App\Http\Controllers\Author\ArticleController::class);

    // Trang cá nhân của tác giả
    Route::get('/profile', [ProfileController::class, 'index'])->name('author.profile');
});

// ------------------------- User Routes -------------------------
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserProfileController::class, 'index'])->name('user.dashboard');
    Route::post('/upgrade-to-author', [UserProfileController::class, 'requestAuthorRole'])->name('upgrade.to.author');
});

// ------------------------- Public Routes -------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/client/articles/{article_id}', [ArticleUserController::class, 'show'])->name('client.articles.article');

// ------------------------- File Upload Route -------------------------
Route::post('/upload-file', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        return response()->json([
            'url' => asset('uploads/' . $filename),
        ]);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
})->name('upload.file');
>>>>>>> tungkeng

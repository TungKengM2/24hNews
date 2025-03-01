<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
<<<<<<< HEAD
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
=======
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 🌟 Giao diện trang chủ + bài viết
Route::get('/', function () {
    return view('welcome');
});

// 🌟 Giao diện chi tiết bài viết

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/client/articles/{article_id}', [ArticleUserController::class, 'show'])->name('client.articles.article');
Route::post('/client/articles/{article_id}/like', [ArticleUserController::class, 'likeArticle'])->name('client.articles.like');
Route::post('/client/articles/{article_id}/comments', [ArticleUserController::class, 'storeComment'])->name('client.articles.comment');

Route::get('/article-detail', function () {
    return view('website.pages.articledetail.homedetail');
});

// client
Route::get('/', function () {
    return view('welcome');
});
Route::get('/article-detail', function () {
    return view('website.pages.articledetail.homedetail');
});
// admin
// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// });
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
    Route::resource('articles', ArticleController::class);
});


// category
Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459
});

// User
Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});

// Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get(
//         '/admin/dashboard',
//         [AdminDashboardController::class, 'index']
//     )
//         ->name('admin.dashboard');
// });


// moderator kiểm duyệt viên
Route::get('/moderator/dashboard', [ModeratorDashboardController::class, 'index'])
    ->name('moderator.dashboard');

Route::get('/moderator/list-article', [ModeratorArticleController::class, 'index'])
    ->name('moderator.list-article');

Route::get('/moderator-profile-setting', function () {
    return view("moderator.profile-setting");
})->name('moderator.profile-setting');

Route::get('/moderator-profile', function () {
    return view("moderator.profile");
})->name('moderator.profile');


//Route author dashborad
Route::get('/author/dashboard', function () {
    return view("author.dashboard");
});

Route::get('/author-profile-setting', function () {
    return view("author.profile-setting");
})->name('author.profile-setting');

Route::get('/author-profile', function () {
    return view("author.profile");
})->name('author.profile');

//Route User dashboard
Route::get('/user/dasboard', function () {
    return view("user.dashboard");
});
Route::get('/user-profile', function () {
    return view("user.user-setting");
})->name('user.profile');

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

<<<<<<< HEAD
// ------------------------- Moderator Routes -------------------------
Route::prefix('moderator')->middleware(['auth', 'role:moderator'])->group(function () {
=======
// 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function () {
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459
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


<<<<<<< HEAD
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
=======
Route::post('/logout', [AuthUserController::class, 'logout'])->name('logout');
>>>>>>> 4f4bd7cc0ce4f018506921aec4238874f7978459

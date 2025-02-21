<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\ArticleUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\Author\UserManagement;
use App\Http\Controllers\Writer\ArticleAuthorManagement;
use App\Http\Controllers\Writer\WriterDashboard;
use App\Http\Controllers\Writer\WriterAuthorManagement;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
use App\Http\Controllers\Moderator\UserManagementController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\Client\UserProfileController;
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

//Routes for login and admin
Route::get('/admin/login', [AuthAdminController::class, 'showLoginAdminForm'])->name('authadmin.login-admin');
Route::post('/admin/login', [AuthAdminController::class, 'loginadmin'])->name('admin.login.submit');




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
    use App\Http\Controllers\AdminDashboardController;
    use App\Http\Controllers\ArticleController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\Author\AuthorDashboard;
    use App\Http\Controllers\Author\ProfileController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\Client\UserProfileController;
    use App\Http\Controllers\ForgotPasswordController;
    use App\Http\Controllers\Moderator\ModeratorDashboardController;
    use App\Http\Controllers\Moderator\UserManagementController;
    use App\Http\Controllers\Writer\WriterDashboard;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;

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
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin/role-upgrade-requests',
        [AdminDashboardController::class, 'roleUpgradeRequests'])
        ->name('admin.user-role-requests');
    Route::post('/admin/approve-role-upgrade/{approval_id}',
        [AdminDashboardController::class, 'approveRoleUpgrade'])
        ->name('admin.approve-role-upgrade');
    Route::post('/admin/reject-role-upgrade/{approval_id}',
        [AdminDashboardController::class, 'rejectRoleUpgrade'])
        ->name('admin.reject-role-upgrade');

    // article
    Route::patch('/articles/{article}/approve',
        [ArticleController::class, 'approve'])->name('articles.approve');
    Route::prefix('admin')->group(function () {
        Route::resource('articles', ArticleController::class);
    });

    // category
    Route::prefix('admin')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    // Middleware guest - Chặn truy cập /login và /signup nếu đã đăng nhập
    Route::middleware('guest')->group(function () {
        // Đăng nhập & Đăng ký
        Route::get('/login', [AuthController::class, 'showLoginForm'])
            ->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/signup', [AuthController::class, 'showSignupForm'])
            ->name('signup');
        Route::post('/signup', [AuthController::class, 'processSignup'])
            ->name('signup.process');

        // Quên mật khẩu
        Route::get('/forgot-password',
            [ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('/forgot-password',
            [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');
        Route::get('/reset-password/{token}',
            [ForgotPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('/reset-password',
            [ForgotPasswordController::class, 'reset'])
            ->name('password.update');
    });

// author
Route::get('/moderator/dashboard', [ModeratorDashboardController::class, 'index'])->name('author.dashboard');
Route::get('/moderator/users', [UserManagementController::class, 'index'])->name('author.users');
Route::get('/moderator/articles', [ModeratorArticleController::class, 'index'])->name('author.articles');

// writer
Route::get('/writer/dashboard', [WriterDashboard::class, 'index'])->name('writer.dashboard');
Route::get('/writer/articleauthor', [ArticleAuthorManagement::class, 'index'])->name('writer.articleauthor');
Route::get('/writer/author', [WriterAuthorManagement::class, 'index'])->name('writer.author');

// router user
Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    // Đăng xuất - chỉ cho phép khi đã đăng nhập
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');

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

    // Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard',
            [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

    // Hiển thị form nhập email để lấy lại mật khẩu
    Route::get('/forgot-password',
        [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // Xử lý gửi email đặt lại mật khẩu
    Route::post('/forgot-password',
        [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // Hiển thị form nhập mật khẩu mới
    Route::get('/reset-password/{token}',
        [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    // Xử lý cập nhật mật khẩu mới
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');

    // //////////////////////////test//////////////////////////////
    Route::get('/writer/dashboard', [WriterDashboard::class, 'index'])
        ->name('writer.dashboard');

    Route::get('/moderator/dashboard',
        [ModeratorDashboardController::class, 'index'])
        ->name('moderator.dashboard');

    Route::get('/user/dashboard', [UserProfileController::class, 'index'])
        ->name('user.dashboard');
    Route::post('/upgrade-to-author',
        [UserProfileController::class, 'requestAuthorRole'])
        ->middleware('auth')
        ->name('upgrade.to.author');
    //    Route::post('/profile/request-author-role', [ProfileController::class, 'requestAuthorRole'])->name('profile.request-author-role');

    Route::get('/author/dashboard', [AuthorDashboard::class, 'index'])
        ->name('author.dashboard');
    // //////////////////////////////////////////////////////////////////

    Route::prefix('author')
        ->middleware(['auth', 'role:author'])
        ->group(function () {
            Route::get('/dashboard', [AuthorDashboard::class, 'index'])
                ->name('author.dashboard');
            Route::get('/articles', [
                \App\Http\Controllers\Author\ArticleController::class,
                'index',
            ])->name('author.articles');
            Route::get('/articles/create', [
                \App\Http\Controllers\Author\ArticleController::class,
                'create',
            ])->name('author.articles.create');
            Route::post('/articles', [
                \App\Http\Controllers\Author\ArticleController::class,
                'store',
            ])->name('author.articles.store');
            Route::post('/articles',
                [\App\Http\Controllers\Author\ArticleController::class, 'edit'])
                ->name('author.articles.edit');
            Route::post('/articles', [
                \App\Http\Controllers\Author\ArticleController::class,
                'update',
            ])->name('author.articles.update');
            Route::post('/articles', [
                \App\Http\Controllers\Author\ArticleController::class,
                'destroy',
            ])->name('author.articles.destroy');

            Route::get('/profile', [
                ProfileController::class,
                'index',
            ])->name('author.profile');
        });

    Route::post('/approve-upgrade/{approval_id}',
        [UserManagementController::class, 'approveUpgrade'])
        ->middleware('moderator')
        ->name('approve.upgrade');

    Route::post('/reject-upgrade/{approval_id}',
        [UserManagementController::class, 'rejectUpgrade'])
        ->middleware('moderator')
        ->name('reject.upgrade');

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

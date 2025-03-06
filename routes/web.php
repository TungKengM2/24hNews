<?php

    use App\Http\Controllers\Admin\AdminDashboardController;
    use App\Http\Controllers\Admin\ArticleController;
    use App\Http\Controllers\Admin\UploadController;
    use App\Http\Controllers\AuthAdminController;
    use App\Http\Controllers\Author\AuthorController;
    use App\Http\Controllers\Author\AuthorDashboard;
    use App\Http\Controllers\Author\AuthorProfileController;
    use App\Http\Controllers\AuthUserController;
    use App\Http\Controllers\Admin\CategoryController;
    use App\Http\Controllers\ForgotPasswordController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\Moderator\ModeratorDashboardController;
    use App\Http\Controllers\Moderator\ModeratorArticleController;
    use App\Http\Controllers\Admin\UserController;
    use Illuminate\Support\Facades\Route;

    // 🌟 Giao diện trang chủ + bài viết
    Route::get('/', function () {
        return view('welcome');
    });

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
    Route::post('/admin/reject-role-upgrade/{approval_id}',
        [AdminDashboardController::class, 'rejectRoleUpgrade'])
        ->name('admin.reject-role-upgrade');

    // approves
    Route::get('/admin/articles/approves',
        [ArticleController::class, 'Approves'])
        ->name('admin.articles.approves');

    // article
    // Route::patch(
    //     '/articles/{article}/approve',
    //     [AdminArticleController::class, 'approve']
    // )->name('articles.approve');

    Route::prefix('admin')->group(function () {
        Route::resource('articles', ArticleController::class);
    });

    // UploadImage
    Route::post('/upload/image', [UploadController::class, 'store'])
        ->name('upload.image');

    // category
    Route::prefix('admin')->group(function () {
        Route::resource('categories', CategoryController::class);
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
    Route::get('/moderator/dashboard',
        [ModeratorDashboardController::class, 'index'])
        ->name('moderator.dashboard');

    Route::get('/moderator/list-article',
        [ModeratorArticleController::class, 'index'])
        ->name('moderator.list-article');

    Route::get('/moderator-profile-setting', function () {
        return view("moderator.profile-setting");
    })->name('moderator.profile-setting');

    Route::get('/moderator-profile', function () {
        return view("moderator.profile");
    })->name('moderator.profile');

    //Route author
    Route::middleware(['auth', 'role:2'])->prefix('author')->group(function () {
        Route::get('/dashboard', [AuthorDashboard::class, 'index'])
            ->name('author.dashboard');

        Route::get('/profile-setting', function () {
            return view('author.profile-setting');
        })->name('author.profile-setting');

        Route::get('/profile', [AuthorProfileController::class, 'index'])
            ->name('author.profile');
        Route::put('/profile',
            [AuthorProfileController::class, 'update'])
            ->name('author.profile.update');

        Route::resource('articles',
            \App\Http\Controllers\Author\ArticleController::class)
            ->names('author.articles');

        Route::post('/articles/upload', [
            \App\Http\Controllers\Author\ArticleController::class,
            'uploadImage',
        ])
            ->name('author.articles.upload');

        Route::get('/articles/search',
            [\App\Http\Controllers\Author\ArticleController::class, 'search'])
            ->name('author.articles.search');
    });

    //Route User dashboard
    Route::get('/user/dasboard', function () {
        return view("user.dashboard");
    });
    Route::get('/user-profile', function () {
        return view("user.user-setting");
    })->name('user.profile');

    // 🌟 Routes dành cho User (AuthUserController)
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

    // 🚀 Khu vực dành riêng cho User (role_id = 4)
    Route::middleware(['auth', 'role:4'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');

        // Yêu cầu nâng cấp vai trò lên Author
        Route::post('/profile/request-author-role',
            [ProfileController::class, 'requestAuthorRole'])
            ->name('profile.request-author-role');
    });

    // 🌟 Routes dành cho Admin (AuthAdminController)
    Route::middleware('guest')
        ->controller(AuthAdminController::class)
        ->group(function () {
            Route::get('/login-admin', 'showLoginAdminForm')
                ->name('loginadmin');
            Route::post('/login-admin', 'login')->name('loginadmin.process');
            Route::get('/forget-admin', 'showForgetAdminForm')
                ->name('forgetadmin');
        });

    // 🚀 Khu vực dành riêng cho Admin (role_id = 1)
    Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
        Route::get('/role-upgrade-requests',
            [AdminDashboardController::class, 'roleUpgradeRequests'])
            ->name('admin.user-role-requests');
        Route::post('/approve-role-upgrade/{approval_id}',
            [AdminDashboardController::class, 'approveRoleUpgrade'])
            ->name('admin.approve-role-upgrade');
        Route::post('/reject-role-upgrade/{approval_id}',
            [AdminDashboardController::class, 'rejectRoleUpgrade'])
            ->name('admin.reject-role-upgrade');

        // Quản lý bài viết
        Route::patch('/articles/{article}/approve',
            [ArticleController::class, 'approve'])->name('articles.approve');
        Route::resource('articles', ArticleController::class);

        // Quản lý danh mục
        Route::resource('categories', CategoryController::class);
    });

    // 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
    Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function (
    ) {
        Route::get('/dashboard', [ModeratorDashboardController::class, 'index'])
            ->name('moderator.dashboard');
        Route::get('/list-article',
            [ModeratorArticleController::class, 'index'])
            ->name('moderator.list-article');
    });

    // 🔹 Quên mật khẩu chung
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')
            ->name('password.request');
        Route::post('/forgot-password', 'sendResetLinkEmail')
            ->name('password.email');
        Route::get('/reset-password/{token}', 'showResetForm')
            ->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });

    Route::post('/logout', [AuthUserController::class, 'logout'])
        ->name('logout');

<?php

    use App\Http\Controllers\AdminDashboardController;
    use App\Http\Controllers\ArticleController;
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

    // Public routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/client/articles/{article_id}',
        [ArticleUserController::class, 'show'])
        ->name('client.articles.article');

    // Authentication routes
    Route::middleware('guest')->group(function () {
        // Login
        Route::controller(AuthController::class)->group(function () {
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login');
            Route::get('/signup', 'showSignupForm')->name('signup');
            Route::post('/signup', 'processSignup')->name('signup.process');
            Route::get('/verify-otp', 'showOtpForm')->name('otp.verify.form');
            Route::post('/verify-otp', 'verifyOtp')->name('otp.verify.process');
        });

        // Password reset
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('/forgot-password', 'showLinkRequestForm')
                ->name('password.request');
            Route::post('/forgot-password', 'sendResetLinkEmail')
                ->name('password.email');
            Route::get('/reset-password/{token}', 'showResetForm')
                ->name('password.reset');
            Route::post('/reset-password', 'reset')->name('password.update');
        });
    });

    // Authenticated routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

    // Admin routes
    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin.dashboard');
            Route::get('/role-upgrade-requests', 'roleUpgradeRequests')
                ->name('admin.user-role-requests');
            Route::post('/approve-role-upgrade/{approval_id}',
                'approveRoleUpgrade')->name('admin.approve-role-upgrade');
            Route::post('/reject-role-upgrade/{approval_id}',
                'rejectRoleUpgrade')->name('admin.reject-role-upgrade');
        });

        Route::resource('articles', ArticleController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
    });

    // Moderator routes
    Route::prefix('moderator')
        ->middleware(['auth', 'role:moderator'])
        ->group(function () {
            Route::get('/dashboard',
                [ModeratorDashboardController::class, 'index'])
                ->name('moderator.dashboard');
            Route::get('/articles',
                [ModeratorArticleController::class, 'index'])
                ->name('moderator.articles');

            Route::controller(UserManagementController::class)->group(function (
            ) {
                Route::get('/approvals', 'index')
                    ->name('moderator.approvals.index');
                Route::get('/approvals/{id}', 'show')
                    ->name('moderator.approvals.show');
                Route::post('/approvals/{id}/approve', 'approve')
                    ->name('moderator.approvals.approve');
                Route::post('/approvals/{id}/reject', 'reject')
                    ->name('moderator.approvals.reject');
            });
        });

    // Author routes
    Route::prefix('author')
        ->middleware(['auth', 'role:author'])
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

    // User dashboard
    Route::middleware('auth')->prefix('user')->group(function () {
        Route::controller(UserProfileController::class)->group(function () {
            Route::get('/dashboard', 'index')
                ->name('user.dashboard');

            Route::post('/upgrade-to-author',
                'requestAuthorRole')
                ->name('user.upgrade');
        });
    });

    // File upload
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

<?php

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ArticleUserController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Author\AuthorDashboard;
use App\Http\Controllers\CategoryUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\User\ArticleTagController;
use App\Http\Controllers\Admin\ViolationsController;
use App\Http\Controllers\User\ArticleSaveController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Moderator\ModeratorController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\Author\TinyMCEUploadController;
use App\Http\Controllers\User\ArticleViewUserController;
use App\Http\Controllers\Moderator\ViolationsMController;
use App\Http\Controllers\Admin\ArticleViewAdminController;
use App\Http\Controllers\Author\ImageModerationController;
use App\Http\Controllers\Author\ArticleViewAuthorController;
use App\Http\Controllers\Moderator\ModeratorArticleController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\Moderator\ModeratorDashboardController;
use App\Http\Controllers\Author\ArticleController as AuthorArticleController;
use App\Http\Controllers\Admin\ArticleSaveController as AdminArticleSaveController;
use App\Http\Controllers\Author\ArticleSaveController as AuthorArticleSaveController;
use App\Http\Controllers\Moderator\ArticleSaveController as ModeratorArticleSaveController;

use App\Http\Controllers\Profile\AuthorProfileController as ProfileAuthorProfileController;

use App\Http\Controllers\Moderator\ArticleViewModeratorController as ModeratorArticleViewModeratorController;


// 🌟 Trang chủ & bài viết chi tiết

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
// dat them




// profile trang chủ dat them

// // User Profile
// Route::get('/profiles/user/{id}', [ProfileAuthorProfileController::class, 'showUser'])->name('website.profileUser')->middleware('auth');

// Author Profile
Route::get('/profiles/author/{id}', [ProfileAuthorProfileController::class, 'showAuth'])->name('website.profileAuth')->middleware('auth');

Route::post('/user/{user}/follow', [ProfileAuthorProfileController::class, 'follow'])->name('user.follow');

Route::post('/user/{user}/unfollow', [ProfileAuthorProfileController::class, 'unfollow'])->name('user.unfollow');



// Client Articles
Route::middleware('auth')->group(function () {
    Route::get('/articles/{slug}', [ArticleUserController::class, 'show'])->name('articles.article');
    Route::post('/articles/{article_id}/like', [ArticleUserController::class, 'likeArticle'])->name('articles.like');
    Route::post('/articles/{article_id}/comments', [ArticleUserController::class, 'storeComment'])->name('articles.comment');
    Route::post('/articles/{article_id}/comments/{comment_id}/reply', [ArticleUserController::class, 'storeReplyComment'])->name('articles.replyComment');
    Route::post('/articles/{article_id}/report', [ArticleUserController::class, 'reportArticle']);
    Route::post('/articles/{article_id}/comments/{comment_id}/report', [ArticleUserController::class, 'reportComment']);
    Route::delete('/comments/{comment}', [ArticleUserController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/like', [ArticleUserController::class, 'toggleLike'])->name('comments.toggleLike');

});
// Client Category
Route::get('/category/{category_id}', [CategoryUserController::class, 'index'])->name('client.category.show');
Route::get('/tags/{tag}', [ArticleTagController::class, 'index'])->name('tags.show');




// 🚀 Auth dành cho User

Route::middleware('guest')
    ->controller(AuthUserController::class)
    ->group(function () {
        Route::get('/login-user', 'showLoginUserForm')->name('loginuser');

        Route::post('/login-user', 'login')->name('loginuser.process');

        Route::get('/signup-user', 'showSignupUserForm')->name('signupuser');

        Route::post('/signup-user', 'processSignup')->name('signupuser.process');

        Route::get('/verify-otp', 'showOtpForm')->name('otp.verify.form');

        Route::post('/verify-otp', 'verifyOtp')->name('otp.verify.process');

        Route::get('/forget-user', 'showForgetUserForm')->name('forgetuser');
    });




// 🚀 Auth dành cho Admin

Route::middleware('guest')
    ->controller(AuthAdminController::class)
    ->group(function () {
        Route::get('/login-admin', 'showLoginAdminForm')->name('loginadmin');

        Route::post('/login-admin', 'login')->name('loginadmin.process');

        Route::get('/forget-admin', 'showForgetAdminForm')->name('forgetadmin');

        Route::post('/forget-admin', 'processForgetAdmin')->name('forgetadmin.process');
    });

// 🔐 Quên mật khẩu chung
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');

    Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');

    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');

    Route::post('/reset-password', 'reset')->name('password.update');
});

// 🚀 Profile dùng chung
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // Route::get(
    //     '/profile/change-password',
    //     [ProfileController::class, 'showChangePasswordForm']
    // )->name('profile.change-password');

    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
});



// 🚀 Cài đặt profile riêng theo vai trò
Route::middleware(['auth', 'role:4'])->get('/user/profile-setting', function () {
    return view('user.profile-setting');
})
    ->name('user.profile-setting');

Route::middleware(['auth', 'role:3'])->get('/moderator/profile-setting', function () {
    return view('moderator.profile-setting');
})
    ->name('moderator.profile-setting');

Route::middleware(['auth', 'role:3'])->get('/moderator/profile', function () {
    return view('moderator.profile');
})
    ->name('moderator.profile');

// moderator thống kê
Route::middleware(['auth', 'role:3'])->get('/moderator/dashboard', [ModeratorDashboardController::class, 'index'])
    ->name('moderator.dashboard');




// 🚀 Khu vực dành riêng cho Moderator (role_id = 3)
Route::middleware(['auth', 'role:3'])->prefix('moderator')->group(function () {


    //Quản lý report
    Route::get('/violations/approves', [ViolationsMController::class, 'approves'])->name('moderator.violations.approves');

    Route::patch('violations/{violation}/resolve', [ViolationsMController::class, 'resolve'])->name('moderator.violations.resolve');

    Route::patch('violations/{violation}/resolves', [ViolationsMController::class, 'resolves'])->name('moderator.violations.resolves');

    Route::patch('violations/{violation}/reject', [ViolationsMController::class, 'reject'])->name('moderator.violations.reject');


    Route::get('/list-article', [ModeratorArticleController::class, 'index'])
        ->name('moderator.list-article');

    Route::get('/profile', [ProfileController::class, 'profileModerator'])
        ->name('moderator.profile');

    Route::get('/following', [ProfileController::class, 'followingOfModeratorList'])->name('moderator.following');

    Route::get('/change-password', [ProfileController::class, 'showChangePasswordFormModerator'])->name('moderator.change-password');

    Route::get('/articles', [ModeratorArticleController::class, 'index'])->name('moderator.articles.index');

    Route::get('/articles/{article}', [ModeratorArticleController::class, 'show'])->name('moderator.articles.show');

    Route::patch('/articles/{article}/approve', [ModeratorArticleController::class, 'approve'])->name('moderator.articles.approve');


    Route::get('/moderator/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'moderator'])
    ->name('moderator.notifications');

    // Sửa lại route reject (bỏ 'moderator/' trong URL)
    Route::patch('/articles/{article}/reject', [ModeratorArticleController::class, 'reject'])->name('moderator.articles.reject');


    // Bookmark By TungKeng
    Route::post('/save-article', [ModeratorArticleSaveController::class, 'saveArticle'])->name('save.article');

    Route::get('/saved-articles', [ModeratorArticleSaveController::class, 'savedArticles'])->name('moderator.saved');

    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('moderator.article.detail');

    Route::delete('/user/remove-saved-article/{id}', [ModeratorArticleSaveController::class, 'removeSavedArticle'])->name('moderator.remove.saved');

    Route::post('/bookmark/{article_id}', [ModeratorArticleSaveController::class, 'toggleBookmark']);



    // Lịch sử bài viết đã xem của moderator
    Route::get('/viewed-articles', [ModeratorArticleViewModeratorController::class, 'index'])->name('moderator.viewed.articles');



    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [ModeratorController::class, 'getUserComments'])->name('moderator.comments');
});

// Đặt trong nhóm auth middleware
Route::middleware(['auth'])->group(function () {
    // ... các route khác ...

    // Notification Routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::get('/unread-count', [NotificationController::class, 'countUnread'])->name('notifications.unreadCount');
    });
});

// Route::prefix('moderator')->name('moderator.')->group(function () {
//     Route::get('/articles', [ModeratorArticleController::class, 'index'])
//         ->name('articles.index');

//     Route::get('/articles/{article}', [ModeratorArticleController::class, 'show'])
//         ->name('articles.show');

//     Route::patch('/articles/{article}/approve', [ModeratorArticleController::class, 'approve'])
//         ->name('articles.approve');

//     // Sửa lại route reject (bỏ 'moderator/' trong URL)
//     Route::patch('/articles/{article}/reject', [ModeratorArticleController::class, 'reject'])
//         ->name('articles.reject');
// });




// 🚀 Khu vực dành riêng cho Author (role_id = 2)
Route::middleware(['auth', 'role:2'])->prefix('author')->group(function () {

    Route::get('/dashboard', [AuthorDashboard::class, 'index'])->name('author.dashboard');

    Route::get('/profile-setting', function () {
        return view('author.profile-setting');
    })->name('author.profile-setting');

    Route::get('/profile', [AuthorProfileController::class, 'index'])->name('author.profile');

    Route::put('/profile', [AuthorProfileController::class, 'update'])->name('author.profile.update');

    Route::get('/following', [ProfileController::class, 'followingOfAuthorList'])->name('author.following');

    Route::resource('articles', AuthorArticleController::class)->names('author.articles');

    Route::put('/articles/{article}/toggle-visibility', [AuthorArticleController::class, 'toggleVisibility'])
    ->name('author.articles.toggle-visibility');

    Route::post('/articles/upload', [AuthorArticleController::class, 'uploadImage',])->name('author.articles.upload');

    Route::get('/articles/search', [AuthorArticleController::class, 'search'])->name('author.articles.search');

    Route::get('/profile', [ProfileController::class, 'profileAuthor'])->name('author.profile');

    Route::get('/change-password', [ProfileController::class, 'showChangePasswordFormAuthor'])->name('author.change-password');

    Route::post('moderate-image', [ImageModerationController::class, 'moderateImage']);

    Route::get('test-moderation', [ImageModerationController::class, 'testModeration']);


    // xóa thông báo khi đã đọc

    // Route::post('/notifications/{id}/read', function ($id, User $user): JsonResponse {
    //     $notification = $user->notifications()->find($id);



    // Bookmark By TungKeng
    Route::post('/save-article', [AuthorArticleSaveController::class, 'saveArticle'])->name('save.article');

    Route::get('/saved-articles', [AuthorArticleSaveController::class, 'savedArticles'])->name('author.saved');

    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('author.article.detail');

    Route::delete('/user/remove-saved-article/{id}', [AuthorArticleSaveController::class, 'removeSavedArticle'])->name('author.remove.saved');

    Route::post('/bookmark/{article_id}', [AuthorArticleSaveController::class, 'toggleBookmark']);



    // Lịch sử bài viết đã xem của author
    Route::get('/viewed-articles', [ArticleViewAuthorController::class, 'index'])->name('author.viewed.articles');


    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [AuthorController::class, 'getUserComments'])->name('author.comments');


    //     if ($notification) {
    //         $notification->markAsRead();
    //         return response()->json([
    //             'success' => true,
    //             'unreadCount' => $user->unreadNotifications()->count()
    //         ]);
    //     }

    //     return response()->json(['success' => false], 404);
    // })->middleware('auth');

    Route::get('/author/followers', [AuthorDashboard::class, 'followers'])->name('author.followers');

    Route::get('/articles/{article}/versions', [AuthorArticleController::class, 'versions'])->name('author.articles.versions');
    Route::get('/articles/{article}/versions/{versionId}', [AuthorArticleController::class, 'showVersion'])->name('author.articles.version');
});


Route::post('/notifications/{id}/read', function ($id) {
    $notification = User::find(auth()->id())
        ->unreadNotifications()
        ->find($id);

    if ($notification) {
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
});


Route::post('/notifications/clear', function () {
    Auth::User()->unreadNotifications->markAsRead();

    return response()->json(['success' => true]);
});




// 🚀 Khu vực dành riêng cho User (role_id = 4)
Route::middleware(['auth', 'role:4'])->prefix('/user')->group(function () {

    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('user.dashboard');


    // Yêu cầu nâng cấp vai trò lên Author
    Route::get('/upgrade', function () {
        return view('user.upgrade');
    })
        ->name('user.upgrade');

    Route::get('/upgrade-result', function () {
        return view('user.upgrade-result');
    })
        ->name('user.upgrade.result');

    Route::post('/upgrade', [ProfileController::class, 'requestAuthorRole'])->name('user.upgrade.author');

    Route::get('/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('user.change-password');

    Route::get('/following', [ProfileController::class, 'followingList'])->name('user.following');

    // Route::post('/articles/view', [ArticleViewUserController::class, 'store']);
    // Route::get('/articles/viewed', [ArticleViewUserController::class, 'index']);

    // Bookmark By TungKeng
    Route::post('/save-article', [ArticleSaveController::class, 'saveArticle'])->name('save.article');

    Route::get('/saved-articles', [ArticleSaveController::class, 'savedArticles'])->name('user.saved');

    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('article.detail');

    Route::delete('/user/remove-saved-article/{id}', [ArticleSaveController::class, 'removeSavedArticle'])->name('user.remove.saved');

    Route::post('/bookmark/{article_id}', [ArticleSaveController::class, 'toggleBookmark']);



    // Lịch sử bài viết đã xem của user
    Route::get('/viewed-articles', [ArticleViewUserController::class, 'index'])->name('viewed.articles');



    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [UserUserController::class, 'getUserComments'])->name('user.comments');
});



// Khu vực dùng cho BookMark By TungKeng

Route::middleware(['auth'])->group(function () {
    Route::post('/save-article', [ArticleSaveController::class, 'saveArticle'])->name('save.article');
});




// 🚀 Khu vực dành riêng cho Admin (role_id = 1)

Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    // 🏠 Admin Dashboard - Thay đổi route này để gọi đến AdminController
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])
        ->name('admin.dashboard');



    Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');

    Route::get('/following', [ProfileController::class, 'followingOfAdminList'])->name('admin.following');

    // Bookmark By TungKeng
    Route::post('/save-article', [AdminArticleSaveController::class, 'saveArticle'])->name('save.article');

    Route::get('/saved-articles', [AdminArticleSaveController::class, 'savedArticles'])->name('admin.saved');

    Route::get('/article/{slug}', [ArticleUserController::class, 'show'])->name('admin.article.detail');

    Route::delete('/user/remove-saved-article/{id}', [AdminArticleSaveController::class, 'removeSavedArticle'])->name('admin.remove.saved');

    Route::post('/bookmark/{article_id}', [AdminArticleSaveController::class, 'toggleBookmark']);



    // Lịch sử bài viết đã xem của admin
    Route::get('/viewed-articles', [ArticleViewAdminController::class, 'index'])->name('admin.viewed.articles');


    // Hoạt động bình luận
    Route::get('/{user_id}/comments', [AdminController::class, 'getUserComments'])->name('admin.comments');

    Route::get('/user-stats', [AdminDashboardController::class, 'getUserStats'])->name('admin.userStats');

    Route::get('/article-stats', [AdminDashboardController::class, 'getArticleStats'])->name('admin.articleStats');


    // Quản lý yêu cầu nâng cấp vai trò
    Route::get('/role-upgrade-requests', [UserController::class, 'roleUpgradeRequests'])->name('admin.user-role-requests');

    Route::get('/role-upgrade-requests/{id}', [UserController::class, 'showApprovalDetail'])->name('admin.user-role-request.show');

    Route::post('/admin/approve/{id}', [UserController::class, 'approve'])->name('admin.approve.user');

    Route::delete('/admin/reject/{id}', [UserController::class, 'reject'])->name('admin.reject.user');


    //Quản lý report
    Route::get('/violations/approves', [ViolationsController::class, 'approves'])->name('admin.violations.approves');

    Route::patch('violations/{violation}/resolve', [ViolationsController::class, 'resolve'])->name('violations.resolve');

    Route::patch('violations/{violation}/resolves', [ViolationsController::class, 'resolves'])->name('violations.resolves');

    Route::patch('violations/{violation}/reject', [ViolationsController::class, 'reject'])->name('violations.reject');



    // Quản lý bài viết
    Route::get('/articles/approves', [ArticleController::class, 'Approves'])->name('admin.articles.approves');

    Route::patch('/articles/{article}/approve', [ArticleController::class, 'approve'])->name('articles.approve');

    Route::put('/articles/{article}/toggle-visibility', [ArticleController::class, 'toggleVisibility'])->name('articles.toggle-visibility');

    Route::resource('articles', ArticleController::class);

    Route::patch('/articles/{article}/reject', [ArticleController::class, 'reject'])->name('articles.reject');



    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);



    // Quản lý người dùng
    Route::resource('users', UserController::class)->names(['index' => 'admin.users.index',]);
});



// 📤 Upload hình ảnh
Route::post('/upload/image', [UploadController::class, 'store'])
    ->name('upload.image');



// 🔐 Đăng xuất
Route::post('/logout', [AuthUserController::class, 'logout'])
    ->name('logout');




// 🌍 Đăng nhập với Google & Facebook
Route::get('auth/{provider}', [SocialAuthController::class, 'redirectToProvider']);

Route::get('auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);

Route::post('/author/tinymce/upload', [TinyMCEUploadController::class, 'uploadImage'])->name('author.tinymce.upload');

Route::get('/tinymce/clear-blocked-images', [TinyMCEUploadController::class, 'clearBlockedImages'])->name('author.tinymce.clear-blocked-images');


// TinyMCE routes cho admin
Route::post('/admin/tinymce/upload', [TinyMCEUploadController::class, 'uploadImage'])->name('admin.tinymce.upload');

Route::get('/admin/tinymce/clear-blocked-images', [TinyMCEUploadController::class, 'clearBlockedImages'])->name('admin.tinymce.clear-blocked-images');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
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
Route::get('/admin/post/createpost', [AdminDashboardController::class, 'showCreatePost'])->name('admin.post.createpost');
Route::get('/admin/post/listpost', [AdminDashboardController::class, 'showListPost'])->name('admin.post.listpost');
Route::get('/admin/post/editpost', [AdminDashboardController::class, 'showEditPost'])->name('admin.post.editpost');
// category
Route::get('/admin/categories/listcategories', [AdminDashboardController::class, 'showListCategory'])->name('admin.categories.listcategories');
Route::get('/admin/categories/createcategories', [AdminDashboardController::class, 'showCreateCategory'])->name('admin.categories.createcategory');
Route::get('/admin/categories/editcategories', [AdminDashboardController::class, 'showEditCategory'])->name('admin.categories.editcategory');

// Routes for login and signup
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


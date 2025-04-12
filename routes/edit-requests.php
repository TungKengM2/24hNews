<?php

use App\Http\Controllers\EditRequestController;
use Illuminate\Support\Facades\Route;

// Admin routes for edit requests
Route::middleware(['auth', 'role:1'])->prefix('admin')->group(function () {
    Route::get('/edit-requests', [EditRequestController::class, 'index'])->name('admin.edit-requests.index');
    Route::put('/edit-requests/{editRequest}/approve', [EditRequestController::class, 'approve'])->name('admin.edit-requests.approve');
    Route::put('/edit-requests/{editRequest}/reject', [EditRequestController::class, 'reject'])->name('admin.edit-requests.reject');
});

// Public route for creating edit requests
Route::post('/articles/{article}/edit-request', [EditRequestController::class, 'store'])
    ->middleware(['auth'])
    ->name('articles.edit-request.store');

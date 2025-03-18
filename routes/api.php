<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

Route::post('/moderate/image-url',
    [
        App\Http\Controllers\Author\ImageModerationController::class,
        'moderateImageUrl',
    ]);
Route::post('/moderate/image-upload',
    [
        App\Http\Controllers\Author\ImageModerationController::class,
        'moderateImageUpload',
    ]);

Route::post('/check-image-moderation',
    [
        App\Http\Controllers\Author\ImageModerationController::class,
        'checkImageModeration',
    ]);

Route::post('/tinymce/upload-image',
    [
        App\Http\Controllers\Author\TinyMCEUploadController::class,
        'uploadImage',
    ]);

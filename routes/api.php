<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
Route::post('/check-nsfw', function (Request $request) {
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $path = $request->file('image')->store('temp');

    $process = new Process([
        '/home/buihien9969/.nvm/versions/node/v22.12.0/bin/node',
        '--experimental-specifier-resolution=node',
        '/home/buihien9969/PhpstormProjects/24hNews/nsfw-check.js',
        $path,
    ]);
    $process->run();

    if (! $process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }

    Storage::delete($path);

    return response()->json(json_decode($process->getOutput(), true));
});

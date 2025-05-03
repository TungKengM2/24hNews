<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function listFiles(): JsonResponse
    {
        $files = Storage::disk('public')->files('uploads');

        $urls = array_map(function ($file) {
            return Storage::disk('public')->url($file);
        }, $files);

        return response()->json([
            'files' => $urls,
        ]);
    }
}

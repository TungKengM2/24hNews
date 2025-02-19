<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{
    public function uploadImage(Request $request) {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('uploads', 'public');
            return response()->json(["url" => asset("storage/" . $path)]);
        }
        return response()->json(["error" => "Upload thất bại"], 400);
    }}

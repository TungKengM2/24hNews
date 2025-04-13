<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('website.profiles.user', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = Auth::user();

            // Delete old avatar if exists
            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }

            // Store new avatar
            $imagePath = $request->file('image')->store('public/profile_images');
            $user->image = str_replace('public/', '', $imagePath);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Ảnh đại diện đã được cập nhật thành công!',
                'avatar_url' => asset('storage/' . $user->image)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật ảnh đại diện: ' . $e->getMessage()
            ], 500);
        }
    }
}

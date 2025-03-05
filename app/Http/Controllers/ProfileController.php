<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    /**
     * Hiển thị trang profile
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->user_id, 'user_id')],
            'phone'    => ['nullable', 'regex:/^0[0-9]{9}$/'],
        ]);

        // Kiểm tra nếu dữ liệu không thay đổi
        if ($request->username == $user->username && $request->phone == $user->phone) {
            return back()->with('error', 'Không có thay đổi nào được thực hiện.');
        }

        // Cập nhật dữ liệu
        $user->update([
            'username' => $request->username,
            'phone'    => $request->phone,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function uploadAvatar(Request $request)
    {
        // Validate file input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if the file exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('avatars', 'public'); // Store the image in the 'avatars' folder in the 'public' disk

            // Update the user's image path in the database
            $user = auth()->user();
            $user->image = $imagePath; // Save the image path to the 'image' column
            $user->save();

            // Return the updated image URL
            return response()->json([
                'success' => true,
                'image_url' => asset('storage/' . $imagePath), // Return the new image URL
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image file was uploaded.',
        ]);
    }
    /**
     * Đổi mật khẩu
     */
    public function showChangePasswordForm()
{
    return view('profile.change-password'); // Trả về view chứa form đổi mật khẩu
}

public function updatePassword(Request $request)
{
    $user = Auth::user();
    
    // Nếu user đăng nhập bằng Google/Facebook thì không cho đổi mật khẩu
    if (!$user->password) {
        return back()->withErrors(['password' => 'Tài khoản của bạn đăng nhập bằng Google/Facebook, không thể đổi mật khẩu.']);
    }

    // Kiểm tra dữ liệu nhập vào
    $request->validate([
        'current_password' => 'required',  // Mật khẩu hiện tại là bắt buộc
        'new_password'     => 'required|min:8|confirmed', // Mật khẩu mới phải có ít nhất 8 ký tự và trùng khớp với xác nhận
    ]);

    // Kiểm tra mật khẩu hiện tại của người dùng
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
    }

    // Cập nhật mật khẩu mới
    $user->update([
        'password' => Hash::make($request->new_password)  // Mã hóa mật khẩu mới và lưu
    ]);

    // Thêm thông báo thành công vào session
    return back()->with('success', 'Đổi mật khẩu thành công!');
}

    
}

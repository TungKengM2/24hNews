<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Nếu dùng bảng khác thì đổi lại

class ForgotPasswordController extends Controller
{
    // Hiển thị form nhập email để nhận link đặt lại mật khẩu
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password'); // Đảm bảo file này có tồn tại trong views
    }

    // Xử lý gửi email đặt lại mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Xử lý đặt lại mật khẩu
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );
    
        if ($status === Password::PASSWORD_RESET) {
            // Kiểm tra nếu email thuộc Admin hay User
            $isAdmin = \App\Models\User::where('email', $request->email)->where('role_id', 1)->exists();
    
            return redirect()->route($isAdmin ? 'loginadmin' : 'loginuser')->with('status', __($status));
        }
    
        return back()->withErrors(['email' => __($status)]);
    }
    
}

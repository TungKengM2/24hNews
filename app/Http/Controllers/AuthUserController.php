<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthUserController extends Controller
{
    public function showLoginUserForm()
    {
        return view('auth.authuser.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
    }

    public function showSignupUserForm()
    {
        return view('auth.authuser.signup');
    }

    public function processSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            // 'terms'    => 'accepted'
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $otp = rand(100000, 999999);
    
        // Lưu dữ liệu đăng ký vào session
        session([
            'signup_data' => [
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'password' => Hash::make($request->password), // Mã hóa mật khẩu trước khi lưu
            ],
            'signup_otp'      => Hash::make($otp), // Mã hóa OTP
            'otp_expires_at'  => now()->addMinutes(1), // OTP hết hạn sau 1 phút
            'otp_attempts'    => 0, // Số lần nhập sai OTP
        ]);
    
        // Gửi OTP qua email
        Mail::raw("Mã OTP của bạn là: $otp (có hiệu lực trong 60 giây)", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Mã OTP xác nhận đăng ký');
        });
    
        return redirect()->route('otp.verify.form')->with('status', 'OTP đã được gửi đến email của bạn.');
    }
    
    // Hiển thị form nhập OTP
    public function showOtpForm()
    {
        return view('auth.otp');
    }
    
    // Xử lý xác nhận OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
    
        if (session('otp_attempts', 0) >= 3) {
            session()->forget(['signup_data', 'signup_otp', 'otp_expires_at', 'otp_attempts']);
            return redirect()->route('signup')->withErrors(['otp' => 'Bạn đã nhập sai OTP quá 3 lần, vui lòng đăng ký lại.']);
        }
    
        if (now()->greaterThan(session('otp_expires_at'))) {
            session()->forget(['signup_data', 'signup_otp', 'otp_expires_at', 'otp_attempts']);
            return redirect()->route('signup')->withErrors(['otp' => 'OTP đã hết hạn, vui lòng đăng ký lại.']);
        }
    
        if (!Hash::check($request->otp, session('signup_otp'))) {
            session(['otp_attempts' => session('otp_attempts', 0) + 1]);
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.'])->withInput();
        }
    
        $signupData = session('signup_data');
        if (!$signupData) {
            return redirect()->route('signup')->withErrors(['email' => 'Dữ liệu đăng ký hết hạn, vui lòng đăng ký lại.']);
        }
    
        // Tạo tài khoản
        $user = User::create($signupData + ['role_id' => 4]);
    
        // Xóa dữ liệu OTP khỏi session
        session()->forget(['signup_data', 'signup_otp', 'otp_expires_at', 'otp_attempts']);
    
        // Đăng nhập người dùng
        Auth::login($user);
    
        return redirect('/')->with('status', 'Đăng ký thành công!');
    }
    

    public function logout(Request $request)
    {
        $redirectRoute = '/';
        if (Auth::check() && Auth::user()->role_id == 1) {
            $redirectRoute = '/login-admin';
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirectRoute)->with('status', 'Bạn đã đăng xuất thành công.');
    }
}
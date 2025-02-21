<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' =>'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            if ($user->role_id == 3) {
                return redirect()->intended('/writer/dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->intended('/moderator/dashboard');
            } elseif ($user->role_id == 4) {
                return redirect()->intended('/user/dashboard');
            }
            else {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function processSignup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'accepted'

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $otp = rand(100000,999999);

         // Lưu dữ liệu đăng ký và OTP vào session

        session([
            'signup_data' => $request->only('username', 'email', 'password','phone'),
            'signup_otp' => $otp,
        ]);

        // Gửi OTP qua email
        Mail::raw("Your OTP for registration is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Your OTP for registration');
        });

         // Chuyển hướng đến form nhập OTP
        return redirect()->route('otp.verify.form')->with('status', 'OTP has been sent to your email.');


    }
    // Hiển thị form  nhập otp

    public function showOtpForm() {
        return view('auth.verify-otp');
    }

    // Xử lý xác nhận otp

    public function verifyOtp(Request $request){
        $request->validate([
            'otp'=>'required|numeric'
        ]);

        $sessionOtp = session('signup_otp');
        if ($request->otp != $sessionOtp) {
            return back()->withErrors(['otp' => "OTP is incorrect"])->withInput();
        }

        $signupData = session('signup_data');
        if (!$signupData) {
            return redirect()->route('signup')->withErrors(['email' => 'Dữ liệu đăng ký hết hạn, vui lòng đăng ký lại.']);
        }

        //Tạo tài khoản
        $user = User::create([
             'username' => $signupData['username'],
             'email' => $signupData['email'],
             'phone'    => $signupData['phone'],
             'password' => Hash::make($signupData['password']),
             'role_id' => 4, // Mặc định là user
             ]);

        //xóa dữ liệu tạm trong session
        session()->forget(['signup_data', 'signup_otp']);

        // ĐĂng nhập người dùng

        Auth::login($user);

        return redirect('/')->with('status', 'Đăng ký thành công');
    }
    public function logout(Request $request)
    {
        $driver = Auth::getDefaultDriver(); // Lưu driver trước khi logout
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Xóa cookie remember me
        Cookie::queue(Cookie::forget('remember_web_' . $driver));
    
        return redirect('/')->with('status', 'You have been logged out.');
    }
    
}

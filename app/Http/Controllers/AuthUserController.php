<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthUserController extends Controller
{
    public function showLoginUserForm()
    {
        return view('auth.authuser.login');
    }

    public function showSignupUserForm()
    {
        return view('auth.authuser.signup');
    }

    public function processSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ], [
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.string' => 'Tên đăng nhập phải là chuỗi ký tự',
            'username.max' => 'Tên đăng nhập không được vượt quá 255 ký tự',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự',
            'email.unique' => 'Địa chỉ email đã tồn tại',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
            'phone.regex' => 'Số điện thoại chỉ được chứa các chữ số',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $otp = rand(100000, 999999);

        // Lưu dữ liệu đăng ký vào session
        session([
            'signup_data' => [
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password, // Không hash ở đây, để model tự hash
            ],
            'signup_otp' => Hash::make($otp),
            'otp_expires_at' => now()->addSeconds(60), // OTP hết hạn sau 60 giây
        ]);

        // Gửi OTP qua email
        Mail::raw("Mã OTP của bạn là: $otp\nMã OTP này có hiệu lực trong 60 giây.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Mã xác thực OTP đăng ký tài khoản');
        });

        // Chuyển hướng đến form nhập OTP
        return redirect()->route('otp.verify.form')->with('status', 'Mã OTP đã được gửi đến email của bạn. Mã này có hiệu lực trong 60 giây.');
    }

    public function showOtpForm()
    {
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        // Kiểm tra xem OTP đã hết hạn chưa
        if (now()->greaterThan(session('otp_expires_at'))) {
            session()->forget(['signup_data', 'signup_otp', 'otp_expires_at']);
            return redirect()->route('signup')
                ->withErrors(['otp' => 'Mã OTP đã hết hạn. Vui lòng đăng ký lại.']);
        }

        if (!Hash::check($request->otp, session('signup_otp'))) {
            return back()->withErrors(['otp' => 'Mã OTP không chính xác.'])->withInput();
        }

        $signupData = session('signup_data');
        if (!$signupData) {
            return redirect()->route('signup')
                ->withErrors(['email' => 'Dữ liệu đăng ký hết hạn, vui lòng đăng ký lại.']);
        }

        // Tạo tài khoản
        $user = User::create($signupData + ['role_id' => 4]);

        // Xóa dữ liệu OTP khỏi session
        session()->forget([
            'signup_data',
            'signup_otp',
            'otp_expires_at',
        ]);

        // Đăng nhập người dùng
        Auth::login($user);

        return redirect('/')->with('status', 'Đăng ký thành công!');
    }

    public function resendOtp()
    {
        // Kiểm tra xem có dữ liệu đăng ký trong session không
        if (!session('signup_data')) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy dữ liệu đăng ký.'
            ]);
        }

        // Tạo mã OTP mới
        $otp = rand(100000, 999999);

        // Cập nhật OTP mới vào session
        session([
            'signup_otp' => Hash::make($otp),
            'otp_expires_at' => now()->addSeconds(60), // OTP hết hạn sau 60 giây
        ]);

        // Gửi OTP mới qua email
        Mail::raw("Mã OTP của bạn là: $otp\nMã OTP này có hiệu lực trong 60 giây.", function ($message) {
            $message->to(session('signup_data')['email'])
                ->subject('Mã xác thực OTP đăng ký tài khoản');
        });

        return response()->json([
            'success' => true,
            'message' => 'Mã OTP mới đã được gửi đến email của bạn.'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Chuyển hướng dựa trên role_id
            switch($user->role_id) {
                case 1: // Admin
                    return redirect()->intended('/admin/dashboard');
                case 2: // Author
                    return redirect()->intended('/');
                case 3: // Moderator
                    return redirect()->intended('/moderator/dashboard');
                case 4: // User
                    return redirect()->intended('/');
                default:
                    return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

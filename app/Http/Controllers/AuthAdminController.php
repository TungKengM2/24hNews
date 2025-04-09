<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class AuthAdminController extends Controller
    {

        public function showLoginAdminForm()
        {
            return view('auth.authadmin.login');
        }

        public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                
                // Kiểm tra nếu không phải admin thì đăng xuất và trả về trang chủ
                if ($user->role_id != 1) {
                    Auth::logout();
                    return redirect('/')->with('error', 'Bạn không có quyền truy cập trang admin.');
                }

                $request->session()->regenerate();
                return redirect()->intended('/admin/dashboard');
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
            return redirect()->route('loginadmin');
        }

        public function showForgetAdminForm()
        {
            return view('auth.authadmin.forget');
        }

    }

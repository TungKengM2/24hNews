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
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
    
            if ($user->role_id == 1) {
                session()->flash('success', 'Login successful!');
                return redirect()->intended('/admin/dashboard');
            }
    
            Auth::logout();
            return redirect('/')->withErrors(['email' => 'You do not have admin access.']);
        }
    
        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput($request->only('email'));
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login-admin')->with('status', 'You have been logged out.');
    }

    public function showForgetAdminForm()
    {
        return view('auth.authadmin.forget');
    }
}

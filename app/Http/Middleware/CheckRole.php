<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        if ($role == 1 && $user->role_id != 1) {
            if ($user->role_id == 2) {
                return redirect('/author/dashboard');
            } elseif ($user->role_id == 3) {
                return redirect('/moderator/dashboard');
            } else {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
            }
        }
        
        if ($role == 2 && $user->role_id != 2) {
            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->role_id == 3) {
                return redirect('/moderator/dashboard');
            } else {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
            }
        }
        
        if ($role == 3 && $user->role_id != 3) {
            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->role_id == 2) {
                return redirect('/author/dashboard');
            } else {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
            }
        }

        if ($role == 4 && $user->role_id != 4) {
            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->role_id == 2) {
                return redirect('/author/dashboard');
            } elseif ($user->role_id == 3) {
                return redirect('/moderator/dashboard');
            } else {
                return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
            }
        }

        return $next($request);
    }
}

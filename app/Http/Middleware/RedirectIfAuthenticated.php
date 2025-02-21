<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Nếu đã đăng nhập và truy cập vào /login, chuyển hướng theo vai trò
                if ($request->route()->named('login')) {
                    return $user->role_id === 1 
                        ? redirect('/admin/dashboard') 
                        : redirect('/');
                }

                // Nếu đã đăng nhập, chuyển hướng mặc định
                return redirect($user->role === 'admin' ? '/admin/dashboard' : '/');
            }
        }

        return $next($request);
    }
}



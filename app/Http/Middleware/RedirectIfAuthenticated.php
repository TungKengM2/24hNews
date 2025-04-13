<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$guards
    ) {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Nếu đang truy cập trang login-user
                if ($request->is('login-user')) {
                    // Nếu là moderator (role_id = 3)
                    if ($user->role_id == 3) {
                        return redirect('/moderator/dashboard');
                    }
                    // Nếu là user hoặc author (role_id = 2,4)
                    else if ($user->role_id == 2 || $user->role_id == 4) {
                        return redirect('/');
                    }
                }

                // Nếu đang truy cập trang login-admin
                if ($request->is('login-admin')) {
                    // Nếu là admin (role_id = 1)
                    if ($user->role_id == 1) {
                        return redirect('/admin/dashboard');
                    }
                    // Nếu là user, author hoặc moderator
                    else {
                        return redirect('/');
                    }
                }

                // Chuyển hướng tùy theo role_id cho các trường hợp khác
                if ($user->role_id == 1) {
                    return redirect('/admin/dashboard');
                } elseif ($user->role_id == 2) {
                    return redirect('/author/dashboard');
                } elseif ($user->role_id == 3) {
                    return redirect('/moderator/dashboard');
                } else {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}

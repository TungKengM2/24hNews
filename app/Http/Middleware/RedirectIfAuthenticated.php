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

                // Chuyển hướng tùy theo role_id
                if ($user->role_id == 1) {
                    return redirect('/admin/dashboard');
                } elseif ($user->role_id == 2) {
                    return redirect('/author/dashboard');
                } elseif ($user->role_id == 3) {
                    return redirect('/moderator/dashboard');
                } else {
                    return redirect('/user/dashboard');
                }
            }
        }

        return $next($request);
    }
}

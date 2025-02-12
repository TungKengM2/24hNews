<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return $next($request);
        }

        // Nếu không phải Admin, chuyển hướng về trang chủ với thông báo lỗi
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang quản trị!');
      }
}

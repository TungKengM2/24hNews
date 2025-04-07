<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckViolationCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->violation_count > 5) {
            return redirect()->route('author.dashboard')->with('error', 'Bạn không thể đăng hoặc sửa bài viết do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
        }

        return $next($request);
    }
}

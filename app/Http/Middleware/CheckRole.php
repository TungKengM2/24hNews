<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Bạn cần đăng nhập.']);
        }

        // Lấy vai trò của user hiện tại
        $user = Auth::user();

        // Kiểm tra role_id có khớp với yêu cầu không
        if ($user->role_id != $role) {
            return abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}

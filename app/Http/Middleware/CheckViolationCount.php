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
         * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
         */
        public function handle(Request $request, Closure $next): Response
        {
            $user = auth()->user();

            if ($user && $user->violation_count > 5) {
                if ($request->is('*/comments') || $request->is('*/comments/*')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Bạn không thể đăng bình luận do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.',
                        ], 403);
                    }

                    return redirect()
                        ->route('home')
                        ->with('error',
                            'Bạn không thể đăng bình luận do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                }

                if ($user->role_id == 2) { // Author (role_id = 2)
                    return redirect()
                        ->route('author.dashboard')
                        ->with('error',
                            'Bạn không thể đăng hoặc sửa bài viết do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                } else { // User thông thường (role_id = 4)
                    return redirect()
                        ->route('home')
                        ->with('error',
                            'Tài khoản của bạn đã bị hạn chế do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                }
            }

            return $next($request);
        }

    }

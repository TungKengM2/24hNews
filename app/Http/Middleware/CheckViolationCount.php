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

            if ($user && $user->role_id == 2 && $user->banned_until && now()->lessThan($user->banned_until)) {
                $banEndTime = $user->banned_until->format('H:i d/m/Y');

                session(['author_banned' => true]);
                session(['author_banned_until' => $banEndTime]);

                if ($request->is('*/comments') || $request->is('*/comments/*')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Bạn không thể đăng bình luận vì tài khoản đã bị tạm khóa đến ' . $banEndTime . '. Vui lòng liên hệ quản trị viên để được hỗ trợ.',
                        ], 403);
                    }

                    return redirect()
                        ->route('home')
                        ->with('error',
                            'Bạn không thể đăng bình luận vì tài khoản đã bị tạm khóa đến ' . $banEndTime . '. Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                }

                if ($request->is('*/report')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Bạn không thể báo cáo vì tài khoản đã bị tạm khóa đến ' . $banEndTime . '. Vui lòng liên hệ quản trị viên để được hỗ trợ.',
                        ], 403);
                    }

                    return redirect()
                        ->back()
                        ->with('error',
                            'Bạn không thể báo cáo vì tài khoản đã bị tạm khóa đến ' . $banEndTime . '. Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                }

                return redirect()
                    ->route('author.dashboard')
                    ->with('error',
                        'Bạn không thể đăng hoặc sửa bài viết vì tài khoản đã bị tạm khóa đến ' . $banEndTime . '. Vui lòng liên hệ quản trị viên để được hỗ trợ.');
            }
            else if ($user && $user->role_id != 2 && $user->banned_until && now()->lessThan($user->banned_until)) {
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

                if ($request->is('*/report')) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Bạn không thể báo cáo do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.',
                        ], 403);
                    }

                    return redirect()
                        ->back()
                        ->with('error',
                            'Bạn không thể báo cáo do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
                }

                return redirect()
                    ->route('home')
                    ->with('error',
                        'Tài khoản của bạn đã bị hạn chế do có quá nhiều vi phạm (> 5). Vui lòng liên hệ quản trị viên để được hỗ trợ.');
            }

            return $next($request);
        }

    }

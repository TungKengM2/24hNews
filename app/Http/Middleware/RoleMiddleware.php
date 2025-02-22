<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Symfony\Component\HttpFoundation\Response;

    class RoleMiddleware
    {

        public function handle($request, Closure $next, $role)
        {
            if (!Auth::check()) {
                return redirect('/login');
            }

            $user = Auth::user();
            if ($user->role->name !== $role) {
                return redirect('/')->with('error',
                    'You do not have permission to access this page.');
            }

            return $next($request);
        }

    }

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
                if ($guard === 'customer') {
                    return redirect('/');
                }
                $user = Auth::guard($guard)->user();
                if ($user && $user->isAdmin()) {
                    return redirect('/admin/dashboard');
                }
                if ($user && $user->isDriver()) {
                    return redirect('/driver/dashboard');
                }
                return redirect('/');
            }
        }

        return $next($request);
    }
}

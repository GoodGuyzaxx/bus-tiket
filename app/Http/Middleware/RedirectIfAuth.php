<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()){
                // Instead of redirecting to '/', redirect to role-based dashboard
                $user = Auth::guard($guard)->user();
                return match ($user->role) {
                    'admin' => redirect()->route('admin.dashboard'),
                    'manager' => redirect()->route('manager.dashboard'),
//                    default => redirect('/login') // Use the redirect controller
                };
            }
        }
        return $next($request);
    }

}

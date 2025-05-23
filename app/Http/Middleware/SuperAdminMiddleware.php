<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->is_super_admin || Auth::user()->employee->is_admin)) {
            return $next($request);
        }

        // If not a super admin, redirect to some other page or show error
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}

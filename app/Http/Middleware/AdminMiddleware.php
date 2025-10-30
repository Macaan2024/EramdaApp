<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ✅ make sure to import this

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Check if user is logged in and is an Admin
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied.');
    }
}

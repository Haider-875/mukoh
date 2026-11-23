<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the admin dashboard.');
        }

        $user = Auth::user();
        if (!$user->isAdmin()) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized. You must have admin privileges to access this area.');
        }

        return $next($request);
    }
}

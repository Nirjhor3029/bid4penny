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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::user()->roles->pluck('title')->toArray());
        $authUserRoles = Auth::user()->roles->pluck('title')->toArray();
         // Check if the user is authenticated and is an admin
        if (Auth::check() && (in_array('admin', $authUserRoles) || in_array('Admin', $authUserRoles))) {
            return $next($request); // Allow access if user is an admin
        }

        // Redirect non-admin users (you can customize this)
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        if (auth()->check()) {
            $user = auth()->user();

            // Check if user has admin access via u_type OR admin role
            if ($user->isAdmin() || $user->isManager() || $user->hasRole('admin')) {
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'You do not have permission to access this area.');
    }
}

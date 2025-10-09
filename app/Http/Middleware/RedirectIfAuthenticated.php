<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
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
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // ✅ توجيه حسب نوع المستخدم
                if ($user->isAdmin() || $user->isManager()) {
                    return redirect('/admin/dashboard');
                }

                // ✅ المستخدم العادي يرجع للصفحة الرئيسية أو home
                return redirect('/');
            }
        }

        return $next($request);
    }
}

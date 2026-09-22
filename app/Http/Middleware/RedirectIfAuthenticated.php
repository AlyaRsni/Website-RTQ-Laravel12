<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Redirect authenticated users away from guest-only pages (login, register).
 * Instead of sending to '/', we redirect to their role-specific dashboard.
 */
class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                return match ($user->role) {
                    'admin'          => redirect()->route('admin.dashboard'),
                    'ustadz_ppdb'    => redirect()->route('ustadz.dashboard'),
                    'calon_santri'   => redirect()->route('ppdb.dashboard'),
                    'ustadz_halaqah' => redirect()->route('siakad.ustadz.dashboard'),
                    'santri'         => redirect()->route('siakad.santri.dashboard'),
                    default          => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}

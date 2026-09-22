<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            // Redirect to appropriate dashboard based on actual role
            return match (Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.'),
                'ustadz_ppdb' => redirect()->route('ustadz.dashboard')->with('error', 'Akses ditolak.'),
                'calon_santri' => redirect()->route('ppdb.dashboard')->with('error', 'Akses ditolak.'),
                'ustadz_halaqah' => redirect()->route('siakad.ustadz.dashboard')->with('error', 'Akses ditolak.'),
                'santri' => redirect()->route('siakad.santri.dashboard')->with('error', 'Akses ditolak.'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}

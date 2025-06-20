<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JabatanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$jabatan): Response
    {
        $jabatan = $jabatan[0] ?? null;
        // Log::info('JabatanMiddleware executed, jabatan: ' . $jabatan);
        // Allow access if user has either the specified role or 'user' role
        if (Auth::check() && (Auth::user()->jabatan === $jabatan || Auth::user()->jabatan === 'user')) {
            return $next($request);
        }

        // If unauthorized, redirect to dashboard for users, otherwise show 403
        if (Auth::check() && Auth::user()->jabatan === 'user') {
            return redirect()->route('dashboard');
        }

        abort(403, 'Unauthorized');
    }
}

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
     * Only admin users can access protected routes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Admin only.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
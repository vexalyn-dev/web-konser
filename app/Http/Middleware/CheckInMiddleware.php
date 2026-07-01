<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Only admin and check-in staff can access protected routes.
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

        $user = auth()->user();

        // Check if user has permission (admin or check-in staff)
        if (!$user->isAdmin() && !$user->isCheckInStaff()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
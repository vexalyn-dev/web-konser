<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect($this->redirectPath());
        }

        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            $user = Auth::user();

            // Update last login information
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            // Log the activity
            ActivityLog::log(
                action: 'login',
                description: 'User logged in successfully',
                userId: $user->id,
                properties: [
                    'email' => $user->email,
                    'ip' => $request->ip(),
                    'remember' => $remember,
                ]
            );

            // Determine redirect path based on role
            $redirectPath = $this->redirectPath();

            // Handle AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Login berhasil! Selamat datang, {$user->name}.",
                    'redirect' => $redirectPath,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                        'role_name' => $user->role_name,
                    ],
                ]);
            }

            return redirect()->intended($redirectPath)
                ->with('success', "Login berhasil! Selamat datang, {$user->name}.");
        }

        // Login failed
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah. Silakan coba lagi.',
            ], 401);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Log the activity before logout
        if ($user) {
            ActivityLog::log(
                action: 'logout',
                description: 'User logged out',
                userId: $user->id,
                properties: [
                    'email' => $user->email,
                ]
            );
        }

        // Logout
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Get the redirect path based on user role.
     */
    protected function redirectPath(): string
    {
        if (!Auth::check()) {
            return route('login');
        }

        $user = Auth::user();

        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'checkin_staff' => route('checkin.index'),
            default => route('login'),
        };
    }
}
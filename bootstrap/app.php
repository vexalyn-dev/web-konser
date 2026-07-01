<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'checkin' => \App\Http\Middleware\CheckInMiddleware::class,
            'activity' => \App\Http\Middleware\LogActivity::class,
        ]);

        // Redirect guests to login page
        $middleware->redirectGuestsTo(function () {
            return route('login');
        });

        // Redirect authenticated users to their dashboard
        $middleware->redirectUsersTo(function () {
            $user = auth()->user();

            if ($user->isAdmin()) {
                return route('admin.dashboard');
            }

            if ($user->isCheckInStaff()) {
                return route('checkin.index');
            }

            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom exception handling
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            return redirect()->guest(route('login'));
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            $status = $e->getStatusCode();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'An error occurred.',
                ], $status);
            }

            if (view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [], $status);
            }

            return response()->view('errors.500', [], 500);
        });
    })->create();
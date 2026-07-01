<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    /**
     * Methods that should be logged
     */
    protected array $loggableMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * Handle an incoming request.
     *
     * Logs all write operations (POST, PUT, PATCH, DELETE) for authenticated users.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users and write operations
        if (
            auth()->check() &&
            in_array($request->method(), $this->loggableMethods) &&
            $response->status() >= 200 &&
            $response->status() < 400
        ) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Log the activity
     */
    protected function logActivity(Request $request, Response $response): void
    {
        try {
            $action = $this->getActionFromMethod($request->method());
            $description = $this->buildDescription($request, $action);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'description' => $description,
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                'properties' => $this->getProperties($request),
            ]);
        } catch (\Throwable $e) {
            // Don't break the request if logging fails
            report($e);
        }
    }

    /**
     * Get action name from HTTP method
     */
    protected function getActionFromMethod(string $method): string
    {
        return match ($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'unknown',
        };
    }

    /**
     * Build description for the log
     */
    protected function buildDescription(Request $request, string $action): string
    {
        $path = $request->path();
        $method = $request->method();

        return ucfirst($action) . " - {$method} {$path}";
    }

    /**
     * Get properties to log (excluding sensitive data)
     */
    protected function getProperties(Request $request): ?array
    {
        $excluded = ['password', 'password_confirmation', '_token', '_method'];
        $data = $request->except($excluded);

        // Only log if there's meaningful data
        if (empty($data)) {
            return null;
        }

        // Limit data size to prevent huge logs
        $json = json_encode($data);
        if (strlen($json) > 10000) {
            return ['note' => 'Data too large to log'];
        }

        return $data;
    }
}
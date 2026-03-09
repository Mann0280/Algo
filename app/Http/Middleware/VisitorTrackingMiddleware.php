<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class VisitorTrackingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Track unique visitor per day
        $ip = $request->ip();
        $today = date('Y-m-d');

        // Use firstOrCreate with unique constraint to prevent race conditions
        // or just check exists for simplicity as per requirements
        $exists = Visitor::where('ip_address', $ip)
                        ->where('visit_date', $today)
                        ->exists();

        if (!$exists) {
            try {
                Visitor::create([
                    'ip_address' => $ip,
                    'visit_date' => $today
                ]);
            } catch (\Exception $e) {
                // Ignore unique constraint violations
            }
        }

        return $next($request);
    }
}

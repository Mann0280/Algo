<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PremiumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user) {
            // Admins have bypass, premium/elite must have future expiry
            if ($user->role === 'admin') {
                return $next($request);
            }

            if (in_array($user->role, ['premium', 'elite']) && $user->premium_expiry && $user->premium_expiry->isFuture()) {
                return $next($request);
            }
        }

        return redirect()->route('pricing')->with('error', 'Algo protocol rejected. Elite authentication required for this terminal node.');
    }
}

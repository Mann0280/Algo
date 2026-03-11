<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckPremiumExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only check for premium or elite roles
            if (in_array($user->role, ['premium', 'elite'])) {
                if ($user->premium_expiry && Carbon::parse($user->premium_expiry)->isPast()) {
                    // Update role to user
                    $user->update([
                        'role' => 'user'
                    ]);
                    
                    // Optional: You could log this or send a notification here
                    // \Log::info("User ID {$user->id} premium status expired.");
                }
            }
        }

        return $next($request);
    }
}

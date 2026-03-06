<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SignalsController extends Controller
{
    /**
     * Show the signals page based on user state.
     *
     * Guest    → locked-login view
     * Free     → locked-upgrade view (blurred preview)
     * Premium  → live Tabulator table with auto-refresh
     */
    public function index()
    {
        // Guest — not logged in
        if (!Auth::check()) {
            return view('signals.index', ['userState' => 'guest']);
        }

        $user = Auth::user();

        // Premium / VIP / Admin — full access
        if (in_array($user->role, ['premium', 'vip', 'admin'])) {
            return view('signals.index', ['userState' => 'premium']);
        }

        // Free user — blurred preview
        return view('signals.index', ['userState' => 'free']);
    }
}

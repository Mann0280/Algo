<?php

namespace App\Http\Controllers;

use App\Models\StockSignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignalController extends Controller
{
    /**
     * Display past signals.
     *
     * @return \Illuminate\View\View
     */
    public function pastSignals()
    {
        // Determine User State for tiered access
        $userState = 'guest';
        if (Auth::check()) {
            $userState = in_array(Auth::user()->role, ['premium', 'vip', 'admin']) ? 'premium' : 'free';
        }

        // Step 2: Retrieve all records ordered by newest first
        $signals = StockSignal::orderBy('id', 'desc')->get();

        // Calculate Stats for the UI
        $totalSignals = $signals->count();
        $totalWin = $signals->where('pnl', '>', 0)->count();
        $totalLoss = $signals->where('pnl', '<', 0)->count();
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 2) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'winRate', 'userState'));
    }
}

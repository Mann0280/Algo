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
    public function pastSignals(Request $request)
    {
        // Determine User State for tiered access
        $userState = 'guest';
        if (Auth::check()) {
            $userState = in_array(Auth::user()->role, ['premium', 'vip', 'admin']) ? 'premium' : 'free';
        }

        // Retrieve and filter signals
        $query = StockSignal::query();

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date);
        }

        if ($request->filled('symbol')) {
            $query->where('stock_name', 'like', '%' . $request->symbol . '%');
        }

        if ($request->filled('signal_type')) {
            $query->where('signal_type', $request->signal_type);
        }

        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        $signals = $query->orderBy('id', 'desc')->get();

        // Calculate Stats for the UI
        $totalSignals = $signals->count();
        $totalWin = $signals->where('pnl', '>', 0)->count();
        $totalLoss = $signals->where('pnl', '<', 0)->count();
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 2) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'winRate', 'userState'));
    }
}

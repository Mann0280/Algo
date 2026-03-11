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

        // Retrieve and filter signals (strictly past dates only)
        // Since entry_date is a varchar(50) and may contain single digits (like 2026-03-2),
        // strict string comparison fails. We use STR_TO_DATE to convert it to an actual date object for comparison.
        $query = StockSignal::query()
            ->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [now()->toDateString()]);

        if ($request->filled('start_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') >= STR_TO_DATE(?, '%Y-%m-%d')", [$request->start_date]);
        }

        if ($request->filled('end_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') <= STR_TO_DATE(?, '%Y-%m-%d')", [$request->end_date]);
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
        $totalPnl = $signals->sum('pnl');
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 2) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalPnl', 'winRate', 'userState'));
    }
}

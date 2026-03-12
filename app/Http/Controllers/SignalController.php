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
        // Using STR_TO_DATE for robust comparison of varchar dates
        $query = StockSignal::query()
            ->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [now()->toDateString()]);

        if ($request->filled('start_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') >= STR_TO_DATE(?, '%Y-%m-%d')", [$request->start_date]);
        }

        if ($request->filled('end_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') <= STR_TO_DATE(?, '%Y-%m-%d')", [$request->end_date]);
        }

        if ($request->filled('symbol')) {
            $query->where('stock_name', 'LIKE', '%' . strtoupper($request->symbol) . '%');
        }

        if ($request->filled('signal_type')) {
            $query->where('signal_type', strtoupper($request->signal_type));
        }

        if ($request->filled('result')) {
            $query->where('result', strtoupper($request->result));
        }

        $signals = $query->orderByRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') DESC")
                       ->orderBy('entry_time', 'DESC')
                       ->get();

        // Calculate Stats for the UI
        $totalSignals = $signals->count();
        $totalWin = $signals->where('result', 'WIN')->count();
        $totalLoss = $signals->where('result', 'LOSS')->count();
        $totalPnl = $signals->sum('pnl');
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 2) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalPnl', 'winRate', 'userState'));
    }
}

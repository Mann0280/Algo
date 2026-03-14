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
        // Redirection Logic: If user filters for ONLY "Today" (both dates), send them to Live Signals
        $today = now()->toDateString();
        if ($request->input('start_date') === $today && $request->input('end_date') === $today) {
            return redirect()->route('signals');
        }

        // Determine User State for tiered access
        $userState = 'guest';
        if (Auth::check()) {
            $userState = in_array(Auth::user()->role, ['premium', 'vip', 'admin']) ? 'premium' : 'free';
        }

        // Retrieve and filter signals. 
        // We include ALL signals strictly BEFORE today.
        $query = StockSignal::query()
            ->where('entry_date', '<', $today);

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date);
        }

        if ($request->filled('symbol')) {
            $query->where('stock_name', 'LIKE', '%' . strtoupper($request->symbol) . '%');
        }

        if ($request->filled('signal_type')) {
            $query->where('signal_type', strtoupper($request->signal_type));
        }

        if ($request->filled('result')) {
            $res = strtoupper($request->result);
            if ($res === 'WIN') {
                $query->where('pnl', '>', 0);
            } elseif ($res === 'LOSS') {
                $query->where('pnl', '<', 0);
            } else {
                $query->where('result', $res);
            }
        }

        // Fetch ONLY necessary columns for Global Stats calculation
        // This avoids memory issues while ensuring the Win Rate is accurate across ALL history
        $allResults = (clone $query)->select('result', 'pnl')->get();

        $totalSignals = $allResults->count();
        
        $totalWin = $allResults->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return $res === 'WIN' || $res === 'TP HIT' || ($res === '' && $s->pnl > 0);
        })->count();

        $totalLoss = $allResults->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return $res === 'LOSS' || $res === 'SL HIT' || ($res === '' && $s->pnl < 0);
        })->count();

        $totalPnl = $allResults->sum('pnl');
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 1) . '%' : '0%';

        // Get Paginated Signals for the Table
        $signals = $query->orderBy('entry_date', 'DESC')
                       ->orderBy('entry_time', 'DESC')
                       ->paginate(15)
                       ->withQueryString();

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalPnl', 'winRate', 'userState'));
    }
}

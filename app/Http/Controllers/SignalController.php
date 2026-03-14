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
        // Before 4 PM: include signals strictly BEFORE today.
        // After 4 PM: include signals UP TO AND INCLUDING today.
        $isAfterMarketClose = now()->hour >= 16;
        $query = StockSignal::query();

        if ($isAfterMarketClose) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') <= STR_TO_DATE(?, '%Y-%m-%d')", [$today]);
        } else {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [$today]);
        }

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
            $res = strtoupper($request->result);
            if ($res === 'WIN') {
                $query->where(function($q) {
                    $q->whereIn('result', ['WIN', 'TP HIT'])
                      ->orWhere(function($sub) {
                          $sub->whereNull('result')->where('pnl', '>', 0);
                      });
                });
            } elseif ($res === 'LOSS') {
                $query->where(function($q) {
                    $q->whereIn('result', ['LOSS', 'SL HIT'])
                      ->orWhere(function($sub) {
                          $sub->whereNull('result')->where('pnl', '<', 0);
                      });
                });
            } else {
                $query->where('result', $res);
            }
        }

        // Fetch ALL signals for the historical view (250-500 rows is performant for Tabulator)
        $signals = $query->orderByRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') DESC")
                       ->orderBy('entry_time', 'DESC')
                       ->get();

        // Calculate Stats for the UI from the collection
        $totalSignals = $signals->count();
        
        $totalWin = $signals->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return in_array($res, ['WIN', 'TP HIT', 'BREAKEVEN']) || (empty($res) && $s->pnl > 0);
        })->count();

        $totalLoss = $signals->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return in_array($res, ['LOSS', 'SL HIT']) || (empty($res) && $s->pnl < 0);
        })->count();

        $totalEOD = $signals->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return $res === 'EOD';
        })->count();

        $totalPnl = $signals->sum('pnl');
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 1) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalEOD', 'totalPnl', 'winRate', 'userState'));
    }
}

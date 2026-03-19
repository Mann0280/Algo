<?php

namespace App\Http\Controllers;

use App\Models\StockSignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SignalController extends Controller
{
    /**
     * Display past signals.
     *
     * @return \Illuminate\View\View
     */
    public function pastSignals(Request $request)
    {
        // Use IST for all time-based logic to align with Indian Market hours
        $nowIST = now()->timezone('Asia/Kolkata');
        $today = $nowIST->toDateString();
        
        // Redirection Logic: If user filters for ONLY "Today" (both dates), send them to Live Signals
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
        $isAfterMarketClose = $nowIST->hour >= 16;
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

        // Updated filtering logic for symbol and stock_name
        if ($request->filled('symbol') || $request->filled('search') || $request->filled('stock_name')) {
            $searchTerm = strtoupper($request->symbol ?? $request->search ?? $request->stock_name);
            $query->where(function($q) use ($searchTerm) {
                $q->where('symbol', 'LIKE', '%' . $searchTerm . '%');
                // Check if stock_name column exists to avoid error on different environments
                if (Schema::hasColumn('stock_signals', 'stock_name')) {
                    $q->orWhere('stock_name', 'LIKE', '%' . $searchTerm . '%');
                }
            });
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

        $totalEODWin = $signals->filter(function($s) {
            $res = strtoupper($s->result ?? '');
            return $res === 'EOD' && $s->pnl > 0;
        })->count();

        $defaultCapital = 100000;
        $totalPnl = $signals->sum(function($s) use ($defaultCapital) {
            return $s->getCalculatedSimPnl($defaultCapital);
        });
        
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 1) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalEOD', 'totalEODWin', 'totalPnl', 'winRate', 'userState'));
    }
}

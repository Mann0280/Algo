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

        // Retrieve and filter signals. A signal is "past" if it's before today
        // OR if it's from today but already has a result or PNL (meaning it's closed).
        $query = StockSignal::query()
            ->where(function($q) {
                $q->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [now()->toDateString()])
                  ->orWhere(function($sq) {
                      $sq->where('entry_date', now()->toDateString())
                         ->where(function($ssq) {
                             $ssq->whereNotNull('result')->where('result', '!=', '')->where('result', '!=', 'RUNNING')
                                 ->orWhereNotNull('pnl')->where('pnl', '!=', '');
                         });
                  });
            });

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
                    $q->where('result', 'WIN')
                      ->orWhere(function($sq) {
                          $sq->where(function($internal) {
                              $internal->whereNull('result')->orWhere('result', '');
                          })->where('pnl', '>', 0);
                      });
                });
            } elseif ($res === 'LOSS') {
                $query->where(function($q) {
                    $q->where('result', 'LOSS')
                      ->orWhere(function($sq) {
                          $sq->where(function($internal) {
                              $internal->whereNull('result')->orWhere('result', '');
                          })->where('pnl', '<', 0);
                      });
                });
            } else {
                $query->where('result', $res);
            }
        }

        $signals = $query->orderByRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') DESC")
                       ->orderBy('entry_time', 'DESC')
                       ->get();

        // Calculate Stats for the UI with Data Resiliency
        $totalSignals = $signals->count();
        $totalWin = $signals->filter(function($s) {
            return strtoupper($s->result) === 'WIN' || (empty($s->result) && $s->pnl > 0);
        })->count();
        $totalLoss = $signals->filter(function($s) {
            return strtoupper($s->result) === 'LOSS' || (empty($s->result) && $s->pnl < 0);
        })->count();
        $totalPnl = $signals->sum('pnl');
        $winRate = $totalSignals > 0 ? round(($totalWin / $totalSignals) * 100, 2) . '%' : '0%';

        // Pass data to the Blade view
        return view('signals.past', compact('signals', 'totalSignals', 'totalWin', 'totalLoss', 'totalPnl', 'winRate', 'userState'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PastSignalsController extends Controller
{
    /**
     * Render the past signals view based on user state.
     */
    public function webIndex()
    {
        if (!Auth::check()) {
            return view('signals.past', ['userState' => 'guest']);
        }

        $user = Auth::user();
        if (in_array($user->role, ['premium', 'vip', 'admin'])) {
            return view('signals.past', ['userState' => 'premium']);
        }

        return view('signals.past', ['userState' => 'free']);
    }

    /**
     * API endpoint for past signals with filtering and pagination.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $isPremium = in_array($user->role, ['premium', 'vip', 'admin']);
        
        // Filtering for past signals (based on entry_date string)
        $today = now()->format('Y-m-d');
        $query = \App\Models\StockSignal::where('entry_date', '<', $today);

        // Tier Access: Free users only see last 7 days of archive
        if (!$isPremium) {
            $query->where('updated_at', '>=', now()->subDays(7));
        }

        // --- Filtering Logic ---
        if ($request->has('startDate') && $request->startDate) {
            $query->whereDate('updated_at', '>=', $request->startDate);
        }
        if ($request->has('endDate') && $request->endDate) {
            $query->whereDate('updated_at', '<=', $request->endDate);
        }
        if ($request->has('symbol') && $request->symbol) {
            $query->where('stock_name', 'like', '%' . $request->symbol . '%');
        }

        // Sort by most recent update
        $query->orderBy('updated_at', 'desc');

        // --- Pagination ---
        $perPage = (int) $request->get('size', 20);
        $perPage = min(max($perPage, 1), 100); 

        $signals = $query->paginate($perPage);

        $data = collect($signals->items())->map(function ($signal) {
            $entry = (float)$signal->entry;
            $target = (float)$signal->target;
            
            return [
                'id' => $signal->id,
                'symbol' => $signal->stock_name,
                'type' => $signal->signal_type ?: ($target > $entry ? 'BUY' : 'SELL'),
                'entry_price' => $entry,
                'tp' => $target,
                'be' => (float)$signal->breakeven,
                'sl' => (float)$signal->sl,
                'close_price' => $signal->close_price ?: ($signal->pnl ? ($entry + (float)$signal->pnl) : $entry),
                'result' => $signal->result ?: ($signal->pnl > 0 ? 'WIN' : ($signal->pnl < 0 ? 'LOSS' : 'BREAKEVEN')),
                'pl' => (float)$signal->pnl,
                'date' => $signal->entry_date,
                'is_today' => false
            ];
        });

        // --- Statistics Calculation ---
        
        // 1. Global Platform Performance (All past signals)
        $today = now()->format('Y-m-d');
        $globalQuery = \App\Models\StockSignal::where('entry_date', '<', $today);
        $globalTotal = $globalQuery->count();
        $globalWins = (clone $globalQuery)->where('pnl', '>', 0)->count();
        $globalProfit = (clone $globalQuery)->sum('pnl');
        $globalLossCount = (clone $globalQuery)->where('pnl', '<', 0)->count();

        // 2. Filtered Dynamic Stats (Current View)
        $statsQuery = clone $query;
        $statsQuery->getQuery()->orders = null; 
        
        $filteredTotal = (clone $statsQuery)->count();
        $filteredWins = (clone $statsQuery)->where('pnl', '>', 0)->count();
        $filteredProfit = (clone $statsQuery)->sum('pnl');
        $filteredLossCount = (clone $statsQuery)->where('pnl', '<', 0)->count();

        return response()->json([
            'success' => true,
            'data' => $data->values()->all(),
            'total' => $signals->total(),
            'page' => $signals->currentPage(),
            'last_page' => $signals->lastPage(),
            'stats' => [
                'total_signals' => $globalTotal,
                'win_rate' => $globalTotal > 0 ? round(($globalWins / $globalTotal) * 100, 1) . '%' : '0%',
                'total_win' => number_format($globalProfit, 2),
                'total_loss' => $globalLossCount,
                
                'filtered' => [
                    'total' => $filteredTotal,
                    'win_rate' => $filteredTotal > 0 ? round(($filteredWins / $filteredTotal) * 100, 1) . '%' : '0%',
                    'profit' => number_format($filteredProfit, 2),
                    'loss' => $filteredLossCount,
                ]
            ]
        ]);
    }
}

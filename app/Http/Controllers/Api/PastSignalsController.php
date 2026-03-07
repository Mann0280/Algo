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
        
        // As per user request: "all tips are the premium user's"
        // We only show closed signals that were premium signals.
        $query = Signal::where('status', 'closed')->where('is_premium', true);

        // Tier Access: Free users only see last 7 days of archive
        if (!$isPremium) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        // --- Filtering Logic ---
        if ($request->has('startDate') && $request->startDate) {
            $query->whereDate('created_at', '>=', $request->startDate);
        }
        if ($request->has('endDate') && $request->endDate) {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        if ($request->has('symbol') && $request->symbol) {
            $query->where('stock_symbol', 'like', '%' . $request->symbol . '%');
        }
        if ($request->has('type') && $request->type) {
            $query->where('type', strtoupper($request->type));
        }
        if ($request->has('result') && $request->result) {
            $query->where('result', strtoupper($request->result));
        }

        // Sort by most recent
        $query->orderBy('created_at', 'desc');

        // --- Pagination ---
        $perPage = (int) $request->get('size', 20);
        $perPage = min(max($perPage, 1), 100); 

        $signals = $query->paginate($perPage);

        $data = collect($signals->items())->map(function ($signal) {
            $isToday = $signal->created_at->isToday();
            
            // Calculate P/L logic (Hidden for today's past signals as per rule)
            $pl = null;
            if (!$isToday && $signal->close_price && $signal->entry_price) {
                if ($signal->type === 'BUY') {
                    $pl = $signal->close_price - $signal->entry_price;
                } else {
                    $pl = $signal->entry_price - $signal->close_price;
                }
            }

            return [
                'id' => $signal->id,
                'symbol' => $signal->stock_symbol,
                'type' => $signal->type,
                'entry_price' => $signal->entry_price,
                'tp' => $signal->target_1,
                'sl' => $signal->stop_loss,
                'close_price' => $signal->close_price,
                'result' => $signal->result,
                'pl' => $pl,
                'date' => $signal->created_at->format('d M Y'),
                'is_today' => $isToday
            ];
        });

        // --- Statistics Calculation ---
        
        // 1. Global Platform Performance (All-time Master Data)
        $globalQuery = Signal::where('status', 'closed')->where('is_premium', true);
        $globalTotal = $globalQuery->count();
        $globalWins = (clone $globalQuery)->where('result', 'WIN')->count();
        $globalProfit = (clone $globalQuery)->sum('pl');
        $globalLossCount = (clone $globalQuery)->where('result', 'LOSS')->count();

        // 2. Filtered Dynamic Stats (Current View)
        $statsQuery = clone $query;
        $statsQuery->getQuery()->orders = null; 
        
        $filteredTotal = (clone $statsQuery)->count();
        $filteredWins = (clone $statsQuery)->where('result', 'WIN')->count();
        $filteredProfit = (clone $statsQuery)->sum('pl');
        $filteredLossCount = (clone $statsQuery)->where('result', 'LOSS')->count();

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $signals->total(),
            'page' => $signals->currentPage(),
            'last_page' => $signals->lastPage(),
            'stats' => [
                // Display Global Master Data initially to impress users
                'total_signals' => $globalTotal,
                'win_rate' => $globalTotal > 0 ? round(($globalWins / $globalTotal) * 100, 1) . '%' : '0%',
                'total_win' => number_format($globalProfit, 2),
                'total_loss' => $globalLossCount,
                
                // Also provide filtered for potential UI toggle/updates
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

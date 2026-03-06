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
     * Render the past signals view.
     */
    public function webIndex()
    {
        return view('signals.past');
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
        
        $query = Signal::where('status', 'closed');

        // Tier Access: Free users only see last 7 days
        if (!$isPremium) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        // Filtering
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

        // Pagination
        $perPage = (int) $request->get('size', 20);
        $perPage = min(max($perPage, 1), 100); // Limit between 1 and 100

        $signals = $query->paginate($perPage);

        $data = collect($signals->items())->map(function ($signal) {
            $isToday = $signal->created_at->isToday();
            
            // Calculate P/L logic
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

        // Stats Calculation (Based on the filtered set or full set? Usually full history statistics are better)
        // For production, we'll calculate stats for the entire pool accessible to the user
        $statsQuery = Signal::where('status', 'closed');
        if (!$isPremium) {
            $statsQuery->where('created_at', '>=', now()->subDays(7));
        }
        
        $totalSignals = $statsQuery->count();
        $wins = (clone $statsQuery)->where('result', 'WIN')->count();
        $totalPl = (clone $statsQuery)->sum('pl');
        $totalLoss = (clone $statsQuery)->where('result', 'LOSS')->count(); // Or sum of negative P/L

        return response()->json([
            'success' => true,
            'data' => $data,
            'total' => $signals->total(),
            'page' => $signals->currentPage(),
            'last_page' => $signals->lastPage(),
            'stats' => [
                'total_signals' => $totalSignals,
                'win_rate' => $totalSignals > 0 ? round(($wins / $totalSignals) * 100, 1) . '%' : '0%',
                'total_profit' => number_format($totalPl, 2),
                'total_loss' => $totalLoss
            ]
        ]);
    }
}

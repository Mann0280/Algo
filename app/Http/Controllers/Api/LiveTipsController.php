<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradingTip;
use Illuminate\Http\Request;

class LiveTipsController extends Controller
{
    public function index()
    {
        $tips = TradingTip::orderBy('created_at', 'desc')->get()->map(function ($tip) {
            $originalEntry = $tip->entry_price;
            $target = $tip->target_price;
            $sl = $tip->stop_loss;
            $isBuy = $target > $originalEntry;

            $multiplier = 1 + (rand(-5, 5) / 10000);
            $tip->entry_price = round($tip->entry_price * $multiplier, 2);
            $currentPrice = $tip->entry_price;

            if ($isBuy) {
                if ($currentPrice >= $target) $tip->status = 'HIT TARGET';
                elseif ($currentPrice <= $sl) $tip->status = 'SL HIT';
                elseif ($currentPrice > $originalEntry) $tip->status = 'RUNNING';
                else $tip->status = 'LIVE';
            } else {
                if ($currentPrice <= $target) $tip->status = 'HIT TARGET';
                elseif ($currentPrice >= $sl) $tip->status = 'SL HIT';
                elseif ($currentPrice < $originalEntry) $tip->status = 'RUNNING';
                else $tip->status = 'LIVE';
            }

            $tip->updated_at = now();
            return $tip;
        });

        $breakevenPoint = \App\Models\SiteSetting::getValue('breakeven_point', '2500.00');
        $breakevenPoint = round($breakevenPoint * (1 + (rand(-2, 2) / 10000)), 2);

        return response()->json([
            'success' => true,
            'count' => $tips->count(),
            'data' => $tips,
            'settings' => [
                'breakeven_point' => number_format($breakevenPoint, 2, '.', ''),
                'breakeven_date' => now()->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * Premium-only live signals endpoint.
     * Returns formatted JSON for the Tabulator table.
     */
    public function liveSignals()
    {
        $user = auth()->user();

        // Block non-premium users
        if (!$user || !in_array($user->role, ['premium', 'vip', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Premium access required.',
            ], 403);
        }

        $today = now()->format('Y-m-d');
        $isAfterMarketClose = now()->hour >= 16;

        if ($isAfterMarketClose) {
             return response()->json([
                'success' => true,
                'count'   => 0,
                'data'    => [],
                'market_status' => 'closed',
            ]);
        }

        $tips = \App\Models\StockSignal::where('entry_date', $today)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($signal) {
                $entry = (float)$signal->entry;
                $target = (float)$signal->target;
                $sl = (float)$signal->sl;
                $isBuy = $signal->signal_type === 'BUY';

                // Prefer stored result if available, otherwise calculate
                $status = $signal->result ?: 'LIVE';
                if (!$signal->result) {
                    if ($signal->pnl > 0) $status = 'HIT TARGET';
                    elseif ($signal->pnl < 0) $status = 'SL HIT';
                    elseif ($signal->pnl == 0 && $signal->pnl !== null) $status = 'RUNNING';
                }

                return [
                    'stock_symbol' => $signal->stock_name,
                    'signal_type'  => $signal->signal_type ?: ($isBuy ? 'BUY' : 'SELL'),
                    'entry_price'  => $entry,
                    'stop_loss'    => $sl,
                    'target_price' => $target,
                    'target_2'     => (float)$signal->breakeven, 
                    'confidence'   => 85,
                    'time'         => $signal->entry_time,
                    'date'         => $signal->entry_date,
                    'status'       => $status,
                    'profit'       => $signal->pnl ? ($signal->pnl > 0 ? '+' : '') . $signal->pnl : '0.00',
                    'video_url'    => null, 
                ];
            });

        return response()->json([
            'success' => true,
            'count'   => $tips->count(),
            'data'    => $tips->values()->all(),
        ]);
    }

    /**
     * Get tutorial videos for the frontend.
     */
    public function tutorialVideos()
    {
        $videos = \App\Models\TutorialVideo::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $videos
        ]);
    }
}

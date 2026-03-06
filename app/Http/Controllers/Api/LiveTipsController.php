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

        $tips = TradingTip::orderBy('created_at', 'desc')->get()->map(function ($tip) {
            $originalEntry = $tip->entry_price;
            $target = $tip->target_price;
            $sl = $tip->stop_loss;
            $isBuy = $target > $originalEntry;

            // Simulate live price fluctuation
            $multiplier = 1 + (rand(-5, 5) / 10000);
            $currentPrice = round($originalEntry * $multiplier, 2);

            // Dynamic status
            if ($isBuy) {
                if ($currentPrice >= $target) $status = 'HIT TARGET';
                elseif ($currentPrice <= $sl) $status = 'SL HIT';
                elseif ($currentPrice > $originalEntry) $status = 'RUNNING';
                else $status = 'LIVE';
            } else {
                if ($currentPrice <= $target) $status = 'HIT TARGET';
                elseif ($currentPrice >= $sl) $status = 'SL HIT';
                elseif ($currentPrice < $originalEntry) $status = 'RUNNING';
                else $status = 'LIVE';
            }

            // Calculate profit/loss
            $diff = $isBuy ? ($currentPrice - $originalEntry) : ($originalEntry - $currentPrice);
            $pctChange = $originalEntry > 0 ? round(($diff / $originalEntry) * 100, 2) : 0;
            $profitStr = ($pctChange >= 0 ? '+' : '') . $pctChange . '%';

            // Confidence based on proximity to target
            $range = abs($target - $sl);
            $progress = $range > 0 ? abs($currentPrice - $sl) / $range : 0.5;
            $confidence = min(98, max(60, round($progress * 100)));

            return [
                'stock_symbol' => $tip->stock_name,
                'signal_type'  => $isBuy ? 'BUY' : 'SELL',
                'entry_price'  => $currentPrice,
                'stop_loss'    => $sl,
                'target_price' => $target,
                'target_2'     => round($target + ($target - $originalEntry) * 0.5, 2),
                'confidence'   => $confidence,
                'time'         => now('Asia/Kolkata')->format('H:i:s'),
                'date'         => now('Asia/Kolkata')->format('d/m/Y'),
                'status'       => $status,
                'profit'       => $profitStr,
            ];
        });

        return response()->json([
            'success' => true,
            'count'   => $tips->count(),
            'data'    => $tips->values(),
        ]);
    }
}

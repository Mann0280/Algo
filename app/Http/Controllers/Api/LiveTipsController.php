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
            // Store original prices for status logic
            $originalEntry = $tip->entry_price;
            $target = $tip->target_price;
            $sl = $tip->stop_loss;
            $isBuy = $target > $originalEntry;

            // Simulate live price fluctuations (+/- 0.05%)
            $multiplier = 1 + (rand(-5, 5) / 10000);
            $tip->entry_price = round($tip->entry_price * $multiplier, 2);
            $currentPrice = $tip->entry_price;

            // Dynamically calculate status
            if ($isBuy) {
                if ($currentPrice >= $target) $tip->status = 'HIT TARGET';
                elseif ($currentPrice <= $sl) $tip->status = 'SL HIT';
                elseif ($currentPrice > $originalEntry) $tip->status = 'RUNNING';
                else $tip->status = 'LIVE';
            } else {
                // Sell logic
                if ($currentPrice <= $target) $tip->status = 'HIT TARGET';
                elseif ($currentPrice >= $sl) $tip->status = 'SL HIT';
                elseif ($currentPrice < $originalEntry) $tip->status = 'RUNNING';
                else $tip->status = 'LIVE';
            }

            $tip->updated_at = now();
            return $tip;
        });

        $breakevenPoint = \App\Models\SiteSetting::getValue('breakeven_point', '2500.00');
        // Simulate live fluctuation for breakeven point (+/- 0.02%)
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
}

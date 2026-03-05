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
            // Simulate live price fluctuations (+/- 0.05%)
            $multiplier = 1 + (rand(-5, 5) / 10000);
            $tip->entry_price = round($tip->entry_price * $multiplier, 2);
            $tip->stop_loss = round($tip->stop_loss * $multiplier, 2);
            $tip->target_price = round($tip->target_price * $multiplier, 2);
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
                'breakeven_date' => \App\Models\SiteSetting::getValue('breakeven_date', now()->format('Y-m-d')),
            ]
        ]);
    }
}

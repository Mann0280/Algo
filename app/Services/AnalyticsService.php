<?php

namespace App\Services;

use App\Models\Signal;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Calculate win rate from performance history.
     */
    public function calculateWinRate()
    {
        $total = DB::table('performance_history')->count();
        if ($total == 0) return 0;
        
        $wins = DB::table('performance_history')->where('result', 'TP')->count();
        return round(($wins / $total) * 100);
    }

    /**
     * Calculate pips gained in the last 7 days.
     */
    public function calculateWeeklyPips()
    {
        return (int) DB::table('performance_history')
            ->where('closed_at', '>=', now()->subDays(7))
            ->sum('pips');
    }

    /**
     * Calculate pips gained in the current month.
     */
    public function calculateMonthlyPips()
    {
        return (int) DB::table('performance_history')
            ->where('closed_at', '>=', now()->startOfMonth())
            ->sum('pips');
    }

    /**
     * Get number of active running signals.
     */
    public function getActiveTrades()
    {
        // Based on the legacy code, it looks for 'Running' status. 
        // We'll use our Signal model for this.
        return Signal::count(); // Simplified for now
    }

    /**
     * Get total signals in the last 7 days.
     */
    public function getTotalSignals()
    {
        return Signal::where('created_at', '>=', now()->subDays(7))->count();
    }

    /**
     * Calculate Risk/Reward ratio.
     */
    public function calculateRiskReward($entry, $sl, $tp, $type)
    {
        if ($type === 'BUY') {
            $risk = abs($entry - $sl);
            $reward = abs($tp - $entry);
        } else {
            $risk = abs($sl - $entry);
            $reward = abs($entry - $tp);
        }
        
        if ($risk == 0) return "1:1";
        return "1:" . round($reward / $risk, 1);
    }

    /**
     * Get market sentiment based on recent signals.
     */
    public function getMarketSentiment()
    {
        $total = Signal::where('created_at', '>=', now()->subDays(7))->count();
        if ($total == 0) return ['bullish' => 50, 'bearish' => 50];
        
        $bullish = Signal::where('risk_level', 'Low') // Temporary mapping for trend
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
            
        $bullPercent = round(($bullish / $total) * 100);
        return ['bullish' => $bullPercent, 'bearish' => 100 - $bullPercent];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Signal;
use App\Models\Watchlist;
use App\Services\AnalyticsService;

class TerminalController extends Controller
{
    protected $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Show the terminal dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';
        
        $watchlist = Watchlist::where('user_id', $user->id)->get();
        $signals = Signal::orderBy('created_at', 'desc')->limit(10)->get();
        
        $stats = [
            'win_rate' => $this->analytics->calculateWinRate(),
            'total_signals' => $this->analytics->getTotalSignals(),
            'active_trades' => $this->analytics->getActiveTrades(),
            'weekly_pips' => $this->analytics->calculateWeeklyPips(),
        ];

        return view('terminal.index', compact('user', 'isPremium', 'watchlist', 'signals', 'stats'));
    }

    /**
     * Show free signals.
     *
     * @return \Illuminate\View\View
     */
    public function free()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';
        
        $db_signals = Signal::where('is_premium', 0)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('terminal.free', compact('user', 'isPremium', 'db_signals'));
    }

    /**
     * Show premium tips.
     *
     * @return \Illuminate\View\View
     */
    public function premiumTips()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';
        
        $tips = \App\Models\PremiumTip::orderBy('created_at', 'desc')->get();
        
        $win_count = $tips->where('status', 'Achieved')->count();
        $closed_count = $tips->whereIn('status', ['Achieved', 'SL Hit', 'Closed'])->count();
        
        $performance = [
            'win_rate' => $closed_count > 0 ? round(($win_count / $closed_count) * 100, 1) : 94.2,
            'total_active' => $tips->where('status', 'Active')->count(),
            'weekly_accuracy' => 96.5,
            'total_tips' => $tips->count(),
            'avg_confidence' => $tips->count() > 0 ? round($tips->avg('confidence_percentage'), 1) : 0,
        ];

        $node_logs = [
            ['time' => now()->subMinutes(2)->format('H:i:s'), 'msg' => 'Neural link established with NSE-MAIN-NODE'],
            ['time' => now()->subMinutes(5)->format('H:i:s'), 'msg' => 'Pattern match found: Bullish Divergence in Sector-5'],
            ['time' => now()->subMinutes(12)->format('H:i:s'), 'msg' => 'Volume spike detected in ELITE assets. Analyzing...'],
            ['time' => now()->subMinutes(18)->format('H:i:s'), 'msg' => 'AI Model v4.2 updated with latest volatility metrics'],
        ];

        $sentiment = ['value' => 72, 'label' => 'Greed', 'trend' => 'up'];

        // Market Movers
        $market_movers = [
            'gainers' => [
                ['name' => 'TATA MOTORS', 'price' => '₹985.40', 'change' => '+4.82%'],
                ['name' => 'WIPRO', 'price' => '₹542.15', 'change' => '+3.67%'],
                ['name' => 'ADANI PORTS', 'price' => '₹1,342.90', 'change' => '+3.21%'],
                ['name' => 'BAJAJ FINANCE', 'price' => '₹7,245.00', 'change' => '+2.95%'],
                ['name' => 'POWER GRID', 'price' => '₹298.50', 'change' => '+2.44%'],
            ],
            'losers' => [
                ['name' => 'BHARTI AIRTEL', 'price' => '₹1,180.60', 'change' => '-2.45%'],
                ['name' => 'ASIAN PAINTS', 'price' => '₹2,780.30', 'change' => '-1.89%'],
                ['name' => 'NESTLE', 'price' => '₹2,412.00', 'change' => '-1.54%'],
                ['name' => 'SBI LIFE', 'price' => '₹1,485.20', 'change' => '-1.32%'],
                ['name' => 'TITAN', 'price' => '₹3,567.80', 'change' => '-0.98%'],
            ],
        ];

        // News Feed
        $news = [
            ['title' => 'RBI keeps repo rate unchanged at 6.5% in Feb policy', 'time' => '12 min ago', 'tag' => 'Policy'],
            ['title' => 'FIIs turn net buyers after 5-day selling streak', 'time' => '28 min ago', 'tag' => 'FII/DII'],
            ['title' => 'IT sector rallies on strong US jobs data', 'time' => '45 min ago', 'tag' => 'Sector'],
            ['title' => 'Reliance Q3 results beat street estimates by 8%', 'time' => '1 hr ago', 'tag' => 'Earnings'],
            ['title' => 'Gold hits all-time high amid global uncertainty', 'time' => '2 hr ago', 'tag' => 'Commodity'],
        ];

        // Trade History
        $trade_history = [
            ['stock' => 'TCS', 'type' => 'BUY', 'entry' => 3842.50, 'exit' => 3920.00, 'qty' => 50, 'pnl' => 3875.00, 'date' => 'Today'],
            ['stock' => 'HDFCBANK', 'type' => 'SELL', 'entry' => 1680.00, 'exit' => 1645.30, 'qty' => 100, 'pnl' => 3470.00, 'date' => 'Today'],
            ['stock' => 'INFY', 'type' => 'BUY', 'entry' => 1520.00, 'exit' => 1498.50, 'qty' => 75, 'pnl' => -1612.50, 'date' => 'Yesterday'],
            ['stock' => 'RELIANCE', 'type' => 'BUY', 'entry' => 2810.00, 'exit' => 2875.40, 'qty' => 30, 'pnl' => 1962.00, 'date' => 'Yesterday'],
            ['stock' => 'SBIN', 'type' => 'BUY', 'entry' => 628.50, 'exit' => 642.20, 'qty' => 200, 'pnl' => 2740.00, 'date' => '2 days ago'],
        ];

        // Watchlist
        $watchlist_stocks = [
            ['name' => 'NIFTY 50', 'price' => '22,456.80', 'change' => '+1.24%', 'up' => true],
            ['name' => 'RELIANCE', 'price' => '₹2,852.30', 'change' => '+0.85%', 'up' => true],
            ['name' => 'TCS', 'price' => '₹3,920.00', 'change' => '+1.92%', 'up' => true],
            ['name' => 'HDFCBANK', 'price' => '₹1,645.30', 'change' => '-0.42%', 'up' => false],
            ['name' => 'INFY', 'price' => '₹1,498.50', 'change' => '-0.67%', 'up' => false],
            ['name' => 'ICICIBANK', 'price' => '₹1,082.40', 'change' => '+1.15%', 'up' => true],
        ];

        // Sector Performance
        $sectors = [
            ['name' => 'IT', 'change' => '+2.8%', 'up' => true],
            ['name' => 'Banking', 'change' => '+1.4%', 'up' => true],
            ['name' => 'Auto', 'change' => '+3.1%', 'up' => true],
            ['name' => 'Pharma', 'change' => '-0.6%', 'up' => false],
            ['name' => 'Energy', 'change' => '+0.9%', 'up' => true],
            ['name' => 'FMCG', 'change' => '-1.2%', 'up' => false],
            ['name' => 'Metal', 'change' => '+2.1%', 'up' => true],
            ['name' => 'Realty', 'change' => '-0.3%', 'up' => false],
        ];

        // Market Summary
        $market_stats = [
            'advances' => 1842,
            'declines' => 956,
            'unchanged' => 142,
            'total_volume' => '₹42,850 Cr',
            'fii_flow' => '+₹2,340 Cr',
            'dii_flow' => '+₹1,120 Cr',
        ];

        // Technical Indicators
        $indicators = [
            ['name' => 'RSI (14)', 'value' => 62.4, 'signal' => 'Neutral', 'color' => 'amber'],
            ['name' => 'MACD', 'value' => '+45.2', 'signal' => 'Bullish', 'color' => 'emerald'],
            ['name' => 'Bollinger', 'value' => 'Upper', 'signal' => 'Overbought', 'color' => 'rose'],
            ['name' => 'EMA (20)', 'value' => '22,380', 'signal' => 'Above', 'color' => 'emerald'],
            ['name' => 'SMA (50)', 'value' => '22,120', 'signal' => 'Above', 'color' => 'emerald'],
            ['name' => 'VWAP', 'value' => '22,440', 'signal' => 'Near', 'color' => 'amber'],
            ['name' => 'ADX', 'value' => 28.6, 'signal' => 'Trending', 'color' => 'purple'],
            ['name' => 'Stochastic', 'value' => 74.1, 'signal' => 'Overbought', 'color' => 'rose'],
        ];

        // Portfolio Summary
        $portfolio = [
            'invested' => 485000,
            'current' => 528450,
            'pnl' => 43450,
            'pnl_pct' => 8.96,
            'today_pnl' => 4280,
            'today_pct' => 0.82,
            'holdings' => [
                ['name' => 'RELIANCE', 'qty' => 30, 'avg' => 2810, 'ltp' => 2852, 'pnl' => 1260],
                ['name' => 'TCS', 'qty' => 50, 'avg' => 3842, 'ltp' => 3920, 'pnl' => 3900],
                ['name' => 'HDFCBANK', 'qty' => 100, 'avg' => 1650, 'ltp' => 1645, 'pnl' => -500],
                ['name' => 'INFY', 'qty' => 75, 'avg' => 1510, 'ltp' => 1498, 'pnl' => -900],
                ['name' => 'ICICIBANK', 'qty' => 120, 'avg' => 1060, 'ltp' => 1082, 'pnl' => 2640],
            ],
        ];

        // Market Calendar
        $calendar = [
            ['date' => 'Mar 3', 'event' => 'TCS Q4 Results', 'type' => 'Earnings', 'impact' => 'High'],
            ['date' => 'Mar 5', 'event' => 'RBI MPC Meeting', 'type' => 'Policy', 'impact' => 'High'],
            ['date' => 'Mar 7', 'event' => 'US Non-Farm Payrolls', 'type' => 'Global', 'impact' => 'Medium'],
            ['date' => 'Mar 10', 'event' => 'HDFC Bank AGM', 'type' => 'Corporate', 'impact' => 'Low'],
            ['date' => 'Mar 12', 'event' => 'CPI Inflation Data', 'type' => 'Macro', 'impact' => 'High'],
            ['date' => 'Mar 14', 'event' => 'Infosys Buyback Record', 'type' => 'Corporate', 'impact' => 'Medium'],
        ];

        // Options Chain
        $options = [
            'pcr' => 1.24,
            'max_pain' => '22,400',
            'iv' => 14.8,
            'calls_oi' => '12.4L',
            'puts_oi' => '15.4L',
            'buildup' => 'Long Build Up',
            'strikes' => [
                ['strike' => 22300, 'call_oi' => '2.1L', 'put_oi' => '3.4L', 'call_chg' => '+12%', 'put_chg' => '-5%'],
                ['strike' => 22400, 'call_oi' => '3.8L', 'put_oi' => '4.2L', 'call_chg' => '+8%', 'put_chg' => '+15%'],
                ['strike' => 22500, 'call_oi' => '5.2L', 'put_oi' => '2.8L', 'call_chg' => '-3%', 'put_chg' => '+22%'],
                ['strike' => 22600, 'call_oi' => '4.1L', 'put_oi' => '1.5L', 'call_chg' => '+18%', 'put_chg' => '-8%'],
            ],
        ];

        // Trading Tips
        $trading_tips = [
            ['title' => 'Risk Management', 'tip' => 'Never risk more than 2% of your capital on a single trade. Use stop-losses religiously.', 'icon' => 'shield'],
            ['title' => 'Trend Following', 'tip' => 'The trend is your friend. Always trade in the direction of the primary trend for higher probability setups.', 'icon' => 'trending-up'],
            ['title' => 'Position Sizing', 'tip' => 'Calculate position size based on your stop-loss distance, not on how much you want to make.', 'icon' => 'calculator'],
            ['title' => 'Patience Pays', 'tip' => 'Wait for your setup. The best traders spend 90% of their time waiting and 10% executing.', 'icon' => 'clock'],
        ];

        return view('terminal.premium', compact(
            'user', 'isPremium', 'tips', 'performance', 'node_logs', 'sentiment',
            'market_movers', 'news', 'trade_history', 'watchlist_stocks', 'sectors', 'market_stats',
            'indicators', 'portfolio', 'calendar', 'options', 'trading_tips'
        ));
    }

    /**
     * Show charts.
     *
     * @return \Illuminate\View\View
     */
    public function charts()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';
        
        return view('terminal.charts', compact('user', 'isPremium'));
    }

    /**
     * Show live breakeven tips.
     *
     * @return \Illuminate\View\View
     */
    public function liveTips()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';
        
        $settings = [
            'breakeven_point' => \App\Models\SiteSetting::getValue('breakeven_point', '2500.00'),
            'breakeven_date' => \App\Models\SiteSetting::getValue('breakeven_date', now()->format('Y-m-d')),
        ];
        
        return view('terminal.live_tips', compact('user', 'isPremium', 'settings'));
    }
}

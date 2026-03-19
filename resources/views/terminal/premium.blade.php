@extends('layouts.app')

@section('title', 'Trading Terminal | Emperor Stock Predictor')

@push('styles')
<style>
    .terminal-grid { display: grid; grid-template-columns: 1fr 340px; gap: 1.25rem; }
    .widget { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); border-radius: 1rem; padding: 1.25rem; }
    .widget-title { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.15em; color: #6b7280; margin-bottom: 1rem; }

    /* Ticker */
    .ticker-strip { display: flex; gap: 1.5rem; overflow: hidden; padding: 0.6rem 0; mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent); }
    .ticker-item { display: flex; align-items: center; gap: 0.5rem; white-space: nowrap; font-size: 10px; font-weight: 700; animation: tickerScroll 25s linear infinite; }
    @keyframes tickerScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* Signal Card */
    .signal-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); border-radius: 1rem; padding: 1.25rem; transition: all 0.3s ease; }
    .signal-card:hover { background: rgba(255,255,255,0.04); border-color: rgba(147, 51, 234, 0.2); }
    .signal-card.premium-locked { position: relative; overflow: hidden; }
    .signal-card.premium-locked .blur-content { filter: blur(6px); pointer-events: none; user-select: none; }

    /* Mini Chart */
    .mini-chart { height: 110px; border-radius: 0.75rem; background: rgba(0,0,0,0.3); }

    /* Dots */
    .dot-green { width: 6px; height: 6px; border-radius: 50%; background: #10b981; box-shadow: 0 0 6px #10b981; }
    .dot-red { width: 6px; height: 6px; border-radius: 50%; background: #ef4444; box-shadow: 0 0 6px #ef4444; }

    /* Tabs */
    .tab-btn { padding: 0.5rem 1rem; font-size: 10px; font-weight: 700; text-transform: uppercase; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; background: rgba(255,255,255,0.03); color: #6b7280; border: 1px solid transparent; }
    .tab-btn.active { background: rgba(147,51,234,0.15); color: #a855f7; border-color: rgba(147,51,234,0.3); }

    /* Calc */
    .calc-input { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 0.5rem; padding: 0.5rem 0.75rem; color: white; font-size: 13px; outline: none; width: 100%; transition: border-color 0.2s; }
    .calc-input:focus { border-color: rgba(147, 51, 234, 0.5); }

    /* News */
    .news-item { padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.03); }
    .news-item:last-child { border-bottom: none; }

    /* Trade Row */
    .trade-row { display: grid; grid-template-columns: 1fr 0.6fr 0.8fr 0.8fr 0.6fr 0.8fr 0.6fr; gap: 0.5rem; align-items: center; padding: 0.6rem 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 11px; }
    .trade-row:last-child { border-bottom: none; }

    /* Sector Pill */
    .sector-pill { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0.75rem; border-radius: 0.5rem; background: rgba(255,255,255,0.03); }

    @media (max-width: 1024px) { .terminal-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 max-w-[1400px] pb-20">

    {{-- ── TOP BAR ── --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-professional text-white uppercase tracking-tight">Trading <span class="text-purple-500">Terminal</span></h1>
            <div class="flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full">
                <div class="dot-green animate-pulse"></div>
                <span class="text-[9px] font-bold text-emerald-500 uppercase">Market Open</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <div class="text-[9px] text-gray-500 font-bold uppercase">Last Sync</div>
                <div class="text-xs text-white font-bold" id="lastSync">--:--:--</div>
            </div>
            <button onclick="window.location.reload()" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg text-xs font-bold text-gray-400 hover:text-white transition-all flex items-center gap-2">
                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Refresh
            </button>
        </div>
    </div>

    {{-- ── TICKER ── --}}
    <div class="bg-white/[0.02] border border-white/5 rounded-xl mb-5 px-4 overflow-hidden">
        <div class="ticker-strip" id="tickerStrip">
            @php $tickers = [
                ['n'=>'NIFTY 50','p'=>'22,456.80','c'=>'+1.24%','u'=>true],['n'=>'SENSEX','p'=>'73,890.20','c'=>'+0.98%','u'=>true],
                ['n'=>'BANK NIFTY','p'=>'47,320.50','c'=>'-0.32%','u'=>false],['n'=>'GOLD','p'=>'₹71,450','c'=>'+0.45%','u'=>true],
                ['n'=>'CRUDE OIL','p'=>'$78.20','c'=>'-1.10%','u'=>false],['n'=>'USD/INR','p'=>'83.12','c'=>'+0.08%','u'=>true],
            ]; @endphp
            @for($i = 0; $i < 3; $i++) @foreach($tickers as $t)
            <div class="ticker-item"><span class="text-gray-400">{{ $t['n'] }}</span><span class="text-white font-bold">{{ $t['p'] }}</span><span class="{{ $t['u'] ? 'text-emerald-400' : 'text-rose-400' }}">{{ $t['c'] }}</span></div>
            @endforeach @endfor
        </div>
    </div>

    {{-- ── QUICK STATS ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        @php $qs = [
            ['l'=>'Win Rate','v'=>$performance['win_rate'].'%','i'=>'target','cl'=>'emerald'],
            ['l'=>'Active Signals','v'=>$performance['total_active'],'i'=>'activity','cl'=>'purple'],
            ['l'=>'Avg Confidence','v'=>$performance['avg_confidence'].'%','i'=>'brain','cl'=>'amber'],
            ['l'=>'Accuracy','v'=>$performance['weekly_accuracy'].'%','i'=>'cpu','cl'=>'blue'],
        ]; @endphp
        @foreach($qs as $s)
        <div class="widget flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-{{ $s['cl'] }}-500/10 text-{{ $s['cl'] }}-400 flex items-center justify-center flex-shrink-0"><i data-lucide="{{ $s['i'] }}" class="w-4 h-4"></i></div>
            <div><div class="text-[8px] font-bold text-gray-500 uppercase">{{ $s['l'] }}</div><div class="text-lg font-bold text-white leading-none">{{ $s['v'] }}</div></div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════
         SECTION 1: MARKET OVERVIEW
         ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        {{-- Sector Heatmap --}}
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="layout-grid" class="w-3.5 h-3.5 text-purple-400"></i> Sector Performance</div>
            <div class="grid grid-cols-2 gap-2">
                @foreach($sectors as $sec)
                <div class="sector-pill">
                    <span class="text-xs font-bold text-gray-300">{{ $sec['name'] }}</span>
                    <span class="text-xs font-bold {{ $sec['up'] ? 'text-emerald-400' : 'text-rose-400' }}">{{ $sec['change'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Market Breadth --}}
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="bar-chart-3" class="w-3.5 h-3.5 text-purple-400"></i> Market Breadth</div>
            <div class="flex items-center gap-2 mb-3">
                <div class="flex-1 text-center"><div class="text-[8px] font-bold text-gray-500 uppercase">Advances</div><div class="text-lg font-bold text-emerald-400">{{ number_format($market_stats['advances']) }}</div></div>
                <div class="w-[1px] h-8 bg-white/5"></div>
                <div class="flex-1 text-center"><div class="text-[8px] font-bold text-gray-500 uppercase">Declines</div><div class="text-lg font-bold text-rose-400">{{ number_format($market_stats['declines']) }}</div></div>
                <div class="w-[1px] h-8 bg-white/5"></div>
                <div class="flex-1 text-center"><div class="text-[8px] font-bold text-gray-500 uppercase">Unchanged</div><div class="text-lg font-bold text-gray-400">{{ $market_stats['unchanged'] }}</div></div>
            </div>
            @php $advPct = round($market_stats['advances'] / ($market_stats['advances'] + $market_stats['declines'] + $market_stats['unchanged']) * 100); @endphp
            <div class="h-2 bg-white/5 rounded-full overflow-hidden flex">
                <div class="h-full bg-emerald-500 rounded-l-full" style="width: {{ $advPct }}%"></div>
                <div class="h-full bg-rose-500 rounded-r-full" style="width: {{ 100 - $advPct }}%"></div>
            </div>
            <div class="grid grid-cols-3 gap-2 mt-4">
                <div class="text-center p-2 bg-white/[0.02] rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Volume</div><div class="text-[11px] font-bold text-white">{{ $market_stats['total_volume'] }}</div></div>
                <div class="text-center p-2 bg-emerald-500/5 rounded-lg"><div class="text-[7px] font-bold text-emerald-500/60 uppercase">FII Flow</div><div class="text-[11px] font-bold text-emerald-400">{{ $market_stats['fii_flow'] }}</div></div>
                <div class="text-center p-2 bg-blue-500/5 rounded-lg"><div class="text-[7px] font-bold text-blue-500/60 uppercase">DII Flow</div><div class="text-[11px] font-bold text-blue-400">{{ $market_stats['dii_flow'] }}</div></div>
            </div>
        </div>

        {{-- Top Movers --}}
        <div class="widget">
            <div class="flex items-center gap-2 mb-3">
                <button class="tab-btn active font-whiskey" id="tabGainers" onclick="showMovers('gainers')">🟢 Gainers</button>
                <button class="tab-btn font-whiskey" id="tabLosers" onclick="showMovers('losers')">🔴 Losers</button>
            </div>
            <div id="moverGainers">
                @foreach($market_movers['gainers'] as $g)
                <div class="flex items-center justify-between py-1.5 border-b border-white/[0.02]">
                    <span class="text-xs font-bold text-gray-300">{{ $g['name'] }}</span>
                    <div class="flex items-center gap-3"><span class="text-xs font-bold text-white">{{ $g['price'] }}</span><span class="text-xs font-bold text-emerald-400">{{ $g['change'] }}</span></div>
                </div>
                @endforeach
            </div>
            <div id="moverLosers" style="display:none;">
                @foreach($market_movers['losers'] as $l)
                <div class="flex items-center justify-between py-1.5 border-b border-white/[0.02]">
                    <span class="text-xs font-bold text-gray-300">{{ $l['name'] }}</span>
                    <div class="flex items-center gap-3"><span class="text-xs font-bold text-white">{{ $l['price'] }}</span><span class="text-xs font-bold text-rose-400">{{ $l['change'] }}</span></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 2: MAIN TERMINAL (Signals + Sidebar)
         ══════════════════════════════════════ --}}
    <div class="terminal-grid">
        {{-- LEFT: Signal Feed --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2"><i data-lucide="zap" class="w-4 h-4 text-purple-400"></i> AI Trading Signals</h2>
                @if(!$isPremium)
                <span class="px-3 py-1 bg-white/10 border border-white/30 text-white text-[9px] font-bold uppercase rounded-full">Free Preview</span>
                @else
                <span class="px-3 py-1 bg-purple-500/10 border border-purple-500/30 text-purple-400 text-[9px] font-bold uppercase rounded-full flex items-center gap-1"><i data-lucide="crown" class="w-3 h-3"></i> Premium</span>
                @endif
            </div>

            {{-- Strategy Filter Tabs --}}
            <div class="flex flex-wrap gap-2 mb-2">
                <button class="tab-btn active" onclick="filterSignals('all', this)">All Signals</button>
                <button class="tab-btn" onclick="filterSignals('Swing', this)">Swing</button>
                <button class="tab-btn" onclick="filterSignals('Intraday', this)">Intraday</button>
                <button class="tab-btn" onclick="filterSignals('Long Term', this)">Long Term</button>
            </div>

            @forelse($tips as $index => $tip)
            @php $isLocked = !$isPremium && $index >= 1; @endphp
            <div class="signal-card {{ $isLocked ? 'premium-locked' : '' }}" data-type="{{ $tip->trade_type }}">
                @if($isLocked)
                <div class="absolute inset-0 z-20 bg-black/60 backdrop-blur-sm rounded-[1rem] flex flex-col items-center justify-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center"><i data-lucide="lock" class="w-5 h-5 text-white"></i></div>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Premium Signal</p>
                    <a href="{{ route('pricing') }}" class="px-6 py-2 bg-white text-black font-bold text-[10px] uppercase rounded-lg hover:scale-105 transition-all">Unlock Now</a>
                </div>
                @endif
                <div class="{{ $isLocked ? 'blur-content' : '' }}">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-bold text-white uppercase tracking-tight">{{ $tip->stock_name }}</h3>
                            <span class="px-2 py-0.5 bg-white/5 border border-white/10 rounded text-[8px] font-bold text-gray-400 uppercase">{{ $tip->trade_type }}</span>
                            <div class="flex items-center gap-1"><div class="{{ $tip->status == 'Active' ? 'dot-green' : 'dot-red' }}"></div><span class="text-[8px] font-bold {{ $tip->status == 'Active' ? 'text-emerald-400' : 'text-rose-400' }} uppercase">{{ $tip->status }}</span></div>
                        </div>
                        <div class="text-right"><div class="text-[8px] font-bold text-gray-600 uppercase">AI Score</div><div class="text-lg font-bold {{ $tip->confidence_percentage >= 90 ? 'text-emerald-400' : 'text-white' }}">{{ $tip->confidence_percentage }}%</div></div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 mb-3">
                        <div class="bg-white/[0.03] rounded-lg p-2.5 text-center"><div class="text-[7px] font-bold text-gray-500 uppercase mb-0.5">Entry</div><div class="text-sm font-bold text-white">₹{{ number_format($tip->entry_price, 1) }}</div></div>
                        <div class="bg-emerald-500/[0.03] rounded-lg p-2.5 text-center border border-emerald-500/10"><div class="text-[7px] font-bold text-emerald-500/60 uppercase mb-0.5">Target 1</div><div class="text-sm font-bold text-emerald-400">₹{{ number_format($tip->target_1, 1) }}</div></div>
                        <div class="bg-emerald-500/[0.03] rounded-lg p-2.5 text-center border border-emerald-500/10"><div class="text-[7px] font-bold text-emerald-500/60 uppercase mb-0.5">Target 2</div><div class="text-sm font-bold text-emerald-400">₹{{ number_format($tip->target_2, 1) }}</div></div>
                        <div class="bg-emerald-500/[0.03] rounded-lg p-2.5 text-center border border-emerald-500/10"><div class="text-[7px] font-bold text-emerald-500/60 uppercase mb-0.5">Target 3</div><div class="text-sm font-bold text-emerald-400">₹{{ number_format($tip->target_3, 1) }}</div></div>
                        <div class="bg-rose-500/[0.03] rounded-lg p-2.5 text-center border border-rose-500/10"><div class="text-[7px] font-bold text-rose-500/60 uppercase mb-0.5">Stop Loss</div><div class="text-sm font-bold text-rose-400">₹{{ number_format($tip->stop_loss, 1) }}</div></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1"><i data-lucide="shield" class="w-3 h-3 text-gray-500"></i><span class="text-[9px] font-bold text-gray-400 uppercase">Risk: <span class="{{ $tip->risk_level == 'Low' ? 'text-emerald-400' : 'text-white' }}">{{ $tip->risk_level }}</span></span></div>
                            <div class="flex items-center gap-1"><i data-lucide="clock" class="w-3 h-3 text-gray-500"></i><span class="text-[9px] font-bold text-gray-400">{{ $tip->created_at->diffForHumans() }}</span></div>
                        </div>
                        @if($isPremium)
                        <div class="flex items-center gap-2">
                            <button class="p-1.5 bg-white/5 hover:bg-white/10 rounded-lg border border-white/5 transition-all" title="Bookmark"><i data-lucide="bookmark" class="w-3.5 h-3.5 text-gray-400"></i></button>
                            <button class="p-1.5 bg-white/5 hover:bg-white/10 rounded-lg border border-white/5 transition-all" title="Watchlist"><i data-lucide="eye" class="w-3.5 h-3.5 text-gray-400"></i></button>
                            <button class="p-1.5 bg-white/5 hover:bg-white/10 rounded-lg border border-white/5 transition-all" title="Share"><i data-lucide="share-2" class="w-3.5 h-3.5 text-gray-400"></i></button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="widget text-center py-12"><i data-lucide="radio" class="w-8 h-8 text-gray-700 mx-auto mb-3"></i><h3 class="font-bold text-gray-500 uppercase text-sm mb-2">No Active Signals</h3><p class="text-gray-600 text-xs">AI engine is scanning markets.</p></div>
            @endforelse

            @if(!$isPremium)
            <div class="widget bg-gradient-to-r from-purple-900/20 to-indigo-900/20 border-purple-500/20 text-center py-6">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3"><i data-lucide="crown" class="w-5 h-5 text-white"></i></div>
                <h3 class="font-bold text-white text-base uppercase mb-1">Unlock All Signals</h3>
                <p class="text-gray-400 text-xs mb-4 max-w-sm mx-auto">Get unlimited access to AI signals, P&L calculator, trade history, and priority alerts.</p>
                <a href="{{ route('pricing') }}" class="inline-block px-8 py-2.5 bg-white text-black font-bold text-[10px] uppercase rounded-xl hover:scale-105 transition-all">Upgrade to Premium</a>
                </div>
            </div>
            @endif

            {{-- Market Analysis Video --}}
            <div class="widget">
                <div class="widget-title flex items-center gap-2"><i data-lucide="play-circle" class="w-3.5 h-3.5 text-purple-400"></i> Market Analysis — Today's Session</div>
                <div class="relative rounded-xl overflow-hidden bg-black/40 aspect-video">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/Xn7KWR9EOGQ?rel=0&modestbranding=1" title="Market Analysis" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                    </div>
            </div>
                <p class="text-[10px] text-gray-500 mt-2 leading-snug"><i data-lucide="info" class="w-3 h-3 inline-block text-gray-600 mr-1"></i>Daily pre-market analysis covering key levels, sector trends, and AI model predictions.</p>
                </div>
            </div>

            {{-- How AI Signals Work --}}
            <div class="widget bg-gradient-to-br from-purple-900/10 to-indigo-900/10 border-purple-500/10">
                <div class="widget-title flex items-center gap-2"><i data-lucide="cpu" class="w-3.5 h-3.5 text-purple-400"></i> How AI Signals Work</div>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-purple-500/20 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-purple-400">1</div>
                        <div><div class="text-xs font-bold text-white mb-0.5">Data Collection</div><p class="text-[10px] text-gray-400 leading-snug">AI scans 500+ stocks across NSE/BSE, analyzing price, volume, OI, and 50+ technical indicators every 30 seconds.</p></div>
                        </div>
            </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-purple-500/20 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-purple-400">2</div>
                        <div><div class="text-xs font-bold text-white mb-0.5">Pattern Recognition</div><p class="text-[10px] text-gray-400 leading-snug">Advanced algorithm v4.2 identifies candlestick patterns, Fibonacci levels, divergences, and support/resistance zones with 96.5% accuracy.</p></div>
                        </div>
            </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-purple-500/20 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-purple-400">3</div>
                        <div><div class="text-xs font-bold text-white mb-0.5">Signal Generation</div><p class="text-[10px] text-gray-400 leading-snug">Signals with Entry, 3 Targets, Stop Loss, and Confidence Score are generated only when AI confidence exceeds 85%.</p></div>
                        </div>
            </div>
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0 text-[10px] font-bold text-emerald-400">✓</div>
                        <div><div class="text-xs font-bold text-emerald-400 mb-0.5">Real-Time Delivery</div><p class="text-[10px] text-gray-400 leading-snug">Signals are delivered instantly to your terminal, WhatsApp, and email with live tracking and auto stop-loss alerts.</p></div>
                        </div>
            </div>
                    </div>
            </div>
                </div>
            </div>

            {{-- Today's Market Summary --}}
            <div class="widget">
                <div class="widget-title flex items-center gap-2"><i data-lucide="bar-chart-2" class="w-3.5 h-3.5 text-purple-400"></i> Today's Market Summary</div>
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <div class="p-2.5 bg-emerald-500/5 rounded-lg text-center border border-emerald-500/10">
                        <div class="text-[7px] font-bold text-gray-500 uppercase mb-0.5">NIFTY 50</div>
                        <div class="text-sm font-bold text-white">22,456.80</div>
                        <div class="text-[9px] font-bold text-emerald-400">▲ +276.40 (+1.24%)</div>
                        </div>
            </div>
                    <div class="p-2.5 bg-emerald-500/5 rounded-lg text-center border border-emerald-500/10">
                        <div class="text-[7px] font-bold text-gray-500 uppercase mb-0.5">SENSEX</div>
                        <div class="text-sm font-bold text-white">73,890.20</div>
                        <div class="text-[9px] font-bold text-emerald-400">▲ +718.50 (+0.98%)</div>
                        </div>
            </div>
                    </div>
            </div>
                <div class="grid grid-cols-3 gap-2 mb-3">
                    <div class="p-2 bg-white/[0.02] rounded-lg text-center">
                        <div class="text-[7px] font-bold text-gray-500 uppercase">India VIX</div>
                        <div class="text-xs font-bold text-white">14.2</div>
                        <div class="text-[8px] text-rose-400">▼ -0.8</div>
                        </div>
            </div>
                    <div class="p-2 bg-white/[0.02] rounded-lg text-center">
                        <div class="text-[7px] font-bold text-gray-500 uppercase">Adv/Dec</div>
                        <div class="text-xs font-bold text-emerald-400">1842/956</div>
                        <div class="text-[8px] text-emerald-400">Bullish</div>
                        </div>
            </div>
                    <div class="p-2 bg-white/[0.02] rounded-lg text-center">
                        <div class="text-[7px] font-bold text-gray-500 uppercase">Volume</div>
                        <div class="text-xs font-bold text-white">₹42.8K Cr</div>
                        <div class="text-[8px] text-emerald-400">▲ +12%</div>
                        </div>
            </div>
                    </div>
            </div>
                <div class="p-3 bg-purple-500/5 rounded-lg border border-purple-500/10">
                    <div class="flex items-center gap-2 mb-1.5">
                        <i data-lucide="sparkles" class="w-3.5 h-3.5 text-purple-400"></i>
                        <span class="text-[9px] font-bold text-purple-400 uppercase">AI Market Outlook</span>
                        </div>
            </div>
                    <p class="text-[10px] text-gray-300 leading-relaxed">Markets are showing <span class="text-emerald-400 font-bold">bullish momentum</span> with strong FII inflows. IT and Auto sectors are leading. Key support at <span class="text-white font-bold">22,200</span>, resistance at <span class="text-white font-bold">22,600</span>. Our AI model suggests a <span class="text-emerald-400 font-bold">75% probability of upside continuation</span> in the next session.</p>
                    </div>
            </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Dashboard --}}
        <aside class="space-y-4">
            {{-- Live Chart --}}
            <div class="widget">
                <div class="flex justify-between items-center mb-2">
                    <div class="widget-title mb-0">Market Pulse</div>
                    <div class="flex items-center gap-1.5"><div class="dot-green animate-pulse"></div><span class="text-[8px] font-bold text-emerald-400 uppercase">Live</span></div>
                </div>
                <div class="mini-chart relative overflow-hidden" id="chartContainer"><canvas id="liveChart"></canvas></div>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div class="text-center p-1.5 bg-emerald-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Buyers</div><div class="text-sm font-bold text-emerald-400" id="buyVol">64.2%</div></div>
                    <div class="text-center p-1.5 bg-rose-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Sellers</div><div class="text-sm font-bold text-rose-400" id="sellVol">35.8%</div></div>
                </div>
            </div>

            {{-- Watchlist --}}
            <div class="widget">
                <div class="widget-title flex items-center gap-2"><i data-lucide="list" class="w-3.5 h-3.5 text-purple-400"></i> Watchlist</div>
                <div class="space-y-0">
                    @foreach($watchlist_stocks as $ws)
                    <div class="flex items-center justify-between py-1.5 border-b border-white/[0.02]">
                        <span class="text-[11px] font-bold text-gray-300">{{ $ws['name'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-bold text-white">{{ $ws['price'] }}</span>
                            <span class="text-[10px] font-bold {{ $ws['up'] ? 'text-emerald-400' : 'text-rose-400' }}">{{ $ws['change'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Performance --}}
            <div class="widget">
                <div class="widget-title">Performance</div>
                @php $bars = [
                    ['l'=>'Win Rate','v'=>$performance['win_rate'].'%','w'=>$performance['win_rate'],'c'=>'emerald'],
                    ['l'=>'AI Accuracy','v'=>$performance['weekly_accuracy'].'%','w'=>$performance['weekly_accuracy'],'c'=>'purple'],
                    ['l'=>'Confidence','v'=>$performance['avg_confidence'].'%','w'=>$performance['avg_confidence'],'c'=>'amber'],
                ]; @endphp
                @foreach($bars as $b)
                <div class="mb-2.5">
                    <div class="flex justify-between mb-0.5"><span class="text-[9px] font-bold text-gray-400 uppercase">{{ $b['l'] }}</span><span class="text-xs font-bold text-white">{{ $b['v'] }}</span></div>
                    <div class="h-1.5 bg-white/5 rounded-full overflow-hidden"><div class="h-full bg-{{ $b['c'] }}-500 rounded-full" style="width: {{ $b['w'] }}%"></div></div>
                </div>
                @endforeach
            </div>

            {{-- P&L Calculator (Premium) --}}
            @if($isPremium)
            <div class="widget">
                <div class="widget-title font-whiskey flex items-center gap-2"><i data-lucide="calculator" class="w-3.5 h-3.5 text-purple-400"></i> P&L Calculator</div>
                <div class="space-y-2">
                    <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Buy Price (₹)</label><input type="number" class="calc-input" id="calcBuy" placeholder="0.00"></div>
                    <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Sell Price (₹)</label><input type="number" class="calc-input" id="calcSell" placeholder="0.00"></div>
                    <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Quantity</label><input type="number" class="calc-input" id="calcQty" placeholder="100"></div>
                    <button onclick="calculatePL()" class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs uppercase rounded-lg transition-all">Calculate</button>
                    <div id="plResult" class="text-center p-2 bg-white/5 rounded-lg hidden"><div class="text-[8px] font-bold text-gray-500 uppercase mb-0.5">Profit / Loss</div><div class="text-xl font-bold" id="plValue">₹0</div></div>
                </div>
            </div>
            @else
            <div class="widget relative overflow-hidden">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-10 flex flex-col items-center justify-center rounded-[1rem]"><i data-lucide="lock" class="w-5 h-5 text-amber-400 mb-1"></i><span class="text-[9px] font-bold text-gray-400 uppercase">Premium Feature</span></div>
                <div class="widget-title">P&L Calculator</div>
                <div class="space-y-2 opacity-30"><div class="h-8 bg-white/5 rounded-lg"></div><div class="h-8 bg-white/5 rounded-lg"></div><div class="h-8 bg-white/5 rounded-lg"></div></div>
            </div>
            @endif

            @if($isPremium)
            <div class="widget">
                <div class="widget-title flex items-center gap-2"><i data-lucide="terminal" class="w-3.5 h-3.5 text-purple-400"></i> AI Activity</div>
                <div class="table-wrapper">
                    <div id="premium-ai-activity-table"></div>
                </div>
            </div>
            @endif
        </aside>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 3: NEWS FEED
         ══════════════════════════════════════ --}}
    <div class="mt-8 mb-5">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2"><i data-lucide="newspaper" class="w-4 h-4 text-purple-400"></i> Market News & Insights</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            @foreach($news as $n)
            <div class="widget hover:border-purple-500/20 transition-all cursor-pointer">
                <span class="inline-block px-2 py-0.5 bg-purple-500/10 text-purple-400 text-[8px] font-bold uppercase rounded mb-2">{{ $n['tag'] }}</span>
                <p class="text-xs font-bold text-gray-300 leading-snug mb-2">{{ $n['title'] }}</p>
                <span class="text-[9px] text-gray-500">{{ $n['time'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 4: TRADE HISTORY (Premium)
         ══════════════════════════════════════ --}}
    @if($isPremium)
    <div class="mb-5">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2"><i data-lucide="history" class="w-4 h-4 text-purple-400"></i> Trade History</h2>
        <div class="table-wrapper">
            <div id="premium-trade-history-table"></div>
        </div>
    </div>
    @else
    <div class="mb-5">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2"><i data-lucide="history" class="w-4 h-4 text-purple-400"></i> Trade History</h2>
        <div class="widget relative overflow-hidden text-center py-8">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm z-10 flex flex-col items-center justify-center rounded-[1rem]">
                <i data-lucide="lock" class="w-6 h-6 text-white mb-2"></i>
                <span class="text-xs font-bold text-gray-400 uppercase mb-2">Premium Feature</span>
                <a href="{{ route('pricing') }}" class="px-4 py-1.5 bg-white text-black font-bold text-[9px] uppercase rounded-lg">Upgrade</a>
            </div>
            <div class="opacity-20 flex gap-2" style="min-height: 100px;">
                <div class="flex-1 bg-white/5 rounded-lg"></div>
                <div class="flex-1 bg-white/5 rounded-lg"></div>
                <div class="flex-1 bg-white/5 rounded-lg"></div>
            </div>
        </div>
    </div>
    @endif

    {{-- ══════════════════════════════════════
         SECTION 5: TECHNICAL INDICATORS + FEAR & GREED
         ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 mb-5">
        {{-- Technical Indicators --}}
        <div class="widget md:col-span-2">
            <div class="widget-title flex items-center gap-2"><i data-lucide="gauge" class="w-3.5 h-3.5 text-purple-400"></i> Technical Indicators — NIFTY 50</div>
            <div class="overflow-x-auto no-scrollbar -mx-2 px-2">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 min-w-[500px] md:min-w-0">
                @foreach($indicators as $ind)
                <div class="p-3 bg-white/[0.02] rounded-lg border border-white/[0.03]">
                    <div class="text-[8px] font-bold text-gray-500 uppercase mb-1">{{ $ind['name'] }}</div>
                    <div class="text-sm font-bold text-white mb-0.5">{{ $ind['value'] }}</div>
                    <span class="text-[8px] font-bold px-1.5 py-0.5 rounded bg-{{ $ind['color'] }}-500/10 text-{{ $ind['color'] }}-400 uppercase">{{ $ind['signal'] }}</span>
                </div>
                @endforeach
                </div>
            </div>
            <div class="mt-3 flex items-center gap-2">
                <span class="text-[8px] font-bold text-gray-500 uppercase">Overall:</span>
                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-400 text-[9px] font-bold uppercase rounded">Bullish (5/8)</span>
                <span class="px-2 py-0.5 bg-rose-500/10 text-rose-400 text-[9px] font-bold uppercase rounded">Bearish (2/8)</span>
                <span class="px-2 py-0.5 bg-white/10 text-white text-[9px] font-bold uppercase rounded">Neutral (1/8)</span>
            </div>
        </div>

        {{-- Fear & Greed Gauge --}}
        <div class="widget text-center">
            <div class="widget-title flex items-center justify-center gap-2"><i data-lucide="heart-pulse" class="w-3.5 h-3.5 text-purple-400"></i> Fear & Greed Index</div>
            <div class="relative w-32 h-16 mx-auto mt-2 mb-4 overflow-hidden">
                <div class="absolute inset-0 rounded-t-[999px] border-[6px] border-b-0" style="border-color: #ef4444 #f59e0b #10b981 #10b981;"></div>
                <div class="absolute bottom-0 left-1/2 w-1 h-14 bg-white rounded origin-bottom transition-transform duration-1000" id="gaugeNeedle" style="transform: translateX(-50%) rotate({{ ($sentiment['value'] / 100) * 180 - 90 }}deg);"></div>
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 bg-white rounded-full shadow-lg"></div>
            </div>
            <div class="text-3xl font-bold text-white mb-1">{{ $sentiment['value'] }}</div>
            <div class="text-xs font-bold uppercase {{ $sentiment['value'] > 60 ? 'text-emerald-400' : ($sentiment['value'] > 40 ? 'text-white' : 'text-rose-400') }}">{{ $sentiment['label'] }}</div>
            <div class="flex justify-between mt-3 text-[7px] font-bold text-gray-500 uppercase">
                <span>Extreme Fear</span><span>Neutral</span><span>Extreme Greed</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
495:     @endif --}}

    {{-- ══════════════════════════════════════
         SECTION 7: OPTIONS CHAIN + CALENDAR
         ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        {{-- Options Chain (Premium) --}}
        @if($isPremium)
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="layers" class="w-3.5 h-3.5 text-purple-400"></i> NIFTY Options Chain</div>
            <div class="grid grid-cols-3 gap-2 mb-3">
                <div class="text-center p-2 bg-white/[0.02] rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">PCR</div><div class="text-sm font-bold text-white">{{ $options['pcr'] }}</div></div>
                <div class="text-center p-2 bg-white/[0.02] rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Max Pain</div><div class="text-sm font-bold text-white">{{ $options['max_pain'] }}</div></div>
                <div class="text-center p-2 bg-white/[0.02] rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">IV</div><div class="text-sm font-bold text-purple-400">{{ $options['iv'] }}%</div></div>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-3">
                <div class="text-center p-2 bg-emerald-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Total Call OI</div><div class="text-xs font-bold text-emerald-400">{{ $options['calls_oi'] }}</div></div>
                <div class="text-center p-2 bg-rose-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Total Put OI</div><div class="text-xs font-bold text-rose-400">{{ $options['puts_oi'] }}</div></div>
            </div>
            <div class="text-[8px] font-bold text-gray-500 uppercase mb-2">Key Strikes</div>
            <div class="overflow-x-auto no-scrollbar -mx-2 px-2">
                <div class="min-w-[400px]">
                    <div class="grid grid-cols-5 gap-1 text-[8px] font-bold text-gray-500 uppercase mb-1 px-1"><div>Call OI</div><div>Call Chg</div><div class="text-center text-purple-400">Strike</div><div>Put OI</div><div>Put Chg</div></div>
                    @foreach($options['strikes'] as $s)
                    <div class="grid grid-cols-5 gap-1 text-[10px] py-1.5 border-b border-white/[0.02] px-1 items-center">
                        <div class="font-bold text-emerald-400">{{ $s['call_oi'] }}</div>
                        <div class="font-bold {{ str_starts_with($s['call_chg'], '+') ? 'text-emerald-400' : 'text-rose-400' }}">{{ $s['call_chg'] }}</div>
                        <div class="text-center font-bold text-white">{{ number_format($s['strike']) }}</div>
                        <div class="font-bold text-rose-400">{{ $s['put_oi'] }}</div>
                        <div class="font-bold {{ str_starts_with($s['put_chg'], '+') ? 'text-emerald-400' : 'text-rose-400' }}">{{ $s['put_chg'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-3 text-center"><span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[9px] font-bold uppercase rounded-full">{{ $options['buildup'] }}</span></div>
        </div>
        @else
        <div class="widget relative overflow-hidden">
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm z-10 flex flex-col items-center justify-center rounded-[1rem]"><i data-lucide="lock" class="w-6 h-6 text-amber-400 mb-2"></i><span class="text-xs font-bold text-gray-400 uppercase mb-2">Premium Feature</span><a href="{{ route('pricing') }}" class="px-4 py-1.5 bg-amber-500 text-black font-bold text-[9px] uppercase rounded-lg">Upgrade</a></div>
            <div class="widget-title">Options Chain</div>
            <div class="opacity-15 space-y-2"><div class="h-6 bg-white/5 rounded"></div><div class="h-6 bg-white/5 rounded"></div><div class="h-6 bg-white/5 rounded"></div><div class="h-6 bg-white/5 rounded"></div></div>
        </div>
        @endif

        {{-- Market Calendar --}}
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="calendar" class="w-3.5 h-3.5 text-purple-400"></i> Upcoming Events</div>
            <div class="space-y-0">
                @foreach($calendar as $ev)
                @php $impactColors = ['High' => 'rose', 'Medium' => 'white', 'Low' => 'gray']; $ic = $impactColors[$ev['impact']] ?? 'gray'; @endphp
                <div class="flex items-center justify-between gap-3 py-2 border-b border-white/[0.02]">
                    <div class="flex items-center gap-3">
                        <div class="w-12 text-center flex-shrink-0"><div class="text-xs font-bold text-white">{{ $ev['date'] }}</div></div>
                        <div class="flex-1">
                            <div class="text-xs font-bold text-gray-300">{{ $ev['event'] }}</div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[8px] font-bold text-gray-500 uppercase">{{ $ev['type'] }}</span>
                                <span class="text-[7px] font-bold px-1.5 py-0.5 rounded bg-{{ $ic }}-500/10 text-{{ $ic }}-400 uppercase">{{ $ev['impact'] }}</span>
                            </div>
                        </div>
                    </div>
                    <i data-lucide="bell" class="w-3.5 h-3.5 text-gray-600 hover:text-purple-400 cursor-pointer transition-colors"></i>
                </div>
                @endforeach
            </div>
        </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 8: RISK-REWARD CALCULATOR + TRADING TIPS
         ══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        {{-- Risk-Reward Calculator --}}
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="scale" class="w-3.5 h-3.5 text-purple-400"></i> Risk-Reward Calculator</div>
            <div class="grid grid-cols-3 gap-2 mb-3">
                <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Entry</label><input type="number" class="calc-input text-[10px]" id="rrEntry" placeholder="22450"></div>
                <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Target</label><input type="number" class="calc-input text-[10px]" id="rrTarget" placeholder="22700"></div>
                <div><label class="text-[8px] font-bold text-gray-500 uppercase block mb-0.5">Stop Loss</label><input type="number" class="calc-input text-[10px]" id="rrSL" placeholder="22300"></div>
            </div>
            <button onclick="calcRR()" class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs uppercase rounded-lg transition-all mb-3">Analyze R:R</button>
            <div id="rrResult" class="hidden">
                <div class="grid grid-cols-3 gap-2 mb-3">
                    <div class="text-center p-2 bg-emerald-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Reward</div><div class="text-sm font-bold text-emerald-400" id="rrReward">0</div></div>
                    <div class="text-center p-2 bg-rose-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">Risk</div><div class="text-sm font-bold text-rose-400" id="rrRisk">0</div></div>
                    <div class="text-center p-2 bg-purple-500/5 rounded-lg"><div class="text-[7px] font-bold text-gray-500 uppercase">R:R Ratio</div><div class="text-sm font-bold text-purple-400" id="rrRatio">0</div></div>
                </div>
                <div class="h-3 bg-white/5 rounded-full overflow-hidden flex">
                    <div class="h-full bg-emerald-500 rounded-l-full transition-all" id="rrBar" style="width: 50%"></div>
                    <div class="h-full bg-rose-500 rounded-r-full transition-all" id="rrBarRisk" style="width: 50%"></div>
                </div>
                <div class="text-center mt-2"><span class="text-[9px] font-bold uppercase" id="rrVerdict"></span></div>
            </div>
        </div>

        {{-- Trading Tips --}}
        <div class="widget">
            <div class="widget-title flex items-center gap-2"><i data-lucide="lightbulb" class="w-3.5 h-3.5 text-white"></i> Pro Trading Tips</div>
            <div class="space-y-3">
                @foreach($trading_tips as $tt)
                <div class="flex gap-3 p-3 bg-white/[0.02] rounded-lg border border-white/[0.03] hover:border-purple-500/20 transition-all">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center flex-shrink-0"><i data-lucide="{{ $tt['icon'] }}" class="w-4 h-4 text-purple-400"></i></div>
                    <div>
                        <div class="text-xs font-bold text-white mb-0.5">{{ $tt['title'] }}</div>
                        <p class="text-[10px] text-gray-400 leading-snug">{{ $tt['tip'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        </div>
    </div>

    {{-- ═ BOTTOM EXPORT BAR ═ --}}
    @if($isPremium)
    <div class="flex gap-3 mb-5">
        <button class="flex-1 py-3 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center gap-2 text-[9px] font-bold text-gray-500 hover:text-white transition-all uppercase"><i data-lucide="download" class="w-3.5 h-3.5"></i> Download PDF Report</button>
        <button class="flex-1 py-3 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center gap-2 text-[9px] font-bold text-gray-500 hover:text-white transition-all uppercase"><i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export CSV Data</button>
        <button class="flex-1 py-3 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center gap-2 text-[9px] font-bold text-gray-500 hover:text-white transition-all uppercase"><i data-lucide="bell-ring" class="w-3.5 h-3.5"></i> Set Price Alert</button>
        <button class="flex-1 py-3 bg-white/5 border border-white/5 rounded-xl flex items-center justify-center gap-2 text-[9px] font-bold text-gray-500 hover:text-white transition-all uppercase"><i data-lucide="printer" class="w-3.5 h-3.5"></i> Print Terminal</button>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script src="{{ asset('js/tabulator-global.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if($isPremium)
        // 1. AI Activity Table
        new Tabulator("#premium-ai-activity-table", {
            ...TABULATOR_BASE_CONFIG,
            data: @json($node_logs),
            headerVisible: false,
            columns: [
                {field: "msg", widthGrow: 1, formatter: (cell) => {
                    const row = cell.getRow().getData();
                    return `
                    <div class="flex items-start gap-2 py-1">
                        <span class="text-[9px] font-mono text-purple-400/60 flex-shrink-0">${row.time}</span>
                        <span class="text-[10px] text-gray-400 leading-snug">${row.msg}</span>
                        </div>
            </div>`;
                }},
            ]
        });

        // 2. Trade History Table
        new Tabulator("#premium-trade-history-table", {
            ...TABULATOR_BASE_CONFIG,
            data: @json($trade_history),
            layout: "fitDataStretch",
            responsiveLayout: false,
            columns: [
                {title: "Stock", field: "stock", minWidth: 120, formatter: (cell) => `<span class="font-bold text-[11px] text-white">${cell.getValue()}</span>`},
                {title: "Type", field: "type", minWidth: 90, formatter: (cell) => {
                    const val = cell.getValue();
                    const cls = val === 'BUY' ? 'text-emerald-400' : 'text-rose-400';
                    return `<span class="font-bold text-[10px] ${cls}">${val}</span>`;
                }},
                {title: "Entry", field: "entry", minWidth: 110, formatter: (cell) => `₹${cell.getValue().toLocaleString()}`},
                {title: "Exit", field: "exit", minWidth: 110, formatter: (cell) => `₹${cell.getValue().toLocaleString()}`},
                {title: "Qty", field: "qty", minWidth: 90},
                {title: "P&L", field: "pnl", minWidth: 120, formatter: (cell) => {
                    const val = cell.getValue();
                    const cls = val >= 0 ? 'text-emerald-400' : 'text-rose-400';
                    return `<span class="font-black font-whiskey ${cls}">${val >= 0 ? '+' : ''}₹${val.toLocaleString()}</span>`;
                }},
                {title: "Date", field: "date", minWidth: 140},
            ]
        });

        // 3. Portfolio Holdings Table
        new Tabulator("#premium-holdings-table", {
            ...TABULATOR_BASE_CONFIG,
            data: @json($portfolio['holdings']),
            layout: "fitDataStretch",
            responsiveLayout: false,
            columns: [
                {title: "Name", field: "name", minWidth: 130, formatter: (cell) => `<span class="font-bold text-[11px] text-white">${cell.getValue()}</span>`},
                {title: "Qty", field: "qty", minWidth: 90},
                {title: "Avg", field: "avg", minWidth: 110, formatter: (cell) => `₹${cell.getValue().toLocaleString()}`},
                {title: "LTP", field: "ltp", minWidth: 110, formatter: (cell) => `₹${cell.getValue().toLocaleString()}`},
                {title: "P&L", field: "pnl", minWidth: 120, formatter: (cell) => {
                    const val = cell.getValue();
                    const cls = val >= 0 ? 'text-emerald-400' : 'text-rose-400';
                    return `<span class="font-bold ${cls}">${val >= 0 ? '+' : ''}₹${val.toLocaleString()}</span>`;
                }},
            ]
        });
        @endif
    });

    // ── Clock ──
    function updateSync() { document.getElementById('lastSync').innerText = new Date().toLocaleTimeString(); }
    updateSync(); setInterval(updateSync, 1000);

    // ── Live Chart ──
    const canvas = document.getElementById('liveChart');
    if (canvas) {
        const ct = document.getElementById('chartContainer');
        const ctx = canvas.getContext('2d');
        let data = []; const max = 60;
        function resize() { canvas.width = ct.offsetWidth * 2; canvas.height = ct.offsetHeight * 2; ctx.scale(2, 2); }
        resize(); window.addEventListener('resize', resize);
        for (let i = 0; i < max; i++) data.push(50 + Math.sin(i * 0.12) * 25 + Math.random() * 8);
        function draw() {
            const w = ct.offsetWidth, h = ct.offsetHeight; ctx.clearRect(0, 0, w, h);
            ctx.strokeStyle = 'rgba(255,255,255,0.02)';
            for (let i = 1; i < 4; i++) { ctx.beginPath(); ctx.moveTo(0, h/4*i); ctx.lineTo(w, h/4*i); ctx.stroke(); }
            const g = ctx.createLinearGradient(0, 0, 0, h); g.addColorStop(0, 'rgba(147,51,234,0.25)'); g.addColorStop(1, 'rgba(147,51,234,0)');
            ctx.beginPath(); ctx.moveTo(0, h);
            data.forEach((p, i) => { const x = (w/(max-1))*i, y = h-(p/100)*h; i === 0 ? ctx.lineTo(x,y) : ctx.lineTo(x,y); });
            ctx.lineTo(w, h); ctx.fillStyle = g; ctx.fill();
            ctx.beginPath(); data.forEach((p, i) => { const x = (w/(max-1))*i, y = h-(p/100)*h; i === 0 ? ctx.moveTo(x,y) : ctx.lineTo(x,y); });
            ctx.strokeStyle = '#a855f7'; ctx.lineWidth = 1.5; ctx.shadowColor = '#a855f7'; ctx.shadowBlur = 8; ctx.stroke(); ctx.shadowBlur = 0;
            const ly = h-(data[data.length-1]/100)*h; ctx.beginPath(); ctx.arc(w, ly, 3, 0, Math.PI*2); ctx.fillStyle = '#a855f7'; ctx.shadowBlur = 10; ctx.fill(); ctx.shadowBlur = 0;
        }
        setInterval(() => { const l = data[data.length-1]; data.push(Math.max(10,Math.min(90,l+(Math.random()-0.48)*6))); if(data.length>max)data.shift(); draw(); }, 400);
        draw();
    }

    // ── Volume Ticker ──
    setInterval(() => { const b = 58 + Math.random() * 12; document.getElementById('buyVol').innerText = b.toFixed(1)+'%'; document.getElementById('sellVol').innerText = (100-b).toFixed(1)+'%'; }, 3000);

    // ── P&L Calculator ──
    function calculatePL() {
        const buy = parseFloat(document.getElementById('calcBuy')?.value||0);
        const sell = parseFloat(document.getElementById('calcSell')?.value||0);
        const qty = parseInt(document.getElementById('calcQty')?.value||0);
        const pl = (sell-buy)*qty;
        const el = document.getElementById('plResult'), val = document.getElementById('plValue');
        if(el&&val) { el.classList.remove('hidden'); val.innerText = (pl>=0?'+':'')+'₹'+pl.toLocaleString('en-IN',{minimumFractionDigits:2}); val.className = 'text-xl font-bold '+(pl>=0?'text-emerald-400':'text-rose-400'); }
    }

    // ── Market Movers Tabs ──
    function showMovers(type) {
        document.getElementById('moverGainers').style.display = type === 'gainers' ? 'block' : 'none';
        document.getElementById('moverLosers').style.display = type === 'losers' ? 'block' : 'none';
        document.getElementById('tabGainers').className = 'tab-btn' + (type === 'gainers' ? ' active' : '');
        document.getElementById('tabLosers').className = 'tab-btn' + (type === 'losers' ? ' active' : '');
    }

    // ── Risk-Reward Calculator ──
    function calcRR() {
        const entry = parseFloat(document.getElementById('rrEntry')?.value||0);
        const target = parseFloat(document.getElementById('rrTarget')?.value||0);
        const sl = parseFloat(document.getElementById('rrSL')?.value||0);
        if(!entry||!target||!sl) return;
        const reward = Math.abs(target - entry);
        const risk = Math.abs(entry - sl);
        const ratio = risk > 0 ? (reward / risk).toFixed(2) : '∞';
        const pct = reward / (reward + risk) * 100;
        document.getElementById('rrResult').classList.remove('hidden');
        document.getElementById('rrReward').innerText = reward.toFixed(0) + ' pts';
        document.getElementById('rrRisk').innerText = risk.toFixed(0) + ' pts';
        document.getElementById('rrRatio').innerText = '1:' + ratio;
        document.getElementById('rrBar').style.width = pct + '%';
        document.getElementById('rrBarRisk').style.width = (100-pct) + '%';
        const v = document.getElementById('rrVerdict');
        if(ratio >= 2) { v.innerText = '✅ Excellent Trade Setup'; v.className = 'text-[9px] font-bold uppercase text-emerald-400'; }
        else if(ratio >= 1) { v.innerText = '⚠️ Acceptable Risk'; v.className = 'text-[9px] font-bold uppercase text-white'; }
        else { v.innerText = '❌ Poor Risk-Reward'; v.className = 'text-[9px] font-bold uppercase text-rose-400'; }
    }

    // ── GSAP ──
    gsap.fromTo(".signal-card, .widget", { y: 15, opacity: 0 }, { y: 0, opacity: 1, stagger: 0.04, duration: 0.5, ease: "power3.out", delay: 0.1 });
</script>
@endpush

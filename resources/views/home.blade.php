@extends('layouts.app')

@section('title', 'AlgoTra AI | Smart Algo Trading Signals')

@push('styles')
<style>
    .hero-upgrade-wrap {
        position: relative;
        display: inline-flex;
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .hero-upgrade-wrap .border-spinner {
        position: absolute;
        inset: 0;
        border-radius: 14px;
        z-index: 0;
        overflow: hidden;
    }
    .hero-upgrade-wrap .border-spinner::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 300%;
        height: 300%;
        background: conic-gradient(
            transparent 0deg,
            transparent 200deg,
            rgba(115, 76, 137, 0.0) 220deg,
            rgba(115, 76, 137, 0.3) 240deg,
            rgba(147, 51, 234, 0.6) 255deg,
            rgba(168, 85, 247, 0.8) 270deg,
            rgba(192, 132, 252, 0.9) 280deg,
            rgba(233, 213, 255, 1.0) 290deg,
            rgba(192, 132, 252, 0.9) 300deg,
            rgba(168, 85, 247, 0.8) 310deg,
            rgba(147, 51, 234, 0.6) 325deg,
            rgba(115, 76, 137, 0.3) 340deg,
            rgba(115, 76, 137, 0.0) 355deg,
            transparent 360deg
        );
        will-change: transform;
        backface-visibility: hidden;
        transform: translate(-50%, -50%) rotate(0deg) translateZ(0);
        animation: spin-border 4s linear infinite;
    }
    .hero-upgrade-wrap .border-fill {
        position: absolute;
        inset: 2px;
        border-radius: 12px;
        background: linear-gradient(145deg, #2d1b4e, #1a0a2e, #0a0515);
        z-index: 1;
    }
    .hero-upgrade-wrap .btn-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        padding: 1rem 2rem;
        color: white;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        white-space: nowrap;
    }
    .hero-glow {
        position: absolute;
        inset: -12px;
        border-radius: 26px;
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
        opacity: 0.5;
        transition: opacity 0.4s ease;
    }
    .hero-glow::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 300%;
        height: 300%;
        background: conic-gradient(
            transparent 0deg,
            transparent 220deg,
            rgba(168, 85, 247, 0.0) 245deg,
            rgba(168, 85, 247, 0.2) 265deg,
            rgba(192, 132, 252, 0.35) 280deg,
            rgba(233, 213, 255, 0.45) 290deg,
            rgba(192, 132, 252, 0.35) 300deg,
            rgba(168, 85, 247, 0.2) 315deg,
            rgba(168, 85, 247, 0.0) 340deg,
            transparent 355deg,
            transparent 360deg
        );
        will-change: transform;
        backface-visibility: hidden;
        transform: translate(-50%, -50%) rotate(0deg) translateZ(0);
        animation: spin-border 4s linear infinite;
        filter: blur(16px);
    }
    .hero-upgrade-wrap:hover .hero-glow { opacity: 1; }
    .hero-upgrade-wrap:hover { transform: translateY(-2px) scale(1.03); }
    @keyframes spin-border {
        from { transform: translate(-50%, -50%) rotate(0deg) translateZ(0); }
        to { transform: translate(-50%, -50%) rotate(360deg) translateZ(0); }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="relative">
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-12 flex flex-col lg:flex-row items-center justify-between py-6 sm:py-10 lg:py-12 gap-8 sm:gap-12">
        <!-- Left Column -->
        <div class="w-full lg:w-5/12 flex flex-col gap-8">
            <div class="relative z-20 space-y-8">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full glass-panel border border-purple-500/20 text-purple-400 text-[10px] font-bold uppercase tracking-[0.2em] hero-stagger opacity-0">
                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                    Join 15k+ traders using AI Trading
                </div>
                
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-professional text-white leading-tight">
                    <span class="block hero-stagger opacity-0">Trade</span>
                    <span class="block hero-stagger opacity-0">Smarter</span>
                    <span class="block text-vibrant hero-stagger opacity-0">Not Harder</span>
                </h1>

                <p class="text-slate-400 text-sm sm:text-lg md:text-xl leading-relaxed max-w-xl hero-stagger opacity-0 font-medium">
                    Real-time market insights with best entry points and smart risk control powered by AI price predictions.
                </p>

                <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 mt-6 sm:mt-8 hero-stagger opacity-0">
                    <a href="{{ url('/pricing') }}" class="hero-upgrade-wrap w-full sm:w-auto group">
                        <div class="hero-glow"></div>
                        <div class="border-spinner"></div>
                        <div class="border-fill"></div>
                        <span class="btn-content">
                            <i data-lucide="crown" class="w-4 h-4"></i>
                            Upgrade To Premium
                        </span>
                    </a>
                    <a href="#signals" class="w-full sm:w-auto glass-panel border border-white/10 hover:bg-white/5 text-white font-bold py-4 sm:py-5 px-8 sm:px-10 rounded-2xl transition-all transform hover:-translate-y-1 text-[11px] uppercase tracking-wider flex items-center justify-center gap-3">
                        Explore Signals
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>


        </div>

        <!-- Right Column: AI Terminal -->
        <div class="w-full lg:w-6/12 relative flex items-center justify-center">
             <!-- Floating Crypto Assets -->
             <!-- <div class="absolute -top-10 -left-10 w-20 h-20 glass-panel rounded-full hidden md:flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.2">
                <i data-lucide="bitcoin" class="w-10 h-10 text-amber-500"></i>
             </div> -->
             <!-- <div class="absolute bottom-10 -right-4 w-16 h-16 glass-panel rounded-full hidden md:flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.5">
                <i data-lucide="coins" class="w-8 h-8 text-blue-400"></i>
             </div> -->
             <!-- <div class="absolute top-1/2 -right-12 w-14 h-14 glass-panel rounded-full hidden md:flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.8">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-400"></i>
             </div> -->

             <!-- Floating Badges -->
             <div class="absolute top-0 right-10 glass-panel rounded-full py-2 px-4 hidden sm:flex items-center gap-2 z-20 hero-stagger opacity-0 border border-purple-500/30">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                <span class="text-[9px] font-bold text-slate-200 font-whiskey tracking-widest uppercase">LIVE TRADING ACTIVE</span>
            </div>

            <!-- Premium Terminal Device Frame -->
            <div class="relative w-full max-w-[320px] sm:max-w-[420px] mx-auto hero-terminal opacity-0 scale-95 transition-all duration-1000">
                <!-- Device Outer Frame (The "Hardware") -->
                <div class="relative aspect-[4/5] bg-[#0c0518] rounded-[3.5rem] p-2.5 border-[6px] border-[#1a1325] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.8),0_0_50px_rgba(147,51,234,0.1)] terminal-frame-glow">
                    <!-- Subtle Metallic Reflection -->
                    <div class="absolute inset-0 rounded-[3rem] border border-white/5 pointer-events-none"></div>
                    
                    <!-- Hardware Details: Side Button -->
                    <div class="absolute -right-[8px] top-32 w-[4px] h-16 bg-[#2a1f3d] rounded-r-lg border-r border-white/5"></div>
                    
                    <!-- Screen Area -->
                    <div class="w-full h-full bg-[#05020a] rounded-[3rem] border border-white/10 relative overflow-hidden flex flex-col pt-12 p-6 shadow-inner">
                        
                        <!-- Dynamic Island / Hardware Sensors -->
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 w-28 h-7 bg-black rounded-full flex items-center justify-center gap-3 border border-white/5 z-30">
                            <div class="w-2 h-2 rounded-full bg-[#0c0518] border border-white/5"></div>
                            <div class="w-8 h-1 bg-white/5 rounded-full"></div>
                        </div>

                        <!-- Gloss/Reflection Layer -->
                        <div class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-white/[0.03] to-transparent pointer-events-none z-20"></div>

                        <div class="flex justify-between items-center mb-10 relative z-10">
                            <div class="flex items-center gap-2 text-purple-500">
                                <i data-lucide="zap" class="w-5 h-5 fill-purple-500"></i>
                                <span class="text-[9px] font-bold tracking-widest uppercase">NEURAL PATHWAY</span>
                            </div>
                            <div class="flex gap-2">
                                 <div class="w-2 h-2 rounded-full bg-rose-500/50"></div>
                                 <div class="w-2 h-2 rounded-full bg-amber-500/50"></div>
                                 <div class="w-2 h-2 rounded-full bg-emerald-500/50"></div>
                            </div>
                        </div>

                        <div class="mb-10 relative z-10">
                            <div class="text-slate-500 text-[9px] tracking-[0.3em] font-bold mb-2">SCANNING MARKET DEPTH</div>
                            <div class="flex items-end gap-3">
                                 <div class="text-5xl font-professional text-white tracking-tighter" id="accuracy-counter">98.4%</div>
                                 <div class="text-emerald-400 text-[10px] font-bold pb-2">+2.45%</div>
                            </div>
                        </div>

                        <!-- Chart SVG -->
                        <div class="flex-1 relative border-t border-white/5 pt-8 overflow-hidden z-10">
                            <svg class="w-full h-full" viewBox="0 0 400 200" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="chart-grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:rgba(147, 51, 234, 0.4);stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:rgba(147, 51, 234, 0);stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <path class="chart-path" d="M0,150 Q50,140 100,160 T200,100 T300,120 T400,80 V200 H0 Z" fill="url(#chart-grad)"></path>
                                <path class="chart-line" d="M0,150 Q50,140 100,160 T200,100 T300,120 T400,80" fill="none" stroke="#a855f7" stroke-width="4" stroke-linecap="round"></path>
                                
                                <!-- Animated Pulse -->
                                <circle cx="400" cy="80" r="5" fill="#a855f7">
                                    <animate attributeName="r" values="5;8;5" dur="1s" repeatCount="indefinite" />
                                    <animate attributeName="opacity" values="1;0.5;1" dur="1s" repeatCount="indefinite" />
                                </circle>
                            </svg>
                        </div>

                        <div class="mt-6 flex justify-between items-center text-[9px] font-bold text-slate-600 relative z-10">
                            <span>Est 2024</span>
                            <div class="flex items-center gap-2">
                                 <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                 SYSTEM OPERATIONAL
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ambient Glows -->
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-purple-600/20 blur-[150px] -z-10 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-indigo-600/20 blur-[150px] -z-10 rounded-full pointer-events-none"></div>
        </div>
        </div>
    </div>

    <!-- Ticker Section -->
    <div class="py-6 glass-panel border-y border-white/5 overflow-hidden z-20 relative mt-20">
        <div class="ticker-wrapper flex whitespace-nowrap animate-ticker">
            @php
                $ticker_items = ['Trending Stocks', 'Market Movers', 'Breakout Opportunities', 'High Momentum Picks', 'AI Watchlist Signals'];
                $all_ticker = array_merge($ticker_items, $ticker_items, $ticker_items, $ticker_items);
            @endphp
            @foreach ($all_ticker as $item)
                <div class="inline-flex items-center gap-6 px-12 border-r border-white/5 group/ticker">
                    <span class="font-bold text-slate-400 group-hover/ticker:text-white transition-colors text-xs tracking-[0.2em] uppercase">{{ $item }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_10px_#a855f7] animate-pulse"></span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Signals Section -->
    <section id="signals" class="pt-16 sm:pt-32 pb-8 sm:pb-16 container mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-5xl font-professional text-white mb-6">Live <span class="text-vibrant">Market Signals</span></h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-medium">Real-time intelligence streams providing validated entry and exit points for global assets.</p>
            </div>
            <a href="{{ url('/signals/past') }}" class="group flex items-center gap-3 text-white font-bold text-xs tracking-widest">
                EXPLORE ALL SIGNALS 
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>

        <div class="glass-panel rounded-[2.5rem] overflow-hidden reveal-section signals-table-container">
            @if($isPremium)
            <div class="overflow-x-auto no-scrollbar">
                <table class="signals-table signals-table-desktop">
                    <thead>
                        <tr>
                            <th onclick="sortSignals('stock')">Stock <i data-lucide="chevron-down" class="w-3 h-3 inline opacity-30"></i></th>
                            <th class="text-center">Type</th>
                            <th class="text-right">Entry</th>
                            <th class="text-right">Stop Loss</th>
                            <th class="text-right">Target</th>
                            <th class="text-right">Breakeven</th>
                            <th onclick="sortSignals('time')" class="text-center">Date/Time <i data-lucide="chevron-down" class="w-3 h-3 inline opacity-30"></i></th>
                            <th class="text-center">Result</th>
                            <th class="text-right">Qty</th>
                            <th class="text-right">PNL</th>
                        </tr>
                    </thead>
                    <tbody id="signals-tbody">
                        @forelse($signals as $signal)
                        @php
                            $timestamp = strtotime($signal->entry_date . ' ' . $signal->entry_time);
                        @endphp
                        <tr class="signal-row hover:bg-white/[0.02] transition-colors" 
                            data-time="{{ $timestamp }}">
                            <td class="py-4">
                                <span class="font-bold text-xs text-white uppercase tracking-tighter">{{ $signal->stock_name }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $type = strtoupper($signal->signal_type ?? 'BUY');
                                    $typeColor = $type === 'BUY' ? 'text-emerald-400' : 'text-rose-400';
                                @endphp
                                <span class="text-[10px] font-black {{ $typeColor }}">{{ $type }}</span>
                            </td>
                            <td class="text-right font-mono text-sm text-white">₹{{ number_format($signal->entry, 1) }}</td>
                            <td class="text-right font-mono text-xs text-rose-500/80">₹{{ number_format($signal->sl, 1) }}</td>
                            <td class="text-right font-mono text-sm text-emerald-400">₹{{ number_format($signal->target, 1) }}</td>
                            <td class="text-right font-mono text-sm text-blue-400">₹{{ number_format($signal->breakeven, 1) }}</td>
                            <td class="text-center">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-white font-bold">{{ $signal->entry_date }}</span>
                                    <span class="text-[9px] text-slate-500 uppercase">{{ date('h:i A', $timestamp) }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @php
                                    $res = (strtoupper($signal->result ?: 'ACTIVE'));
                                    if (in_array($res, ['WIN', 'TP HIT', 'ACTIVE'])) {
                                        $resCls = 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20';
                                    } elseif (in_array($res, ['LOSS', 'SL HIT'])) {
                                        $resCls = 'bg-rose-500/10 text-rose-400 border-rose-500/20';
                                    } else {
                                        $resCls = 'bg-blue-500/10 text-blue-400 border-blue-500/20';
                                    }
                                @endphp
                                <span class="px-2 py-0.5 rounded text-[9px] font-black border {{ $resCls }}">{{ $res }}</span>
                            </td>
                            <td class="text-right font-mono text-xs text-slate-400">{{ $signal->qty }}</td>
                            <td class="text-right font-bold text-sm {{ $signal->sim_pnl >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ $signal->sim_pnl >= 0 ? '+' : '' }}₹{{ number_format($signal->sim_pnl, 1) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-20 text-center">
                                <i data-lucide="search-x" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
                                <p class="text-slate-500 text-xs uppercase font-bold">No AI signals detected right now.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card Layout --}}
            <div class="signals-mobile-cards p-4">
                @foreach($signals as $signal)
                @php
                    $timestamp = strtotime($signal->entry_date . ' ' . $signal->entry_time);
                    $res = (strtoupper($signal->result ?: 'ACTIVE'));
                    $resCls = in_array($res, ['WIN', 'TP HIT', 'ACTIVE']) ? 'text-emerald-400' : (in_array($res, ['LOSS', 'SL HIT']) ? 'text-rose-400' : 'text-blue-400');
                @endphp
                <div class="signal-card space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-white/5">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-base text-white uppercase">{{ $signal->stock_name }}</span>
                        </div>
                        <span class="text-[10px] font-black uppercase {{ $signal->signal_type === 'BUY' ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $signal->signal_type }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <div class="text-[8px] font-bold text-slate-500 uppercase mb-1">Entry Price</div>
                            <div class="font-mono text-sm text-white">₹{{ number_format($signal->entry, 1) }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-slate-500 uppercase mb-1">Stop Loss</div>
                            <div class="font-mono text-sm text-rose-500/80">₹{{ number_format($signal->sl, 1) }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-slate-500 uppercase mb-1">Target / BE</div>
                            <div class="font-mono text-[10px] text-emerald-400">T: ₹{{ number_format($signal->target, 1) }}</div>
                            <div class="font-mono text-[10px] text-blue-400 border-t border-white/5 mt-1 pt-1">B: ₹{{ number_format($signal->breakeven, 1) }}</div>
                        </div>
                        <div>
                            <div class="text-[8px] font-bold text-slate-500 uppercase mb-1">Result / Qty</div>
                            <div class="flex items-center gap-1.5 pt-1">
                                <span class="w-1.5 h-1.5 rounded-full {{ str_replace('text-', 'bg-', $resCls) }} animate-pulse"></span>
                                <span class="text-[10px] font-black {{ $resCls }} uppercase">{{ $res }}</span>
                            </div>
                            <div class="text-[10px] text-slate-500 font-bold mt-1">QTY: {{ $signal->qty }}</div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-white/5">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-bold">{{ $signal->entry_date }}</span>
                            <span class="text-[8px] text-slate-600 font-bold uppercase">{{ date('h:i A', $timestamp) }}</span>
                        </div>
                        <div class="font-bold text-sm {{ $signal->sim_pnl >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                            {{ $signal->sim_pnl >= 0 ? '+' : '' }}₹{{ number_format($signal->sim_pnl, 1) }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-white/5 flex justify-center">
                <a href="{{ url('/signals/past') }}" class="group bg-purple-600/10 hover:bg-purple-600 border border-purple-500/30 text-purple-400 hover:text-white px-8 py-3 rounded-xl font-bold text-[10px] tracking-widest transition-all shadow-[0_0_20px_rgba(147,51,234,0.1)] hover:shadow-purple-500/40 uppercase">
                    Explore All Signals
                </a>
            </div>

            @push('scripts')
            <script>
                let sortDirections = {};
                function sortSignals(field) {
                    const tbody = document.getElementById('signals-tbody');
                    const rows = Array.from(tbody.querySelectorAll('.signal-row'));
                    const direction = sortDirections[field] === 'asc' ? 'desc' : 'asc';
                    sortDirections[field] = direction;

                    rows.sort((a, b) => {
                        let valA, valB;
                        if (field === 'time') {
                            valA = parseInt(a.dataset.time);
                            valB = parseInt(b.dataset.time);
                        } else if (field === 'stock') {
                            valA = a.cells[0].innerText.trim().toLowerCase();
                            valB = b.cells[0].innerText.trim().toLowerCase();
                        } else {
                            // Default for numeric or other text
                            valA = a.innerText.trim().toLowerCase();
                            valB = b.innerText.trim().toLowerCase();
                        }

                        if (valA === valB) return 0;
                        if (direction === 'asc') return valA > valB ? 1 : -1;
                        return valA < valB ? 1 : -1;
                    });

                    rows.forEach(row => tbody.appendChild(row));
                }
            </script>
            @endpush
            @else
            <!-- Lock Overlay for Landing Page -->
            <div class="p-12 text-center bg-gradient-to-t from-purple-900/40 to-transparent">
                <div class="w-12 h-12 bg-amber-400 text-black rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl shadow-amber-400/20 animate-bounce">
                    <i data-lucide="lock" class="w-6 h-6"></i>
                </div>
                <h3 class="font-professional text-xl text-white mb-2 uppercase">Neural Prediction Stream Restricted</h3>
                <p class="text-slate-400 text-sm mb-8 max-w-lg mx-auto italic">Full data terminal access is reserved for Premium King members only. Precision levels and real-time execution alerts currently blurred.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ url('/pricing') }}" class="bg-black text-white font-bold py-4 px-10 rounded-2xl text-[10px] hover:scale-105 transition-all shadow-lg shadow-white/20 uppercase">Unlock Terminal</a>
                    <a href="{{ url('/register') }}" class="glass-panel text-white font-bold py-4 px-10 rounded-2xl text-[10px] hover:bg-white/10 transition-all uppercase">Initialize Terminal</a>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- Pricing Packages Section (hidden from home page)
    @if(isset($packages) && $packages->count() > 0)
    <section class="py-20 sm:py-32 relative">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-16">
                <span class="font-whiskey text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Choose Your Plan</span>
                <h2 class="text-3xl md:text-5xl font-bold-tight text-white mb-6 uppercase">Powerful <span class="text-vibrant">AI Features</span></h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-medium">Precision-engineered tools designed for modern market conditions, providing you with a definitive edge.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
                @foreach($packages as $index => $package)
                @php $isMiddle = ($packages->count() >= 3 && $index === 1); @endphp
                <div class="relative group">
                    <div class="relative glass-panel p-8 sm:p-10 rounded-[2.5rem] border {{ $isMiddle ? 'border-[#734C89]/30' : 'border-white/10' }} overflow-hidden transition-all duration-300 hover:-translate-y-2 h-full flex flex-col">
                        @if($isMiddle)
                        <div class="absolute top-5 right-5">
                            <span class="text-[7px] font-black font-whiskey uppercase tracking-[0.2em] text-white px-3 py-1.5 rounded-full" style="background: linear-gradient(135deg, #734C89, #9333ea);">Popular</span>
                        </div>
                        @endif

                        <!-- Package Name -->
                        <div class="mb-6">
                            <h3 class="font-whiskey text-lg font-black text-white uppercase italic tracking-tight">{{ $package->name }}</h3>
                            @if($package->tags_json && count($package->tags_json) > 0)
                            <div class="flex flex-wrap gap-1.5 mt-3">
                                @foreach(array_slice($package->tags_json, 0, 2) as $tag)
                                <span class="text-[7px] font-bold font-whiskey uppercase tracking-widest px-2.5 py-1 rounded-full border border-white/10" style="background-color: {{ $tag['color'] ?? '#9333ea' }}20; color: {{ $tag['color'] ?? '#9333ea' }};">{{ $tag['name'] ?? $tag }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white font-whiskey">&#8377;{{ number_format($package->price, 0) }}</span>
                            <span class="text-xs text-gray-500 font-medium ml-1">/ {{ $package->duration_days }} days</span>
                        </div>

                        <!-- Description -->
                        <p class="text-[10px] font-bold font-whiskey text-gray-500 uppercase tracking-widest mb-6 leading-relaxed">{{ $package->description }}</p>

                        <!-- Features -->
                        @if($package->features && count($package->features) > 0)
                        <ul class="space-y-3 mb-8 flex-1">
                            @foreach(array_slice($package->features, 0, 4) as $feature)
                            <li class="flex items-start gap-3 text-sm text-gray-300">
                                <i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                                <span>{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                        @endif

                        <!-- CTA -->
                        <a href="{{ url('/pricing') }}" class="block w-full py-4 rounded-2xl text-center font-black font-whiskey text-[10px] tracking-[0.2em] uppercase italic transition-all hover:scale-[1.02] active:scale-[0.98] {{ $isMiddle ? 'text-white hover:shadow-[0_0_30px_rgba(115,76,137,0.4)]' : 'bg-white/5 border border-white/10 text-white hover:bg-white/10 hover:border-purple-500/30' }}" style="{{ $isMiddle ? 'background: linear-gradient(135deg, #734C89, #9333ea);' : '' }}">
                            Get Started
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Link -->
            <div class="text-center mt-12">
                <a href="{{ url('/pricing') }}" class="inline-flex items-center gap-2 text-[10px] font-black font-whiskey text-purple-400 uppercase tracking-[0.2em] hover:text-white transition-colors group">
                    View All Plans
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>
    @endif
    --}}

    <!-- Premium Plans Section -->
    @include('components.premium-plans', ['mode' => 'dynamic'])

    <!-- Why Our AI -->

    <section id="features" class="pt-16 sm:pt-24 pb-16 sm:pb-24 relative bg-white/[0.01]">
        <div class="container mx-auto px-6">
             <div class="text-center mb-20">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Core Advantages</span>
                <h2 class="text-3xl md:text-5xl font-professional text-white mb-6 uppercase">Why Our AI is <span class="text-vibrant">Powerful</span></h2>
                <p class="text-slate-400 max-w-2xl mx-auto text-sm leading-relaxed">Built on years of quantitative research and advanced machine learning, our neural engine delivers institutional-grade analysis to every trader.</p>
             </div>
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php 
                $feats = [
                    ['icon' => 'brain', 'title' => 'Neural Accuracy', 'desc' => 'Multi-layered LSTM and transformer models trained on 15+ years of market microstructure data for pattern-level precision.', 'color' => 'purple'],
                    ['icon' => 'shield-check', 'title' => 'Risk Governance', 'desc' => 'Automated stop-loss algorithms and position sizing models designed to protect your capital in volatile conditions.', 'color' => 'emerald'],
                    ['icon' => 'bell-ring', 'title' => 'Real-time Alerts', 'desc' => 'Multi-channel delivery via dashboard, Telegram, and email ensures you never miss a high-probability trade entry.', 'color' => 'blue'],
                    ['icon' => 'trending-up', 'title' => 'Market Intelligence', 'desc' => 'Sentiment analysis, volume profiling, and volatility metrics distilled into actionable, easy-to-read insights.', 'color' => 'amber']
                ];
                @endphp
                @foreach($feats as $f)
                <div class="glass-panel p-10 rounded-[2.5rem] hover:-translate-y-3 transition-all duration-300 group border border-white/5 hover:border-{{ $f['color'] }}-500/30">
                    <div class="w-14 h-14 bg-{{ $f['color'] }}-500/10 rounded-2xl flex items-center justify-center text-{{ $f['color'] }}-400 mb-8 group-hover:bg-{{ $f['color'] }}-500 group-hover:text-white transition-all border border-{{ $f['color'] }}-500/20">
                        <i data-lucide="{{ $f['icon'] }}" class="w-7 h-7"></i>
                    </div>
                    <h3 class="font-professional text-base mb-4 text-white tracking-tight">{{ $f['title'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
             </div>
        </div>
    </section>

    <!-- Alert Feature -->
    <section class="pt-16 sm:pt-24 pb-16 sm:pb-24 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="p-6 sm:p-12 md:p-20 rounded-[2rem] sm:rounded-[5rem] bg-[#0c0518] border border-white/5 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-600/10 blur-[130px] -z-10 group-hover:bg-purple-600/15 transition-all duration-700"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[100px] -z-10"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 sm:gap-20 items-center">
                    <div class="reveal-left">
                        <h2 class="text-3xl md:text-6xl font-professional mb-8 leading-[1.1]">
                            <span class="text-white block">Never Miss An</span>
                            <span class="text-vibrant block">Opportunity</span>
                        </h2>
                        <p class="text-slate-400 text-sm sm:text-lg mb-8 sm:mb-12 max-w-md font-medium leading-relaxed">Our multi-channel alert system ensures you are always connected to the market pulse.</p>
                        
                        <div class="space-y-5">
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-emerald-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                    <i data-lucide="smartphone" class="w-5 h-5"></i>
                                </div>
                                <span class="font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">MOBILE PUSH NOTIFICATIONS</span>
                            </div>
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-purple-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                </div>
                                <span class="font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">DASHBOARD LIVE ALERTS</span>
                            </div>
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-blue-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <span class="font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">REAL-TIME EMAIL INSIGHTS</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative flex justify-center items-center reveal-right overflow-hidden">
                        <!-- Floating ambient blobs -->
                        <div class="absolute -top-10 -left-10 w-48 h-24 glass-panel rounded-[2rem] border border-white/10 -rotate-12 blur-[2px] opacity-40"></div>
                        <div class="absolute -bottom-10 -right-10 w-48 h-24 glass-panel rounded-[2rem] border border-white/10 rotate-6 blur-[1px] opacity-40 scale-110"></div>

                        <!-- Notification Card -->
                        <div class="relative w-full max-w-sm glass-panel p-10 rounded-[3rem] border border-white/10 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] z-10 transform -rotate-3 hover:rotate-0 transition-all duration-700 overflow-hidden group/card">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-center gap-5 mb-10 relative z-10">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-600/40 relative">
                                    <div class="absolute inset-0 bg-white/20 rounded-2xl animate-ping opacity-20"></div>
                                    <i data-lucide="bell" class="w-6 h-6 text-white relative z-10"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-purple-400 text-[8px] font-bold uppercase tracking-[0.4em] mb-1 leading-none">System Core</span>
                                    <span class="font-professional text-[12px] tracking-[0.2em] text-white uppercase">NEW SIGNAL ALERT</span>
                                </div>
                            </div>
                            
                            <div class="space-y-6 relative z-10">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-gray-500 text-[9px] font-bold uppercase tracking-widest mb-1">Pair</span>
                                        <span class="text-white text-xl font-professional">RELIANCE</span>
                                    </div>
                                    <!-- <div class="text-right flex flex-col">
                                        <span class="text-gray-500 text-[9px] font-black font-whiskey uppercase tracking-widest mb-1">Status</span>
                                        <span class="text-emerald-400 text-sm font-black font-whiskey animate-pulse">● LONG / BUY</span>
                                    </div> -->
                                </div>
                                
                                <!-- <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-between">
                                    <span class="text-gray-500 text-[9px] font-black font-whiskey uppercase tracking-widest">Entry Price</span>
                                        <span class="text-white text-lg font-black font-whiskey tracking-tight">PROTECTED</span>
                                </div> -->

                                <div class="pt-4">
                                    <div class="w-full py-4 bg-purple-600/20 rounded-2xl border border-purple-500/30 text-center text-[9px] font-bold uppercase tracking-[0.2em] text-purple-400">
                                        STOCHASTIC RSI OVERBOUGHT
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="pt-16 sm:pt-24 pb-16 sm:pb-24 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-24">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Simple Process</span>
                <h2 class="text-3xl md:text-5xl font-professional text-white mb-6 uppercase">How It <span class="text-vibrant">Works</span></h2>
                <p class="text-slate-400 max-w-xl mx-auto text-sm leading-relaxed">Master the market in three simplified steps — from connecting your dashboard to executing profitable trades.</p>
            </div>

            <div class="relative mt-24">
                <!-- Progress Line placeholder removed -->
                <div class="absolute top-1/2 left-0 w-full h-[1px] bg-white/10 -translate-y-1/2 hidden lg:block">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 relative z-10">
                    @php 
                    $steps = [
                        ['n' => '01', 'icon' => 'link', 't' => 'Connect Terminal', 'd' => 'Create your account and access the neural trading dashboard. Link your watchlist or follow signals manually in real-time.'],
                        ['n' => '02', 'icon' => 'brain', 't' => 'AI Analysis', 'd' => 'Our engine scans 500+ data points per second using LSTM models to identify the highest-probability entry and exit zones.'],
                        ['n' => '03', 'icon' => 'rocket', 't' => 'Execute & Profit', 'd' => 'Receive instant multi-channel alerts. Execute trades with precision entry levels, calculated stop losses, and multi-target exits.']
                    ];
                    @endphp
                    @foreach($steps as $s)
                    <div class="glass-panel p-10 rounded-[3rem] text-center reveal-step group hover:border-purple-500/40 transition-all duration-500 border border-white/5">
                        <div class="relative mb-10 inline-block">
                             <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto shadow-2xl shadow-purple-600/30 font-professional text-2xl font-bold relative z-10 group-hover:scale-110 transition-transform">
                                {{ $s['n'] }}
                            </div>
                            <div class="absolute inset-0 bg-purple-500 blur-2xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        </div>
                        <h3 class="font-professional text-base mb-4 text-white tracking-tight">{{ $s['t'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-[260px] mx-auto">{{ $s['d'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="pt-16 pb-16 container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Social Proof</span>
            <h2 class="text-3xl md:text-5xl font-professional text-white mb-6 uppercase">Traders Trust <span class="text-vibrant">Data</span>, Not Noise</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @php 
            $reviews = [
                ['text' => 'The AI signals completely transformed my trading approach. I stopped emotional trading and started following data-driven setups. My consistency improved dramatically within the first month.', 'name' => 'Rahul Sharma', 'role' => 'Day Trader, Mumbai', 'initials' => 'RS'],
                ['text' => 'The risk management layer alone made the premium subscription worth it. The stop-loss algorithms saved me from multiple catastrophic positions during volatile sessions.', 'name' => 'Priya Desai', 'role' => 'Swing Trader, Pune', 'initials' => 'PD'],
                ['text' => 'AI pattern recognition is incredibly precise. Entry points are consistently near optimal levels. I finally trade with a structured plan instead of guessing on FOMO.', 'name' => 'Arjun Mehta', 'role' => 'Options Trader, Delhi', 'initials' => 'AM']
            ];
            @endphp
            @foreach($reviews as $i => $r)
            <div class="glass-panel p-6 sm:p-8 rounded-2xl sm:rounded-3xl relative border border-white/5 hover:border-purple-500/20 transition-all group overflow-hidden">
                <div class="absolute -top-4 -left-4 w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-purple-600/30 pointer-events-none">
                    <i data-lucide="quote" class="w-5 h-5 text-white fill-white"></i>
                </div>
                <div class="flex gap-1 mb-4 mt-2">
                    @for($j = 0; $j < 5; $j++)
                    <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                    @endfor
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-8">"{{ $r['text'] }}"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center font-bold text-white text-xs">{{ $r['initials'] }}</div>
                    <div>
                        <div class="text-sm font-bold text-white">{{ $r['name'] }}</div>
                        <div class="text-[10px] font-bold text-slate-500 tracking-widest uppercase">{{ $r['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Supported Markets -->
    <section class="pt-16 pb-16 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Asset Coverage</span>
                <h2 class="font-professional text-3xl md:text-5xl uppercase tracking-tighter text-white mb-4">
                    Indian Equities Market We <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Cover</span>
                </h2>
                <p class="text-slate-400 max-w-xl mx-auto text-sm leading-relaxed">Our neural engine monitors a diverse range of asset classes across global exchanges to identify the highest-probability setups.</p>
            </div>

            <!-- <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-5xl mx-auto">
                @php
                $markets = [
                    ['icon' => 'trending-up', 'name' => 'Indian Equities', 'sub' => 'NSE / BSE', 'color' => 'purple'],
                    ['icon' => 'bar-chart-3', 'name' => 'Forex', 'sub' => 'Major Pairs', 'color' => 'emerald'],
                    ['icon' => 'bitcoin', 'name' => 'Crypto', 'sub' => 'BTC, ETH, SOL', 'color' => 'amber'],
                    ['icon' => 'gem', 'name' => 'Commodities', 'sub' => 'Gold, Silver', 'color' => 'blue'],
                    ['icon' => 'activity', 'name' => 'Options', 'sub' => 'Nifty / Bank Nifty', 'color' => 'rose'],
                    ['icon' => 'globe', 'name' => 'US Stocks', 'sub' => 'NYSE / NASDAQ', 'color' => 'indigo'],
                ];
                @endphp
                @foreach($markets as $m)
                <div class="glass-panel p-6 rounded-2xl border border-white/5 text-center hover:border-{{ $m['color'] }}-500/30 transition-all group/market">
                    <div class="w-12 h-12 rounded-xl bg-{{ $m['color'] }}-500/10 border border-{{ $m['color'] }}-500/20 flex items-center justify-center mx-auto mb-4 group-hover/market:bg-{{ $m['color'] }}-500 group-hover/market:text-white transition-all">
                        <i data-lucide="{{ $m['icon'] }}" class="w-6 h-6 text-{{ $m['color'] }}-400 group-hover/market:text-white transition-colors"></i>
                    </div>
                    <div class="font-whiskey text-xs font-black text-white uppercase italic tracking-tight mb-1">{{ $m['name'] }}</div>
                    <div class="text-[9px] font-bold text-slate-500 font-whiskey uppercase tracking-widest">{{ $m['sub'] }}</div>
                </div>
                @endforeach
            </div> -->
        </div>
    </section>

    <!-- Platform Performance -->
    <section class="pt-16 pb-16 relative">
        <div class="container mx-auto px-6">
            <div class="glass-panel p-6 sm:p-10 md:p-16 rounded-[2rem] sm:rounded-[2.5rem] border border-white/5 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-purple-600/3 via-transparent to-indigo-600/3 -z-10"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Live Telemetry</span>
                        <h2 class="font-professional text-3xl md:text-4xl uppercase tracking-tighter text-white mb-6">
                            Platform <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Performance</span>
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">Our infrastructure processes millions of data points across global exchanges, delivering real-time signals with sub-second latency.</p>
                        <div class="flex gap-4">
                            <a href="{{ url('/register') }}" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-[10px] tracking-widest rounded-xl hover:scale-105 transition-all uppercase">
                                Start Free Trial
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Uptime</span>
                            </div>
                            <div class="text-3xl font-professional text-white tracking-tighter">99.9%</div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                    <i data-lucide="shield" class="w-5 h-5 text-white"></i>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Latency</span>
                            </div>
                            <div class="text-3xl font-professional text-white tracking-tighter">14<span class="text-xs text-slate-500 ml-1">ms</span></div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="database" class="w-3 h-3 text-purple-500"></i>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Daily Data</span>
                            </div>
                            <div class="text-3xl font-professional text-white tracking-tighter">2M<span class="text-xs text-slate-500 ml-1">pts</span></div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="cpu" class="w-3 h-3 text-blue-500"></i>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Nodes</span>
                            </div>
                            <div class="text-3xl font-professional text-white tracking-tighter">12<span class="text-xs text-slate-500 ml-1">active</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter / Quick CTA -->
    <!-- <section class="py-16 relative">
        <div class="container mx-auto px-6">
            <div class="glass-panel p-6 sm:p-8 md:p-12 rounded-[2rem] sm:rounded-[2.5rem] border border-white/5 flex flex-col md:flex-row items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <div>
                        <h3 class="font-whiskey text-lg font-black text-white uppercase italic tracking-tight">Stay in the Loop</h3>
                        <p class="text-sm text-slate-400">Get weekly market analysis and top signals delivered to your inbox.</p>
                    </div>
                </div>
                <div class="flex gap-4 w-full md:w-auto">
                    <input type="email" placeholder="your@email.com" class="w-full md:w-64 bg-white/5 border border-white/10 rounded-xl px-5 py-3 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-600">
                    <button class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black font-whiskey text-[10px] tracking-widest rounded-xl hover:scale-105 transition-all uppercase flex-shrink-0">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Premium CTA Section -->
    <section class="pt-16 pb-32 relative overflow-hidden group">
        <!-- Background Blobs -->
        <div class="absolute top-1/2 left-1/4 w-[500px] h-[500px] bg-purple-600/20 blur-[120px] -z-10 animate-pulse rounded-full"></div>
                <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-indigo-600/20 blur-[120px] -z-10 rounded-full"></div>
                <div class="absolute -top-1/4 -right-1/4 w-[500px] h-[500px] bg-white/5 blur-[120px] rounded-full"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="glass-panel p-8 sm:p-16 md:p-20 rounded-[2rem] sm:rounded-[4rem] text-center border border-white/5 relative overflow-hidden reveal-section">
                <!-- Particle Background Container -->
                <div id="cta-particles" class="absolute inset-0 -z-10"></div>
                
                <div class="relative z-20">
                    <h2 class="font-professional text-3xl sm:text-4xl md:text-7xl mb-8 leading-tight text-white">
                        Stop Guessing. <br>
                        Start <span class="text-gradient">Trading</span>.
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-lg md:text-xl mb-8 sm:mb-12 max-w-2xl mx-auto font-medium">
                        Join the elite circle of traders using our Neural Prediction Stream to maintain a consistent edge in the market.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="{{ url('/pricing') }}" class="bg-black text-white font-bold py-5 px-14 rounded-2xl text-[10px] uppercase tracking-[0.2em] hover:bg-purple-600 hover:text-white transition-all shadow-[0_20px_50px_rgba(255,255,255,0.1)] hover:shadow-purple-600/50 transform hover:-translate-y-1">
                            Get Premium Access
                        </a>
                        <a href="{{ url('/register') }}" class="glass-panel border border-white/10 text-white font-bold py-5 px-14 rounded-2xl text-[10px] uppercase tracking-[0.2em] hover:bg-white/5 transition-all transform hover:-translate-y-1">
                            Initialize Terminal
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-10 sm:mt-16 pt-10 sm:pt-16 border-t border-white/5 flex flex-wrap justify-center gap-6 sm:gap-12 opacity-40">
                         <div class="font-bold text-[9px] tracking-widest uppercase flex items-center gap-2 text-white">
                             <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                             ENCRYPTED DATA
                         </div>
                         <div class="font-bold text-[9px] tracking-widest uppercase flex items-center gap-2 text-white">
                             <i data-lucide="zap" class="w-4 h-4 text-purple-500"></i>
                             NEURAL PIPELINE
                         </div>
                         <div class="font-bold text-[9px] tracking-widest uppercase flex items-center gap-2 text-white">
                             <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i>
                             24/7 MONITORING
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@push('styles')
<style>
    .animate-ticker { animation: ticker 15s linear infinite; }
    @media (max-width: 640px) {
        .animate-ticker { animation-duration: 8s; }
    }
    .animate-ticker:hover { animation-play-state: paused; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* AI Signals Table Styles */
    .signals-table-container {
        background: rgba(12, 5, 24, 0.4);
        border: 1px solid rgba(147, 51, 234, 0.1);
        backdrop-filter: blur(30px);
    }
    .signals-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .hero-content h1 {
        font-family: 'Inter', sans-serif;
        font-size: clamp(2.5rem, 8vw, 5rem);
        font-weight: 900;
        line-height: 0.95;
        letter-spacing: -3px;
        margin-bottom: 2rem;
        background: linear-gradient(to right, #ffffff, #9333ea);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        font-style: italic;
    }
    .signals-table th {
        padding: 1.5rem 1rem;
        background: rgba(255, 255, 255, 0.02);
        color: #94a3b8;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .signals-table th:hover { color: #a855f7; background: rgba(147, 51, 234, 0.02); }
    .signals-table td {
        padding: 1.5rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        transition: background 0.3s;
    }
    .signals-table tr:last-child td { border-bottom: none; }
    .signals-table tr:hover td { background: rgba(147, 51, 234, 0.04); }

    /* Confidence Badges */
    .conf-high { color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); background: rgba(16, 185, 129, 0.05); }
    .conf-mid { color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); background: rgba(245, 158, 11, 0.05); }
    .conf-low { color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.05); }

    /* Status Badges */
    .status-active { color: #10b981; }
    .status-closed { color: #94a3b8; }

    /* Mobile Cards */
    @media (max-width: 767px) {
        .signals-table-desktop { display: none; }
        .signals-mobile-cards { display: block; }
        .signal-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: transform 0.3s;
        }
        .signal-card:hover { transform: translateY(-3px); border-color: rgba(147, 51, 234, 0.3); }
    }
    @media (min-width: 768px) {
        .signals-table-desktop { display: table; }
        .signals-mobile-cards { display: none; }
    }

    /* Terminal Frame Enhancements */
    .terminal-frame-glow {
        box-shadow: 
            0 50px 100px -20px rgba(0,0,0,0.8),
            0 0 50px rgba(147, 51, 234, 0.1),
            inset 0 0 20px rgba(255, 255, 255, 0.02);
    }
    .hero-terminal {
        perspective: 1000px;
    }
    .hero-terminal > div {
        transform: rotateX(2deg);
        transform-style: preserve-3d;
    }

    /* Modal Styles */
    #funds-modal-container {
        z-index: 100;
    }
    .step-indicator.active {
        background: linear-gradient(135deg, #f59e0b, #ea580c);
        color: white;
        border-color: transparent;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }
    .step-indicator.completed {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    .step-connector.active {
        background: linear-gradient(90deg, #f59e0b, #ea580c);
    }
    @keyframes scan-line {
        0%, 100% { transform: translateY(0); opacity: 0; }
        5% { opacity: 1; }
        95% { opacity: 1; }
        50% { transform: translateY(168px); }
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize GSAP & ScrollTrigger

    gsap.registerPlugin(ScrollTrigger);

    const animateHomepage = () => {
        // 1. Hero Entrance Timeline
        const heroTl = gsap.timeline({ defaults: { ease: "power4.out", duration: 1.5 } });
        
        heroTl.to(".hero-stagger", {
            y: 0,
            opacity: 1,
            stagger: 0.15,
            duration: 1.2
        })
        .to(".hero-terminal", {
            opacity: 1,
            scale: 1,
            duration: 1.5,
            ease: "expo.out"
        }, "-=1")
        .to(".floating-asset", {
            opacity: 1,
            stagger: 0.2,
            duration: 1
        }, "-=0.5");

        // 2. Floating Assets Parallax/Animation
        gsap.to(".floating-asset", {
            y: "random(-15, 15)",
            x: "random(-5, 5)",
            rotation: "random(-15, 15)",
            duration: "random(2, 4)",
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

        // 3. Count Up Statistics
        gsap.utils.toArray(".count-up").forEach(counter => {
            const target = counter.getAttribute('data-value');
            gsap.to(counter, {
                innerText: target,
                duration: 2,
                snap: { innerText: 1 },
                scrollTrigger: {
                    trigger: counter,
                    start: "top 90%",
                }
            });
        });

        // 5. Section & Card Reveals
        const reveals = gsap.utils.toArray('.reveal-section, .reveal-step, .glass-panel');
        reveals.forEach((el) => {
            gsap.from(el, {
                y: 50,
                opacity: 0,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 85%",
                    toggleActions: "play none none none"
                }
            });
        });

        // 6. Terminal Chart Animation
        gsap.from(".chart-line", {
            strokeDasharray: 1000,
            strokeDashoffset: 1000,
            duration: 3,
            ease: "power2.inOut",
            scrollTrigger: {
                trigger: ".hero-terminal",
                start: "top center"
            },
            onUpdate: function() {
                const progress = this.progress();
                document.querySelector(".chart-line").style.strokeDashoffset = 1000 * (1 - progress);
            }
        });

        // Ensure triggers are updated after animations
        setTimeout(() => ScrollTrigger.refresh(), 100);
    };

    // 7. CTA Particle Effect
    const initParticles = () => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const container = document.getElementById('cta-particles');
        if (!container) return;
        
        container.appendChild(canvas);
        let particles = [];
        
        const resize = () => {
            canvas.width = container.offsetWidth;
            canvas.height = container.offsetHeight;
        };
        
        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() {
                this.reset();
            }
            reset() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2;
                this.speedX = (Math.random() - 0.5) * 0.5;
                this.speedY = (Math.random() - 0.5) * 0.5;
                this.opacity = Math.random() * 0.5;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x < 0 || this.x > canvas.width || this.y < 0 || this.y > canvas.height) this.reset();
            }
            draw() {
                ctx.fillStyle = `rgba(168, 85, 247, ${this.opacity})`;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        for (let i = 0; i < 50; i++) particles.push(new Particle());

        const animate = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animate);
        };
        animate();
    };

    // Initialize everything
    window.addEventListener('DOMContentLoaded', () => {
        animateHomepage();
        initParticles();
        
        // Re-sync ScrollTrigger after all assets load
        window.addEventListener('load', () => {
            ScrollTrigger.refresh();
        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Modal Styles */
    #funds-modal-container {
        z-index: 1000;
    }
    .step-indicator.active {
        background: linear-gradient(135deg, #f59e0b, #ea580c);
        color: white;
        border-color: transparent;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }
    .step-indicator.completed {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    .step-connector.active {
        background: linear-gradient(90deg, #f59e0b, #ea580c);
    }
    @keyframes scan-line {
        0%, 100% { transform: translateY(0); opacity: 0; }
        5% { opacity: 1; }
        95% { opacity: 1; }
        50% { transform: translateY(168px); }
    }
</style>
@endpush

@endsection

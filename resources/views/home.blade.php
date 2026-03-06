@extends('layouts.app')

@section('title', 'AlgoTra AI | Smart Algo Trading Signals')

@section('content')
    <!-- Hero Section -->
    <div class="relative z-10 container mx-auto px-6 lg:px-12 flex flex-col lg:flex-row items-center justify-between py-16 lg:py-20 gap-12">
        <!-- Left Column -->
        <div class="w-full lg:w-5/12 flex flex-col gap-8">
            <div class="relative z-20 space-y-8">
                <div class="inline-flex items-center gap-3 px-4 py-1.5 rounded-full glass-panel border border-purple-500/20 text-purple-400 text-[10px] font-bold orbitron uppercase tracking-[0.2em] hero-stagger opacity-0">
                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                    Join 15k+ traders using AI Precision
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black tracking-tighter leading-[0.95] orbitron uppercase italic">
                    <span class="block text-gradient hero-stagger opacity-0">TRADE</span>
                    <span class="block text-white hero-stagger opacity-0">SMARTER</span>
                    <span class="block text-purple-600/50 hero-stagger opacity-0">NOT HARDER</span>
                </h1>

                <p class="text-slate-400 text-lg md:text-xl leading-relaxed max-w-xl hero-stagger opacity-0 font-medium">
                    Real-time market insights with precision entry points and intelligent risk management powered by advanced AI prediction models.
                </p>

                <div class="flex flex-wrap gap-4 mt-8 hero-stagger opacity-0">
                    <a href="#signals" class="bg-purple-600 text-white font-black py-5 px-10 rounded-2xl transition-all flex items-center gap-3 hover:shadow-[0_0_40px_rgba(147,51,234,0.4)] transform hover:-translate-y-1 orbitron text-[10px] uppercase tracking-widest">
                        Explore Signals
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ url('/pricing') }}" class="glass-panel border border-white/10 hover:bg-white/5 text-white font-black py-5 px-10 rounded-2xl transition-all transform hover:-translate-y-1 orbitron text-[10px] uppercase tracking-widest">
                        Upgrade To Premium
                    </a>
                </div>
            </div>

            <!-- Stats Bar -->
            <div class="flex gap-12 mt-6 border-t border-white/5 pt-8 hero-stagger opacity-0">
                <div class="group">
                    <div class="text-3xl font-black text-white orbitron tracking-tighter count-up" data-value="95">0</div>
                    <div class="text-[9px] text-slate-500 font-bold orbitron uppercase tracking-widest mt-2">Win Rate %</div>
                </div>
                <div class="group">
                    <div class="text-3xl font-black text-white orbitron tracking-tighter count-up" data-value="15">0</div>
                    <div class="text-[9px] text-slate-500 font-bold orbitron uppercase tracking-widest mt-2">Active Users (k)</div>
                </div>
                <div class="group">
                    <div class="text-3xl font-black text-white orbitron tracking-tighter count-up" data-value="24">0</div>
                    <div class="text-[9px] text-slate-500 font-bold orbitron uppercase tracking-widest mt-2">AI Engine (hrs)</div>
                </div>
            </div>
        </div>

        <!-- Right Column: AI Terminal -->
        <div class="w-full lg:w-6/12 relative flex items-center justify-center">
             <!-- Floating Crypto Assets -->
             <div class="absolute -top-10 -left-10 w-20 h-20 glass-panel rounded-full flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.2">
                <i data-lucide="bitcoin" class="w-10 h-10 text-amber-500"></i>
             </div>
             <div class="absolute bottom-10 -right-10 w-16 h-16 glass-panel rounded-full flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.5">
                <i data-lucide="coins" class="w-8 h-8 text-blue-400"></i>
             </div>
             <div class="absolute top-1/2 -right-20 w-14 h-14 glass-panel rounded-full flex items-center justify-center z-20 floating-asset opacity-0" data-delay="0.8">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-400"></i>
             </div>

             <!-- Floating Badges -->
             <div class="absolute top-0 right-10 glass-panel rounded-full py-2 px-4 flex items-center gap-2 z-20 hero-stagger opacity-0 border border-purple-500/30">
                <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
                <span class="text-[9px] font-bold text-slate-200 orbitron tracking-widest uppercase">TERMINAL v2.0 ACTIVE</span>
            </div>

            <!-- Terminal -->
            <div class="relative w-full max-w-[450px] aspect-[4/5] bg-[#0c0518] rounded-[3rem] border border-purple-500/40 terminal-glow shadow-2xl z-10 flex flex-col overflow-hidden hero-terminal opacity-0 scale-95 transition-all duration-700">
                <div class="w-full h-10 flex justify-center items-center gap-2 mt-4 opacity-30">
                    <div class="w-20 h-1.5 bg-black/60 rounded-full"></div>
                </div>
                
                <!-- Screen Area -->
                <div class="flex-1 mx-5 mb-5 bg-[#05020a] rounded-[2.5rem] border border-white/5 relative overflow-hidden flex flex-col p-6">
                    <div class="flex justify-between items-center mb-10">
                        <div class="flex items-center gap-2 text-purple-500">
                            <i data-lucide="zap" class="w-5 h-5 fill-purple-500"></i>
                            <span class="text-[9px] font-black orbitron tracking-widest">NEURAL PATHWAY</span>
                        </div>
                        <div class="flex gap-2">
                             <div class="w-2 h-2 rounded-full bg-rose-500/50"></div>
                             <div class="w-2 h-2 rounded-full bg-amber-500/50"></div>
                             <div class="w-2 h-2 rounded-full bg-emerald-500/50"></div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <div class="text-slate-500 text-[9px] orbitron tracking-[0.3em] font-bold mb-2">SCANNING MARKET DEPTH</div>
                        <div class="flex items-end gap-3">
                             <div class="text-5xl font-black text-white orbitron tracking-tighter" id="accuracy-counter">98.4%</div>
                             <div class="text-emerald-400 text-[10px] font-bold pb-2">+2.45%</div>
                        </div>
                    </div>

                    <!-- Chart SVG -->
                    <div class="flex-1 relative border-t border-white/5 pt-8 overflow-hidden">
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

                    <div class="mt-6 flex justify-between items-center text-[9px] orbitron font-bold text-slate-600">
                        <span>EST 2024</span>
                        <div class="flex items-center gap-2">
                             <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                             SYSTEM OPERATIONAL
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ambient Glows -->
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-purple-600/20 blur-[150px] -z-10 rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-indigo-600/20 blur-[150px] -z-10 rounded-full"></div>
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
                <div class="inline-flex items-center gap-6 px-12 border-r border-white/5">
                    <span class="orbitron font-bold text-slate-400 text-sm tracking-widest uppercase">{{ $item }}</span>
                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Signals Section -->
    <section id="signals" class="py-32 container mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div class="max-w-2xl">
                <h2 class="orbitron text-4xl md:text-5xl font-bold mb-6 uppercase">See what our AI is detecting <span class="text-purple-500">right now</span></h2>
                <p class="text-slate-400 leading-relaxed text-lg">Our intelligent trading engine continuously scans market data to detect high-probability setups.</p>
            </div>
            <a href="{{ url('/register') }}" class="group flex items-center gap-3 text-purple-400 font-bold orbitron text-xs tracking-widest">
                EXPLORE ALL SIGNALS 
                <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>

        <div class="glass-panel rounded-[2.5rem] overflow-hidden reveal-section">
            @if($isPremium)
            <div id="home-signals-table"></div>
@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script src="{{ asset('js/tabulator-global.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const signalsData = @json($signals);

        new Tabulator("#home-signals-table", {
            ...TABULATOR_BASE_CONFIG,
            data: signalsData,
            columns: [
                {title: "STOCK", field: "stock_symbol", widthGrow: 1.5, sorter: "string", formatter: (cell) => `<div class="font-bold orbitron text-white uppercase">${cell.getValue()}</div>`},
                {title: "TYPE", field: "is_premium", width: 70, formatter: (cell) => {
                    const isPremium = cell.getValue();
                    const cls = isPremium ? 'border-amber-500/50 text-amber-500' : 'border-purple-500/50 text-purple-500';
                    return `<span class="text-[9px] font-black px-2 py-0.5 rounded border ${cls}">${isPremium ? 'VIP' : 'PRO'}</span>`;
                }},
                {title: "ENTRY", field: "entry_price", width: 100, formatter: (cell) => `<div class="font-mono text-sm text-white">₹${cell.getValue()}</div>`},
                {title: "SL", field: "stop_loss", width: 80, formatter: (cell) => `<div class="font-mono text-xs text-slate-500">₹${cell.getValue()}</div>`},
                {title: "T1", field: "target_1", width: 80, color: "#a855f7", formatter: (cell) => `<div class="font-mono text-xs text-slate-300">₹${cell.getValue()}</div>`},
                {title: "T2", field: "target_2", width: 80, color: "#a855f7", formatter: (cell) => `<div class="font-mono text-xs text-slate-300">₹${cell.getValue()}</div>`},
                {title: "AI %", field: "confidence_level", width: 80, formatter: (cell) => `<div class="font-bold text-purple-400 text-sm">${cell.getValue()}%</div>`},
                {title: "TIME", field: "created_at", width: 80, formatter: (cell) => `<div class="text-xs text-slate-500">${new Date(cell.getValue()).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>`},
                {title: "STATUS", field: "status", width: 100, formatter: (cell) => `
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>
                        <span class="text-[9px] font-bold orbitron text-emerald-400 uppercase">ACTIVE</span>
                    </div>`
                },
                {title: "PROFIT", field: "profit", hozAlign: "right", widthGrow: 1, formatter: (cell) => `<div class="font-bold text-emerald-400 text-sm italic uppercase">PENDING</div>`},
            ],
            renderComplete: () => {
                if (window.lucide) lucide.createIcons();
            }
        });
    });
</script>
@endpush
            @else
            <!-- Lock Overlay for Landing Page -->
            <div class="p-12 text-center bg-gradient-to-t from-purple-900/40 to-transparent">
                <div class="w-12 h-12 bg-amber-400 text-black rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl shadow-amber-400/20 animate-bounce">
                    <i data-lucide="lock" class="w-6 h-6"></i>
                </div>
                <h3 class="orbitron font-bold text-xl text-white mb-2 uppercase">Neural Prediction Stream Restricted</h3>
                <p class="text-slate-400 text-sm mb-8 max-w-lg mx-auto italic">Full data terminal access is reserved for Premium King members only. Precision levels and real-time execution alerts currently blurred.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ url('/pricing') }}" class="bg-amber-400 text-black font-black py-4 px-10 rounded-2xl text-[10px] orbitron hover:scale-105 transition-all shadow-lg shadow-amber-400/20 uppercase">Unlock Terminal</a>
                    <a href="{{ url('/register') }}" class="glass-panel text-white font-bold py-4 px-10 rounded-2xl text-[10px] orbitron hover:bg-white/10 transition-all uppercase">Initialize Terminal</a>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Why Our AI -->
    <section id="features" class="py-32 relative bg-white/[0.01]">
        <div class="container mx-auto px-6">
             <div class="text-center mb-20">
                <span class="orbitron text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Core Advantages</span>
                <h2 class="orbitron text-4xl md:text-5xl font-black mb-6 uppercase italic tracking-tighter text-white">Why Our AI is <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Powerful</span></h2>
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
                    <h3 class="orbitron font-black text-base mb-4 text-white uppercase italic tracking-tight">{{ $f['title'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
             </div>
        </div>
    </section>

    <!-- Alert Feature -->
    <section class="py-32 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="p-12 md:p-20 rounded-[5rem] bg-[#0c0518] border border-white/5 relative overflow-hidden group shadow-2xl">
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-purple-600/10 blur-[130px] -z-10 group-hover:bg-purple-600/15 transition-all duration-700"></div>
                <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[100px] -z-10"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                    <div class="reveal-left">
                        <h2 class="orbitron text-4xl md:text-6xl font-black mb-8 leading-[1.1] uppercase tracking-tighter">
                            <span class="text-white block">NEVER MISS AN</span>
                            <span class="bg-gradient-to-r from-purple-500 to-magenta-500 bg-clip-text text-transparent block" style="background-image: linear-gradient(90deg, #9333ea, #d946ef);">OPPORTUNITY</span>
                        </h2>
                        <p class="text-slate-400 text-lg mb-12 max-w-md font-medium leading-relaxed">Our multi-channel alert system ensures you are always connected to the market pulse.</p>
                        
                        <div class="space-y-5">
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-emerald-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                                    <i data-lucide="smartphone" class="w-5 h-5"></i>
                                </div>
                                <span class="orbitron font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">MOBILE PUSH NOTIFICATIONS</span>
                            </div>
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-purple-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                </div>
                                <span class="orbitron font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">DASHBOARD LIVE ALERTS</span>
                            </div>
                            <div class="flex items-center gap-6 p-5 glass-panel rounded-2xl border border-white/5 border-l-4 border-l-blue-500 group/item hover:bg-white/10 transition-all cursor-default">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <span class="orbitron font-bold text-[11px] tracking-[0.2em] text-slate-200 uppercase">REAL-TIME EMAIL INSIGHTS</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative flex justify-center items-center reveal-right">
                        <!-- Floating ambient blobs -->
                        <div class="absolute -top-10 -left-10 w-48 h-24 glass-panel rounded-[2rem] border border-white/10 -rotate-12 blur-[2px] opacity-40"></div>
                        <div class="absolute -bottom-10 -right-10 w-48 h-24 glass-panel rounded-[2rem] border border-white/10 rotate-6 blur-[1px] opacity-40 scale-110"></div>

                        <!-- Notification Card -->
                        <div class="relative w-full max-sm glass-panel p-10 rounded-[3rem] border border-white/10 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] z-10 transform -rotate-3 hover:rotate-0 transition-all duration-700 overflow-hidden group/card">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/10 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                            
                            <div class="flex items-center gap-5 mb-10 relative z-10">
                                <div class="w-12 h-12 bg-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-600/40 animate-pulse">
                                    <i data-lucide="bell" class="w-6 h-6 text-white"></i>
                                </div>
                                <span class="orbitron font-black text-[12px] tracking-[0.3em] text-white uppercase">NEW SIGNAL ALERT</span>
                            </div>
                            
                            <div class="space-y-5 relative z-10 opacity-40">
                                <div class="h-3 w-5/6 bg-white/10 rounded-full"></div>
                                <div class="h-3 w-full bg-white/10 rounded-full"></div>
                                <div class="pt-6">
                                    <div class="h-12 w-full bg-purple-600/20 rounded-2xl border border-purple-500/30"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-32 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center">
            <div class="mb-24">
                <span class="orbitron text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Simple Process</span>
                <h2 class="orbitron text-4xl md:text-5xl font-black mb-6 uppercase italic tracking-tighter text-white">HOW IT <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">WORKS</span></h2>
                <p class="text-slate-400 max-w-xl mx-auto text-sm leading-relaxed">Master the market in three simplified steps — from connecting your dashboard to executing profitable trades.</p>
            </div>

            <div class="relative mt-24">
                <!-- Progress Line -->
                <div class="absolute top-1/2 left-0 w-full h-[1px] bg-white/10 -translate-y-1/2 hidden lg:block">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 w-0 timeline-progress"></div>
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
                             <div class="w-20 h-20 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto shadow-2xl shadow-purple-600/30 orbitron text-2xl font-black italic relative z-10 group-hover:scale-110 transition-transform">
                                {{ $s['n'] }}
                            </div>
                            <div class="absolute inset-0 bg-purple-500 blur-2xl opacity-20 group-hover:opacity-40 transition-opacity"></div>
                        </div>
                        <h3 class="orbitron font-black text-base mb-4 text-white uppercase italic tracking-tight">{{ $s['t'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-[260px] mx-auto">{{ $s['d'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-24 container mx-auto px-6">
        <div class="text-center mb-20">
            <span class="orbitron text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Social Proof</span>
            <h2 class="orbitron text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white">Traders Trust <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Data</span>, Not Noise</h2>
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
            <div class="glass-panel p-8 rounded-3xl relative border border-white/5 hover:border-purple-500/20 transition-all group">
                <div class="absolute -top-4 -left-4 w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-purple-600/30">
                    <i data-lucide="quote" class="w-5 h-5 text-white fill-white"></i>
                </div>
                <div class="flex gap-1 mb-4 mt-2">
                    @for($j = 0; $j < 5; $j++)
                    <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                    @endfor
                </div>
                <p class="text-slate-300 text-sm leading-relaxed mb-8">"{{ $r['text'] }}"</p>
                <div class="flex items-center gap-4 pt-6 border-t border-white/5">
                    <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center font-bold text-white text-xs orbitron">{{ $r['initials'] }}</div>
                    <div>
                        <div class="text-sm font-bold text-white">{{ $r['name'] }}</div>
                        <div class="text-[10px] font-bold orbitron text-slate-500 tracking-widest uppercase">{{ $r['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Supported Markets -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="orbitron text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Asset Coverage</span>
                <h2 class="orbitron text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white mb-4">
                    Markets We <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Cover</span>
                </h2>
                <p class="text-slate-400 max-w-xl mx-auto text-sm leading-relaxed">Our neural engine monitors a diverse range of asset classes across global exchanges to identify the highest-probability setups.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 max-w-5xl mx-auto">
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
                    <div class="orbitron text-xs font-black text-white uppercase italic tracking-tight mb-1">{{ $m['name'] }}</div>
                    <div class="text-[9px] font-bold text-slate-500 orbitron uppercase tracking-widest">{{ $m['sub'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Platform Performance -->
    <section class="py-24 relative">
        <div class="container mx-auto px-6">
            <div class="glass-panel p-10 md:p-16 rounded-[2.5rem] border border-white/5 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-purple-600/3 via-transparent to-indigo-600/3 -z-10"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="orbitron text-[10px] font-black text-purple-500 tracking-[0.3em] uppercase mb-4 block">Live Telemetry</span>
                        <h2 class="orbitron text-3xl md:text-4xl font-black uppercase italic tracking-tighter text-white mb-6">
                            Platform <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Performance</span>
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed mb-8">Our infrastructure processes millions of data points across global exchanges, delivering real-time signals with sub-second latency.</p>
                        <div class="flex gap-4">
                            <a href="{{ url('/register') }}" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black orbitron text-[10px] tracking-widest rounded-xl hover:scale-105 transition-all uppercase">
                                Start Free Trial
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest">Uptime</span>
                            </div>
                            <div class="text-3xl font-black text-white orbitron tracking-tighter">99.9%</div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="zap" class="w-3 h-3 text-amber-500"></i>
                                <span class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest">Latency</span>
                            </div>
                            <div class="text-3xl font-black text-white orbitron tracking-tighter">14<span class="text-xs text-slate-500 ml-1">ms</span></div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="database" class="w-3 h-3 text-purple-500"></i>
                                <span class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest">Daily Data</span>
                            </div>
                            <div class="text-3xl font-black text-white orbitron tracking-tighter">2M<span class="text-xs text-slate-500 ml-1">pts</span></div>
                        </div>
                        <div class="glass-panel p-6 rounded-2xl border border-white/5">
                            <div class="flex items-center gap-2 mb-3">
                                <i data-lucide="cpu" class="w-3 h-3 text-blue-500"></i>
                                <span class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest">Nodes</span>
                            </div>
                            <div class="text-3xl font-black text-white orbitron tracking-tighter">12<span class="text-xs text-slate-500 ml-1">active</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter / Quick CTA -->
    <section class="py-16 relative">
        <div class="container mx-auto px-6">
            <div class="glass-panel p-8 md:p-12 rounded-[2.5rem] border border-white/5 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <div>
                        <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">Stay in the Loop</h3>
                        <p class="text-sm text-slate-400">Get weekly market analysis and top signals delivered to your inbox.</p>
                    </div>
                </div>
                <div class="flex gap-4 w-full md:w-auto">
                    <input type="email" placeholder="your@email.com" class="w-full md:w-64 bg-white/5 border border-white/10 rounded-xl px-5 py-3 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-600">
                    <button class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black orbitron text-[10px] tracking-widest rounded-xl hover:scale-105 transition-all uppercase flex-shrink-0">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Premium CTA Section -->
    <section class="py-32 relative overflow-hidden group">
        <!-- Background Blobs -->
        <div class="absolute top-1/2 left-1/4 w-[500px] h-[500px] bg-purple-600/20 blur-[120px] -z-10 animate-pulse rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-indigo-600/20 blur-[120px] -z-10 rounded-full"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="glass-panel p-16 md:p-32 rounded-[4rem] text-center border border-white/5 relative overflow-hidden reveal-section">
                <!-- Particle Background Container -->
                <div id="cta-particles" class="absolute inset-0 -z-10"></div>
                
                <div class="relative z-20">
                    <h2 class="orbitron text-4xl md:text-7xl font-black mb-8 leading-tight tracking-tighter text-white uppercase italic">
                        STOP GUESSING. <br>
                        START <span class="text-gradient">TRADING</span>.
                    </h2>
                    <p class="text-slate-400 text-lg md:text-xl mb-12 max-w-2xl mx-auto font-medium">
                        Join the elite circle of traders using our Neural Prediction Stream to maintain a consistent edge in the market.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-6">
                        <a href="{{ url('/pricing') }}" class="bg-white text-black font-black py-5 px-14 rounded-2xl text-[10px] uppercase orbitron tracking-[0.2em] hover:bg-purple-600 hover:text-white transition-all shadow-[0_20px_50px_rgba(255,255,255,0.1)] hover:shadow-purple-600/50 transform hover:-translate-y-1">
                            Get Premium Access
                        </a>
                        <a href="{{ url('/register') }}" class="glass-panel border border-white/10 text-white font-black py-5 px-14 rounded-2xl text-[10px] uppercase orbitron tracking-[0.2em] hover:bg-white/5 transition-all transform hover:-translate-y-1">
                            Initialize Terminal
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="mt-16 pt-16 border-t border-white/5 flex flex-wrap justify-center gap-12 opacity-40">
                         <div class="orbitron font-bold text-[9px] tracking-widest uppercase flex items-center gap-2">
                             <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                             ENCRYPTED DATA
                         </div>
                         <div class="orbitron font-bold text-[9px] tracking-widest uppercase flex items-center gap-2">
                             <i data-lucide="zap" class="w-4 h-4 text-purple-500"></i>
                             NEURAL PIPELINE
                         </div>
                         <div class="orbitron font-bold text-[9px] tracking-widest uppercase flex items-center gap-2">
                             <i data-lucide="clock" class="w-4 h-4 text-indigo-500"></i>
                             24/7 MONITORING
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .animate-ticker { animation: ticker 40s linear infinite; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
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
            y: "random(-20, 20)",
            x: "random(-10, 10)",
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

        // 4. How It Works Timeline Progress
        gsap.to(".timeline-progress", {
            width: "100%",
            scrollTrigger: {
                trigger: "#how-it-works",
                start: "top center",
                end: "bottom center",
                scrub: 1
            }
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

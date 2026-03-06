@extends('layouts.app')

@section('title', 'Free Forex Signals | AlgoTrade AI')

@section('content')
<main class="relative pt-32 pb-20 px-6 min-h-screen overflow-hidden">
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-1/4 left-1/4 w-[600px] h-[600px] bg-purple-600/10 blur-[150px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 blur-[150px] rounded-full"></div>
    </div>

    <div class="container mx-auto max-w-6xl relative z-10">
        <div class="text-center mb-16 fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-black orbitron uppercase tracking-[0.3em] mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-ping"></span>
                Live Intelligence Feed
            </div>
            <h1 class="text-4xl md:text-6xl font-black orbitron italic text-white mb-6 uppercase tracking-tighter">
                FREE <span class="text-gradient">FOREX</span> SIGNALS
            </h1>
            <p class="text-gray-400 max-w-2xl mx-auto text-sm md:text-base leading-relaxed">
                Experience the precision of our AI neural engine. Below are the top-tier algorithmic signals synchronized with global market volatility.
            </p>
        </div>

        <div class="glass-panel p-8 rounded-[2.5rem] border border-white/5 mb-12 fade-in-up" style="animation-delay: 0.1s">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Daily Usage Quota</div>
                        <div class="text-lg font-bold text-white uppercase italic">1 of 3 Used <span class="text-purple-500 text-sm ml-2 orbitron font-normal tracking-normal">- 2 Remaining</span></div>
                    </div>
                </div>
                <div class="flex-grow max-w-md w-full">
                    <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full" style="width: 33%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Telemetry Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 fade-in-up" style="animation-delay: 0.15s">
            <div class="glass-panel p-6 rounded-2xl border border-white/5 relative overflow-hidden group shadow-lg">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-600/5 blur-2xl -z-10"></div>
                <div class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest mb-3">Active Nodes</div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-black text-white orbitron tracking-tighter">12/12</span>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span>
                </div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 relative overflow-hidden group shadow-lg">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-600/5 blur-2xl -z-10"></div>
                <div class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest mb-3">Throughput</div>
                <div class="text-2xl font-black text-white orbitron tracking-tighter">4.2<span class="text-xs text-slate-500 ml-1">GB/S</span></div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 relative overflow-hidden group shadow-lg">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-600/5 blur-2xl -z-10"></div>
                <div class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest mb-3">Neural Sync</div>
                <div class="text-2xl font-black text-white orbitron tracking-tighter">99.8<span class="text-xs text-slate-500 ml-1">%</span></div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 relative overflow-hidden group shadow-lg">
                <div class="absolute top-0 right-0 w-24 h-24 bg-rose-600/5 blur-2xl -z-10"></div>
                <div class="text-[9px] font-black orbitron text-slate-500 uppercase tracking-widest mb-3">Latency</div>
                <div class="text-2xl font-black text-white orbitron tracking-tighter">14<span class="text-xs text-slate-500 ml-1">MS</span></div>
            </div>
        </div>

        <!-- Market Sentiment & Momentum -->
        <div class="glass-panel p-8 rounded-[2.5rem] border border-white/5 mb-12 fade-in-up shadow-xl" style="animation-delay: 0.2s">
            <div class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-white/5">
                <div class="lg:pr-12 pb-8 lg:pb-0 flex-1">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black orbitron text-slate-500 uppercase tracking-[0.2em]">Market Sentiment</span>
                        <span class="text-[10px] font-black orbitron text-emerald-400 uppercase tracking-widest">Bullish</span>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="relative w-20 h-20 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="40" cy="40" r="35" stroke="currentColor" stroke-width="6" fill="transparent" class="text-white/5"/>
                                <circle cx="40" cy="40" r="35" stroke="currentColor" stroke-width="6" fill="transparent" class="text-emerald-500 shadow-[0_0_10px_#10b981]" stroke-dasharray="219.9" stroke-dashoffset="70"/>
                            </svg>
                            <span class="absolute text-xl font-black orbitron">68%</span>
                        </div>
                        <div class="flex-grow space-y-3">
                            <div class="flex justify-between text-[9px] font-bold orbitron uppercase text-slate-400">
                                <span>Buy Intensity</span>
                                <span>High</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full shadow-[0_0_10px_#10b981]" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:px-12 py-8 lg:py-0 flex-1">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black orbitron text-slate-500 uppercase tracking-[0.2em]">Neural Momentum</span>
                        <span class="text-[10px] font-black orbitron text-purple-400 uppercase tracking-widest">+4.2%</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white/[0.03] rounded-2xl border border-white/5 hover:bg-white/[0.05] transition-all">
                            <div class="text-[8px] font-bold text-slate-500 orbitron uppercase mb-1">Volatility</div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="activity" class="w-3 h-3 text-purple-400"></i>
                                <span class="text-xs font-black orbitron uppercase text-white">Medium</span>
                            </div>
                        </div>
                        <div class="p-4 bg-white/[0.03] rounded-2xl border border-white/5 hover:bg-white/[0.05] transition-all">
                            <div class="text-[8px] font-bold text-slate-500 orbitron uppercase mb-1">Volume Proxy</div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="bar-chart-3" class="w-3 h-3 text-blue-400"></i>
                                <span class="text-xs font-black orbitron uppercase text-white">Extreme</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass-panel border border-white/5 overflow-hidden mb-20 fade-in-up" style="animation-delay: 0.2s; border-radius: 4px;">
            <div id="free-signals-table"></div>
        </div>

        <!-- Recent Success Ticker -->
        <div class="relative w-full overflow-hidden py-10 mb-20 fade-in-up" style="animation-delay: 0.25s">
            <div class="flex items-center gap-4 mb-8 px-4 justify-center md:justify-start">
                <div class="flex -space-x-3">
                    <div class="w-8 h-8 rounded-full border-2 border-[#05020a] bg-emerald-500/20 flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-emerald-400"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full border-2 border-[#05020a] bg-purple-500/20 flex items-center justify-center">
                        <i data-lucide="zap" class="w-4 h-4 text-purple-400"></i>
                    </div>
                </div>
                <span class="text-[10px] font-black orbitron text-white uppercase tracking-[0.4em] opacity-60">Neural Achievement Stream</span>
            </div>
            <div class="flex gap-6 animate-ticker-slow">
                @php
                    $successes = [
                        ['pair' => 'EUR/USD', 'pnl' => '+45.2', 'msg' => 'Target 2 Cleared', 'color' => 'emerald'],
                        ['pair' => 'GBP/JPY', 'pnl' => '+112.0', 'msg' => 'High Alpha Signal', 'color' => 'emerald'],
                        ['pair' => 'GOLD', 'pnl' => '+28.5', 'msg' => 'Entry Sequence Complete', 'color' => 'purple'],
                        ['pair' => 'BTC/USDT', 'pnl' => '+845.0', 'msg' => 'Breakout Confirmed', 'color' => 'emerald'],
                        ['pair' => 'TCS/NSE', 'pnl' => '+4.2%', 'msg' => 'Neural Match Found', 'color' => 'blue'],
                    ];
                @endphp
                @foreach (array_merge($successes, $successes, $successes) as $s)
                <div class="flex-shrink-0 flex items-center gap-6 px-8 py-6 glass-panel rounded-3xl border border-white/5 border-l-4 border-l-{{ $s['color'] }}-500 min-w-[280px] group/item hover:bg-white/10 transition-all">
                    <div class="flex flex-col">
                        <span class="text-base font-black orbitron text-white tracking-tighter">{{ $s['pair'] }}</span>
                        <span class="text-[9px] font-bold text-slate-500 orbitron uppercase tracking-widest mt-1">{{ $s['msg'] }}</span>
                    </div>
                    <div class="ml-auto text-{{ $s['color'] }}-400 font-black orbitron text-xl tracking-tighter">
                        {{ $s['pnl'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Premium Upgrade Banner -->
        <div class="glass-panel p-6 md:p-10 rounded-3xl border border-amber-500/20 border-l-4 border-l-amber-500 relative overflow-hidden mb-20 fade-in-up group hover:bg-amber-500/5 transition-all duration-500" style="animation-delay: 0.3s">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 blur-[80px] -z-10 group-hover:bg-amber-500/10 transition-all duration-700"></div>
            
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8 relative z-10">
                <div class="flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-[0_10px_30px_rgba(251,191,36,0.3)] animate-pulse">
                        <i data-lucide="crown" class="w-10 h-10 text-white fill-white/20"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black orbitron text-white mb-2 uppercase italic tracking-tight">
                            UPGRADE TO <span class="text-amber-500">ELITE</span> INTERFACE
                        </h2>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-slate-400">
                             <span class="flex items-center gap-1.5 text-[10px] font-bold orbitron uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5">
                                 <i data-lucide="zap" class="w-3 h-3 text-amber-500"></i> 20+ Daily Signals
                             </span>
                             <span class="flex items-center gap-1.5 text-[10px] font-bold orbitron uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5">
                                 <i data-lucide="activity" class="w-3 h-3 text-emerald-500"></i> Real-time Telemetry
                             </span>
                             <span class="flex items-center gap-1.5 text-[10px] font-bold orbitron uppercase tracking-widest bg-white/5 px-3 py-1 rounded-full border border-white/5">
                                 <i data-lucide="shield" class="w-3 h-3 text-blue-500"></i> Priority Support
                             </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="{{ url('/pricing') }}" class="inline-flex items-center gap-4 px-10 py-4 bg-amber-500 text-black font-black orbitron text-[10px] tracking-widest rounded-xl hover:bg-amber-400 hover:scale-105 active:scale-95 transition-all uppercase italic shadow-[0_15px_35px_rgba(251,191,36,0.25)]">
                        Unlock Elite Access <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

@push('styles')
<style>
    .text-gradient { 
        background: linear-gradient(to right, #fff, #9333ea); 
        -webkit-background-clip: text; 
        -webkit-text-fill-color: transparent; 
    }
    .animate-ticker-slow {
        display: flex;
        width: max-content;
        animation: ticker-move 40s linear infinite;
    }
    @keyframes ticker-move {
        0% { transform: translateX(0); }
        100% { transform: translateX(-33.33%); }
    }
    .animate-ticker-slow:hover {
        animation-play-state: paused;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize GSAP & ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // Animate elements with fade-in-up class
        const fadeElements = gsap.utils.toArray('.fade-in-up');
        fadeElements.forEach((el, i) => {
            gsap.to(el, {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: i * 0.1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 90%",
                    toggleActions: "play none none none"
                }
            });
        });

        // Initialize Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection

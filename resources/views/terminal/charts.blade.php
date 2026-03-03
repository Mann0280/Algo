@extends('layouts.app')

@section('title', 'Neural Market Charts | AlgoTrade AI')

@section('content')
<main class="relative min-h-screen pt-32 pb-20 px-6">
    <div class="container mx-auto">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="orbitron text-3xl font-black text-white uppercase italic tracking-tighter">NEURAL <span class="text-purple-500">CHARTS</span></h1>
                <p class="text-gray-500 text-sm italic">Real-time market visualization node.</p>
            </div>
            <div class="flex gap-4">
                <div class="glass-panel px-6 py-2 rounded-xl border border-white/5 flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] orbitron font-bold text-white uppercase tracking-widest">Live Link Established</span>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-[2rem] border border-white/5 w-full h-[700px] overflow-hidden relative">
            <!-- TradingView Widget placeholder -->
            <div class="absolute inset-0 flex items-center justify-center text-center p-12">
                <div class="max-w-md">
                    <div class="w-16 h-16 bg-purple-600/20 border border-purple-500/30 rounded-2xl flex items-center justify-center mx-auto mb-8 animate-spin-slow">
                        <i data-lucide="activity" class="w-8 h-8 text-purple-500"></i>
                    </div>
                    <h2 class="orbitron text-xl font-bold text-white mb-4 italic uppercase tracking-widest">Synchronizing Data...</h2>
                    <p class="text-gray-500 text-sm mb-8 italic">TradingView Neural Engine Interface is being integrated. Standby for live market telemetrics.</p>
                </div>
            </div>
            
            <!-- In a real scenario, we'd embed TradingView here -->
            <!-- <div id="tradingview_chart" class="w-full h-full"></div> -->
        </div>
    </div>
</main>
@endsection

@push('scripts')
<style>
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 8s linear infinite; }
</style>
@endpush

@extends('layouts.app')

@section('title', 'Pricing Tiers | ALGO TRADE')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 py-20 relative z-10 font-bold uppercase italic tracking-tighter">
    <div class="text-center mb-16">
        <h1 class="orbitron text-5xl font-black mb-4 tracking-tighter text-white">CHOOSE YOUR <span class="text-purple-500">LEVEL</span></h1>
        <p class="text-gray-400 max-w-lg mx-auto font-normal not-italic normal-case tracking-normal">Scale your trading with AI-powered insights and professional grade toolsets.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
        <!-- Normal Plan -->
        <div class="glass-panel p-10 rounded-[3rem] border border-white/5 opacity-60">
            <h2 class="orbitron text-xl font-bold mb-2 text-white">TRADING BASIC</h2>
            <div class="text-4xl font-black mb-8 text-white">FREE</div>
            <ul class="space-y-4 text-sm text-gray-400 mb-10 not-italic normal-case">
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-purple-500"></i> Daily Market Ticker</li>
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-purple-500"></i> Stock Gainer View</li>
                <li class="flex items-center gap-3 text-gray-700"><i data-lucide="x" class="w-5 h-5"></i> Locked AI Signals</li>
            </ul>
            <button disabled class="w-full py-4 rounded-2xl bg-white/5 text-gray-500 font-bold tracking-widest text-xs uppercase">Current Plan</button>
        </div>

        <!-- Premium Plan -->
        <div class="glass-panel p-10 rounded-[3rem] border border-white/10 relative overflow-hidden {{ !$isPremium ? 'premium-glow scale-105' : '' }}">
            @if (!$isPremium)
            <div class="absolute top-6 right-6 bg-amber-400 text-black px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse">MOST POPULAR</div>
            @endif
            
            <h2 class="orbitron text-xl font-bold mb-2 text-white">PREMIUM KING</h2>
            <div class="text-4xl font-black mb-8 text-white">₹ 4,999<span class="text-xs text-gray-500 font-medium">/month</span></div>
            
            <ul class="space-y-4 text-sm text-gray-200 mb-10 not-italic normal-case">
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Unlock All AI Signals</li>
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Entry / SL / Target Prices</li>
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Real-time Alert System</li>
                <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Premium Gold UI Experience</li>
            </ul>

            @if ($isPremium)
                <button disabled class="w-full py-4 rounded-2xl bg-amber-400/20 text-amber-400 font-bold tracking-widest text-xs uppercase italic">Active Subscription</button>
            @else
                <form action="{{ route('subscribe') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-4 rounded-2xl bg-amber-400 text-black font-black tracking-widest text-sm hover:scale-105 transition-all shadow-lg shadow-amber-400/20 uppercase italic">Upgrade to King</button>
                </form>
            @endif
        </div>
    </div>
</main>
@endsection

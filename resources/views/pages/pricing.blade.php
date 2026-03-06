@extends('layouts.app')

@section('title', 'Pricing Tiers | ALGO TRADE')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 py-20 relative z-10 font-bold uppercase italic tracking-tighter">
    <div class="text-center mb-16">
        <h1 class="orbitron text-5xl font-black mb-4 tracking-tighter text-white">CHOOSE YOUR <span class="text-purple-500">LEVEL</span></h1>
        <p class="text-gray-400 max-w-lg mx-auto font-normal not-italic normal-case tracking-normal">Scale your trading with AI-powered insights and professional grade toolsets.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl w-full">
        @forelse($packages as $package)
        <!-- Dynamic Package -->
        <div class="glass-panel p-10 rounded-[3rem] border border-white/10 relative overflow-hidden transition-all hover:translate-y-[-10px] {{ $loop->first && !$isPremium ? 'premium-glow scale-105' : '' }}">
            <div class="absolute top-6 right-6 flex flex-col gap-2 items-end">
                @if ($package->tags_json && count($package->tags_json) > 0)
                    @foreach($package->tags_json as $t)
                        <div class="px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse shadow-lg" style="background-color: {{ $t['color'] }}; color: white; border: 1px solid rgba(255,255,255,0.1);">{{ strtoupper($t['name']) }}</div>
                    @endforeach
                @elseif ($package->tag)
                    <div class="bg-purple-500 text-white px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse shadow-[0_0_15px_rgba(147,51,234,0.5)]">{{ strtoupper($package->tag) }}</div>
                @elseif ($loop->first && !$isPremium)
                    <div class="bg-amber-400 text-black px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse">MOST POPULAR</div>
                @endif
            </div>
            
            <h2 class="orbitron text-xl font-bold mb-2 text-white italic tracking-tighter uppercase">{{ $package->name }}</h2>
            <div class="text-4xl font-black mb-8 text-white">₹ {{ number_format($package->price, 0) }}<span class="text-xs text-gray-500 font-medium lowercase"> / {{ $package->duration_days }} days</span></div>
            
            <p class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-6 px-1">{{ $package->description }}</p>

            <ul class="space-y-4 text-sm text-gray-200 mb-10 not-italic normal-case">
                @if($package->features)
                    @foreach($package->features as $feature)
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> {{ $feature }}</li>
                    @endforeach
                @else
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Unlock AI Signals</li>
                @endif
            </ul>

            @if ($isPremium)
                <button disabled class="w-full py-4 rounded-2xl bg-amber-400/20 text-amber-400 font-bold tracking-widest text-xs uppercase italic">Active Subscription</button>
            @else
                <form action="{{ route('subscribe') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    @if($package->upi_id)
                    <div class="p-3 bg-white/5 border border-white/5 rounded-xl flex flex-col items-center gap-1 group/upi cursor-help transition-all hover:bg-white/10" title="Direct Payment Address">
                        <span class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest">Protocol UPI Gateway</span>
                        <span class="text-[10px] font-bold text-amber-400 group-hover/upi:text-amber-300 transition-colors lowercase">{{ $package->upi_id }}</span>
                    </div>
                    @endif
                    <button type="submit" class="w-full py-4 rounded-2xl font-black tracking-widest text-sm hover:scale-105 transition-all shadow-lg uppercase italic" style="background-color: {{ $package->button_color ?? '#fbbf24' }}; color: {{ ($package->button_color && $package->button_color != '#fbbf24') ? 'white' : 'black' }}; shadow: 0 0 20px {{ $package->button_color ?? '#fbbf24' }}44;">Initiate Upgrade</button>
                </form>
            @endif
        </div>
        @empty
        <div class="col-span-full py-20 text-center opacity-30">
            <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
            <h3 class="orbitron text-xl font-black uppercase tracking-widest">No Active Protocol Packages</h3>
        </div>
        @endforelse
    </div>
</main>
@endsection

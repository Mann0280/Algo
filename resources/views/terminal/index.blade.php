@extends('layouts.app')

@section('title', 'Dashboard | AlgoTrade AI Terminal')

@push('styles')
<style>
    .notification-panel {
        position: fixed; right: -400px; top: 0; width: 380px; height: 100vh;
        background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(20px);
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1000; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .notification-panel.active { right: 0; }
</style>
@endpush

@section('content')
<div class="flex min-h-screen">
    <!-- Notification Panel Overlay -->
    <div id="notif-panel" class="notification-panel p-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="orbitron font-bold text-xl text-white">NOTIFICATIONS</h2>
            <button onclick="toggleNotif()" class="text-gray-500 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="space-y-4" id="alert-list">
            <div class="glass-panel p-5 rounded-2xl border-l-4 border-purple-500 animate-pulse">
                <div class="flex justify-between mb-2">
                    <span class="text-[10px] font-bold text-purple-400 orbitron">SYSTEM UPDATE</span>
                    <span class="text-[10px] text-gray-600 uppercase">Just Now</span>
                </div>
                <p class="text-xs text-gray-300">AI Neural Engine has successfully scanned 500+ NYSE symbols. New signals generated.</p>
            </div>
        </div>
    </div>

    <!-- Terminal Layout handles sidebar itself in the original design, but as we are converting, we'll keep it integrated. -->
    <div class="flex-grow p-8">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="orbitron text-2xl font-bold uppercase italic tracking-tighter text-white">TERMINAL <span class="text-purple-500">ACCESS</span></h1>
                <p class="text-gray-500 text-sm">Welcome back, {{ $user->username }}. AI Engine is active.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <button onclick="toggleNotif()" class="glass-panel p-3 rounded-2xl relative text-gray-400 hover:text-white transition-all">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    <span class="absolute top-2 right-2 w-3 h-3 bg-red-500 border-2 border-black rounded-full"></span>
                </button>
                <div class="glass-panel px-6 py-3 rounded-2xl flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-[10px] text-gray-500 uppercase font-bold">Account Status</div>
                        <div class="text-sm font-bold {{ $isPremium ? 'text-amber-400' : 'text-purple-400' }}">
                            {{ $isPremium ? 'PREMIUM ACCESS' : 'LIMITED ACCESS' }}
                        </div>
                    </div>
                </div>
                @if (!$isPremium)
                    <a href="{{ url('/pricing') }}" class="bg-amber-400 text-black px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-amber-400/20 hover:scale-105 transition-all flex items-center">UPGRADE NOW</a>
                @endif
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12 reveal-section">
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-gray-500 text-xs font-bold mb-1 orbitron tracking-widest uppercase">ACCURACY</div>
                <div class="text-2xl font-bold text-emerald-400">94.2%</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-gray-500 text-xs font-bold mb-1 orbitron tracking-widest uppercase">TOTAL SIGNALS</div>
                <div class="text-2xl font-bold text-white">12,854</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-gray-500 text-xs font-bold mb-1 orbitron tracking-widest uppercase">MARKET TREND</div>
                <div class="text-2xl font-bold text-emerald-400 uppercase">Bullish</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-gray-500 text-xs font-bold mb-1 orbitron tracking-widest uppercase">AI CONFIDENCE</div>
                <div class="text-2xl font-bold text-purple-400">High</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Active Signals Table -->
            <div class="lg:col-span-2 reveal-section">
                <div class="glass-panel rounded-3xl overflow-hidden border border-white/5">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/5">
                        <h2 class="orbitron text-sm font-bold tracking-widest text-white uppercase italic">AI MONITORING TERMINAL</h2>
                        <span class="text-[9px] bg-red-500/10 text-red-500 border border-red-500/20 px-2 py-1 rounded font-black orbitron animate-pulse">LIVE DATA</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="text-slate-500 text-[10px] uppercase font-bold bg-white/5 orbitron">
                                <tr>
                                    <th class="px-6 py-4 border-b border-white/5">STOCK</th>
                                    <th class="px-6 py-4 border-b border-white/5">TYPE</th>
                                    <th class="px-6 py-4 border-b border-white/5">ENTRY</th>
                                    <th class="px-6 py-4 border-b border-white/5">SL</th>
                                    <th class="px-6 py-4 border-b border-white/5 text-purple-400">T1</th>
                                    <th class="px-6 py-4 border-b border-white/5 text-purple-400">T2</th>
                                    <th class="px-6 py-4 border-b border-white/5 text-purple-400">AI %</th>
                                    <th class="px-6 py-4 border-b border-white/5">TIME</th>
                                    <th class="px-6 py-4 border-b border-white/5">STATUS</th>
                                    <th class="px-6 py-4 border-b border-white/5 text-right">ACTION</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($signals as $signal)
                                @php 
                                    $signal = (array)$signal;
                                    $locked = !$isPremium && $signal['is_premium'];
                                    $type = ($signal['risk_level'] == 'Low' ? 'VIP' : ($signal['risk_level'] == 'Medium' ? 'PRO' : 'HIGH'));
                                @endphp
                                <tr class="group hover:bg-white/[0.02] transition-all">
                                    <td class="px-6 py-5 font-bold orbitron text-white italic truncate max-w-[120px]">{{ $signal['stock_symbol'] }}</td>
                                    <td class="px-6 py-5">
                                        <span class="text-[9px] font-black px-2 py-0.5 rounded border {{ $type == 'VIP' ? 'border-amber-500/50 text-amber-500' : ($type == 'PRO' ? 'border-purple-500/50 text-purple-500' : 'border-blue-500/50 text-blue-500') }}">
                                            {{ $type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 font-mono text-xs {{ $locked ? 'blur-sm select-none' : '' }}">₹{{ $signal['entry_price'] }}</td>
                                    <td class="px-6 py-5 font-mono text-xs text-slate-500 {{ $locked ? 'blur-sm select-none' : '' }}">₹{{ $signal['stop_loss'] }}</td>
                                    <td class="px-6 py-5 font-mono text-xs text-slate-300 {{ $locked ? 'blur-sm select-none' : '' }}">₹{{ $signal['target_1'] }}</td>
                                    <td class="px-6 py-5 font-mono text-xs text-slate-300 {{ $locked ? 'blur-sm select-none' : '' }}">₹{{ $signal['target_2'] }}</td>
                                    <td class="px-6 py-5 font-bold text-purple-400 text-xs text-center">{{ $signal['confidence_level'] }}%</td>
                                    <td class="px-6 py-5 text-xs text-slate-500">{{ date('H:i', strtotime($signal['created_at'])) }}</td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>
                                            <span class="text-[9px] font-bold orbitron text-emerald-400 uppercase">ACTIVE</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        @if($locked)
                                            <a href="{{ url('/pricing') }}" class="text-[9px] font-black text-amber-400 flex items-center justify-end gap-1 hover:underline orbitron">
                                                <i data-lucide="lock" class="w-3 h-3"></i>
                                                UNLOCK
                                            </a>
                                        @else
                                            <button class="text-[9px] font-black text-purple-400 hover:text-white transition-colors orbitron">DETAILS</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-10 text-center text-gray-600 orbitron text-xs font-bold uppercase">No active signals detected in the current cycle.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-8 reveal-section">
                <div class="glass-panel rounded-3xl p-6 border border-white/5">
                    <h2 class="orbitron text-sm font-bold mb-6 flex justify-between uppercase italic tracking-widest text-white">
                        WATCHLIST
                        <span class="text-purple-500 cursor-pointer">+</span>
                    </h2>
                    <div class="space-y-4">
                        @php $watchlist = $watchlist->toArray(); @endphp
                        @if (empty($watchlist))
                            @php 
                                $placeholders = [['s'=>'RELIANCE', 'p'=>'2,854.20', 'c'=>'+1.45%'], ['s'=>'HDFC BANK', 'p'=>'1,620.00', 'c'=>'-0.8%']];
                            @endphp
                            @foreach($placeholders as $p)
                             <div class="flex justify-between items-center p-3 rounded-xl hover:bg-white/5 transition-all">
                                <div><div class="font-bold text-sm text-white">{{ $p['s'] }}</div><div class="text-[10px] text-gray-500 uppercase font-black orbitron">SIGNAL ACTIVE</div></div>
                                <div class="text-right"><div class="text-sm font-mono text-white">{{ $p['p'] }}</div><div class="text-[10px] font-bold {{ strpos($p['c'], '+') !== false ? 'text-emerald-400' : 'text-rose-400' }}">{{ $p['c'] }}</div></div>
                            </div>
                            @endforeach
                        @else
                            @foreach($watchlist as $item)
                            @php $item = (array)$item; @endphp
                            <div class="flex justify-between items-center p-3 rounded-xl hover:bg-white/5 transition-all">
                                <div class="font-bold text-sm text-white">{{ $item['stock_symbol'] }}</div>
                                <div class="text-xs font-mono text-emerald-400">+2.45%</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    gsap.from(".reveal-section", { duration: 1, y: 30, opacity: 0, stagger: 0.1, ease: "power3.out" });
    function toggleNotif() { document.getElementById('notif-panel').classList.toggle('active'); }
</script>
@endpush

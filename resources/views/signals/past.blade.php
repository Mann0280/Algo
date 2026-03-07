@extends('layouts.app')

@section('title', 'Past Signals | ALGO TRADE AI')

@push('styles')
<link href="https://unpkg.com/tabulator-tables@5.5.0/dist/css/tabulator_midnight.min.css" rel="stylesheet">
<style>
    .glass-card {
        background: rgba(10, 5, 20, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
    }
    .stats-card {
        background: linear-gradient(135deg, rgba(147, 51, 234, 0.1), rgba(79, 70, 229, 0.1));
        border: 1px solid rgba(147, 51, 234, 0.2);
    }
    .input-cyber {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    .input-cyber:focus {
        border-color: #9333ea;
        box-shadow: 0 0 15px rgba(147, 51, 234, 0.3);
        outline: none;
    }
    /* Tabulator Custom Cyber Theme */
    .tabulator {
        background-color: transparent !important;
        border: none !important;
        font-family: 'Inter', sans-serif !important;
    }
    .tabulator-header {
        background-color: rgba(255, 255, 255, 0.02) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #94a3b8 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        font-weight: 800 !important;
    }
    .tabulator-row {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03) !important;
        color: #e2e8f0 !important;
        transition: all 0.2s ease !important;
    }
    .tabulator-row:hover {
        background-color: rgba(147, 51, 234, 0.05) !important;
    }
    .tabulator-cell {
        padding: 12px 16px !important;
        border: none !important;
    }
    .tabulator-footer {
        background-color: transparent !important;
        border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #94a3b8 !important;
    }
    .tabulator-page {
        background: rgba(255, 255, 255, 0.05) !important;
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 0.5rem !important;
        margin: 0 2px !important;
    }
    .tabulator-page.active {
        background: #9333ea !important;
        border-color: #9333ea !important;
    }
</style>
@endpush

@section('content')
<main class="relative min-h-screen pt-12 pb-24 px-6 md:px-12">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-5xl font-black orbitron text-white mb-4 italic uppercase tracking-tighter">
                    PAST <span class="text-gradient">SIGNALS</span>
                </h1>
                <p class="text-gray-400 max-w-2xl text-lg uppercase tracking-tight">
                    Historical intelligence performance analytics and verification. All signals are premium curated assets.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="h-px w-24 bg-gradient-to-r from-purple-500 to-transparent hidden lg:block"></div>
                <span class="text-[10px] orbitron font-bold text-purple-500 uppercase tracking-[0.3em]">Historical Archive Mode V2.0</span>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="stats-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-[10px] font-bold text-purple-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL SIGNALS</p>
            <h3 class="text-4xl font-black text-white orbitron italic relative z-10">{{ $totalSignals }}</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-[10px] font-bold text-emerald-400 orbitron uppercase tracking-widest mb-1 relative z-10">WIN RATE</p>
            <h3 class="text-4xl font-black text-white orbitron italic relative z-10">{{ $winRate }}</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-[10px] font-bold text-blue-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL WIN</p>
            <h3 class="text-4xl font-black text-white orbitron italic relative z-10">{{ $totalWin }}</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute inset-0 bg-rose-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <p class="text-[10px] font-bold text-rose-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL LOSS</p>
            <h3 class="text-4xl font-black text-white orbitron italic relative z-10">{{ $totalLoss }}</h3>
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative">
        <!-- Main Content Area -->
        <div class="{{ $userState !== 'premium' ? 'blur-md pointer-events-none select-none opacity-40 transition-all duration-700' : '' }}">
            <!-- Filter Panel -->
            <div class="mb-8">
                <div class="glass-card p-6 border border-white/5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Start Date</label>
                            <input type="date" id="filter-start" class="input-cyber w-full">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">End Date</label>
                            <input type="date" id="filter-end" class="input-cyber w-full">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Symbol</label>
                            <input type="text" id="filter-symbol" placeholder="e.g. BTC" class="input-cyber w-full uppercase">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Signal Type</label>
                            <select id="filter-type" class="input-cyber w-full">
                                <option value="">ALL TYPES</option>
                                <option value="BUY">BUY</option>
                                <option value="SELL">SELL</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Result</label>
                            <select id="filter-result" class="input-cyber w-full">
                                <option value="">ALL RESULTS</option>
                                <option value="WIN">WIN</option>
                                <option value="LOSS">LOSS</option>
                                <option value="BREAKEVEN">BREAKEVEN</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button onclick="applyFilters()" class="flex-1 px-4 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-black orbitron text-xs uppercase italic tracking-widest rounded-xl transition-all shadow-lg shadow-purple-500/20">
                                Apply
                            </button>
                            <button onclick="resetFilters()" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 text-gray-400 font-black orbitron text-xs uppercase tracking-widest rounded-xl transition-all">
                                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="glass-card border border-white/5 overflow-hidden p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400 orbitron text-[10px] uppercase tracking-widest">
                            <th class="py-4 px-4 font-black">Stock Name</th>
                            <th class="py-4 px-4 font-black">Entry Price</th>
                            <th class="py-4 px-4 font-black">Target Price</th>
                            <th class="py-4 px-4 font-black">Stop Loss</th>
                            <th class="py-4 px-4 font-black">Breakeven</th>
                            <th class="py-4 px-4 font-black">Entry Date</th>
                            <th class="py-4 px-4 font-black">Entry Time</th>
                            <th class="py-4 px-4 font-black text-right">PnL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach ($signals as $signal)
                        <tr class="hover:bg-white/5 transition-colors">
                            <td class="py-4 px-4 font-black text-white orbitron uppercase">{{ $signal->stock_name }}</td>
                            <td class="py-4 px-4 text-gray-300">₹{{ number_format($signal->entry, 2) }}</td>
                            <td class="py-4 px-4 text-emerald-400 font-bold">₹{{ number_format($signal->target, 2) }}</td>
                            <td class="py-4 px-4 text-rose-400 font-bold">₹{{ number_format($signal->sl, 2) }}</td>
                            <td class="py-4 px-4 text-blue-400">₹{{ number_format($signal->breakeven, 2) }}</td>
                            <td class="py-4 px-4 text-gray-500 font-mono text-xs">{{ $signal->entry_date }}</td>
                            <td class="py-4 px-4 text-gray-500 font-mono text-xs">{{ $signal->entry_time }}</td>
                            <td class="py-4 px-4 text-right">
                                @if($signal->pnl !== null)
                                    <span class="font-black {{ $signal->pnl >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $signal->pnl >= 0 ? '+' : '' }}₹{{ number_format($signal->pnl, 2) }}
                                    </span>
                                @else
                                    <span class="text-gray-600">--</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($signals->isEmpty())
                    <div class="py-12 text-center">
                        <p class="orbitron text-xs text-gray-500 uppercase tracking-widest italic">Neural Archive Empty...</p>
                    </div>
                @endif
            </div>
        </div>
        {{-- Overlays kept from previous version as they are part of the UI structure --}}
        <!-- Locked Overlays -->
        @if($userState === 'guest')
        <div class="absolute inset-x-0 top-0 bottom-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm rounded-[2rem] border border-white/5">
            <div class="text-center p-12 glass-card max-w-lg border-purple-500/20 shadow-2xl shadow-purple-500/10 scale-110">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-purple-500/40">
                    <i data-lucide="lock" class="w-10 h-10 text-white"></i>
                </div>
                <h2 class="text-3xl font-black orbitron text-white mb-4 italic tracking-tighter">ARCHIVE ENCRYPTED</h2>
                <p class="text-gray-400 mb-8 leading-relaxed uppercase tracking-tight font-medium">Authentication is required to synchronize with the neural signal history archive.</p>
                <div class="flex flex-col gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-purple-600 hover:bg-purple-500 text-white font-black orbitron text-sm uppercase italic tracking-widest rounded-2xl transition-all shadow-lg shadow-purple-500/30">
                        Initiate Login
                    </a>
                    <a href="{{ route('register') }}" class="text-gray-500 hover:text-white orbitron text-[10px] uppercase tracking-widest transition-colors">Create Neural Identity</a>
                </div>
            </div>
        </div>
        @elseif($userState === 'free')
        <div class="absolute inset-x-0 top-0 bottom-0 z-50 flex items-center justify-center pointer-events-none">
            <div class="pointer-events-auto text-center p-12 glass-card max-w-lg border-purple-500/20 shadow-2xl shadow-purple-500/20 bg-black/60 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-purple-600/20 blur-[80px] rounded-full"></div>
                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-purple-500/40 relative z-10">
                    <i data-lucide="zap" class="w-10 h-10 text-white fill-white"></i>
                </div>
                <h2 class="text-3xl font-black orbitron text-white mb-4 italic tracking-tighter relative z-10 uppercase">PREMIUM ACCESS REQUIRED</h2>
                <p class="text-gray-400 mb-8 leading-relaxed uppercase tracking-tight font-medium relative z-10">Full signal history and performance verification is restricted to Premium Alpha Nodes.</p>
                <a href="{{ url('/pricing') }}" class="inline-block px-10 py-5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black orbitron text-sm uppercase italic tracking-[0.2em] rounded-2xl transition-all shadow-xl shadow-purple-600/40 relative z-10">
                    Upgrade to Premium
                </a>
            </div>
        </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush

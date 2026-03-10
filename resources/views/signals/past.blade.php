@extends('layouts.app')

@section('title', 'Past Signals | Emperor Stock Predictor')

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
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
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
        <div class="stats-card p-6 rounded-3xl relative overflow-hidden group" style="border-color: {{ $totalPnl >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(244,63,94,0.3)' }}">
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity" style="background: {{ $totalPnl >= 0 ? 'rgba(16,185,129,0.05)' : 'rgba(244,63,94,0.05)' }}"></div>
            <p class="text-[10px] font-bold orbitron uppercase tracking-widest mb-1 relative z-10" style="color: {{ $totalPnl >= 0 ? '#34d399' : '#fb7185' }}">TOTAL PNL</p>
            <h3 class="text-3xl font-black orbitron italic relative z-10" style="color: {{ $totalPnl >= 0 ? '#34d399' : '#fb7185' }}">
                {{ $totalPnl >= 0 ? '+' : '' }}₹{{ number_format($totalPnl, 2) }}
            </h3>
        </div>
    </div>

    <div class="max-w-7xl mx-auto relative">
        <!-- Main Content Area -->
        <div class="transition-all duration-700">
            <!-- Filter Panel -->
            <div class="mb-8">
                <div class="glass-card p-6 border border-white/5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Start Date</label>
                            <input type="date" id="filter-start" class="input-cyber w-full" value="{{ request('start_date') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">End Date</label>
                            <input type="date" id="filter-end" class="input-cyber w-full" value="{{ request('end_date') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Symbol</label>
                            <input type="text" id="filter-symbol" placeholder="E.G. BTC" class="input-cyber w-full uppercase" value="{{ request('symbol') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Signal Type</label>
                            <select id="filter-type" class="input-cyber w-full">
                                <option value="">ALL TYPES</option>
                                <option value="BUY" {{ request('signal_type') == 'BUY' ? 'selected' : '' }}>BUY</option>
                                <option value="SELL" {{ request('signal_type') == 'SELL' ? 'selected' : '' }}>SELL</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Result</label>
                            <select id="filter-result" class="input-cyber w-full">
                                <option value="">ALL RESULTS</option>
                                <option value="WIN" {{ request('result') == 'WIN' ? 'selected' : '' }}>WIN</option>
                                <option value="LOSS" {{ request('result') == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                                <option value="BREAKEVEN" {{ request('result') == 'BREAKEVEN' ? 'selected' : '' }}>BREAKEVEN</option>
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
            <div class="glass-card border border-white/5 overflow-hidden p-4 sm:p-6">
                <div class="overflow-x-auto -mx-4 sm:-mx-6">
                <table class="w-full text-left border-collapse" style="min-width: 700px;">
                    <thead>
                        <tr class="border-b border-white/10 text-gray-400 orbitron text-[10px] uppercase tracking-widest">
                            <th class="py-4 px-4 font-black whitespace-nowrap">Stock</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Entry</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Target</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Stop Loss</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Breakeven</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Date</th>
                            <th class="py-4 px-4 font-black whitespace-nowrap">Time</th>
                            <th class="py-4 px-4 font-black text-right whitespace-nowrap">PnL</th>
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
                </div>{{-- end overflow-x-auto --}}
                @if($signals->isEmpty())
                    <div class="py-12 text-center">
                        <p class="orbitron text-xs text-gray-500 uppercase tracking-widest italic">Neural Archive Empty...</p>
                    </div>
                @endif
            </div>
        </div>
        {{-- Overlays kept from previous version as they are part of the UI structure --}}

    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });

    function applyFilters() {
        const start = document.getElementById('filter-start').value;
        const end = document.getElementById('filter-end').value;
        const symbol = document.getElementById('filter-symbol').value;
        const type = document.getElementById('filter-type').value;
        const result = document.getElementById('filter-result').value;

        const params = new URLSearchParams();
        if (start) params.append('start_date', start);
        if (end) params.append('end_date', end);
        if (symbol) params.append('symbol', symbol);
        if (type) params.append('signal_type', type);
        if (result) params.append('result', result);

        window.location.href = window.location.pathname + '?' + params.toString();
    }

    function resetFilters() {
        window.location.href = window.location.pathname;
    }
</script>
@endpush

@extends('layouts.app')

@section('title', 'Past Signals | Emperor Stock Predictor')

@push('styles')
<!-- Using custom emperor theme instead of tabulator_midnight -->
<link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator.min.css" rel="stylesheet">
<style>
    .glass-card {
        background: rgba(10, 5, 20, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 2rem;
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
        color-scheme: dark;
    }
    .input-cyber:focus {
        border-color: #9333ea;
        box-shadow: 0 0 15px rgba(147, 51, 234, 0.3);
        outline: none;
    }
    select.input-cyber {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 0.9rem;
        padding-right: 2.5rem;
        cursor: pointer;
        width: 100% !important;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    select.input-cyber option {
        background-color: #0d061a;
        color: white;
        padding: 12px !important;
    }

    /* Premium Status Badges (Match Live Tips) */
    .status-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .status-win { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .status-loss { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
    .status-breakeven { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }

    .glow-badge::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: inherit;
        filter: blur(8px);
        opacity: 0.4;
        z-index: -1;
    }

    .tabulator {
        width: 100% !important;
        background-color: transparent !important;
        background: transparent !important;
        border: none !important;
        font-family: inherit !important;
    }
    .tabulator-header {
        position: sticky !important;
        top: 0;
        z-index: 10;
        background-color: rgba(10, 11, 20, 0.95) !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
    }
    .tabulator, .tabulator-table {
        background-color: transparent !important;
        background: transparent !important;
    }
    .tabulator-col {
        background: transparent !important;
        border: none !important;
    }
    .tabulator-row,
    .tabulator-row.tabulator-row-even,
    .tabulator-row.tabulator-row-odd,
    .tabulator-row:nth-child(even),
    .tabulator-row:nth-child(odd) {
        background-color: transparent !important;
        background: rgba(0,0,0,0) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        min-height: auto !important;
        padding: 0 !important;
        transition: all 0.3s ease !important;
    }
    .tabulator-row.tabulator-row-even {
        background-color: rgba(255, 255, 255, 0.01) !important;
    }
    .tabulator-row:hover {
        background: rgba(140,90,255,0.08) !important;
        background-color: rgba(140,90,255,0.08) !important;
        transform: scale(1.002);
    }
    .tabulator-cell {
        padding: 12px 16px !important;
        border: none !important;
        font-size: 12px !important;
    }
    .tabulator-footer {
        background: transparent !important;
        border: none !important;
        padding: 32px 0 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 20px !important;
        width: 100% !important;
    }

    /* Target the container that holds BOTH page-size and paginator */
    .tabulator-footer > div:first-child {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 20px !important;
        width: 100% !important;
    }

    /* Style the select box within footer */
    .tabulator-footer select {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: white !important;
        border-radius: 8px !important;
        padding: 6px 32px 6px 12px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        outline: none !important;
        transition: all 0.3s ease !important;
        color-scheme: dark;
        width: 100px !important;
        cursor: pointer !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 10px center !important;
    }

    .tabulator-footer select option {
        background-color: #0d061a !important;
        color: white !important;
        padding: 10px !important;
    }

    .tabulator-footer select:focus {
        border-color: #9333ea !important;
        box-shadow: 0 0 10px rgba(147, 51, 234, 0.2) !important;
    }

    /* Target the Page Size label */
    .tabulator-page-size {
        color: #64748b !important;
        font-size: 10px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        margin-right: 8px !important;
        display: flex !important;
        align-items: center !important;
    }

    .tabulator-page {
        background: rgba(255, 255, 255, 0.02) !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #94a3b8 !important;
        min-width: 36px !important;
        height: 36px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-radius: 10px !important;
        margin: 0 3px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    @media (max-width: 640px) {
        .tabulator-footer {
            padding: 30px 10px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 20px !important;
        }

        /* Group Page Size and Pagination sections to stack them vertically */
        .tabulator-footer .tabulator-page-size,
        .tabulator-footer .tabulator-paginator {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 12px !important;
            width: 100% !important;
            margin: 0 !important;
            float: none !important;
        }

        /* Keep the internal navigation elements (Prev, Numbers, Next) HORIZONTAL */
        .tabulator-footer .tabulator-pages {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 4px !important;
            width: auto !important;
            margin: 0 auto !important;
        }

        /* Ensure PREV, Numbers, and NEXT stay in a HORIZONTAL ROW */
        .tabulator-paginator {
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 6px !important;
        }

        .tabulator-page {
            min-width: 32px !important;
            height: 32px !important;
            margin: 2px !important;
            font-size: 10px !important;
            display: inline-flex !important;
            padding: 0 8px !important;
        }
        
        .tabulator-page-size {
            margin-bottom: 5px !important;
        }

        /* Hide First/Last on mobile to save space */
        .tabulator-page[data-page="first"],
        .tabulator-page[data-page="last"] {
            display: none !important;
        }
        
        .tabulator-page-counter {
            display: none !important;
        }
    }

    .tabulator-page:hover:not(.disabled) {
        background: rgba(147, 51, 234, 0.1) !important;
        color: white !important;
        border-color: rgba(147, 51, 234, 0.3) !important;
        transform: translateY(-2px) !important;
    }

    .tabulator-page.active {
        background: linear-gradient(135deg, #9333ea, #6366f1) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3) !important;
    }

    .tabulator-page.disabled {
        opacity: 0.3 !important;
        cursor: not-allowed !important;
    }

    /* Hide the default buttons if we want just numbers, but keeping them for now */
    .tabulator-page[data-page="first"],
    .tabulator-page[data-page="prev"],
    .tabulator-page[data-page="next"],
    .tabulator-page[data-page="last"] {
        padding: 0 12px !important;
        font-size: 9px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
    }

    @media (max-width: 480px) {
        .tabulator-page[data-page="prev"],
        .tabulator-page[data-page="next"] {
            padding: 0 8px !important;
            font-size: 8px !important;
        }
    }
    
    /* Strict Tabulator Background Override */
    div.tabulator-row {
        background-color: transparent !important;
    }
    div.tabulator-row.tabulator-row-even {
        background-color: rgba(255, 255, 255, 0.01) !important;
    }

    /* Custom Sleek Scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: rgba(10, 5, 20, 0.5);
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(147, 51, 234, 0.3);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(147, 51, 234, 0.6);
    }
    .tabulator .tabulator-tableholder::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    /* Laravel Pagination Cyber Styles */
    .pagination-cyber nav {
        background: transparent;
    }
    .pagination-cyber .relative.inline-flex.items-center {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 4px;
        gap: 4px;
    }
    .pagination-cyber a, .pagination-cyber span[aria-current="page"] > span {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 800;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }
    .pagination-cyber a {
        color: #94a3b8;
        background: transparent;
    }
    .pagination-cyber a:hover {
        background: rgba(147, 51, 234, 0.1);
        color: #c084fc;
        border-color: rgba(147, 51, 234, 0.2);
    }
    .pagination-cyber span[aria-current="page"] > span {
        background: linear-gradient(135deg, #7c3aed, #4f46e5);
        color: white;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }
    .pagination-cyber .hidden.flex-1.flex.items-center.justify-between {
        display: flex !important;
        flex-direction: column;
        gap: 16px;
        align-items: center;
    }
    @media (min-width: 640px) {
        .pagination-cyber .hidden.flex-1.flex.items-center.justify-between {
            flex-direction: row;
        }
    }
</style>
@endpush

@section('content')
<main class="relative min-h-screen pt-8 pb-16 px-6 md:px-12">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-5xl font-professional text-white mb-4 tracking-tighter">
                    Past <span class="text-gradient">Signals</span>
                </h1>
                <p class="text-gray-400 max-w-2xl text-lg tracking-tight">
                    Premium historical data records. 100% verified performance.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 group cursor-help">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">System Online</span>
                </div>
                <div class="h-px w-24 bg-gradient-to-r from-purple-500/50 to-transparent hidden lg:block"></div>
                <span class="text-[10px] font-bold text-purple-500 uppercase tracking-[0.3em]">ALL RECORDS</span>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-6 mb-12">
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-1 relative z-10">TOTAL SIGNALS</p>
            <h3 class="text-2xl font-bold text-white relative z-10">{{ $totalSignals ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1 relative z-10">WIN RATE</p>
            <h3 class="text-2xl font-bold text-white relative z-10">{{ $winRate ?? '0%' }}</h3>
         </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1 relative z-10">TOTAL WIN</p>
            <h3 class="text-2xl font-bold text-white relative z-10">{{ $totalWin ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-rose-400 uppercase tracking-widest mb-1 relative z-10">TOTAL LOSS</p>
            <h3 class="text-2xl font-bold text-white relative z-10">{{ $totalLoss ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest mb-1 relative z-10">TOTAL EOD</p>
            <h3 class="text-2xl font-bold text-white relative z-10">{{ $totalEOD ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-1 relative z-10">CAPITAL Per Trade</p>
            <h3 id="stat-total-capital" class="text-xl font-bold text-white relative z-10">₹100K</h3>
        </div>
        <div id="stat-pnl-card" class="stats-card p-4 rounded-3xl relative overflow-hidden group" style="border-color: {{ ($totalPnl ?? 0) >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(244,63,94,0.3)' }}">
            <p id="stat-pnl-label" class="text-[10px] font-bold uppercase tracking-widest mb-1 relative z-10" style="color: {{ ($totalPnl ?? 0) >= 0 ? '#34d399' : '#fb7185' }}">TOTAL PNL</p>
            <h3 id="stat-total-pnl-top" class="text-xl font-bold relative z-10" style="color: {{ ($totalPnl ?? 0) >= 0 ? '#34d399' : '#fb7185' }}">
                {{ ($totalPnl ?? 0) >= 0 ? '+' : '' }}₹{{ number_format($totalPnl ?? 0, 0) }}
            </h3>
        </div>
    </div>

    <!-- Profit Simulator -->
    <div class="max-w-7xl mx-auto mb-12">
        <div class="glass-card p-8 border border-purple-500/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/5 blur-[100px] rounded-full"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="space-y-2">
                    <h2 class="font-professional text-2xl text-white tracking-tighter">
                        Profit <span class="text-gradient">Simulator</span>
                    </h2>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">Live Profit Analysis</p>
                </div>

                <div class="flex flex-wrap items-end gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-purple-400 uppercase tracking-widest ml-1">Investment Per Trade (₹)</label>
                        <input type="number" id="capital-input" placeholder="e.g. 100000" value="100000"
                               class="input-cyber w-full sm:w-64 font-bold text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button onclick="calculateSimulation()" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-lg hover:shadow-purple-500/40 transform hover:-translate-y-1">
                            Calculate Profit
                        </button>
                        <button onclick="resetSimulation()" class="px-5 py-3 bg-white/5 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all border border-white/5 hover:bg-white/10">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div id="sim-result-container" class="hidden min-w-[240px] p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-inner">
                    <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest mb-1">PROFIT RESULT</p>
                    <div id="sim-total-pnl" class="text-2xl font-bold">₹0.00</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="max-w-7xl mx-auto mb-12">
        <form action="{{ route('signals.past') }}" method="GET" class="glass-card p-6 border border-white/5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Start Date</label>
                    <input type="date" name="start_date" class="input-cyber w-full" value="{{ request('start_date') }}">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">End Date</label>
                    <input type="date" name="end_date" class="input-cyber w-full" value="{{ request('end_date') }}">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Symbol</label>
                    <input type="text" name="symbol" placeholder="E.G. NIFTY" class="input-cyber w-full uppercase" value="{{ request('symbol') }}">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Type</label>
                    <select name="signal_type" class="input-cyber w-full">
                        <option value="">ALL TYPES</option>
                        <option value="BUY" {{ request('signal_type') == 'BUY' ? 'selected' : '' }}>BUY</option>
                        <option value="SELL" {{ request('signal_type') == 'SELL' ? 'selected' : '' }}>SELL</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Signal Result</label>
                    <select name="result" class="input-cyber w-full">
                        <option value="">ALL RESULTS</option>
                        <option value="WIN" {{ request('result') == 'WIN' ? 'selected' : '' }}>WIN</option>
                        <option value="LOSS" {{ request('result') == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                        <option value="EOD" {{ request('result') == 'EOD' ? 'selected' : '' }}>EOD</option>
                        <option value="BREAKEVEN" {{ request('result') == 'BREAKEVEN' ? 'selected' : '' }}>BREAKEVEN</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-purple-900/40 hover:shadow-purple-500/50 hover:-translate-y-0.5 transition-all active:scale-95 group relative overflow-hidden">
                        <span class="relative z-10">Apply</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                    <a href="{{ route('signals.past') }}" class="px-4 py-2.5 bg-white/5 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl border border-white/5 flex items-center justify-center hover:bg-white/10">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabulator Table Section -->
    <div class="max-w-7xl mx-auto px-4 md:px-0">
        <div class="flex items-center justify-between mb-6">
            <div id="data-status-badge" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 hidden">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="data-status-text" class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">History Update Successful</span>
            </div>
            <div class="flex items-center gap-2 text-[10px] text-gray-600 font-bold uppercase tracking-[0.2em] hidden md:flex">
                <i data-lucide="info" class="w-3 h-3"></i> Use scroll for more data
            </div>
        </div>

        <div class="table-wrapper">
            <div id="signals-table" class="whiskey-table"></div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script>
    window.addEventListener('load', function() {
        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        @php
            $defaultCapital = 100000;
            $tableData = $signals->map(function($s) use ($defaultCapital) {
                return [
                    'id' => $s->id,
                    'stock' => (string)($s->symbol ?: $s->stock_name ?: '---'),
                    'type' => (string)($s->signal_type ?? '---'),
                    'entry' => (float)($s->entry ?? 0),
                    'exit' => (float)($s->close_price ?? 0),
                    'target' => (float)($s->target ?? 0),
                    'sl' => (float)($s->sl ?? 0),
                    'breakeven' => (float)($s->breakeven ?? 0),
                    'date' => (string)($s->entry_date ?? '---'),
                    'time' => (string)($s->entry_time ?? '---'),
                    'quantity' => $s->getCalculatedQty($defaultCapital),
                    'pnl' => (float)($s->pnl ?? 0),
                    'sim_pnl' => $s->getCalculatedSimPnl($defaultCapital),
                    'result' => (string)($s->result ?? '---'),
                ];
            });
        @endphp
        
        const rawData = @json($tableData);

        // UI Update for record count
        const statusBadge = document.getElementById('data-status-badge');
        const statusText = document.getElementById('data-status-text');
        if (statusBadge && statusText) {
            statusBadge.classList.remove('hidden');
            statusText.textContent = `${rawData.length} HISTORICAL RECORDS`;
        }

        try {
            window.signalsTable = new Tabulator("#signals-table", {
                data: rawData,
                layout: "fitDataStretch",
                responsiveLayout: false,
                pagination: "local",
                paginationSize: 20,
                paginationSizeSelector: [10, 20, 50, 100],
                placeholder: "<div class='text-gray-600 py-16 text-[10px] font-bold uppercase tracking-[0.4em]'>NO HISTORY FOUND</div>",
                resizableColumns: true,
                columnHeaderVertAlign: "bottom",
                columns: [
                    {title: "Stock", field: "stock", hozAlign: "left", minWidth: 120, formatter: function(cell){
                        return "<span style='font-weight:bold; color:white;'>" + cell.getValue() + "</span>";
                    }},
                    {title: "Type", field: "type", hozAlign: "center", minWidth: 90, formatter: function(cell){
                        let val = cell.getValue().toUpperCase();
                        let color = val === 'BUY' ? '#10b981' : (val === 'SELL' ? '#ef4444' : '#94a3b8');
                        return `<span style="color:${color}; font-weight:900; font-size:10px;">${val}</span>`;
                    }},
                    {title: "Entry", field: "entry", hozAlign: "right", minWidth: 110, formatter: function(cell){
                        return "<span style='color:white;'>₹" + cell.getValue().toLocaleString() + "</span>";
                    }},
                    {title: "Exit", field: "exit", hozAlign: "right", minWidth: 110, formatter: function(cell){
                        return "<span style='color:#94a3b8'>₹" + (cell.getValue() || 0).toLocaleString() + "</span>";
                    }},
                    {title: "Target", field: "target", hozAlign: "right", minWidth: 110, formatter: function(cell){
                        return "<span style='color:#10b981'>₹" + cell.getValue().toLocaleString() + "</span>";
                    }},
                    {title: "Stop Loss", field: "sl", hozAlign: "right", minWidth: 100, formatter: function(cell){
                        return "<span style='color:#ef4444'>₹" + cell.getValue().toLocaleString() + "</span>";
                    }},
                    {title: "Breakeven", field: "breakeven", hozAlign: "right", minWidth: 100, formatter: function(cell){
                        return "<span style='color:#3b82f6'>₹" + cell.getValue().toLocaleString() + "</span>";
                    }},
                    {title: "Date", field: "date", hozAlign: "center", minWidth: 160, formatter: function(cell) {
                        let time = cell.getData().time || '';
                        return `<div class="flex flex-col items-center">
                            <span class="text-white font-bold">${cell.getValue()}</span>
                            ${time ? `<span class="text-[9px] text-gray-500 font-medium">${time}</span>` : ''}
                        </div>`;
                    }},
                    {title: "Result", field: "result", hozAlign: "center", minWidth: 110, formatter: function(cell){
                        let val = (cell.getValue() || '').toUpperCase();
                        let pnl = cell.getData().pnl;
                        
                        // Fallback logic if result is empty
                        if (!val || val === '---') {
                            if (pnl > 0) val = 'WIN';
                            else if (pnl < 0) val = 'LOSS';
                            else val = '---';
                        }

                        let cls = '';
                        if (['WIN', 'TP HIT'].includes(val)) cls = 'status-win';
                        else if (['LOSS', 'SL HIT'].includes(val)) cls = 'status-loss';
                        else if (['BREAKEVEN', 'EOD'].includes(val)) cls = 'status-breakeven';
                        
                        return val !== '---' ? `<span class="status-badge ${cls}">${val}</span>` : '---';
                    }},
                    {title: "Points", field: "pnl", hozAlign: "right", minWidth: 100, formatter: function(cell){
                        let val = cell.getValue();
                        let color = val > 0 ? '#10b981' : (val < 0 ? '#ef4444' : '#94a3b8');
                        return `<span style="color:${color}; font-weight:bold;">${val > 0 ? '+' : ''}${val}</span>`;
                    }},
                    {title: "Qty", field: "quantity", hozAlign: "center", minWidth: 110, formatter: function(cell){
                        let val = cell.getValue();
                        let display = val && val > 0 ? Math.floor(val).toLocaleString() : "---";
                        return `<span style="color:white;">${display}</span>`;
                    }},
                    {title: "PNL", field: "sim_pnl", hozAlign: "right", minWidth: 120, formatter: function(cell){
                        let value = cell.getValue();
                        if(value > 0){
                            return "<span style='color:#10b981; font-weight:bold;'>+₹" + value.toLocaleString() + "</span>";
                        } else if(value < 0){
                            return "<span style='color:#ef4444; font-weight:bold;'>-₹" + Math.abs(value).toLocaleString() + "</span>";
                        } else {
                            return "₹" + value;
                        }
                    }}
                ],
            });

            // Bind Custom Page Size Selector
            document.getElementById("page-size-selector").addEventListener("change", function() {
                window.signalsTable.setPageSize(this.value);
            });

            // Initial simulation check
            const capitalInput = document.getElementById("capital-input");
            if (capitalInput) {
                capitalInput.value = 100000;
            }
            calculateSignals(); // unified calculation function

        } catch (err) {
            console.error("Initialization Failure:", err);
            document.getElementById('signals-table').innerHTML = `<div class='p-10 text-rose-500 font-bold text-[10px]'>SYSTEM OVERLOAD: ${err.message}</div>`;
        }

        // Store original stats state
        const statPnlTop = document.getElementById('stat-total-pnl-top');
        if (statPnlTop) {
            window.originalPnlState = {
                text: statPnlTop.textContent,
                color: statPnlTop.style.color,
                borderColor: document.getElementById('stat-pnl-card').style.borderColor,
                labelColor: document.getElementById('stat-pnl-label').style.color
            };
        }

        // Recalculate When Capital Changes
        const capInput = document.getElementById("capital-input");
        if (capInput) {
            capInput.addEventListener("input", calculateSignals);
            
            // Sync with stat card
            capInput.addEventListener('input', function() {
                const val = parseFloat(this.value);
                const statCapital = document.getElementById('stat-total-capital');
                if (statCapital) {
                    if (!isNaN(val) && val >= 0) {
                        let display = '';
                        if (val >= 1000) {
                            display = `₹${(val / 1000).toFixed(1).replace(/\.0$/, '')}K`;
                        } else {
                            display = `₹${val}`;
                        }
                        statCapital.textContent = display;
                    } else if (this.value === '') {
                        statCapital.textContent = '₹0';
                    }
                }
            });
        }
    });

    function calculateSignals() {
        if(!window.signalsTable) return;
        const capitalInput = document.getElementById('capital-input');
        const capital = parseFloat(capitalInput.value) || 100000;
        const effectiveCapital = capital * 5; // 5x Leverage as per user formula

        let totalNetPnl = 0;
        const tableData = window.signalsTable.getData();

        tableData.forEach(row => {
            const entry = parseFloat(row.entry);
            const pnlPerUnit = parseFloat(row.pnl);

            if (!entry || entry <= 0) {
                row.quantity = 0;
                row.sim_pnl = 0;
                return;
            }

            // Formula: Quantity = (Capital * 5) / Entry
            row.quantity = Math.floor(effectiveCapital / entry);
            // Formula: PNL = Points * Quantity
            row.sim_pnl = row.quantity * pnlPerUnit;
            totalNetPnl += row.sim_pnl;
        });

        window.signalsTable.replaceData(tableData);

        // Update UI Summary Result (Simulator Container)
        const summaryVal = document.getElementById('sim-total-pnl');
        if (summaryVal) {
            summaryVal.textContent = (totalNetPnl >= 0 ? '+' : '-') + `₹${Math.abs(totalNetPnl).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            summaryVal.className = `text-2xl font-bold ${totalNetPnl >= 0 ? 'text-emerald-400' : 'text-rose-400'}`;
            document.getElementById('sim-result-container').classList.remove('hidden');
        }

        // Update Top Stat Cards
        const topPnl = document.getElementById('stat-total-pnl-top');
        if (topPnl) {
            const pnlColor = totalNetPnl >= 0 ? '#34d399' : '#fb7185';
            topPnl.textContent = (totalNetPnl >= 0 ? '+' : '-') + `₹${Math.abs(totalNetPnl).toLocaleString(undefined, {minimumFractionDigits: 0})}`;
            topPnl.style.color = pnlColor;
            
            const pnlCard = document.getElementById('stat-pnl-card');
            const pnlLabel = document.getElementById('stat-pnl-label');
            if (pnlCard) pnlCard.style.borderColor = totalNetPnl >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(244,63,94,0.3)';
            if (pnlLabel) {
                pnlLabel.textContent = 'TOTAL PNL';
                pnlLabel.style.color = pnlColor;
            }
        }
    }

    function calculateSimulation() {
        calculateSignals();
    }

    function resetSimulation() {
        if(!window.signalsTable) return;
        document.getElementById('sim-result-container').classList.add('hidden');
        const capInput = document.getElementById('capital-input');
        if (capInput) capInput.value = '';
        document.getElementById('stat-total-capital').textContent = '₹0';
        window.signalsTable.updateData(window.signalsTable.getData().map(row => ({ ...row, quantity: 0, sim_pnl: row.pnl })));
        
        if (window.originalPnlState) {
            const topPnl = document.getElementById('stat-total-pnl-top');
            topPnl.textContent = window.originalPnlState.text;
            topPnl.style.color = window.originalPnlState.color;
            document.getElementById('stat-pnl-card').style.borderColor = window.originalPnlState.borderColor;
            document.getElementById('stat-pnl-label').style.color = window.originalPnlState.labelColor;
        }
    }
</script>
@endpush

@extends('layouts.app')

@section('title', 'Past Signals | Emperor Stock Predictor')

@push('styles')
<style>
    :root { color-scheme: dark; }
    
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
        background: #160d2e;
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
    }
    select.input-cyber option {
        background-color: #0d061a !important;
        color: white !important;
        padding: 12px;
    }

    /* Global Select Style for Dark Mode */
    select {
        color-scheme: dark;
        background-color: #160d2e !important;
    }
    option {
        background-color: #160d2e !important;
        color: white !important;
    }

    .mini-select {
        appearance: none;
        background-color: rgba(255, 255, 255, 0.03);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        background-size: 0.7rem;
        padding: 0.25rem 1.75rem 0.25rem 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.5rem;
        color: white;
        font-weight: 700;
        font-size: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .mini-select:hover {
        background-color: rgba(255, 255, 255, 0.05);
        border-color: rgba(147, 51, 234, 0.3);
    }
    .mini-select:focus {
        outline: none;
        border-color: #9333ea;
        box-shadow: 0 0 10px rgba(147, 51, 234, 0.2);
    }

    /* Premium Status Badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-win { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
    .status-loss { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
    .status-breakeven { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }

    /* Custom Table Styles */
    .custom-table-container {
        overflow-x: auto;
        border-radius: 1.5rem;
        background: rgba(10, 5, 20, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }
    .custom-table th {
        background: rgba(15, 10, 30, 0.8);
        padding: 16px;
        text-align: left;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        white-space: nowrap;
    }
    .custom-table td {
        padding: 14px 16px;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        transition: all 0.2s ease;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    .custom-table tr:hover td {
        background: rgba(147, 51, 234, 0.05);
    }

    /* Modal Styles */
    .modal-backdrop {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        transition: opacity 0.3s ease;
    }
    .modal-content {
        background: #0d061a;
        border: 1px solid rgba(147, 51, 234, 0.3);
        box-shadow: 0 0 40px rgba(147, 51, 234, 0.2);
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    #details-modal.modal-open .modal-content {
        transform: translateY(0);
    }

    /* Pagination Styles */
    .page-btn {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: #94a3b8;
        font-weight: 700;
        font-size: 11px;
        transition: all 0.2s ease;
    }
    .page-btn:hover:not(:disabled) {
        background: rgba(147, 51, 234, 0.1);
        color: white;
        border-color: rgba(147, 51, 234, 0.3);
    }
    .page-btn.active {
        background: linear-gradient(135deg, #9333ea, #6366f1);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3);
    }
    .page-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    /* Custom Scrollbar */
    .custom-table-container::-webkit-scrollbar {
        height: 6px;
    }
    .custom-table-container::-webkit-scrollbar-track {
        background: rgba(10, 5, 20, 0.5);
    }
    .custom-table-container::-webkit-scrollbar-thumb {
        background: rgba(147, 51, 234, 0.3);
        border-radius: 4px;
    }

    @media (max-width: 767px) {
        .desktop-only { display: none !important; }
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
                <span class="inline-flex items-center gap-[1px]">
                    {{ ($totalPnl ?? 0) >= 0 ? '+' : '-' }}₹{{ number_format(abs($totalPnl ?? 0), 0) }}
                </span>
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
                    <select name="signal_type" class="input-cyber w-full" style="color-scheme: dark;">
                        <option value="">ALL TYPES</option>
                        <option value="BUY" {{ request('signal_type') == 'BUY' ? 'selected' : '' }}>BUY</option>
                        <option value="SELL" {{ request('signal_type') == 'SELL' ? 'selected' : '' }}>SELL</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Signal Result</label>
                    <select name="result" class="input-cyber w-full" style="color-scheme: dark;">
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

    <!-- Custom Table Section -->
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6 px-4 md:px-0">
            <div id="data-status-badge" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="data-status-text" class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Loading Records...</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Show</span>
                    <select id="page-size-selector" class="mini-select">
                        <option value="10">10</option>
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="custom-table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th class="desktop-only text-center">Type</th>
                        <th class="desktop-only text-right">Entry</th>
                        <th class="desktop-only text-right">Exit</th>
                        <th class="desktop-only text-right">Target</th>
                        <th class="desktop-only text-right">Stop Loss</th>
                        <th class="desktop-only text-right">Breakeven</th>
                        <th class="desktop-only text-center">Date</th>
                        <th class="text-center">Result</th>
                        <th class="desktop-only text-right">Points</th>
                        <th class="desktop-only text-center">Qty</th>
                        <th class="desktop-only text-right">PNL</th>
                        <th class="text-center md:hidden">Action</th>
                    </tr>
                </thead>
                <tbody id="signals-table-body">
                    <!-- Rows rendered via JS -->
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mt-8 px-4 md:px-0 text-center md:text-left">
            <div id="pagination-info" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                Showing 0 to 0 of 0 records
            </div>
            <div id="pagination-controls" class="flex items-center justify-center gap-2">
                <!-- Buttons rendered via JS -->
            </div>
        </div>
    </div>
</main>

<!-- Mobile Details Modal -->
<div id="details-modal" class="fixed inset-0 z-[100] flex items-center justify-center px-6 hidden opacity-0 transition-all duration-300">
    <div class="absolute inset-0 modal-backdrop" onclick="closeModal()"></div>
    <div class="modal-content w-full max-w-lg rounded-[2.5rem] p-8 relative z-10 overflow-hidden">
        <div class="flex items-start justify-between mb-8">
            <div>
                <h2 id="modal-stock-name" class="text-3xl font-professional text-white tracking-tighter uppercase">STOCK NAME</h2>
                <p id="modal-date" class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">DATE & TIME</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 text-gray-400 hover:text-white transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Signal Type</p>
                <p id="modal-type" class="text-sm font-black uppercase tracking-wider">BUY</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Result Status</p>
                <div id="modal-result-container"></div>
            </div>
            
            <div class="col-span-2 h-px bg-white/5 my-2"></div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Entry Price</p>
                <p id="modal-entry" class="text-lg font-bold text-white tracking-tight">₹0.00</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Exit Price</p>
                <p id="modal-exit" class="text-lg font-bold text-gray-400 tracking-tight">₹0.00</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Target Price</p>
                <p id="modal-target" class="text-lg font-bold text-emerald-500 tracking-tight">₹0.00</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Stop Loss</p>
                <p id="modal-sl" class="text-lg font-bold text-rose-500 tracking-tight">₹0.00</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Breakeven</p>
                <p id="modal-breakeven" class="text-lg font-bold text-blue-500 tracking-tight">₹0.00</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Points (P/L)</p>
                <p id="modal-points" class="text-lg font-bold tracking-tight">0.00</p>
            </div>

            <div class="col-span-2 h-px bg-white/5 my-2"></div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest">Calculated Qty</p>
                <p id="modal-qty" class="text-xl font-black text-white">0</p>
            </div>
            <div class="space-y-1">
                <p class="text-[10px] font-bold text-purple-400 uppercase tracking-widest">Net Profit/Loss</p>
                <p id="modal-pnl" class="text-xl font-black">₹0.00</p>
            </div>
        </div>

        <div class="mt-10">
            <button onclick="closeModal()" class="w-full py-4 bg-white/5 text-white font-bold text-xs uppercase tracking-[0.2em] rounded-2xl border border-white/10 hover:bg-white/10 transition-all">
                Close Details
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // State Management
    let signalsData = [];
    let currentPage = 1;
    let pageSize = 20;
    let currentModalId = null;

    window.addEventListener('load', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();

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
        
        signalsData = @json($tableData);
        initializeUI();
        calculateSignals();
    });

    function initializeUI() {
        const statusText = document.getElementById('data-status-text');
        if (statusText) statusText.textContent = `${signalsData.length} HISTORICAL RECORDS`;

        document.getElementById('page-size-selector').addEventListener('change', (e) => {
            pageSize = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });

        const capInput = document.getElementById("capital-input");
        if (capInput) {
            capInput.addEventListener("input", () => {
                calculateSignals();
                updateStatCards();
            });
        }
    }

    function calculateSignals() {
        const capitalInput = document.getElementById('capital-input');
        const capital = parseFloat(capitalInput.value) || 100000;
        const effectiveCapital = capital * 5;

        signalsData.forEach(row => {
            if (!row.entry || row.entry <= 0) {
                row.quantity = 0;
                row.sim_pnl = 0;
            } else {
                row.quantity = Math.floor(effectiveCapital / row.entry);
                row.sim_pnl = row.quantity * row.pnl;
            }
        });

        renderTable();
        if (currentModalId) updateModal(currentModalId);
    }

    function updateStatCards() {
        const capitalInput = document.getElementById('capital-input');
        const capital = parseFloat(capitalInput.value) || 100000;
        
        const statCapital = document.getElementById('stat-total-capital');
        if (statCapital) {
            statCapital.textContent = capital >= 1000 ? `₹${(capital / 1000).toFixed(1).replace(/\.0$/, '')}K` : `₹${capital}`;
        }

        const totalNetPnl = signalsData.reduce((acc, row) => acc + (row.sim_pnl || 0), 0);
        
        const topPnl = document.getElementById('stat-total-pnl-top');
        const pnlCard = document.getElementById('stat-pnl-card');
        const pnlLabel = document.getElementById('stat-pnl-label');
        const simResultVal = document.getElementById('sim-total-pnl');
        const simResultContainer = document.getElementById('sim-result-container');

        const pnlColor = totalNetPnl >= 0 ? '#34d399' : '#fb7185';
        const formattedPnl = (totalNetPnl >= 0 ? '+' : '-') + `₹${Math.abs(totalNetPnl).toLocaleString(undefined, {maximumFractionDigits: 0})}`;

        if (topPnl) {
            const pnlPrefix = totalNetPnl >= 0 ? '+' : '-';
            const pnlValue = Math.abs(totalNetPnl).toLocaleString(undefined, {maximumFractionDigits: 0});
            topPnl.innerHTML = `<span class="inline-flex items-center gap-[1px]">${pnlPrefix}₹${pnlValue}</span>`;
            topPnl.style.color = pnlColor;
        }
        if (pnlCard) pnlCard.style.borderColor = totalNetPnl >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(244,63,94,0.3)';
        if (pnlLabel) {
            pnlLabel.style.color = pnlColor;
            pnlLabel.textContent = 'TOTAL PNL';
        }
        if (simResultVal) {
            const simPrefix = totalNetPnl >= 0 ? '+' : '-';
            const simValue = Math.abs(totalNetPnl).toLocaleString(undefined, {minimumFractionDigits: 2});
            simResultVal.innerHTML = `<span class="inline-flex items-center gap-[1px]">${simPrefix}₹${simValue}</span>`;
            simResultVal.className = `text-2xl font-bold ${totalNetPnl >= 0 ? 'text-emerald-400' : 'text-rose-400'}`;
        }
        if (simResultContainer) simResultContainer.classList.remove('hidden');
    }

    function renderTable() {
        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        const paginatedData = signalsData.slice(start, end);
        const tbody = document.getElementById('signals-table-body');
        
        tbody.innerHTML = paginatedData.length ? '' : `<tr><td colspan="13" class="text-center py-20 text-gray-500 font-bold uppercase tracking-[0.3em] text-[10px]">No Records Found</td></tr>`;

        paginatedData.forEach(row => {
            const resultBadge = getResultBadge(row.result, row.pnl);
            const tr = document.createElement('tr');
            
            tr.innerHTML = `
                <td class="font-bold text-white uppercase">${row.stock}</td>
                <td class="desktop-only text-center font-black text-[10px]" style="color: ${row.type === 'BUY' ? '#10b981' : '#ef4444'}">${row.type}</td>
                <td class="desktop-only text-right text-white">₹${row.entry.toLocaleString()}</td>
                <td class="desktop-only text-right text-gray-500">₹${row.exit.toLocaleString()}</td>
                <td class="desktop-only text-right text-emerald-500">₹${row.target.toLocaleString()}</td>
                <td class="desktop-only text-right text-rose-500">₹${row.sl.toLocaleString()}</td>
                <td class="desktop-only text-right text-blue-500">₹${row.breakeven.toLocaleString()}</td>
                <td class="desktop-only text-center">
                    <div class="flex flex-col">
                        <span class="text-white font-bold text-[11px]">${row.date}</span>
                        <span class="text-gray-500 text-[9px]">${row.time}</span>
                    </div>
                </td>
                <td class="text-center">${resultBadge}</td>
                <td class="desktop-only text-right font-bold" style="color: ${row.pnl > 0 ? '#10b981' : (row.pnl < 0 ? '#ef4444' : '#94a3b8')}">
                    <span class="inline-flex items-center gap-[1px] whitespace-nowrap">
                        ${row.pnl > 0 ? '+' : ''}${row.pnl}
                    </span>
                </td>
                <td class="desktop-only text-center text-white">${Math.floor(row.quantity).toLocaleString()}</td>
                <td class="desktop-only text-right font-bold" style="color: ${row.sim_pnl > 0 ? '#10b981' : (row.sim_pnl < 0 ? '#ef4444' : '#94a3b8')}">
                    <span class="inline-flex items-center gap-[1px] whitespace-nowrap">
                        ${row.sim_pnl >= 0 ? '+' : '-'}₹${Math.abs(row.sim_pnl).toLocaleString(undefined, {maximumFractionDigits: 0})}
                    </span>
                </td>
                <td class="text-center md:hidden">
                    <button onclick="openModal(${row.id})" class="px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-purple-400 font-bold text-[10px] uppercase tracking-wider hover:bg-white/10 active:scale-95 transition-all">
                        Details
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        renderPaginationControls();
    }

    function renderPaginationControls() {
        const totalPages = Math.ceil(signalsData.length / pageSize);
        const controls = document.getElementById('pagination-controls');
        const info = document.getElementById('pagination-info');
        
        info.textContent = `Showing ${(currentPage-1)*pageSize + 1} to ${Math.min(currentPage*pageSize, signalsData.length)} of ${signalsData.length} records`;
        
        controls.innerHTML = '';
        
        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.disabled = currentPage === 1;
        prevBtn.innerHTML = '<i data-lucide="chevron-left" class="w-4 h-4"></i>';
        prevBtn.onclick = () => { currentPage--; renderTable(); };
        controls.appendChild(prevBtn);

        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(totalPages, startPage + 2);
        if (endPage - startPage < 2) startPage = Math.max(1, endPage - 2);

        for (let i = startPage; i <= endPage; i++) {
            const btn = document.createElement('button');
            btn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
            btn.textContent = i;
            btn.onclick = () => { currentPage = i; renderTable(); };
            controls.appendChild(btn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.innerHTML = '<i data-lucide="chevron-right" class="w-4 h-4"></i>';
        nextBtn.onclick = () => { currentPage++; renderTable(); };
        controls.appendChild(nextBtn);

        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function getResultBadge(res, pnl) {
        let val = (res || '').toUpperCase();
        if (!val || val === '---') {
            if (pnl > 0) val = 'WIN';
            else if (pnl < 0) val = 'LOSS';
            else return '<span class="text-gray-600 font-bold">---</span>';
        }

        let cls = '';
        if (['WIN', 'TP HIT'].includes(val)) cls = 'status-win';
        else if (['LOSS', 'SL HIT'].includes(val)) cls = 'status-loss';
        else if (['BREAKEVEN', 'EOD'].includes(val)) cls = 'status-breakeven';
        
        return `<span class="status-badge ${cls}">${val}</span>`;
    }

    function openModal(id) {
        currentModalId = id;
        const row = signalsData.find(r => r.id === id);
        if (!row) return;

        updateModalData(row);
        
        const modal = document.getElementById('details-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100', 'modal-open');
        }, 10);
        document.body.classList.add('overflow-hidden');
    }

    function updateModal(id) {
        const row = signalsData.find(r => r.id === id);
        if (row) updateModalData(row);
    }

    function updateModalData(row) {
        document.getElementById('modal-stock-name').textContent = row.stock;
        document.getElementById('modal-date').textContent = `${row.date} @ ${row.time}`;
        
        const typeEl = document.getElementById('modal-type');
        typeEl.textContent = row.type;
        typeEl.style.color = row.type === 'BUY' ? '#10b981' : '#ef4444';
        
        document.getElementById('modal-result-container').innerHTML = getResultBadge(row.result, row.pnl);
        document.getElementById('modal-entry').textContent = `₹${row.entry.toLocaleString()}`;
        document.getElementById('modal-exit').textContent = `₹${row.exit.toLocaleString()}`;
        document.getElementById('modal-target').textContent = `₹${row.target.toLocaleString()}`;
        document.getElementById('modal-sl').textContent = `₹${row.sl.toLocaleString()}`;
        document.getElementById('modal-breakeven').textContent = `₹${row.breakeven.toLocaleString()}`;
        
        const pointsEl = document.getElementById('modal-points');
        const pointsPrefix = row.pnl > 0 ? '+' : '';
        pointsEl.innerHTML = `<span class="inline-flex items-center gap-[1px]">${pointsPrefix}${row.pnl}</span>`;
        pointsEl.style.color = row.pnl > 0 ? '#10b981' : (row.pnl < 0 ? '#ef4444' : '#94a3b8');
        
        document.getElementById('modal-qty').textContent = Math.floor(row.quantity).toLocaleString();
        
        const pnlEl = document.getElementById('modal-pnl');
        const pnlPrefix = row.sim_pnl >= 0 ? '+' : '-';
        const pnlValue = Math.abs(row.sim_pnl).toLocaleString(undefined, {maximumFractionDigits: 0});
        pnlEl.innerHTML = `<span class="inline-flex items-center gap-[1px]">${pnlPrefix}₹${pnlValue}</span>`;
        pnlEl.className = `text-xl font-black ${row.sim_pnl >= 0 ? 'text-emerald-400' : 'text-rose-400'}`;
    }

    function closeModal() {
        const modal = document.getElementById('details-modal');
        modal.classList.remove('opacity-100', 'modal-open');
        setTimeout(() => {
            modal.classList.add('hidden');
            currentModalId = null;
        }, 300);
        document.body.classList.remove('overflow-hidden');
    }

    function calculateSimulation() {
        calculateSignals();
    }

    function resetSimulation() {
        document.getElementById('sim-result-container').classList.add('hidden');
        const capInput = document.getElementById('capital-input');
        if (capInput) capInput.value = '100000';
        calculateSignals();
        updateStatCards();
    }
</script>
@endpush

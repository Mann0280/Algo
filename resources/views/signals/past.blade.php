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
                    Historical intelligence performance analytics and verification.
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
        <div class="stats-card p-6 rounded-3xl">
            <p class="text-[10px] font-bold text-purple-400 orbitron uppercase tracking-widest mb-1">Total Signals</p>
            <h3 id="stat-total" class="text-3xl font-black text-white orbitron italic">--</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl">
            <p class="text-[10px] font-bold text-emerald-400 orbitron uppercase tracking-widest mb-1">Win Rate</p>
            <h3 id="stat-winrate" class="text-3xl font-black text-white orbitron italic">--</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl">
            <p class="text-[10px] font-bold text-blue-400 orbitron uppercase tracking-widest mb-1">Total Win</p>
            <h3 id="stat-wins" class="text-3xl font-black text-white orbitron italic">--</h3>
        </div>
        <div class="stats-card p-6 rounded-3xl">
            <p class="text-[10px] font-bold text-rose-400 orbitron uppercase tracking-widest mb-1">Total Loss</p>
            <h3 id="stat-loss" class="text-3xl font-black text-white orbitron italic">--</h3>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="glass-card p-6 border border-white/5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
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
    <div class="max-w-7xl mx-auto">
        <div class="glass-card border border-white/5 overflow-hidden">
            <div id="past-signals-table"></div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>
<script>
    let table;

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Initialize Tabulator
        table = new Tabulator("#past-signals-table", {
            ajaxURL: "/api/past-signals",
            ajaxConfig: "GET",
            pagination: "remote",
            paginationSize: 20,
            paginationSizeSelector: [20, 50, 100],
            layout: "fitColumns",
            responsiveLayout: "collapse",
            placeholder: "<div class='py-12 text-gray-500 orbitron text-xs uppercase tracking-widest'>Searching Neural Archive...</div>",
            
            ajaxResponse: function(url, params, response) {
                // Update stats
                if (response.stats) {
                    document.getElementById('stat-total').textContent = response.stats.total_signals;
                    document.getElementById('stat-winrate').textContent = response.stats.win_rate;
                    document.getElementById('stat-wins').textContent = response.stats.total_profit;
                    document.getElementById('stat-loss').textContent = response.stats.total_loss;
                }
                return {
                    last_page: response.last_page,
                    data: response.data
                };
            },

            columns: [
                {title: "ID", field: "id", width: 70, hozAlign: "center", headerSort: false, formatter: (cell) => `<span class="text-[10px] text-gray-600">#${cell.getValue()}</span>`},
                {title: "Symbol", field: "symbol", fontStyle: "bold", formatter: (cell) => `<span class="font-black text-white">${cell.getValue()}</span>`},
                {title: "Type", field: "type", hozAlign: "center", width: 90, formatter: function(cell) {
                    const val = cell.getValue();
                    const color = val === 'BUY' ? 'emerald' : 'rose';
                    return `<span class="px-2 py-0.5 rounded text-[9px] font-black orbitron bg-${color}-500/10 text-${color}-500 border border-${color}-500/20">${val}</span>`;
                }},
                {title: "Entry", field: "entry_price", hozAlign: "right", formatter: (cell) => `₹${parseFloat(cell.getValue()).toLocaleString()}`},
                {title: "TP", field: "tp", hozAlign: "right", formatter: (cell) => `₹${parseFloat(cell.getValue()).toLocaleString()}`},
                {title: "SL", field: "sl", hozAlign: "right", formatter: (cell) => `<span class="text-rose-400">₹${parseFloat(cell.getValue()).toLocaleString()}</span>`},
                {title: "Close", field: "close_price", hozAlign: "right", formatter: (cell) => `<span class="text-blue-400 font-bold">₹${cell.getValue() ? parseFloat(cell.getValue()).toLocaleString() : '—'}</span>`},
                {title: "Result", field: "result", hozAlign: "center", width: 110, formatter: function(cell) {
                    const val = cell.getValue();
                    if (!val) return '—';
                    let bg = 'rgba(255,255,255,0.05)';
                    let clr = '#94a3b8';
                    if (val === 'WIN') { bg = 'rgba(16, 185, 129, 0.15)'; clr = '#10b981'; }
                    if (val === 'LOSS') { bg = 'rgba(244, 63, 94, 0.15)'; clr = '#f43f5e'; }
                    if (val === 'BREAKEVEN') { bg = 'rgba(234, 179, 8, 0.15)'; clr = '#eab308'; }
                    return `<span class="px-3 py-1 rounded-full text-[10px] font-black orbitron uppercase tracking-widest" style="background:${bg}; color:${clr}; border: 1px solid ${clr}33">${val}</span>`;
                }},
                {title: "P/L", field: "pl", hozAlign: "right", width: 100, formatter: function(cell) {
                    const val = cell.getValue();
                    const rowData = cell.getData();
                    if (rowData.is_today || val === null) return `<span class="text-gray-600">--</span>`;
                    const color = val >= 0 ? 'text-emerald-400' : 'text-rose-400';
                    const prefix = val >= 0 ? '+' : '';
                    return `<span class="${color} font-black">₹${prefix}${parseFloat(val).toLocaleString()}</span>`;
                }},
                {title: "Date", field: "date", hozAlign: "right", width: 120, formatter: (cell) => `<span class="text-gray-500 font-mono text-[10px]">${cell.getValue()}</span>`}
            ],
        });
    });

    function applyFilters() {
        const params = {
            startDate: document.getElementById('filter-start').value,
            endDate: document.getElementById('filter-end').value,
            symbol: document.getElementById('filter-symbol').value,
            type: document.getElementById('filter-type').value,
        };
        table.setData("/api/past-signals", params);
    }

    function resetFilters() {
        document.getElementById('filter-start').value = '';
        document.getElementById('filter-end').value = '';
        document.getElementById('filter-symbol').value = '';
        document.getElementById('filter-type').value = '';
        table.setData("/api/past-signals");
    }
</script>
@endpush

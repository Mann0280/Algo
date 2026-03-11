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
    }
    .input-cyber:focus {
        border-color: #9333ea;
        box-shadow: 0 0 15px rgba(147, 51, 234, 0.3);
        outline: none;
    }

    /* Premium Status Badges (Match Live Tips) */
    .status-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 900;
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
        background-color: #05020c !important;
        border-bottom: 2px solid rgba(147, 51, 234, 0.3) !important;
        color: #94a3b8 !important;
        font-family: 'Orbitron', sans-serif !important;
        font-size: 10px !important;
        font-weight: 950 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.15em !important;
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
    }
    .tabulator-footer {
        background-color: transparent !important;
        border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #64748b !important;
        font-family: 'Orbitron', sans-serif !important;
        font-size: 10px !important;
    }
    .tabulator-page {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #94a3b8 !important;
        border-radius: 8px !important;
        margin: 0 4px !important;
        font-weight: bold;
    }
    .tabulator-page.active {
        background: linear-gradient(135deg, #9333ea, #6366f1) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 0 15px rgba(147, 51, 234, 0.3);
    }
    
    /* Strict Tabulator Background Override */
    div.tabulator-row {
        background-color: transparent !important;
    }
    div.tabulator-row.tabulator-row-even {
        background-color: rgba(255, 255, 255, 0.01) !important;
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
                    Premium historical telemetry database. 100% verified performance.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 group cursor-help">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] orbitron font-bold text-gray-500 uppercase tracking-widest">Archive Online</span>
                </div>
                <div class="h-px w-24 bg-gradient-to-r from-purple-500/50 to-transparent hidden lg:block"></div>
                <span class="text-[10px] orbitron font-bold text-purple-500 uppercase tracking-[0.3em]">PRO ARCHIVE</span>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-12">
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-purple-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL SIGNALS</p>
            <h3 class="text-2xl font-black text-white orbitron italic relative z-10">{{ $totalSignals ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-emerald-400 orbitron uppercase tracking-widest mb-1 relative z-10">WIN RATE</p>
            <h3 class="text-2xl font-black text-white orbitron italic relative z-10">{{ $winRate ?? '0%' }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-blue-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL WIN</p>
            <h3 class="text-2xl font-black text-white orbitron italic relative z-10">{{ $totalWin ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-rose-400 orbitron uppercase tracking-widest mb-1 relative z-10">TOTAL LOSS</p>
            <h3 class="text-2xl font-black text-white orbitron italic relative z-10">{{ $totalLoss ?? 0 }}</h3>
        </div>
        <div class="stats-card p-4 rounded-3xl relative overflow-hidden group">
            <p class="text-[10px] font-bold text-purple-400 orbitron uppercase tracking-widest mb-1 relative z-10">SIM CAPITAL</p>
            <h3 id="stat-total-capital" class="text-xl font-black text-white orbitron italic relative z-10">₹0</h3>
        </div>
        <div id="stat-pnl-card" class="stats-card p-4 rounded-3xl relative overflow-hidden group" style="border-color: {{ ($totalPnl ?? 0) >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(244,63,94,0.3)' }}">
            <p id="stat-pnl-label" class="text-[10px] font-bold orbitron uppercase tracking-widest mb-1 relative z-10" style="color: {{ ($totalPnl ?? 0) >= 0 ? '#34d399' : '#fb7185' }}">TOTAL PNL</p>
            <h3 id="stat-total-pnl-top" class="text-xl font-black orbitron italic relative z-10" style="color: {{ ($totalPnl ?? 0) >= 0 ? '#34d399' : '#fb7185' }}">
                {{ ($totalPnl ?? 0) >= 0 ? '+' : '' }}₹{{ number_format($totalPnl ?? 0, 0) }}
            </h3>
        </div>
    </div>

    <!-- Capital Backtest Simulator -->
    <div class="max-w-7xl mx-auto mb-12">
        <div class="glass-card p-8 border border-purple-500/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/5 blur-[100px] rounded-full"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="space-y-2">
                    <h2 class="orbitron text-2xl font-black text-white italic uppercase tracking-tighter">
                        Backtest <span class="text-gradient">Simulator</span>
                    </h2>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-[0.2em]">Synchronized Capital Telemetry</p>
                </div>

                <div class="flex flex-wrap items-end gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-purple-400 orbitron uppercase tracking-widest ml-1">Capital Investment (₹)</label>
                        <input type="number" id="sim-capital" placeholder="e.g. 100000" value="100000"
                               class="input-cyber w-full sm:w-64 font-bold orbitron text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button onclick="calculateSimulation()" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black orbitron text-xs uppercase italic tracking-widest rounded-xl transition-all shadow-lg hover:shadow-purple-500/40 transform hover:-translate-y-1">
                            Execute Simulation
                        </button>
                        <button onclick="resetSimulation()" class="px-5 py-3 bg-white/5 text-gray-400 font-bold orbitron text-xs uppercase tracking-widest rounded-xl transition-all border border-white/5 hover:bg-white/10">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div id="sim-result-container" class="hidden min-w-[240px] p-5 rounded-2xl bg-white/[0.03] border border-white/10 shadow-inner">
                    <p class="text-[9px] font-bold text-gray-500 orbitron uppercase tracking-widest mb-1">PROJECTION RESULT</p>
                    <div id="sim-total-pnl" class="text-2xl font-black orbitron italic">₹0.00</div>
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
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-white text-black font-black orbitron text-xs uppercase italic tracking-widest rounded-xl shadow-lg hover:bg-gray-100 transition-colors">
                        Query
                    </button>
                    <a href="{{ route('signals.past') }}" class="px-4 py-2.5 bg-white/5 text-gray-400 font-black orbitron text-xs uppercase tracking-widest rounded-xl border border-white/5 flex items-center justify-center hover:bg-white/10">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabulator Table Section -->
    <div class="max-w-7xl mx-auto px-4 md:px-0">
        <div class="flex items-center justify-between mb-4">
            <div id="data-status-badge" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/5 border border-white/10 hidden">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="data-status-text" class="text-[9px] orbitron font-bold text-gray-400 uppercase tracking-widest">Archive Engine Synced</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <label class="text-[9px] orbitron font-bold text-gray-400 uppercase tracking-widest">Rows per page</label>
                    <select id="page-size-selector" class="bg-white/5 border border-white/10 text-white text-[10px] font-bold orbitron rounded-lg px-2 py-1 outline-none focus:border-purple-500 transition-colors">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 text-[10px] orbitron text-gray-600 font-bold uppercase tracking-[0.2em] hidden md:flex">
                    <i data-lucide="info" class="w-3 h-3"></i> Use scroll for more data
                </div>
            </div>
        </div>

        <div class="glass-card border border-white/5 overflow-hidden p-0 relative shadow-2xl">
            <div class="w-full overflow-x-auto">
                <div id="signals-table" class="w-full !max-w-none"></div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script>
    window.addEventListener('load', function() {
        @php
            $tableData = $signals->map(function($s) {
                return [
                    'id' => $s->id,
                    'stock' => (string)($s->stock_name ?? '---'),
                    'entry' => (float)($s->entry ?? 0),
                    'target' => (float)($s->target ?? 0),
                    'sl' => (float)($s->sl ?? 0),
                    'breakeven' => (float)($s->breakeven ?? 0),
                    'date' => (string)($s->entry_date ?? '---'),
                    'time' => (string)($s->entry_time ?? '---'),
                    'qty' => 0,
                    'pnl' => (float)($s->pnl ?? 0),
                    'sim_pnl' => (float)($s->pnl ?? 0)
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
                layout: "fitColumns",
                pagination: true,
                paginationSize: 25,
                paginationSizeSelector: false,
                placeholder: "<div class='orbitron text-gray-600 py-32 text-[10px] tracking-[0.4em]'>NO ARCHIVED TELEMETRY FOUND</div>",
                resizableColumns: true,
                columnHeaderVertAlign: "bottom",
                columns: [
                    {title: "Stock", field: "stock", hozAlign: "left", formatter: function(cell){
                        return "<span style='font-weight:bold; color:white;'>" + cell.getValue() + "</span>";
                    }},
                    {title: "Entry", field: "entry", hozAlign: "right"},
                    {title: "Target", field: "target", hozAlign: "right", formatter: function(cell){
                        return "<span style='color:#10b981'>" + cell.getValue() + "</span>";
                    }},
                    {title: "Stop Loss", field: "sl", hozAlign: "right", formatter: function(cell){
                        return "<span style='color:#ef4444'>" + cell.getValue() + "</span>";
                    }},
                    {title: "Breakeven", field: "breakeven", hozAlign: "right", formatter: function(cell){
                        return "<span style='color:#3b82f6'>" + cell.getValue() + "</span>";
                    }},
                    {title: "Date", field: "date", hozAlign: "right"},
                    {title: "Time", field: "time", hozAlign: "right"},
                    {title: "Quantity", field: "qty", hozAlign: "right", formatter: function(cell){
                        return cell.getValue() > 0 ? cell.getValue() : '---';
                    }},
                    {title: "PNL", field: "sim_pnl", hozAlign: "right", formatter: function(cell){
                        let value = cell.getValue();
                        if(value > 0){
                            return "<span style='color:#10b981'>+" + value + "</span>";
                        } else if(value < 0){
                            return "<span style='color:#ef4444'>" + value + "</span>";
                        } else {
                            return value;
                        }
                    }}
                ],
            });

            // Bind Custom Page Size Selector
            document.getElementById("page-size-selector").addEventListener("change", function() {
                window.signalsTable.setPageSize(this.value);
            });

            // Initial simulation check
            setTimeout(() => {
                if (document.getElementById('sim-capital').value) calculateSimulation();
            }, 500);

        } catch (err) {
            console.error("Initialization Failure:", err);
            document.getElementById('signals-table').innerHTML = `<div class='p-10 text-rose-500 orbitron text-[10px]'>SYSTEM OVERLOAD: ${err.message}</div>`;
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
    });

    function calculateSimulation() {
        if(!window.signalsTable) return;
        const capitalInput = document.getElementById('sim-capital');
        const capital = parseFloat(capitalInput.value);
        if (isNaN(capital) || capital <= 0) return;

        const tradingCapital = capital * 5;
        let totalNetPnl = 0;

        const updatedData = window.signalsTable.getData().map(row => {
            if (row.entry > 0) {
                const qty = Math.floor(tradingCapital / row.entry);
                const simPnl = qty * row.pnl;
                totalNetPnl += simPnl;
                return { ...row, qty: qty, sim_pnl: simPnl };
            }
            return row;
        });

        window.signalsTable.updateData(updatedData);

        const summaryVal = document.getElementById('sim-total-pnl');
        summaryVal.textContent = (totalNetPnl >= 0 ? '+' : '-') + `₹${Math.abs(totalNetPnl).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        summaryVal.className = `text-2xl font-black orbitron italic ${totalNetPnl >= 0 ? 'text-emerald-400' : 'text-rose-400'}`;
        document.getElementById('sim-result-container').classList.remove('hidden');
        document.getElementById('stat-total-capital').textContent = `₹${(tradingCapital/1000).toFixed(0)}K`;
        
        const topPnl = document.getElementById('stat-total-pnl-top');
        if (topPnl) {
            const pnlColor = totalNetPnl >= 0 ? '#34d399' : '#fb7185';
            topPnl.textContent = (totalNetPnl >= 0 ? '+' : '') + `₹${Math.abs(totalNetPnl).toLocaleString(undefined, {maximumFractionDigits: 0})}`;
            topPnl.style.color = pnlColor;
            document.getElementById('stat-pnl-card').style.borderColor = totalNetPnl >= 0 ? 'rgba(16,185,129,0.4)' : 'rgba(244,63,94,0.4)';
            document.getElementById('stat-pnl-label').style.color = pnlColor;
        }
    }

    function resetSimulation() {
        if(!window.signalsTable) return;
        document.getElementById('sim-result-container').classList.add('hidden');
        document.getElementById('sim-capital').value = '';
        document.getElementById('stat-total-capital').textContent = '₹0';
        window.signalsTable.updateData(window.signalsTable.getData().map(row => ({ ...row, qty: 0, sim_pnl: row.pnl })));
        
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

@extends('layouts.admin')

@section('title', 'Signal History')

@section('content')
<div class="space-y-10 max-w-[1600px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">PREDICTION MANAGEMENT</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                SIGNAL <span class="text-purple-500 text-glow">RECORDS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Manage and view historical trading signals</p>
        </div>
    </div>

    @push('styles')
    <style>
        .input-cyber {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(147, 51, 234, 0.2);
            color: white;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            color-scheme: dark;
            font-size: 11px;
            font-weight: 700;
        }
        .input-cyber:focus {
            border-color: #9333ea;
            box-shadow: 0 0 15px rgba(147, 51, 234, 0.3);
            outline: none;
        }
        select.input-cyber {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
        }
        .page-size-selector {
            background: #000000;
            border: 1px solid rgba(147, 51, 234, 0.2);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 4px 28px 4px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239333ea'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 0.75rem;
        }
        .page-size-selector:focus {
            border-color: #9333ea;
            box-shadow: 0 0 10px rgba(147, 51, 234, 0.3);
            outline: none;
        }
    </style>
    @endpush

    <!-- Filter Panel -->
    <div class="mb-10">
        <form action="{{ route('admin.predictions.index') }}" method="GET" class="glass-panel p-8 border-purple-500/10 rounded-3xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6">
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
                        <option value="">ALL SIGNAL TYPES</option>
                        <option value="BUY" {{ request('signal_type') == 'BUY' ? 'selected' : '' }}>BUY</option>
                        <option value="SELL" {{ request('signal_type') == 'SELL' ? 'selected' : '' }}>SELL</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest ml-1">Signal Result</label>
                    <select name="result" class="input-cyber w-full">
                        <option value="">SHOW ALL</option>
                        <option value="WIN" {{ request('result') == 'WIN' ? 'selected' : '' }}>WIN</option>
                        <option value="LOSS" {{ request('result') == 'LOSS' ? 'selected' : '' }}>LOSS</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-3 bg-[#9333ea] text-white font-semibold font-whiskey text-[10px] uppercase italic tracking-widest rounded-xl shadow-lg hover:shadow-purple-500/40 transition-all">
                        FILTER RECORDS
                    </button>
                    <a href="{{ route('admin.predictions.index') }}" class="px-4 py-3 bg-white/5 text-gray-400 font-black font-whiskey text-[10px] uppercase tracking-widest rounded-xl border border-white/5 flex items-center justify-center hover:bg-white/10">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Signals Table Section Controls -->
    <div class="flex items-center justify-between mb-6 px-1">
        <div id="data-status-badge" class="flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/5 border border-purple-500/10">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 shadow-[0_0_8px_#9333ea]"></span>
            <span class="text-[9px] font-whiskey font-semibold text-purple-400 uppercase tracking-widest">{{ $predictions->count() }} RECORDS FOUND</span>
        </div>
        
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Rows per page</label>
                <select id="admin-page-size" class="page-size-selector">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/5 border border-white/5 text-[9px] font-bold text-gray-500 uppercase tracking-widest">
                <i data-lucide="info" class="w-3 h-3 text-purple-500"></i>
                Use scroll for more data
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <div id="admin-predictions-table" class="whiskey-table"></div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script>
    window.addEventListener('load', function() {
        @php
            $tableData = $predictions->map(function($s) {
                return [
                    'id' => $s->id,
                    'stock' => (string)($s->stock_name ?? '---'),
                    'type' => (string)($s->signal_type ?? '---'),
                    'entry' => (float)($s->entry ?? 0),
                    'target' => (float)($s->target ?? 0),
                    'sl' => (float)($s->sl ?? 0),
                    'breakeven' => (float)($s->breakeven ?? 0),
                    'date' => (string)($s->entry_date ?? '---'),
                    'time' => (string)($s->entry_time ?? '---'),
                    'result' => (string)($s->result ?? '---'),
                    'pnl' => (float)($s->pnl ?? 0),
                    'destroy_route' => route('admin.predictions.destroy', $s->id)
                ];
            });
        @endphp

        const rawData = @json($tableData);

        try {
            window.adminTable = new Tabulator("#admin-predictions-table", {
                data: rawData,
                layout: "fitColumns",
                responsiveLayout: false,
                pagination: true,
                paginationSize: 20,
                placeholder: "<div class='font-whiskey text-gray-600 py-32 text-[10px] tracking-widest uppercase'>NO SIGNALS FOUND</div>",
                columns: [
                    {title: "Stock", field: "stock", hozAlign: "left", minWidth: 200, formatter: function(cell){
                        let data = cell.getData();
                        return `<div class="flex flex-col py-2">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                        <span class="text-white font-bold text-[12px] uppercase tracking-tight">${cell.getValue()}</span>
                                    </div>
                                    <span class="text-[9px] text-gray-500 font-semibold uppercase tracking-widest italic">${data.time}</span>
                                </div>`;
                    }},
                    {title: "Type", field: "type", hozAlign: "center", minWidth: 100, formatter: function(cell){
                        let val = cell.getValue().toUpperCase();
                        let isBuy = val === 'BUY';
                        let color = isBuy ? '#10b981' : '#ef4444';
                        return `<div class="flex flex-col items-center">
                                    <span style="color:${color}; font-weight:900; font-size:11px; letter-spacing:0.1em;">${val}</span>
                                    <div class="w-6 h-[1px] mt-1" style="background:${color}; opacity:0.2;"></div>
                                </div>`;
                    }},
                    {title: "Entry / Target", field: "entry", hozAlign: "left", minWidth: 180, formatter: function(cell){
                        let data = cell.getData();
                        return `<div class="space-y-1 py-1">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[9px] font-bold text-gray-500 uppercase">ENTRY</span>
                                        <span class="text-white font-bold text-[11px]">₹${data.entry.toLocaleString()}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[9px] font-bold text-emerald-500/50 uppercase">TARGET</span>
                                        <span class="text-white font-bold text-[11px]">₹${data.target.toLocaleString()}</span>
                                    </div>
                                </div>`;
                    }},
                    {title: "Safety (SL / BE)", field: "sl", hozAlign: "left", minWidth: 180, formatter: function(cell){
                        let data = cell.getData();
                        return `<div class="space-y-1 py-1">
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[9px] font-bold text-rose-500/50 uppercase">SL</span>
                                        <span class="text-white font-bold text-[11px]">₹${data.sl.toLocaleString()}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <span class="text-[9px] font-bold text-blue-500/50 uppercase">BE</span>
                                        <span class="text-white font-bold text-[11px]">₹${data.breakeven.toLocaleString()}</span>
                                    </div>
                                </div>`;
                    }},
                    {title: "Final Status", field: "result", hozAlign: "center", minWidth: 120, formatter: function(cell){
                        let pnl = cell.getData().pnl;
                        let val = '';
                        
                        if (pnl > 0) val = 'WIN';
                        else if (pnl < 0) val = 'LOSS';
                        else {
                            let dbVal = (cell.getValue() || '').toUpperCase();
                            val = (dbVal && dbVal !== '---') ? dbVal : 'LIVE';
                        }
                        
                        let cls = val === 'WIN' ? 'status-win' : (val === 'LOSS' ? 'status-loss' : 'status-live');
                        return `<span class="status-badge ${cls}">${val}</span>`;
                    }},
                    {title: "Profit/Loss", field: "pnl", hozAlign: "right", minWidth: 130, formatter: function(cell){
                        let value = cell.getValue();
                        let isPositive = value > 0;
                        let isNegative = value < 0;
                        let color = isPositive ? '#10b981' : (isNegative ? '#ef4444' : '#64748b');
                        let sign = isPositive ? '+' : '';
                        return `<span class="font-whiskey text-[12px] font-semibold" style="color:${color};">${sign}₹${Math.abs(value).toLocaleString()}</span>`;
                    }},
                    {title: "Time", field: "date", hozAlign: "center", minWidth: 140, formatter: function(cell){
                        return `<div class="flex flex-col items-center">
                                    <span class="text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest">${cell.getValue()}</span>
                                    <div class="w-4 h-[1px] bg-white/10 mt-1"></div>
                                </div>`;
                    }},
                    {title: "Actions", field: "id", hozAlign: "right", headerHozAlign: "right", minWidth: 100, formatter: function(cell){
                        let data = cell.getData();
                        return `<div class="flex justify-end gap-3 py-1">
                                    <form action="${data.destroy_route}" method="POST" onsubmit="return confirm('Permanently delete this signal?')" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-2xl bg-rose-500/5 border border-rose-500/10 text-rose-500/60 hover:text-rose-500 hover:bg-rose-500/20 hover:border-rose-500/40 transition-all shadow-lg shadow-rose-900/10">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>`;
                    }, cellClick: function(e, cell){ e.stopPropagation(); }}
                ],
                renderComplete: function() {
                    if (typeof initIcons !== 'undefined') initIcons();
                }
            });

            // Bind Page Size Selector
            document.getElementById("admin-page-size").addEventListener("change", function() {
                window.adminTable.setPageSize(parseInt(this.value));
            });
        } catch (err) {
            console.error("Admin Table Failure:", err);
            document.getElementById('admin-predictions-table').innerHTML = `<div class='p-10 text-rose-500 font-whiskey text-[10px] uppercase'>NEURAL LINK ERROR: ${err.message}</div>`;
        }
    });
</script>
@endpush
@endsection

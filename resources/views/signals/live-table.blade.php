{{-- ═══════════════════════════════════════════
    PREMIUM USER — Full live signals table
    Standard HTML Table with 5-second auto-refresh
    ═══════════════════════════════════════════ --}}

<style>
    .cyber-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 4px;
        color: #e5e7eb;
    }
    .cyber-table thead th {
        padding: 12px 16px;
        font-[Orbitron] font-black uppercase text-[10px] text-gray-500 tracking-[0.2em] border-b border-white/[0.05];
        text-align: left;
    }
    .cyber-table tbody tr {
        background: rgba(255, 255, 255, 0.02);
        transition: all 0.3s ease;
    }
    .cyber-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }
    .cyber-table td {
        padding: 16px;
        font-size: 13px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .cyber-table td:first-child {
        border-left: 1px solid rgba(255, 255, 255, 0.05);
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .cyber-table td:last-child {
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .ai-row {
        background: transparent !important;
    }
    .ai-row td {
        padding: 4px 16px 12px 16px !important;
        border: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
</style>

<div class="mt-4 space-y-5">

    {{-- Status Bar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-1">
        <div class="flex items-center gap-3">
            <span class="live-dot"></span>
            <span class="text-[10px] font-bold orbitron text-emerald-400 uppercase tracking-[0.2em]">Live Feed Active</span>
            <span class="text-gray-600 text-xs">•</span>
            <span id="last-update" class="text-[10px] text-gray-600 font-mono">--:--:--</span>
        </div>
        <div class="flex items-center gap-3">
            <span id="signal-count" class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest">0 signals</span>
            <button onclick="refreshData()" class="p-2 rounded-lg bg-white/[0.03] border border-white/[0.05] text-gray-500 hover:text-purple-400 hover:border-purple-500/20 transition-all" title="Refresh now">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            </button>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="overflow-x-auto no-scrollbar">
        <table class="cyber-table">
            <thead>
                <tr>
                    <th style="width: 15%">Stock</th>
                    <th style="width: 10%; text-align: center;">Signal</th>
                    <th style="width: 10%; text-align: right;">Entry</th>
                    <th style="width: 10%; text-align: right;">Stop Loss</th>
                    <th style="width: 10%; text-align: right;">Target 1</th>
                    <th style="width: 10%; text-align: right;">Target 2</th>
                    <th style="width: 15%; text-align: center;">Date</th>
                    <th style="width: 10%; text-align: center;">Time</th>
                </tr>
            </thead>
            <tbody id="signals-tbody">
                {{-- Dynamic Content --}}
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    let refreshInterval;

    function renderTable(data) {
        const tbody = document.getElementById('signals-tbody');
        tbody.innerHTML = '';

        data.forEach(item => {
            const isBuy = (item.signal_type || '').toUpperCase() === 'BUY';
            const signalColor = isBuy ? '#34d399' : '#f87171';
            const signalBg = isBuy ? 'rgba(16,185,129,0.08)' : 'rgba(239,68,68,0.08)';
            const signalBdr = isBuy ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)';

            const status = (item.status || 'LIVE').toUpperCase().replace(/\s+/g, '_');
            const statusMap = {
                'LIVE': { bg: 'rgba(59,130,246,0.08)', clr: '#60a5fa', bdr: 'rgba(59,130,246,0.15)' },
                'RUNNING': { bg: 'rgba(16,185,129,0.08)', clr: '#34d399', bdr: 'rgba(16,185,129,0.15)' },
                'HIT_TARGET': { bg: 'rgba(234,179,8,0.08)', clr: '#fbbf24', bdr: 'rgba(234,179,8,0.15)' },
                'SL_HIT': { bg: 'rgba(239,68,68,0.08)', clr: '#f87171', bdr: 'rgba(239,68,68,0.15)' },
            };
            const s = statusMap[status] || statusMap['LIVE'];

            const pl = item.profit || '0%';
            const plPositive = !pl.startsWith('-');
            const plColor = plPositive ? '#34d399' : '#f87171';
            const plPrefix = plPositive && !pl.startsWith('+') ? '+' : '';

            const confidence = parseInt(item.confidence || 0);
            const confidenceColor = confidence >= 85 ? '#a78bfa' : confidence >= 70 ? '#60a5fa' : '#6b7280';

            // MAIN ROW
            const mainRow = document.createElement('tr');
            mainRow.innerHTML = `
                <td><span style="font-weight:800;color:#f1f5f9;font-size:13px;text-transform:uppercase;">${item.stock_symbol || '—'}</span></td>
                <td style="text-align: center;">
                    <span style="display:inline-block;padding:4px 14px;border-radius:8px;font-family:Orbitron,monospace;font-size:9px;font-weight:900;background:${signalBg};color:${signalColor};border:1px solid ${signalBdr};">${(item.signal_type || '').toUpperCase()}</span>
                </td>
                <td style="text-align: right; color:#d1d5db; font-weight:600;">₹${parseFloat(item.entry_price || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#f87171; font-weight:600;">₹${parseFloat(item.stop_loss || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#34d399; font-weight:600;">₹${parseFloat(item.target_price || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#34d399; font-weight:600;">${item.target_2 ? '₹' + parseFloat(item.target_2).toFixed(2) : '—'}</td>
                <td style="text-align: center; color:#94a3b8; font-size:11px; font-family:monospace;">${item.date || '—'}</td>
                <td style="text-align: center; color:#6b7280; font-size:11px; font-family:monospace;">${item.time || '—'}</td>
            `;

            tbody.appendChild(mainRow);
        });
    }

    async function refreshData() {
        try {
            const res = await fetch('/api/live-signals', {
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]*)/)?.[1] || ''),
                },
                credentials: 'same-origin',
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const json = await res.json();
            if (json.success && json.data) {
                renderTable(json.data);
                document.getElementById('signal-count').textContent = `${json.count || json.data.length} signals`;
                document.getElementById('last-update').textContent = new Date().toLocaleTimeString('en-IN', { hour12: false });
            }
        } catch (err) {
            console.warn('Signal refresh failed:', err);
        }
    }

    window.refreshData = refreshData;

    refreshData();
    refreshInterval = setInterval(refreshData, 5000);

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(refreshInterval);
        } else {
            refreshData();
            refreshInterval = setInterval(refreshData, 5000);
        }
    });
});
</script>
@endpush


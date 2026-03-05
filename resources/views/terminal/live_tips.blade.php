@extends('layouts.app')

@section('title', 'Live BreakEven Tips | AlgoTrade AI')

@push('styles')
<style>
    .status-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }
    
    .status-live { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .status-running { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .status-hit_target { background: rgba(234, 179, 8, 0.1); color: #fbbf24; border: 1px solid rgba(234, 179, 8, 0.3); }
    .status-sl_hit { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

    .glow-badge::after {
        content: '';
        position: absolute;
        inset: -2px;
        background: inherit;
        filter: blur(8px);
        opacity: 0.4;
        z-index: -1;
    }

    .new-row-animation {
        animation: highlightRow 2s ease-out;
    }

    @keyframes highlightRow {
        0% { background: rgba(139, 92, 246, 0.2); }
        100% { background: transparent; }
    }

    .price-flash-up { animation: flashGreen 1s ease-out; }
    .price-flash-down { animation: flashRed 1s ease-out; }

    @keyframes flashGreen {
        0% { color: #10b981; text-shadow: 0 0 10px #10b981; }
        100% { color: inherit; text-shadow: none; }
    }

    @keyframes flashRed {
        0% { color: #ef4444; text-shadow: 0 0 10px #ef4444; }
        100% { color: inherit; text-shadow: none; }
    }
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-6 pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-bold orbitron uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    LIVE TELEMETRY ACTIVE
                </span>
                <span id="refresh-counter" class="text-[9px] font-bold text-slate-500 orbitron uppercase tracking-widest">REFRESHING IN 5s</span>
                <span id="last-sync-time" class="text-[9px] font-bold text-slate-600 orbitron uppercase tracking-widest ml-4 opacity-70">LAST SYNC: INITIALIZING...</span>
            </div>
            <h1 class="orbitron text-4xl font-black italic tracking-tighter uppercase" style="color: var(--text-white)">
                BreakEven <span class="text-purple-500">Live Tips</span>
            </h1>
            <div class="flex flex-wrap items-center gap-6 mt-4">
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest">Breakevenpoint :</span>
                    <span id="display-breakeven" class="text-sm font-black text-purple-400 orbitron tracking-tighter">{{ $settings['breakeven_point'] ?? '2500.00' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest">Date:</span>
                    <span id="display-date" class="text-sm font-black orbitron tracking-tighter" style="color: var(--text-white)">{{ \Carbon\Carbon::parse($settings['breakeven_date'] ?? now())->format('d M, Y') }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="glass-panel px-6 py-3 rounded-2xl border border-white/5 flex items-center gap-4">
                <div class="text-right">
                    <div class="text-[9px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Active Signals</div>
                    <div id="total-active" class="text-xl font-black orbitron tracking-tighter" style="color: var(--text-white)">00</div>
                </div>
                <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-400">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
            </div>
            <button onclick="fetchLiveTips()" class="w-12 h-12 glass-panel rounded-xl border border-white/5 flex items-center justify-center text-slate-400 hover:text-white transition-all group">
                <i data-lucide="refresh-cw" class="w-5 h-5 group-active:rotate-180 transition-transform"></i>
            </button>
        </div>
    </div>

    <!-- Tips Table -->
    <div class="glass-panel rounded-[2.5rem] border border-white/5 overflow-hidden relative shadow-2xl">
        <div id="table-loader" class="absolute inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity text-white">
            <div class="flex flex-col items-center gap-4">
                <div class="w-10 h-10 border-4 border-purple-500/20 border-t-purple-500 rounded-full animate-spin"></div>
                <span class="text-[10px] font-bold orbitron text-purple-400 tracking-widest uppercase">Syncing...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="text-[10px] orbitron font-bold text-slate-500 uppercase tracking-widest" style="background: var(--nav-hover-bg)">
                    <tr>
                        <th class="px-8 py-6 border-b border-white/5">#</th>
                        <th class="px-8 py-6 border-b border-white/5">Stock Name</th>
                        <th class="px-8 py-6 border-b border-white/5">Entry Price</th>
                        <th class="px-8 py-6 border-b border-white/5">Stop Loss</th>
                        <th class="px-8 py-6 border-b border-white/5 px-8">Target Price</th>
                        <th class="px-8 py-6 border-b border-white/5">Signal Status</th>
                        <th class="px-8 py-6 border-b border-white/5 text-right">Last Updated</th>
                    </tr>
                </thead>
                <tbody id="tips-table-body" class="divide-y divide-white/5">
                    <!-- Data will be injected here via JS -->
                </tbody>
            </table>
        </div>
        
        <div id="empty-state" class="p-20 text-center hidden">
            <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-600">
                <i data-lucide="alert-circle" class="w-10 h-10"></i>
            </div>
            <h3 class="orbitron font-bold text-xl mb-2 uppercase" style="color: var(--text-white)">No Signals Detected</h3>
            <p class="text-slate-500 text-sm max-w-xs mx-auto italic">Our neural pathways are currently scanning the market. Stay synchronized for new breakouts.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let nextSync = 5;
    let syncInProgress = false;
    let existingTipIds = new Set();
    let previousPrices = {}; // Store prices to detect changes
    let prevBreakeven = null; // Store breakeven to detect changes

    async function syncNeuralTelemetry() {
        if (syncInProgress) return;
        syncInProgress = true;

        const body = document.getElementById('tips-table-body');
        const emptyState = document.getElementById('empty-state');
        const totalActiveEl = document.getElementById('total-active');
        const lastSyncEl = document.getElementById('last-sync-time');
        const loader = document.getElementById('table-loader');
        
        const breakevenEl = document.getElementById('display-breakeven');
        const dateEl = document.getElementById('display-date');

        try {
            console.log("[%cSYNC%c] Contacting Neural Engine...", "color: #9333ea; font-weight: bold", "");
            
            const response = await fetch(`/api/live-tips?nocache=${new Date().getTime()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error(`Neural Network Error: ${response.status}`);
            
            const result = await response.json();

            if (result.success) {
                const tips = result.data;
                const now = new Date();
                
                if (lastSyncEl) lastSyncEl.innerText = `LAST SYNC: ${now.toLocaleTimeString([], { hour12: true })}`;
                if (totalActiveEl) totalActiveEl.innerText = tips.length.toString().padStart(2, '0');

                if (result.settings) {
                    if (breakevenEl) {
                        const newBe = result.settings.breakeven_point;
                        if (prevBreakeven !== null && prevBreakeven !== newBe) {
                            const flashClass = parseFloat(newBe) > parseFloat(prevBreakeven) ? 'price-flash-up' : 'price-flash-down';
                            breakevenEl.classList.remove('price-flash-up', 'price-flash-down');
                            void breakevenEl.offsetWidth; // Trigger reflow
                            breakevenEl.classList.add(flashClass);
                        }
                        breakevenEl.innerText = newBe;
                        prevBreakeven = newBe;
                    }
                    if (dateEl) {
                        const d = new Date(result.settings.breakeven_date);
                        dateEl.innerText = d.toLocaleDateString([], { day: '2-digit', month: 'short', year: 'numeric' });
                    }
                }

                if (tips.length === 0) {
                    if (body) body.innerHTML = '';
                    if (emptyState) emptyState.classList.remove('hidden');
                } else {
                    if (emptyState) emptyState.classList.add('hidden');
                    
                    let rowsHtml = '';
                    tips.forEach((tip, index) => {
                        const isNew = !existingTipIds.has(tip.id);
                        if (isNew) existingTipIds.add(tip.id);

                        // Price change detection
                        const prevPrice = previousPrices[tip.id] || tip.entry_price;
                        const priceClass = tip.entry_price > prevPrice ? 'price-flash-up' : (tip.entry_price < prevPrice ? 'price-flash-down' : '');
                        previousPrices[tip.id] = tip.entry_price;

                        const statusClass = `status-${tip.status.toLowerCase().replace(' ', '_')}`;
                        const statusLabel = tip.status;
                        const isHit = tip.status === 'HIT TARGET' || tip.status === 'SL HIT';
                        const hitClass = tip.status === 'HIT TARGET' ? 'bg-emerald-500/5' : (tip.status === 'SL HIT' ? 'bg-rose-500/5' : '');

                        rowsHtml += `
                            <tr class="group hover:bg-[var(--nav-hover-bg)] transition-colors ${isHit ? hitClass : ''} ${isNew ? 'new-row-animation' : ''}">
                                <td class="px-8 py-6 font-bold orbitron text-slate-500 text-xs">${index + 1}</td>
                                <td class="px-8 py-6">
                                    <div class="font-black orbitron text-sm tracking-tight uppercase" style="color: var(--text-white)">${tip.stock_name}</div>
                                </td>
                                <td class="px-8 py-6 font-mono text-sm ${priceClass}" style="color: var(--text-muted)">₹${parseFloat(tip.entry_price).toLocaleString()}</td>
                                <td class="px-8 py-6 font-mono text-xs text-rose-500/70 italic">₹${parseFloat(tip.stop_loss).toLocaleString()}</td>
                                <td class="px-8 py-6 font-mono text-sm text-emerald-400 font-bold">₹${parseFloat(tip.target_price).toLocaleString()}</td>
                                <td class="px-8 py-6">
                                    <span class="status-badge glow-badge orbitron ${statusClass}">${statusLabel}</span>
                                </td>
                                <td class="px-8 py-6 text-right font-mono text-[10px] text-slate-500">
                                    ${new Date(tip.updated_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}
                                </td>
                            </tr>
                        `;
                    });
                    
                    if (body) {
                        body.innerHTML = rowsHtml;
                        if (window.lucide) lucide.createIcons();
                    }
                }
                console.log("[%cSUCCESS%c] Neural Path Re-Synchronized", "color: #10b981; font-weight: bold", "");
            }
        } catch (error) {
            console.error('[DATABASE SYNC ERROR]', error);
            if (lastSyncEl) lastSyncEl.innerHTML = `<span class="text-rose-500">SYNC FAILED: RETRYING...</span>`;
        } finally {
            syncInProgress = false;
        }
    }

    function runCountdown() {
        const timerEl = document.getElementById('refresh-counter');
        if (nextSync <= 0) {
            nextSync = 5;
            syncNeuralTelemetry();
        }
        if (timerEl) timerEl.innerText = `REFRESHING IN ${nextSync}s`;
        nextSync--;
    }

    document.addEventListener('DOMContentLoaded', () => {
        syncNeuralTelemetry();
        setInterval(runCountdown, 1000);
    });
</script>
@endpush


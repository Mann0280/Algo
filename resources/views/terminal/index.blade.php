@extends('layouts.dashboard')

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
<div class="space-y-12">
    <!-- Notification Panel Overlay -->
    <div id="notif-panel" class="notification-panel p-8" style="background: var(--nav-sticky-bg)">
        <div class="flex justify-between items-center mb-10">
            <h2 class="orbitron font-bold text-xl uppercase" style="color: var(--text-white)">NOTIFICATIONS</h2>
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
    <div class="flex-grow">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="orbitron text-2xl font-bold uppercase italic tracking-tighter" style="color: var(--text-white)">TERMINAL <span class="text-purple-500">ACCESS</span></h1>
                <p class="text-[var(--text-muted)] text-sm">Welcome back, {{ $user->username }}. AI Engine is active.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <button onclick="toggleNotif()" class="glass-panel p-3 rounded-2xl relative text-gray-400 hover:text-white transition-all">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    <span class="absolute top-2 right-2 w-3 h-3 bg-red-500 border-2 border-black rounded-full"></span>
                </button>
                <div class="glass-panel px-6 py-3 rounded-2xl flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-[10px] uppercase font-bold" style="color: var(--text-muted)">Account Status</div>
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
                <div class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Breakeven Point</div>
                <div id="display-breakeven" class="text-2xl font-bold text-purple-400 orbitron">{{ $settings['breakeven_point'] ?? '2500.00' }}</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Session Date</div>
                <div id="display-date" class="text-2xl font-bold orbitron tracking-tighter" style="color: var(--text-white)">{{ \Carbon\Carbon::parse($settings['breakeven_date'] ?? now())->format('d M, Y') }}</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Active Signals</div>
                <div id="total-active" class="text-2xl font-bold text-emerald-400 orbitron">00</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5">
                <div class="text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Sync Status</div>
                <div id="refresh-counter" class="text-xs font-bold text-purple-400 orbitron">SYNCING...</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Active Signals Table -->
            <div class="lg:col-span-2 reveal-section">
                <div class="glass-panel rounded-3xl overflow-hidden border border-white/5">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/5">
                        <h2 class="orbitron text-sm font-bold tracking-widest uppercase italic" style="color: var(--text-white)">AI MONITORING TERMINAL</h2>
                        <span class="text-[9px] bg-red-500/10 text-red-500 border border-red-500/20 px-2 py-1 rounded font-black orbitron animate-pulse">LIVE DATA</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="text-slate-500 text-[10px] uppercase font-bold bg-white/5 orbitron">
                                <tr>
                                    <th class="px-6 py-4 border-b border-white/5">#</th>
                                    <th class="px-6 py-4 border-b border-white/5">STOCK NAME</th>
                                    <th class="px-6 py-4 border-b border-white/5">ENTRY PRICE</th>
                                    <th class="px-6 py-4 border-b border-white/5">STOP LOSS</th>
                                    <th class="px-6 py-4 border-b border-white/5">TARGET PRICE</th>
                                    <th class="px-6 py-4 border-b border-white/5">SIGNAL STATUS</th>
                                    <th class="px-6 py-4 border-b border-white/5 text-right">LAST UPDATED</th>
                                </tr>
                            </thead>
                            <tbody id="tips-table-body" class="divide-y divide-white/5">
                                <!-- Data will be injected here via JS -->
                            </tbody>
                        </table>
                        <div id="empty-state" class="p-10 text-center hidden">
                            <p class="text-slate-500 text-xs orbitron uppercase">No active signals detected.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8 reveal-section">
                <div class="glass-panel rounded-3xl p-6 border border-white/5">
                    <h2 class="orbitron text-sm font-bold mb-6 flex justify-between uppercase italic tracking-widest" style="color: var(--text-white)">
                        WATCHLIST
                        <span class="text-purple-500 cursor-pointer">+</span>
                    </h2>
                    <div class="space-y-4">
                        @if ($watchlist->isEmpty())
                            @php 
                                $placeholders = [['s'=>'RELIANCE', 'p'=>'2,854.20', 'c'=>'+1.45%'], ['s'=>'HDFC BANK', 'p'=>'1,620.00', 'c'=>'-0.8%']];
                            @endphp
                            @foreach($placeholders as $p)
                             <div class="flex justify-between items-center p-3 rounded-xl hover:bg-white/5 transition-all">
                                <div><div class="font-bold text-sm" style="color: var(--text-white)">{{ $p['s'] }}</div><div class="text-[10px] text-gray-500 uppercase font-black orbitron">SIGNAL ACTIVE</div></div>
                                <div class="text-right"><div class="text-sm font-mono" style="color: var(--text-white)">{{ $p['p'] }}</div><div class="text-[10px] font-bold {{ strpos($p['c'], '+') !== false ? 'text-emerald-400' : 'text-rose-400' }}">{{ $p['c'] }}</div></div>
                            </div>
                            @endforeach
                        @else
                            @foreach($watchlist as $item)
                            <div class="flex justify-between items-center p-3 rounded-xl hover:bg-white/5 transition-all">
                                <div class="font-bold text-sm" style="color: var(--text-white)">{{ $item->stock_symbol }}</div>
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
<style>
    .status-badge { padding: 4px 12px; border-radius: 8px; font-size: 8px; font-weight: 900; letter-spacing: 0.1em; text-transform: uppercase; position: relative; }
    .status-live { background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
    .status-running { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .status-hit_target { background: rgba(234, 179, 8, 0.1); color: #fbbf24; border: 1px solid rgba(234, 179, 8, 0.3); }
    .status-sl_hit { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
</style>
<script>
    gsap.from(".reveal-section", { duration: 1, y: 30, opacity: 0, stagger: 0.1, ease: "power3.out" });
    function toggleNotif() { document.getElementById('notif-panel').classList.toggle('active'); }

    let nextSync = 5;
    let syncInProgress = false;
    let existingTipIds = new Set();

    async function syncNeuralTelemetry() {
        if (syncInProgress) return;
        syncInProgress = true;

        const body = document.getElementById('tips-table-body');
        const emptyState = document.getElementById('empty-state');
        const totalActiveEl = document.getElementById('total-active');
        const breakevenEl = document.getElementById('display-breakeven');
        const dateEl = document.getElementById('display-date');

        try {
            const response = await fetch(`/api/live-tips?nocache=${new Date().getTime()}`);
            if (!response.ok) throw new Error(`Sync Error: ${response.status}`);
            const result = await response.json();

            if (result.success) {
                const tips = result.data;
                if (totalActiveEl) totalActiveEl.innerText = tips.length.toString().padStart(2, '0');

                if (result.settings) {
                    if (breakevenEl) breakevenEl.innerText = result.settings.breakeven_point;
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
                        const statusClass = `status-${tip.status.toLowerCase().replace(' ', '_')}`;
                        rowsHtml += `
                            <tr class="group hover:bg-[var(--nav-hover-bg)] transition-colors">
                                <td class="px-6 py-4 font-bold orbitron text-slate-500 text-[10px]">${index + 1}</td>
                                <td class="px-6 py-4 font-black orbitron text-xs uppercase" style="color: var(--text-white)">${tip.stock_name}</td>
                                <td class="px-6 py-4 font-mono text-xs" style="color: var(--text-muted)">₹${parseFloat(tip.entry_price).toLocaleString()}</td>
                                <td class="px-6 py-4 font-mono text-[10px] text-rose-500/70">₹${parseFloat(tip.stop_loss).toLocaleString()}</td>
                                <td class="px-6 py-4 font-mono text-xs text-emerald-400">₹${parseFloat(tip.target_price).toLocaleString()}</td>
                                <td class="px-6 py-4">
                                    <span class="status-badge orbitron ${statusClass}">${tip.status}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-mono text-[9px] text-slate-500">
                                    ${new Date(tip.updated_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}
                                </td>
                            </tr>
                        `;
                    });
                    if (body) body.innerHTML = rowsHtml;
                }
            }
        } catch (error) {
            console.error('Sync Error:', error);
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

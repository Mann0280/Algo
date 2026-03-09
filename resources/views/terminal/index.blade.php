@extends('layouts.dashboard')

@section('title', 'Dashboard | Emperor Stock Predictor Terminal')

@push('styles')
<style>
    .notification-panel {
        position: fixed; right: -400px; top: 0; width: 380px; height: 100vh;
        background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(20px);
        border-left: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1000; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .notification-panel.active { right: 0; }
    
    .restricted-overlay {
        background: linear-gradient(to top, rgba(5, 2, 10, 1) 0%, rgba(5, 2, 10, 0.8) 50%, rgba(5, 2, 10, 0) 100%);
        pointer-events: none;
    }
    .restricted-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        pointer-events: auto;
    }
    .blur-data {
        filter: blur(5px);
        user-select: none;
    }

    /* Mobile Neural Pathway (iPhone View) */
    .mobile-phone-frame {
        background: #000000;
        border: 4px solid #1a1a1a;
        border-radius: 4.5rem;
        padding: 0.8rem;
        position: relative;
        box-shadow: 
            0 0 0 2px rgba(147, 51, 234, 0.1),
            0 30px 60px rgba(0,0,0,0.9);
        overflow: hidden;
    }
    .mobile-phone-frame::after {
        content: '';
        position: absolute;
        inset: 0.6rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 3.8rem;
        pointer-events: none;
        z-index: 10;
    }
    .dynamic-island {
        width: 120px;
        height: 35px;
        background: #000000;
        border-radius: 20px;
        margin: 10px auto 25px auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        z-index: 50;
    }
    .island-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #1a1a1a;
    }
    .island-sensor {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #1a1a5a 0%, #000 70%);
        opacity: 0.6;
    }
    .neural-card {
        background: linear-gradient(180deg, #2a0a4e 0%, #0a0514 30%, #05020a 100%);
        border-radius: 3.2rem;
        padding: 2.5rem 2rem;
        position: relative;
        overflow: hidden;
        min-height: 580px;
        border: 1px solid rgba(147, 51, 234, 0.15);
        box-shadow: inset 0 20px 40px rgba(0,0,0,0.4);
    }
    .neural-wave {
        width: 100%;
        height: 120px;
        fill: none;
        stroke: #9333ea;
        stroke-width: 3;
        stroke-linecap: round;
        filter: drop-shadow(0 0 10px rgba(147, 51, 234, 0.5));
    }
    .neural-wave-fill {
        fill: url(#wave-gradient);
        opacity: 0.3;
    }
    @keyframes waveSwim {
        0% { transform: translateX(0); }
        50% { transform: translateX(-15px); }
        100% { transform: translateX(0); }
    }
    .animate-wave { animation: waveSwim 4s ease-in-out infinite; }
</style>
@endpush

@section('content')
<div class="space-y-12 pb-20">
    <!-- MOBILE IPHONE VIEW (Hidden on Desktop) -->
    @if ($isPremium)
    <div class="block lg:hidden mb-12">
        <div class="flex justify-end mb-6">
            <div class="px-4 py-1.5 bg-black/40 border border-purple-500/30 rounded-full flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_8px_#9333ea]"></span>
                <span class="orbitron text-[9px] font-bold text-gray-300 uppercase tracking-widest">TERMINAL V2.0 ACTIVE</span>
            </div>
        </div>

        <div class="mobile-phone-frame max-w-[400px] mx-auto scale-95 origin-top">
            <!-- Dynamic Island -->
            <div class="dynamic-island">
                <i data-lucide="lock" class="w-3 h-3 text-white/40"></i>
                <div class="island-sensor"></div>
                <div class="island-dot"></div>
            </div>

            <div class="neural-card">
                <!-- Header -->
                <div class="flex justify-between items-center mb-10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <i data-lucide="zap" class="w-5 h-5 text-white fill-white"></i>
                        </div>
                        <span class="orbitron font-black text-xs italic tracking-tighter text-purple-500">NEURAL PATHWAY</span>
                    </div>
                    <div class="flex gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-red-500/40"></span>
                        <span class="w-2 h-2 rounded-full bg-amber-500/40"></span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500/40"></span>
                    </div>
                </div>

                <!-- Main Display -->
                <div class="space-y-1">
                    <p class="orbitron text-[9px] font-bold text-gray-500 uppercase tracking-widest">SCANNING MARKET DEPTH</p>
                    <div class="flex items-baseline gap-3">
                        <h2 class="orbitron text-6xl font-black text-white tracking-tighter italic">98.4<span class="text-4xl">%</span></h2>
                        <span class="text-emerald-400 font-bold text-xs font-mono">+2.45%</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="h-px bg-white/5 w-full my-10"></div>

                <!-- Animated Wave Chart -->
                <div class="relative h-[180px] -mx-8 mt-4">
                    <svg viewBox="0 0 400 180" class="w-full h-full neural-wave animate-wave">
                        <defs>
                            <linearGradient id="wave-gradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#a855f7" stop-opacity="0.6" />
                                <stop offset="100%" stop-color="#9333ea" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <path d="M0,130 C50,120 80,160 140,100 C200,40 280,150 340,70 C370,30 400,100 450,120 L450,180 L0,180 Z" class="neural-wave-fill" />
                        <path d="M0,130 C50,120 80,160 140,100 C200,40 280,150 340,70 C370,30 400,100 450,120" />
                        <!-- Tooltip Point -->
                        <circle cx="340" cy="70" r="4" fill="#fff" class="shadow-lg" />
                    </svg>
                </div>

                <!-- Footer -->
                <div class="flex justify-between items-center mt-6">
                    <span class="orbitron text-[8px] font-bold text-gray-600 uppercase tracking-widest">EST 2024</span>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
                        <span class="orbitron text-[8px] font-bold text-gray-400 uppercase tracking-widest">SYSTEM OPERATIONAL</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Notification Panel Overlay -->
    <div id="notif-panel" class="notification-panel p-6 sm:p-8 w-full sm:w-[380px] right-[-100%] sm:right-[-400px]" style="background: var(--nav-sticky-bg)">
        <div class="flex justify-between items-center mb-8">
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
                <p class="text-xs text-gray-300 leading-relaxed">AI Neural Engine has successfully scanned 500+ NSE symbols. New signals generated.</p>
            </div>
        </div>
    </div>

    <!-- Terminal Layout -->
    <div class="flex-grow">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div>
                <h1 class="orbitron text-2xl font-bold uppercase italic tracking-tighter" style="color: var(--text-white)">TERMINAL <span class="text-purple-500">ACCESS</span></h1>
                <p class="text-[var(--text-muted)] text-sm">Welcome back, {{ $user->username }}. AI Engine is active.</p>
            </div>
            <div class="flex flex-wrap gap-3 sm:gap-4 w-full md:w-auto">
                <button onclick="toggleNotif()" class="glass-panel p-3 rounded-2xl relative text-gray-400 hover:text-white transition-all">
                    <i data-lucide="bell" class="w-6 h-6"></i>
                    <span class="absolute top-2 right-2 w-3 h-3 bg-red-500 border-2 border-black rounded-full"></span>
                </button>
                <div class="glass-panel px-4 sm:px-6 py-3 rounded-2xl flex items-center gap-4 flex-grow md:flex-grow-0">
                    <div class="text-left">
                        <div class="text-[10px] uppercase font-bold" style="color: var(--text-muted)">Account Status</div>
                        <div class="text-sm font-bold {{ $isPremium ? 'text-amber-400' : 'text-purple-400' }}">
                            {{ $isPremium ? 'PREMIUM' : 'LIMITED' }}
                        </div>
                    </div>
                </div>
                @if (!$isPremium)
                    <a href="{{ url('/pricing') }}" class="bg-amber-400 text-black px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-amber-400/20 hover:scale-105 transition-all flex items-center flex-grow md:flex-grow-0 justify-center">UPGRADE</a>
                @endif
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12 reveal-section">
            <div class="glass-panel p-5 sm:p-6 rounded-2xl border border-white/5">
                <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Breakeven</div>
                <div id="display-breakeven" class="text-xl sm:text-2xl font-bold text-purple-400 orbitron">{{ $settings['breakeven_point'] ?? '2500.00' }}</div>
            </div>
            <div class="glass-panel p-5 sm:p-6 rounded-2xl border border-white/5">
                <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Session Date</div>
                <div id="display-date" class="text-xl sm:text-2xl font-bold orbitron tracking-tighter" style="color: var(--text-white)">{{ \Carbon\Carbon::parse($settings['breakeven_date'] ?? now())->format('d M') }}</div>
            </div>
            <div class="glass-panel p-5 sm:p-6 rounded-2xl border border-white/5">
                <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Active</div>
                <div id="total-active" class="text-xl sm:text-2xl font-bold text-emerald-400 orbitron">00</div>
            </div>
            <div class="glass-panel p-5 sm:p-6 rounded-2xl border border-white/5">
                <div class="text-[9px] sm:text-[10px] font-bold text-slate-500 orbitron uppercase tracking-widest mb-1">Sync Status</div>
                <div id="refresh-counter" class="text-[10px] font-bold text-purple-400 orbitron uppercase">SYNC...</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @if ($isPremium)
            <!-- Active Signals Table -->
            <div class="lg:col-span-2 reveal-section">
                <div class="glass-panel rounded-3xl overflow-hidden border border-white/5 relative">
                    <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/5">
                        <h2 class="orbitron text-sm font-bold tracking-widest uppercase italic" style="color: var(--text-white)">AI MONITORING TERMINAL</h2>
                        <span class="text-[9px] bg-red-500/10 text-red-500 border border-red-500/20 px-2 py-1 rounded font-black orbitron animate-pulse">LIVE DATA</span>
                    </div>
                    <div class="overflow-x-auto">
                        <div id="tips-table"></div>
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
            @endif
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
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script src="{{ asset('js/tabulator-global.js') }}"></script>
<script>
    gsap.from(".reveal-section", { duration: 1, y: 30, opacity: 0, stagger: 0.1, ease: "power3.out" });
    function toggleNotif() { document.getElementById('notif-panel').classList.toggle('active'); }

    let tipsTable;
    let nextSync = 5;
    let syncInProgress = false;

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize Tabulator
        tipsTable = new Tabulator("#tips-table", {
            ...TABULATOR_BASE_CONFIG,
            data: [],
            columns: [
                {title: "Stock", field: "stock_name", widthGrow: 2, minWidth: 130, resizable: false, sorter: "string", formatter: (cell) => `<span class="font-black orbitron text-xs text-white uppercase tracking-tighter">${cell.getValue()}</span>`},
                {title: "Type", field: "confidence_percentage", width: 90, resizable: false, hozAlign: "center", formatter: (cell) => {
                    const badge = cell.getValue() >= 90 ? 'VIP' : 'PRO';
                    const cls = cell.getValue() >= 90 ? 'bg-amber-500/10 text-amber-500 border-amber-500/20' : 'bg-purple-500/10 text-purple-500 border-purple-500/20';
                    return `<span class="px-2 py-0.5 rounded border text-[8px] font-bold orbitron ${cls}">${badge}</span>`;
                }},
                {title: "Entry", field: "entry_price", width: 110, hozAlign: "right", sorter: "number", formatter: (cell) => {
                    const v = cell.getValue();
                    const isMasked = v === '•••••';
                    return `<span class="font-mono text-xs text-gray-400 ${isMasked ? 'blur-[5px] select-none opacity-50' : ''}">${isMasked ? '' : '₹'}${v}</span>`;
                }},
                {title: "SL", field: "stop_loss", width: 100, hozAlign: "right", sorter: "number", formatter: (cell) => {
                    const v = cell.getValue();
                    const isMasked = v === '•••••';
                    return `<span class="font-mono text-[10px] text-rose-500/60 ${isMasked ? 'blur-[5px] select-none opacity-50' : ''}">${isMasked ? '' : '₹'}${v}</span>`;
                }},
                {title: "T1", field: "target_1", width: 100, hozAlign: "right", sorter: "number", formatter: (cell) => {
                    const v = cell.getValue();
                    const isMasked = v === '•••••';
                    return `<span class="font-mono text-xs text-purple-400 ${isMasked ? 'blur-[5px] select-none opacity-50' : ''}">${isMasked ? '' : '₹'}${v}</span>`;
                }},
                {title: "T2", field: "target_2", width: 100, hozAlign: "right", sorter: "number", formatter: (cell) => {
                    const v = cell.getValue();
                    const isMasked = v === '•••••';
                    return `<span class="font-mono text-xs text-purple-400 ${isMasked ? 'blur-[5px] select-none opacity-50' : ''}">${v && !isMasked ? '₹' : ''}${v || '---'}</span>`;
                }},
                {title: "AI %", field: "confidence_percentage", width: 90, hozAlign: "center", sorter: "number", formatter: (cell) => `<span class="font-black orbitron text-xs text-purple-500">${cell.getValue()}%</span>`},
                {title: "Time", field: "updated_at", width: 90, hozAlign: "center", formatter: (cell) => {
                    return `<span class="font-mono text-[10px] text-gray-500">${new Date(cell.getValue()).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;
                }},
                {title: "Status", field: "status", width: 120, resizable: false, hozAlign: "center", formatter: (cell) => `
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></div>
                        <span class="text-[9px] font-bold orbitron text-emerald-500 uppercase tracking-widest">ACTIVE</span>
                    </div>`
                },
                {title: "Profit", field: "profit", width: 100, resizable: false, hozAlign: "right", formatter: (cell) => `<span class="font-black orbitron text-[10px] text-emerald-400 italic">PENDING</span>`},
            ]
        });

        // Initial Sync
        syncNeuralTelemetry();
        setInterval(runCountdown, 1000);
    });

    async function syncNeuralTelemetry() {
        if (syncInProgress || !tipsTable) return;
        syncInProgress = true;

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
                    tipsTable.setData([]);
                    if (emptyState) emptyState.classList.remove('hidden');
                } else {
                    if (emptyState) emptyState.classList.add('hidden');
                    tipsTable.replaceData(tips);
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
</script>
@endpush

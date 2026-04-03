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
        padding: 16px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 0.15em;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        text-align: left;
        white-space: nowrap;
    }
    .cyber-table tbody tr {
        background: rgba(255, 255, 255, 0.015);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        transform: scale(1); /* Forces exact container for absolute children in all browsers */
        border-radius: 16px;
    }
    .cyber-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.04);
        transform: translateZ(0) scale(1.005);
        z-index: 50;
    }
    .cyber-table td {
        padding: 20px 16px;
        font-size: 14px;
        color: #f1f5f9;
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        white-space: nowrap;
    }
    .cyber-table td:first-child {
        padding-left: 24px;
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
        white-space: normal;
        min-width: 250px;
    }
    .cyber-table td:last-child {
        padding-right: 24px;
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }
    
    /* Ensure only top/bottom borders exist between rows initially to make the pulse look good */
    .cyber-table td {
        border-top: 1px solid rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }
    .cyber-table td:first-child {
        border-left: 1px solid transparent; /* Remove left border */
    }
    .cyber-table td:last-child {
        border-right: 1px solid transparent; /* Remove right border */
    }

    .ai-row {
        background: transparent !important;
    }
    .ai-row td {
        padding: 4px 16px 12px 16px !important;
        border: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    /* Mobile Card Styles */
    #mobile-cards-container {
        display: none;
    }

    @media (max-width: 800px) {
        .desktop-only { display: none !important; }
        #mobile-cards-container {
            display: none;
        }
    }

    .signal-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .signal-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(147, 51, 234, 0.2);
    }
    .btn-copy-stock {
        position: absolute;
        top: 24px;
        right: 24px;
        background: rgba(147, 51, 234, 0.1);
        color: #c084fc;
        font-size: 9px;
        font-weight: 800;
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid rgba(147, 51, 234, 0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.3s ease;
        z-index: 20;
    }
    .btn-copy-stock:hover {
        background: rgba(147, 51, 234, 0.2);
    }
    .card-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 8px;
    }
    .card-value {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }
    .card-footer {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .status-btn {
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    /* 4-Span Border Trace Animation */
    .row-border-anim {
        /* Set to relative so absolute spans can position relative to the row/card */
        position: relative;
    }
    
    /* Hide overflow horizontally to prevent scrollbars, 
       but we don't want to clip the glow vertically if we don't have to.
       Applying border-radius to match the tr borders.
    */
    .border-anim-wrapper {
        position: absolute;
        inset: 0;
        border-radius: 16px;
        overflow: hidden;
        pointer-events: none;
        z-index: 0; 
    }
    
    .border-anim-wrapper span {
        position: absolute;
        display: block;
        z-index: 10;
        filter: blur(1px);
    }
    /* Top Line */
    .border-anim-wrapper span:nth-child(1) {
        top: 0;
        left: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #10b981, #34d399, #10b981);
        animation: anim-top 4s linear infinite;
    }
    @keyframes anim-top {
        0% { left: -100%; opacity: 0; }
        5%, 95% { opacity: 1; }
        100% { left: 100%; opacity: 0; }
    }
    /* Right Line */
    .border-anim-wrapper span:nth-child(2) {
        top: -100%;
        right: 0;
        width: 2px;
        height: 100%;
        background: linear-gradient(180deg, transparent, #10b981, #34d399, #10b981);
        animation: anim-right 4s linear infinite;
        animation-delay: 1s;
    }
    @keyframes anim-right {
        0% { top: -100%; opacity: 0; }
        5%, 95% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    /* Bottom Line */
    .border-anim-wrapper span:nth-child(3) {
        bottom: 0;
        right: -100%;
        width: 100%;
        height: 2px;
        background: linear-gradient(270deg, transparent, #10b981, #34d399, #10b981);
        animation: anim-bottom 4s linear infinite;
        animation-delay: 2s;
    }
    @keyframes anim-bottom {
        0% { right: -100%; opacity: 0; }
        5%, 95% { opacity: 1; }
        100% { right: 100%; opacity: 0; }
    }
    /* Left Line */
    .border-anim-wrapper span:nth-child(4) {
        bottom: -100%;
        left: 0;
        width: 2px;
        height: 100%;
        background: linear-gradient(360deg, transparent, #10b981, #34d399, #10b981);
        animation: anim-left 4s linear infinite;
        animation-delay: 3s;
    }
    @keyframes anim-left {
        0% { bottom: -100%; opacity: 0; }
        5%, 95% { opacity: 1; }
        100% { bottom: 100%; opacity: 0; }
    }

    /* Modern Table Row Relative Support */
    .cyber-table tbody tr {
        position: relative;
    }
</style>

<div class="mt-4 space-y-5">

    {{-- Status Bar --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-1">
        <div class="flex items-center gap-3">
            <span id="live-indicator-dot" class="live-dot"></span>
            <span id="live-indicator-text" class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.2em]">Live Feed Active</span>
            <span class="text-gray-600 text-xs">•</span>
            <span id="last-update" class="text-[10px] text-gray-600 font-mono">--:--:--</span>
            <span class="text-gray-600 text-xs">•</span>
            <div id="sync-indicator" class="flex items-center gap-1.5 bg-white/[0.03] px-2 py-0.5 rounded-md border border-white/[0.02]">
                <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Next Sync in:</span>
                <span id="countdown-timer" class="text-[10px] font-bold text-purple-400 w-4">05s</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span id="signal-count" class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">0 signals</span>
            <button onclick="refreshData()" class="p-2 rounded-lg bg-white/[0.03] border border-white/[0.05] text-gray-500 hover:text-purple-400 hover:border-purple-500/20 transition-all" title="Refresh now">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            </button>
        </div>
    </div>

    {{-- Main Table --}}
    <div id="market-closed-notice" class="hidden py-16 glass-card border-white/5 flex flex-col items-center justify-center text-center">
        <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6 border border-white/10 group">
             <i data-lucide="clock-4" class="w-8 h-8 text-gray-600 transition-colors group-hover:text-purple-400"></i>
        </div>
        <h2 class="text-2xl font-professional text-white tracking-tighter mb-2">Market Day <span class="text-gradient">Complete</span></h2>
        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.3em] mb-8">Daily Session Closed at 4:00 PM</p>
        <div class="flex flex-col gap-3">
             <p class="text-xs text-gray-400 max-w-sm mb-4">All live signals from today have been saved to history for check.</p>
             <a href="{{ route('signals.past') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-white/[0.03] border border-white/10 text-white font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-white/10 transition-all">
                View Today's History
                <i data-lucide="arrow-right" class="w-3 h-3"></i>
             </a>
        </div>
    </div>

    <div id="table-container" class="overflow-x-auto no-scrollbar pb-10">
        <div class="min-w-[1000px] px-1">
            <table class="cyber-table">
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th class="desktop-only" style="text-align: center;">Signal</th>
                        <th class="desktop-only" style="text-align: right;">Entry</th>
                        <th class="desktop-only" style="text-align: right;">Stop Loss</th>
                        <th class="desktop-only" style="text-align: right;">Target</th>
                        <th class="desktop-only" style="text-align: right;">Breakeven</th>
                        <th style="text-align: center;">Date</th>
                        <th class="desktop-only" style="text-align: center;">Result</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody id="signals-tbody">
                    {{-- Dynamic Content --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards Container (HIDDEN - Using Table) --}}
    <div id="mobile-cards-container" class="hidden">
        {{-- Dynamic Cards --}}
    </div>

    <!-- Mobile Details Modal -->
    <div id="details-modal" class="fixed inset-0 z-[100] flex items-center justify-center px-6 hidden opacity-0 transition-all duration-300">
        <div class="absolute inset-0 modal-backdrop bg-black/80 backdrop-blur-md" onclick="closeModal()"></div>
        <div class="modal-content w-full max-w-lg rounded-[2.5rem] p-8 relative z-10 overflow-hidden bg-[#0d061a] border border-purple-500/30 shadow-2xl">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h2 id="modal-stock-name" class="text-3xl font-professional text-white tracking-tighter uppercase">STOCK NAME</h2>
                    <p id="modal-date" class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mt-1">DATE & TIME</p>
                </div>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Signal Type</p>
                    <p id="modal-type" class="text-sm font-black uppercase tracking-wider">BUY</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Current Status</p>
                    <div id="modal-status-container"></div>
                </div>
                
                <div class="col-span-2 h-px bg-white/5 my-2"></div>

                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Entry Price</p>
                    <p id="modal-entry" class="text-lg font-bold text-white tracking-tight">₹0.00</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Stop Loss</p>
                    <p id="modal-sl" class="text-lg font-bold text-rose-500 tracking-tight">₹0.00</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Target Price (T1)</p>
                    <p id="modal-target" class="text-lg font-bold text-emerald-500 tracking-tight">₹0.00</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Breakeven (BE)</p>
                    <p id="modal-breakeven" class="text-lg font-bold text-blue-500 tracking-tight">₹0.00</p>
                </div>
            </div>

            <div class="mt-10">
                <button onclick="closeModal()" class="w-full py-4 bg-white/5 text-white font-bold text-xs uppercase tracking-[0.2em] rounded-2xl border border-white/10 hover:bg-white/10 transition-all">
                    Close Details
                </button>
            </div>
        </div>
    </div>

    {{-- Video Modal --}}
    <div id="video-modal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[10000] hidden items-center justify-center p-4">
        <div class="absolute inset-0" onclick="closeVideoModal()"></div>
        <div class="relative w-full max-w-4xl aspect-video rounded-3xl overflow-hidden border border-white/10 shadow-2xl bg-black">
            <button onclick="closeVideoModal()" class="absolute top-4 right-4 w-10 h-10 rounded-xl bg-black/50 backdrop-blur-md flex items-center justify-center text-white hover:bg-rose-500 transition-all z-10">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            <iframe id="video-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentSignals = [];

    function openModal(id) {
        const item = currentSignals.find(s => s.id == id);
        if(!item) return;

        const isBuy = (item.signal_type || '').toUpperCase() === 'BUY';
        const signalColor = isBuy ? '#34d399' : '#f87171';
        
        const status = (item.status || 'LIVE').toUpperCase().replace(/\s+/g, '_');
        const statusMap = {
            'LIVE': { bg: 'rgba(59,130,246,0.1)', clr: '#60a5fa', bdr: 'rgba(59,130,246,0.2)', label: 'LIVE' },
            'RUNNING': { bg: 'rgba(16,185,129,0.1)', clr: '#34d399', bdr: 'rgba(16,185,129,0.2)', label: 'RUNNING' },
            'HIT_TARGET': { bg: 'rgba(234,179,8,0.1)', clr: '#fbbf24', bdr: 'rgba(234,179,8,0.2)', label: 'HIT TARGET' },
            'SL_HIT': { bg: 'rgba(239,68,68,0.1)', clr: '#f87171', bdr: 'rgba(239,68,68,0.2)', label: 'SL HIT' },
            'TP_HIT': { bg: 'rgba(168,85,247,0.1)', clr: '#a855f7', bdr: 'rgba(168,85,247,0.2)', label: 'TP HIT' },
            'EOD': { bg: 'rgba(148,163,184,0.1)', clr: '#94a3b8', bdr: 'rgba(148,163,184,0.2)', label: 'EOD' },
            'BREAKEVEN': { bg: 'rgba(59,130,246,0.1)', clr: '#60a5fa', bdr: 'rgba(59,130,246,0.2)', label: 'BREAKEVEN' },
        };
        const s = statusMap[status] || statusMap['LIVE'];

        document.getElementById('modal-stock-name').textContent = item.stock_symbol || '---';
        document.getElementById('modal-date').textContent = `${item.date || ''} @ ${item.time || ''}`;
        
        const typeEl = document.getElementById('modal-type');
        typeEl.textContent = (item.signal_type || '').toUpperCase();
        typeEl.style.color = signalColor;
        
        document.getElementById('modal-status-container').innerHTML = `<span style="display:inline-block;padding:4px 14px;border-radius:8px;font-family:'Inter',sans-serif;font-size:9px;font-weight:900;background:${s.bg};color:${s.clr};border:1px solid ${s.bdr};">${s.label}</span>`;
        
        document.getElementById('modal-entry').textContent = `₹${parseFloat(item.entry_price || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        document.getElementById('modal-sl').textContent = `₹${parseFloat(item.stop_loss || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        document.getElementById('modal-target').textContent = `₹${parseFloat(item.target_price || 0).toLocaleString(undefined, {minimumFractionDigits: 2})}`;
        document.getElementById('modal-breakeven').textContent = item.target_2 ? `₹${parseFloat(item.target_2).toLocaleString(undefined, {minimumFractionDigits: 2})}` : '---';

        const modal = document.getElementById('details-modal');
        modal.classList.remove('hidden');
        setTimeout(() => { modal.classList.add('opacity-100'); }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('details-modal');
        modal.classList.remove('opacity-100');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
        document.body.style.overflow = '';
    }

    function openVideoModal(url) {
        const modal = document.getElementById('video-modal');
        const iframe = document.getElementById('video-iframe');
        
        // Handle YouTube/Vimeo/Direct
        let finalUrl = url;
        if (url.includes('youtube.com/watch?v=')) {
            finalUrl = url.replace('watch?v=', 'embed/');
        } else if (url.includes('youtu.be/')) {
            finalUrl = 'https://www.youtube.com/embed/' + url.split('/').pop();
        }

        iframe.src = finalUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        if (typeof lenis !== 'undefined') lenis.stop();
    }

    function closeVideoModal() {
        const modal = document.getElementById('video-modal');
        const iframe = document.getElementById('video-iframe');
        iframe.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (typeof lenis !== 'undefined') lenis.start();
    }

    document.addEventListener("DOMContentLoaded", function() {
    let refreshInterval;

    function renderTable(data) {
        const tbody = document.getElementById('signals-tbody');
        const cardsContainer = document.getElementById('mobile-cards-container');
        
        tbody.innerHTML = '';
        cardsContainer.innerHTML = '';

        data.forEach(item => {
            const isBuy = (item.signal_type || '').toUpperCase() === 'BUY';
            const signalColor = isBuy ? '#34d399' : '#f87171';
            const signalBg = isBuy ? 'rgba(16,185,129,0.08)' : 'rgba(239,68,68,0.08)';
            const signalBdr = isBuy ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)';

            const status = (item.status || 'LIVE').toUpperCase().replace(/\s+/g, '_');
            const statusMap = {
                'LIVE': { bg: 'rgba(59,130,246,0.1)', clr: '#60a5fa', bdr: 'rgba(59,130,246,0.2)', label: 'LIVE' },
                'RUNNING': { bg: 'rgba(16,185,129,0.1)', clr: '#34d399', bdr: 'rgba(16,185,129,0.2)', label: 'RUNNING' },
                'HIT_TARGET': { bg: 'rgba(234,179,8,0.1)', clr: '#fbbf24', bdr: 'rgba(234,179,8,0.2)', label: 'HIT TARGET' },
                'SL_HIT': { bg: 'rgba(239,68,68,0.1)', clr: '#f87171', bdr: 'rgba(239,68,68,0.2)', label: 'SL HIT' },
                'TP_HIT': { bg: 'rgba(168,85,247,0.1)', clr: '#a855f7', bdr: 'rgba(168,85,247,0.2)', label: 'TP HIT' },
                'EOD': { bg: 'rgba(148,163,184,0.1)', clr: '#94a3b8', bdr: 'rgba(148,163,184,0.2)', label: 'EOD' },
                'BREAKEVEN': { bg: 'rgba(59,130,246,0.1)', clr: '#60a5fa', bdr: 'rgba(59,130,246,0.2)', label: 'BREAKEVEN' },
            };
            const s = statusMap[status] || statusMap['LIVE'];

            // 1. RENDER TABLE ROW
            const mainRow = document.createElement('tr');
            mainRow.className = 'row-border-anim group';
            mainRow.innerHTML = `
                <td>
                    <div class="border-anim-wrapper">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <div class="flex flex-col gap-0.5 relative z-20">
                        <span style="font-weight:900;color:#fff;font-size:15px;letter-spacing:-0.02em;line-height:1.2;">${item.stock_symbol || '—'}</span>
                        <span class="desktop-only" style="font-size:10px;color:#64748b;font-family:monospace;font-weight:600;">${item.date || '—'}</span>
                    </div>
                </td>
                <td class="desktop-only" style="text-align: center; position: relative; z-index: 10;">
                    <span style="display:inline-block;padding:4px 14px;border-radius:8px;font-family:'Inter',sans-serif;font-size:9px;font-weight:900;background:${signalBg};color:${signalColor};border:1px solid ${signalBdr};">${(item.signal_type || '').toUpperCase()}</span>
                </td>
                <td class="desktop-only" style="text-align: right; color:#d1d5db; font-weight:600; position: relative; z-index: 10;">₹${parseFloat(item.entry_price || 0).toFixed(2)}</td>
                <td class="desktop-only" style="text-align: right; color:#f87171; font-weight:600; position: relative; z-index: 10;">₹${parseFloat(item.stop_loss || 0).toFixed(2)}</td>
                <td class="desktop-only" style="text-align: right; color:#34d399; font-weight:600; position: relative; z-index: 10;">₹${parseFloat(item.target_price || 0).toFixed(2)}</td>
                <td class="desktop-only" style="text-align: right; color:#60a5fa; font-weight:600; position: relative; z-index: 10;">${item.target_2 ? '₹' + parseFloat(item.target_2).toFixed(2) : '—'}</td>
                <td style="text-align: center; color:#94a3b8; font-size:11px; font-family:monospace; position: relative; z-index: 10;">
                    <div class="flex flex-col items-center">
                        <span style="font-weight:700;color:#fff;">${item.date || '—'}</span>
                        <span class="desktop-only" style="font-size:9px;">${item.time || '—'}</span>
                    </div>
                </td>
                <td class="desktop-only" style="text-align: center; position: relative; z-index: 10;">
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-1 h-1 rounded-full" style="background: ${s.clr}; box-shadow: 0 0 8px ${s.clr};"></span>
                        <span style="display:inline-block;padding:4px 10px;border-radius:8px;font-family:'Inter',sans-serif;font-size:9px;font-weight:900;background:${s.bg};color:${s.clr};border:1px solid ${s.bdr};">${s.label}</span>
                    </div>
                </td>
                <td style="text-align: center; position: relative; z-index: 10;">
                    <button onclick="openModal(${item.id})" class="px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg text-purple-400 font-bold text-[9px] uppercase tracking-wider hover:bg-purple-500/20 hover:text-white transition-all active:scale-95">
                        Details
                    </button>
                </td>
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
            
            // Handle Market Closed State
            if (json.market_status === 'closed') {
                document.getElementById('market-closed-notice').classList.remove('hidden');
                document.getElementById('table-container').classList.add('hidden');
                document.getElementById('live-indicator-text').textContent = 'Market Closed';
                document.getElementById('live-indicator-text').className = 'text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]';
                document.getElementById('live-indicator-dot').style.background = '#4b5563';
                document.getElementById('live-indicator-dot').style.boxShadow = 'none';
                document.getElementById('live-indicator-dot').classList.remove('animate-pulse');
                document.getElementById('sync-indicator').classList.add('hidden');
                document.getElementById('signal-count').textContent = 'Moved to History';
                
                // Initialize Lucide for the new notice
                if (typeof lucide !== 'undefined') lucide.createIcons();
                
                clearInterval(refreshInterval); // Stop refreshing if closed
                return;
            }

            if (json.success && json.data) {
                currentSignals = json.data;
                renderTable(json.data);
                document.getElementById('signal-count').textContent = `${json.count || json.data.length} signals`;
                document.getElementById('last-update').textContent = new Date().toLocaleTimeString('en-IN', { hour12: false });
            }
        } catch (err) {
            console.warn('Signal refresh failed:', err);
        }
    }

    async function refreshTutorials() {
        try {
            const res = await fetch('/api/tutorial-videos', {
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]*)/)?.[1] || ''),
                },
                credentials: 'same-origin',
            });

            if (!res.ok) throw new Error(`HTTP ${res.status}`);

            const json = await res.json();
            if (json.success && json.data) {
                renderVideoFeed(json.data);
            }
        } catch (err) {
            console.warn('Tutorial refresh failed:', err);
        }
    }

    function renderVideoFeed(videos) {
        const videoGrid = document.getElementById('video-grid');
        const videoSection = document.getElementById('video-feed-section');
        const videoCount = document.getElementById('video-count');
        
        if (videos.length === 0) {
            videoSection.classList.add('hidden');
            return;
        }

        videoSection.classList.remove('hidden');
        videoCount.textContent = `${videos.length} active tutorial${videos.length > 1 ? 's' : ''}`;
        
        videoGrid.innerHTML = videos.map(item => {
            // Robust YouTube ID Extraction
            let thumb = '';
            const url = item.video_url || '';
            const ytRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i;
            const match = url.match(ytRegex);
            const id = match ? match[1] : null;

            if (id) {
                // Use hqdefault for better quality and hq720 if available (fallback to hqdefault)
                thumb = `https://img.youtube.com/vi/${id}/hqdefault.jpg`;
            }

            return `
                <div onclick="openVideoModal('${item.video_url}')" class="glass-card p-4 rounded-3xl border border-white/5 group cursor-pointer transition-all hover:border-purple-500/30 hover:bg-white/[0.02]">
                    <div class="aspect-video rounded-2xl overflow-hidden bg-slate-900 relative mb-4">
                        ${thumb ? `<img src="${thumb}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-all duration-700 scale-105 group-hover:scale-100" alt="Thumbnail">` : `
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-900/40 to-blue-900/40 flex items-center justify-center">
                                <i data-lucide="video" class="w-8 h-8 text-white/10"></i>
                            </div>
                        `}
                        
                        <div class="absolute inset-0 flex items-center justify-center z-10">
                            <div class="w-16 h-16 rounded-full bg-purple-600/90 flex items-center justify-center text-white shadow-2xl shadow-purple-600/40 transform group-hover:scale-110 transition-all duration-500 border border-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" class="ml-1"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-[5]"></div>
                        
                        <div class="absolute bottom-3 left-3 flex items-center gap-2 z-20">
                             <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse shadow-[0_0_8px_#f43f5e]"></div>
                             <span class="text-[9px] font-black text-white uppercase tracking-[0.2em]">Advanced Analysis</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-sm font-bold text-white tracking-tight line-clamp-1">${item.title}</h3>
                        </div>
                        <p class="text-[10px] font-medium text-gray-500 uppercase tracking-widest line-clamp-1">${item.description || 'Global Intelligence Stream'}</p>
                    </div>
                </div>
            `;
        }).join('');
        
        // Ensure icons are created for fallback
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    window.refreshData = refreshData;

    window.copyStock = function(btn, text) {
        navigator.clipboard.writeText(text).then(() => {
            const span = btn.querySelector('span');
            if(span) {
                const originalText = span.textContent;
                span.textContent = 'COPIED!';
                btn.style.background = 'rgba(147, 51, 234, 0.25)';
                setTimeout(() => {
                    span.textContent = originalText;
                    btn.style.background = '';
                }, 2000);
            }
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    };

    let countdownValue = 5;
    const countdownEl = document.getElementById('countdown-timer');

    function startCountdown() {
        clearInterval(refreshInterval);
        refreshInterval = setInterval(() => {
            countdownValue--;
            if (countdownValue <= 0) {
                refreshData();
                countdownValue = 5;
            }
            countdownEl.textContent = `${countdownValue.toString().padStart(2, '0')}s`;
        }, 1000);
    }

    refreshData();
    refreshTutorials();
    startCountdown();

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(refreshInterval);
        } else {
            refreshData();
            countdownValue = 5;
            startCountdown();
        }
    });
});
</script>
@endpush


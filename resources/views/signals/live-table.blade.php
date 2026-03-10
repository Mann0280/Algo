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
            <span class="text-gray-600 text-xs">•</span>
            <div class="flex items-center gap-1.5 bg-white/[0.03] px-2 py-0.5 rounded-md border border-white/[0.02]">
                <span class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-widest">Next Sync in:</span>
                <span id="countdown-timer" class="text-[10px] font-black orbitron text-purple-400 w-4">05s</span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span id="signal-count" class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest">0 signals</span>
            <button onclick="refreshData()" class="p-2 rounded-lg bg-white/[0.03] border border-white/[0.05] text-gray-500 hover:text-purple-400 hover:border-purple-500/20 transition-all" title="Refresh now">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
            </button>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="overflow-x-auto no-scrollbar -mx-4 px-4 sm:mx-0 sm:px-0">
        <div class="min-w-[800px]">
            <table class="cyber-table">
                <thead>
                    <tr>
                        <th style="width: 15%">Stock</th>
                        <th style="width: 10%; text-align: center;">Signal</th>
                        <th style="width: 10%; text-align: right;">Entry</th>
                        <th style="width: 10%; text-align: right;">Stop Loss</th>
                        <th style="width: 10%; text-align: right;">Target</th>
                        <th style="width: 10%; text-align: right;">Breakeven</th>
                        <th style="width: 12%; text-align: center;">Date</th>
                        <th style="width: 10%; text-align: center;">Time</th>
                    </tr>
                </thead>
                <tbody id="signals-tbody">
                    {{-- Dynamic Content --}}
                </tbody>
            </table>
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

            const pl = item.profit || '0.00';
            const plValue = parseFloat(pl);
            const plColor = plValue > 0 ? '#34d399' : (plValue < 0 ? '#f87171' : '#94a3b8');
            const plPrefix = plValue > 0 ? '+' : '';

            // MAIN ROW
            const mainRow = document.createElement('tr');
            mainRow.innerHTML = `
                <td>
                    <div class="flex flex-col">
                        <span style="font-weight:800;color:#f1f5f9;font-size:13px;text-transform:uppercase;">${item.stock_symbol || '—'}</span>
                        <span style="font-size:9px;color:#4b5563;font-family:monospace;letter-spacing:1px;">${item.date || '—'}</span>
                    </div>
                </td>
                <td style="text-align: center;">
                    <span style="display:inline-block;padding:4px 14px;border-radius:8px;font-family:Orbitron,monospace;font-size:9px;font-weight:900;background:${signalBg};color:${signalColor};border:1px solid ${signalBdr};">${(item.signal_type || '').toUpperCase()}</span>
                </td>
                <td style="text-align: right; color:#d1d5db; font-weight:600;">₹${parseFloat(item.entry_price || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#f87171; font-weight:600;">₹${parseFloat(item.stop_loss || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#34d399; font-weight:600;">₹${parseFloat(item.target_price || 0).toFixed(2)}</td>
                <td style="text-align: right; color:#60a5fa; font-weight:600;">${item.target_2 ? '₹' + parseFloat(item.target_2).toFixed(2) : '—'}</td>
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
            return `
                <div onclick="openVideoModal('${item.video_url}')" class="glass-card p-4 rounded-3xl border border-white/5 group cursor-pointer transition-all hover:border-purple-500/30 hover:bg-white/[0.02]">
                    <div class="aspect-video rounded-2xl overflow-hidden bg-black relative mb-4">
                        <div class="absolute inset-0 flex items-center justify-center bg-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <div class="w-12 h-12 rounded-full bg-purple-600 flex items-center justify-center text-white shadow-xl shadow-purple-600/40">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                        <div class="absolute bottom-3 left-3 flex items-center gap-2">
                             <div class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></div>
                             <span class="text-[8px] font-black orbitron text-white uppercase tracking-widest italic">Educational Stream</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-sm font-black orbitron text-white italic tracking-tight line-clamp-1">${item.title}</h3>
                        </div>
                        <p class="text-[9px] font-medium text-gray-500 uppercase tracking-widest line-clamp-1">${item.description || 'Neural Learning Protocol'}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    window.refreshData = refreshData;

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


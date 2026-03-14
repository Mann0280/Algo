{{-- ═══════════════════════════════════════════
    FREE USER — Blurred preview + Upgrade overlay
    ═══════════════════════════════════════════ --}}

<div class="relative mt-4">

    {{-- Blurred Preview Table --}}
    <div class="table-wrapper">
        <div id="locked-signals-preview" class="overflow-hidden rounded-2xl border border-white/[0.03]" style="filter: blur(6px); pointer-events: none; user-select: none;"></div>
    </div>

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script src="{{ asset('js/tabulator-global.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dummyData = [
            {stock: 'RELIANCE', signal: 'BUY', entry: '₹2450.50', sl: '₹2380.00', t1: '₹2550.00', t2: '₹2620.00', conf: '92%', status: 'LIVE'},
            {stock: 'INFY', signal: 'SELL', entry: '₹1520.20', sl: '₹1580.00', t1: '₹1450.00', t2: '₹1400.00', conf: '88%', status: 'LIVE'},
            {stock: 'TCS', signal: 'BUY', entry: '₹3840.00', sl: '₹3780.00', t1: '₹3950.00', t2: '₹4050.00', conf: '95%', status: 'LIVE'},
            {stock: 'HDFCBANK', signal: 'BUY', entry: '₹1650.40', sl: '₹1610.00', t1: '₹1720.00', t2: '₹1780.00', conf: '91%', status: 'LIVE'},
        ];

        new Tabulator("#locked-signals-preview", {
            ...TABULATOR_BASE_CONFIG,
            data: dummyData,
            layout: "fitDataStretch",
            responsiveLayout: false,
            columns: [
                {title: "STOCK", field: "stock", minWidth: 120, formatter: (cell) => `<div class="text-white font-bold">${cell.getValue()}</div>`},
                {title: "SIGNAL", field: "signal", minWidth: 90, formatter: (cell) => {
                    const val = cell.getValue();
                    const cls = val === 'BUY' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400';
                    return `<span class="px-3 py-1 rounded-lg text-[9px] font-bold ${cls}">${val}</span>`;
                }},
                {title: "ENTRY", field: "entry", minWidth: 110},
                {title: "SL", field: "sl", minWidth: 100},
                {title: "TARGET 1", field: "t1", minWidth: 110},
                {title: "TARGET 2", field: "t2", minWidth: 110},
                {title: "CONFIDENCE", field: "conf", minWidth: 100},
                {title: "STATUS", field: "status", minWidth: 110},
            ]
        });
    });
</script>
@endpush

    {{-- Lock Overlay --}}
    <div class="absolute inset-0 flex items-center justify-center rounded-2xl" style="background: rgba(5,2,10,0.6); backdrop-filter: blur(2px);">
        <div class="text-center max-w-md px-6">

            {{-- Lock Icon --}}
            <div class="mx-auto w-16 h-16 rounded-2xl bg-purple-600/10 border border-purple-500/15 flex items-center justify-center mb-6" style="box-shadow: 0 0 40px rgba(124,58,237,0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            <h3 class="text-lg font-bold uppercase tracking-tight text-white mb-2">
                Premium <span class="text-purple-400">Access Required</span>
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">
                Upgrade to Premium to unlock real-time AI trading signals. Get precision entry points, stop losses, targets, and AI confidence scores.
            </p>

            <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center gap-2 px-10 py-4 rounded-xl bg-[#7c3aed] hover:bg-[#6d28d9] text-white text-xs font-bold uppercase tracking-widest transition-all shadow-[0_4px_24px_rgba(124,58,237,0.3)] hover:shadow-[0_4px_32px_rgba(124,58,237,0.5)] hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/></svg>
                Upgrade to Premium
            </a>
        </div>
    </div>

</div>

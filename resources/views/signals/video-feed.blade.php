{{-- ═══════════════════════════════════════════
    PREMIUM — Neural Video Feed
    Displays signals that have video analysis
    ═══════════════════════════════════════════ --}}

<div id="video-feed-section" class="hidden mt-12 animate-in fade-in slide-in-from-top-4 duration-1000">
    <div class="flex items-center justify-between mb-6 px-1">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_rgba(168,85,247,0.5)]"></div>
            <h2 class="text-[10px] font-bold text-white uppercase tracking-[0.3em]">Neural Video Analysis</h2>
        </div>
        <div id="video-count" class="text-[9px] font-bold text-gray-600 uppercase tracking-widest">0 active streams</div>
    </div>

    <div id="video-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Dynamic Content --}}
    </div>
</div>

{{-- ═══════════════════════════════════════════
    PREMIUM — Neural Video Feed
    Displays signals that have video analysis
    ═══════════════════════════════════════════ --}}

<div id="video-feed-section" class="hidden mt-16 animate-in fade-in slide-in-from-top-4 duration-1000">
    <div class="flex flex-col items-center justify-center mb-10 px-1 text-center">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_rgba(168,85,247,0.5)]"></div>
            <h2 class="text-[11px] font-bold text-white uppercase tracking-[0.4em]">Neural Video Analysis</h2>
        </div>
        <div id="video-count" class="text-[9px] font-bold text-gray-600 uppercase tracking-widest">0 active streams</div>
    </div>

    <div id="video-grid" class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
        {{-- Dynamic Content --}}
    </div>
</div>

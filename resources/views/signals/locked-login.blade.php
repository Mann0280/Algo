{{-- ═══════════════════════════════════════════
    GUEST LOCK SCREEN — Not logged in
    ═══════════════════════════════════════════ --}}

<div class="flex items-center justify-center py-16">
    <div class="text-center max-w-lg mx-auto">

        {{-- Lock Icon --}}
        <div class="mx-auto w-24 h-24 rounded-3xl bg-gradient-to-br from-purple-600/10 to-indigo-600/10 border border-purple-500/10 flex items-center justify-center mb-8" style="box-shadow: 0 0 60px rgba(124,58,237,0.08);">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        {{-- Message --}}
        <h2 class="text-xl font-black orbitron uppercase tracking-tight text-white mb-3">
            Neural Signal Stream <span class="text-purple-400">Restricted</span>
        </h2>
        <p class="text-gray-500 text-sm leading-relaxed mb-8 max-w-md mx-auto">
            Login to see what our AI is detecting in the market. Real-time precision signals, execution alerts, and confidence levels are available to authenticated users.
        </p>

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-[#7c3aed] hover:bg-[#6d28d9] text-white text-xs font-bold orbitron uppercase tracking-widest transition-all shadow-[0_4px_20px_rgba(124,58,237,0.25)] hover:shadow-[0_4px_28px_rgba(124,58,237,0.4)] hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                Login
            </a>
            <a href="{{ route('pricing') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-white/[0.03] border border-purple-500/10 text-gray-400 hover:text-white hover:border-purple-500/25 text-xs font-bold orbitron uppercase tracking-widest transition-all hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 13L2 9Z"/><path d="M11 3 8 9l4 13 4-13-3-6"/><path d="M2 9h20"/></svg>
                Explore Premium
            </a>
        </div>

        {{-- Decorative grid --}}
        <div class="mt-12 grid grid-cols-3 gap-3 max-w-sm mx-auto opacity-20">
            @for($i = 0; $i < 6; $i++)
            <div class="h-8 rounded-lg bg-gradient-to-r from-purple-600/10 to-transparent border border-white/[0.02]"></div>
            @endfor
        </div>
    </div>
</div>

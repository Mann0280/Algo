@extends('layouts.app')

@section('title', 'Notifications | ALGO TRADE')

@section('content')
<main class="relative min-h-screen pt-10 pb-20 px-6">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-1/3 left-1/4 w-[500px] h-[500px] bg-purple-600/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="flex items-center justify-between mb-12 fade-in-up">
            <div>
                <h1 class="text-4xl font-black orbitron text-white mb-2 uppercase italic">NOTIFICATIONS</h1>
                <p class="text-gray-400">AI Intelligence Alerts and System Protocols.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-2 fade-in-up">
                <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-transparent border border-transparent text-gray-400 font-bold text-sm hover:bg-white/5 transition-all">
                    <i data-lucide="user" class="w-5 h-5"></i> General
                </a>
                <a href="{{ route('account.membership') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-transparent border border-transparent text-gray-400 font-bold text-sm hover:bg-white/5 transition-all">
                    <i data-lucide="credit-card" class="w-5 h-5"></i> Membership
                </a>
                <a href="{{ route('account.notifications') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-sm transition-all">
                    <i data-lucide="bell" class="w-5 h-5 text-purple-500"></i> Notifications
                </a>
            </div>

            <div class="md:col-span-2 space-y-4 fade-in-up">
                <div class="glass-panel rounded-3xl p-6 border border-white/5 hover:border-purple-500/30 transition-all group relative overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-1 bg-purple-500"></div>
                    <div class="flex gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-500">
                            <i data-lucide="zap" class="w-6 h-6"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-[12px] font-black orbitron text-white uppercase tracking-widest">System Sync Successful</h4>
                                <span class="text-[9px] font-bold text-gray-500">JUST NOW</span>
                            </div>
                            <p class="text-sm text-gray-400 leading-relaxed uppercase tracking-tight">Your terminal has successfully migrated to the advanced node structure.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

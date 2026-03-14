@extends('layouts.app')

@section('title', 'Notifications | Emperor Stock Predictor')

@section('content')
<main class="relative min-h-screen pt-10 pb-20 px-6">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-1/3 left-1/4 w-[500px] h-[500px] bg-purple-600/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="flex items-center justify-between mb-12 fade-in-up">
            <div>
                <h1 class="text-4xl font-black font-whiskey text-white mb-2 uppercase italic">NOTIFICATIONS</h1>
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
                @if(!$isPremium)
                <div class="glass-panel rounded-3xl p-12 text-center border border-white/5 bg-white/5">
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 mx-auto mb-6">
                        <i data-lucide="lock" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-whiskey font-black text-white uppercase text-xl mb-3 tracking-widest">Protocol Restricted</h3>
                    <p class="text-gray-400 text-sm max-w-sm mx-auto mb-8 uppercase tracking-tight">The Neural Notification Stream is exclusive to Premium Elite Nodes. Upgrade to initialize connection.</p>
                    <a href="{{ url('/pricing') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-amber-500 text-black font-black font-whiskey text-xs uppercase tracking-widest hover:scale-105 transition-all">
                        <i data-lucide="zap" class="w-4 h-4"></i> Upgrade Neural Access
                    </a>
                </div>
                @elseif($notifications->isEmpty())
                <div class="glass-panel rounded-3xl p-12 text-center border border-white/5 bg-white/5 opacity-50">
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-500 mx-auto mb-6">
                        <i data-lucide="inbox" class="w-8 h-8"></i>
                    </div>
                    <h3 class="font-whiskey font-black text-white uppercase text-xl mb-3 tracking-widest">Matrix Clear</h3>
                    <p class="text-gray-400 text-sm uppercase tracking-tighter">No neural signals detected in the current stream.</p>
                </div>
                @else
                    @foreach($notifications as $notification)
                    <div class="glass-panel rounded-3xl p-6 border border-white/5 hover:border-purple-500/30 transition-all group relative overflow-hidden">
                        <div class="absolute inset-y-0 left-0 w-1 {{ $notification->type === 'danger' ? 'bg-rose-500' : ($notification->type === 'success' ? 'bg-emerald-500' : 'bg-purple-500') }}"></div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-2xl {{ $notification->type === 'danger' ? 'bg-rose-500/10 text-rose-500 border-rose-500/20' : ($notification->type === 'success' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-purple-500/10 text-purple-500 border-purple-500/20') }} border flex items-center justify-center">
                                <i data-lucide="{{ $notification->icon ?? 'bell' }}" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-[12px] font-black font-whiskey text-white uppercase tracking-widest">{{ $notification->title }}</h4>
                                    <span class="text-[9px] font-bold text-gray-500 uppercase">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed uppercase tracking-tight">{{ $notification->message }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.to('.fade-in-up', {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.2,
            ease: "power4.out"
        });
    });
</script>
@endpush
@endsection

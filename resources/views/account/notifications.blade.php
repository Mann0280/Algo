@extends('layouts.dashboard')

@section('title', 'Neural Notifications | System Protocol')

@section('content')
<div class="px-6 py-8">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8 opacity-0 translate-y-4" id="notif-header">
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight uppercase leading-none mb-2">
                    Neural <span class="text-purple-500">Alert Stream</span>
                </h1>
                <p class="text-gray-400 text-sm font-medium">Real-time intelligence and system protocol synchronization.</p>
            </div>
            
            @if($isPremium && $notifications->isNotEmpty())
            <div class="flex items-center gap-3">
                <span class="px-3 py-1.5 rounded-lg bg-purple-500/10 border border-purple-500/20 text-purple-500 text-[10px] font-bold uppercase tracking-widest">
                    {{ $notifications->count() }} Signals Detected
                </span>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Status Card --}}
            <div class="lg:col-span-1 space-y-4 opacity-0 translate-y-4 notif-stagger">
                <div class="glass-panel rounded-3xl p-6 border border-white/5 bg-white/[0.02]">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-500 mb-4 border border-purple-500/20">
                        <i data-lucide="activity" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-white font-bold text-sm mb-1 uppercase tracking-wider">Stream Status</h3>
                    <p class="text-gray-500 text-[11px] font-medium leading-relaxed mb-4">Neural node connection is active and monitoring signal patterns.</p>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-gray-400">Connection</span>
                            <span class="text-emerald-500 font-bold uppercase tracking-widest">Stable</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px]">
                            <span class="text-gray-400">Latency</span>
                            <span class="text-purple-500 font-bold uppercase tracking-widest">14ms</span>
                        </div>
                    </div>
                </div>

                <div class="glass-panel rounded-3xl p-6 border border-white/5 bg-white/[0.02]">
                    <h3 class="text-white font-bold text-xs mb-4 uppercase tracking-widest flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-purple-500"></i>
                        Security Log
                    </h3>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-1 h-8 rounded-full bg-emerald-500/40"></div>
                            <div>
                                <p class="text-white text-[10px] font-bold">Protocol Sync</p>
                                <p class="text-gray-500 text-[9px]">Authentication verified</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-1 h-8 rounded-full bg-purple-500/40"></div>
                            <div>
                                <p class="text-white text-[10px] font-bold">Neural Link</p>
                                <p class="text-gray-500 text-[9px]">Encryption encrypted</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notifications List --}}
            <div class="lg:col-span-3 space-y-4">
                @if(!$isPremium)
                <div class="glass-panel rounded-[2.5rem] p-16 text-center border border-white/5 bg-white/[0.03] opacity-0 translate-y-4 notif-stagger">
                    <div class="relative inline-block mb-8">
                        <div class="absolute inset-0 bg-amber-500/20 blur-3xl rounded-full"></div>
                        <div class="relative w-24 h-24 rounded-[2rem] bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 mx-auto">
                            <i data-lucide="lock" class="w-10 h-10"></i>
                        </div>
                    </div>
                    <h3 class="text-3xl font-black text-white uppercase tracking-tight mb-4">Protocol Restricted</h3>
                    <p class="text-gray-400 text-sm max-w-sm mx-auto mb-10 leading-relaxed font-medium uppercase tracking-tight">The Neural Notification Stream is exclusive to Premium Elite Nodes. Upgrade to initialize the high-frequency connection.</p>
                    <a href="{{ route('pricing') }}" class="inline-flex items-center gap-3 px-10 py-5 rounded-2xl bg-amber-500 text-black font-black text-xs uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl shadow-amber-500/20">
                        <i data-lucide="zap" class="w-4 h-4"></i> Upgrade Neural Access
                    </a>
                </div>
                @elseif($notifications->isEmpty())
                <div class="glass-panel rounded-[2.5rem] p-16 text-center border border-white/5 bg-white/[0.03] opacity-0 translate-y-4 notif-stagger">
                    <div class="relative inline-block mb-6">
                        <div class="absolute inset-0 bg-purple-500/10 blur-3xl rounded-full"></div>
                        <div class="relative w-20 h-20 rounded-[1.8rem] bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-500 mx-auto">
                            <i data-lucide="inbox" class="w-8 h-8"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-3">Matrix Clear</h3>
                    <p class="text-gray-500 text-[11px] font-bold uppercase tracking-widest">No neural signals detected in the current stream.</p>
                </div>
                @else
                    @foreach($notifications as $notification)
                    <div class="glass-panel rounded-3xl p-6 border border-white/5 bg-white/[0.02] hover:border-purple-500/30 hover:bg-white/[0.04] transition-all group relative overflow-hidden opacity-0 translate-y-4 notif-stagger">
                        {{-- Border Accent --}}
                        <div class="absolute inset-y-0 left-0 w-1 {{ $notification->type === 'danger' ? 'bg-rose-500/60' : ($notification->type === 'success' ? 'bg-emerald-500/60' : 'bg-purple-500/60') }}"></div>
                        
                        <div class="flex gap-6">
                            <div class="w-14 h-14 rounded-2xl flex-shrink-0 {{ $notification->type === 'danger' ? 'bg-rose-500/10 text-rose-500 border-rose-500/20' : ($notification->type === 'success' ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-purple-500/10 text-purple-500 border-purple-500/20') }} border flex items-center justify-center shadow-lg transition-transform group-hover:scale-105">
                                <i data-lucide="{{ $notification->icon ?? 'bell' }}" class="w-7 h-7"></i>
                            </div>
                            
                            <div class="flex-1 pt-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-black text-white uppercase tracking-wider">{{ $notification->title }}</h4>
                                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest bg-white/5 px-2.5 py-1 rounded-md border border-white/5">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed font-medium">{{ $notification->message }}</p>
                            </div>
                        </div>

                        {{-- Mark as read button (Optional UX Enhancement) --}}
                        @if(!$notification->read_at)
                        <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="w-2 h-2 rounded-full bg-purple-500 shadow-[0_0_10px_rgba(168,85,247,0.5)]"></span>
                        </div>
                        @endif
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .glass-panel {
        backdrop-filter: blur(10px);
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation sequence
        gsap.to('#notif-header', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            ease: "power3.out"
        });

        gsap.to('.notif-stagger', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: "power3.out",
            delay: 0.2
        });
    });
</script>
@endpush
@endsection

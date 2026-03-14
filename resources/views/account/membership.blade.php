@extends('layouts.app')

@section('title', 'My Subscription | Emperor Stock Predictor')

@section('content')
<main class="relative min-h-screen pt-10 pb-20 px-6 font-bold uppercase italic">
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute top-1/4 left-0 w-[500px] h-[500px] bg-purple-600/5 blur-[120px] rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        <div class="mb-12 fade-in-up">
            <h1 class="text-4xl font-black font-whiskey text-white mb-2 tracking-tighter italic">Account Status</h1>
            <p class="text-gray-400 font-normal not-italic capitalize">Manage your plan and view your trading access.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-2 fade-in-up">
                <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 font-bold text-sm hover:bg-white/5 transition-all group">
                    <i data-lucide="user" class="w-5 h-5 group-hover:scale-110 transition-transform"></i> General
                </a>
                <a href="{{ route('account.membership') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-bold text-sm transition-all group">
                    <i data-lucide="credit-card" class="w-5 h-5 text-purple-500 group-hover:scale-110 transition-transform"></i> Membership
                </a>
                <a href="{{ route('account.notifications') }}" class="flex items-center gap-3 px-6 py-4 rounded-2xl text-gray-400 font-bold text-sm hover:bg-white/5 transition-all group">
                    <i data-lucide="bell" class="w-5 h-5 group-hover:scale-110 transition-transform"></i> Notifications
                </a>
            </div>

            <div class="md:col-span-2 space-y-8 fade-in-up">
                <div class="glass-panel rounded-3xl p-8 border border-white/5 relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <label class="block text-[10px] font-black font-whiskey text-gray-500 tracking-widest mb-2">Current Active Node</label>
                                <h3 class="text-3xl font-black font-whiskey text-white tracking-tighter">{{ ($user->role === 'premium' || $user->role === 'admin') ? 'PREMIUM KING' : 'FREE EXPLORER' }}</h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-500">
                                <i data-lucide="{{ ($user->role === 'premium' || $user->role === 'admin') ? 'crown' : 'zap' }}" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-purple-500"></i>
                                {{ ($user->role === 'premium' || $user->role === 'admin') ? 'Unlimited High-Accuracy Signals' : 'Daily Free Trading Signals' }}
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-purple-500"></i>
                                {{ ($user->role === 'premium' || $user->role === 'admin') ? 'AI Predictions Active' : 'Standard Market Analysis' }}
                            </div>
                        </div>

                        @if($user->role !== 'premium' && $user->role !== 'admin')
                            <a href="{{ url('/pricing') }}" class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-black font-whiskey text-sm hover:scale-[1.02] transition-all">
                                Update Access Node
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </a>
                        @else
                            <div class="flex items-center gap-4">
                                <span class="text-xs text-gray-500 italic">Renewal Sync: March 28, 2026</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

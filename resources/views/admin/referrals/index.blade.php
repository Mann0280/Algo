@extends('layouts.admin')

@section('title', 'Referral Network')

@section('content')
<div class="space-y-12 max-w-[1200px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-glow-indigo">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">AFFILIATE PROGRAM</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                REFERRAL <span class="text-purple-500 text-glow">HISTORY</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Monitor user referrals and affiliate rewards</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse shadow-[0_0_10px_#6366f1]"></span>
                <span class="text-[10px] font-semibold font-whiskey text-indigo-400 uppercase tracking-widest text-glow-sm">PROGRAM ACTIVE</span>
            </div>
        </div>
    </div>

    <!-- Referrals Table Container -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Date & Time</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Referrer</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Referred User</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Reward</th>
                        <th class="px-10 py-8 text-right text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($referrals as $referral)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-semibold font-whiskey text-white italic tracking-widest uppercase">{{ $referral->created_at->format('d M Y') }}</span>
                                <span class="text-[8px] font-bold text-gray-700 uppercase tracking-widest mt-1">{{ $referral->created_at->format('H:i') }} UTC</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-600/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 font-black font-whiskey text-xs shadow-[0_0_15px_rgba(99,102,241,0.1)] group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($referral->referrer->username, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black font-whiskey text-white italic group-hover:text-indigo-400 transition-colors uppercase tracking-tight">{{ $referral->referrer->username }}</span>
                                    <span class="text-[8px] font-bold text-gray-600 uppercase tracking-widest mt-0.5">Source Account</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-400 font-black font-whiskey text-xs shadow-[0_0_15px_rgba(147,51,234,0.1)] group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($referral->referredUser->username, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black font-whiskey text-white italic group-hover:text-purple-400 transition-colors uppercase tracking-tight">{{ $referral->referredUser->username }}</span>
                                    <span class="text-[8px] font-bold text-gray-600 uppercase tracking-widest mt-0.5">New Account</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-lg font-black font-whiskey text-emerald-400 italic">₹{{ number_format($referral->reward_amount, 2) }}</span>
                                <span class="text-[8px] font-bold text-emerald-500/40 uppercase tracking-widest mt-0.5">Commission</span>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                             @if($referral->status === 'rewarded')
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
                                <span class="text-[9px] font-semibold font-whiskey text-emerald-500 uppercase tracking-widest">REWARDED</span>
                            </div>
                            @else
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_#f59e0b]"></span>
                                <span class="text-[9px] font-semibold font-whiskey text-amber-500 uppercase tracking-widest leading-none mt-0.5">PENDING</span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center gap-6 opacity-20">
                                <div class="w-20 h-20 rounded-[2.5rem] bg-white/5 border border-white/10 flex items-center justify-center">
                                    <i data-lucide="share-2" class="w-10 h-10 text-white"></i>
                                </div>
                                <span class="text-[10px] font-semibold font-whiskey uppercase tracking-widest text-white">No Referrals Found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($referrals->hasPages())
        <div class="px-10 py-8 border-t border-white/5 bg-white/[0.01]">
            {{ $referrals->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

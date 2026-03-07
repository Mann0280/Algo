@extends('layouts.admin')

@section('title', 'Referral Management | Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="orbitron text-2xl font-black text-white italic uppercase tracking-tight">Referral <span class="text-purple-500">Protocol Monitoring</span></h1>
            <p class="text-gray-500 text-xs font-bold orbitron uppercase tracking-widest mt-1">Global Network Growth & Rewards Audit</p>
        </div>
    </div>

    <div class="glass-panel rounded-[2rem] border border-white/10 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-white/5 border-b border-white/10 text-[9px] font-black orbitron text-gray-400 uppercase tracking-widest">
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Referrer</th>
                    <th class="px-6 py-4">Referred User</th>
                    <th class="px-6 py-4">Reward Amount</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.05]">
                @foreach($referrals as $referral)
                <tr class="hover:bg-white/[0.02] transition-all">
                    <td class="px-6 py-4 text-[10px] text-gray-500 font-bold orbitron">{{ $referral->created_at->format('d M, H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-[10px] font-black orbitron text-indigo-400 border border-indigo-500/20">
                                {{ strtoupper(substr($referral->referrer->username, 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-white">{{ $referral->referrer->username }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-[10px] font-black orbitron text-purple-400 border border-purple-500/20">
                                {{ strtoupper(substr($referral->referredUser->username, 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-white">{{ $referral->referredUser->username }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-black orbitron text-emerald-400">&#8377;{{ number_format($referral->reward_amount, 2) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($referral->status === 'rewarded')
                        <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[7px] font-black orbitron text-emerald-500 uppercase tracking-widest">REWARDED</span>
                        @else
                        <span class="px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-[7px] font-black orbitron text-amber-500 uppercase tracking-widest transition-pulse animate-pulse">PENDING ACTIVATION</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-6 border-t border-white/10">
            {{ $referrals->links() }}
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Refer & Earn | Emperor Stock Predictor')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white orbitron italic tracking-tighter">REFER & <span class="text-purple-500">EARN</span></h2>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest font-bold">Network Growth Protocol</p>
        </div>
        <div class="flex items-center gap-3 px-6 py-3 bg-white/[0.02] border border-white/[0.05] rounded-2xl">
            <span class="text-[10px] font-black orbitron text-gray-400 uppercase tracking-widest">Your Code:</span>
            <span class="text-lg font-black orbitron text-white tracking-widest">{{ $user->referral_code }}</span>
        </div>
    </div>

    <!-- Referral Link & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Referral Link Card -->
        <div class="lg:col-span-2 glass-panel rounded-[2.5rem] p-8 sm:p-10 border-white/[0.05] relative overflow-hidden group flex flex-col justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/[0.03] to-transparent"></div>
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-white mb-6">Invite your network and earn massive rewards.</h3>
                <div class="p-2 bg-black/40 rounded-3xl border border-white/10 flex flex-col sm:flex-row items-center gap-4 transition-all focus-within:border-purple-500/50 shadow-2xl">
                    <div class="flex-1 px-4 py-2 text-indigo-400 text-sm font-medium w-full break-all">
                        {{ $referralLink }}
                    </div>
                    <button id="copy-link-btn" class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] transition-all hover:scale-[1.03] shadow-lg">
                        Copy Link
                    </button>
                </div>
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Plan Rewards</span>
                        <span class="text-xs font-bold text-emerald-400 mt-1">Up to ₹5000 / Invite</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Payouts</span>
                        <span class="text-xs font-bold text-indigo-400 mt-1">Direct to Wallet</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Limit</span>
                        <span class="text-xs font-bold text-white mt-1">Unlimited Earnings</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mini Stats -->
        <div class="flex flex-col gap-6">
            <div class="flex-1 glass-panel rounded-[2rem] p-8 border-white/[0.05] flex flex-col justify-between">
                <div>
                    <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Total Refers</label>
                    <p class="text-4xl font-black text-white orbitron mt-1">{{ number_format($stats['total_referrals']) }}</p>
                </div>
                <div class="mt-6 flex items-center justify-between text-[11px] font-bold">
                    <span class="text-gray-500 uppercase tracking-widest">Success Rate</span>
                    <span class="text-emerald-500">
                        @if($stats['total_referrals'] > 0)
                            {{ number_format(($stats['successful_purchases'] / $stats['total_referrals']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
            </div>
            <div class="flex-1 glass-panel rounded-[2rem] p-8 border-white/[0.05] flex flex-col justify-between">
                <div>
                    <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Total Earnings</label>
                    <p class="text-4xl font-black text-purple-500 orbitron mt-1">₹{{ number_format($stats['total_earnings'], 2) }}</p>
                </div>
                <div class="mt-6 flex items-center justify-between text-[11px] font-bold">
                    <span class="text-gray-500 uppercase tracking-widest">Processed</span>
                    <span class="text-indigo-500">{{ number_format($stats['successful_purchases']) }} Nodes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral List -->
    <div class="glass-panel rounded-[2.5rem] border-white/[0.05] overflow-hidden">
        <div class="px-8 py-6 border-b border-white/[0.05] flex items-center justify-between">
            <h3 class="text-lg font-bold text-white tracking-wide uppercase text-[12px] orbitron italic flex items-center gap-3">
                <i data-lucide="users" class="w-5 h-5 text-purple-500"></i>
                Network Connections
            </h3>
        </div>
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] bg-white/[0.01]">
                        <th class="px-8 py-5">Connection</th>
                        <th class="px-8 py-5">Joined</th>
                        <th class="px-8 py-5">Upgrade Status</th>
                        <th class="px-8 py-5">Plan</th>
                        <th class="px-8 py-5 text-right">Commission</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @forelse($referrals as $ref)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600/20 to-purple-600/20 flex items-center justify-center text-xs font-black text-indigo-400 orbitron italic">
                                    {{ strtoupper(substr($ref->referredUser->username, 0, 1)) }}
                                </div>
                                <span class="text-sm font-bold text-white">{{ $ref->referredUser->username }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-medium text-gray-400">
                            {{ $ref->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-5">
                            @if($ref->status === 'rewarded')
                                <span class="px-3 py-1 rounded-lg bg-emerald-500/10 text-emerald-500 text-[9px] font-black orbitron uppercase tracking-widest border border-emerald-500/20">Success</span>
                            @elseif($ref->status === 'pending')
                                <span class="px-3 py-1 rounded-lg bg-amber-500/10 text-amber-500 text-[9px] font-black orbitron uppercase tracking-widest border border-amber-500/20">Pending Purchase</span>
                            @else
                                <span class="px-3 py-1 rounded-lg bg-rose-500/10 text-rose-500 text-[9px] font-black orbitron uppercase tracking-widest border border-rose-500/20">Rejected</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-400 font-medium">
                            {{ $ref->plan_name ?: 'Waiting...' }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <span class="text-sm font-black orbitron tabular-nums {{ $ref->reward_amount > 0 ? 'text-emerald-500' : 'text-gray-600' }}">
                                +₹{{ number_format($ref->reward_amount, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <i data-lucide="users" class="w-12 h-12 text-gray-700 opacity-30"></i>
                                <p class="text-sm font-bold text-gray-600 orbitron uppercase tracking-[0.2em]">Zero network connections detected</p>
                                <p class="text-xs text-gray-500 max-w-xs mx-auto">Start sharing your referral link with traders and friends to unlock massive bonus commissions.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($referrals->hasPages())
        <div class="px-8 py-6 border-t border-white/[0.05]">
            {{ $referrals->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const copyBtn = document.getElementById('copy-link-btn');
        const linkText = "{{ $referralLink }}";

        copyBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(linkText).then(() => {
                const originalText = copyBtn.innerText;
                copyBtn.innerText = 'COPIED!';
                copyBtn.classList.replace('from-purple-600', 'from-emerald-600');
                
                setTimeout(() => {
                    copyBtn.innerText = originalText;
                    copyBtn.classList.replace('from-emerald-600', 'from-purple-600');
                }, 2000);
            });
        });
    });
</script>
@endsection

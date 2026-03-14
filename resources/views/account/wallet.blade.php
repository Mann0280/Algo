@extends('layouts.dashboard')

@section('title', 'Neural Wallet | Emperor Stock Predictor')

@section('content')
<div class="space-y-10">
    <!-- Header/Quick Stats -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white font-whiskey italic tracking-tighter">NEURAL <span class="text-purple-500">WALLET</span></h2>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest font-bold">Financial Protocol Dashboard</p>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('account.withdraw') }}" class="px-8 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black font-whiskey uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all">
                Request Withdrawal
            </a>
        </div>
    </div>

    <!-- Balance Card -->
    <div class="glass-panel rounded-[2.5rem] p-8 border-white/[0.05] relative overflow-hidden group">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-purple-600/10 blur-[80px] rounded-full group-hover:bg-purple-600/20 transition-all duration-1000"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <label class="text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-[0.3em]">Total Wallet Balance</label>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl font-bold text-purple-500">₹</span>
                    <h3 class="text-6xl font-black text-white font-whiskey tracking-tighter tabular-nums">{{ number_format($user->wallet_balance, 2) }}</h3>
                </div>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-emerald-500/5 border border-emerald-500/10 rounded-xl h-fit">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold text-emerald-500 font-whiskey">SECURE ASSETS</span>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Full Width Row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Earnings -->
        <div class="glass-panel rounded-[2rem] p-6 border-white/[0.05] flex flex-col justify-between group hover:border-purple-500/30 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="trending-up" class="w-5 h-5 text-purple-500"></i>
            </div>
            <div class="mt-4">
                <p class="text-[8px] font-black font-whiskey text-gray-500 uppercase tracking-widest">Total Earned</p>
                <p class="text-xl font-bold text-white mt-1 tabular-nums">₹{{ number_format($stats['total_earnings'], 2) }}</p>
            </div>
        </div>
        <!-- Total Withdrawn -->
        <div class="glass-panel rounded-[2rem] p-6 border-white/[0.05] flex flex-col justify-between group hover:border-indigo-500/30 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="external-link" class="w-5 h-5 text-indigo-500"></i>
            </div>
            <div class="mt-4">
                <p class="text-[8px] font-black font-whiskey text-gray-500 uppercase tracking-widest">Withdrawn</p>
                <p class="text-xl font-bold text-white mt-1 tabular-nums">₹{{ number_format($stats['total_withdrawn'], 2) }}</p>
            </div>
        </div>
        <!-- Available for Withdraw -->
        <div class="glass-panel rounded-[2rem] p-6 border-white/[0.05] flex flex-col justify-between group hover:border-emerald-500/30 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            </div>
            <div class="mt-4">
                <p class="text-[8px] font-black font-whiskey text-gray-500 uppercase tracking-widest">Available</p>
                <p class="text-xl font-bold text-emerald-500 mt-1 tabular-nums">₹{{ number_format($stats['available_balance'], 2) }}</p>
            </div>
        </div>
        <!-- Pending Withdrawals -->
        <div class="glass-panel rounded-[2rem] p-6 border-white/[0.05] flex flex-col justify-between group hover:border-amber-500/30 transition-all duration-500">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
            </div>
            <div class="mt-4">
                <p class="text-[8px] font-black font-whiskey text-gray-500 uppercase tracking-widest">Pending</p>
                <p class="text-xl font-bold text-amber-500 mt-1 tabular-nums">₹{{ number_format($stats['pending_withdraw'], 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="glass-panel rounded-[2.5rem] border-white/[0.05] overflow-hidden">
        <div class="px-8 py-6 border-b border-white/[0.05] flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i data-lucide="history" class="w-5 h-5 text-purple-500"></i>
                <h3 class="text-lg font-bold text-white tracking-wide uppercase text-[12px] font-whiskey">Transaction Records</h3>
            </div>
        </div>
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[9px] font-black font-whiskey text-gray-500 uppercase tracking-[0.2em] bg-white/[0.01]">
                        <th class="px-8 py-5">Date</th>
                        <th class="px-8 py-5">Type</th>
                        <th class="px-8 py-5">Amount</th>
                        <th class="px-8 py-5">Description</th>
                        <th class="px-8 py-5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.03]">
                    @forelse($transactions as $tx)
                    <tr class="group hover:bg-white/[0.02] transition-colors">
                        <td class="px-8 py-5 text-sm font-medium text-gray-400">
                            {{ $tx->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-8 py-5">
                            @if($tx->type === 'credit')
                                <span class="flex items-center gap-2 text-emerald-500 text-xs font-bold uppercase font-whiskey italic tracking-widest">
                                    <i data-lucide="arrow-down-left" class="w-3.5 h-3.5"></i> Credit
                                </span>
                            @elseif($tx->type === 'debit')
                                <span class="flex items-center gap-2 text-rose-500 text-xs font-bold uppercase font-whiskey italic tracking-widest">
                                    <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i> Debit
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-amber-500 text-xs font-bold uppercase font-whiskey italic tracking-widest">
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Withdraw
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-sm font-black font-whiskey tabular-nums {{ $tx->type === 'credit' ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-300 font-medium">
                            {{ $tx->description }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black font-whiskey uppercase tracking-widest 
                                {{ $tx->status === 'success' || $tx->status === 'approved' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 
                                   ($tx->status === 'pending' ? 'bg-amber-500/10 text-amber-500 border border-amber-500/20' : 
                                   'bg-rose-500/10 text-rose-500 border border-rose-500/20') }}">
                                {{ $tx->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <i data-lucide="database" class="w-12 h-12 text-gray-700 opacity-30"></i>
                                <p class="text-sm font-bold text-gray-600 font-whiskey uppercase tracking-[0.2em]">No financial activity logged yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-8 py-6 border-t border-white/[0.05]">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

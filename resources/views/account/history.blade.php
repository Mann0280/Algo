@extends('layouts.dashboard')

@section('title', 'Link History | Emperor Stock Predictor')

@section('content')
<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-black orbitron uppercase italic tracking-wider text-white">Link History</h2>
            <p class="text-[11px] font-bold orbitron text-gray-500 uppercase tracking-[0.3em] mt-1">Temporal Subscription Logs • Protocol v4.2</p>
        </div>
        <div class="px-6 py-3 rounded-2xl bg-purple-500/5 border border-purple-500/10 flex items-center gap-4">
            <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_#9333ea]"></div>
            <span class="text-[10px] font-black orbitron text-purple-400 uppercase tracking-widest">Neural Sync Active</span>
        </div>
    </div>

    <!-- History Table Container -->
    <div class="glass-panel rounded-[2.5rem] border-white/[0.05] overflow-hidden">
        <div class="p-8 border-b border-white/[0.05] bg-white/[0.01] flex items-center justify-between">
            <div class="flex items-center gap-4">
                <i data-lucide="database" class="w-5 h-5 text-gray-500"></i>
                <h3 class="text-sm font-black orbitron text-gray-400 uppercase tracking-widest">Transaction Records</h3>
            </div>
            <div class="text-[10px] font-bold orbitron text-gray-600 uppercase tracking-widest">
                Showing {{ $history->count() }} entry(s)
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02]">
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Purchase Date</th>
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Protocol Plan</th>
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Amount</th>
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Termination</th>
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.02]">
                    @forelse($history as $record)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-white mb-1">{{ $record->purchased_at->format('d M Y') }}</span>
                                <span class="text-[10px] font-mono text-gray-600 uppercase tracking-tighter">{{ $record->purchased_at->format('H:i:s') }} UTC</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                                    <i data-lucide="zap" class="w-4 h-4 text-indigo-400"></i>
                                </div>
                                <span class="text-sm font-black orbitron text-white italic group-hover:text-indigo-400 transition-colors uppercase">{{ $record->plan_name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold orbitron text-white">₹{{ number_format($record->amount, 0) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-xs font-bold orbitron {{ $record->expires_at && $record->expires_at->isPast() ? 'text-gray-600' : 'text-emerald-500' }}">
                                {{ $record->expires_at ? $record->expires_at->format('d M Y') : 'UNLIMITED' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black orbitron uppercase tracking-widest {{ $record->status === 'Completed' ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-500' : 'bg-rose-500/10 border border-rose-500/20 text-rose-500' }}">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <button class="p-2.5 rounded-xl bg-white/[0.05] border border-white/[0.05] text-gray-500 hover:text-white hover:bg-purple-600/20 hover:border-purple-500/30 transition-all">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4 opacity-30">
                                <i data-lucide="ghost" class="w-12 h-12"></i>
                                <span class="text-[11px] font-black orbitron uppercase tracking-[0.3em]">No Temporal Records Identified</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Information Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-panel p-10 rounded-[2.5rem] border-white/[0.05] flex items-center gap-8">
            <div class="w-20 h-20 rounded-3xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center flex-shrink-0 animate-pulse">
                <i data-lucide="shield-alert" class="w-10 h-10 text-amber-500"></i>
            </div>
            <div>
                <h4 class="text-xl font-black orbitron text-white uppercase italic tracking-tight">Security Protocol Advisory</h4>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Transaction records are immutable once confirmed by the neural network. If you identify a synchronization error in your temporal logs, please initiate a support ticket immediately for manual verification.
                </p>
            </div>
        </div>
        
        <div class="glass-panel p-10 rounded-[2.5rem] border-white/[0.05] flex flex-col justify-center items-center text-center group">
            <p class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest">Total Investment</p>
            <p class="text-4xl font-black orbitron text-white mt-1 group-hover:text-purple-500 transition-colors">
                ₹{{ number_format($history->where('status', 'Completed')->sum('amount'), 0) }}
            </p>
        </div>
    </div>
</div>
@endsection

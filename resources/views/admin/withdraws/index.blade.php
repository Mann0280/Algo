@extends('layouts.admin')

@section('title', 'WITHDRAWAL PROTOCOL AUDIT')

@section('content')
<div class="space-y-12 max-w-[1400px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-glow-indigo">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-amber-500"></span>
                <span class="text-[10px] font-black orbitron text-amber-500 uppercase tracking-[0.3em]">FINANCIAL PAYOUT AUDIT</span>
            </div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                WITHDRAW <span class="text-amber-500 text-glow">REQUESTS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Verifying and Processing High-Value Payout Sequences</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse shadow-[0_0_10px_#f59e0b]"></span>
                <span class="text-[10px] font-black orbitron text-amber-400 uppercase tracking-widest text-glow-sm">PROCESSING ACTIVE</span>
            </div>
        </div>
    </div>

    <!-- Requests Table Container -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-8 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Trace</th>
                        <th class="px-8 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Node Origin</th>
                        <th class="px-8 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Value (INR)</th>
                        <th class="px-8 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Bank Topology</th>
                        <th class="px-8 py-8 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Action Protocol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($requests as $request)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-8 py-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black orbitron text-white italic tracking-widest uppercase">{{ $request->created_at->format('d M Y') }}</span>
                                <span class="text-[8px] font-bold text-gray-700 uppercase tracking-[0.2em] mt-1">{{ $request->created_at->format('H:i') }} UTC</span>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-600/10 border border-amber-500/20 flex items-center justify-center text-amber-400 font-black orbitron text-xs shadow-[0_0_15px_rgba(245,158,11,0.1)] group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($request->user->username, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black orbitron text-white italic group-hover:text-amber-400 transition-colors uppercase tracking-tight">{{ $request->user->username }}</span>
                                    <span class="text-[8px] font-bold text-gray-600 uppercase tracking-widest mt-0.5">Wallet: ₹{{ number_format($request->user->wallet_balance, 2) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <span class="text-xl font-black orbitron text-white italic tracking-tighter">₹{{ number_format($request->amount, 2) }}</span>
                        </td>
                        <td class="px-8 py-8">
                            <div class="grid grid-cols-2 gap-x-8 gap-y-2">
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-black orbitron text-gray-600 uppercase tracking-widest">Bank</span>
                                    <span class="text-[11px] font-bold text-gray-300">{{ $request->bank_name }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-black orbitron text-gray-600 uppercase tracking-widest">IFSC</span>
                                    <span class="text-[11px] font-bold text-gray-300 uppercase">{{ $request->ifsc_code }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-black orbitron text-gray-600 uppercase tracking-widest">A/C No.</span>
                                    <span class="text-[11px] font-bold text-gray-300 font-mono">{{ $request->account_number }}</span>
                                </div>
                                @if($request->upi_id)
                                <div class="flex flex-col">
                                    <span class="text-[8px] font-black orbitron text-gray-600 uppercase tracking-widest">UPI ID</span>
                                    <span class="text-[11px] font-bold text-amber-500/80">{{ $request->upi_id }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-8 text-right">
                            @if($request->status === 'pending')
                            <div class="flex items-center justify-end gap-3">
                                <form action="{{ route('admin.withdraw-requests.approve', $request) }}" method="POST" onsubmit="return confirm('Execute financial payout and deduct user wallet?')">
                                    @csrf
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-[9px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em] hover:bg-emerald-500 hover:text-white transition-all shadow-lg hover:shadow-emerald-500/20">
                                        AUTHORIZE
                                    </button>
                                </form>
                                <form action="{{ route('admin.withdraw-requests.reject', $request) }}" method="POST" onsubmit="return confirm('Reject this withdrawal request?')">
                                    @csrf
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-[9px] font-black orbitron text-rose-500 uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all">
                                        REJECT
                                    </button>
                                </form>
                            </div>
                            @elseif($request->status === 'approved')
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span>
                                <span class="text-[9px] font-black orbitron text-emerald-500 uppercase tracking-widest">DISBURSED</span>
                            </div>
                            @else
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shadow-[0_0_8px_#f43f5e]"></span>
                                <span class="text-[9px] font-black orbitron text-rose-500 uppercase tracking-widest">REJECTED</span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center gap-6 opacity-20">
                                <div class="w-20 h-20 rounded-[2.5rem] bg-white/5 border border-white/10 flex items-center justify-center">
                                    <i data-lucide="external-link" class="w-10 h-10 text-white"></i>
                                </div>
                                <span class="text-[10px] font-black orbitron uppercase tracking-[0.4em] text-white">No Pending Payout Sequence Detected</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($requests->hasPages())
        <div class="px-10 py-8 border-t border-white/5 bg-white/[0.01]">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'PAYMENT MATRIX')

@section('content')
<div class="space-y-12 max-w-[1400px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black orbitron text-purple-500 uppercase tracking-[0.3em]">FINANCIAL VERIFICATION GATEWAY</span>
            </div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                PAYMENT <span class="text-purple-500 text-glow">REQUISITIONS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Manual Synchronization of Neural Credit Inflow</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_#a855f7]"></span>
                <span class="text-[10px] font-black orbitron text-purple-400 uppercase tracking-widest text-glow-sm">LEDGER SYNCED</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] orbitron font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="glass-panel border-rose-500/20 bg-rose-500/5 text-rose-400 p-5 rounded-2xl text-[10px] orbitron font-black uppercase tracking-[0.2em] text-center">
        <i data-lucide="alert-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('error') }}
    </div>
    @endif

    <!-- TABBED NAVIGATION -->
    <div class="flex flex-wrap items-center gap-4 md:gap-8 border-b border-white/5 pb-8">
        <button onclick="switchAdminTab('premium')" id="tab-btn-premium" class="admin-tab-btn active group flex items-center gap-3 px-6 py-3 rounded-2xl transition-all duration-500 border border-transparent">
            <i data-lucide="zap" class="w-4 h-4 opacity-50 group-[.active]:opacity-100 group-[.active]:text-purple-500 transition-all"></i>
            <span class="text-[10px] font-black orbitron uppercase tracking-[0.2em] italic transition-all text-gray-500 group-[.active]:text-white">Premium Sync</span>
        </button>
        <button onclick="switchAdminTab('upgrades')" id="tab-btn-upgrades" class="admin-tab-btn group flex items-center gap-3 px-6 py-3 rounded-2xl transition-all duration-500 border border-transparent">
            <i data-lucide="trending-up" class="w-4 h-4 opacity-50 group-[.active]:opacity-100 group-[.active]:text-purple-500 transition-all"></i>
            <span class="text-[10px] font-black orbitron uppercase tracking-[0.2em] italic transition-all text-gray-500 group-[.active]:text-white">P2P Upgrades</span>
        </button>
        <button onclick="switchAdminTab('wallet')" id="tab-btn-wallet" class="admin-tab-btn group flex items-center gap-3 px-6 py-3 rounded-2xl transition-all duration-500 border border-transparent">
            <i data-lucide="wallet" class="w-4 h-4 opacity-50 group-[.active]:opacity-100 group-[.active]:text-purple-500 transition-all"></i>
            <span class="text-[10px] font-black orbitron uppercase tracking-[0.2em] italic transition-all text-gray-500 group-[.active]:text-white">Wallet Ingress</span>
        </button>
    </div>

    <!-- PREMIUM REQUISITIONS TABLE -->
    <div id="admin-tab-premium" class="admin-tab-content active glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl animate-in fade-in duration-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Initiator / Tier</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Value</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Verification Trace</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Protocol Status</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Timestamp</th>
                        <th class="px-10 py-8 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Overrides</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($payments as $payment)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform duration-500">
                                    <i data-lucide="user" class="w-6 h-6"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black orbitron text-white italic group-hover:text-purple-400 transition-colors uppercase tracking-tight">{{ $payment->user->username ?? 'Unknown' }}</span>
                                    <span class="text-[9px] font-bold text-gray-600 mt-1 uppercase tracking-widest">{{ $payment->package->name ?? 'DELETED_PROTOCOL' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-lg font-black orbitron text-white italic">₹{{ number_format($payment->amount, 0) }}</span>
                                <span class="text-[9px] font-bold text-emerald-500/40 uppercase tracking-widest mt-0.5 italic">Credit Inbound</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-[#0c0518] border border-white/5 rounded-xl text-[10px] font-mono text-gray-400 italic">
                                    {{ $payment->transaction_id }}
                                </span>
                                @if($payment->screenshot)
                                <button onclick="viewProof('{{ asset('storage/' . $payment->screenshot) }}')" class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center hover:bg-emerald-500/20 transition-all group/btn">
                                    <i data-lucide="image" class="w-4 h-4 group-hover/btn:scale-110 transition-transform"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            @php
                                $statusMap = [
                                    'pending' => 'text-amber-400 border-amber-500/20 bg-amber-500/5',
                                    'approved' => 'text-emerald-400 border-emerald-500/20 bg-emerald-500/5',
                                    'rejected' => 'text-rose-400 border-rose-500/20 bg-rose-500/5',
                                ];
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black orbitron uppercase tracking-[0.2em] {{ $statusMap[$payment->status] ?? 'text-white border-white/10' }} border">
                                    {{ $payment->status }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black orbitron text-gray-400 uppercase tracking-widest italic">{{ $payment->created_at->format('d M Y') }}</span>
                                <span class="text-[8px] font-bold text-gray-700 uppercase tracking-[0.2em] mt-1">{{ $payment->created_at->format('H:i') }} UTC</span>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex justify-end gap-3">
                                @if($payment->status === 'pending')
                                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Authorize this premium activation?')" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-black text-[9px] orbitron uppercase tracking-widest transition-all shadow-lg shadow-purple-900/20">
                                        Authorize
                                    </button>
                                </form>
                                <button onclick="openRejectModal({{ $payment->id }}, 'premium')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-600 hover:text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/20 transition-all flex items-center justify-center">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                </button>
                                @else
                                    <span class="text-[8px] font-black orbitron text-gray-800 uppercase tracking-[0.4em] italic">ARCHIVED_LOG</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center gap-6 opacity-20">
                                <div class="w-20 h-20 rounded-[2rem] bg-white/5 border border-white/10 flex items-center justify-center">
                                    <i data-lucide="shield-alert" class="w-10 h-10"></i>
                                </div>
                                <span class="text-[10px] font-black orbitron uppercase tracking-[0.4em]">Zero Pending Requisitions Detected</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Other tabs will follow same structure logic handled by minimalist JS as before -->
    <div id="admin-tab-upgrades" class="admin-tab-content hidden glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl animate-in fade-in duration-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">User / Target Plan</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Differential Value</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">UTR Number</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Status</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Timestamp</th>
                        <th class="px-10 py-8 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($upgradeRequests as $req)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500/10 to-orange-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                                    <i data-lucide="arrow-up-circle" class="w-6 h-6"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black orbitron text-white italic group-hover:text-amber-500 transition-colors uppercase tracking-tight">{{ $req->user->username ?? 'Unknown' }}</span>
                                    <span class="text-[9px] font-bold text-gray-600 mt-1 uppercase tracking-widest">{{ $req->plan_name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8 font-black orbitron text-white text-lg italic">
                            ₹{{ number_format($req->amount, 0) }}
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-[#0c0518] border border-white/5 rounded-xl text-[10px] font-mono text-gray-400">
                                    {{ $req->utr_number }}
                                </span>
                                @if($req->payment_screenshot)
                                <button onclick="viewProof('{{ asset('storage/' . $req->payment_screenshot) }}')" class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center hover:bg-emerald-500/20 transition-all">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-8">
                             <span class="px-4 py-1.5 rounded-full text-[9px] font-black orbitron uppercase tracking-[0.2em] {{ $statusMap[$req->status] ?? 'text-white border-white/10' }} border">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td class="px-10 py-8 italic text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                            {{ $req->created_at->format('d M Y') }}
                        </td>
                        <td class="px-10 py-8 text-right">
                            @if($req->status === 'pending')
                            <div class="flex justify-end gap-3">
                                <form action="{{ route('admin.payments.upgrade.approve', $req) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Authorize this P2P Upgrade?')" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-[9px] orbitron uppercase tracking-widest transition-all">
                                        Approve
                                    </button>
                                </form>
                                <button onclick="openRejectModal({{ $req->id }}, 'upgrade')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-600 hover:text-rose-500 hover:bg-rose-500/10 transition-all flex items-center justify-center">
                                    <i data-lucide="x-circle" class="w-4 h-4"></i>
                                </button>
                            </div>
                            @else
                                <span class="text-[8px] font-black orbitron {{ $req->status === 'approved' ? 'text-emerald-500' : 'text-rose-500' }} uppercase tracking-[0.4em] italic">{{ strtoupper($req->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-32 text-center opacity-20">
                            <i data-lucide="zap-off" class="w-12 h-12 mx-auto mb-4"></i>
                            <span class="text-[10px] font-black orbitron uppercase tracking-[0.4em]">No P2P Upgrade Requisitions</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- WALLET TAB -->
    <div id="admin-tab-wallet" class="admin-tab-content hidden glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl animate-in fade-in duration-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Initiator</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Ingress Value / Method</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Reference (UTR)</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Status</th>
                        <th class="px-10 py-8 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Timestamp</th>
                        <th class="px-10 py-8 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.3em]">Override</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($walletTransactions as $tx)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <span class="text-sm font-black orbitron text-white italic group-hover:text-purple-400 transition-all uppercase tracking-tight">{{ $tx->user->username ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-10 py-8 flex flex-col">
                            <span class="font-black orbitron text-lg italic text-white underline decoration-emerald-500/20 underline-offset-4">₹{{ number_format($tx->amount, 0) }}</span>
                            <span class="text-[8px] text-purple-500/60 font-black orbitron uppercase tracking-[0.2em] mt-1">{{ $tx->payment_method }} Gateway</span>
                        </td>
                        <td class="px-10 py-8">
                             <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-[#0c0518] border border-white/5 rounded-xl text-[10px] font-mono text-gray-400">
                                    {{ $tx->payment_reference }}
                                </span>
                                @if($tx->screenshot)
                                <button onclick="viewProof('{{ asset('storage/' . $tx->screenshot) }}')" class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center hover:bg-purple-500/20 transition-all">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-8">
                             <span class="px-4 py-1.5 rounded-full text-[9px] font-black orbitron uppercase tracking-[0.2em] {{ $statusMap[$tx->status] ?? 'text-white border-white/10' }} border">
                                {{ $tx->status }}
                            </span>
                        </td>
                        <td class="px-10 py-8 italic text-[10px] font-bold text-gray-600 uppercase tracking-widest">
                            {{ $tx->created_at->format('d M Y') }}
                        </td>
                        <td class="px-10 py-8 text-right">
                             <div class="flex justify-end gap-3">
                                @if($tx->status === 'pending')
                                <form action="{{ route('admin.wallet.approve', $tx) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Credit ₹{{ $tx->amount }} to user wallet?')" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-black font-black text-[9px] orbitron uppercase tracking-widest transition-all">
                                        Authorize
                                    </button>
                                </form>
                                <form action="{{ route('admin.wallet.reject', $tx) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Reject this wallet top-up?')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-600 hover:text-rose-500 hover:bg-rose-500/10 transition-all flex items-center justify-center">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @else
                                    <span class="text-[8px] font-black orbitron text-gray-800 uppercase tracking-[0.4em] italic">SYNC_COMPLETE</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                     <tr>
                        <td colspan="6" class="px-10 py-32 text-center opacity-20">
                            <i data-lucide="database-zap" class="w-12 h-12 mx-auto mb-4"></i>
                            <span class="text-[10px] font-black orbitron uppercase tracking-[0.4em]">Zero Wallet Transactions</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-12 flex justify-center">
        <!-- Minimalist Pagination Styling Link -->
        <div class="glass-panel px-6 py-4 rounded-3xl border-white/5">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<!-- Proof Archive Modal -->
<div id="proof-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-4 transition-all duration-700 opacity-0">
    <div class="relative max-w-5xl w-full bg-[#0c0518] border border-white/10 rounded-[3rem] overflow-hidden shadow-[0_0_100px_rgba(147,51,234,0.1)]">
        <div class="flex items-center justify-between p-8 border-b border-white/5 bg-white/[0.02]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-4 h-4 text-purple-400"></i>
                </div>
                <span class="text-[10px] font-black orbitron text-white uppercase tracking-[0.3em]">REQUISITION PROOF PROTOCOL</span>
            </div>
            <button onclick="closeProof()" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all flex items-center justify-center">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-8 sm:p-12 flex items-center justify-center bg-black/50">
            <img id="proof-img" src="" alt="Proof" class="max-h-[70vh] rounded-2xl shadow-[0_0_60px_rgba(0,0,0,0.5)] border border-white/10">
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-6">
    <div class="max-w-xl w-full glass-card border border-white/10 rounded-[2.5rem] p-12 space-y-10 shadow-2xl">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <h3 class="orbitron text-xl font-black text-rose-500 uppercase tracking-tighter italic leading-none">TERMINATION <span class="text-white">PROTOCOL</span></h3>
                <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest mt-2">Specify reason for ledger refusal</span>
            </div>
            <button onclick="closeReject()" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 text-gray-400 transition-all flex items-center justify-center">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="reject-form" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-4">
                <label class="block text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest ml-1">Transmission Note</label>
                <textarea name="rejection_note" required rows="4" placeholder="Security breach, invalid credential, or insufficient proof details..." class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-5 text-white text-[11px] font-bold tracking-tight outline-none focus:border-rose-500/50 transition-all placeholder:text-gray-800"></textarea>
            </div>
            <button type="submit" class="w-full py-5 bg-gradient-to-r from-rose-600 to-rose-700 text-white font-black orbitron uppercase tracking-[0.3em] text-[10px] transition-all italic rounded-2xl shadow-xl shadow-rose-950/20 hover:scale-[1.02] active:scale-95">
                EXECUTE REFUSAL SEQUENCE
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function switchAdminTab(tab) {
        document.querySelectorAll('.admin-tab-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-white/5', 'border-white/10');
            btn.classList.add('border-transparent');
        });
        const activeBtn = document.getElementById('tab-btn-' + tab);
        activeBtn.classList.add('active', 'bg-white/5', 'border-white/10');
        activeBtn.classList.remove('border-transparent');

        document.querySelectorAll('.admin-tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById('admin-tab-' + tab).classList.remove('hidden');
    }

    function viewProof(url) {
        const modal = document.getElementById('proof-modal');
        const img = document.getElementById('proof-img');
        img.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => modal.classList.add('opacity-100'), 10);
    }

    function closeProof() {
        const modal = document.getElementById('proof-modal');
        modal.classList.remove('opacity-100');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 700);
    }

    function openRejectModal(id, type = 'premium') {
        const modal = document.getElementById('reject-modal');
        const form = document.getElementById('reject-form');
        
        if (type === 'upgrade') {
            form.action = `/admin/payments/upgrade/${id}/reject`;
        } else {
            form.action = `/admin/payments/${id}/reject`;
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReject() {
        const modal = document.getElementById('reject-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Initialize first tab
    document.addEventListener('DOMContentLoaded', () => {
        switchAdminTab('premium');
    });
</script>
@endpush
@endsection

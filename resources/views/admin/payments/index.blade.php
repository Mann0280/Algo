@extends('layouts.admin')

@section('title', 'Payment Ledger')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">TRANSACTION MANAGEMENT</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                PAYMENT <span class="text-purple-500 text-glow">HISTORY</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Review and verify platform payment history</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_#a855f7]"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-400 uppercase tracking-widest text-glow-sm">LEDGER ACTIVE</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="glass-panel border-rose-500/20 bg-rose-500/5 text-rose-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center">
        <i data-lucide="alert-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('error') }}
    </div>
    @endif

    <!-- PREMIUM REQUISITIONS TABLE (CONSOLIDATED) -->
    <div id="admin-tab-premium" class="admin-tab-content active glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl animate-in fade-in duration-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">User / Plan</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Amount</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Reference & Proof</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Timestamp</th>
                        <th class="px-10 py-8 text-right text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($allRequests as $item)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform duration-500">
                                    <i data-lucide="user" class="w-6 h-6"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black font-whiskey text-white italic group-hover:text-purple-400 transition-colors uppercase tracking-tight">{{ $item->user->username ?? 'Unknown' }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-bold text-gray-600 uppercase tracking-widest">{{ $item->display_plan }}</span>
                                        <span class="px-1.5 py-0.5 rounded bg-white/5 border border-white/10 text-[7px] font-black font-whiskey text-gray-500 uppercase">{{ $item->sync_type }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-lg font-black font-whiskey text-white italic">₹{{ number_format($item->display_amount, 0) }}</span>
                                <span class="text-[9px] font-bold text-emerald-500/40 uppercase tracking-widest mt-0.5 italic">Payment Received</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-[#0c0518] border border-white/5 rounded-xl text-[10px] font-mono text-gray-400 italic">
                                    {{ $item->display_reference ?: 'NO_REF' }}
                                </span>
                                @if($item->display_proof)
                                <button onclick="viewProof('{{ str_starts_with($item->display_proof, 'uploads/') ? asset($item->display_proof) : asset('storage/' . $item->display_proof) }}')" class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center hover:bg-emerald-500/20 transition-all group/btn">
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
                                    'success' => 'text-emerald-400 border-emerald-500/20 bg-emerald-500/5',
                                ];
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-semibold font-whiskey uppercase tracking-widest {{ $statusMap[$item->status] ?? 'text-white border-white/10' }} border">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black font-whiskey text-gray-400 uppercase tracking-widest italic">{{ $item->created_at->format('d M Y') }}</span>
                                <span class="text-[8px] font-bold text-gray-700 uppercase tracking-[0.2em] mt-1">{{ $item->created_at->format('H:i') }} UTC</span>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex justify-end gap-3">
                                @if($item->status === 'pending')
                                    @php
                                        $approveRoute = '#';
                                        if($item->sync_type === 'payment') $approveRoute = route('admin.payments.approve', $item->id);
                                        elseif($item->sync_type === 'request') $approveRoute = route('admin.payments.upgrade.approve', $item->id);
                                        elseif($item->sync_type === 'wallet') $approveRoute = route('admin.wallet.approve', $item->id);
                                    @endphp
                                    <form action="{{ $approveRoute }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Approve this payment?')" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-black text-[9px] font-whiskey uppercase tracking-widest transition-all shadow-lg shadow-purple-900/20 flex items-center gap-2">
                                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                            Approve
                                        </button>
                                    </form>
                                    <button onclick="openRejectModal({{ $item->id }}, '{{ $item->sync_type }}')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-600 hover:text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/20 transition-all flex items-center justify-center">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                    </button>
                                @else
                                    <span class="text-[8px] font-semibold font-whiskey text-gray-800 uppercase tracking-widest italic">PROCESSED</span>
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
                                <span class="text-[10px] font-semibold font-whiskey uppercase tracking-widest">No Pending Payments Found</span>
                            </div>
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
            {{ $allRequests->links() }}
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
                <span class="text-[10px] font-semibold font-whiskey text-white uppercase tracking-widest">PAYMENT EVIDENCE</span>
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
                <h3 class="font-whiskey text-xl font-black text-rose-500 uppercase tracking-tighter italic leading-none">REJECT <span class="text-white">PAYMENT</span></h3>
                <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest mt-2">Reason for rejection</span>
            </div>
            <button onclick="closeReject()" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 text-gray-400 transition-all flex items-center justify-center">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="reject-form" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-4">
                <label class="block text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Note for User</label>
                <textarea name="rejection_note" required rows="4" placeholder="Security breach, invalid credential, or insufficient proof details..." class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-5 text-white text-[11px] font-bold tracking-tight outline-none focus:border-rose-500/50 transition-all placeholder:text-gray-800"></textarea>
            </div>
            <button type="submit" class="w-full py-5 bg-gradient-to-r from-rose-600 to-rose-700 text-white font-black font-whiskey uppercase tracking-widest text-[10px] transition-all italic rounded-2xl shadow-xl shadow-rose-950/20 hover:scale-[1.02] active:scale-95">
                Reject Payment
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
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

    function openRejectModal(id, type = 'payment') {
        const modal = document.getElementById('reject-modal');
        const form = document.getElementById('reject-form');
        
        if (type === 'request') {
            form.action = `/admin/payments/upgrade/${id}/reject`;
        } else if (type === 'payment') {
            form.action = `/admin/payments/${id}/reject`;
        } else {
            form.action = `/admin/wallet/reject/${id}`;
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReject() {
        const modal = document.getElementById('reject-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
@endsection

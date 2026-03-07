@extends('layouts.admin')

@section('title', 'Payment Matrix')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                PAYMENT <span class="text-purple-500 text-glow">REQUISITIONS</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest leading-none">Manual verification gateway</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-500 text-xs font-bold orbitron uppercase tracking-widest">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center gap-3 text-rose-500 text-xs font-bold orbitron uppercase tracking-widest">
        <i data-lucide="alert-circle" class="w-4 h-4"></i>
        {{ session('error') }}
    </div>
    @endif

    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5">
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Initiator / Package</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Amount</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Transaction (UTR)</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Date</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($payments as $payment)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-black orbitron text-white italic group-hover:text-purple-400 transition-all uppercase tracking-tight">{{ $payment->user->username ?? 'Unknown' }}</span>
                            <span class="text-[9px] text-gray-500 mt-1 uppercase tracking-widest">{{ $payment->package->name ?? 'Deleted Package' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 font-bold text-white orbitron text-sm italic">
                        ₹{{ number_format($payment->amount, 0) }}
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-mono text-gray-400 bg-white/5 px-3 py-1.5 border border-white/5 rounded-lg">{{ $payment->transaction_id }}</span>
                            @if($payment->screenshot)
                            <button onclick="viewProof('{{ asset($payment->screenshot) }}')" class="p-2 rounded-lg bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all">
                                <i data-lucide="image" class="w-3.5 h-3.5"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @php
                            $statusMap = [
                                'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                'approved' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                'rejected' => 'bg-rose-500/10 text-rose-500 border-rose-500/20',
                            ];
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-[9px] font-black orbitron uppercase tracking-[0.2em] {{ $statusMap[$payment->status] }} border">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest italic leading-none">{{ $payment->created_at->format('d M Y') }}<br><span class="text-[8px] opacity-50">{{ $payment->created_at->format('H:i') }}</span></span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-3">
                            @if($payment->status === 'pending')
                            <form action="{{ route('admin.payments.approve', $payment) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Authorize this premium activation?')" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-black font-bold text-[9px] orbitron uppercase tracking-widest transition-all">
                                    Approve
                                </button>
                            </form>
                            <button onclick="openRejectModal({{ $payment->id }})" class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-rose-500/20 hover:border-rose-500/30 font-bold text-[9px] orbitron uppercase tracking-widest transition-all">
                                Reject
                            </button>
                            @else
                                <span class="text-[8px] font-black orbitron text-gray-700 uppercase tracking-widest">ARCHIVED</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4 opacity-20">
                            <i data-lucide="shield-alert" class="w-12 h-12"></i>
                            <span class="text-[10px] font-black orbitron uppercase tracking-[0.3em]">No Pending Requisitions</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-8">
        {{ $payments->links() }}
    </div>
</div>

<!-- Screenshot Modal -->
<div id="proof-modal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[100] hidden items-center justify-center p-6 transition-all duration-500 opa-0" style="opacity: 0">
    <div class="relative max-w-4xl w-full bg-black/40 border border-white/10 rounded-[2.5rem] overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-white/5">
            <span class="text-xs font-black orbitron text-white uppercase tracking-widest">PAYMENT PROOF ARCHIVE</span>
            <button onclick="closeProof()" class="p-2 text-gray-500 hover:text-white transition-all"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div class="p-4 sm:p-10 flex items-center justify-center">
            <img id="proof-img" src="" alt="Proof" class="max-h-[70vh] rounded-2xl shadow-2xl shadow-purple-500/10 border border-white/10">
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[100] hidden items-center justify-center p-6">
    <div class="max-w-xl w-full glass-card border border-white/10 rounded-[2.5rem] p-10 space-y-8">
        <div class="flex items-center justify-between">
            <h3 class="orbitron text-xl font-black text-rose-500 uppercase tracking-tighter italic">REJECT <span class="text-white">PROTOCOL</span></h3>
            <button onclick="closeReject()" class="p-2 text-gray-500 hover:text-white transition-all"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>

        <form id="reject-form" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="block text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest ml-1">Rejection Reason</label>
                <textarea name="rejection_note" required rows="4" placeholder="Invalid UTR, incorrect amount, etc..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs outline-none focus:border-rose-500/50 transition-all"></textarea>
            </div>
            <button type="submit" class="w-full py-4 bg-rose-500 hover:bg-rose-600 text-black font-black orbitron uppercase tracking-widest text-xs transition-all italic">
                Decline Payment Sequence
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
        setTimeout(() => modal.style.opacity = '1', 10);
    }

    function closeProof() {
        const modal = document.getElementById('proof-modal');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 500);
    }

    function openRejectModal(id) {
        const modal = document.getElementById('reject-modal');
        const form = document.getElementById('reject-form');
        form.action = `/admin/payments/${id}/reject`;
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

@extends('layouts.admin')

@section('title', 'Subscription Requests')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">WAITING FOR CHECK</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                SUBSCRIPTION <span class="text-purple-500 text-glow">REQUESTS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Check User Payments and Subscription Upgrades</p>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="glass-panel border-rose-500/20 bg-rose-500/5 text-rose-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center">
        <i data-lucide="alert-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('error') }}
    </div>
    @endif

    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">User</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Plan</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Amount</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Transaction ID</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Proof</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-10 py-8 text-right text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($requests as $request)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <span class="text-sm font-black font-whiskey text-white uppercase tracking-tight">{{ $request->user->username ?? 'N/A' }}</span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $request->package->name ?? $request->plan_name ?? 'Custom' }}</span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="text-sm font-black font-whiskey text-purple-400">₹{{ number_format($request->amount, 0) }}</span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-3 py-1.5 bg-[#0c0518] border border-white/5 rounded-xl text-[10px] font-mono text-gray-400 italic">
                                {{ $request->utr_number }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            @if($request->payment_screenshot)
                            <button onclick="viewProof('{{ str_starts_with($request->payment_screenshot, 'uploads/') ? asset($request->payment_screenshot) : (str_starts_with($request->payment_screenshot, 'http') ? $request->payment_screenshot : Storage::disk('public')->url($request->payment_screenshot)) }}')" class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center hover:bg-emerald-500/20 transition-all group/btn">
                                <i data-lucide="image" class="w-4 h-4"></i>
                            </button>
                            @else
                            <span class="text-[8px] text-gray-600 font-semibold font-whiskey">NO EVIDENCE</span>
                            @endif
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black font-whiskey uppercase tracking-[0.2em] 
                                {{ $request->status === 'approved' ? 'text-emerald-400 border-emerald-500/20 bg-emerald-500/5' : 
                                   ($request->status === 'rejected' ? 'text-rose-400 border-rose-500/20 bg-rose-500/5' : 
                                   'text-amber-400 border-amber-500/20 bg-amber-500/5') }} border">
                                {{ strtoupper($request->status) }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex justify-end gap-3">
                                @if($request->status === 'pending')
                                <form action="{{ route('admin.payments.upgrade.approve', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Approve this upgrade?')" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-black text-[9px] font-whiskey uppercase tracking-widest transition-all flex items-center gap-2">
                                        <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                        Approve
                                    </button>
                                </form>
                                <button onclick="openRejectModal({{ $request->id }})" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-gray-600 hover:text-rose-500 hover:bg-rose-500/10 transition-all flex items-center justify-center">
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
                        <td colspan="7" class="px-10 py-32 text-center opacity-20 italic font-whiskey text-[10px] tracking-widest uppercase">
                            No subscription requests found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center">
        {{ $requests->links() }}
    </div>
</div>

<!-- Proof Modal -->
<div id="proof-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-4">
    <div class="relative max-w-5xl w-full bg-[#0c0518] border border-white/10 rounded-[3rem] overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between p-8 border-b border-white/5">
            <span class="text-[10px] font-semibold font-whiskey text-white uppercase tracking-widest">PAYMENT PROOF</span>
            <button onclick="closeProof()" class="text-gray-400 hover:text-white transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-8 flex items-center justify-center">
            <img id="proof-img" src="" alt="Proof" class="max-h-[70vh] rounded-2xl border border-white/10">
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="reject-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-6">
    <div class="max-w-xl w-full glass-card border border-white/10 rounded-[2.5rem] p-12 space-y-10 shadow-2xl">
        <div class="flex items-center justify-between">
            <h3 class="font-whiskey text-xl font-black text-rose-500 uppercase tracking-tighter italic">REJECT <span class="text-white">REQUEST</span></h3>
            <button onclick="closeReject()" class="text-gray-400 hover:text-white transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="reject-form" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-4">
                <label class="block text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-widest">Reason for Rejection</label>
                <textarea name="rejection_note" required rows="4" class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-5 text-white text-[11px] font-bold outline-none focus:border-rose-500/50 transition-all"></textarea>
            </div>
            <button type="submit" class="w-full py-5 bg-rose-600 text-white font-black font-whiskey uppercase text-[10px] rounded-2xl">Reject Request</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function viewProof(url) {
        document.getElementById('proof-img').src = url;
        document.getElementById('proof-modal').classList.remove('hidden');
        document.getElementById('proof-modal').classList.add('flex');
    }
    function closeProof() {
        document.getElementById('proof-modal').classList.add('hidden');
        document.getElementById('proof-modal').classList.remove('flex');
    }
    function openRejectModal(id) {
        const form = document.getElementById('reject-form');
        form.action = `/admin/payments/upgrade/${id}/reject`;
        document.getElementById('reject-modal').classList.remove('hidden');
        document.getElementById('reject-modal').classList.add('flex');
    }
    function closeReject() {
        document.getElementById('reject-modal').classList.add('hidden');
        document.getElementById('reject-modal').classList.remove('flex');
    }
</script>
@endpush
@endsection

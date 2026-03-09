@extends('layouts.admin')

@section('title', 'SIGNAL CONTROL')

@section('content')
<div class="space-y-10 max-w-[1600px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black orbitron text-purple-500 uppercase tracking-[0.3em]">PREDICTIVE ENGINE V2.0</span>
            </div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                SIGNAL <span class="text-purple-500 text-glow">COMMAND</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Manage and Authorize AI Trading Transmissions</p>
        </div>
        
        <button onclick="toggleModal('add-modal')" class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 rounded-2xl font-black orbitron text-[10px] tracking-[0.25em] uppercase flex items-center gap-3 transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-purple-900/20 italic text-white">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            INJECT NEW SIGNAL
        </button>
    </div>

    @if (session('success'))
        <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] orbitron font-black uppercase tracking-[0.2em] text-center animate-pulse">
            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Signals Table/Grid Container -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Asset Pair</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Entry / Target</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Confidence</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Risk Profile</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Transmission Date</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.02]">
                    @foreach ($predictions as $signal)
                    <tr class="group hover:bg-white/[0.02] transition-colors duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                                    <i data-lucide="trending-up" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-white orbitron tracking-tight">{{ strtoupper($signal->stock_symbol) }}</div>
                                    <div class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-1">Market: Spot/Future</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1">
                                <div class="text-xs font-bold text-gray-400">Entry: <span class="text-white">Active</span></div>
                                <div class="text-xs font-bold text-purple-400">Target 1: <span class="text-white font-black">₹{{ number_format($signal->target_1, 2) }}</span></div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 max-w-[80px] h-1.5 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-600 shadow-[0_0_10px_rgba(147,51,234,0.5)]" style="width: {{ $signal->confidence_level }}%"></div>
                                </div>
                                <span class="text-xs font-black orbitron text-white italic">{{ $signal->confidence_level }}%</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black orbitron tracking-widest uppercase border {{ $signal->risk_level == 'High' ? 'border-rose-500/30 text-rose-500 bg-rose-500/5' : 'border-emerald-500/30 text-emerald-500 bg-emerald-500/5' }}">
                                {{ $signal->risk_level }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">{{ $signal->created_at->format('d M, Y / H:i') }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end gap-3">
                                <button class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-gray-500 hover:text-white hover:bg-white/10 transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </button>
                                <form action="{{ route('admin.predictions.destroy', $signal->id) }}" method="POST" onsubmit="return confirm('Terminate this signal transmission?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y divide-white/5">
            @foreach ($predictions as $signal)
            <div class="p-8 space-y-6">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                            <i data-lucide="trending-up" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <div class="text-lg font-black text-white orbitron tracking-tight">{{ strtoupper($signal->stock_symbol) }}</div>
                            <div class="text-[10px] font-black text-purple-500 orbitron uppercase italic mt-1">{{ $signal->confidence_level }}% CONFIDENCE</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 bg-white/[0.02] p-6 rounded-2xl border border-white/5">
                    <div>
                        <div class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-widest mb-1">TARGET 1</div>
                        <div class="text-sm font-black text-white">₹{{ number_format($signal->target_1, 2) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-widest mb-1">RISK PROFILE</div>
                        <div class="text-[10px] font-black orbitron {{ $signal->risk_level == 'High' ? 'text-rose-500' : 'text-emerald-500' }} uppercase">{{ $signal->risk_level }}</div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button class="flex-1 py-4 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black orbitron uppercase tracking-widest text-gray-400">EDIT</button>
                    <form action="{{ route('admin.predictions.destroy', $signal->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-[10px] font-black orbitron uppercase tracking-widest text-rose-500">TERMINATE</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Signal Modal Overhaul -->
<div id="add-modal" class="fixed inset-0 bg-black/90 backdrop-blur-xl z-[100] flex items-center justify-center hidden p-6">
    <div class="w-full max-w-xl glass-card p-10 rounded-[3rem] border border-white/10 relative overflow-hidden shadow-[0_0_100px_rgba(147,51,234,0.1)]">
        <div class="absolute top-0 right-0 w-48 h-48 bg-purple-600/5 blur-[80px] -z-10"></div>
        
        <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
            <div>
                <h2 class="orbitron font-black text-2xl italic uppercase tracking-tighter text-white">Inject <span class="text-purple-500 text-glow text-3xl">Signal</span></h2>
                <div class="text-[9px] font-black orbitron text-purple-500 tracking-[0.3em] mt-2 uppercase italic leading-none">Authorization Required</div>
            </div>
            <button onclick="toggleModal('add-modal')" class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 hover:text-white transition-all group">
                <i data-lucide="x" class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </div>

        <form action="{{ route('admin.predictions.store') }}" method="POST" class="space-y-8">
            @csrf
            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] pl-1">Trading Asset</label>
                    <input type="text" name="symbol" required placeholder="BTC/USDT" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black orbitron tracking-tight text-white placeholder:text-gray-800">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] pl-1">AI Confidence (%)</label>
                    <input type="number" name="confidence" required placeholder="98" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black orbitron tracking-tight text-white placeholder:text-gray-800">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] pl-1">Entry Threshold</label>
                    <input type="number" step="0.0001" name="entry" required placeholder="0.0482" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black orbitron tracking-tight text-white placeholder:text-gray-800">
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] pl-1">Primary Target (T1)</label>
                    <input type="number" step="0.0001" name="target_1" required placeholder="0.0520" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black orbitron tracking-tight text-white placeholder:text-gray-800">
                </div>
            </div>

            <div class="space-y-3 pt-4">
                <label class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] pl-1">Risk Classification</label>
                <div class="flex gap-4">
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="risk_level" value="Low" checked class="hidden peer">
                        <div class="py-4 rounded-2xl border border-white/10 bg-white/5 text-center text-[10px] font-black orbitron text-gray-500 peer-checked:bg-emerald-500/10 peer-checked:border-emerald-500/50 peer-checked:text-emerald-500 transition-all uppercase tracking-widest">Low Risk</div>
                    </label>
                    <label class="flex-1 cursor-pointer group">
                        <input type="radio" name="risk_level" value="High" class="hidden peer">
                        <div class="py-4 rounded-2xl border border-white/10 bg-white/5 text-center text-[10px] font-black orbitron text-gray-500 peer-checked:bg-rose-500/10 peer-checked:border-rose-500/50 peer-checked:text-rose-500 transition-all uppercase tracking-widest">High Risk</div>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 py-6 rounded-2xl font-black orbitron text-[11px] tracking-[0.3em] uppercase shadow-2xl shadow-purple-900/40 hover:scale-[1.01] active:scale-95 transition-all text-white italic">
                Authorize Market Transmission
            </button>
        </form>
    </div>
</div>
@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
</script>
@endpush
@endsection

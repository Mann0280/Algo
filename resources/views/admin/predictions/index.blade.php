@extends('layouts.admin')

@section('title', 'AI Signal Control')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                SIGNAL <span class="text-purple-500 text-glow">CONTROL</span>
            </h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">Predictive Engine Interface</p>
        </div>
        <button onclick="document.getElementById('add-modal').classList.remove('hidden')" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 px-6 py-3 rounded-xl font-bold orbitron text-[10px] tracking-widest uppercase flex items-center gap-2 transition-all active:scale-95 shadow-lg shadow-purple-500/20">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Inject New Signal
        </button>
    </div>

    @if (session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 rounded-xl text-[10px] orbitron font-bold uppercase tracking-wider text-center">
            {{ session('success') }}
        </div>
    @endif

    <!-- Signal List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($predictions as $signal)
        @php $signal = (array)$signal; @endphp
        <div class="glass-card p-6 rounded-3xl border border-white/5 relative group transition-all hover:border-purple-500/30">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-black orbitron text-white">{{ $signal['stock_symbol'] }}</h2>
                    <p class="text-[9px] text-gray-500 orbitron uppercase font-bold tracking-widest leading-none mt-1">{{ $signal['model_used'] }} Engine</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-1">Confidence</p>
                    <p class="text-lg font-black text-purple-400">{{ $signal['confidence_level'] }}%</p>
                </div>
            </div>

            <div class="space-y-4 py-4 border-t border-white/5">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-medium">Target Price</span>
                    <span class="text-white font-bold">₹{{ number_format($signal['predicted_price'], 2) }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 font-medium">Broadcast Date</span>
                    <span class="text-gray-400">{{ date('d M, Y', strtotime($signal['created_at'])) }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-white/5 flex gap-2">
                <button class="flex-1 py-2 rounded-lg bg-white/5 text-[10px] font-bold orbitron uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/10 transition-all">Archive</button>
                <form action="{{ route('admin.predictions.destroy', $signal['id']) }}" method="POST" onsubmit="return confirm('Terminate signal?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Signal Modal -->
<div id="add-modal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center hidden p-6">
    <div class="w-full max-w-lg glass-card p-8 rounded-3xl border border-white/10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="orbitron font-black text-xl italic uppercase tracking-tighter">New <span class="text-purple-500 text-glow">Signal</span></h2>
            <button onclick="document.getElementById('add-modal').classList.add('hidden')" class="text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form action="{{ route('admin.predictions.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Symbol</label>
                    <input type="text" name="symbol" required placeholder="TATASTEEL" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Confidence</label>
                    <input type="number" name="confidence" required placeholder="95" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Target Price (₹)</label>
                <input type="number" step="0.01" name="price" required placeholder="142.50" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 py-4 rounded-xl font-bold orbitron text-[10px] tracking-widest uppercase shadow-xl shadow-purple-500/20 active:scale-95 transition-all text-white">
                Broadcast Signal
            </button>
        </form>
    </div>
</div>
@endsection

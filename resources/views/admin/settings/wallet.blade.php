@extends('layouts.admin')

@section('title', 'Wallet Configuration')

@section('content')
<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                WALLET <span class="text-purple-500 text-glow">PROTOCOL</span>
            </h1>
            <p class="text-gray-500 text-[10px] font-bold orbitron uppercase tracking-[0.3em] mt-2">Centralized Neural Credit Infrastructure</p>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-500 text-xs font-bold orbitron uppercase tracking-widest animate-in zoom-in-95 duration-300">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Configuration Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.settings.wallet.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="glass-panel rounded-[2.5rem] p-10 border-white/5 space-y-8 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    
                    <div class="relative z-10 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- UPI ID -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] pl-2">Neural UPI ID</label>
                                <div class="relative group/input">
                                    <i data-lucide="hash" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-focus-within/input:text-purple-500 transition-colors"></i>
                                    <input type="text" name="wallet_upi_id" value="{{ $settings['upi_id'] }}" required 
                                        class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all" 
                                        placeholder="e.g. trading@upi">
                                </div>
                            </div>

                            <!-- UPI Name -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] pl-2">Authorized Receiver Name</label>
                                <div class="relative group/input">
                                    <i data-lucide="user" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-focus-within/input:text-purple-500 transition-colors"></i>
                                    <input type="text" name="wallet_upi_name" value="{{ $settings['upi_name'] }}" required 
                                        class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all" 
                                        placeholder="e.g. AlgoTrade Systems">
                                </div>
                            </div>
                        </div>

                        <!-- QR Code Upload -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] pl-2">Neural QR Matrix</label>
                            <label class="w-full h-40 bg-white/[0.03] border-2 border-dashed border-white/[0.08] rounded-[2rem] flex flex-col items-center justify-center cursor-pointer group hover:bg-white/[0.05] hover:border-purple-500/40 transition-all text-gray-500 hover:text-white">
                                <i data-lucide="qr-code" class="w-10 h-10 mb-3 opacity-20 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500"></i>
                                <span class="text-[10px] font-black orbitron uppercase tracking-[0.2em]">Deploy New QR Matrix</span>
                                <input type="file" name="wallet_qr_code" accept="image/*" class="hidden" onchange="previewQR(this)">
                            </label>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-12 py-4 bg-purple-600 text-white rounded-2xl font-black orbitron uppercase tracking-[0.2em] text-[10px] hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all">Synchronize Protocols</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div class="lg:col-span-1 space-y-6">
            <h4 class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.3em] px-2">Visual Synchronization</h4>
            
            <div class="glass-panel rounded-[2.5rem] p-8 border-white/5 relative overflow-hidden flex flex-col items-center justify-center aspect-square group">
                <div class="absolute inset-0 bg-gradient-to-tr from-purple-600/[0.05] to-transparent"></div>
                
                @if($settings['qr_code'])
                <img id="qr-preview" src="{{ asset('storage/' . $settings['qr_code']) }}" 
                    class="relative z-10 w-48 h-48 object-contain rounded-2xl border border-white/10 p-2 bg-white/5 shadow-2xl">
                @else
                <div id="qr-placeholder" class="relative z-10 w-48 h-48 rounded-2xl border-2 border-dashed border-white/5 flex flex-col items-center justify-center text-gray-700">
                    <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                    <p class="text-[8px] font-bold orbitron uppercase italic">Waiting for Matrix...</p>
                </div>
                <img id="qr-preview" class="hidden relative z-10 w-48 h-48 object-contain rounded-2xl border border-white/10 p-2 bg-white/5 shadow-2xl">
                @endif
                
                <div class="mt-6 text-center">
                    <p class="text-[10px] font-black orbitron text-white uppercase tracking-widest italic" id="preview-name">{{ $settings['upi_name'] ?: 'SYSTEM_NAME' }}</p>
                    <p class="text-[8px] font-bold orbitron text-purple-500 uppercase tracking-widest mt-1" id="preview-upi">{{ $settings['upi_id'] ?: 'NULL_ADDRESS' }}</p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-amber-500/5 border border-amber-500/10 space-y-3">
                <div class="flex items-center gap-3 text-amber-500">
                    <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                    <span class="text-[9px] font-black orbitron uppercase tracking-widest">Global Override</span>
                </div>
                <p class="text-[8px] font-bold orbitron text-amber-500/60 leading-relaxed uppercase tracking-widest italic">
                    These settings will override all package-specific payment credentials across the neural network. Use with caution.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function previewQR(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('qr-preview');
                const placeholder = document.getElementById('qr-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

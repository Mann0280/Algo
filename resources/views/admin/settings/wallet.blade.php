@extends('layouts.admin')

@section('title', 'WALLET CONFIGURATION')

@section('content')
<div class="space-y-12 max-w-[1200px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black font-whiskey text-purple-500 uppercase tracking-[0.3em]">WALLET CONFIGURATION</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                FINANCIAL <span class="text-purple-500 text-glow">RECEPTION</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Configure payment receive and withdrawal protocols.</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_#10b981]"></span>
                <span class="text-[10px] font-black font-whiskey text-emerald-400 uppercase tracking-widest text-glow-sm">ENCRYPTION ACTIVE</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Configuration Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.settings.wallet.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl relative group">
                    <div class="px-10 py-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shadow-[0_0_20px_rgba(147,51,234,0.1)]">
                                <i data-lucide="credit-card" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 class="font-whiskey text-sm font-black tracking-[0.2em] uppercase text-white leading-none">Receiver Credentials</h2>
                                <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-2 leading-none">Primary payment reception parameters</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="grid grid-cols-1 gap-10">
                            <!-- UPI ID -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] pl-1">Business UPI ID</label>
                                <div class="relative group/input">
                                    <div class="absolute inset-y-0 left-5 flex items-center text-gray-700 group-focus-within/input:text-purple-500 transition-colors">
                                        <i data-lucide="hash" class="w-4 h-4"></i>
                                    </div>
                                    <input type="text" name="wallet_upi_id" value="{{ $settings['upi_id'] }}" required 
                                        class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 pl-14 pr-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white shadow-inner placeholder:text-gray-800" 
                                        placeholder="address@upi">
                                </div>
                                <p class="text-[8px] font-bold text-gray-700 uppercase tracking-widest pl-1">The UPI ID where users will send payments.</p>
                            </div>

                            <!-- UPI Name -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] pl-1">Account Holder Name</label>
                                <div class="relative group/input">
                                    <div class="absolute inset-y-0 left-5 flex items-center text-gray-700 group-focus-within/input:text-purple-500 transition-colors">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </div>
                                    <input type="text" name="wallet_upi_name" value="{{ $settings['upi_name'] }}" required 
                                        class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 pl-14 pr-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white shadow-inner placeholder:text-gray-800" 
                                        placeholder="Legal Name">
                                </div>
                                <p class="text-[8px] font-bold text-gray-700 uppercase tracking-widest pl-1">The name shown to users during payment.</p>
                            </div>

                            <!-- Min Withdrawal Amount -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] pl-1">Min Withdrawal Limit (₹)</label>
                                <div class="relative group/input">
                                    <div class="absolute inset-y-0 left-5 flex items-center text-gray-700 group-focus-within/input:text-purple-500 transition-colors">
                                        <i data-lucide="indian-rupee" class="w-4 h-4"></i>
                                    </div>
                                    <input type="number" name="min_withdrawal_amount" value="{{ $settings['min_withdrawal'] }}" required min="1"
                                        class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 pl-14 pr-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white shadow-inner placeholder:text-gray-800" 
                                        placeholder="100">
                                </div>
                                <p class="text-[8px] font-bold text-gray-700 uppercase tracking-widest pl-1">The minimum distance for user withdrawals.</p>
                            </div>
                        </div>


                        <div class="flex justify-end pt-4">
                            <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-purple-600 to-indigo-600 px-12 py-5 rounded-2xl font-black font-whiskey text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-purple-900/20 hover:scale-[1.02] active:scale-95 transition-all text-white italic">
                                UPDATE WALLET SETTINGS
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preview & Warnings -->
        <div class="space-y-10">
            <!-- Live UPI Preview -->
            <div class="space-y-4">
                <h4 class="text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.4em] pl-4">LIVE PREVIEW</h4>
                <div class="glass-card rounded-[2.5rem] p-10 border-white/5 flex flex-col items-center text-center relative overflow-hidden group shadow-2xl bg-gradient-to-b from-white/[0.02] to-transparent">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600/5 blur-[60px] rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10 w-full flex flex-col items-center">
                        <div class="w-16 h-16 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 mb-6">
                            <i data-lucide="wallet" class="w-8 h-8"></i>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-black font-whiskey text-white italic tracking-tight uppercase" id="preview-name">
                                {{ $settings['upi_name'] ?: 'SYSTEM_GATEWAY_NODE' }}
                            </p>
                            <div class="flex items-center justify-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                <p class="text-[10px] font-bold font-whiskey text-purple-400 uppercase tracking-widest" id="preview-upi">
                                    {{ $settings['upi_id'] ?: 'ADDRESS_UNREACHABLE' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-[8px] font-bold text-gray-700 uppercase tracking-widest mt-6">QR code is auto-generated from UPI ID</p>
                    </div>
                </div>
            </div>

            <!-- Global Protocol Warning -->
            <div class="glass-card p-8 rounded-[2rem] border border-amber-500/10 bg-amber-500/5 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-amber-500/30"></div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                        <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black font-whiskey text-amber-500 uppercase tracking-widest">Global Override</h4>
                    </div>
                </div>
                <p class="text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.2em] leading-relaxed italic">
                    Modifying these protocols will simultaneously broadcast new gateway credentials to every active node and package across the platform. Verification is mandatory.
                </p>
            </div>
        </div>
    </div>
</div>

<script>

    // Live sync for text inputs
    document.querySelector('input[name="wallet_upi_name"]').addEventListener('input', function(e) {
        document.getElementById('preview-name').innerText = e.target.value || 'SYSTEM_GATEWAY_NODE';
    });
    document.querySelector('input[name="wallet_upi_id"]').addEventListener('input', function(e) {
        document.getElementById('preview-upi').innerText = e.target.value || 'ADDRESS_UNREACHABLE';
    });
</script>
@endsection

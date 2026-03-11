@extends('layouts.app')

@section('title', 'Secure Payment | Emperor Stock Predictor')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl relative z-10">
    <div class="text-center mb-10">
        <h1 class="orbitron text-3xl sm:text-4xl font-black mb-2 tracking-tighter text-white uppercase italic">
            SECURE <span class="text-purple-500">PAYMENT</span>
        </h1>
        <p class="text-gray-400 text-sm font-medium uppercase tracking-[0.2em]">Complete your upgrade sequence</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Plan Summary & QR Code -->
        <div class="space-y-6">
            <div class="glass-panel border-white/10 rounded-[2.5rem] p-8 relative overflow-hidden h-full">
                <!-- Background Glow -->
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-purple-600/10 rounded-full blur-[80px]"></div>
                
                <div class="relative z-10">
                    <div class="mb-8">
                        <span class="text-[10px] font-black orbitron text-purple-400 uppercase tracking-widest px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 mb-4 inline-block">Plan Selected</span>
                        <h2 class="orbitron text-2xl font-black text-white italic uppercase tracking-tight">{{ $package->name }}</h2>
                        <div class="mt-2 flex items-baseline gap-1">
                            <span class="text-3xl font-black text-white orbitron">₹{{ number_format($package->price) }}</span>
                            <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">/ {{ $package->duration_days }} Days</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex flex-col items-center">
                            <div class="relative p-4 bg-white/[0.03] rounded-[2rem] border border-white/10 mb-6">
                                <div class="bg-white p-3 rounded-2xl">
                                    <div id="payment-qrcode"></div>
                                </div>
                                <!-- Scanner Line Animation -->
                                <div class="absolute left-0 w-full h-1 bg-gradient-to-r from-transparent via-purple-500 to-transparent z-10" style="animation: scan-line 3s ease-in-out infinite;"></div>
                            </div>
                            
                            <div class="w-full space-y-3">
                                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.06] flex items-center justify-between group">
                                    <div class="space-y-0.5">
                                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Store UPI ID</p>
                                        <p class="text-sm font-black text-purple-400 font-mono">{{ $upiId }}</p>
                                    </div>
                                    <button onclick="copyToClipboard('{{ $upiId }}', this)" class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center hover:bg-purple-500 hover:text-white transition-all">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/[0.06]">
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-1">Payee Name</p>
                                    <p class="text-sm font-bold text-white">{{ $upiName }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                            <h4 class="text-xs font-black text-amber-500 uppercase tracking-widest flex items-center gap-2 mb-2">
                                <i data-lucide="info" class="w-3.5 h-3.5"></i> Payment Instructions
                            </h4>
                            <ul class="text-[11px] text-gray-400 space-y-2 leading-relaxed">
                                <li>• Scan the QR code using any UPI app (GPay, PhonePe, Paytm).</li>
                                <li>• Ensure the amount exactly matches the plan price: <strong class="text-white">₹{{ number_format($package->price) }}</strong>.</li>
                                <li>• After payment, record the <strong class="text-white">12-digit UTR Number</strong>.</li>
                                <li>• Take a screenshot of the payment confirmation page.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Form -->
        <div class="space-y-6">
            <div class="glass-panel border-white/10 rounded-[2.5rem] p-8 h-full">
                <div class="mb-8">
                    <h3 class="orbitron text-xl font-black text-white italic uppercase tracking-tight">VERIFY <span class="text-purple-500">PAYMENT</span></h3>
                    <p class="text-gray-500 text-xs mt-1">Submit your transaction details for synchronization</p>
                </div>

                <form action="{{ route('payment.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    <input type="hidden" name="amount" value="{{ $package->price }}">

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Plan Reference</label>
                        <div class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 flex items-center justify-between">
                            <span class="text-sm font-bold text-white uppercase">{{ $package->name }}</span>
                            <span class="text-sm font-black text-purple-400 orbitron">₹{{ number_format($package->price) }}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="utr" class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">UTR / Transaction ID</label>
                        <div class="relative group">
                            <i data-lucide="hash" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-400 transition-colors"></i>
                            <input type="text" name="utr" id="utr" required
                                class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white text-sm font-semibold outline-none focus:border-purple-500/50 transition-all"
                                placeholder="Enter 12-digit UTR number">
                        </div>
                        @error('utr')
                            <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1">Payment Proof (Screenshot)</label>
                        <label class="relative group cursor-pointer block">
                            <div class="w-full bg-white/[0.03] border border-dashed border-white/20 rounded-2xl p-8 flex flex-col items-center gap-3 group-hover:bg-white/[0.05] group-hover:border-purple-500/40 transition-all">
                                <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform">
                                    <i data-lucide="image-plus" class="w-6 h-6"></i>
                                </div>
                                <div class="text-center">
                                    <p id="file-name" class="text-sm font-bold text-gray-400">Select Image File</p>
                                    <p class="text-[10px] text-gray-600 font-medium uppercase tracking-wider mt-1">JPG, PNG or PDF (Max 2MB)</p>
                                </div>
                            </div>
                            <input type="file" name="screenshot" id="screenshot" required accept="image/*" class="hidden" onchange="updateFileName(this)">
                        </label>
                        @error('screenshot')
                            <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-[1.5rem] font-black orbitron uppercase italic tracking-wider text-sm transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(147,51,234,0.4)] active:scale-[0.98] flex items-center justify-center gap-3">
                            <span>Submit Neural Upgrade Request</span>
                            <i data-lucide="zap" class="w-5 h-5"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const upiId = '{{ $upiId }}';
        const receiverName = '{{ urlencode($upiName) }}';
        const amount = '{{ $package->price }}';
        
        const upiString = `upi://pay?pa=${upiId}&pn=${receiverName}&am=${amount}&cu=INR`;
        
        new QRCode(document.getElementById("payment-qrcode"), {
            text: upiString,
            width: 180,
            height: 180,
            colorDark : "#030303",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });

    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Select Image File';
        document.getElementById('file-name').innerText = fileName;
        document.getElementById('file-name').classList.add('text-purple-400');
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i>';
            btn.classList.add('bg-emerald-500/20', 'text-emerald-500');
            lucide.createIcons();
            
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.classList.remove('bg-emerald-500/20', 'text-emerald-500');
                lucide.createIcons();
            }, 2000);
        });
    }
</script>
<style>
    @keyframes scan-line {
        0%, 100% { transform: translateY(0); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        50% { transform: translateY(208px); }
    }
</style>
@endpush
@endsection

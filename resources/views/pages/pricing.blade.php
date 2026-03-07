@extends('layouts.app')

@section('title', 'Pricing Tiers | ALGO TRADE')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 py-20 relative z-10 font-bold uppercase italic tracking-tighter">
    <div class="text-center mb-16">
        <h1 class="orbitron text-5xl font-black mb-4 tracking-tighter text-white">CHOOSE YOUR <span class="text-purple-500">LEVEL</span></h1>
        <p class="text-gray-400 max-w-lg mx-auto font-normal not-italic normal-case tracking-normal">Scale your trading with AI-powered insights and professional grade toolsets.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl w-full">
        @forelse($packages as $package)
        <!-- Dynamic Package -->
        <div class="glass-panel p-10 rounded-[3rem] border border-white/10 relative overflow-hidden transition-all hover:translate-y-[-10px] {{ $loop->first && !$isPremium ? 'premium-glow scale-105' : '' }}">
            <div class="absolute top-6 right-6 flex flex-col gap-2 items-end">
                @if ($package->tags_json && count($package->tags_json) > 0)
                    @foreach($package->tags_json as $t)
                        <div class="px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse shadow-lg" style="background-color: {{ $t['color'] }}; color: white; border: 1px solid rgba(255,255,255,0.1);">{{ strtoupper($t['name']) }}</div>
                    @endforeach
                @elseif ($package->tag)
                    <div class="bg-purple-500 text-white px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse shadow-[0_0_15px_rgba(147,51,234,0.5)]">{{ strtoupper($package->tag) }}</div>
                @elseif ($loop->first && !$isPremium)
                    <div class="bg-amber-400 text-black px-4 py-1 rounded-full text-[10px] font-black orbitron animate-pulse">MOST POPULAR</div>
                @endif
            </div>
            
            <h2 class="orbitron text-xl font-bold mb-2 text-white italic tracking-tighter uppercase">{{ $package->name }}</h2>
            <div class="text-4xl font-black mb-8 text-white">₹ {{ number_format($package->price, 0) }}<span class="text-xs text-gray-500 font-medium lowercase"> / {{ $package->duration_days }} days</span></div>
            
            <p class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-6 px-1">{{ $package->description }}</p>

            <ul class="space-y-4 text-sm text-gray-200 mb-10 not-italic normal-case">
                @if($package->features)
                    @foreach($package->features as $feature)
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> {{ $feature }}</li>
                    @endforeach
                @else
                    <li class="flex items-center gap-3"><i data-lucide="check" class="w-5 h-5 text-amber-400"></i> Unlock AI Signals</li>
                @endif
            </ul>

            @if ($isPremium)
                <button disabled class="w-full py-4 rounded-2xl bg-amber-400/20 text-amber-400 font-bold tracking-widest text-xs uppercase italic">Active Subscription</button>
            @else
                <div class="space-y-4">
                    @if($package->upi_id)
                    <div class="p-3 bg-white/5 border border-white/5 rounded-xl flex flex-col items-center gap-1 group/upi cursor-help transition-all hover:bg-white/10" title="Direct Payment Address">
                        <span class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest">Protocol UPI Gateway</span>
                        <span class="text-[10px] font-bold text-amber-400 group-hover/upi:text-amber-300 transition-colors lowercase">{{ $package->upi_id }}</span>
                    </div>
                    @endif
                    <button onclick='openPaymentModal(@json($package))' class="w-full py-4 rounded-2xl font-black tracking-widest text-sm hover:scale-105 active:scale-95 transition-all shadow-xl uppercase italic group/btn relative overflow-hidden" style="background-color: {{ $package->button_color ?? '#fbbf24' }}; color: {{ ($package->button_color && $package->button_color != '#fbbf24') ? 'white' : 'black' }};">
                        <span class="relative z-10">Initiate Upgrade</span>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover/btn:translate-y-0 transition-transform duration-300"></div>
                    </button>
                </div>
            @endif
        </div>
        @empty
        <div class="col-span-full py-20 text-center opacity-30">
            <i data-lucide="package-search" class="w-16 h-16 mx-auto mb-4"></i>
            <h3 class="orbitron text-xl font-black uppercase tracking-widest">No Active Protocol Packages</h3>
        </div>
        @endforelse
    </div>

    <!-- Redesigned Multi-Step Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-[#05020a]/95 backdrop-blur-2xl z-[9999] hidden items-center justify-center p-4 sm:p-6 transition-all duration-500 overflow-y-auto">
        <style>
            .cyber-modal {
                background: linear-gradient(135deg, rgba(15, 10, 25, 0.8), rgba(5, 2, 10, 0.95));
                box-shadow: 0 0 50px rgba(147, 51, 234, 0.1), inset 0 0 20px rgba(147, 51, 234, 0.05);
            }
            .qr-scanner-container {
                position: relative;
                padding: 1.5rem;
                background: rgba(255, 255, 255, 0.03);
                border-radius: 2.5rem;
                border: 1px solid rgba(147, 51, 234, 0.3);
                overflow: hidden;
            }
            .qr-scanner-line {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #9333ea, transparent);
                box-shadow: 0 0 15px #9333ea;
                animation: qr-scan 3s ease-in-out infinite;
                z-index: 10;
            }
            @keyframes qr-scan {
                0%, 100% { top: 0%; opacity: 0; }
                10%, 90% { opacity: 1; }
                50% { top: 100%; }
            }
            .cyber-input {
                background: rgba(255, 255, 255, 0.02) !important;
                border: 1px solid rgba(255, 255, 255, 0.05) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .cyber-input:focus {
                background: rgba(147, 51, 234, 0.05) !important;
                border-color: rgba(147, 51, 234, 0.5) !important;
                box-shadow: 0 0 20px rgba(147, 51, 234, 0.1);
            }
            .cyber-badge {
                background: repeating-linear-gradient(45deg, rgba(147, 51, 234, 0.1), rgba(147, 51, 234, 0.1) 10px, transparent 10px, transparent 20px);
            }
        </style>

        <div class="relative max-w-xl w-full cyber-modal border border-white/10 rounded-[3rem] p-8 sm:p-10 animate-in zoom-in-95 duration-500 shadow-2xl">
            <!-- Close Trigger -->
            <button onclick="closePaymentModal()" class="absolute top-6 right-6 w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gray-500 hover:text-white hover:bg-rose-500/20 transition-all border border-white/5 z-20">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            
            <!-- Step 1: Scan & Pay -->
            <div id="payment-step-1" class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="text-center space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 mx-auto">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                        <span class="text-[8px] font-black orbitron text-purple-400 uppercase tracking-[0.3em]">STEP 01: SCAN PROTOCOL</span>
                    </div>
                    <h3 class="orbitron text-xl font-black text-white italic uppercase tracking-tighter">INITIATE <span class="text-purple-500">TRANSFER</span></h3>
                    <p id="modal-package-name" class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] italic">ELITE TRADER MODULE</p>
                </div>

                <div class="flex flex-col items-center gap-6">
                    <div class="qr-scanner-container w-full max-w-[240px] group">
                        <div class="qr-scanner-line"></div>
                        <div class="bg-white rounded-3xl p-4 shadow-2xl overflow-hidden aspect-square flex items-center justify-center border-4 border-black/5">
                            <img id="modal-qr-code" src="" alt="Payment QR" class="w-full h-full object-contain grayscale-0 group-hover:scale-110 transition-transform duration-700">
                        </div>
                    </div>

                    <div class="w-full grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-white/2 border border-white/5 flex flex-col items-center justify-center text-center">
                            <span class="text-[7px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Requisition</span>
                            <div id="modal-price" class="text-lg font-black orbitron text-white italic tracking-tighter uppercase">₹ 0</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-white/2 border border-white/5 relative group flex flex-col items-center justify-center text-center overflow-hidden">
                            <span class="text-[7px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Neural ID</span>
                            <div id="modal-upi-id" class="text-[10px] font-bold text-amber-400 lowercase truncate w-full px-2">-</div>
                            <button onclick="copyUPI(event)" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-amber-400/10 text-amber-500 flex items-center justify-center hover:bg-amber-400 hover:text-black transition-all">
                                <i data-lucide="copy" class="w-3 h-3"></i>
                            </button>
                        </div>
                    </div>

                    <div id="modal-instructions" class="cyber-badge w-full p-4 rounded-2xl border border-purple-500/10 text-[9px] font-bold text-gray-500 uppercase tracking-widest leading-loose italic text-center">
                        SCAN QR • EXECUTE TRANSFER • CLICK NEXT
                    </div>

                    <div class="w-full flex gap-4 pt-2">
                        <a id="upi-deep-link" href="#" class="flex-1 py-4 bg-white/5 border border-white/10 rounded-2xl font-black orbitron text-[9px] uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-white/10 transition-all">
                            <i data-lucide="smartphone" class="w-4 h-4 text-purple-500"></i> Neural Pay
                        </a>
                        <button onclick="toggleStep(2)" class="flex-[2] py-4 bg-purple-600 hover:bg-purple-500 text-white rounded-2xl font-black orbitron uppercase tracking-[0.3em] text-[10px] transition-all shadow-xl shadow-purple-600/20 italic flex items-center justify-center gap-2">
                            NEXT: VERIFICATION <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Step 2: Verification Form -->
            <div id="payment-step-2" class="hidden space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="text-center space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 mx-auto">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span class="text-[8px] font-black orbitron text-amber-400 uppercase tracking-[0.3em]">STEP 02: VERIFY UPGRADE</span>
                    </div>
                    <h3 class="orbitron text-xl font-black text-white italic uppercase tracking-tighter">DEPLOY <span class="text-amber-500">CREDENTIALS</span></h3>
                </div>

                <form id="payment-form" onsubmit="handlePaymentSubmit(event)" class="space-y-6">
                    @csrf
                    <input type="hidden" name="package_id" id="form-package-id">
                    <input type="hidden" name="amount" id="form-amount">
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-widest italic">Verification UTR (12-Digit)</label>
                            <span class="text-[7px] font-bold text-purple-500/50 uppercase tracking-widest">REQUIRED</span>
                        </div>
                        <input type="text" name="transaction_id" required placeholder="Enter UPI Reference Number" 
                            class="cyber-input w-full rounded-2xl px-6 py-4 text-white font-black orbitron text-xs outline-none placeholder:text-gray-800 tracking-widest italic">
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between px-1">
                            <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-widest italic">Payment Screenshot</label>
                            <span class="text-[7px] font-bold text-amber-500 uppercase tracking-widest">MANDATORY</span>
                        </div>
                        <label class="cyber-input w-full rounded-2xl px-6 py-4 flex items-center gap-4 cursor-pointer group hover:bg-white/5 transition-all">
                            <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-gray-500 group-hover:text-amber-500 group-hover:bg-amber-500/20 transition-all">
                                <i data-lucide="upload" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[9px] font-bold orbitron text-gray-600 group-hover:text-gray-300 uppercase tracking-widest truncate">Upload Transfer Proof...</span>
                            <input type="file" name="screenshot" accept="image/*" required class="hidden" onchange="this.previousElementSibling.innerText = this.files[0].name; this.previousElementSibling.classList.add('text-amber-400')">
                        </label>
                    </div>

                    <div class="flex gap-4 pt-2">
                        <button type="button" onclick="toggleStep(1)" class="flex-1 py-4 rounded-2xl border border-white/5 bg-white/2 text-gray-500 font-black orbitron uppercase tracking-widest text-[9px] hover:bg-white/5 transition-all flex items-center justify-center gap-2">
                             <i data-lucide="chevron-left" class="w-4 h-4"></i> BACK
                        </button>
                        <button type="submit" id="submit-btn" class="flex-[2] py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:scale-[1.02] text-white rounded-2xl font-black orbitron uppercase tracking-[0.3em] text-[10px] transition-all shadow-xl shadow-purple-600/20 italic group relative overflow-hidden">
                            <span class="relative z-10">AUTHORIZE UPGRADE</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    function toggleStep(step) {
        const s1 = document.getElementById('payment-step-1');
        const s2 = document.getElementById('payment-step-2');
        
        if(step === 2) {
            s1.classList.add('hidden');
            s2.classList.remove('hidden');
        } else {
            s2.classList.add('hidden');
            s1.classList.remove('hidden');
        }
    }

    function openPaymentModal(package) {
        document.getElementById('modal-package-name').innerText = package.name + ' MODULE';
        document.getElementById('modal-price').innerText = '₹ ' + Number(package.price).toLocaleString();
        document.getElementById('modal-upi-id').innerText = package.upi_id;
        document.getElementById('modal-qr-code').src = package.qr_code ? '/' + package.qr_code : '/assets/img/default-qr.png';
        
        // Reset state
        toggleStep(1);
        document.getElementById('payment-form').reset();
        const uploadLabel = document.querySelector('label.cyber-input span');
        if(uploadLabel) {
            uploadLabel.innerText = "Neural Snapshot Sequence...";
            uploadLabel.classList.remove('text-amber-400');
        }

        // Populate inputs
        document.getElementById('form-package-id').value = package.id;
        document.getElementById('form-amount').value = package.price;
        
        // UPI Deep Link
        const upiName = package.upi_name || 'ALGO TRADE';
        const deepLink = `upi://pay?pa=${package.upi_id}&pn=${encodeURIComponent(upiName)}&am=${package.price}&cu=INR`;
        document.getElementById('upi-deep-link').href = deepLink;

        // Custom Instructions
        if (package.payment_info) {
            document.getElementById('modal-instructions').innerHTML = package.payment_info.replace(/\n/g, '<br>');
        }

        const modal = document.getElementById('payment-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        lucide.createIcons();
    }

    function closePaymentModal() {
        const modal = document.getElementById('payment-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function copyUPI(event) {
        const upi = document.getElementById('modal-upi-id').innerText;
        navigator.clipboard.writeText(upi).then(() => {
            const btn = event.currentTarget || event.target.closest('button');
            const icon = btn.querySelector('i');
            lucide.createIcons({
                attrs: { 'data-lucide': 'check' },
                name: 'check',
                element: icon
            });
            setTimeout(() => {
                lucide.createIcons({
                    attrs: { 'data-lucide': 'copy' },
                    name: 'copy',
                    element: icon
                });
            }, 2000);
        });
    }

    async function handlePaymentSubmit(e) {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        const span = btn.querySelector('span');
        const originalText = span.innerText;
        
        btn.disabled = true;
        span.innerText = 'EXECUTING VERIFICATION...';
        btn.classList.add('opacity-50', 'cursor-not-allowed');

        const formData = new FormData(e.target);

        try {
            const response = await fetch('{{ route("payment.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.success) {
                span.innerText = 'PROTOCOL ACTIVATED';
                btn.classList.add('bg-emerald-500');
                setTimeout(() => {
                    window.location.href = '{{ route("account.profile") }}';
                }, 1500);
            } else {
                alert(result.message || 'Verification failed. Please check your data.');
                btn.disabled = false;
                span.innerText = originalText;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        } catch (error) {
            console.error('Payment error:', error);
            alert('A neural connection error occurred. Please try again.');
            btn.disabled = false;
            span.innerText = originalText;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
</script>
@endpush
@endsection

@extends('layouts.app')

@section('title', 'Pricing Tiers | Emperor Stock Predictor')

@section('content')
<main class="min-h-screen flex flex-col items-center justify-center p-6 py-20 relative z-10 font-bold uppercase italic tracking-tighter">
    <div class="text-center mb-16">
        <h1 class="orbitron text-3xl sm:text-5xl font-black mb-4 tracking-tighter text-white">CHOOSE YOUR <span class="text-purple-500">LEVEL</span></h1>
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
                    <button 
                        data-id="{{ $package->id }}"
                        data-name="{{ $package->name }}"
                        data-price="{{ $package->price }}"
                        data-upi="{{ $package->upi_id }}"
                        data-qr="{{ $package->qr_code }}"
                        data-info="{{ $package->payment_info }}"
                        data-upi-name="{{ $package->upi_name ?? 'Emperor Stock Predictor' }}"
                        data-wallet="{{ $walletBalance }}"
                        onclick='openPaymentModal(this)' 
                        class="w-full py-4 rounded-2xl font-black tracking-widest text-sm hover:scale-105 active:scale-95 transition-all shadow-xl uppercase italic group/btn relative overflow-hidden" 
                        style="background-color: {{ $package->button_color ?? '#fbbf24' }}; color: {{ ($package->button_color && $package->button_color != '#fbbf24') ? 'white' : 'black' }};">
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

    <!-- Wallet-Only Premium Upgrade Modal -->
    <div id="payment-modal" class="fixed inset-0 z-[999999] hidden items-center justify-center p-4 sm:p-6 transition-all duration-500">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/90 backdrop-blur-3xl" onclick="closePaymentModal()"></div>
        
        <!-- Ambient glow effects -->
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-purple-600/8 blur-[150px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[300px] h-[300px] bg-indigo-600/5 blur-[120px] rounded-full pointer-events-none"></div>

        <style>
            .premium-modal-card {
                background: linear-gradient(170deg, rgba(18, 8, 32, 0.97), rgba(6, 2, 12, 0.99));
                box-shadow: 
                    0 0 0 1px rgba(147, 51, 234, 0.15),
                    0 25px 80px rgba(0, 0, 0, 0.8),
                    0 0 100px rgba(147, 51, 234, 0.06),
                    inset 0 1px 0 rgba(255, 255, 255, 0.06);
            }
            .premium-modal-card::before {
                content: '';
                position: absolute;
                top: -1px;
                left: 20%;
                right: 20%;
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(147,51,234,0.7), rgba(99,102,241,0.5), transparent);
                border-radius: 2px;
            }
            .premium-modal-card::after {
                content: '';
                position: absolute;
                bottom: -1px;
                left: 30%;
                right: 30%;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(147,51,234,0.3), transparent);
            }
            @keyframes icon-glow {
                0%, 100% { 
                    box-shadow: 0 0 25px rgba(147,51,234,0.15), 0 0 50px rgba(147,51,234,0.05);
                    transform: scale(1);
                }
                50% { 
                    box-shadow: 0 0 40px rgba(147,51,234,0.25), 0 0 80px rgba(147,51,234,0.1);
                    transform: scale(1.03);
                }
            }
            @keyframes ring-rotate {
                from { transform: translate(-50%, -50%) rotate(0deg); }
                to { transform: translate(-50%, -50%) rotate(360deg); }
            }
            @keyframes ring-rotate-reverse {
                from { transform: translate(-50%, -50%) rotate(360deg); }
                to { transform: translate(-50%, -50%) rotate(0deg); }
            }
            .modal-pay-btn {
                background: linear-gradient(135deg, #7c3aed, #6366f1, #8b5cf6);
                background-size: 200% 200%;
                animation: gradient-shift 4s ease infinite;
            }
            .modal-pay-btn:hover {
                box-shadow: 0 0 50px rgba(147,51,234,0.35), 0 15px 40px rgba(99,102,241,0.2);
            }
            @keyframes gradient-shift {
                0%, 100% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
            }
        </style>

        <div class="relative w-full max-w-[420px] premium-modal-card rounded-[2rem] p-8 sm:p-10 animate-in zoom-in-95 fade-in duration-500 z-10">
            <!-- Close -->
            <button onclick="closePaymentModal()" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-500 hover:text-white hover:bg-rose-500/20 hover:border-rose-500/30 transition-all z-20 group">
                <i data-lucide="x" class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300"></i>
            </button>

            <input type="hidden" id="form-package-id">

            <div class="space-y-7">
                <!-- Premium Header with Animated Icon -->
                <div class="text-center space-y-4 pt-1">
                    <div class="relative w-20 h-20 mx-auto">
                        <!-- Outer rotating ring -->
                        <div class="absolute top-1/2 left-1/2 w-full h-full rounded-full border border-dashed border-purple-500/20" style="animation: ring-rotate 12s linear infinite;"></div>
                        <!-- Inner counter-rotating ring -->
                        <div class="absolute top-1/2 left-1/2 w-[70%] h-[70%] rounded-full border border-purple-500/10" style="animation: ring-rotate-reverse 8s linear infinite;"></div>
                        <!-- Icon center -->
                        <div class="absolute inset-[15%] rounded-2xl bg-gradient-to-br from-purple-600/25 to-indigo-600/25 border border-purple-500/30 flex items-center justify-center backdrop-blur-sm" style="animation: icon-glow 3s ease-in-out infinite;">
                            <i data-lucide="zap" class="w-7 h-7 text-purple-400 drop-shadow-[0_0_8px_rgba(147,51,234,0.6)]"></i>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="orbitron text-xl font-black text-white italic uppercase tracking-tight">Upgrade <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">Protocol</span></h3>
                        <p id="modal-package-name" class="text-[9px] font-bold orbitron text-purple-400/50 uppercase tracking-[0.3em]">-</p>
                    </div>
                </div>

                <!-- Balance Summary Card -->
                <div class="rounded-[1.25rem] bg-white/[0.015] border border-white/[0.06] overflow-hidden backdrop-blur-sm">
                    <!-- Wallet Balance -->
                    <div class="px-5 py-4 flex items-center justify-between border-b border-white/[0.04] group hover:bg-white/[0.02] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500/15 to-emerald-600/5 border border-emerald-500/10 flex items-center justify-center group-hover:border-emerald-500/25 transition-colors">
                                <i data-lucide="wallet" class="w-4 h-4 text-emerald-500"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold orbitron text-gray-300 uppercase tracking-widest">Wallet Balance</span>
                                <span class="text-[7px] font-medium text-gray-600 uppercase tracking-wider">Available Credits</span>
                            </div>
                        </div>
                        <span class="text-sm font-black orbitron text-emerald-400">₹ <span id="modal-wallet-balance">0</span></span>
                    </div>

                    <!-- Plan Price -->
                    <div class="px-5 py-4 flex items-center justify-between border-b border-white/[0.04] group hover:bg-white/[0.02] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500/15 to-purple-600/5 border border-purple-500/10 flex items-center justify-center group-hover:border-purple-500/25 transition-colors">
                                <i data-lucide="tag" class="w-4 h-4 text-purple-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold orbitron text-gray-300 uppercase tracking-widest">Plan Price</span>
                                <span class="text-[7px] font-medium text-gray-600 uppercase tracking-wider">One-time Debit</span>
                            </div>
                        </div>
                        <span class="text-sm font-black orbitron text-white">₹ <span id="modal-package-price">0</span></span>
                    </div>

                    <!-- Remaining Balance -->
                    <div class="px-5 py-4 flex items-center justify-between bg-gradient-to-r from-white/[0.01] to-transparent group hover:from-white/[0.03] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500/15 to-indigo-600/5 border border-indigo-500/10 flex items-center justify-center group-hover:border-indigo-500/25 transition-colors">
                                <i data-lucide="arrow-right-left" class="w-4 h-4 text-indigo-400"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold orbitron text-gray-300 uppercase tracking-widest">After Upgrade</span>
                                <span class="text-[7px] font-medium text-gray-600 uppercase tracking-wider">Remaining Balance</span>
                            </div>
                        </div>
                        <span id="modal-remaining" class="text-sm font-black orbitron text-emerald-400">₹ 0</span>
                    </div>
                </div>

                <!-- Action Area -->
                <div class="space-y-4">
                    <!-- Premium Pay Button -->
                    <button id="wallet-pay-btn" onclick="handleWalletUpgrade()" class="modal-pay-btn w-full py-5 text-white rounded-2xl font-black orbitron uppercase tracking-[0.2em] text-[11px] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] italic flex items-center justify-center gap-3 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i data-lucide="wallet" class="w-4.5 h-4.5 relative z-10"></i>
                        <span class="relative z-10">Pay Using Wallet</span>
                    </button>

                    <!-- Insufficient Balance Warning -->
                    <div id="wallet-insufficient-msg" class="hidden space-y-3">
                        <div class="p-4 rounded-xl bg-rose-500/[0.05] border border-rose-500/15 text-center space-y-2">
                            <div class="flex items-center justify-center gap-2">
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-500"></i>
                                <p class="text-[9px] font-black orbitron text-rose-400 uppercase tracking-widest">Insufficient Balance</p>
                            </div>
                            <p class="text-[8px] font-medium text-rose-400/50 normal-case not-italic tracking-normal leading-relaxed">Your wallet doesn't have enough funds for this plan. Please add credits to proceed.</p>
                        </div>
                        <a href="{{ route('account.wallet.index') }}" class="block w-full py-4 rounded-xl bg-white/[0.03] border border-white/[0.08] text-center text-[9px] font-black orbitron text-gray-300 uppercase tracking-widest hover:bg-purple-500/10 hover:border-purple-500/20 hover:text-white transition-all duration-300 group">
                            <span class="flex items-center justify-center gap-2.5">
                                <i data-lucide="plus-circle" class="w-4 h-4 text-purple-500 group-hover:scale-110 transition-transform"></i>
                                Add Funds to Wallet
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Security Footer -->
                <div class="flex items-center justify-center gap-2.5 pt-1">
                    <div class="flex items-center gap-1">
                        <i data-lucide="shield-check" class="w-3 h-3 text-emerald-500/50"></i>
                        <span class="text-[7px] font-bold orbitron text-gray-600 uppercase tracking-[0.15em]">256-bit Encrypted</span>
                    </div>
                    <span class="text-gray-800">•</span>
                    <div class="flex items-center gap-1">
                        <i data-lucide="lock" class="w-2.5 h-2.5 text-emerald-500/50"></i>
                        <span class="text-[7px] font-bold orbitron text-gray-600 uppercase tracking-[0.15em]">Secure Transaction</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    function openPaymentModal(btn) {
        const pkg = {
            id: btn.getAttribute('data-id'),
            name: btn.getAttribute('data-name'),
            price: Number(btn.getAttribute('data-price')),
            wallet_balance: Number(btn.getAttribute('data-wallet'))
        };

        document.getElementById('modal-package-name').innerText = pkg.name;
        document.getElementById('modal-package-price').innerText = pkg.price.toLocaleString('en-IN');
        document.getElementById('modal-wallet-balance').innerText = pkg.wallet_balance.toLocaleString('en-IN');
        document.getElementById('form-package-id').value = pkg.id;

        // Calculate remaining balance
        const remaining = pkg.wallet_balance - pkg.price;
        const remainEl = document.getElementById('modal-remaining');
        remainEl.innerText = '₹ ' + Math.max(0, remaining).toLocaleString('en-IN');
        remainEl.className = remaining >= 0
            ? 'text-sm font-black orbitron text-emerald-400'
            : 'text-sm font-black orbitron text-rose-500';

        // Wallet sufficient check
        const walletBtn = document.getElementById('wallet-pay-btn');
        const insufficientMsg = document.getElementById('wallet-insufficient-msg');

        if (pkg.wallet_balance >= pkg.price) {
            walletBtn.disabled = false;
            walletBtn.classList.remove('opacity-40', 'grayscale', 'cursor-not-allowed', 'pointer-events-none');
            insufficientMsg.classList.add('hidden');
        } else {
            walletBtn.disabled = true;
            walletBtn.classList.add('opacity-40', 'grayscale', 'cursor-not-allowed', 'pointer-events-none');
            insufficientMsg.classList.remove('hidden');
        }

        // Hide navbar so it doesn't overlap
        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = 'none';

        const modal = document.getElementById('payment-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Full scroll lock
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
        document.body.style.top = `-${window.scrollY}px`;
        document.body.dataset.scrollY = window.scrollY;

        lucide.createIcons();
    }

    function closePaymentModal() {
        const modal = document.getElementById('payment-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Restore scroll
        const scrollY = document.body.dataset.scrollY || 0;
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
        document.body.style.position = '';
        document.body.style.width = '';
        document.body.style.top = '';
        window.scrollTo(0, parseInt(scrollY));

        // Show navbar again
        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = '';
    }

    async function handleWalletUpgrade() {
        const pkgId = document.getElementById('form-package-id').value;
        const btn = document.getElementById('wallet-pay-btn');
        const originalHTML = btn.innerHTML;

        if (!confirm('Authorize instant upgrade using your neural wallet balance?')) return;

        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> <span class="relative z-10">Processing...</span>';
        lucide.createIcons();

        try {
            const response = await fetch('{{ route("account.upgrade-plan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ package_id: pkgId })
            });

            const result = await response.json();

            if (result.success) {
                btn.innerHTML = '<i data-lucide="check-circle" class="w-5 h-5"></i> <span class="relative z-10">Upgrade Complete!</span>';
                btn.classList.add('!bg-emerald-600');
                btn.style.background = 'linear-gradient(135deg, #059669, #10b981)';
                lucide.createIcons();
                setTimeout(() => window.location.href = '{{ route("account.profile") }}', 1200);
            } else {
                alert(result.message || 'Upgrade failed. Please try again.');
                btn.disabled = false;
                btn.innerHTML = originalHTML;
                lucide.createIcons();
            }
        } catch (error) {
            alert('A connection error occurred. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalHTML;
            lucide.createIcons();
        }
    }
</script>
@endpush
@endsection

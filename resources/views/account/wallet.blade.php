@extends('layouts.dashboard')

@section('title', 'My Wallet | Emperor Stock Predictor')

@section('content')
<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                My <span class="text-amber-500 text-glow">Wallet</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium mt-1 tracking-wide leading-none">Add funds and view your transaction history</p>
        </div>
    </div>

    <!-- WALLET MANAGEMENT SECTION -->
    <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05] relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4">
                    <i data-lucide="wallet" class="w-6 h-6 text-amber-500"></i>
                    <h3 class="text-xl font-bold text-white tracking-wide">Wallet Balance</h3>
                </div>
                <button onclick="openFundsModal()" class="px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-2xl text-sm font-bold uppercase tracking-[0.1em] hover:scale-105 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all">Add Funds</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Balance Card -->
                <div class="lg:col-span-1">
                    <div class="p-8 rounded-[2.5rem] bg-gradient-to-br from-amber-500/10 to-orange-500/5 border border-amber-500/20 relative overflow-hidden group/card h-full flex flex-col justify-center">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/20 blur-[60px] rounded-full group-hover/card:scale-150 transition-transform duration-1000"></div>
                        <p class="text-xs font-semibold text-amber-500/60 uppercase tracking-widest mb-4">Available Balance</p>
                        <h4 class="text-5xl font-black orbitron text-white italic tracking-tighter drop-shadow-[0_0_15px_rgba(245,158,11,0.4)]">
                            &#8377;{{ number_format($user->wallet_balance, 2) }}
                        </h4>
                        <div class="mt-8 flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-xs font-medium text-emerald-500/80 tracking-wide">Secured & Encrypted</span>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="lg:col-span-2">
                    <div class="space-y-4">
                        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-widest px-2">Recent Transactions</h4>
                        <div class="max-h-[300px] overflow-y-auto pr-2 no-scrollbar space-y-3">
                            @forelse($transactions as $tx)
                            <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] flex items-center justify-between hover:bg-white/[0.04] transition-all group/tx">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl {{ $tx->type === 'credit' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="{{ $tx->type === 'credit' ? 'arrow-down-left' : 'arrow-up-right' }}" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white">{{ $tx->description }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $tx->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black orbitron {{ $tx->type === 'credit' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $tx->type === 'credit' ? '+' : '-' }}&#8377;{{ number_format($tx->amount, 2) }}
                                    </p>
                                    @php
                                        $statusColor = match($tx->status) {
                                            'pending' => 'text-amber-500/80',
                                            'approved', 'success' => 'text-emerald-500/80',
                                            'rejected' => 'text-rose-500/80',
                                            default => 'text-gray-600'
                                        };
                                    @endphp
                                    <p class="text-xs {{ $statusColor }} capitalize mt-0.5 font-semibold">{{ $tx->status }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="py-12 text-center border border-dashed border-white/10 rounded-3xl">
                                <p class="text-sm font-medium text-gray-600">No transactions yet.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success/Error Alerts -->
    @if(session('success'))
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-500 text-sm font-semibold">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center gap-3 text-rose-500 text-sm font-semibold">
        <i data-lucide="alert-circle" class="w-4 h-4"></i>
        {{ session('error') }}
    </div>
    @endif
</div>

<!-- MODAL: 4-STEP ADD FUNDS WIZARD -->
<div id="add-funds-modal" class="fixed inset-0 z-[999999] hidden items-center justify-center p-4 sm:p-6 transition-all duration-500">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/90 backdrop-blur-3xl" onclick="closeFundsModal()"></div>
    
    <!-- Ambient glow -->
    <div class="absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-amber-600/6 blur-[120px] rounded-full pointer-events-none"></div>

    <style>
        .funds-modal-card {
            background: linear-gradient(170deg, rgba(18, 10, 5, 0.97), rgba(6, 2, 12, 0.99));
            box-shadow: 
                0 0 0 1px rgba(245, 158, 11, 0.12),
                0 25px 80px rgba(0, 0, 0, 0.8),
                0 0 80px rgba(245, 158, 11, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        .funds-modal-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 20%;
            right: 20%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.6), rgba(234,88,12,0.4), transparent);
            border-radius: 2px;
        }
        @keyframes scan-line {
            0%, 100% { top: 0; opacity: 0.3; }
            50% { top: calc(100% - 2px); opacity: 1; }
        }
        @keyframes checkmark-draw {
            0% { stroke-dashoffset: 50; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes circle-fill {
            0% { transform: scale(0); opacity: 0; }
            60% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(2); opacity: 0; }
        }
        .step-indicator {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .step-indicator.active {
            background: linear-gradient(135deg, #f59e0b, #ea580c);
            color: black;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }
        .step-indicator.completed {
            background: rgba(16, 185, 129, 0.15);
            border-color: rgba(16, 185, 129, 0.4);
            color: #10b981;
        }
        .step-connector {
            transition: background 0.5s ease;
        }
        .step-connector.active {
            background: linear-gradient(90deg, #f59e0b, #ea580c) !important;
        }
    </style>

    <div class="relative w-full max-w-[440px] funds-modal-card border border-white/[0.06] rounded-[2rem] p-8 sm:p-10 animate-in zoom-in-95 fade-in duration-500 z-10 max-h-[92vh] overflow-y-auto no-scrollbar">
        <!-- Close -->
        <button onclick="closeFundsModal()" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-500 hover:text-white hover:bg-rose-500/20 hover:border-rose-500/30 transition-all z-20 group">
            <i data-lucide="x" class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300"></i>
        </button>

        <!-- Step Indicators (4 steps) -->
        <div class="flex items-center justify-center gap-0 mb-8 pt-1">
            <div id="step-ind-1" class="step-indicator active w-7 h-7 rounded-full flex items-center justify-center text-[8px] font-black orbitron border border-transparent">1</div>
            <div id="step-conn-1" class="step-connector w-8 h-[2px] bg-white/10 rounded-full"></div>
            <div id="step-ind-2" class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-[8px] font-black orbitron bg-white/5 border border-white/10 text-gray-500">2</div>
            <div id="step-conn-2" class="step-connector w-8 h-[2px] bg-white/10 rounded-full"></div>
            <div id="step-ind-3" class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-[8px] font-black orbitron bg-white/5 border border-white/10 text-gray-500">3</div>
            <div id="step-conn-3" class="step-connector w-8 h-[2px] bg-white/10 rounded-full"></div>
            <div id="step-ind-4" class="step-indicator w-7 h-7 rounded-full flex items-center justify-center text-[8px] font-black orbitron bg-white/5 border border-white/10 text-gray-500">4</div>
        </div>

        <!-- qrcode.js CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <form id="funds-form" action="{{ route('account.wallet.topup.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payment_request_id" id="payment_request_id" value="">

            <!-- ==================== STEP 1: ENTER AMOUNT ==================== -->
            <div id="fund-step-1" class="space-y-6">
                <div class="text-center space-y-2">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-amber-500/15 to-orange-500/10 border border-amber-500/20 flex items-center justify-center mb-3">
                        <i data-lucide="indian-rupee" class="w-7 h-7 text-amber-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white tracking-tight">Enter Amount</h3>
                    <p class="text-sm text-gray-500">How much would you like to add to your wallet?</p>
                </div>

                <!-- Amount Input -->
                <div class="space-y-2.5">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-widest pl-1">Amount (&#8377;)</label>
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center group-focus-within:bg-amber-500/20 transition-colors">
                            <span class="text-amber-500 font-black orbitron text-lg">&#8377;</span>
                        </div>
                        <input type="number" name="amount" id="fund-amount" min="100" step="1" required 
                            class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl pl-18 pr-6 py-5 text-white text-lg font-black orbitron tracking-tight focus:outline-none focus:border-amber-500/40 focus:bg-white/[0.04] transition-all placeholder:text-gray-700 text-center" 
                            placeholder="1,000" style="padding-left: 4.5rem;">
                    </div>
                    <p class="text-xs text-gray-600 text-center">Minimum: &#8377;100  <br> Maximum: &#8377;50,000</p>
                </div

                <!-- Quick Amount Buttons -->
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" onclick="document.getElementById('fund-amount').value=500" class="py-2.5 rounded-lg bg-white/[0.03] border border-white/[0.06] text-xs font-semibold text-gray-400 hover:text-amber-400 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all">&#8377;500</button>
                    <button type="button" onclick="document.getElementById('fund-amount').value=1000" class="py-2.5 rounded-lg bg-white/[0.03] border border-white/[0.06] text-xs font-semibold text-gray-400 hover:text-amber-400 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all">&#8377;1,000</button>
                    <button type="button" onclick="document.getElementById('fund-amount').value=2000" class="py-2.5 rounded-lg bg-white/[0.03] border border-white/[0.06] text-xs font-semibold text-gray-400 hover:text-amber-400 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all">&#8377;2,000</button>
                    <button type="button" onclick="document.getElementById('fund-amount').value=5000" class="py-2.5 rounded-lg bg-white/[0.03] border border-white/[0.06] text-xs font-semibold text-gray-400 hover:text-amber-400 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all">&#8377;5,000</button>
                </div>

                <!-- Next Button -->
                <button type="button" onclick="goToStep(2)" class="w-full py-5 mt-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-2xl font-bold uppercase tracking-[0.1em] text-sm transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(245,158,11,0.3)] active:scale-[0.98] flex items-center justify-center gap-3 group min-h-[56px]">
                    <span>Continue to Payment</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <!-- ==================== STEP 2: QR CODE + UPI ID ==================== -->
            <div id="fund-step-2" class="hidden space-y-6">
                <div class="text-center space-y-2">
                    <h3 class="text-lg font-bold text-white tracking-tight">Make Payment</h3>
                    <p class="text-sm text-gray-500">Scan the QR code or use the UPI ID below to send payment</p>
                </div>

                <!-- Amount Display -->
                <div class="flex items-center justify-center gap-2 py-2">
                    <span class="text-sm text-gray-500">Amount to Pay: &#8377;</span>
                    <span id="step2-amount" class="text-sm font-black orbitron text-amber-400">0</span>
                </div>

                <!-- QR Code + UPI Section -->
                @if(!empty($walletSettings['qr_code']) || !empty($walletSettings['upi_id']))
                <div class="flex flex-col items-center gap-5">
                    @if(!empty($walletSettings['upi_id']))
                    <div class="relative">
                        <div class="relative w-44 h-44 p-3 bg-white/[0.03] rounded-[1.75rem] border border-amber-500/20 overflow-hidden group/qr">
                            <!-- Scan line -->
                            <div class="absolute left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent z-10" style="animation: scan-line 2.5s ease-in-out infinite;"></div>
                            <!-- Corner decorations -->
                            <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-amber-500/40 rounded-tl-lg"></div>
                            <div class="absolute top-0 right-0 w-5 h-5 border-t-2 border-r-2 border-amber-500/40 rounded-tr-lg"></div>
                            <div class="absolute bottom-0 left-0 w-5 h-5 border-b-2 border-l-2 border-amber-500/40 rounded-bl-lg"></div>
                            <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-amber-500/40 rounded-br-lg"></div>
                            <div class="bg-white rounded-2xl p-2 h-full overflow-hidden flex items-center justify-center">
                                <div id="dynamic-qrcode"></div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="w-full p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-center">
                        <p class="text-sm font-semibold text-rose-500">UPI not configured yet. Contact admin.</p>
                    </div>
                    @endif

                    @if(!empty($walletSettings['upi_id']))
                    <div class="w-full p-4 rounded-xl bg-white/[0.02] border border-white/[0.06] space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="space-y-0.5">
                                <p class="text-xs text-gray-500 uppercase tracking-widest">UPI ID</p>
                                <p class="text-sm font-bold text-amber-400">{{ $walletSettings['upi_id'] }}</p>
                            </div>
                            <button type="button" onclick="copyUPIWallet()" class="w-9 h-9 rounded-lg bg-amber-500/10 border border-amber-500/15 text-amber-500 flex items-center justify-center hover:bg-amber-500 hover:text-black transition-all">
                                <i data-lucide="copy" class="w-3.5 h-3.5" id="copy-icon-wallet"></i>
                            </button>
                        </div>
                        @if(!empty($walletSettings['upi_name']))
                        <div class="flex items-center gap-2 pt-1 border-t border-white/[0.04]">
                            <i data-lucide="user-check" class="w-3 h-3 text-emerald-500/50"></i>
                            <span class="text-xs text-gray-500">Account Name: <span class="text-white font-semibold">{{ $walletSettings['upi_name'] }}</span></span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                <!-- Navigation -->
                <div class="flex gap-3">
                    <button type="button" onclick="goToStep(1)" class="flex-1 py-4 rounded-xl bg-white/[0.03] border border-white/[0.06] text-gray-400 font-semibold text-sm hover:bg-white/[0.06] transition-all flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back
                    </button>
                    <button type="button" onclick="goToStep(3)" class="flex-[2] py-4 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl font-bold text-sm transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(245,158,11,0.25)] flex items-center justify-center gap-2.5 group">
                        <span>I Have Paid</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- ==================== STEP 3: ENTER UTR ==================== -->
            <div id="fund-step-3" class="hidden space-y-6">
                <div class="text-center space-y-6 py-4">
                    <div class="space-y-2">
                        <h3 class="text-lg font-bold text-white tracking-tight">Confirm Payment</h3>
                        <p class="text-sm text-gray-500 max-w-xs mx-auto">Enter the UTR / Reference number from your payment app to confirm the transaction.</p>
                    </div>

                    <!-- Transfer Summary -->
                    <div class="rounded-xl bg-white/[0.02] border border-white/[0.06] p-5 text-left space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Amount Paid</span>
                            <span id="confirm-amount" class="text-sm font-black orbitron text-emerald-400">&#8377; 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Status</span>
                            <span class="text-sm font-semibold text-amber-500 flex items-center gap-1.5" id="utr-status">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse border-indicator"></span>
                                Waiting for UTR
                            </span>
                        </div>
                    </div>

                    <!-- UTR Input -->
                    <div class="space-y-2.5 text-left">
                        <div class="flex items-center justify-between pl-1 pr-1">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-widest">UTR / Reference ID</label>
                            <span class="text-xs font-medium text-rose-500/70">Required</span>
                        </div>
                        <div class="relative group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center group-focus-within:bg-emerald-500/20 transition-colors">
                                <i data-lucide="hash" class="w-3.5 h-3.5 text-emerald-400"></i>
                            </div>
                            <input type="text" id="verify_utr_input" class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl pl-16 pr-6 py-4 text-white text-sm font-semibold outline-none focus:border-emerald-500/40 focus:bg-white/[0.04] transition-all placeholder:text-gray-700" placeholder="Enter 12-digit UTR number" required>
                        </div>
                        <p id="utr-error" class="hidden text-xs font-semibold text-rose-500 text-center mt-2"></p>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex gap-3">
                    <button type="button" onclick="goToStep(2)" class="flex-1 py-4 rounded-xl bg-white/[0.03] border border-white/[0.06] text-gray-400 font-semibold text-sm hover:bg-white/[0.06] transition-all flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back
                    </button>
                    <button type="button" onclick="verifyUtr()" id="verify-utr-btn" class="flex-[2] py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-bold text-sm transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(16,185,129,0.25)] flex items-center justify-center gap-2 group">
                        <span>Verify UTR</span>
                        <i data-lucide="check-circle" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- ==================== STEP 4: UPLOAD SCREENSHOT ==================== -->
            <div id="fund-step-4" class="hidden space-y-6">
                <div class="text-center space-y-2">
                    <h3 class="text-lg font-bold text-white tracking-tight">Upload Payment Screenshot</h3>
                    <p class="text-sm text-gray-500">Please upload a screenshot of your payment for our team to verify.</p>
                </div>

                <!-- Payment Method -->
                <div class="space-y-2.5">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-widest pl-1">Payment Method</label>
                    <select name="payment_method" required class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl px-5 py-4 text-white text-sm font-semibold outline-none focus:border-purple-500/40 focus:bg-white/[0.04] appearance-none transition-all">
                        <option value="UPI" class="bg-[#0a0514]">UPI / G-Pay / PhonePe</option>
                        <option value="Bank Transfer" class="bg-[#0a0514]">Bank Transfer (IMPS/NEFT)</option>
                        <option value="QR Scan" class="bg-[#0a0514]">QR Code Scan</option>
                    </select>
                </div>

                <!-- Screenshot Upload -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between pl-1 pr-1">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Payment Screenshot</label>
                        <span class="text-xs font-medium text-rose-500/70">Required</span>
                    </div>
                    <label class="w-full bg-white/[0.02] border border-dashed border-white/[0.1] rounded-xl px-5 py-5 flex items-center gap-4 cursor-pointer group hover:bg-white/[0.04] hover:border-purple-500/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 group-hover:border-purple-500/25 transition-all shrink-0">
                            <i data-lucide="image-plus" class="w-5 h-5 text-purple-400"></i>
                        </div>
                        <div class="flex flex-col flex-1 min-w-0">
                            <span id="fund-file-name" class="text-sm font-semibold text-gray-500 group-hover:text-gray-300 truncate transition-colors">Click to upload screenshot...</span>
                            <span class="text-xs text-gray-700 mt-0.5">PNG, JPG, GIF — Max 2MB</span>
                        </div>
                        <input type="file" name="screenshot" accept="image/*" required class="hidden" onchange="handleFileSelect(this)">
                    </label>
                </div>

                <!-- Info Banner -->
                <div class="p-3.5 rounded-xl bg-amber-500/[0.04] border border-amber-500/10 flex items-start gap-3">
                    <i data-lucide="info" class="w-3.5 h-3.5 text-amber-500/60 shrink-0 mt-0.5"></i>
                    <p class="text-xs text-amber-500/60 leading-relaxed">Your payment will be reviewed and credited to your wallet within 5–15 minutes after approval.</p>
                </div>

                <!-- Navigation -->
                <div class="flex gap-3">
                    <button type="button" onclick="goToStep(3)" class="flex-1 py-4 rounded-xl bg-white/[0.03] border border-white/[0.06] text-gray-400 font-semibold text-sm hover:bg-white/[0.06] transition-all flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back
                    </button>
                    <button type="submit" id="submit-funds-btn" class="flex-[2] py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-bold text-sm transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(147,51,234,0.25)] flex items-center justify-center gap-2.5 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i data-lucide="send" class="w-4 h-4 relative z-10"></i>
                        <span class="relative z-10">Submit for Review</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Security Footer -->
        <div class="flex items-center justify-center gap-2.5 mt-6">
            <div class="flex items-center gap-1">
                <i data-lucide="shield-check" class="w-3 h-3 text-emerald-500/40"></i>
                <span class="text-xs text-gray-700 tracking-wide">Encrypted</span>
            </div>
            <span class="text-gray-800">•</span>
            <div class="flex items-center gap-1">
                <i data-lucide="lock" class="w-2.5 h-2.5 text-emerald-500/40"></i>
                <span class="text-xs text-gray-700 tracking-wide">Admin Verified</span>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0%, 100% { transform: translateY(0); opacity: 0.5; }
        50% { transform: translateY(88px); opacity: 1; }
    }
    .text-glow {
        text-shadow: 0 0 10px currentColor;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    let currentFundStep = 1;
    const TOTAL_STEPS = 4;
    let qrCodeInstance = null;

    function openFundsModal() {
        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = 'none';

        const modal = document.getElementById('add-funds-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
        document.body.style.top = `-${window.scrollY}px`;
        document.body.dataset.scrollY = window.scrollY;

        goToStep(1);
        lucide.createIcons();
    }

    function closeFundsModal() {
        const modal = document.getElementById('add-funds-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        const scrollY = document.body.dataset.scrollY || 0;
        document.body.style.overflow = '';
        document.documentElement.style.overflow = '';
        document.body.style.position = '';
        document.body.style.width = '';
        document.body.style.top = '';
        window.scrollTo(0, parseInt(scrollY));

        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = '';
    }

    async function goToStep(step) {
        // Validate step 1 → 2: amount required
        if (currentFundStep === 1 && step === 2) {
            const amountInput = document.getElementById('fund-amount');
            const amount = Number(amountInput.value);
            if (!amountInput.value || amount < 100 || amount > 50000) {
                amountInput.focus();
                amountInput.classList.add('border-rose-500/50');
                setTimeout(() => amountInput.classList.remove('border-rose-500/50'), 2000);
                return;
            }

            // Initialize top-up request
            try {
                const response = await fetch("{{ route('account.wallet.topup.init') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount: amount })
                });
                
                const data = await response.json();
                if (data.success) {
                    document.getElementById('payment_request_id').value = data.payment_request_id;
                    
                    // Generate dynamic QR code
                    const upiId = '{{ $walletSettings["upi_id"] ?? "" }}';
                    const receiverName = '{{ urlencode($walletSettings["upi_name"] ?? "Merchant") }}';
                    
                    if (upiId) {
                        const upiString = `upi://pay?pa=${upiId}&pn=${receiverName}&am=${amount}&cu=INR`;
                        const qrContainer = document.getElementById('dynamic-qrcode');
                        qrContainer.innerHTML = '';
                        qrCodeInstance = new QRCode(qrContainer, {
                            text: upiString,
                            width: 140,
                            height: 140,
                            colorDark : "#000000",
                            colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.H
                        });
                    }

                } else {
                    alert(data.message || 'Error initiating top-up request.');
                    return;
                }
            } catch (err) {
                console.error('Error:', err);
                alert('Network error. Please try again.');
                return;
            }

            // Show amount on step 2 and step 3
            const formattedAmt = '&#8377; ' + amount.toLocaleString('en-IN');
            document.getElementById('step2-amount').innerText = formattedAmt;
            document.getElementById('confirm-amount').innerText = formattedAmt;
        }

        currentFundStep = step;

        // Hide all steps
        for (let i = 1; i <= TOTAL_STEPS; i++) {
            const el = document.getElementById('fund-step-' + i);
            if(el) el.classList.add('hidden');
        }
        const currentEl = document.getElementById('fund-step-' + step);
        if(currentEl) currentEl.classList.remove('hidden');

        // Update indicators
        for (let i = 1; i <= TOTAL_STEPS; i++) {
            const ind = document.getElementById('step-ind-' + i);
            if(!ind) continue;
            ind.classList.remove('active', 'completed');
            ind.className = 'step-indicator w-7 h-7 rounded-full flex items-center justify-center text-[8px] font-black orbitron';

            if (i < step) {
                ind.classList.add('completed', 'border');
                ind.innerHTML = '<svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M5 13l4 4L19 7"/></svg>';
            } else if (i === step) {
                ind.classList.add('active', 'border', 'border-transparent');
                ind.innerHTML = i;
            } else {
                ind.classList.add('bg-white/5', 'border', 'border-white/10', 'text-gray-500');
                ind.innerHTML = i;
            }
        }

        // Update connectors
        for (let i = 1; i < TOTAL_STEPS; i++) {
            const conn = document.getElementById('step-conn-' + i);
            if(conn) conn.classList.toggle('active', step > i);
        }

        lucide.createIcons();
    }

    function copyUPIWallet() {
        const upiId = '{{ $walletSettings["upi_id"] ?? "" }}';
        navigator.clipboard.writeText(upiId).then(() => {
            const icon = document.getElementById('copy-icon-wallet');
            if (icon) {
                icon.setAttribute('data-lucide', 'check');
                lucide.createIcons();
                setTimeout(() => {
                    icon.setAttribute('data-lucide', 'copy');
                    lucide.createIcons();
                }, 2000);
            }
        });
    }

    function handleFileSelect(input) {
        const label = document.getElementById('fund-file-name');
        if (input.files && input.files[0]) {
            label.innerText = input.files[0].name;
            label.classList.add('text-amber-400');
            label.classList.remove('text-gray-500');
        }
    }

    async function verifyUtr() {
        const utrInput = document.getElementById('verify_utr_input');
        const reqId = document.getElementById('payment_request_id').value;
        const utrVal = utrInput.value.trim();
        const errorText = document.getElementById('utr-error');
        const statusSpan = document.getElementById('utr-status');
        const verifyBtn = document.getElementById('verify-utr-btn');

        if (!utrVal || utrVal.length < 5) {
            errorText.innerText = "Please enter a valid UTR number.";
            errorText.classList.remove('hidden');
            return;
        }

        verifyBtn.disabled = true;
        verifyBtn.innerHTML = '<span class="flex items-center gap-2"><i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Verifying...</span>';
        lucide.createIcons();

        try {
            const response = await fetch("{{ route('account.wallet.topup.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ payment_request_id: reqId, utr_number: utrVal })
            });

            const data = await response.json();

            if (data.success) {
                errorText.classList.add('hidden');
                statusSpan.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></span><span class="text-emerald-500 font-semibold">Amount Verified</span>';
                
                setTimeout(() => {
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = '<span>Verify UTR</span><i data-lucide="check-circle" class="w-4 h-4"></i>';
                    goToStep(4);
                }, 1000);

            } else {
                errorText.innerText = data.message || "UTR verification failed. Please check and try again.";
                errorText.classList.remove('hidden');
                statusSpan.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse border-indicator"></span><span class="text-rose-500 font-semibold">Verification Failed</span>';
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<span>Verify UTR</span><i data-lucide="check-circle" class="w-4 h-4"></i>';
                lucide.createIcons();
            }
        } catch (err) {
            console.error('Error verifying UTR:', err);
            errorText.innerText = "Network error. Please try again.";
            errorText.classList.remove('hidden');
            verifyBtn.disabled = false;
            verifyBtn.innerHTML = '<span>Verify UTR</span><i data-lucide="check-circle" class="w-4 h-4"></i>';
            lucide.createIcons();
        }
    }
</script>
@endsection

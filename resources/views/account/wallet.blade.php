@extends('layouts.dashboard')

@section('title', 'Neural Wallet | AlgoTrade AI')

@section('content')
<div class="space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                NEURAL <span class="text-amber-500 text-glow">WALLET</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest leading-none">Cryptonid Balance Management</p>
        </div>
    </div>

    <!-- WALLET MANAGEMENT SECTION -->
    <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05] relative overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4">
                    <i data-lucide="wallet" class="w-6 h-6 text-amber-500"></i>
                    <h3 class="text-xl font-black orbitron uppercase italic tracking-wider text-white">Neural Assets</h3>
                </div>
                <button onclick="openFundsModal()" class="px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all">Add Neural Credit</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Balance Card -->
                <div class="lg:col-span-1">
                    <div class="p-8 rounded-[2.5rem] bg-gradient-to-br from-amber-500/10 to-orange-500/5 border border-amber-500/20 relative overflow-hidden group/card h-full flex flex-col justify-center">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/20 blur-[60px] rounded-full group-hover/card:scale-150 transition-transform duration-1000"></div>
                        <p class="text-[10px] font-black orbitron text-amber-500/60 uppercase tracking-[0.3em] mb-4">Current Neural Balance</p>
                        <h4 class="text-5xl font-black orbitron text-white italic tracking-tighter drop-shadow-[0_0_15px_rgba(245,158,11,0.4)]">
                            ₹{{ number_format($user->wallet_balance, 2) }}
                        </h4>
                        <div class="mt-8 flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[8px] font-black orbitron text-emerald-500/80 uppercase tracking-widest text-glow">Secured by Cryptonid Protocol</span>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="lg:col-span-2">
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] px-2">Recent Signal Logs</h4>
                        <div class="max-h-[300px] overflow-y-auto pr-2 no-scrollbar space-y-3">
                            @forelse($transactions as $tx)
                            <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] flex items-center justify-between hover:bg-white/[0.04] transition-all group/tx">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl {{ $tx->type === 'credit' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }} flex items-center justify-center shrink-0">
                                        <i data-lucide="{{ $tx->type === 'credit' ? 'arrow-down-left' : 'arrow-up-right' }}" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black orbitron text-white uppercase tracking-tight">{{ $tx->description }}</p>
                                        <p class="text-[8px] font-bold orbitron text-gray-500 uppercase mt-0.5">{{ $tx->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-black orbitron {{ $tx->type === 'credit' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                                    </p>
                                    @php
                                        $statusColor = match($tx->status) {
                                            'pending' => 'text-amber-500/80',
                                            'approved', 'success' => 'text-emerald-500/80',
                                            'rejected' => 'text-rose-500/80',
                                            default => 'text-gray-600'
                                        };
                                    @endphp
                                    <p class="text-[7px] font-black orbitron {{ $statusColor }} uppercase mt-0.5 tracking-[0.2em] italic">{{ $tx->status }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="py-12 text-center border border-dashed border-white/10 rounded-3xl">
                                <p class="text-[10px] font-bold orbitron text-gray-600 uppercase tracking-widest italic">No transaction frequency detected...</p>
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
</div>

<!-- MODAL: 3-STEP ADD FUNDS WIZARD -->
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

        <!-- Step Indicators -->
        <div class="flex items-center justify-center gap-0 mb-8 pt-1">
            <div id="step-ind-1" class="step-indicator active w-8 h-8 rounded-full flex items-center justify-center text-[9px] font-black orbitron border border-transparent">1</div>
            <div id="step-conn-1" class="step-connector w-12 h-[2px] bg-white/10 rounded-full"></div>
            <div id="step-ind-2" class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-[9px] font-black orbitron bg-white/5 border border-white/10 text-gray-500">2</div>
            <div id="step-conn-2" class="step-connector w-12 h-[2px] bg-white/10 rounded-full"></div>
            <div id="step-ind-3" class="step-indicator w-8 h-8 rounded-full flex items-center justify-center text-[9px] font-black orbitron bg-white/5 border border-white/10 text-gray-500">3</div>
        </div>

        <form id="funds-form" action="{{ route('account.wallet.add') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ==================== STEP 1: QR + UPI + AMOUNT ==================== -->
            <div id="fund-step-1" class="space-y-6">
                <div class="text-center space-y-2">
                    <h3 class="orbitron text-lg font-black text-white italic uppercase tracking-tight">Scan & <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-500">Transfer</span></h3>
                    <p class="text-[8px] font-bold orbitron text-gray-600 uppercase tracking-widest">Scan the QR code or use UPI to transfer</p>
                </div>

                <!-- QR Code + UPI Section -->
                @if(!empty($walletSettings['qr_code']) || !empty($walletSettings['upi_id']))
                <div class="flex flex-col items-center gap-5">
                    @if(!empty($walletSettings['qr_code']))
                    <div class="relative">
                        <!-- QR Container -->
                        <div class="relative w-44 h-44 p-3 bg-white/[0.03] rounded-[1.75rem] border border-amber-500/20 overflow-hidden group/qr">
                            <!-- Scan line -->
                            <div class="absolute left-0 w-full h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent z-10" style="animation: scan-line 2.5s ease-in-out infinite;"></div>
                            <!-- Corner decorations -->
                            <div class="absolute top-0 left-0 w-5 h-5 border-t-2 border-l-2 border-amber-500/40 rounded-tl-lg"></div>
                            <div class="absolute top-0 right-0 w-5 h-5 border-t-2 border-r-2 border-amber-500/40 rounded-tr-lg"></div>
                            <div class="absolute bottom-0 left-0 w-5 h-5 border-b-2 border-l-2 border-amber-500/40 rounded-bl-lg"></div>
                            <div class="absolute bottom-0 right-0 w-5 h-5 border-b-2 border-r-2 border-amber-500/40 rounded-br-lg"></div>
                            <!-- QR Image -->
                            <div class="bg-white rounded-2xl p-2 h-full overflow-hidden">
                                <img src="{{ asset('storage/' . $walletSettings['qr_code']) }}" alt="Payment QR" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- UPI Info Card -->
                    @if(!empty($walletSettings['upi_id']))
                    <div class="w-full p-4 rounded-xl bg-white/[0.02] border border-white/[0.06] space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="space-y-0.5">
                                <p class="text-[7px] font-black orbitron text-gray-600 uppercase tracking-[0.2em]">UPI Address</p>
                                <p class="text-xs font-black orbitron text-amber-400 italic">{{ $walletSettings['upi_id'] }}</p>
                            </div>
                            <button type="button" onclick="copyUPIWallet()" class="w-9 h-9 rounded-lg bg-amber-500/10 border border-amber-500/15 text-amber-500 flex items-center justify-center hover:bg-amber-500 hover:text-black transition-all">
                                <i data-lucide="copy" class="w-3.5 h-3.5" id="copy-icon-wallet"></i>
                            </button>
                        </div>
                        @if(!empty($walletSettings['upi_name']))
                        <div class="flex items-center gap-2 pt-1 border-t border-white/[0.04]">
                            <i data-lucide="user-check" class="w-3 h-3 text-emerald-500/50"></i>
                            <span class="text-[8px] font-bold orbitron text-gray-500 uppercase tracking-wider">Authorized: <span class="text-white">{{ $walletSettings['upi_name'] }}</span></span>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                <!-- Amount Input -->
                <div class="space-y-2.5">
                    <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-[0.2em] pl-1">Credit Amount (₹)</label>
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center group-focus-within:bg-amber-500/20 transition-colors">
                            <i data-lucide="indian-rupee" class="w-3.5 h-3.5 text-amber-500"></i>
                        </div>
                        <input type="number" name="amount" id="fund-amount" min="100" step="1" required 
                            class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl pl-16 pr-6 py-4 text-white text-sm font-black orbitron tracking-tight focus:outline-none focus:border-amber-500/40 focus:bg-white/[0.04] transition-all placeholder:text-gray-700" 
                            placeholder="Enter amount">
                    </div>
                </div>

                <!-- Next Button -->
                <button type="button" onclick="goToStep(2)" class="w-full py-4.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-xl font-black orbitron uppercase tracking-[0.2em] text-[10px] transition-all hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(245,158,11,0.25)] active:scale-[0.98] italic flex items-center justify-center gap-2.5 group">
                    <span>I Have Transferred</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <!-- ==================== STEP 2: QR SCAN CONFIRMATION ==================== -->
            <div id="fund-step-2" class="hidden space-y-6">
                <div class="text-center space-y-6 py-4">
                    <!-- Success Animation -->
                    <div class="relative w-24 h-24 mx-auto">
                        <!-- Pulse rings -->
                        <div class="absolute inset-0 rounded-full border-2 border-emerald-500/30" style="animation: pulse-ring 2s ease-out infinite;"></div>
                        <div class="absolute inset-0 rounded-full border-2 border-emerald-500/20" style="animation: pulse-ring 2s ease-out infinite 0.5s;"></div>
                        <!-- Main circle -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 border-2 border-emerald-500/40 flex items-center justify-center" style="animation: circle-fill 0.6s ease-out forwards;">
                            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none">
                                <path d="M5 13l4 4L19 7" stroke="#10b981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="stroke-dasharray: 50; animation: checkmark-draw 0.6s ease-out 0.4s forwards; stroke-dashoffset: 50;"/>
                            </svg>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="orbitron text-lg font-black text-white italic uppercase tracking-tight">Payment <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Confirmed</span></h3>
                        <p class="text-[8px] font-bold orbitron text-gray-500 uppercase tracking-widest leading-relaxed max-w-xs mx-auto">Your transfer has been initiated. Please provide verification details in the next step.</p>
                    </div>

                    <!-- Transfer Summary -->
                    <div class="rounded-xl bg-white/[0.02] border border-white/[0.06] p-5 text-left space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest">Amount Transferred</span>
                            <span id="confirm-amount" class="text-sm font-black orbitron text-emerald-400">₹ 0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest">Status</span>
                            <span class="text-[9px] font-black orbitron text-amber-500 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Awaiting Verification
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex gap-3">
                    <button type="button" onclick="goToStep(1)" class="flex-1 py-4 rounded-xl bg-white/[0.03] border border-white/[0.06] text-gray-400 font-black orbitron uppercase text-[9px] tracking-widest hover:bg-white/[0.06] transition-all flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back
                    </button>
                    <button type="button" onclick="goToStep(3)" class="flex-[2] py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-black orbitron uppercase tracking-[0.2em] text-[10px] transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(16,185,129,0.25)] italic flex items-center justify-center gap-2 group">
                        <span>Continue Verification</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- ==================== STEP 3: UTR + SCREENSHOT ==================== -->
            <div id="fund-step-3" class="hidden space-y-6">
                <div class="text-center space-y-2">
                    <h3 class="orbitron text-lg font-black text-white italic uppercase tracking-tight">Submit <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">Proof</span></h3>
                    <p class="text-[8px] font-bold orbitron text-gray-600 uppercase tracking-widest">Provide your UTR & screenshot for admin verification</p>
                </div>

                <!-- Payment Method -->
                <div class="space-y-2.5">
                    <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-[0.2em] pl-1">Payment Method</label>
                    <select name="payment_method" required class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl px-5 py-4 text-white text-xs font-bold orbitron outline-none focus:border-purple-500/40 focus:bg-white/[0.04] appearance-none transition-all">
                        <option value="UPI" class="bg-[#0a0514]">UPI / G-Pay / PhonePe</option>
                        <option value="Bank Transfer" class="bg-[#0a0514]">Bank Transfer (IMPS/NEFT)</option>
                        <option value="QR Scan" class="bg-[#0a0514]">QR Code Scan</option>
                    </select>
                </div>

                <!-- UTR Input -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between pl-1 pr-1">
                        <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">UTR / Reference ID</label>
                        <span class="text-[7px] font-bold text-rose-500/70 uppercase tracking-widest">Required</span>
                    </div>
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center group-focus-within:bg-purple-500/20 transition-colors">
                            <i data-lucide="hash" class="w-3.5 h-3.5 text-purple-400"></i>
                        </div>
                        <input type="text" name="payment_reference" required 
                            class="w-full bg-white/[0.02] border border-white/[0.08] rounded-xl pl-16 pr-6 py-4 text-white text-xs font-bold orbitron tracking-wider outline-none focus:border-purple-500/40 focus:bg-white/[0.04] transition-all placeholder:text-gray-700" 
                            placeholder="Enter 12-digit UTR number">
                    </div>
                </div>

                <!-- Screenshot Upload -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between pl-1 pr-1">
                        <label class="text-[9px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Payment Screenshot</label>
                        <span class="text-[7px] font-bold text-rose-500/70 uppercase tracking-widest">Mandatory</span>
                    </div>
                    <label class="w-full bg-white/[0.02] border border-dashed border-white/[0.1] rounded-xl px-5 py-5 flex items-center gap-4 cursor-pointer group hover:bg-white/[0.04] hover:border-purple-500/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 group-hover:border-purple-500/25 transition-all shrink-0">
                            <i data-lucide="image-plus" class="w-5 h-5 text-purple-400"></i>
                        </div>
                        <div class="flex flex-col flex-1 min-w-0">
                            <span id="fund-file-name" class="text-[10px] font-bold orbitron text-gray-500 group-hover:text-gray-300 uppercase tracking-wider truncate transition-colors">Click to upload screenshot...</span>
                            <span class="text-[7px] font-medium text-gray-700 uppercase tracking-wider">PNG, JPG, GIF — Max 2MB</span>
                        </div>
                        <input type="file" name="screenshot" accept="image/*" required class="hidden" onchange="handleFileSelect(this)">
                    </label>
                </div>

                <!-- Info Banner -->
                <div class="p-3.5 rounded-xl bg-amber-500/[0.04] border border-amber-500/10 flex items-start gap-3">
                    <i data-lucide="info" class="w-3.5 h-3.5 text-amber-500/60 shrink-0 mt-0.5"></i>
                    <p class="text-[7px] font-bold orbitron text-amber-500/50 uppercase leading-relaxed tracking-widest">Admin verification typically takes 5-15 minutes. Your balance will be credited after approval.</p>
                </div>

                <!-- Navigation -->
                <div class="flex gap-3">
                    <button type="button" onclick="goToStep(2)" class="flex-1 py-4 rounded-xl bg-white/[0.03] border border-white/[0.06] text-gray-400 font-black orbitron uppercase text-[9px] tracking-widest hover:bg-white/[0.06] transition-all flex items-center justify-center gap-2">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back
                    </button>
                    <button type="submit" id="submit-funds-btn" class="flex-[2] py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-black orbitron uppercase tracking-[0.2em] text-[10px] transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(147,51,234,0.25)] italic flex items-center justify-center gap-2.5 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i data-lucide="send" class="w-4 h-4 relative z-10"></i>
                        <span class="relative z-10">Submit for Verification</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Security Footer -->
        <div class="flex items-center justify-center gap-2.5 mt-6">
            <div class="flex items-center gap-1">
                <i data-lucide="shield-check" class="w-3 h-3 text-emerald-500/40"></i>
                <span class="text-[7px] font-bold orbitron text-gray-700 uppercase tracking-[0.15em]">Encrypted</span>
            </div>
            <span class="text-gray-800">•</span>
            <div class="flex items-center gap-1">
                <i data-lucide="lock" class="w-2.5 h-2.5 text-emerald-500/40"></i>
                <span class="text-[7px] font-bold orbitron text-gray-700 uppercase tracking-[0.15em]">Admin Verified</span>
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

    function openFundsModal() {
        // Hide navbar
        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = 'none';

        const modal = document.getElementById('add-funds-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Scroll lock
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        document.body.style.position = 'fixed';
        document.body.style.width = '100%';
        document.body.style.top = `-${window.scrollY}px`;
        document.body.dataset.scrollY = window.scrollY;

        // Reset to step 1
        goToStep(1);
        lucide.createIcons();
    }

    function closeFundsModal() {
        const modal = document.getElementById('add-funds-modal');
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

        // Show navbar
        const nav = document.getElementById('main-nav');
        if (nav) nav.style.display = '';
    }

    function goToStep(step) {
        // Validate before leaving step 1
        if (currentFundStep === 1 && step === 2) {
            const amountInput = document.getElementById('fund-amount');
            if (!amountInput.value || Number(amountInput.value) < 100) {
                amountInput.focus();
                amountInput.classList.add('border-rose-500/50');
                setTimeout(() => amountInput.classList.remove('border-rose-500/50'), 2000);
                return;
            }
            // Update confirmation amount
            document.getElementById('confirm-amount').innerText = '₹ ' + Number(amountInput.value).toLocaleString('en-IN');
        }

        currentFundStep = step;

        // Hide all steps
        document.getElementById('fund-step-1').classList.add('hidden');
        document.getElementById('fund-step-2').classList.add('hidden');
        document.getElementById('fund-step-3').classList.add('hidden');

        // Show current step
        document.getElementById('fund-step-' + step).classList.remove('hidden');

        // Update indicators
        for (let i = 1; i <= 3; i++) {
            const ind = document.getElementById('step-ind-' + i);
            ind.classList.remove('active', 'completed');
            ind.className = 'step-indicator w-8 h-8 rounded-full flex items-center justify-center text-[9px] font-black orbitron';

            if (i < step) {
                ind.classList.add('completed');
                ind.classList.add('border');
                ind.innerHTML = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><path d="M5 13l4 4L19 7"/></svg>';
            } else if (i === step) {
                ind.classList.add('active');
                ind.classList.add('border', 'border-transparent');
                ind.innerHTML = i;
            } else {
                ind.classList.add('bg-white/5', 'border', 'border-white/10', 'text-gray-500');
                ind.innerHTML = i;
            }
        }

        // Update connectors
        const conn1 = document.getElementById('step-conn-1');
        const conn2 = document.getElementById('step-conn-2');
        conn1.classList.toggle('active', step > 1);
        conn2.classList.toggle('active', step > 2);

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
</script>
@endsection

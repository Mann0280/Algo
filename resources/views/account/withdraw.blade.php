@extends('layouts.dashboard')

@section('title', 'Withdraw Credits | Emperor Stock Predictor')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-bold text-white tracking-tighter uppercase">WITHDRAW <span class="text-purple-500">FUNDS</span></h2>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest font-bold">Secure Payout Protocol</p>
        </div>
        <a href="{{ route('account.wallet') }}" class="flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-white transition-colors uppercase tracking-widest">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Wallet
        </a>
    </div>

    <!-- Available Balance Card -->
    <div class="glass-panel rounded-[2rem] p-8 border-white/[0.05] relative overflow-hidden group bg-gradient-to-br from-purple-600/[0.02] to-transparent">
        <div class="flex items-center justify-between relative z-10">
            <div>
                <label class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.3em]">Available for Withdrawal</label>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-xl font-bold text-purple-500">₹</span>
                    <h3 class="text-4xl font-bold text-white tracking-tighter tabular-nums">{{ number_format($availableBalance, 2) }}</h3>
                </div>
            </div>
            <div class="hidden sm:block">
                <div class="px-6 py-3 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase">VERIFIED ASSETS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdrawal Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2">
            <form action="{{ route('account.withdraw.store') }}" method="POST" class="glass-panel rounded-[2.5rem] p-8 sm:p-10 border-white/[0.05] space-y-8">
                @csrf
                
                @if ($errors->any())
                    <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl">
                        <ul class="list-disc list-inside text-xs text-rose-500 font-bold uppercase tracking-widest space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Amount -->
                    <div class="space-y-3">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-2">Withdrawal Amount (₹)</label>
                        <div class="relative group/field">
                            <i data-lucide="indian-rupee" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-focus-within:text-purple-500 transition-colors"></i>
                            <input type="number" name="amount" min="{{ $minWithdraw }}" max="{{ $availableBalance }}" step="0.01" required 
                                   class="w-full bg-white/[0.03] border border-white/10 rounded-2xl pl-14 pr-6 py-4 text-white text-lg font-bold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.06] transition-all shadow-inner" 
                                   placeholder="Enter Amount">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Bank Name -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-2">Bank Name</label>
                            <input type="text" name="bank_name" required 
                                   class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-purple-500/50 transition-all" 
                                   placeholder="e.g. HDFC Bank">
                        </div>
                        <!-- IFSC Code -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-2">IFSC Code</label>
                            <input type="text" name="ifsc_code" required 
                                   class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-purple-500/50 transition-all uppercase" 
                                   placeholder="HDFC0001234">
                        </div>
                    </div>

                    <!-- Account Number -->
                    <div class="space-y-3">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-2">Account Number</label>
                        <input type="text" name="account_number" required 
                               class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-bold tracking-widest focus:outline-none focus:border-purple-500/50 transition-all" 
                               placeholder="Enter your account number">
                    </div>

                    <!-- UPI ID -->
                    <div class="space-y-3">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-2">UPI ID </label>
                        <input type="text" name="upi_id" required
                               class="w-full bg-white/[0.03] border border-white/10 rounded-2xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-purple-500/50 transition-all" 
                               placeholder="username@okbank">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[12px] font-bold uppercase tracking-[0.3em] hover:scale-[1.02] hover:shadow-[0_0_40px_rgba(147,51,234,0.4)] transition-all">
                        Initiate Withdrawal
                    </button>
                    <p class="text-center text-[10px] text-gray-600 font-bold uppercase tracking-widest mt-6">
                        By initiating, you agree to our withdrawal protocol and security checks.
                    </p>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="glass-panel rounded-[2rem] p-8 border-white/[0.05] space-y-6">
                <h4 class="text-xs font-bold text-white uppercase tracking-widest">Withdrawal Protocol</h4>
                <div class="space-y-5">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center">
                            <i data-lucide="clock-4" class="w-4 h-4 text-purple-500"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-300 uppercase tracking-wide">Processing Time</p>
                            <p class="text-[10px] text-gray-500 mt-1">Typical approval within 24-48 business hours after security verification.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center">
                            <i data-lucide="shield-alert" class="w-4 h-4 text-indigo-500"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-300 uppercase tracking-wide">Security Check</p>
                            <p class="text-[10px] text-gray-500 mt-1">Manual audit performed for all high-value withdrawal requests to prevent fraud.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                            <i data-lucide="help-circle" class="w-4 h-4 text-emerald-500"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-300 uppercase tracking-wide">Support</p>
                            <p class="text-[10px] text-gray-500 mt-1">Need help? Contact our institutional support team via the contact portal.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-8 rounded-[2rem] bg-gradient-to-br from-indigo-600/10 to-transparent border border-white/[0.05]">
                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest leading-relaxed">
                    "Accuracy is the currency of trading, but security is the foundation of wealth."
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

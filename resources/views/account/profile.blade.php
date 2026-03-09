@extends('layouts.dashboard')

@section('title', 'Institutional Settings | Emperor Stock Predictor')

@section('content')
<style>
    .tab-content {
        display: block;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    @keyframes ping-slow {
        0% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.1); opacity: 0.2; }
        100% { transform: scale(1); opacity: 0.1; }
    }
    .animate-ping-slow {
        animation: ping-slow 3s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
    .animate-spin-slow {
        animation: spin 10s linear infinite;
    }
</style>
<div class="space-y-12">
    <!-- SECTION: IDENTITY -->
    <div id="tab-profile" class="tab-content active space-y-10">
        <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-12 border-white/[0.05] relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div class="flex items-center gap-4">
                        <i data-lucide="fingerprint" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Identity Protocol</h3>
                    </div>
                    <button id="save-changes-btn" class="px-8 py-3.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all">Save Changes</button>
                </div>

                <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-center lg:items-start">
                    <!-- Avatar Section -->
                    <div class="relative shrink-0">
                        <div class="w-32 h-32 sm:w-44 sm:h-44 rounded-[2.5rem] sm:rounded-[3.5rem] border border-white/[0.08] flex items-center justify-center relative overflow-hidden group/avatar shadow-[0_20px_50px_rgba(0,0,0,0.5)]" style="background: var(--card-inner-bg)">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 opacity-40 group-hover/avatar:opacity-60 transition-opacity duration-500"></div>
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(147,51,234,0.15),transparent_70%)]"></div>
                            
                            <div id="avatar-container" class="absolute inset-0 z-10 flex items-center justify-center">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">
                                @else
                                    <span class="text-5xl sm:text-7xl font-black orbitron italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                @endif
                            </div>
                            
                            <!-- Hover Upload Overlay -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 group-hover/avatar:opacity-100 transition-all duration-500 cursor-pointer z-20" onclick="document.getElementById('profile_photo_input').click()">
                                <i data-lucide="camera" class="w-8 h-8 text-white mb-2 transform translate-y-2 group-hover/avatar:translate-y-0 transition-transform"></i>
                                <span class="text-[8px] font-black orbitron text-white uppercase tracking-widest opacity-0 group-hover/avatar:opacity-100 transition-opacity">Update Node</span>
                            </div>
                            <input type="file" id="profile_photo_input" class="hidden" accept="image/*">
                        </div>
                        <!-- Enhanced Badge -->
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 px-5 py-2.5 bg-[#05020a] border border-emerald-500/30 rounded-full shadow-[0_0_20px_rgba(16,185,129,0.1)] z-30">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span>
                                <p class="text-[8px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em] whitespace-nowrap">Verified Node</p>
                            </div>
                        </div>
                    </div>

                    <!-- Data Grid -->
                    <div class="flex-1 w-full mt-8 lg:mt-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 sm:gap-y-10">
                            <!-- Field: Username -->
                            <div class="space-y-3.5">
                                <div class="flex justify-between items-center px-2">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Username Handle</label>
                                    <span class="text-[8px] font-bold orbitron text-purple-500/50 uppercase tracking-widest">Public</span>
                                </div>
                                <div class="relative group/field">
                                    <i data-lucide="user" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="text" name="username" value="{{ Auth::user()->username }}" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-[var(--text-white)] text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all shadow-inner">
                                </div>
                            </div>

                            <!-- Field: Email -->
                            <div class="space-y-3.5">
                                <div class="flex justify-between items-center px-2">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Neural Email</label>
                                    <span class="text-[8px] font-bold orbitron text-emerald-500/50 uppercase tracking-widest">Active</span>
                                </div>
                                <div class="relative group/field">
                                    <i data-lucide="mail" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-[var(--text-white)] text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all shadow-inner">
                                </div>
                            </div>

                            <!-- Field: PIN -->
                            <div class="space-y-3.5">
                                <div class="flex justify-between items-center px-2">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Access PIN</label>
                                    <span class="text-[8px] font-bold orbitron text-gray-600 uppercase tracking-widest">Hidden</span>
                                </div>
                                <div class="relative group/field">
                                    <i data-lucide="lock" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="password" value="********" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-[var(--text-white)] text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all shadow-inner">
                                </div>
                            </div>

                            <!-- Reset Button Callout -->
                            <div class="flex items-end">
                                <div class="w-full p-1 bg-white/[0.02] border border-white/[0.05] rounded-2xl">
                                    <button class="w-full py-3.5 rounded-xl bg-white/[0.03] border border-white/[0.1] text-[9px] font-black orbitron uppercase tracking-[0.25em] hover:bg-purple-600 hover:text-white hover:border-purple-500 transition-all duration-300 group/btn shadow-lg">
                                        <div class="flex items-center justify-center gap-3">
                                            <i data-lucide="refresh-cw" class="w-3.5 h-3.5 group-hover/btn:rotate-180 transition-transform duration-500"></i>
                                            Reset Access Credentials
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- SECTION 2 — SUBSCRIPTION PROTOCOL -->
    <div id="tab-subscription" class="tab-content active space-y-10">
        <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-12 border-white/[0.05] relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            <div class="relative z-10">
                <div class="mb-10 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">{{ \App\Models\SiteSetting::getValue('subscription_header', 'Subscription Protocol') }}</h3>
                        <p class="text-[11px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] mt-1">{{ \App\Models\SiteSetting::getValue('subscription_subheader', 'Neural Access Monitoring') }} • Link ID: {{ substr(md5($user->id), 0, 8) }}</p>
                    </div>
                </div>

                @if($latestPayment && $latestPayment->status !== 'approved' && !($user->role === 'premium' && $latestPayment->status === 'approved'))
                    <div class="mb-8 p-6 rounded-3xl border {{ $latestPayment->status === 'pending' ? 'bg-amber-500/5 border-amber-500/20' : 'bg-rose-500/5 border-rose-500/20' }} animate-in fade-in slide-in-from-top-4 duration-700">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl {{ $latestPayment->status === 'pending' ? 'bg-amber-500/10 text-amber-500' : 'bg-rose-500/10 text-rose-500' }} flex items-center justify-center shrink-0">
                                <i data-lucide="{{ $latestPayment->status === 'pending' ? 'clock' : 'shield-alert' }}" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-[10px] font-black orbitron {{ $latestPayment->status === 'pending' ? 'text-amber-500' : 'text-rose-500' }} uppercase tracking-[0.2em]">
                                    Payment {{ ucfirst($latestPayment->status) }}
                                </h4>
                                <p class="text-[9px] font-bold orbitron text-gray-400 uppercase tracking-widest mt-1">
                                    @if($latestPayment->status === 'pending')
                                        Your requisition for the {{ $latestPayment->package->name ?? 'Premium' }} protocol is under neural verification.
                                    @else
                                        Protocol rejected: {{ $latestPayment->rejection_note ?? 'Institutional verification failed.' }}
                                    @endif
                                </p>
                            </div>
                            @if($latestPayment->status === 'rejected')
                                <a href="{{ route('pricing') }}" class="px-6 py-2.5 bg-rose-500 text-black rounded-xl text-[8px] font-black orbitron uppercase tracking-widest hover:bg-rose-600 transition-all">Re-initiate Upgrade</a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="flex flex-col lg:flex-row justify-between items-center gap-12">
                    <!-- PLAN INFO -->
                    <div class="w-full lg:w-1/2 space-y-6">
                        <div class="p-6 sm:p-8 rounded-[1.5rem] sm:rounded-[2rem] bg-white/[0.02] border border-white/[0.05] space-y-5">
                            @php
                                $isActive = $preciseExpiry && \Carbon\Carbon::parse($preciseExpiry)->isFuture();
                                $hasPlan = (bool)$user->premium_expiry;
                            @endphp
                            <div class="flex items-center justify-between group">
                                <span class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Plan Name</span>
                                <span class="text-sm font-black orbitron text-white uppercase italic group-hover:text-purple-400 transition-colors">
                                    @if($user->role === 'admin')
                                        Institutional Admin
                                    @elseif($isActive && $currentSubscription)
                                        {{ $currentSubscription->plan_name }}
                                    @else
                                        {{ $user->role === 'premium' ? 'Premium Trader' : 'Basic Node' }}
                                    @endif
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Link Status</span>
                                <span class="px-5 py-1.5 rounded-full {{ $isActive ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-500' : 'bg-rose-500/10 border border-rose-500/20 text-rose-500' }} text-[9px] font-black orbitron uppercase tracking-[0.2em] shadow-[0_0_20px_rgba(244,63,94,0.1)]">
                                    {{ $isActive ? 'Protocol Active' : ($hasPlan ? 'Protocol Expired' : 'Link Offline') }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-white/[0.05]">
                                <span class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Init Date</span>
                                <span class="text-xs font-bold orbitron text-gray-400">{{ $user->created_at ? $user->created_at->format('d M Y') : '01 Mar 2026' }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Termination</span>
                                <span class="text-xs font-bold orbitron {{ $isActive ? 'text-indigo-400' : 'text-rose-500/50' }}">{{ $user->premium_expiry ? \Carbon\Carbon::parse($user->premium_expiry)->format('d M Y') : 'UNDEFINED' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- COUNTDOWN -->
                    <div class="w-full lg:w-1/2 flex flex-col items-center text-center space-y-6">
                        <div class="space-y-2">
                            <h4 class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.4em]">Temporal Remaining Capacity</h4>
                            <div class="h-0.5 w-12 bg-purple-500/30 mx-auto rounded-full"></div>
                        </div>
                        
                        <div id="subscription-timer" class="text-4xl sm:text-5xl xl:text-7xl font-black orbitron italic tracking-tighter {{ $isActive ? 'text-purple-500 drop-shadow-[0_0_25px_rgba(147,51,234,0.6)]' : 'text-white/10' }}">
                            00h 00m 00s
                        </div>

                        <div class="flex flex-col items-center gap-4">
                            @if(!$isActive)
                                <a href="{{ route('pricing') }}" class="group relative px-12 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.3em] overflow-hidden transition-all hover:scale-105 shadow-2xl">
                                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                    <span class="relative z-10">Upgrade Protocol</span>
                                </a>
                                <p class="text-[8px] font-bold orbitron text-gray-600 uppercase tracking-widest italic animate-pulse">Neural limits imposed. Upgrade for full bandwidth.</p>
                            @else
                                <div class="px-8 py-3 rounded-xl bg-emerald-500/5 border border-emerald-500/20">
                                    <p class="text-[9px] font-black orbitron text-emerald-500 uppercase tracking-widest italic">Full Neural Integration Active</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($user->premium_expiry)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const expiry = new Date("{{ $preciseExpiry }}").getTime();
                const timerDisplay = document.getElementById('subscription-timer');
                
                const updateTimer = () => {
                    const now = new Date().getTime();
                    const distance = expiry - now;
                    
                    if (distance <= 0) {
                        timerDisplay.innerText = "00h 00m 00s";
                        timerDisplay.classList.remove('text-purple-500');
                        timerDisplay.classList.add('text-rose-500/20');
                        return;
                    }
                    
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    timerDisplay.innerText = `${hours}h ${minutes}m ${seconds}s`;
                };
                
                updateTimer();
                setInterval(updateTimer, 1000);
            });
        </script>
        @endif
    </div>

    {{-- 
    <!-- SECTION: WALLET MANAGEMENT -->
    <div id="tab-wallet" class="tab-content active space-y-10">
        <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05] relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                    <div class="flex items-center gap-4">
                        <i data-lucide="wallet" class="w-6 h-6 text-amber-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Neural Wallet Management</h3>
                    </div>
                    <button onclick="document.getElementById('add-funds-modal').classList.remove('hidden')" class="px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all">Add Neural Credit</button>
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
                                <span class="text-[8px] font-black orbitron text-emerald-500/80 uppercase tracking-widest">Secured by Cryptonid Protocol</span>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="lg:col-span-2 space-y-10">
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] px-2">Recent Signal Logs</h4>
                            <div class="max-h-[250px] overflow-y-auto pr-2 no-scrollbar space-y-3">
                                @forelse($walletTransactions as $tx)
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
                                        <p class="text-[7px] font-bold orbitron text-gray-600 uppercase mt-0.5 tracking-[0.2em]">{{ strtoupper($tx->status) }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="py-8 text-center border border-dashed border-white/10 rounded-3xl">
                                    <p class="text-[9px] font-bold orbitron text-gray-600 uppercase tracking-widest italic">No transaction frequency detected...</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- P2P Requests Section -->
                        <div class="space-y-4 pt-4 border-t border-white/5">
                            <h4 class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] px-2">Manual Protocol Requisitions</h4>
                            <div class="overflow-x-auto no-scrollbar">
                                <table class="w-full text-left border-separate border-spacing-y-2">
                                    <thead>
                                        <tr class="text-[8px] font-black orbitron text-gray-700 uppercase tracking-[0.2em]">
                                            <th class="px-4 pb-2">Plan</th>
                                            <th class="px-4 pb-2">Amount</th>
                                            <th class="px-4 pb-2">UTR Code</th>
                                            <th class="px-4 pb-2">Status</th>
                                            <th class="px-4 pb-2 text-right">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($paymentRequests as $req)
                                        <tr class="bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.04] transition-all">
                                            <td class="px-4 py-4 rounded-l-xl">
                                                <span class="text-[10px] font-black orbitron text-white uppercase italic tracking-tight">{{ $req->plan_name }}</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="text-[10px] font-bold orbitron text-gray-400">₹{{ number_format($req->amount, 0) }}</span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <code class="text-[9px] font-mono text-indigo-400/70">{{ $req->utr_number }}</code>
                                            </td>
                                            <td class="px-4 py-4">
                                                <span class="px-3 py-1 rounded-full border text-[7px] font-black orbitron uppercase tracking-widest
                                                    {{ $req->status === 'pending' ? 'border-amber-500/20 text-amber-500' : ($req->status === 'approved' ? 'border-emerald-500/20 text-emerald-500' : 'border-rose-500/20 text-rose-500') }}">
                                                    {{ $req->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 rounded-r-xl text-right">
                                                <span class="text-[8px] font-bold orbitron text-gray-600 uppercase">{{ $req->created_at->format('d M') }}</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-[9px] font-bold orbitron text-gray-700 uppercase tracking-widest italic">No manual protocols initialized.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    --}}

    <!-- MODAL: ADD FUNDS -->
    <div id="add-funds-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6 bg-black/80 backdrop-blur-md">
        <div class="bg-[#0a0514] border border-amber-500/20 rounded-[2.5rem] w-full max-w-md p-10 relative overflow-hidden shadow-2xl shadow-amber-500/10">
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-amber-600/10 blur-[80px] rounded-full"></div>
            
            <button onclick="document.getElementById('add-funds-modal').classList.add('hidden')" class="absolute top-8 right-8 text-gray-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="plus-circle" class="w-8 h-8 text-amber-500"></i>
                </div>
                <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Initialize Top-up</h3>
                <p class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-widest mt-2">Inject neural credits into your wallet</p>
            </div>

            <form action="{{ route('account.wallet.add') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-3">
                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] pl-2">Credit Amount (₹)</label>
                    <div class="relative group">
                        <i data-lucide="indian-rupee" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover:text-amber-500 transition-colors"></i>
                        <input type="number" name="amount" min="1" step="1" required class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-amber-500/40 focus:bg-white/[0.06] transition-all" placeholder="1000">
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                    <div class="flex items-start gap-3">
                        <i data-lucide="shield-info" class="w-4 h-4 text-amber-500 shrink-0 mt-0.5"></i>
                        <p class="text-[8px] font-bold orbitron text-amber-500/70 uppercase leading-relaxed tracking-widest">Neural credits are instantly finalized and cannot be reversed once synchronized.</p>
                    </div>
                </div>

                <button type="submit" class="w-full py-5 rounded-2xl bg-gradient-to-r from-amber-600 to-orange-600 text-white text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(245,158,11,0.3)] transition-all">Synchronize Credits</button>
            </form>
        </div>
    </div>

    <!-- SECTION 3 — ACTIVE SECURE SESSIONS -->
    <div id="tab-sessions" class="tab-content active space-y-10">
        <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-12 border-white/[0.05] relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between gap-6 mb-10">
                    <div class="flex items-center gap-4">
                        <i data-lucide="shield-check" class="w-6 h-6 text-emerald-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Active Secure Sessions</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span>
                        <span class="text-[8px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em]">Monitoring Active</span>
                    </div>
                </div>

                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-separate border-spacing-y-4">
                        <thead>
                            <tr class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-[0.25em]">
                                <th class="px-6 pb-2">Device Node</th>
                                <th class="px-6 pb-2">Location</th>
                                <th class="px-6 pb-2">IP Address</th>
                                <th class="px-6 pb-2">Last Activity</th>
                                <th class="px-6 pb-2">Status</th>
                                <th class="px-6 pb-2 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sessions-table-body">
                            @foreach($sessions as $session)
                            <tr class="group/row bg-white/[0.02] border border-white/[0.05] hover:bg-white/[0.05] transition-all relative">
                                <td class="px-6 py-5 rounded-l-2xl border-l border-t border-b border-white/[0.05]">
                                    <div class="flex items-center gap-3">
                                        <i data-lucide="{{ str_contains($session->device, 'PC') ? 'monitor' : 'smartphone' }}" class="w-4 h-4 text-purple-500"></i>
                                        <span class="text-[10px] font-bold orbitron text-white uppercase">{{ $session->device }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-t border-b border-white/[0.05]">
                                    <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">{{ $session->location }}</span>
                                </td>
                                <td class="px-6 py-5 border-t border-b border-white/[0.05]">
                                    <code class="text-[10px] font-bold text-indigo-400">{{ $session->ip_address }}</code>
                                </td>
                                <td class="px-6 py-5 border-t border-b border-white/[0.05]">
                                    <span class="text-[10px] font-medium text-gray-500 uppercase">{{ $session->last_active }}</span>
                                </td>
                                <td class="px-6 py-5 border-t border-b border-white/[0.05]">
                                    @if($session->is_current_device)
                                        <span class="px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-500 text-[8px] font-black orbitron uppercase tracking-widest">Current</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-white/5 border border-white/10 text-gray-500 text-[8px] font-black orbitron uppercase tracking-widest">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 rounded-r-2xl border-r border-t border-b border-white/[0.05] text-right">
                                    @if(!$session->is_current_device)
                                        <button onclick="terminateSession('{{ $session->id }}', this)" class="px-4 py-2 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 text-[8px] font-black orbitron uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">Logout</button>
                                    @else
                                        <span class="text-[8px] font-black orbitron text-emerald-500/50 uppercase tracking-widest italic">Immutable</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- SECTION 4 — PASSWORD SECURITY -->
    <div id="tab-security" class="tab-content active space-y-10">
        <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-12 border-white/[0.05] relative overflow-hidden group">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_0%,rgba(139,92,246,0.05),transparent_50%)]"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-10">
                    <i data-lucide="lock" class="w-6 h-6 text-purple-500"></i>
                    <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Password Security Protocol</h3>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Change Password Form -->
                    <div class="space-y-8">
                        <div class="space-y-6">
                            <div class="space-y-3">
                                <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Current Authorization Key</label>
                                <div class="relative group/field">
                                    <i data-lucide="key" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="password" id="current_password" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all" placeholder="Enter Current Password">
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">New Security Hash</label>
                                <div class="relative group/field">
                                    <i data-lucide="shield-plus" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="password" id="new_password" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all" placeholder="Enter New Password">
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Confirm Protocol Hash</label>
                                <div class="relative group/field">
                                    <i data-lucide="check-circle-2" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    <input type="password" id="new_password_confirmation" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-6 py-4.5 text-white text-sm font-bold orbitron tracking-tight focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all" placeholder="Repeat New Password">
                                </div>
                            </div>
                        </div>

                        <button onclick="updatePassword()" class="w-full py-5 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all">Update Access Key</button>
                    </div>

                    <!-- Requirements & Status -->
                    <div class="space-y-8 p-8 rounded-[2.5rem] bg-indigo-500/[0.02] border border-white/[0.03]">
                        <h4 class="text-[10px] font-black orbitron text-white uppercase tracking-[0.2em] mb-6">Encryption Complexity Requirements</h4>
                        
                        <div class="space-y-5">
                            <div class="requirement-item flex items-center justify-between group" data-req="length">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="hash" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-[10px] font-bold orbitron text-gray-500 group-[.valid]:text-emerald-500 uppercase tracking-widest">Min. 8 Characters</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="uppercase">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="type" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-[10px] font-bold orbitron text-gray-500 group-[.valid]:text-emerald-500 uppercase tracking-widest">Uppercase Sentinel</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="number">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="binary" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-[10px] font-bold orbitron text-gray-500 group-[.valid]:text-emerald-500 uppercase tracking-widest">Numeric Sequence</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="special">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="asterisk" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-[10px] font-bold orbitron text-gray-500 group-[.valid]:text-emerald-500 uppercase tracking-widest">Special Character Link</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-white/[0.05]">
                            <div class="flex items-center gap-3">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-gray-600"></i>
                                <p class="text-[8px] font-black orbitron text-gray-600 uppercase tracking-[0.2em]">Last Modified: <span class="text-indigo-500/80">3 DAYS AGO</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- GLOBAL NEURAL NOTIFICATION SYSTEM -->
    <div id="neural-toast-container" class="fixed bottom-12 right-12 z-[100] space-y-4 pointer-events-none"></div>
</div>
@endsection

@push('scripts')
<script>
    // --- NEURAL UI UTILS ---
    function notify(message, type = 'info') {
        const container = document.getElementById('neural-toast-container');
        const toast = document.createElement('div');
        const colors = {
            info: 'border-purple-500/30 text-purple-400 bg-purple-500/5',
            success: 'border-emerald-500/30 text-emerald-400 bg-emerald-500/5',
            error: 'border-rose-500/30 text-rose-400 bg-rose-500/5'
        };
        
        toast.className = `px-8 py-4 rounded-2xl border backdrop-blur-xl ${colors[type]} flex items-center gap-4 shadow-2xl pointer-events-auto transform translate-x-12 opacity-0 transition-all duration-500`;
        toast.innerHTML = `
            <div class="w-2 h-2 rounded-full bg-current ${type === 'info' ? 'animate-pulse' : ''}"></div>
            <span class="text-[10px] font-black orbitron uppercase tracking-widest">${message}</span>
        `;
        
        container.appendChild(toast);
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-12', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('translate-x-12', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }

    // --- SESSION MANAGEMENT ---
    function terminateSession(sessionId, btn) {
        if (!confirm('Permanently terminate this secure link?')) return;
        
        const row = btn.closest('tr');
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-3 h-3 animate-spin mx-auto"></i>';
        lucide.createIcons();
        
        fetch(`/account/profile/sessions/${sessionId}/terminate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                notify(result.message, 'success');
                row.style.transform = 'translateX(20px)';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            } else {
                notify('Session termination failed.', 'error');
                btn.disabled = false;
                btn.innerText = 'Logout';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            notify('Neural link error.', 'error');
            btn.disabled = false;
            btn.innerText = 'Logout';
        });
    }
    window.terminateSession = terminateSession;

    // --- PASSWORD SECURITY ---
    function updatePassword() {
        const payload = {
            current_password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value
        };

        fetch("{{ route('account.update-password') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                notify(result.message, 'success');
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('new_password_confirmation').value = '';
                document.querySelectorAll('.requirement-item').forEach(i => i.classList.remove('valid'));
            } else {
                const errorMsg = result.message || 'Verification failed.';
                notify(errorMsg, 'error');
            }
        })
        .catch(error => {
            notify('System protocol error.', 'error');
        });
    }
    window.updatePassword = updatePassword;

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        // 1. Password Real-time Validation
        const newPassInput = document.getElementById('new_password');
        if(newPassInput) {
            newPassInput.addEventListener('input', (e) => {
                const val = e.target.value;
                const reqs = {
                    length: val.length >= 8,
                    uppercase: /[A-Z]/.test(val),
                    number: /[0-9]/.test(val),
                    special: /[@$!%*#?&]/.test(val)
                };

                Object.keys(reqs).forEach(key => {
                    const item = document.querySelector(`.requirement-item[data-req="${key}"]`);
                    if (reqs[key]) item.classList.add('valid');
                    else item.classList.remove('valid');
                });
            });
        }

        // 2. Global Save Logic (Identity section)
        const saveBtn = document.getElementById('save-changes-btn');
        if(saveBtn) {
            saveBtn.addEventListener('click', () => {
                saveBtn.disabled = true;
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<span class="flex items-center gap-2 justify-center"><i data-lucide="loader-2" class="w-3 h-3 animate-spin"></i> SYNCING...</span>';
                lucide.createIcons();
                
                const formData = new FormData();
                const inputs = document.querySelectorAll('#tab-profile input[name]');
                inputs.forEach(input => {
                    formData.append(input.name, input.value);
                });

                const photoInput = document.getElementById('profile_photo_input');
                if (photoInput && photoInput.files.length > 0) {
                    formData.append('profile_photo', photoInput.files[0]);
                }

                fetch("{{ route('account.update') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        notify(result.message, 'success');
                        if (result.user) {
                            const avatarContainer = document.getElementById('avatar-container');
                            if (result.user.profile_photo_url) {
                                avatarContainer.innerHTML = `<img src="${result.user.profile_photo_url}" alt="Profile" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">`;
                            } else {
                                avatarContainer.innerHTML = `<span class="text-7xl font-black orbitron italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">${result.user.initial}</span>`;
                            }
                            
                            document.querySelectorAll('.global-user-photo').forEach(img => {
                                if (result.user.profile_photo_url) {
                                    img.src = result.user.profile_photo_url;
                                    img.classList.remove('hidden');
                                } else {
                                    img.classList.add('hidden');
                                }
                            });
                            document.querySelectorAll('.global-user-initial').forEach(span => {
                                if (result.user.profile_photo_url) {
                                    span.classList.add('hidden');
                                } else {
                                    span.textContent = result.user.initial;
                                    span.classList.remove('hidden');
                                }
                            });

                            document.querySelectorAll('.global-username').forEach(el => {
                                el.textContent = result.user.username;
                            });
                        }
                    } else {
                        notify('Protocol sync failed. Please verify neural link.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notify('System error during synchronization.', 'error');
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                    lucide.createIcons();
                });
            });
        }

        // 3. Profile Photo Preview
        const photoInput = document.getElementById('profile_photo_input');
        if(photoInput) {
            photoInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const avatarContainer = document.getElementById('avatar-container');
                        avatarContainer.innerHTML = `<img src="${event.target.result}" alt="Preview" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">`;
                        notify('Node telemetry updated. Sync to finalize.', 'info');
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }
    });
</script>
@endpush

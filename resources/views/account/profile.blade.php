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
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8 xl:gap-12 items-start">
    {{-- COLUMN 1: IDENTITY & SECURITY --}}
    <div class="space-y-8 xl:space-y-12">
        <!-- SECTION: IDENTITY -->
        <div id="tab-profile" class="tab-content active">
            <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border-white/[0.05] relative overflow-hidden group h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between gap-6 mb-10 pb-6 border-b border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center border border-purple-500/20">
                                <i data-lucide="fingerprint" class="w-5 h-5 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white tracking-tight">Profile</h3>
                                <p class="text-[10px] text-slate-500 uppercase font-black tracking-widest mt-0.5">Identity Settings</p>
                            </div>
                        </div>
                        <button id="save-changes-btn" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all active:scale-95 shadow-xl shadow-purple-900/20">Save Changes</button>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-8 items-center sm:items-start">
                        <!-- Avatar Section -->
                        <div class="relative shrink-0">
                            <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-[2rem] sm:rounded-[2.5rem] border border-white/[0.08] flex items-center justify-center relative overflow-hidden group/avatar shadow-[0_20px_50px_rgba(0,0,0,0.5)]" style="background: var(--card-inner-bg)">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 opacity-40 group-hover/avatar:opacity-60 transition-opacity duration-500"></div>
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(147,51,234,0.15),transparent_70%)]"></div>
                                
                                <div id="avatar-container" class="absolute inset-0 z-10 flex items-center justify-center">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">
                                    @else
                                        <span class="text-4xl sm:text-6xl font-black font-whiskey italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                    @endif
                                </div>
                                
                                <!-- Hover Upload Overlay -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 group-hover/avatar:opacity-100 transition-all duration-500 cursor-pointer z-20" onclick="document.getElementById('profile_photo_input').click()">
                                    <i data-lucide="camera" class="w-6 h-6 text-white mb-1"></i>
                                    <span class="text-[8px] font-bold text-white">Update</span>
                                </div>
                                <input type="file" id="profile_photo_input" class="hidden" accept="image/*">
                            </div>
                        </div>

                        <!-- Data Grid -->
                        <div class="flex-1 w-full space-y-8">
                            <!-- Field: Username -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pl-1">Username</label>
                                <div class="relative group/field">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-3 pr-4 border-r border-white/5">
                                        <i data-lucide="user" class="w-4 h-4 text-slate-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    </div>
                                    <input type="text" name="username" value="{{ Auth::user()->username }}" class="w-full bg-white/[0.02] border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-white text-sm font-semibold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.04] focus:shadow-[0_0_40px_rgba(147,51,234,0.1)] transition-all placeholder:text-slate-700" placeholder="Your account nickname">
                                </div>
                            </div>

                            <!-- Field: Email -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pl-1">Email Address</label>
                                <div class="relative group/field">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-3 pr-4 border-r border-white/5">
                                        <i data-lucide="mail" class="w-4 h-4 text-slate-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-white/[0.02] border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-white text-sm font-semibold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.04] focus:shadow-[0_0_40px_rgba(147,51,234,0.1)] transition-all placeholder:text-slate-700" placeholder="primary@interface.io">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- SECTION 4 — PASSWORD SECURITY -->
        <div id="tab-security" class="tab-content active">
            <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border-white/[0.05] relative overflow-hidden group h-full">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_100%_0%,rgba(139,92,246,0.05),transparent_50%)]"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-8">
                        <i data-lucide="lock" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-bold text-white tracking-wide">Update Security</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pl-1">Current Password</label>
                            <div class="relative group/field">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-3 pr-4 border-r border-white/5">
                                    <i data-lucide="key" class="w-4 h-4 text-slate-600 group-hover/field:text-purple-500 transition-colors"></i>
                                </div>
                                <input type="password" id="current_password" class="w-full bg-white/[0.02] border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-white text-sm font-semibold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.04] focus:shadow-[0_0_40px_rgba(147,51,234,0.1)] transition-all placeholder:text-slate-700" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pl-1">New Password</label>
                                <div class="relative group/field">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-3 pr-4 border-r border-white/5">
                                        <i data-lucide="shield-plus" class="w-4 h-4 text-slate-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    </div>
                                    <input type="password" id="new_password" class="w-full bg-white/[0.02] border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-white text-sm font-semibold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.04] focus:shadow-[0_0_40px_rgba(147,51,234,0.1)] transition-all placeholder:text-slate-700" placeholder="••••••••">
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] pl-1">Confirm New Password</label>
                                <div class="relative group/field">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex items-center gap-3 pr-4 border-r border-white/5">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-slate-600 group-hover/field:text-purple-500 transition-colors"></i>
                                    </div>
                                    <input type="password" id="new_password_confirmation" class="w-full bg-white/[0.02] border border-white/10 rounded-2xl pl-16 pr-6 py-4 text-white text-sm font-semibold focus:outline-none focus:border-purple-500/50 focus:bg-white/[0.04] focus:shadow-[0_0_40px_rgba(147,51,234,0.1)] transition-all placeholder:text-slate-700" placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                        
                        <button onclick="updatePassword()" class="w-full py-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white text-[10px] font-black uppercase tracking-widest hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all shadow-xl shadow-purple-900/20 active:scale-95">Update Security Protocol</button>
                    </div>

                    <!-- Requirements & Status -->
                    <div class="space-y-8 p-8 rounded-[2.5rem] bg-indigo-500/[0.02] border border-white/[0.03] mt-8">
                        <h4 class="text-sm font-bold text-white mb-6">Password Requirements</h4>
                        
                        <div class="space-y-5">
                            <div class="requirement-item flex items-center justify-between group" data-req="length">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="hash" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 group-[.valid]:text-emerald-500">At least 8 characters</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="uppercase">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="type" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 group-[.valid]:text-emerald-500">One uppercase letter</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="number">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="binary" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 group-[.valid]:text-emerald-500">One number</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>

                            <div class="requirement-item flex items-center justify-between group" data-req="special">
                                <div class="flex items-center gap-4">
                                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center group-[.valid]:bg-emerald-500/20 transition-colors">
                                        <i data-lucide="asterisk" class="w-4 h-4 text-gray-600 group-[.valid]:text-emerald-500"></i>
                                    </div>
                                    <span class="text-sm text-gray-500 group-[.valid]:text-emerald-500">One special character</span>
                                </div>
                                <i data-lucide="circle" class="w-3 h-3 text-gray-700 group-[.valid]:hidden"></i>
                                <i data-lucide="check-circle" class="w-3 h-3 text-emerald-500 hidden group-[.valid]:block"></i>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-white/[0.05]">
                            <div class="flex items-center gap-3">
                                <i data-lucide="history" class="w-3.5 h-3.5 text-gray-600"></i>
                                <p class="text-xs text-gray-600">Last Modified: <span class="text-indigo-500/80">3 days ago</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- COLUMN 2: SUBSCRIPTION & SESSIONS --}}
    <div class="space-y-8 xl:space-y-12">
        <!-- SECTION 2 — SUBSCRIPTION PROTOCOL -->
        <div id="tab-subscription" class="tab-content active">
            <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border-white/[0.05] relative overflow-hidden group h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                <div class="relative z-10">
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-wide">Subscription</h3>
                            <p class="text-[10px] text-gray-500 mt-1 uppercase tracking-widest font-bold">Node ID: {{ substr(md5($user->id), 0, 8) }}</p>
                        </div>
                        <div id="subscription-timer" class="whitespace-nowrap text-3xl font-black font-whiskey italic tracking-tighter text-purple-500 drop-shadow-[0_0_15px_rgba(147,51,234,0.4)]">
                            00h 00m 00s
                        </div>
                    </div>

                    @if($latestPayment && $latestPayment->status !== 'approved' && !($user->role === 'premium' && $latestPayment->status === 'approved'))
                        <div class="mb-8 p-6 rounded-3xl border {{ $latestPayment->status === 'pending' ? 'bg-white/5 border-white/20' : 'bg-rose-500/5 border-rose-500/20' }} animate-in fade-in slide-in-from-top-4 duration-700">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl {{ $latestPayment->status === 'pending' ? 'bg-white/10 text-white' : 'bg-rose-500/10 text-rose-500' }} flex items-center justify-center shrink-0">
                                    <i data-lucide="{{ $latestPayment->status === 'pending' ? 'clock' : 'shield-alert' }}" class="w-6 h-6"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold {{ $latestPayment->status === 'pending' ? 'text-white' : 'text-rose-500' }}">
                                        Payment {{ ucfirst($latestPayment->status) }}
                                    </h4>
                                    <p class="text-sm text-gray-400 mt-1">
                                        @if($latestPayment->status === 'pending')
                                            Your payment for the {{ $latestPayment->package->name ?? 'Premium' }} plan is being reviewed.
                                        @else
                                            Rejected: {{ $latestPayment->rejection_note ?? 'Payment verification failed.' }}
                                        @endif
                                    </p>
                                </div>
                                @if($latestPayment->status === 'rejected')
                                    <a href="{{ route('pricing') }}" class="px-6 py-2.5 bg-white text-black rounded-xl text-sm font-bold hover:bg-gray-100 transition-all">Try Again</a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/[0.05] space-y-4">
                        @php
                            $isActive = $preciseExpiry && \Carbon\Carbon::parse($preciseExpiry)->isFuture();
                        @endphp
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">Active Protocol</span>
                            <span class="text-sm font-bold text-white">
                                @if($user->role === 'admin') Institutional Admin @elseif($user->role === 'elite') Elite Signal Access @elseif($user->role === 'premium') Premium Protocol @else Basic Node @endif
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">Status</span>
                            <span class="px-3 py-1 rounded-full {{ ($isActive || $user->role === 'admin') ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }} text-[10px] font-bold uppercase tracking-widest">
                                {{ ($isActive || $user->role === 'admin') ? 'Operational' : 'Restricted' }}
                            </span>
                        </div>

                        <div class="pt-4 border-t border-white/[0.05] flex items-center justify-between">
                            <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">Expires</span>
                            <span class="text-sm font-bold {{ $isActive ? 'text-indigo-400' : 'text-gray-600' }}">
                                {{ $user->premium_expiry ? \Carbon\Carbon::parse($user->premium_expiry)->format('d M Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4 mt-8">
                        @if(!$isActive)
                            <a href="{{ route('pricing') }}" class="group relative px-12 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black font-whiskey uppercase tracking-[0.3em] overflow-hidden transition-all hover:scale-105 shadow-2xl">
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                                <span class="relative z-10">Upgrade Protocol</span>
                            </a>
                            <p class="text-xs text-gray-500 animate-pulse">Upgrade to access premium features.</p>
                        @else
                            <div class="px-8 py-3 rounded-xl bg-emerald-500/5 border border-emerald-500/20">
                                <p class="text-sm font-semibold text-emerald-500">Premium Access Active</p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        <!-- SECTION 3 — ACTIVE SECURE SESSIONS -->
        <div id="tab-sessions" class="tab-content active">
            <section class="glass-panel rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border-white/[0.05] relative overflow-hidden group h-full">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-4">
                            <i data-lucide="shield-check" class="w-6 h-6 text-emerald-500"></i>
                            <h3 class="text-xl font-bold text-white tracking-wide">Secure Sessions</h3>
                        </div>
                    </div>

                    <div class="space-y-4 max-h-[400px] overflow-y-auto no-scrollbar pr-2">
                        @foreach($sessions as $session)
                        <div class="p-4 bg-white/[0.02] border border-white/[0.05] rounded-xl hover:bg-white/[0.04] transition-all flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-purple-500 shrink-0">
                                    <i data-lucide="{{ str_contains($session->device, 'PC') ? 'monitor' : 'smartphone' }}" class="w-5 h-5"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ $session->device }}</p>
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest break-all leading-tight">{{ $session->ip_address }}</p>
                                </div>
                            </div>
                            @if(!$session->is_current_device)
                                <button onclick="terminateSession('{{ $session->id }}', this)" class="p-2 text-rose-500/50 hover:text-rose-500 hover:bg-rose-500/10 rounded-lg transition-all">
                                    <i data-lucide="power" class="w-4 h-4"></i>
                                </button>
                            @else
                                <span class="px-2 py-1 bg-emerald-500/10 text-emerald-500 rounded-lg text-[8px] font-bold uppercase tracking-widest border border-emerald-500/20">Current</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

    <!-- GLOBAL NEURAL NOTIFICATION SYSTEM -->
    <div id="neural-toast-container" class="fixed bottom-12 right-12 z-[100] space-y-4 pointer-events-none"></div>
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
            <span class="text-[10px] font-black font-whiskey uppercase tracking-widest">${message}</span>
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
        
        const container = btn.closest('.p-4');
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
                container.style.transform = 'translateX(20px)';
                container.style.opacity = '0';
                setTimeout(() => container.remove(), 300);
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
                                avatarContainer.innerHTML = `<span class="text-7xl font-black font-whiskey italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">${result.user.initial}</span>`;
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
                        notify('Photo updated. Click Save Changes to apply.', 'info');
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        // 4. Subscription Timer Logic
        @if($user->premium_expiry)
        const expiry = new Date("{{ $preciseExpiry }}").getTime();
        const timerDisplay = document.getElementById('subscription-timer');
        
        if (timerDisplay) {
            const updateTimer = () => {
                const now = new Date().getTime();
                const distance = expiry - now;
                
                if (distance <= 0) {
                    timerDisplay.innerText = "00h 00m 00s";
                    timerDisplay.classList.remove('text-purple-500');
                    timerDisplay.classList.add('text-rose-500/20');
                    return;
                }
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                let timeString = "";
                if (days > 0) timeString += `${days}d `;
                timeString += `${hours.toString().padStart(2, '0')}h ${minutes.toString().padStart(2, '0')}m ${seconds.toString().padStart(2, '0')}s`;
                
                timerDisplay.innerText = timeString;
            };
            
            updateTimer();
            setInterval(updateTimer, 1000);
        }
        @endif
    });
</script>
@endpush

@extends('layouts.dashboard')

@section('title', 'Institutional Settings | AlgoTrade AI')

@section('content')
<style>
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
<div class="space-y-12">
    
    <!-- HEADER SECTION -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 border-b border-white/[0.05] pb-12">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-purple-600/10 border border-purple-500/20 text-purple-400 text-[8px] font-black orbitron tracking-[0.3em] uppercase rounded-full">Settings Control</span>
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            <h1 class="text-5xl font-black orbitron uppercase italic tracking-tighter mb-4 leading-none" style="color: var(--text-white)">Neural Hub</h1>
            <p class="text-gray-500 text-sm font-medium tracking-wide max-w-xl">Configure your institutional identity, security protocols, and algorithmic execution parameters across the AlgoTrade neural network.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden md:block">
                <p class="text-[9px] font-bold orbitron text-gray-600 uppercase tracking-widest mb-1">Last Protocol Sync</p>
                <p class="text-xs font-black orbitron" style="color: var(--text-white)">06:42:18 UTC</p>
            </div>
            <div class="w-px h-10 bg-white/[0.05]"></div>
            <button id="save-changes-btn" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.3)] transition-all">Save Changes</button>
        </div>
    </div>

    <!-- SETTINGS NAVIGATION (HORIZONTAL) -->
    <div class="sticky top-0 z-50 backdrop-blur-xl border-b border-white/[0.05] -mx-12 px-12 mb-12" style="background: var(--nav-sticky-bg)">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-4" id="settings-nav">
            @php
                $tabs = [
                    ['id' => 'profile', 'label' => 'Identity', 'icon' => 'fingerprint'],
                    ['id' => 'security', 'label' => 'Security', 'icon' => 'shield-check'],
                    ['id' => 'trading', 'label' => 'Algorithms', 'icon' => 'bar-chart-3'],
                    ['id' => 'ai-signals', 'label' => 'Neural Engine', 'icon' => 'brain-circuit'],
                    ['id' => 'notifications', 'label' => 'Alert Channels', 'icon' => 'radio'],
                    ['id' => 'subscription', 'label' => 'Node Status', 'icon' => 'zap'],
                    ['id' => 'broker', 'label' => 'Bridges', 'icon' => 'repeat'],
                    ['id' => 'privacy', 'label' => 'Privacy', 'icon' => 'eye-off'],
                ];
            @endphp

            @foreach($tabs as $index => $tab)
            <button onclick="switchTab('{{ $tab['id'] }}')" 
                    class="tab-trigger flex items-center gap-3 px-6 py-3 rounded-xl transition-all group outline-none shrink-0 {{ $index === 0 ? 'bg-white/[0.04] border border-white/[0.1] shadow-xl' : 'text-gray-500 hover:text-gray-300' }}"
                    style="{{ $index === 0 ? 'color: var(--text-white)' : '' }}"
                    data-tab="{{ $tab['id'] }}">
                <i data-lucide="{{ $tab['icon'] }}" class="w-4 h-4 group-hover:scale-110 transition-transform {{ $index === 0 ? 'text-purple-500' : '' }}"></i>
                <span class="text-[9px] font-black orbitron uppercase tracking-[0.2em]">{{ $tab['label'] }}</span>
                @if($index === 0)
                    <div class="w-1 h-1 rounded-full bg-purple-500 shadow-[0_0_8px_#9333ea]"></div>
                @endif
            </button>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 gap-12">
        <!-- MAIN PANELS (Full Width) -->
        <div class="space-y-12">
            
            {{-- 1. IDENTITY --}}
            <div id="tab-profile" class="tab-content active space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05] relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-10">
                            <i data-lucide="fingerprint" class="w-6 h-6 text-purple-500"></i>
                            <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Identity Protocol</h3>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-8 xl:gap-12 items-center lg:items-start">
                            <!-- Avatar Section -->
                            <div class="relative shrink-0">
                                <div class="w-44 h-44 rounded-[3.5rem] border border-white/[0.08] flex items-center justify-center relative overflow-hidden group/avatar shadow-[0_20px_50px_rgba(0,0,0,0.5)]" style="background: var(--card-inner-bg)">
                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 to-purple-600/30 opacity-40 group-hover/avatar:opacity-60 transition-opacity duration-500"></div>
                                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(147,51,234,0.15),transparent_70%)]"></div>
                                    
                                    <div id="avatar-container" class="absolute inset-0 z-10 flex items-center justify-center">
                                        @if(Auth::user()->profile_photo)
                                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">
                                        @else
                                            <span class="text-7xl font-black orbitron italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
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
                            <div class="flex-1 w-full mt-4 lg:mt-0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
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

            {{-- 2. SECURITY --}}
            <div id="tab-security" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="shield-check" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Active Secure Sessions</h3>
                    </div>

                    <div class="grid gap-6">
                        @for($i=1; $i<=2; $i++)
                        <div class="session-card flex flex-col sm:flex-row items-center justify-between p-8 bg-white/[0.02] border border-white/[0.04] rounded-3xl group hover:border-purple-500/20 hover:bg-white/[0.04] transition-all duration-300">
                            <div class="flex items-center gap-6 mb-6 sm:mb-0">
                                <div class="w-16 h-16 rounded-2xl border border-white/[0.05] flex items-center justify-center text-purple-400 relative overflow-hidden group-hover:scale-105 transition-transform" style="background: var(--card-inner-bg)">
                                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-transparent"></div>
                                    <i data-lucide="{{ $i == 1 ? 'monitor' : 'smartphone' }}" class="w-8 h-8 relative z-10"></i>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-sm font-black orbitron uppercase tracking-tight" style="color: var(--text-white)">{{ $i == 1 ? 'Windows Desktop Protocol' : 'Neural Mobile ID' }}</h4>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500 shadow-[0_0_5px_#10b981]"></span>
                                            <span class="text-[9px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em]">Active Now</span>
                                        </div>
                                        <span class="w-px h-3 bg-white/[0.1] hidden sm:block"></span>
                                        <span class="text-[9px] font-medium text-gray-600 uppercase tracking-[0.1em] italic">124.81.19.{{ rand(10,99) }} · New Delhi, IN</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto p-1 bg-white/[0.02] border border-white/[0.05] rounded-xl">
                                <button class="w-full sm:w-auto px-6 py-3 rounded-lg bg-rose-500/10 border border-rose-500/20 text-[9px] font-black orbitron text-rose-500 uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all duration-300">Kill Session</button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </section>
            </div>

            {{-- 3. ALGORITHMS --}}
            <div id="tab-trading" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="bar-chart-3" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Execution Parameters</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-4">
                            <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Risk Strategy</label>
                            <input type="hidden" name="risk_strategy" id="risk_strategy" value="{{ Auth::user()->risk_strategy }}">
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" onclick="setRiskStrategy('Aggressive')" 
                                        class="risk-btn p-4 rounded-xl border {{ Auth::user()->risk_strategy == 'Aggressive' ? 'bg-purple-500/10 border-purple-500/30 text-purple-400' : 'bg-white/[0.02] border-white/[0.05] text-[var(--text-muted)]' }} text-[10px] font-black orbitron uppercase transition-all" 
                                        data-strategy="Aggressive">Aggressive</button>
                                <button type="button" onclick="setRiskStrategy('Balanced')" 
                                        class="risk-btn p-4 rounded-xl border {{ Auth::user()->risk_strategy == 'Balanced' ? 'bg-purple-500/10 border-purple-500/30 text-purple-400' : 'bg-white/[0.02] border-white/[0.05] text-[var(--text-muted)]' }} text-[10px] font-black orbitron uppercase transition-all" 
                                        data-strategy="Balanced">Balanced</button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Default Allocation</label>
                            <div class="relative group/field">
                                <i data-lucide="wallet" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-600 group-hover/field:text-purple-500 transition-colors"></i>
                                <input type="text" name="default_allocation" value="{{ Auth::user()->default_allocation }}" class="w-full bg-white/[0.03] border border-white/[0.08] rounded-2xl pl-14 pr-20 py-4.5 text-[var(--text-white)] font-black orbitron italic text-sm focus:outline-none focus:border-purple-500/40 focus:bg-white/[0.06] transition-all shadow-inner uppercase tracking-wider">
                                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[9px] font-black orbitron text-purple-500 uppercase italic">INR</span>
                            </div>
                        </div>
                        <div class="space-y-4 md:col-span-2">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Stop Loss Threshold</label>
                                <span id="sl-value" class="text-xs font-black orbitron text-rose-500 italic">{{ Auth::user()->sl_threshold }}%</span>
                            </div>
                            <div class="relative h-1.5 bg-white/[0.05] rounded-full overflow-hidden">
                                <div id="sl-bar" class="absolute inset-y-0 left-0 w-[{{ Auth::user()->sl_threshold }}%] bg-gradient-to-r from-purple-600 to-rose-500 rounded-full shadow-[0_0_15px_rgba(244,63,94,0.3)]"></div>
                                <input type="range" name="sl_threshold" id="sl-range" min="0" max="100" step="0.01" value="{{ Auth::user()->sl_threshold }}" class="absolute inset-0 opacity-0 cursor-pointer w-full">
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- 4. NEURAL ENGINE --}}
            <div id="tab-ai-signals" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05] bg-gradient-to-br from-purple-900/[0.05] to-transparent">
                    <div class="flex items-center justify-between mb-16">
                        <div class="flex items-center gap-4">
                            <i data-lucide="brain-circuit" class="w-6 h-6 text-purple-500"></i>
                            <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Neural Tuning</h3>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[9px] font-black orbitron text-purple-500 uppercase italic">Power State:</span>
                            <span class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 text-[9px] font-black orbitron text-emerald-500 uppercase italic rounded-lg">OPTIMIZED</span>
                        </div>
                    </div>

                    <div class="space-y-20">
                        <div class="space-y-8">
                            <div class="flex justify-between items-end">
                                <div>
                                    <h4 class="text-xs font-black orbitron uppercase tracking-widest mb-1" style="color: var(--text-white)">Signal Sensitivity</h4>
                                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-[0.1em]">Adjust neural filter density</p>
                                </div>
                                <span id="alpha-value" class="text-4xl font-black orbitron text-purple-500 italic tracking-tighter">{{ Auth::user()->signal_sensitivity }} <span class="text-sm font-bold text-gray-700 not-italic uppercase ml-2">ALPHA</span></span>
                            </div>
                            <input type="range" name="signal_sensitivity" id="alpha-range" min="0" max="1" step="0.01" value="{{ Auth::user()->signal_sensitivity }}" class="w-full h-1.5 bg-white/[0.05] rounded-full appearance-none cursor-pointer accent-purple-600 border border-white/[0.1]">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="p-8 border border-white/[0.05] rounded-3xl text-center group hover:border-purple-500/30 transition-all" style="background: var(--card-inner-bg)">
                                <p class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-4 group-hover:text-purple-500 transition-colors">Neural Confidence</p>
                                <div class="flex items-center justify-center gap-1">
                                    <input type="number" name="neural_confidence" value="{{ Auth::user()->neural_confidence }}" class="w-16 bg-transparent border-none text-2xl font-black orbitron italic text-center focus:outline-none" style="color: var(--text-white)">
                                    <span class="text-2xl font-black orbitron italic" style="color: var(--text-white)">%</span>
                                </div>
                                <p class="text-[8px] font-bold orbitron text-gray-700 uppercase tracking-widest">MIN THRESHOLD</p>
                            </div>
                            <div class="p-8 border border-white/[0.05] rounded-3xl text-center group hover:border-purple-500/30 transition-all" style="background: var(--card-inner-bg)">
                                <p class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-4 group-hover:text-purple-500 transition-colors">Learning Rate</p>
                                <input type="number" name="learning_rate" value="{{ Auth::user()->learning_rate }}" step="0.0001" class="w-full bg-transparent border-none text-2xl font-black orbitron italic text-center focus:outline-none" style="color: var(--text-white)">
                                <p class="text-[8px] font-bold orbitron text-gray-700 uppercase tracking-widest">DELTA ADAPT</p>
                            </div>
                            <div class="p-8 border border-white/[0.05] rounded-3xl text-center group hover:border-purple-500/30 transition-all" style="background: var(--card-inner-bg)">
                                <p class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-4 group-hover:text-purple-500 transition-colors">Pattern Depth</p>
                                <input type="text" name="pattern_depth" value="{{ Auth::user()->pattern_depth }}" class="w-full bg-transparent border-none text-2xl font-black orbitron italic text-center focus:outline-none" style="color: var(--text-white)">
                                <p class="text-[8px] font-bold orbitron text-gray-700 uppercase tracking-widest">MATRIX CORE</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- 5. NOTIFICATIONS --}}
            <div id="tab-notifications" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="radio" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Alert Orchestration</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach([
                            ['label' => 'Neural Signals', 'desc' => 'Instant Buy/Sell triggers', 'status' => 'ACTIVE'],
                            ['label' => 'Market Volatility', 'desc' => 'Abnormal price movements', 'status' => 'ACTIVE'],
                            ['label' => 'Node Status', 'desc' => 'System & maintenance logs', 'status' => 'STANDBY'],
                            ['label' => 'Portfolio Delta', 'desc' => 'Balance change summaries', 'status' => 'DISABLED'],
                        ] as $notif)
                        <div class="flex items-center justify-between p-8 bg-white/[0.01] border border-white/[0.04] rounded-3xl group hover:bg-white/[0.03] transition-all">
                            <div>
                                <h4 class="text-sm font-black uppercase tracking-tight" style="color: var(--text-white)">{{ $notif['label'] }}</h4>
                                <p class="text-[9px] font-medium text-gray-600 uppercase tracking-widest mt-1.5">{{ $notif['desc'] }}</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $notif['status'] == 'ACTIVE' ? 'bg-emerald-500 animate-pulse' : 'bg-gray-800' }}"></div>
                                    <span class="text-[8px] font-black orbitron {{ $notif['status'] == 'ACTIVE' ? 'text-emerald-500' : 'text-gray-700' }} uppercase tracking-widest">{{ $notif['status'] }}</span>
                                </div>
                            </div>
                            <div class="neural-toggle relative w-14 h-8 {{ $notif['status'] == 'ACTIVE' ? 'bg-purple-600' : 'bg-white/5' }} rounded-full border border-white/[0.05] transition-all cursor-pointer">
                                <div class="absolute {{ $notif['status'] == 'ACTIVE' ? 'right-1' : 'left-1' }} top-1 w-6 h-6 bg-white rounded-full transition-all"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- 6. SUBSCRIPTION --}}
            <div id="tab-subscription" class="tab-content space-y-10">
                <section class="glass-panel rounded-[3rem] p-16 border-indigo-500/20 relative overflow-hidden ring-1 ring-indigo-500/10" 
                         style="background: linear-gradient(to bottom right, rgba(79, 70, 229, 0.1), var(--bg-deep))">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-600/10 blur-[100px] rounded-full"></div>
                    
                    <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-16">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-4 py-1.5 bg-amber-500 text-black text-[9px] font-black orbitron uppercase tracking-[0.2em] rounded-lg italic shadow-[0_0_20px_rgba(251,191,36,0.2)]">Active Membership</span>
                                <span class="text-[9px] font-black orbitron text-amber-500 uppercase italic tracking-widest">Premium Tier</span>
                            </div>
                            <h3 class="text-6xl font-black orbitron uppercase italic tracking-tighter mb-4 leading-none" style="color: var(--text-white)">Neural Elite</h3>
                            <p class="text-gray-500 text-xs font-medium uppercase tracking-[0.2em] italic">Full Algorithmic Access · Renews in 24 Days</p>
                        </div>

                        <div class="flex gap-4">
                            <button class="px-10 py-5 bg-white text-black rounded-3xl text-[11px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 transition-all shadow-2xl">Manage Billing</button>
                            <button class="px-10 py-5 bg-white/[0.03] border border-white/[0.08] text-gray-500 hover:text-white rounded-3xl text-[11px] font-black orbitron uppercase tracking-[0.2em] transition-all">Node Overview</button>
                        </div>
                    </div>
                </section>
                
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <h3 class="text-xl font-black orbitron uppercase italic tracking-wider mb-10" style="color: var(--text-white)">Ledger Protocol</h3>
                    <div class="space-y-4">
                        @for($i=1; $i<=3; $i++)
                        <div class="flex items-center justify-between p-8 bg-white/[0.01] border border-white/[0.04] rounded-[2rem] group hover:border-indigo-500/20 transition-all">
                            <div class="flex items-center gap-8">
                                <div class="w-14 h-14 rounded-2xl border border-white/[0.05] flex items-center justify-center text-gray-500 group-hover:text-indigo-400 transition-colors" style="background: var(--card-inner-bg)">
                                    <i data-lucide="file-check" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black uppercase tracking-tight" style="color: var(--text-white)">Invoice #ATX-99{{ $i }}2</p>
                                    <p class="text-[9px] font-black orbitron text-gray-700 uppercase tracking-widest mt-2">MARCH {{ 28 - $i }}, 2026 · NEURAL ELITE CORE</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-black orbitron italic mb-1" style="color: var(--text-white)">₹ 9,999</p>
                                <button class="text-[8px] font-black orbitron text-indigo-500 hover:text-white uppercase tracking-[0.2em] transition-all underline underline-offset-8">Download Registry</button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </section>
            </div>

            {{-- 7. BROKER --}}
            <div id="tab-broker" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="repeat" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Broker Bridges</h3>
                    </div>

                    <div class="p-16 text-center border-2 border-dashed border-white/[0.05] rounded-[3rem] bg-white/[0.01]">
                        <div class="w-20 h-20 bg-purple-600/10 rounded-[2.5rem] flex items-center justify-center text-purple-500 mx-auto mb-8 shadow-2xl">
                            <i data-lucide="unplug" class="w-10 h-10"></i>
                        </div>
                        <h4 class="text-2xl font-black orbitron uppercase italic tracking-tight mb-4" style="color: var(--text-white)">No Bridge Active</h4>
                        <p class="text-gray-500 text-sm font-medium mb-12 max-w-md mx-auto">Establish a secure API connection between AlgoTrade and your brokerage to automate neural signal execution.</p>
                        <button class="px-12 py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-3xl text-[11px] font-black orbitron text-white uppercase tracking-[0.3em] hover:scale-105 transition-all shadow-xl shadow-purple-500/20">Establish Bridge</button>
                    </div>
                </section>
            </div>

            {{-- 8. PRIVACY --}}
            <div id="tab-privacy" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="eye-off" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron uppercase italic tracking-wider" style="color: var(--text-white)">Visibility Protocols</h3>
                    </div>

                    <div class="space-y-6">
                        @foreach([
                            ['label' => 'Leaderboard Participation', 'desc' => 'Display your neural performance to the network'],
                            ['label' => 'Diagnostic Feed', 'desc' => 'Allow system telemetry sharing for optimization'],
                        ] as $item)
                        <div class="flex items-center justify-between p-8 bg-white/[0.01] border border-white/[0.04] rounded-3xl">
                            <div>
                                <h4 class="text-sm font-black uppercase tracking-tight" style="color: var(--text-white)">{{ $item['label'] }}</h4>
                                <p class="text-[9px] font-medium text-gray-600 uppercase tracking-widest mt-1.5">{{ $item['desc'] }}</p>
                            </div>
                            <div class="neural-toggle relative w-14 h-8 bg-white/5 rounded-full border border-white/[0.05] cursor-pointer">
                                <div class="absolute left-1 top-1 w-6 h-6 bg-white/10 rounded-full transition-all"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>

                <section class="glass-panel rounded-[2.5rem] p-12 border-rose-500/20 bg-rose-500/[0.01] relative overflow-hidden ring-1 ring-rose-500/10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-12">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <i data-lucide="alert-octagon" class="w-5 h-5 text-rose-500"></i>
                                <span class="text-[9px] font-black orbitron text-rose-500 uppercase italic tracking-widest">Termination Zone</span>
                            </div>
                            <h4 class="text-2xl font-black orbitron uppercase italic tracking-tight mb-2" style="color: var(--text-white)">Purge Neural ID</h4>
                            <p class="text-gray-600 text-[10px] font-medium uppercase tracking-widest">Permanently delete terminal data, signal history, and brokerage links.</p>
                        </div>
                        <button onclick="openPurgeModal()" class="px-10 py-5 bg-rose-500/10 border border-rose-500/20 text-[11px] font-black orbitron text-rose-500 uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all rounded-2xl">Delete Protocol</button>
                    </div>
                </section>
            </div>

        </div>
    </div>

    <!-- GLOBAL NEURAL NOTIFICATION SYSTEM -->
    <div id="neural-toast-container" class="fixed bottom-12 right-12 z-[100] space-y-4 pointer-events-none"></div>

    <!-- PURGE MODAL -->
    <div id="purge-modal" class="fixed inset-0 z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-500">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-xl"></div>
        <div class="relative glass-panel rounded-[3rem] p-16 border-rose-500/30 max-w-xl w-full text-center space-y-10 scale-90 transition-transform duration-500" id="purge-modal-inner">
            <div class="w-24 h-24 bg-rose-500/10 rounded-[2.5rem] flex items-center justify-center text-rose-500 mx-auto shadow-[0_0_50px_rgba(244,63,94,0.2)] animate-pulse">
                <i data-lucide="alert-triangle" class="w-12 h-12"></i>
            </div>
            <div class="space-y-4">
                <h4 class="text-3xl font-black orbitron uppercase italic tracking-tighter" style="color: var(--text-white)">Triple-Check Required</h4>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-widest">You are about to permanently purge your neural identity. This action is irreversible across all brokerage nodes.</p>
            </div>
            <div class="space-y-4">
                <input type="text" id="purge-confirm" placeholder="TYPE 'TERMINATE' TO CONFIRM" class="perfect-input w-full rounded-2xl px-8 py-5 text-center text-rose-500 font-black orbitron uppercase tracking-[0.3em] outline-none">
                <div class="flex gap-4">
                    <button onclick="closePurgeModal()" class="flex-1 py-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] hover:text-white transition-all">Abort Protocol</button>
                    <button id="final-purge-btn" class="flex-1 py-5 rounded-2xl bg-rose-500 text-white text-[10px] font-black orbitron uppercase tracking-[0.2em] opacity-30 cursor-not-allowed transition-all" disabled>Liquidate ID</button>
                </div>
            </div>
        </div>
    </div>

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

    // --- TAB SYSTEM ---
    function switchTab(tabId) {
        document.querySelectorAll('.tab-trigger').forEach(btn => {
            btn.classList.remove('bg-white/[0.04]', 'text-white', 'border', 'border-white/[0.1]', 'shadow-xl');
            btn.classList.add('text-gray-500', 'hover:text-gray-300');
            
            // Robustly find the icon (can be <i> or <svg> after lucide-icons runs)
            const icon = btn.querySelector('i, svg');
            if(icon) icon.classList.remove('text-purple-500');
            
            const dot = btn.querySelector('.rounded-full');
            if(dot) dot.remove();

            if (btn.getAttribute('data-tab') === tabId) {
                btn.classList.add('bg-white/[0.04]', 'text-white', 'border', 'border-white/[0.1]', 'shadow-xl');
                btn.classList.remove('text-gray-500', 'hover:text-gray-300');
                if(icon) icon.classList.add('text-purple-500');
                const newDot = document.createElement('div');
                newDot.className = 'w-1 h-1 rounded-full bg-purple-500 shadow-[0_0_8px_#9333ea]';
                btn.appendChild(newDot);
                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });

        document.querySelectorAll('.tab-content').forEach(pane => {
            pane.classList.remove('active');
            if (pane.id === `tab-${tabId}`) {
                pane.classList.add('active');
                if (typeof gsap !== 'undefined') {
                    gsap.fromTo(`#tab-${tabId}`, { y: 15, opacity: 0 }, { y: 0, opacity: 1, duration: 0.3, ease: "power2.out" });
                }
            }
        });
    }

    // --- MODAL CONTROLS ---
    function openPurgeModal() {
        const modal = document.getElementById('purge-modal');
        const inner = document.getElementById('purge-modal-inner');
        modal.classList.remove('pointer-events-none');
        modal.classList.add('opacity-100');
        inner.classList.add('scale-100');
    }

    function closePurgeModal() {
        const modal = document.getElementById('purge-modal');
        const inner = document.getElementById('purge-modal-inner');
        modal.classList.remove('opacity-100');
        inner.classList.remove('scale-100');
        setTimeout(() => modal.classList.add('pointer-events-none'), 500);
    }

    // Expose functions globally immediately
    window.switchTab = switchTab;
    window.openPurgeModal = openPurgeModal;
    window.closePurgeModal = closePurgeModal;

    function setRiskStrategy(strategy) {
        document.getElementById('risk_strategy').value = strategy;
        document.querySelectorAll('.risk-btn').forEach(btn => {
            if (btn.getAttribute('data-strategy') === strategy) {
                btn.classList.add('bg-purple-500/10', 'border-purple-500/30', 'text-purple-400');
                btn.classList.remove('bg-white/[0.02]', 'border-white/[0.05]', 'text-[var(--text-muted)]');
            } else {
                btn.classList.remove('bg-purple-500/10', 'border-purple-500/30', 'text-purple-400');
                btn.classList.add('bg-white/[0.02]', 'border-white/[0.05]', 'text-[var(--text-muted)]');
            }
        });
    }
    window.setRiskStrategy = setRiskStrategy;

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        // (Rest of the init code)

        // 1. Sliders - Realtime Updates
        const alphaRange = document.getElementById('alpha-range');
        const alphaValue = document.getElementById('alpha-value');
        if(alphaRange && alphaValue) {
            alphaRange.addEventListener('input', (e) => {
                const val = parseFloat(e.target.value).toFixed(2);
                alphaValue.firstChild.textContent = val + ' ';
            });
        }

        const slRange = document.getElementById('sl-range');
        const slValue = document.getElementById('sl-value');
        const slBar = document.getElementById('sl-bar');
        if(slRange && slValue) {
            slRange.addEventListener('input', (e) => {
                const val = e.target.value + '%';
                slValue.textContent = val;
                slBar.style.width = val;
            });
        }

        // 2. Global Save Logic
        const saveBtn = document.getElementById('save-changes-btn');
        if(saveBtn) {
            saveBtn.addEventListener('click', () => {
                saveBtn.disabled = true;
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<span class="flex items-center gap-2 justify-center"><i data-lucide="loader-2" class="w-3 h-3 animate-spin"></i> SYNCING...</span>';
                lucide.createIcons();
                
                // Collect all input data using FormData
                const formData = new FormData();
                
                // Text inputs
                const inputs = document.querySelectorAll('input[name]');
                inputs.forEach(input => {
                    formData.append(input.name, input.value);
                });

                // Profile Photo
                const photoInput = document.getElementById('profile_photo_input');
                if (photoInput.files.length > 0) {
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
                        // Update UI elements
                        if (result.user) {
                            // Update avatar initial if no photo, or update photo
                            const avatarContainer = document.getElementById('avatar-container');
                            if (result.user.profile_photo_url) {
                                avatarContainer.innerHTML = `<img src="${result.user.profile_photo_url}" alt="Profile" class="w-full h-full object-cover transition-transform duration-500 group-hover/avatar:scale-110" id="avatar-image">`;
                            } else {
                                avatarContainer.innerHTML = `<span class="text-7xl font-black orbitron italic select-none tracking-tighter" id="avatar-initial" style="color: var(--text-white); filter: drop-shadow(0 0 10px rgba(255,255,255,0.2))">${result.user.initial}</span>`;
                            }
                            
                            // Update other global profile photos
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

                            // Update all username displays
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

        // 3. Purge Validation
        const purgeInput = document.getElementById('purge-confirm');
        const finalPurgeBtn = document.getElementById('final-purge-btn');
        if(purgeInput) {
            purgeInput.addEventListener('input', (e) => {
                if(e.target.value.toUpperCase() === 'TERMINATE') {
                    finalPurgeBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                    finalPurgeBtn.classList.add('hover:scale-105');
                    finalPurgeBtn.disabled = false;
                } else {
                    finalPurgeBtn.classList.add('opacity-30', 'cursor-not-allowed');
                    finalPurgeBtn.classList.remove('hover:scale-105');
                    finalPurgeBtn.disabled = true;
                }
            });
        }

        // 4. Session Controls
        document.querySelectorAll('.kill-session-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const container = e.target.closest('.session-card');
                gsap.to(container, { opacity: 0, x: 20, duration: 0.3, onComplete: () => {
                    container.remove();
                    notify('Secure session terminated', 'info');
                }});
            });
        });

        // 5. Connect Toggle Logic
        document.querySelectorAll('.neural-toggle').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const inner = toggle.querySelector('div');
                const isActive = toggle.classList.contains('bg-purple-600');
                
                if(isActive) {
                    toggle.classList.remove('bg-purple-600');
                    toggle.classList.add('bg-white/5');
                    inner.classList.add('left-1');
                    inner.classList.remove('right-1');
                    notify('Channel protocol disabled', 'info');
                } else {
                    toggle.classList.add('bg-purple-600');
                    toggle.classList.remove('bg-white/5');
                    inner.classList.remove('left-1');
                    inner.classList.add('right-1');
                    notify('Channel protocol activated', 'success');
                }
            });
        });

        // 6. Profile Photo Preview
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

    // Global exposed functions
    window.openPurgeModal = openPurgeModal;
    window.closePurgeModal = closePurgeModal;
    window.switchTab = switchTab;
</script>
@endpush

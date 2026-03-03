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
            <h1 class="text-5xl font-black orbitron text-white uppercase italic tracking-tighter mb-4 leading-none">Neural Hub</h1>
            <p class="text-gray-500 text-sm font-medium tracking-wide max-w-xl">Configure your institutional identity, security protocols, and algorithmic execution parameters across the AlgoTrade neural network.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden md:block">
                <p class="text-[9px] font-bold orbitron text-gray-600 uppercase tracking-widest mb-1">Last Protocol Sync</p>
                <p class="text-xs font-black text-white orbitron">06:42:18 UTC</p>
            </div>
            <div class="w-px h-10 bg-white/[0.05]"></div>
            <button id="save-changes-btn" class="px-8 py-4 bg-white text-black rounded-2xl text-[10px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition-all">Save Changes</button>
        </div>
    </div>

    <!-- SETTINGS NAVIGATION (HORIZONTAL) -->
    <div class="sticky top-0 z-50 bg-[#020105]/80 backdrop-blur-xl border-b border-white/[0.05] -mx-12 px-12 mb-12">
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
                    class="tab-trigger flex items-center gap-3 px-6 py-3 rounded-xl transition-all group outline-none shrink-0 {{ $index === 0 ? 'bg-white/[0.04] text-white border border-white/[0.1] shadow-xl' : 'text-gray-500 hover:text-gray-300' }}"
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
                            <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Identity Protocol</h3>
                        </div>

                        <div class="flex flex-col xl:flex-row gap-16 items-start">
                            <div class="relative">
                                <div class="w-40 h-40 rounded-[3rem] bg-[#0a0514] border border-white/[0.05] flex items-center justify-center relative overflow-hidden group/avatar shadow-2xl">
                                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-600 opacity-20 group-hover/avatar:opacity-40 transition-opacity"></div>
                                    <span class="text-6xl font-black orbitron text-white italic z-10">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover/avatar:opacity-100 transition-all cursor-pointer">
                                        <i data-lucide="upload-cloud" class="w-8 h-8 text-white"></i>
                                    </div>
                                </div>
                                <div class="absolute -bottom-2 -right-2 px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                                    <p class="text-[8px] font-black orbitron text-emerald-500 uppercase tracking-widest">Verified Node</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-1 w-full">
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Username Handle</label>
                                    <input type="text" value="{{ Auth::user()->username }}" class="perfect-input w-full rounded-2xl px-6 py-4.5 text-white text-sm outline-none">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Neural Email</label>
                                    <input type="email" value="{{ Auth::user()->email }}" class="perfect-input w-full rounded-2xl px-6 py-4.5 text-white text-sm outline-none">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Access PIN</label>
                                    <input type="password" value="********" class="perfect-input w-full rounded-2xl px-6 py-4.5 text-white text-sm outline-none">
                                </div>
                                <div class="flex items-end">
                                    <button class="w-full py-4.5 rounded-2xl bg-white/[0.03] border border-white/[0.08] text-[10px] font-black orbitron text-white uppercase tracking-[0.2em] hover:bg-white/[0.06] transition-all">Reset Access Credentials</button>
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
                        <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Active Secure Sessions</h3>
                    </div>

                    <div class="grid gap-6">
                        @for($i=1; $i<=2; $i++)
                        <div class="session-card flex items-center justify-between p-8 bg-white/[0.02] border border-white/[0.04] rounded-3xl group hover:border-purple-500/20 transition-all">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-[#0a0514] border border-white/[0.05] flex items-center justify-center text-purple-400">
                                    <i data-lucide="{{ $i == 1 ? 'monitor' : 'smartphone' }}" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white uppercase tracking-tight">{{ $i == 1 ? 'Windows Desktop Protocol' : 'Neural Mobile ID' }}</h4>
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <span class="text-[9px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em]">Active Now</span>
                                        <span class="w-px h-2.5 bg-white/[0.1]"></span>
                                        <span class="text-[9px] font-medium text-gray-600 uppercase tracking-widest">124.81.19.{{ rand(10,99) }} · New Delhi, IN</span>
                                    </div>
                                </div>
                            </div>
                            <button class="kill-session-btn px-6 py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-[9px] font-black orbitron text-rose-500 uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">Kill Session</button>
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
                        <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Execution Parameters</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div class="space-y-4">
                            <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Risk Strategy</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button class="p-4 rounded-xl bg-purple-500/10 border border-purple-500/30 text-[10px] font-black orbitron text-purple-400 uppercase">Aggressive</button>
                                <button class="p-4 rounded-xl bg-white/[0.02] border border-white/[0.05] text-[10px] font-black orbitron text-gray-500 uppercase hover:text-gray-300">Balanced</button>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Default Allocation</label>
                            <div class="relative">
                                <input type="text" value="₹ 50,000" class="perfect-input w-full rounded-2xl px-6 py-4.5 text-white font-black orbitron italic text-sm outline-none">
                                <span class="absolute right-6 top-1/2 -translate-y-1/2 text-[9px] font-black orbitron text-purple-500 uppercase italic">INR</span>
                            </div>
                        </div>
                        <div class="space-y-4 md:col-span-2">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] ml-2">Stop Loss Threshold</label>
                                <span id="sl-value" class="text-xs font-black orbitron text-rose-500 italic">2.45%</span>
                            </div>
                            <div class="relative h-1.5 bg-white/[0.05] rounded-full overflow-hidden">
                                <div id="sl-bar" class="absolute inset-y-0 left-0 w-[24.5%] bg-gradient-to-r from-purple-600 to-rose-500 rounded-full shadow-[0_0_15px_rgba(244,63,94,0.3)]"></div>
                                <input type="range" id="sl-range" min="0" max="100" value="24.5" class="absolute inset-0 opacity-0 cursor-pointer w-full">
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
                            <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Neural Tuning</h3>
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
                                    <h4 class="text-xs font-black orbitron text-white uppercase tracking-widest mb-1">Signal Sensitivity</h4>
                                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-[0.1em]">Adjust neural filter density</p>
                                </div>
                                <span id="alpha-value" class="text-4xl font-black orbitron text-purple-500 italic tracking-tighter">0.82 <span class="text-sm font-bold text-gray-700 not-italic uppercase ml-2">ALPHA</span></span>
                            </div>
                            <input type="range" id="alpha-range" min="0" max="1" step="0.01" value="0.82" class="w-full h-1.5 bg-white/[0.05] rounded-full appearance-none cursor-pointer accent-purple-600 border border-white/[0.1]">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach([
                                ['label' => 'Neural Confidence', 'value' => '75%', 'sub' => 'MIN THRESHOLD'],
                                ['label' => 'Learning Rate', 'value' => '0.005', 'sub' => 'DELTA ADAPT'],
                                ['label' => 'Pattern Depth', 'value' => 'V4.2', 'sub' => 'MATRIX CORE'],
                            ] as $stat)
                            <div class="p-8 bg-black/20 border border-white/[0.05] rounded-3xl text-center group hover:border-purple-500/30 transition-all">
                                <p class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-4 group-hover:text-purple-500 transition-colors">{{ $stat['label'] }}</p>
                                <p class="text-2xl font-black orbitron text-white italic mb-1">{{ $stat['value'] }}</p>
                                <p class="text-[8px] font-bold orbitron text-gray-700 uppercase tracking-widest">{{ $stat['sub'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>

            {{-- 5. NOTIFICATIONS --}}
            <div id="tab-notifications" class="tab-content space-y-10">
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <div class="flex items-center gap-4 mb-12">
                        <i data-lucide="radio" class="w-6 h-6 text-purple-500"></i>
                        <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Alert Orchestration</h3>
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
                                <h4 class="text-sm font-black text-white uppercase tracking-tight">{{ $notif['label'] }}</h4>
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
                <section class="glass-panel rounded-[3rem] p-16 border-white/[0.05] bg-gradient-to-br from-indigo-950/[0.2] to-[#020105] border-indigo-500/20 relative overflow-hidden ring-1 ring-indigo-500/10">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-600/10 blur-[100px] rounded-full"></div>
                    
                    <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-16">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <span class="px-4 py-1.5 bg-amber-500 text-black text-[9px] font-black orbitron uppercase tracking-[0.2em] rounded-lg italic shadow-[0_0_20px_rgba(251,191,36,0.2)]">Active Membership</span>
                                <span class="text-[9px] font-black orbitron text-amber-500 uppercase italic tracking-widest">Premium Tier</span>
                            </div>
                            <h3 class="text-6xl font-black orbitron text-white uppercase italic tracking-tighter mb-4 leading-none">Neural Elite</h3>
                            <p class="text-gray-500 text-xs font-medium uppercase tracking-[0.2em] italic">Full Algorithmic Access · Renews in 24 Days</p>
                        </div>

                        <div class="flex gap-4">
                            <button class="px-10 py-5 bg-white text-black rounded-3xl text-[11px] font-black orbitron uppercase tracking-[0.2em] hover:scale-105 transition-all shadow-2xl">Manage Billing</button>
                            <button class="px-10 py-5 bg-white/[0.03] border border-white/[0.08] text-gray-500 hover:text-white rounded-3xl text-[11px] font-black orbitron uppercase tracking-[0.2em] transition-all">Node Overview</button>
                        </div>
                    </div>
                </section>
                
                <section class="glass-panel rounded-[2.5rem] p-12 border-white/[0.05]">
                    <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider mb-10">Ledger Protocol</h3>
                    <div class="space-y-4">
                        @for($i=1; $i<=3; $i++)
                        <div class="flex items-center justify-between p-8 bg-white/[0.01] border border-white/[0.04] rounded-[2rem] group hover:border-indigo-500/20 transition-all">
                            <div class="flex items-center gap-8">
                                <div class="w-14 h-14 rounded-2xl bg-[#0a0514] border border-white/[0.05] flex items-center justify-center text-gray-500 group-hover:text-indigo-400 transition-colors">
                                    <i data-lucide="file-check" class="w-7 h-7"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-white uppercase tracking-tight">Invoice #ATX-99{{ $i }}2</p>
                                    <p class="text-[9px] font-black orbitron text-gray-700 uppercase tracking-widest mt-2">MARCH {{ 28 - $i }}, 2026 · NEURAL ELITE CORE</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-black orbitron text-white italic mb-1">₹ 9,999</p>
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
                        <h4 class="text-2xl font-black orbitron text-white uppercase italic tracking-tight mb-4">No Bridge Active</h4>
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
                        <h3 class="text-xl font-black orbitron text-white uppercase italic tracking-wider">Visibility Protocols</h3>
                    </div>

                    <div class="space-y-6">
                        @foreach([
                            ['label' => 'Leaderboard Participation', 'desc' => 'Display your neural performance to the network'],
                            ['label' => 'Diagnostic Feed', 'desc' => 'Allow system telemetry sharing for optimization'],
                        ] as $item)
                        <div class="flex items-center justify-between p-8 bg-white/[0.01] border border-white/[0.04] rounded-3xl">
                            <div>
                                <h4 class="text-sm font-black text-white uppercase tracking-tight">{{ $item['label'] }}</h4>
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
                            <h4 class="text-2xl font-black orbitron text-white uppercase italic tracking-tight mb-2">Purge Neural ID</h4>
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
                <h4 class="text-3xl font-black orbitron text-white uppercase italic tracking-tighter">Triple-Check Required</h4>
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
            const icon = btn.querySelector('i');
            icon.classList.remove('text-purple-500');
            const dot = btn.querySelector('.rounded-full');
            if(dot) dot.remove();

            if (btn.getAttribute('data-tab') === tabId) {
                btn.classList.add('bg-white/[0.04]', 'text-white', 'border', 'border-white/[0.1]', 'shadow-xl');
                btn.classList.remove('text-gray-500', 'hover:text-gray-300');
                icon.classList.add('text-purple-500');
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
                gsap.fromTo(`#tab-${tabId}`, { y: 15, opacity: 0 }, { y: 0, opacity: 1, duration: 0.3, ease: "power2.out" });
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

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

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
                
                setTimeout(() => {
                    notify('Neural protocols synchronized successfully', 'success');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }, 2000);
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
    });

    // Global exposed functions
    window.openPurgeModal = openPurgeModal;
    window.closePurgeModal = closePurgeModal;
    window.switchTab = switchTab;
</script>
@endpush

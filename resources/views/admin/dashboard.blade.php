@extends('layouts.admin')

@section('title', 'NEURAL DASHBOARD')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black orbitron text-purple-500 uppercase tracking-[0.3em]">SYSTEM STATUS: OPERATIONAL</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black orbitron italic uppercase tracking-tighter text-white">
                CORE <span class="text-purple-500 text-glow">TELEMETRY</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Welcome back, Commander <span class="text-white">{{ Auth::user()->username }}</span></p>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button onclick="toggleModal('notificationModal')" class="glass-panel hover:bg-white/5 border border-purple-500/30 text-white px-6 py-3.5 rounded-xl font-black text-[10px] orbitron tracking-[0.25em] uppercase transition-all flex items-center gap-3 shadow-lg shadow-purple-500/10 group">
                <i data-lucide="bell-ring" class="w-4 h-4 text-purple-500 group-hover:animate-pulse"></i> BROADCAST ALERT
            </button>
            <div class="glass-panel p-3 px-6 rounded-xl border border-white/5 flex items-center gap-6">
                <div class="text-right">
                   <div class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none mb-1 text-right">NODE UPTIME</div>
                   <div class="text-xs font-black text-emerald-500 orbitron">99.98%</div>
                </div>
                <div class="w-[1px] h-8 bg-white/5"></div>
                <div class="text-right">
                   <div class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none mb-1 text-right">ACTIVE CORES</div>
                   <div class="text-xs font-black text-purple-500 orbitron">12/12</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid (4 per row) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php 
        $stats = [
            ['label' => 'Today\'s Visitors', 'value' => $visitor_stats['today'], 'icon' => 'user-check', 'color' => 'purple', 'trend' => 'Daily'],
            ['label' => 'Monthly Visitors', 'value' => $visitor_stats['month'], 'icon' => 'users', 'color' => 'blue', 'trend' => '30 Days'],
            ['label' => 'Total Visitors', 'value' => $visitor_stats['total'], 'icon' => 'globe', 'color' => 'emerald', 'trend' => 'Lifetime'],
            ['label' => 'Total Users', 'value' => $total_users, 'icon' => 'user-plus', 'color' => 'amber', 'trend' => 'Registered'],
        ];
        $colors = [
            'purple' => 'from-purple-600 to-indigo-600 text-purple-400',
            'blue' => 'from-blue-600 to-cyan-600 text-blue-400',
            'emerald' => 'from-emerald-600 to-teal-600 text-emerald-400',
            'amber' => 'from-amber-500 to-orange-500 text-amber-400',
        ];
        @endphp

        @foreach ($stats as $stat)
        <div class="glass-card p-8 rounded-[2rem] border border-white/5 relative overflow-hidden group hover:border-white/10 transition-all duration-500">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-white/[0.03] to-transparent rounded-bl-full translate-x-10 -translate-y-10 group-hover:translate-x-5 group-hover:-translate-y-5 transition-transform duration-700"></div>
            
            <div class="relative z-10 space-y-6">
                <div class="flex justify-between items-start">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white transition-all group-hover:scale-110 group-hover:bg-white/10">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 {{ $colors[$stat['color']] }}"></i>
                    </div>
                    <span class="text-[9px] font-black orbitron {{ $colors[$stat['color']] }} tracking-widest bg-white/5 px-3 py-1 rounded-full">{{ $stat['trend'] }}</span>
                </div>
                
                <div>
                    <div class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.25em] mb-2">{{ $stat['label'] }}</div>
                    <div class="text-4xl font-black text-white orbitron tracking-tighter">{{ $stat['value'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Live Market Activity / Placeholder for Chart -->
        {{-- 
        <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-10 border border-white/5 relative overflow-hidden min-h-[500px] flex flex-col">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
                <div>
                    <h3 class="orbitron font-black text-xs tracking-[0.3em] text-white uppercase">Neural Growth Analytics</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-bold mt-1 tracking-widest">REAL-TIME DATA STREAM V4.2</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-lg bg-white/5 text-[9px] font-black orbitron text-gray-400 hover:text-white transition-all">DAILY</button>
                    <button class="px-4 py-2 rounded-lg bg-purple-600 text-[9px] font-black orbitron text-white transition-all">WEEKLY</button>
                </div>
            </div>
            
            <div class="flex-1 flex flex-col items-center justify-center text-center space-y-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full border border-purple-500/20 flex items-center justify-center animate-pulse">
                        <i data-lucide="bar-chart-3" class="w-10 h-10 text-purple-500/40"></i>
                    </div>
                    <div class="absolute inset-0 bg-purple-500/5 blur-3xl rounded-full"></div>
                </div>
                <div>
                    <p class="orbitron font-bold text-[10px] tracking-widest text-gray-500 uppercase">Awaiting Data Population</p>
                    <p class="text-[10px] text-gray-700 uppercase tracking-widest mt-2 max-w-xs mx-auto leading-relaxed">Advanced telemetry visualization will initialize upon first market trigger event.</p>
                </div>
            </div>
        </div>
        --}}
        <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-10 border border-white/5 flex flex-col items-center justify-center text-center min-h-[500px]">
            <div class="w-20 h-20 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-6">
                <i data-lucide="lock" class="w-8 h-8 text-gray-600"></i>
            </div>
            <h3 class="orbitron font-black text-xs tracking-[0.3em] text-gray-500 uppercase">Module Suspended</h3>
            <p class="text-[10px] text-gray-700 uppercase tracking-widest mt-2">Neural Analytics and Predictive Streams are currently offline.</p>
        </div>

        <!-- System Logs -->
        <div class="glass-card rounded-[2.5rem] p-10 border border-white/5 flex flex-col">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
                <h3 class="orbitron font-black text-xs tracking-[0.3em] text-white uppercase italic">Stream Log</h3>
                <span class="text-[9px] font-black orbitron text-emerald-500 tracking-widest animate-pulse">LIVE</span>
            </div>

            <div class="flex-1 space-y-8 overflow-y-auto no-scrollbar max-h-[400px]">
                @php
                $logs = [
                    ['msg' => 'Satellite connection synchronized', 'time' => '2M AGO', 'type' => 'success'],
                    ['msg' => 'AI Model (V4.2) weights updated', 'time' => '15M AGO', 'type' => 'purple'],
                    ['msg' => 'High volatility alert triggered', 'time' => '1H AGO', 'type' => 'amber'],
                    ['msg' => 'User ID:48239 session terminated', 'time' => '2H AGO', 'type' => 'danger'],
                    ['msg' => 'New Premium Payload detected', 'time' => '4H AGO', 'type' => 'success'],
                    ['msg' => 'System firewall protocol active', 'time' => 'Yesterday', 'type' => 'purple'],
                ];
                $logTypes = [
                    'success' => 'bg-emerald-500',
                    'purple' => 'bg-purple-500', 
                    'amber' => 'bg-amber-500',
                    'danger' => 'bg-rose-500'
                ];
                @endphp

                @foreach($logs as $index => $log)
                <div class="flex gap-6 items-start relative group">
                    @if($index < count($logs) - 1)
                    <div class="absolute left-[3px] top-6 bottom-[-32px] w-[1px] bg-white/5"></div>
                    @endif
                    <div class="w-2 h-2 rounded-full {{ $logTypes[$log['type']] }} mt-1.5 shadow-[0_0_10px_rgba(255,255,255,0.1)] group-hover:scale-125 transition-transform duration-300"></div>
                    <div class="flex-1">
                        <div class="text-[11px] font-black text-gray-300 group-hover:text-white transition-colors duration-300 uppercase leading-normal tracking-wide">{{ $log['msg'] }}</div>
                        <div class="text-[9px] font-bold text-gray-600 orbitron uppercase tracking-[0.2em] mt-2 italic">{{ $log['time'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-auto pt-10 border-t border-white/5">
                <button class="w-full py-4 border border-white/5 rounded-2xl text-[10px] orbitron font-black text-gray-500 hover:text-white hover:bg-white/5 transition-all uppercase tracking-[0.250em]">
                    Export System Protocol
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal Re-styled -->
<div id="notificationModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 sm:p-0">
    <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" onclick="toggleModal('notificationModal')"></div>
    <div class="glass-card w-full max-w-xl rounded-[3rem] border border-white/10 relative z-10 overflow-hidden shadow-[0_0_100px_rgba(147,51,234,0.1)]">
        <div class="p-10 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
            <div>
                <h2 class="orbitron font-black text-xl text-white italic tracking-tighter uppercase">Neural Broadcast</h2>
                <div class="text-[9px] font-black orbitron text-purple-500 tracking-[0.3em] mt-1 uppercase">PRIORITY LEVEL: GLOBAL</div>
            </div>
            <button onclick="toggleModal('notificationModal')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 hover:text-white transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form action="{{ route('admin.broadcast-notification') }}" method="POST" class="p-10 space-y-10">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-3">Broadcast Title</label>
                    <input type="text" name="title" required placeholder="PROTOCOL IDENTIFIED..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs orbitron outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700">
                </div>
                <div>
                    <label class="block text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-3">Transmission Message</label>
                    <textarea name="message" required rows="4" placeholder="ENTER MESSAGE CONTENT..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs orbitron outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700 resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-3">Target Nodes</label>
                        <select name="target" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[10px] font-black orbitron outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="premium">PREMIUM ONLY</option>
                            <option value="all">ALL NODES</option>
                            <option value="admin">OFFICERS ONLY</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] mb-3">Alert Intensity</label>
                        <select name="type" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[10px] font-black orbitron outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="info">ROUTINE (INFO)</option>
                            <option value="success">POSITIVE (SUCCESS)</option>
                            <option value="warning">CAUTION (WARNING)</option>
                            <option value="danger">CRITICAL (DANGER)</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black orbitron uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] transition-all shadow-xl shadow-purple-900/40 italic">Authorize Transmission</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }
</script>
@endpush
@endsection

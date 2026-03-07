@extends('layouts.admin')

@section('title', 'Neural Dashboard')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="flex justify-between items-end">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl border border-white/10 flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-500/20 to-purple-500/20 shadow-2xl relative">
                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : '' }}" 
                     alt="Admin" 
                     class="w-full h-full object-cover global-user-photo {{ !Auth::user()->profile_photo ? 'hidden' : '' }}">
                
                <span class="global-user-initial text-2xl font-black orbitron text-white italic {{ Auth::user()->profile_photo ? 'hidden' : '' }}">
                    {{ Auth::user() ? strtoupper(substr(Auth::user()->username, 0, 1)) : 'A' }}
                </span>
            </div>
            <div>
                <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                    CORE <span class="text-purple-500 text-glow">DASHBOARD</span>
                </h1>
                <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest leading-none">Welcome back, Control Center Officer <span class="global-username">{{ Auth::user() ? Auth::user()->username : 'Officer' }}</span></p>
            </div>
        </div>
        <div class="flex gap-4">
            <button onclick="toggleModal('notificationModal')" class="bg-amber-500 hover:bg-amber-600 text-black px-6 py-3 rounded-2xl font-bold text-xs orbitron tracking-widest uppercase transition-all flex items-center gap-2">
                <i data-lucide="bell" class="w-4 h-4"></i> Send Notification
            </button>
            <div class="text-right hidden sm:block">
               <div class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-1">System Health</div>
               <div class="flex items-center gap-2 text-emerald-500 text-xs font-bold">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                  99.9% OPERATIONAL
               </div>
            </div>
        </div>
    </div>


    <!-- Notification Modal -->
    <div id="notificationModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 sm:p-0">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModal('notificationModal')"></div>
        <div class="glass-card w-full max-w-xl rounded-[2.5rem] border border-white/10 relative z-10 overflow-hidden">
            <div class="p-8 border-b border-white/5 bg-white/5 flex justify-between items-center">
                <h2 class="orbitron font-black text-white italic tracking-tighter uppercase">Global Neural Broadcast</h2>
                <button onclick="toggleModal('notificationModal')" class="text-gray-500 hover:text-white"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form action="{{ route('admin.broadcast-notification') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Notification Title</label>
                        <input type="text" name="title" required placeholder="e.g. System Maintenance Update" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-amber-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Broadcast Message</label>
                        <textarea name="message" required rows="3" placeholder="Enter the protocol details..." class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-amber-500/50 transition-all"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Target Node(s)</label>
                            <select name="target" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-amber-500/50 transition-all">
                                <option value="premium">Premium Only</option>
                                <option value="all">All Users</option>
                                <option value="admin">Admins Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Alert Intensity</label>
                            <select name="type" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-amber-500/50 transition-all">
                                <option value="info" class="text-blue-500">Normal (Info)</option>
                                <option value="success" class="text-emerald-500">Positive (Success)</option>
                                <option value="warning" class="text-amber-500">Caution (Warning)</option>
                                <option value="danger" class="text-rose-500">Critical (Danger)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-amber-500 rounded-xl text-black font-black orbitron uppercase tracking-widest text-xs hover:scale-[1.02] transition-all shadow-xl shadow-amber-500/20 italic">Authorize Global Broadcast</button>
            </form>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php 
        $stats = [
            ['label' => 'Total Users', 'value' => $total_users, 'icon' => 'users', 'color' => 'purple'],
            ['label' => 'AI Accuracy', 'value' => $ai_accuracy . '%', 'icon' => 'cpu', 'color' => 'emerald'],
            ['label' => 'Net Revenue', 'value' => $net_revenue, 'icon' => 'dollar-sign', 'color' => 'amber'],
        ];
        $colors = [
            'purple' => 'from-purple-600 to-indigo-600 shadow-purple-500/10',
            'blue' => 'from-blue-600 to-cyan-600 shadow-blue-500/10',
            'emerald' => 'from-emerald-600 to-teal-600 shadow-emerald-500/10',
            'amber' => 'from-amber-500 to-orange-500 shadow-amber-500/10',
        ];
        @endphp

        @foreach ($stats as $stat)
        <div class="glass-card p-6 rounded-3xl border border-white/5 relative overflow-hidden group transition-all hover:translate-y-[-5px]">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-white/5 to-transparent rounded-bl-[100%]"></div>
            <div class="relative z-10 flex flex-col h-full justify-between gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $colors[$stat['color']] }} flex items-center justify-center text-white shadow-2xl">
                    <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</div>
                    <div class="text-2xl font-black text-white">{{ $stat['value'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Interface Modules -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass-card rounded-3xl p-8 border border-white/5 min-h-[400px] flex flex-col items-center justify-center text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center text-gray-500">
                <i data-lucide="bar-chart-3" class="w-8 h-8"></i>
            </div>
            <div>
                <h3 class="orbitron font-bold text-xs tracking-widest text-gray-400 uppercase">System Analytics</h3>
                <p class="text-[10px] text-gray-600 uppercase tracking-widest mt-2">Additional telemetry modules will be deployed in the next cycle.</p>
            </div>
        </div>

        <div class="glass-card rounded-3xl p-8 border border-white/5">
            <h3 class="orbitron font-bold text-xs tracking-widest text-gray-400 uppercase mb-8">Stream Log</h3>
            <div class="space-y-6">
                @php
                $logs = [
                    ['msg' => 'Satellite User Connection Established', 'time' => '3 minutes ago'],
                    ['msg' => 'AI Model Neural Weights Synchronized', 'time' => '6 minutes ago'],
                    ['msg' => 'Market Real-time Data Feed Active', 'time' => '9 minutes ago'],
                    ['msg' => 'System Guard: Persistent Firewall Active', 'time' => '12 minutes ago'],
                    ['msg' => 'Admin Protocol: UI Module Refined', 'time' => '15 minutes ago'],
                ];
                @endphp

                @foreach($logs as $index => $log)
                <div class="flex gap-4 items-start relative group">
                    @if($index < count($logs) - 1)
                    <div class="absolute left-[7px] top-6 bottom-[-24px] w-[1px] bg-white/5"></div>
                    @endif
                    <div class="w-4 h-4 rounded-full bg-purple-500/20 border border-purple-500/40 flex items-center justify-center relative z-10">
                        <div class="w-1.5 h-1.5 rounded-full bg-purple-500"></div>
                    </div>
                    <div class="flex-1">
                        <div class="text-[11px] font-bold text-gray-300 group-hover:text-purple-400 transition-colors">{{ $log['msg'] }}</div>
                        <div class="text-[9px] text-gray-500 uppercase tracking-wider mt-1">{{ $log['time'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="w-full mt-10 py-3 border border-white/5 rounded-xl text-[9px] orbitron font-bold text-gray-500 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest">
                View Full Protocol Log
            </button>
        </div>
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

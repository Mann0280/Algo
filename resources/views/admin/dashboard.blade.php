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
            <button onclick="toggleModal('broadcastModal')" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-2xl font-bold text-xs orbitron tracking-widest uppercase transition-all flex items-center gap-2">
                <i data-lucide="zap" class="w-4 h-4"></i> Broadcast Elite Signal
            </button>
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

    <!-- Broadcast Modal -->
    <div id="broadcastModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 sm:p-0">
        <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModal('broadcastModal')"></div>
        <div class="glass-card w-full max-w-2xl rounded-[2.5rem] border border-white/10 relative z-10 overflow-hidden">
            <div class="p-8 border-b border-white/5 bg-white/5 flex justify-between items-center">
                <h2 class="orbitron font-black text-white italic tracking-tighter uppercase">Broadcast Neural Signal</h2>
                <button onclick="toggleModal('broadcastModal')" class="text-gray-500 hover:text-white"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <form action="{{ route('admin.broadcast-tip') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Stock Name</label>
                        <input type="text" name="stock_name" required placeholder="e.g. RELIANCE" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Strategy Type</label>
                        <select name="trade_type" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                            <option value="Intraday">Intraday</option>
                            <option value="Swing">Swing</option>
                            <option value="Long Term">Long Term</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Entry Price</label>
                        <input type="number" step="0.01" name="entry_price" required placeholder="2845.50" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Target 1</label>
                        <input type="number" step="0.01" name="target_1" required placeholder="2920.00" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Stop Loss</label>
                        <input type="number" step="0.01" name="stop_loss" required placeholder="2780.00" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">AI Confidence %</label>
                        <input type="number" name="confidence" required placeholder="92" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-2">Risk Level</label>
                        <select name="risk_level" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm outline-none focus:border-purple-500/50 transition-all">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl text-white font-black orbitron uppercase tracking-widest text-xs hover:scale-[1.02] transition-all shadow-xl shadow-purple-500/20 italic">Initial Broadcast Sequence</button>
            </form>
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
            ['label' => 'Active Signals', 'value' => $active_signals, 'icon' => 'zap', 'color' => 'blue'],
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
        <div class="lg:col-span-2 glass-card rounded-3xl p-8 border border-white/5 min-h-[400px]">
            <div class="flex justify-between items-center mb-8">
                <h3 class="orbitron font-bold text-xs tracking-widest text-gray-400 uppercase">Performance Analytics</h3>
                <div class="flex gap-2">
                    <span class="px-3 py-1 bg-white/5 rounded-full text-[9px] orbitron font-bold text-gray-500 uppercase tracking-tighter">Live Telemetry</span>
                    <span class="px-3 py-1 bg-purple-500/10 rounded-full text-[9px] orbitron font-bold text-purple-400 uppercase tracking-tighter">94.2% Success</span>
                </div>
            </div>
            
            <div class="space-y-6">
                <!-- Header -->
                <div class="grid grid-cols-4 gap-4 pb-4 border-b border-white/5 text-[10px] orbitron font-bold text-gray-500 uppercase tracking-widest">
                    <div>Sector</div>
                    <div class="text-center">Signals</div>
                    <div class="col-span-2">Accuracy</div>
                </div>

                @php
                $analytics = [
                    ['sector' => 'IT', 'signals' => 142, 'accuracy' => 96.5, 'color' => 'emerald'],
                    ['sector' => 'Banking', 'signals' => 89, 'accuracy' => 92.1, 'color' => 'purple'],
                    ['sector' => 'Auto', 'signals' => 64, 'accuracy' => 88.4, 'color' => 'amber'],
                    ['sector' => 'Pharma', 'signals' => 51, 'accuracy' => 94.8, 'color' => 'purple'],
                    ['sector' => 'Energy', 'signals' => 38, 'accuracy' => 85.2, 'color' => 'amber'],
                ];
                @endphp

                @foreach($analytics as $item)
                <div class="grid grid-cols-4 gap-4 items-center group">
                    <div class="font-bold text-white orbitron text-[11px] uppercase tracking-wider group-hover:text-purple-400 transition-colors">{{ $item['sector'] }}</div>
                    <div class="text-center text-gray-400 font-bold text-xs">{{ $item['signals'] }}</div>
                    <div class="col-span-2 flex items-center gap-3">
                        <div class="flex-1 h-1.5 bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-{{ $item['color'] }}-500 rounded-full" style="width: {{ $item['accuracy'] }}%"></div>
                        </div>
                        <div class="text-[10px] font-black orbitron text-white min-w-[40px] text-right">{{ $item['accuracy'] }}%</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="glass-card rounded-3xl p-8 border border-white/5">
            <h3 class="orbitron font-bold text-xs tracking-widest text-gray-400 uppercase mb-8">Stream Log</h3>
            <div class="space-y-6">
                @php
                $logs = [
                    ['msg' => 'Satellite User Connection Established', 'time' => '3 minutes ago'],
                    ['msg' => 'AI Model v4.2 Weights Synchronized', 'time' => '6 minutes ago'],
                    ['msg' => 'NSE Real-time Data Feed Active', 'time' => '9 minutes ago'],
                    ['msg' => 'Premium Signal Broadcasted: RELIANCE', 'time' => '12 minutes ago'],
                    ['msg' => 'System Guard: Firewall Rule Updated', 'time' => '15 minutes ago'],
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

@extends('layouts.admin')

@section('title', 'Admin Overview')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">SYSTEM STATUS: ACTIVE</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                SITE <span class="text-purple-500 text-glow">DASHBOARD</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Welcome back, <span class="text-white">{{ Auth::user()->username }}</span></p>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button onclick="toggleModal('notificationModal')" class="glass-panel hover:bg-white/5 border border-purple-500/30 text-white px-6 py-3.5 rounded-xl font-semibold text-[10px] font-whiskey tracking-widest uppercase transition-all flex items-center gap-3 shadow-lg shadow-purple-500/10 group">
                <i data-lucide="bell-ring" class="w-4 h-4 text-purple-500 group-hover:animate-pulse"></i> SEND NOTIFICATION
            </button>
            <div class="glass-panel p-3 px-6 rounded-xl border border-white/5 flex items-center gap-6">
                <div class="text-right">
                    <div class="text-[9px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest leading-none mb-1 text-right">SITE UPTIME</div>
                   <div class="text-xs font-semibold text-emerald-500 font-whiskey">99.9%</div>
                </div>
                <div class="w-[1px] h-8 bg-white/5"></div>
                <div class="text-right">
                   <div class="text-[9px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest leading-none mb-1 text-right">ACTIVE CORES</div>
                   <div class="text-xs font-semibold text-purple-500 font-whiskey">12/12</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        @php 
        $stats = [
            ['label' => 'Today\'s Visitors', 'value' => $visitor_stats['today'], 'icon' => 'user-check', 'color' => 'purple', 'trend' => 'Daily'],
            ['label' => 'Monthly Visitors', 'value' => $visitor_stats['month'], 'icon' => 'users', 'color' => 'blue', 'trend' => '30 Days'],
            ['label' => 'Total Visitors', 'value' => $visitor_stats['total'], 'icon' => 'globe', 'color' => 'emerald', 'trend' => 'Lifetime'],
            ['label' => 'Total Users', 'value' => $total_users, 'icon' => 'user-plus', 'color' => 'white', 'trend' => 'Registered'],
        ];
        $colors = [
            'purple' => 'from-purple-600 to-indigo-600 text-purple-400',
            'blue' => 'from-blue-600 to-cyan-600 text-blue-400',
            'emerald' => 'from-emerald-600 to-teal-600 text-emerald-400',
            'white' => 'from-white/10 to-white/20 text-white',
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
                    <span class="text-[9px] font-black font-whiskey {{ $colors[$stat['color']] }} tracking-widest bg-white/5 px-3 py-1 rounded-full">{{ $stat['trend'] }}</span>
                </div>
                
                <div>
                    <div class="text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-[0.25em] mb-2">{{ $stat['label'] }}</div>
                    <div class="text-4xl font-black text-white font-whiskey tracking-tighter">{{ $stat['value'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts & Logs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Visitor Traffic Chart -->
        <div class="lg:col-span-2 glass-card rounded-[2.5rem] p-10 border border-white/5 relative overflow-hidden min-h-[500px] flex flex-col">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
                <div>
                    <h3 class="font-whiskey font-black text-xs tracking-widest text-white uppercase">Visitor Statistics</h3>
                    <p class="text-[10px] text-gray-500 uppercase font-bold mt-1 tracking-widest">Live Traffic Data</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-lg bg-white/5 text-[9px] font-black font-whiskey text-gray-400 hover:text-white transition-all">DAILY</button>
                    <button class="px-4 py-2 rounded-lg bg-purple-600 text-[9px] font-black font-whiskey text-white transition-all">WEEKLY</button>
                </div>
            </div>
            
            <div class="flex-1 relative">
                <canvas id="visitorTrafficChart"></canvas>
            </div>
        </div>

        <!-- System Logs -->
        <div class="glass-card rounded-[2.5rem] p-10 border border-white/5 flex flex-col">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-white/5">
                <h3 class="font-whiskey font-black text-xs tracking-widest text-white uppercase italic">Activity Log</h3>
                <span class="text-[9px] font-semibold font-whiskey text-emerald-500 tracking-widest animate-pulse">LIVE</span>
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
                        <div class="text-[9px] font-bold text-gray-600 font-whiskey uppercase tracking-[0.2em] mt-2 italic">{{ $log['time'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-auto pt-10 border-t border-white/5">
                <button class="w-full py-4 border border-white/5 rounded-2xl text-[10px] font-whiskey font-black text-gray-500 hover:text-white hover:bg-white/5 transition-all uppercase tracking-[0.250em]">
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
                <h2 class="font-whiskey font-black text-xl text-white italic tracking-tighter uppercase">Global Notification</h2>
                <div class="text-[9px] font-semibold font-whiskey text-purple-500 tracking-widest mt-1 uppercase">Target: All Users</div>
            </div>
            <button onclick="toggleModal('notificationModal')" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 hover:text-white transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form action="{{ route('admin.broadcast-notification') }}" method="POST" class="p-10 space-y-10">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest mb-3">Notification Title</label>
                    <input type="text" name="title" required placeholder="Subject..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs font-whiskey outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700">
                </div>
                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest mb-3">Message Content</label>
                    <textarea name="message" required rows="4" placeholder="Type your message here..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs font-whiskey outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700 resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] mb-3">Target Nodes</label>
                        <select name="target" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[10px] font-black font-whiskey outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="premium">PREMIUM ONLY</option>
                            <option value="all">ALL NODES</option>
                            <option value="admin">OFFICERS ONLY</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] mb-3">Alert Intensity</label>
                        <select name="type" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[10px] font-black font-whiskey outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="info">ROUTINE (INFO)</option>
                            <option value="success">POSITIVE (SUCCESS)</option>
                            <option value="warning">CAUTION (WARNING)</option>
                            <option value="danger">CRITICAL (DANGER)</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black font-whiskey uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] transition-all shadow-xl shadow-purple-900/40 italic">Authorize Transmission</button>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorTrafficChart').getContext('2d');
        const purpleGradient = ctx.createLinearGradient(0, 0, 0, 400);
        purpleGradient.addColorStop(0, 'rgba(147, 51, 234, 0.4)');
        purpleGradient.addColorStop(1, 'rgba(147, 51, 234, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($chart_data, 'day')) !!},
                datasets: [{
                    label: 'Unique Visitors',
                    data: {!! json_encode(array_column($chart_data, 'count')) !!},
                    borderColor: '#9333ea',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#9333ea',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: purpleGradient,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0c0518',
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 12 },
                        padding: 12,
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)', drawBorder: false },
                        ticks: { color: '#6b7280', font: { family: 'Inter', size: 9 }, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280', font: { family: 'Inter', size: 9 } }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection

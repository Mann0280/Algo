@extends('layouts.admin')

@section('title', 'NEURAL ANALYTICS')

@section('content')
<div class="space-y-12 max-w-[1400px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black orbitron text-purple-500 uppercase tracking-[0.3em]">DATA EXTRACTION LAYER</span>
            </div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                SYNERGIC <span class="text-purple-500 text-glow">ANALYTICS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Visualizing Growth Metrics and Neural Efficiency</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_10px_#a855f7]"></span>
                <span class="text-[10px] font-black orbitron text-purple-400 uppercase tracking-widest text-glow-sm">LIVE FEED ACTIVE</span>
            </div>
        </div>
    </div>

    <!-- Analytics Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- New Users Chart Card -->
        <div class="lg:col-span-2 glass-card p-10 rounded-[2.5rem] border border-white/5 flex flex-col gap-8 shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-10 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="users" class="w-24 h-24 text-purple-500"></i>
            </div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="orbitron text-xs font-black tracking-[0.2em] uppercase text-gray-400">Node Population</h3>
                    <div class="text-4xl font-black orbitron text-white italic mt-2">{{ $total_users }} <span class="text-purple-500 text-xl font-bold not-italic font-sans tracking-tight ml-1">+12%</span></div>
                </div>
                <div class="bg-purple-600/10 border border-purple-500/20 px-3 py-1.5 rounded-xl text-[9px] font-black orbitron text-purple-400 uppercase tracking-widest leading-none mt-1">Growth Matrix</div>
            </div>
            <div class="h-64 w-full">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <!-- Signal Distribution Card -->
        <div class="lg:col-span-2 glass-card p-10 rounded-[2.5rem] border border-white/5 flex flex-col gap-8 shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-10 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="zap" class="w-24 h-24 text-indigo-500"></i>
            </div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="orbitron text-xs font-black tracking-[0.2em] uppercase text-gray-400">Signal Ingress</h3>
                    <div class="text-4xl font-black orbitron text-white italic mt-2">{{ $active_signals }} <span class="text-indigo-500 text-xl font-bold not-italic font-sans tracking-tight ml-1">Live Signals</span></div>
                </div>
                <div class="bg-indigo-600/10 border border-indigo-500/20 px-3 py-1.5 rounded-xl text-[9px] font-black orbitron text-indigo-400 uppercase tracking-widest leading-none mt-1">Distribution</div>
            </div>
            <div class="h-64 w-full">
                <canvas id="signalChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Deep Metrics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Revenue Performance -->
        <div class="lg:col-span-2 glass-card p-10 rounded-[2.5rem] border border-white/5 shadow-2xl">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 shadow-[0_0_20px_rgba(16,185,129,0.1)]">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="orbitron text-sm font-black tracking-[0.2em] uppercase text-white leading-none">Financial Trajectory</h2>
                    <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-2 leading-none">Net Revenue Synchronization</p>
                </div>
            </div>
            <div class="h-80 w-full mb-8">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-white/5">
                <div class="text-center">
                    <div class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Total Yield</div>
                    <div class="text-xl font-black orbitron text-white">{{ $net_revenue }}</div>
                </div>
                <div class="text-center border-x border-white/5">
                    <div class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Efficiency</div>
                    <div class="text-xl font-black orbitron text-emerald-400">{{ $ai_accuracy }}%</div>
                </div>
                <div class="text-center">
                    <div class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Active Nodes</div>
                    <div class="text-xl font-black orbitron text-white">{{ $total_users }}</div>
                </div>
            </div>
        </div>

        <!-- System Efficiency Gauge -->
        <div class="glass-card p-10 rounded-[2.5rem] border border-white/5 shadow-2xl flex flex-col items-center justify-center text-center gap-8 relative overflow-hidden group">
            <div class="absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-transparent via-purple-500/50 to-transparent"></div>
            
            <h2 class="orbitron text-xs font-black tracking-[0.4em] uppercase text-gray-500">Neural Precision Factor</h2>
            
            <div class="relative w-56 h-56 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="112" cy="112" r="100" stroke="currentColor" stroke-width="12" fill="transparent" class="text-white/5"></circle>
                    <circle cx="112" cy="112" r="100" stroke="currentColor" stroke-width="12" fill="transparent" stroke-dasharray="628" stroke-dashoffset="{{ 628 - (628 * (float)$ai_accuracy / 100) }}" stroke-linecap="round" class="text-purple-500 shadow-[0_0_20px_#a855f7]"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-5xl font-black orbitron text-white italic tracking-tighter">{{ $ai_accuracy }}%</span>
                    <span class="text-[9px] font-black orbitron text-purple-400 uppercase tracking-[0.2em] mt-1 shadow-purple-500/50">Optimal Range</span>
                </div>
            </div>

            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest max-w-[200px] leading-relaxed">
                Platform operational efficiency is currently stabilized within optimal neural parameters.
            </p>

            <div class="w-full grid grid-cols-2 gap-4 mt-4">
                <div class="bg-white/5 border border-white/10 rounded-2xl py-4 px-2">
                    <div class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">CPU Load</div>
                    <div class="text-sm font-black orbitron text-white">2.4%</div>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl py-4 px-2">
                    <div class="text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest mb-1">Latency</div>
                    <div class="text-sm font-black orbitron text-white font-mono">14ms</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxGrowth = document.getElementById('growthChart').getContext('2d');
        const ctxSignal = document.getElementById('signalChart').getContext('2d');
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

        const purpleGradient = ctxGrowth.createLinearGradient(0, 0, 0, 300);
        purpleGradient.addColorStop(0, 'rgba(168, 85, 247, 0.3)');
        purpleGradient.addColorStop(1, 'rgba(168, 85, 247, 0)');

        const indigoGradient = ctxSignal.createLinearGradient(0, 0, 0, 300);
        indigoGradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        indigoGradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        const emeraldGradient = ctxRevenue.createLinearGradient(0, 0, 0, 350);
        emeraldGradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
        emeraldGradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#4B5563',
                        font: { family: 'Orbitron', size: 9, weight: 'bold' }
                    }
                }
            },
            elements: {
                point: { radius: 0, hoverRadius: 6, hitRadius: 8, hoverBorderWidth: 4, hoverBorderColor: '#fff' },
                line: { tension: 0.4 }
            }
        };

        // Node Growth Chart
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'],
                datasets: [{
                    borderColor: '#a855f7',
                    borderWidth: 4,
                    data: [320, 380, 450, 420, 580, 720, 850],
                    fill: true,
                    backgroundColor: purpleGradient
                }]
            },
            options: commonOptions
        });

        // Signal Ingress Chart
        new Chart(ctxSignal, {
            type: 'line',
            data: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '23:59'],
                datasets: [{
                    borderColor: '#6366f1',
                    borderWidth: 4,
                    data: [12, 8, 25, 42, 38, 55, 48],
                    fill: true,
                    backgroundColor: indigoGradient
                }]
            },
            options: commonOptions
        });

        // Financial Trajectory Chart
        new Chart(ctxRevenue, {
            type: 'line',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [{
                    borderColor: '#10b981',
                    borderWidth: 5,
                    data: [42000, 58000, 49000, 72000, 85000, 92000, 115000, 138000, 125000, 142000, 168000, 195000],
                    fill: true,
                    backgroundColor: emeraldGradient
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: {
                            color: '#4B5563',
                            font: { family: 'Orbitron', size: 8 },
                            callback: value => '₹' + (value/1000) + 'K'
                        }
                    },
                    x: commonOptions.scales.x
                }
            }
        });
    });
</script>
@endsection

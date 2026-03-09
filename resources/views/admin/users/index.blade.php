@extends('layouts.admin')

@section('title', 'USER MANAGEMENT')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-black orbitron text-purple-500 uppercase tracking-[0.3em]">USER ACCESS CONTROL</span>
            </div>
            <h1 class="text-4xl font-black orbitron italic uppercase tracking-tighter text-white">
                POPULATION <span class="text-purple-500 text-glow">COMMAND</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-[0.2em]">Manage Subscriber Protocols and Authentication Levels</p>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 rounded-2xl font-black orbitron text-[10px] tracking-[0.25em] uppercase flex items-center gap-3 transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-purple-900/40 italic text-white text-center">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            PROVISION NEW ACCOUNT
        </a>
    </div>

    @if (session('success'))
        <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] orbitron font-black uppercase tracking-[0.2em] text-center">
            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @php 
        $userStats = [
            ['label' => 'Total Population', 'value' => $users->count(), 'icon' => 'users', 'color' => 'purple'],
            ['label' => 'Premium Nodes', 'value' => $users->where('role', 'premium')->count(), 'icon' => 'zap', 'color' => 'emerald'],
            ['label' => 'Standard Access', 'value' => $users->where('role', 'user')->count(), 'icon' => 'user', 'color' => 'blue'],
            ['label' => 'System Officers', 'value' => $users->where('role', 'admin')->count(), 'icon' => 'shield-check', 'color' => 'amber'],
        ];
        $statColors = [
            'purple' => 'text-purple-400 border-purple-500/10',
            'emerald' => 'text-emerald-400 border-emerald-500/10',
            'blue' => 'text-blue-400 border-blue-500/10',
            'amber' => 'text-amber-400 border-amber-500/10',
        ];
        @endphp

        @foreach($userStats as $stat)
        <div class="glass-card p-6 rounded-3xl border border-white/5 relative overflow-hidden group">
            <div class="relative z-10">
                <div class="text-[9px] font-black orbitron text-gray-600 uppercase tracking-widest mb-3 leading-none">{{ $stat['label'] }}</div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center {{ $statColors[$stat['color']] }}">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <div class="text-2xl font-black text-white orbitron tracking-tight">{{ $stat['value'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Search & Filter Bar -->
    <div class="flex flex-col md:flex-row gap-6 items-center">
        <div class="relative flex-1 w-full">
            <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-600 w-4 h-4"></i>
            <input type="text" id="user-search" placeholder="SCAN NEURAL DATABASE FOR SUBJECTS..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-14 pr-6 outline-none focus:border-purple-500/50 transition-all text-[10px] font-black orbitron tracking-widest text-white placeholder:text-gray-800 uppercase">
        </div>
        <div class="flex gap-2 overflow-x-auto no-scrollbar w-full md:w-auto pb-2 md:pb-0">
            @php $roles = ['all', 'premium', 'user', 'admin']; @endphp
            @foreach($roles as $role)
            <button onclick="applyRoleFilter('{{ $role }}')" data-filter="{{ $role }}" class="filter-btn px-6 py-4 rounded-xl text-[9px] font-black orbitron uppercase tracking-[0.2em] transition-all border {{ $loop->first ? 'bg-purple-600 border-purple-500 text-white shadow-lg shadow-purple-900/40' : 'bg-white/5 border-white/10 text-gray-500 hover:text-gray-300' }} whitespace-nowrap">
                {{ $role == 'all' ? 'FULL SCAN' : $role }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse" id="users-master-table">
                <thead>
                    <tr class="border-b border-white/5 bg-white/[0.02]">
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Subscriber</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Access Protocol</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Synchronization Date</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.02]">
                    @foreach ($users as $user)
                    <tr class="user-row group hover:bg-white/[0.02] transition-colors duration-300" data-role="{{ $user->role }}" data-search="{{ strtolower($user->username . ' ' . $user->email) }}">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl border border-white/10 bg-white/5 flex items-center justify-center overflow-hidden">
                                   @if($user->profile_photo)
                                       <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                                   @else
                                       <span class="text-sm font-black orbitron text-purple-400">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                                   @endif
                                </div>
                                <div>
                                    <div class="text-sm font-black text-white orbitron tracking-tight leading-none mb-1">{{ strtoupper($user->username) }}</div>
                                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-widest italic">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @php
                                $roleStyles = [
                                    'admin'   => 'border-amber-500/30 text-amber-500 bg-amber-500/5',
                                    'premium' => 'border-purple-500/30 text-purple-500 bg-purple-500/5',
                                    'user'    => 'border-white/10 text-gray-500 bg-white/5',
                                ];
                            @endphp
                            <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black orbitron tracking-widest uppercase border {{ $roleStyles[$user->role] ?? $roleStyles['user'] }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none mb-1">{{ $user->created_at->format('d M, Y') }}</div>
                            <div class="text-[9px] font-bold text-gray-700 uppercase tracking-widest italic">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                <span class="text-[10px] font-black orbitron text-emerald-400 uppercase tracking-widest">Linked</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-gray-500 hover:text-white hover:border-purple-500/50 hover:bg-purple-500/10 transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Initiate account termination protocol?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                                        <i data-lucide="user-minus" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function applyRoleFilter(role) {
        // Update UI
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.getAttribute('data-filter') === role) {
                btn.classList.add('bg-purple-600', 'border-purple-500', 'text-white', 'shadow-lg', 'shadow-purple-900/40');
                btn.classList.remove('bg-white/5', 'border-white/10', 'text-gray-500');
            } else {
                btn.classList.remove('bg-purple-600', 'border-purple-500', 'text-white', 'shadow-lg', 'shadow-purple-900/40');
                btn.classList.add('bg-white/5', 'border-white/10', 'text-gray-500');
            }
        });

        // Filter Table
        document.querySelectorAll('.user-row').forEach(row => {
            const rowRole = row.getAttribute('data-role');
            if (role === 'all' || rowRole === role) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }

    // Search Logic
    document.getElementById('user-search').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const searchData = row.getAttribute('data-search');
            if (searchData.includes(query)) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    });
</script>
@endpush


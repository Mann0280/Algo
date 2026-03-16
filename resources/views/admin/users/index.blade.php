@extends('layouts.admin')

@section('title', 'USER MANAGEMENT')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">USER ACCOUNT MANAGEMENT</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                USER <span class="text-purple-500 text-glow">MANAGEMENT</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Manage User Access and Subscription Levels</p>
        </div>
        
        <a href="{{ route('admin.users.create') }}" class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 rounded-2xl font-semibold font-whiskey text-[10px] tracking-widest uppercase flex items-center gap-3 transition-all hover:scale-[1.02] active:scale-95 shadow-xl shadow-purple-900/40 italic text-white text-center">
            <i data-lucide="user-plus" class="w-5 h-5"></i>
            CREATE NEW USER
        </a>
    </div>

    @if (session('success'))
        <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center">
            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="stats-grid">
        @php 
        $userStats = [
            ['label' => 'Total Users', 'value' => $users->count(), 'icon' => 'users', 'color' => 'purple'],
            ['label' => 'Premium Users', 'value' => $users->where('role', 'premium')->count(), 'icon' => 'zap', 'color' => 'emerald'],
            ['label' => 'Standard Users', 'value' => $users->where('role', 'user')->count(), 'icon' => 'user', 'color' => 'blue'],
            ['label' => 'Administrators', 'value' => $users->where('role', 'admin')->count(), 'icon' => 'shield-check', 'color' => 'amber'],
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
                <div class="text-[9px] font-black font-whiskey text-gray-600 uppercase tracking-widest mb-3 leading-none">{{ $stat['label'] }}</div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center {{ $statColors[$stat['color']] }}">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                    </div>
                    <div class="text-2xl font-black text-white font-whiskey tracking-tight">{{ $stat['value'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Search & Filter Bar -->
    <div class="flex flex-col md:flex-row gap-6 items-center">
        <div class="relative flex-1 w-full">
            <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-600 w-4 h-4"></i>
            <input type="text" id="user-search" placeholder="SCAN NEURAL DATABASE FOR SUBJECTS..." class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-14 pr-6 outline-none focus:border-purple-500/50 transition-all text-[10px] font-black font-whiskey tracking-widest text-white placeholder:text-gray-800 uppercase">
        </div>
        <div class="flex gap-2 overflow-x-auto no-scrollbar w-full md:w-auto pb-2 md:pb-0">
            @php $roles = ['all', 'premium', 'user', 'admin']; @endphp
            @foreach($roles as $role)
            <button onclick="applyRoleFilter('{{ $role }}')" data-filter="{{ $role }}" class="filter-btn px-6 py-4 rounded-xl text-[9px] font-semibold font-whiskey uppercase tracking-widest transition-all border {{ $loop->first ? 'bg-purple-600 border-purple-500 text-white shadow-lg shadow-purple-900/40' : 'bg-white/5 border-white/10 text-gray-500 hover:text-gray-300' }} whitespace-nowrap">
                {{ $role == 'all' ? 'SHOW ALL' : $role }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Users Table Terminal -->
    <div class="table-wrapper">
        <div id="users-master-table" class="whiskey-table"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script>
    window.addEventListener('load', function() {
        const rawData = @json($usersJson);

        window.usersTable = new Tabulator("#users-master-table", {
            data: rawData,
            layout: "fitColumns",
            responsiveLayout: "collapse",
            pagination: "local",
            paginationSize: 10,
            placeholder: "<div class='font-whiskey text-gray-600 py-32 text-[10px] tracking-widest uppercase'>NO USERS FOUND</div>",
            columns: [
                {title: "User", field: "username", minWidth: 250, formatter: function(cell) {
                    let data = cell.getData();
                    let photo = data.profile_photo ? `<img src="${data.profile_photo}" class="w-full h-full object-cover">` : `<span class="text-[10px] font-semibold font-whiskey text-purple-400">${data.initial}</span>`;
                    return `<div class="flex items-center gap-4 py-2">
                                <div class="w-10 h-10 rounded-xl border border-white/10 bg-white/5 flex items-center justify-center overflow-hidden shrink-0">
                                    ${photo}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-white font-semibold font-whiskey text-[11px] uppercase tracking-tight leading-none mb-1">${cell.getValue()}</span>
                                    <span class="text-[9px] text-gray-500 font-bold uppercase tracking-widest italic">${data.email}</span>
                                </div>
                            </div>`;
                }},
                {title: "Role", field: "role", width: 120, hozAlign: "center", formatter: function(cell) {
                    let val = cell.getValue().toUpperCase();
                    let cls = val === 'ADMIN' ? 'border-amber-500/30 text-amber-500 bg-amber-500/5' : (val === 'PREMIUM' ? 'border-purple-500/30 text-purple-500 bg-purple-500/5' : 'border-white/10 text-gray-500 bg-white/5');
                    return `<span class="inline-flex px-3 py-1 rounded-full text-[8px] font-semibold font-whiskey tracking-widest uppercase border ${cls}">${val}</span>`;
                }},
                {title: "Expiry", field: "premium_expiry", width: 150, hozAlign: "center", formatter: function(cell) {
                    let val = cell.getValue();
                    if (!val) return `<span class="text-gray-700 text-[10px] font-whiskey font-semibold uppercase tracking-widest">---</span>`;
                    let isExpired = !cell.getData().is_premium;
                    let color = isExpired ? 'text-rose-500' : 'text-emerald-500';
                    return `<div class="flex flex-col items-center">
                                <span class="text-[10px] font-semibold font-whiskey ${color} uppercase tracking-widest">${val}</span>
                                <div class="w-4 h-[1px] bg-white/10 mt-1"></div>
                            </div>`;
                }},
                {title: "Joined", field: "created_at", width: 150, hozAlign: "center", formatter: function(cell) {
                    return `<div class="flex flex-col items-center">
                                <span class="text-[9px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest">${cell.getValue()}</span>
                            </div>`;
                }},
                {title: "Status", field: "id", width: 100, hozAlign: "center", formatter: function(cell) {
                    return `<div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                <span class="text-[9px] font-semibold font-whiskey text-emerald-400 uppercase tracking-widest">ACTIVE</span>
                            </div>`;
                }},
                {title: "Actions", field: "id", hozAlign: "right", headerHozAlign: "right", width: 120, formatter: function(cell) {
                    let data = cell.getData();
                    return `<div class="flex justify-end gap-2 py-1">
                                <a href="${data.edit_url}" class="action-btn edit-btn">
                                    <i class="fas fa-pen text-[13px]"></i>
                                </a>
                                <form action="${data.delete_url}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn">
                                        <i class="fas fa-trash text-[13px]"></i>
                                    </button>
                                </form>
                            </div>`;
                }, cellClick: function(e, cell) { e.stopPropagation(); }}
            ],
            renderComplete: function() {
                if (typeof initIcons !== 'undefined') initIcons();
            }
        });

        // Search Logic
        document.getElementById('user-search').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            window.usersTable.setFilter([
                {field: "username", type: "like", value: query},
            ], "or", [
                {field: "email", type: "like", value: query}
            ]);
        });
    });

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
        if (role === 'all') {
            window.usersTable.clearFilter();
        } else {
            window.usersTable.setFilter("role", "=", role);
        }
    }
</script>
@endpush


@extends('layouts.admin')

@section('title', 'User Control Center')

@push('styles')
<link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator_simple.min.css" rel="stylesheet">
<link href="{{ asset('css/tabulator-dark.css') }}" rel="stylesheet">
<style>
    /* Page-specific tweaks */
    .stat-card {
        background: #0c0618;
        border: 1px solid rgba(124,58,237,0.06);
        border-radius: 14px;
        padding: 20px 24px;
        transition: all 0.25s ease;
    }
    .stat-card:hover {
        border-color: rgba(124,58,237,0.15);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }
    .search-input {
        background: #0c0618;
        border: 1px solid rgba(124,58,237,0.08);
        border-radius: 12px;
        color: #e2e8f0;
        font-size: 13px;
        padding: 12px 16px 12px 44px;
        width: 100%;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .search-input::placeholder { color: #374151; }
    .search-input:focus {
        border-color: rgba(124,58,237,0.3);
        box-shadow: 0 0 0 3px rgba(124,58,237,0.06);
    }
    .filter-btn {
        padding: 10px 18px;
        border-radius: 10px;
        font-family: 'Orbitron', monospace;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    .filter-btn.active {
        background: #7c3aed;
        color: #ffffff;
        border-color: #7c3aed;
        box-shadow: 0 0 16px rgba(124,58,237,0.25);
    }
    .filter-btn:not(.active) {
        background: rgba(124,58,237,0.04);
        color: #6b7280;
        border-color: rgba(124,58,237,0.06);
    }
    .filter-btn:not(.active):hover {
        background: rgba(124,58,237,0.08);
        color: #d1d5db;
        border-color: rgba(124,58,237,0.12);
    }
</style>
@endpush

@section('content')
<div class="space-y-7 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black orbitron italic uppercase tracking-tighter text-white">
                USER <span class="text-purple-500" style="text-shadow: 0 0 20px rgba(124,58,237,0.4)">MANAGEMENT</span>
            </h1>
            <p class="text-gray-500 text-xs font-semibold mt-1 uppercase tracking-[0.2em]">Access Control & Subscriber Protocols</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 bg-[#7c3aed] hover:bg-[#6d28d9] text-white px-7 py-3.5 rounded-xl font-bold text-[10px] orbitron tracking-widest uppercase transition-all shadow-[0_4px_20px_rgba(124,58,237,0.25)] hover:shadow-[0_4px_28px_rgba(124,58,237,0.4)] hover:-translate-y-0.5">
            <i data-lucide="user-plus" class="w-4 h-4"></i> New User
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flex items-center gap-3 px-5 py-3.5 rounded-xl border border-emerald-500/15 bg-emerald-500/[0.06]">
        <i data-lucide="check-circle" class="w-4 h-4 text-emerald-400 shrink-0"></i>
        <span class="text-emerald-400 text-xs font-bold orbitron uppercase tracking-[0.15em]">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] mb-1.5">Total Users</div>
            <div class="text-2xl font-black orbitron text-white tracking-tight">{{ $users->count() }}</div>
        </div>
        <div class="stat-card" style="border-color: rgba(124,58,237,0.1)">
            <div class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] mb-1.5">Premium</div>
            <div class="text-2xl font-black orbitron text-purple-400 tracking-tight">{{ $users->where('role', 'premium')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] mb-1.5">Free Users</div>
            <div class="text-2xl font-black orbitron text-gray-300 tracking-tight">{{ $users->where('role', 'user')->count() }}</div>
        </div>
        <div class="stat-card" style="border-color: rgba(245,158,11,0.08)">
            <div class="text-[9px] font-bold orbitron text-gray-500 uppercase tracking-[0.2em] mb-1.5">Admins</div>
            <div class="text-2xl font-black orbitron text-amber-400 tracking-tight">{{ $users->where('role', 'admin')->count() }}</div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
        <div class="relative flex-1 max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="global-search" placeholder="Search users..." class="search-input">
        </div>
        <div class="flex gap-2 flex-wrap">
            <button onclick="filterRole('all')" class="filter-btn active" data-role="all">All</button>
            <button onclick="filterRole('premium')" class="filter-btn" data-role="premium">Premium</button>
            <button onclick="filterRole('user')" class="filter-btn" data-role="user">Free</button>
            <button onclick="filterRole('admin')" class="filter-btn" data-role="admin">Admin</button>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <div id="users-table"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/tabulator-tables@6.3.1/dist/js/tabulator.min.js"></script>
<script src="{{ asset('js/tabulator-global.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const usersData = @json($usersJson);

    const table = new Tabulator("#users-table", {
        ...TABULATOR_BASE_CONFIG,
        data: usersData,
        placeholder: "<div style='padding:48px 20px;text-align:center;color:#374151;font-family:Orbitron,monospace;font-size:10px;letter-spacing:0.2em;text-transform:uppercase;'>No users found in the neural database</div>",
        columns: [
            {
                title: "User",
                field: "username",
                widthGrow: 3,
                minWidth: 220,
                sorter: "string",
                resizable: false,
                headerFilter: false,
                formatter: function(cell) {
                    const d = cell.getRow().getData();
                    const avatar = d.profile_photo
                        ? `<img src="${d.profile_photo}" style="width:100%;height:100%;object-fit:cover;">`
                        : `<span style="font-family:Orbitron,monospace;font-size:12px;font-weight:900;color:#a855f7;">${d.initial}</span>`;
                    return `<div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,rgba(99,102,241,0.12),rgba(147,51,234,0.12));border:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                            ${avatar}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-weight:700;color:#f1f5f9;font-size:13px;text-transform:uppercase;letter-spacing:-0.01em;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${d.username}</div>
                            <div style="font-size:11px;color:#4b5563;margin-top:1px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${d.email}</div>
                        </div>
                    </div>`;
                }
            },
            {
                title: "Role",
                field: "role",
                width: 150,
                hozAlign: "center",
                sorter: "string",
                headerFilter: false,
                formatter: function(cell) {
                    const role = cell.getValue();
                    const styles = {
                        admin:   'background:rgba(245,158,11,0.08);color:#fbbf24;border:1px solid rgba(245,158,11,0.15);',
                        premium: 'background:rgba(124,58,237,0.08);color:#a78bfa;border:1px solid rgba(124,58,237,0.15);',
                        user:    'background:rgba(100,116,139,0.08);color:#94a3b8;border:1px solid rgba(100,116,139,0.1);',
                    };
                    return `<span style="display:inline-block;padding:5px 14px;border-radius:8px;font-family:Orbitron,monospace;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:0.14em;${styles[role] || styles.user}">${role}</span>`;
                }
            },
            {
                title: "Joined",
                field: "created_at",
                width: 150,
                hozAlign: "center",
                sorter: "string",
                formatter: function(cell) {
                    return `<span style="font-size:12px;color:#6b7280;font-weight:500;">${cell.getValue()}</span>`;
                }
            },
            {
                title: "Status",
                field: "id",
                width: 130,
                hozAlign: "center",
                headerSort: false,
                formatter: function() {
                    return `<div style="display:inline-flex;align-items:center;gap:6px;padding:4px 12px;border-radius:20px;background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.1);">
                        <span style="width:5px;height:5px;border-radius:50%;background:#10b981;box-shadow:0 0 8px rgba(16,185,129,0.6);"></span>
                        <span style="font-family:Orbitron,monospace;font-size:8px;font-weight:700;color:#34d399;text-transform:uppercase;letter-spacing:0.12em;">Active</span>
                    </div>`;
                }
            },
            {
                title: "Actions",
                field: "id",
                width: 120,
                headerSort: false,
                hozAlign: "center",
                formatter: function(cell) {
                    const d = cell.getRow().getData();
                    return `<div style="display:flex;gap:6px;justify-content:center;">
                        <a href="${d.edit_url}" title="Edit" style="width:32px;height:32px;border-radius:8px;background:rgba(124,58,237,0.04);border:1px solid rgba(124,58,237,0.08);color:#6b7280;display:inline-flex;align-items:center;justify-content:center;transition:all 0.15s;" onmouseover="this.style.color='#a78bfa';this.style.borderColor='rgba(124,58,237,0.25)';this.style.background='rgba(124,58,237,0.08)'" onmouseout="this.style.color='#6b7280';this.style.borderColor='rgba(124,58,237,0.08)';this.style.background='rgba(124,58,237,0.04)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                        </a>
                        <button onclick="deleteUser(${d.id},'${d.delete_url}')" title="Delete" style="width:32px;height:32px;border-radius:8px;background:rgba(239,68,68,0.04);border:1px solid rgba(239,68,68,0.08);color:#6b7280;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;" onmouseover="this.style.color='#f87171';this.style.borderColor='rgba(239,68,68,0.25)';this.style.background='rgba(239,68,68,0.08)'" onmouseout="this.style.color='#6b7280';this.style.borderColor='rgba(239,68,68,0.08)';this.style.background='rgba(239,68,68,0.04)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                    </div>`;
                }
            },
        ],
    });

    // ── Search ──
    document.getElementById('global-search').addEventListener('input', function() {
        const val = this.value.toLowerCase();
        if (!val) { table.clearFilter(); return; }
        table.setFilter([
            [
                {field: "username", type: "like", value: val},
                {field: "email", type: "like", value: val},
                {field: "role", type: "like", value: val},
            ]
        ]);
    });

    // ── Role Filter (exposed globally for onclick handlers) ──
    window.filterRole = function(role) {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.toggle('active', b.dataset.role === role);
        });
        role === 'all' ? table.clearFilter() : table.setFilter("role", "=", role);
    };

    // ── Delete (exposed globally for onclick handlers) ──
    window.deleteUser = function(id, url) {
        if (!confirm('Initiate user deletion protocol?')) return;
        const f = document.createElement('form');
        f.method = 'POST';
        f.action = url;
        f.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(f);
        f.submit();
    };
});
</script>
@endpush


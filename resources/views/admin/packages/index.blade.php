@extends('layouts.admin')

@section('title', 'Pricing Plans')

@section('content')
<div class="space-y-12 max-w-[1200px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">PLANS & PRICING</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                PRICING <span class="text-purple-500 text-glow">PLANS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Manage Subscription Plans and User Tiers</p>
        </div>
        
        <a href="{{ route('admin.premium-packages.create') }}" class="group relative px-8 py-4 bg-purple-600 rounded-2xl overflow-hidden shadow-[0_0_30px_rgba(147,51,234,0.3)]">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-600"></div>
            <div class="relative flex items-center gap-3">
                <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                <span class="text-[10px] font-semibold font-whiskey text-white uppercase tracking-widest">Create New Plan</span>
            </div>
        </a>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Packages Container -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Plan Name</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Price</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Duration</th>
                        <th class="px-10 py-8 text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-10 py-8 text-right text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($packages as $package)
                    <tr class="group hover:bg-white/[0.01] transition-all duration-500">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500/10 to-indigo-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover:scale-110 transition-transform duration-500 shadow-[0_0_20px_rgba(147,51,234,0.1)]">
                                    <i data-lucide="package" class="w-6 h-6"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black font-whiskey text-white italic group-hover:text-purple-400 transition-colors uppercase tracking-tight">{{ $package->name }}</span>
                                    <span class="text-[9px] font-bold text-gray-600 mt-1 uppercase tracking-widest max-w-[200px] truncate">{{ $package->description }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-lg font-black font-whiskey text-white italic">₹{{ number_format($package->price, 0) }}</span>
                                <span class="text-[9px] font-bold text-gray-700 uppercase tracking-widest mt-0.5">Total Price</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-700"></i>
                                <span class="text-[10px] font-semibold font-whiskey text-gray-400 uppercase tracking-widest">{{ $package->duration_days }} Days</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $package->is_active ? 'bg-emerald-500 shadow-[0_0_10px_#10b981]' : 'bg-rose-500 shadow-[0_0_10px_#f43f5e]' }}"></span>
                                <span class="text-[10px] font-semibold font-whiskey {{ $package->is_active ? 'text-emerald-400' : 'text-rose-400' }} uppercase tracking-widest">
                                    {{ $package->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex justify-end gap-2 text-right">
                                <a href="{{ route('admin.premium-packages.edit', $package) }}" class="action-btn edit-btn ml-auto">
                                    <i class="fas fa-pen text-[13px]"></i>
                                </a>
                                <form action="{{ route('admin.premium-packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn">
                                        <i class="fas fa-trash text-[13px]"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center gap-6 opacity-20">
                                <div class="w-20 h-20 rounded-[2.5rem] bg-white/5 border border-white/10 flex items-center justify-center">
                                    <i data-lucide="package-search" class="w-10 h-10 text-white"></i>
                                </div>
                                <span class="text-[10px] font-semibold font-whiskey uppercase tracking-widest text-white">No Pricing Plans Found</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

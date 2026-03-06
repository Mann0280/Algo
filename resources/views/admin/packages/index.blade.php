@extends('layouts.admin')

@section('title', 'Neural Packages')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                PACKAGE <span class="text-purple-500 text-glow">PROTOCOLS</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest leading-none">Subscription management matrix</p>
        </div>
        <a href="{{ route('admin.premium-packages.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-2xl font-bold text-xs orbitron tracking-widest uppercase transition-all flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Initialize New Package
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-500 text-xs font-bold orbitron uppercase tracking-widest">
        <i data-lucide="check-circle" class="w-4 h-4"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white/5">
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Package Name</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Price (INR)</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Duration</th>
                    <th class="px-8 py-5 text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-8 py-5 text-right text-[10px] font-black orbitron text-gray-400 uppercase tracking-[0.2em]">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($packages as $package)
                <tr class="hover:bg-white/[0.02] transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-black orbitron text-white italic group-hover:text-purple-400 transition-all uppercase tracking-tight">{{ $package->name }}</span>
                            <span class="text-[9px] text-gray-500 mt-1 uppercase tracking-widest truncate max-w-xs">{{ $package->description }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 font-bold text-white orbitron text-sm italic">
                        ₹{{ number_format($package->price, 0) }}
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">{{ $package->duration_days }} Days</span>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-4 py-1 rounded-full text-[9px] font-black orbitron uppercase tracking-[0.2em] {{ $package->is_active ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-500 border border-rose-500/20' }}">
                            {{ $package->is_active ? 'Active' : 'Offline' }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.premium-packages.edit', $package) }}" class="p-2.5 rounded-xl bg-white/5 border border-white/5 text-gray-500 hover:text-white hover:bg-purple-600/20 hover:border-purple-500/30 transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('admin.premium-packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Deconstruct this package protocol?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 rounded-xl bg-white/5 border border-white/5 text-gray-500 hover:text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/20 transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center gap-4 opacity-20">
                            <i data-lucide="package-search" class="w-12 h-12"></i>
                            <span class="text-[10px] font-black orbitron uppercase tracking-[0.3em]">No Dynamic Protocols Found</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

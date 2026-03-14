@extends('layouts.admin')

@section('title', 'CONTACT MESSAGES')

@section('content')
<div class="space-y-12 max-w-[1600px] mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">USER COMMUNICATION ARCHIVE</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                CONTACT <span class="text-purple-500 text-glow">MESSAGES</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Review and manage incoming community transmissions</p>
        </div>
    </div>

    @if (session('success'))
        <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center">
            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Messages Table -->
    <div class="glass-panel border-white/5 rounded-[2.5rem] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5">
                        <th class="px-8 py-6 text-[10px] font-black font-whiskey text-purple-500 uppercase tracking-widest">Subject / Date</th>
                        <th class="px-8 py-6 text-[10px] font-black font-whiskey text-purple-500 uppercase tracking-widest">From</th>
                        <th class="px-8 py-6 text-[10px] font-black font-whiskey text-purple-500 uppercase tracking-widest">Message Content</th>
                        <th class="px-8 py-6 text-[10px] font-black font-whiskey text-purple-500 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($messages as $msg)
                        <tr class="group hover:bg-white/[0.01] transition-all">
                            <td class="px-8 py-6">
                                <div class="text-white font-bold text-sm mb-1 uppercase tracking-tight">{{ $msg->subject }}</div>
                                <div class="text-[9px] text-gray-600 font-bold uppercase tracking-widest">{{ $msg->created_at->format('d M Y | H:i') }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-white font-bold text-sm mb-1">{{ $msg->name }}</div>
                                <div class="text-[10px] text-purple-400 font-medium lowercase tracking-tighter">{{ $msg->email }}</div>
                            </td>
                            <td class="px-8 py-6 max-w-md">
                                <p class="text-gray-400 text-xs leading-relaxed line-clamp-3 group-hover:line-clamp-none transition-all duration-500">
                                    {{ $msg->message }}
                                </p>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Purge this transmission from archives?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all ml-auto">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-20">
                                    <i data-lucide="mail-search" class="w-16 h-16 text-white"></i>
                                    <div class="text-[10px] font-black font-whiskey text-white uppercase tracking-[0.3em]">No incoming transmissions detected</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($messages->hasPages())
            <div class="px-8 py-6 border-t border-white/5 bg-white/[0.01]">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

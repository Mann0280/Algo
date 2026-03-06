@extends('layouts.admin')

@section('title', 'Neural Initialization | New User')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="p-3 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black orbitron italic uppercase tracking-tighter text-white">
                INITIALIZE <span class="text-purple-500 text-glow">NEW USER</span>
            </h1>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-widest mt-1">Deploying New Identity Protocol</p>
        </div>
    </div>

    @if($errors->any())
    <div class="glass-panel p-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 space-y-2">
        @foreach($errors->all() as $error)
        <div class="text-rose-500 text-[10px] font-bold orbitron uppercase tracking-widest flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $error }}
        </div>
        @endforeach
    </div>
    @endif

    <!-- Form -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <form action="{{ route('admin.users.store') }}" method="POST" class="p-10 space-y-8">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-3 px-1">Protocol Identifier (Username)</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="text" name="username" value="{{ old('username') }}" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all"
                               placeholder="e.g. neuro_trader">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-3 px-1">Neural Relay (Email)</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all"
                               placeholder="user@algotrade.ai">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-3 px-1">Access Tier (Role)</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['user' => 'Standard', 'premium' => 'Elite', 'admin' => 'Control'] as $key => $label)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="{{ $key }}" class="peer hidden" {{ old('role', 'user') === $key ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border border-white/10 bg-white/5 text-center transition-all peer-checked:bg-purple-600 peer-checked:border-purple-500 peer-checked:text-white group-hover:border-white/20">
                                <span class="text-[9px] font-black orbitron uppercase tracking-widest">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-3 px-1">Security Key</label>
                        <input type="password" name="password" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest mb-3 px-1">Confirm Key</label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black orbitron uppercase tracking-widest text-xs hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-500/20 italic">
                Authorize Deployment Sequence
            </button>
        </form>
    </div>
</div>
@endsection

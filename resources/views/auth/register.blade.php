@extends('layouts.app')

@section('title', 'Initialize Terminal | AlgoTrade AI')

@section('content')
<main class="min-h-screen flex items-center justify-center p-6 relative z-10">
    <div class="w-full max-w-md glass-panel p-10 rounded-[2.5rem] border border-white/10 relative overflow-hidden group">
        <!-- Logo -->
        <div class="text-center mb-10 flex flex-col items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20 mb-4">
                <i data-lucide="zap" class="w-7 h-7 text-white fill-white"></i>
            </div>
            <div class="orbitron font-black text-2xl italic tracking-tighter">
                <span class="text-white">ALGO</span><span class="text-purple-500">TRADE</span> AI
            </div>
            <p class="text-gray-500 text-[10px] font-bold orbitron uppercase tracking-[0.2em] mt-2">Neural Enrollment</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 text-[10px] font-bold p-3 rounded-xl mb-6 text-center orbitron uppercase tracking-widest animate-shake">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-[10px] font-bold text-gray-500 orbitron uppercase tracking-widest mb-2 px-1">Choose Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="trader_nexus" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 transition-all text-sm font-medium text-white placeholder:text-gray-700">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 orbitron uppercase tracking-widest mb-2 px-1">Email Frequency</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@domain.com" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 transition-all text-sm font-medium text-white placeholder:text-gray-700">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-500 orbitron uppercase tracking-widest mb-2 px-1">Signal Access Phrase</label>
                <input type="password" name="password" placeholder="Create Phrase" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 transition-all text-sm font-medium text-white placeholder:text-gray-700 mb-3">
                <input type="password" name="password_confirmation" placeholder="Confirm Phrase" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 transition-all text-sm font-medium text-white placeholder:text-gray-700">
            </div>

            <button type="submit" class="w-full py-4 rounded-xl bg-purple-600 text-white font-black orbitron text-xs tracking-widest hover:bg-purple-500 hover:shadow-[0_0_20px_rgba(147,51,234,0.4)] transition-all transform active:scale-95 uppercase">
                Initialize Connection
            </button>
        </form>

        <p class="text-center mt-8 text-xs text-gray-400">
            Already have a terminal? <a href="{{ route('login') }}" class="text-purple-400 font-bold hover:underline">Verify Identity</a>
        </p>

        <!-- Dynamic Ambient Light -->
        <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-purple-600/10 blur-[60px] rounded-full group-hover:bg-purple-600/20 transition-all"></div>
    </div>
</main>

<style>
    @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
    .animate-shake { animation: shake 0.3s ease-in-out; }
</style>
@endsection

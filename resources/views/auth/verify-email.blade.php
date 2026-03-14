@extends('layouts.app')

@section('title', 'Verify Your Protocol')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 relative overflow-hidden bg-[#05020a]">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-purple-900/20 blur-[120px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-900/20 blur-[120px] rounded-full animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="w-full max-w-xl relative z-10 animate-in fade-in slide-in-from-bottom-8 duration-700">
        <div class="glass-card p-12 rounded-[3rem] border border-white/10 shadow-[0_0_100px_rgba(147,51,234,0.1)] text-center space-y-10">
            
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group">
                    <div class="absolute inset-0 bg-purple-500/20 blur-2xl rounded-full group-hover:bg-purple-500/40 transition-all duration-500"></div>
                    <i data-lucide="mail" class="w-10 h-10 text-purple-500 relative z-10"></i>
                </div>
                
                <h1 class="font-whiskey text-3xl font-black text-white italic uppercase tracking-tighter mb-4">
                    Identity <span class="text-purple-500 text-glow">Verification</span>
                </h1>
                
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                    <span class="text-[9px] font-black font-whiskey text-purple-500 uppercase tracking-[0.4em]">Protocol Authorization Required</span>
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                </div>
            </div>

            <div class="space-y-6">
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                    A celestial handshake has been sent to your transmission relay. Please verify your email address to initialize your neural connection.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black font-whiskey text-emerald-400 uppercase tracking-widest">
                            New transmission link deployed successfully!
                        </p>
                    </div>
                @endif
            </div>

            <div class="space-y-6 pt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black font-whiskey uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-900/40 italic flex items-center justify-center gap-3">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        Resend Verification Protocol
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[9px] font-black font-whiskey text-gray-600 hover:text-white uppercase tracking-[0.4em] transition-all">
                        Terminate Session
                    </button>
                </form>
            </div>
            
            <div class="pt-6 border-t border-white/5">
                <p class="text-[8px] font-black font-whiskey text-gray-700 uppercase tracking-[0.3em]">
                    Algorithmic Security Layer v4.0 Active
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

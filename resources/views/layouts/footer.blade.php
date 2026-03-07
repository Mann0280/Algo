<footer class="py-20 border-t border-white/5 bg-black/40 relative z-10 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                </div>
                <div class="orbitron font-black text-xl italic tracking-tighter text-white">
                    EMPEROR STOCK <span class="text-purple-500">PREDICTOR</span>
                </div>
            </a>
            
            <div class="flex justify-center flex-wrap gap-10 text-[10px] font-bold orbitron text-slate-500 tracking-widest">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors uppercase">Home</a>
                @auth
                {{-- <a href="{{ url('/terminal/free') }}" class="hover:text-white transition-colors uppercase">Signals</a> --}}
                {{-- <a href="{{ url('/terminal') }}" class="hover:text-white transition-colors uppercase">Dashboard</a> --}}
                @else
                    <a href="{{ url('/login') }}" class="hover:text-white transition-colors uppercase">Login</a>
                @endauth
                <a href="{{ url('/about') }}" class="hover:text-white transition-colors uppercase">About</a>
                <a href="{{ url('/contact') }}" class="hover:text-white transition-colors uppercase">Contact</a>
            </div>

            <div class="flex gap-6">
                <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-purple-500 transition-all"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-purple-500 transition-all"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                <a href="#" class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:border-purple-500 transition-all"><i data-lucide="send" class="w-4 h-4"></i></a>
            </div>
        </div>

        <div class="text-center">
            <p class="text-[9px] font-bold orbitron text-slate-700 tracking-[0.4em] uppercase mb-4">Neural Interface v3.2.0 • Secured by AES-256</p>
            <p class="text-slate-600 text-[10px] font-medium">&copy; {{ date('Y') }} Emperor Stock Predictor. All rights reserved. Registered Digital Asset Protocol.</p>
        </div>
    </div>
</footer>

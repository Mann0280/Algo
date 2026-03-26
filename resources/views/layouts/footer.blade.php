<footer class="pt-20 pb-10 border-t border-white/5 bg-black/40 relative z-10 overflow-hidden">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand Column -->
            <div class="col-span-1 md:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center shadow-[0_0_20px_rgba(147,51,234,0.3)]">
                        <i data-lucide="zap" class="w-6 h-6 text-white fill-white transition-transform group-hover:scale-110"></i>
                    </div>
                    <div class="font-professional text-xl text-white tracking-tight">
                        EMPEROR <span class="text-vibrant">PREDICTOR</span>
                    </div>
                </a>
                <p class="text-slate-400 text-xs leading-relaxed mb-6 font-medium">
                    Premier trading systems for global market forecasting and predictive asset analysis. Registered digital asset platform.
                </p>
                <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg w-fit">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">System Active</span>
                </div>
            </div>

            <!-- Products Column -->
            <div class="flex flex-col gap-4">
                <h4 class="text-white text-[11px] font-black uppercase tracking-[0.2em] mb-2">Platform</h4>
                <div class="flex flex-col gap-3 text-[10px] font-bold text-slate-500 tracking-widest">
                    <a href="{{ url('/') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Home</a>
                    <a href="{{ url('/signals/past') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Past Signals</a>
                    <a href="{{ url('/pricing') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Plan Tiers</a>
                    @auth
                        <a href="{{ url('/account/dashboard') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Dashboard</a>
                    @else
                        <a href="{{ url('/login') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Login</a>
                    @endauth
                </div>
            </div>

            <!-- Support Column -->
            <div class="flex flex-col gap-4">
                <h4 class="text-white text-[11px] font-black uppercase tracking-[0.2em] mb-2">Company</h4>
                <div class="flex flex-col gap-3 text-[10px] font-bold text-slate-500 tracking-widest">
                    <a href="{{ url('/about') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">About Us</a>
                    <a href="{{ url('/contact') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Contact Support</a>
                    @auth
                        <a href="{{ url('/account/history') }}" class="hover:text-white transition-all duration-300 transform hover:translate-x-1 uppercase">Account History</a>
                    @endauth
                </div>
            </div>

            <!-- Security Column -->
            <div class="flex flex-col gap-4 text-right md:text-left">
                <h4 class="text-white text-[11px] font-black uppercase tracking-[0.2em] mb-2">Infrastructure</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 bg-white/[0.03] border border-white/10 p-3 rounded-xl">
                        <i data-lucide="shield-check" class="w-5 h-5 text-purple-500"></i>
                        <div>
                            <div class="text-[9px] text-white font-bold uppercase">AES-256 SECURED</div>
                            <div class="text-[8px] text-slate-500 font-medium uppercase">Military Grade Encryption</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/[0.03] border border-white/10 p-3 rounded-xl">
                        <i data-lucide="globe" class="w-5 h-5 text-blue-500"></i>
                        <div>
                            <div class="text-[9px] text-white font-bold uppercase">Global CDN</div>
                            <div class="text-[8px] text-slate-500 font-medium uppercase">Distributed Low-Latency</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-600 text-[10px] font-medium">&copy; {{ date('Y') }} Emperor Stock Predictor. All rights reserved.</p>
            <div class="flex gap-8 text-[9px] font-bold text-slate-700 tracking-[0.2em] uppercase">
                <span>Secured by AWS Cloud</span>
                <span>Algo v3.2.0</span>
            </div>
        </div>
    </div>
</footer>

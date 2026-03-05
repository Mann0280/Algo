<nav class="fixed top-0 left-0 w-full z-[100] px-6 py-6 transition-all duration-500" id="main-nav">
    <div class="container mx-auto">
        <div class="glass-panel px-8 py-4 rounded-[2rem] border border-white/10 flex justify-between items-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 relative z-10 transition-transform hover:scale-105">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i data-lucide="zap" class="w-5 h-5 text-white fill-white"></i>
                </div>
                <div class="orbitron font-black text-lg italic tracking-tighter">
                    <span class="text-white">ALGO</span><span class="text-purple-500">TRADE</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden lg:flex items-center gap-8 relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-white hover:text-purple-400 transition-colors tracking-wider uppercase">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i> Home
                </a>
                <a href="{{ url('/about') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="info" class="w-3.5 h-3.5"></i> About Us
                </a>
                <a href="{{ url('/contact') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="mail" class="w-3.5 h-3.5"></i> Contact Us
                </a>
                <a href="{{ url('/signals') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="activity" class="w-3.5 h-3.5"></i> Signals
                </a>
                {{-- <a href="{{ url('/terminal/free') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i> Free Signals
                </a> --}}
                {{-- <a href="{{ url('/terminal/premium') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> Premium Tips
                </a> --}}
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3 relative z-10">
                @auth
                    <!-- Terminal Access -->
                    @if(Auth::user()->role === 'premium' || Auth::user()->role === 'admin')
                    {{-- <a href="{{ url('/terminal/premium') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-900/40 border border-purple-500/30 text-purple-200 font-bold orbitron text-[10px] tracking-wider hover:bg-purple-800/40 transition-all">
                        <i data-lucide="crown" class="w-3.5 h-3.5 text-amber-500"></i> Premium Terminal
                    </a> --}}
                    @else
                    <a href="{{ url('/pricing') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-500 font-bold orbitron text-[10px] tracking-wider hover:bg-amber-500/20 transition-all group">
                        <i data-lucide="zap" class="w-3.5 h-3.5 group-hover:animate-pulse"></i> Upgrade
                    </a>
                    @endif

                    <!-- Notification Bell -->
                    <button class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-amber-500 hover:bg-white/10 transition-all relative group">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-amber-500 rounded-full shadow-[0_0_10px_#fbbf24]"></span>
                    </button>

                    <!-- User Profile Badge -->
                    <a href="{{ url('/account/profile') }}" class="flex items-center gap-3 px-1 pl-1 pr-4 py-1 rounded-full border {{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'border-amber-500/50 bg-gradient-to-r from-amber-600/20 to-transparent hover:from-amber-600/30 hover:border-amber-500/80 hover:shadow-[0_0_20px_rgba(245,158,11,0.1)]' : 'border-white/10 bg-white/5 hover:bg-white/10 hover:border-purple-500/40 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)]' }} transition-all duration-300 group hover:scale-[1.02]">
                        <div class="w-8 h-8 rounded-full {{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'bg-amber-500 text-black' : 'bg-purple-600 text-white shadow-lg shadow-purple-500/20' }} flex items-center justify-center transition-transform group-hover:scale-105 overflow-hidden relative">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : '' }}" 
                                 alt="User" 
                                 class="w-full h-full object-cover global-user-photo {{ !Auth::user()->profile_photo ? 'hidden' : '' }}">
                                 
                            <span class="global-user-initial flex items-center justify-center w-full h-full {{ Auth::user()->profile_photo ? 'hidden' : '' }}">
                                <i data-lucide="{{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'crown' : 'user' }}" 
                                   class="w-4 h-4 {{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'fill-black' : '' }}"></i>
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black orbitron {{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'text-amber-500' : 'text-purple-400' }} leading-none tracking-widest uppercase transition-colors group-hover:text-white">
                                {{ (Auth::user()->role === 'premium' || Auth::user()->role === 'admin') ? 'Premium Member' : 'Standard Account' }}
                            </span>
                            <span class="text-[11px] font-bold orbitron text-white leading-tight uppercase global-username">{{ Auth::user()->username }}</span>
                        </div>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-xl bg-rose-950/30 border border-rose-500/20 flex items-center justify-center text-rose-500 hover:bg-rose-900/40 hover:border-rose-500/40 transition-all shadow-lg shadow-rose-900/10">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="text-[10px] font-bold orbitron text-white hover:text-purple-400 transition-colors tracking-widest uppercase mr-4">Login</a>
                    <a href="{{ url('/register') }}" class="px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black orbitron text-[10px] tracking-widest hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.4)] transition-all uppercase">Initialize</a>
                @endauth
                
                <button class="lg:hidden w-10 h-10 rounded-xl glass-panel flex items-center justify-center border border-white/10" id="mobile-menu-btn">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
        </div>
    </div>
</nav>

<script>
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            nav.classList.add('py-4');
            nav.querySelector('.glass-panel').classList.add('shadow-2xl', 'bg-black/60');
        } else {
            nav.classList.remove('py-4');
            nav.querySelector('.glass-panel').classList.remove('shadow-2xl', 'bg-black/60');
        }
    });
</script>

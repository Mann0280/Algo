<nav class="fixed top-0 left-0 w-full z-[100] px-3 sm:px-6 py-2 sm:py-3 transition-all duration-500" id="main-nav">
    <div class="container mx-auto">
        <div class="glass-panel px-4 py-2 sm:px-8 sm:py-2.5 rounded-xl sm:rounded-[2rem] border border-white/10 flex justify-between items-center relative group">
            <div class="absolute inset-0 rounded-xl sm:rounded-[2rem] overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            </div>
            
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 relative z-10 transition-transform hover:scale-105">
                <div class="w-9 h-9 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i data-lucide="zap" class="w-5 h-5 text-white fill-white"></i>
                </div>
                <div class="flex flex-col leading-none font-professional">
                    <span class="text-[11px] font-bold text-white tracking-[0.2em] opacity-90">EMPEROR STOCK</span>
                    <span class="text-[16px] font-bold text-purple-500 tracking-tighter mt-0.5">PREDICTOR</span>
                </div>
            </a>

            <!-- Navigation Links (Desktop only) -->
            <div class="hidden lg:flex items-center gap-8 relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-white transition-colors tracking-[0.1em] uppercase">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i> Home
                </a>

                <a href="{{ url('/about') }}" class="flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-white transition-colors tracking-[0.1em] uppercase">
                    <i data-lucide="info" class="w-3.5 h-3.5"></i> About Us
                </a>
                <a href="{{ url('/contact') }}" class="flex items-center gap-2 text-[11px] font-bold text-gray-400 hover:text-white transition-colors tracking-[0.1em] uppercase">
                    <i data-lucide="mail" class="w-3.5 h-3.5"></i> Contact Us
                </a>
                <a href="{{ url('/signals') }}" class="flex items-center gap-2 text-[11px] font-bold {{ request()->is('signals') ? 'text-white' : 'text-gray-400' }} hover:text-white transition-colors tracking-[0.1em] uppercase">
                    <i data-lucide="activity" class="w-3.5 h-3.5"></i> Signals
                </a>
                <a href="{{ route('signals.past') }}" class="flex items-center gap-2 text-[11px] font-bold {{ request()->is('signals/past') ? 'text-white' : 'text-gray-400' }} hover:text-white transition-colors tracking-[0.1em] uppercase">
                    <i data-lucide="history" class="w-3.5 h-3.5"></i> Past Signals
                </a>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-2 sm:gap-3 relative z-10">
                @php
                    $user = Auth::user() ?? Auth::guard('admin')->user();
                    $isAdmin = Auth::guard('admin')->check() || ($user && $user->role === 'admin');
                    $isPremium = ($user && ($user->role === 'premium' || $isAdmin));
                @endphp

                @auth('web')
                @elseauth('admin')
                @endauth
                
                @if($user)
                    <!-- Desktop-only actions: hidden on mobile -->
                    <div class="hidden lg:flex items-center gap-3">
                        <!-- Terminal Access -->
                        @if($isPremium)
                        <a href="{{ url('/signals') }}" class="flex items-center gap-3 px-5 py-2 rounded-2xl bg-purple-950/40 border border-purple-500/30 text-white transition-all hover:bg-purple-900/40 hover:border-purple-500/50 shadow-lg shadow-purple-900/10 group">
                            <i data-lucide="crown" class="w-4 h-4 text-purple-400 group-hover:scale-110 transition-transform"></i>
                            <div class="flex flex-col items-start leading-none font-professional">
                                <span class="text-[8px] font-bold text-purple-200/60 uppercase tracking-[0.15em] mb-0.5">Premium</span>
                                <span class="text-[11px] font-bold text-white uppercase tracking-wide">Terminal</span>
                            </div>
                        </a>
                        @else
                        <a href="{{ url('/pricing') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 border border-white/30 text-white font-bold text-[11px] tracking-widest hover:bg-white/20 transition-all uppercase group">
                            <i data-lucide="zap" class="w-3.5 h-3.5 group-hover:animate-pulse"></i> Upgrade
                        </a>
                        @endif

                        <!-- Notification Bell -->
                        @if($isPremium)
                        <div class="relative">
                            <button class="notification-trigger w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-white/10 transition-all relative group">
                                <div class="relative flex items-center justify-center">
                                    <i data-lucide="bell" class="w-5 h-5 group-hover:rotate-12 transition-transform origin-top"></i>
                                    <span class="notification-dot hidden absolute -top-0.5 -right-0.5 w-[9px] h-[9px] bg-rose-500 border-2 border-[#151120] rounded-full shadow-[0_0_10px_rgba(244,63,94,0.6)]"></span>
                                </div>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown" style="background: linear-gradient(135deg, #180a33 0%, #000000 100%);" class="absolute top-[calc(100%+16px)] right-0 w-[400px] border border-white/10 rounded-[2.5rem] shadow-[0_30px_80px_-10px_rgba(0,0,0,0.9)] transition-all duration-300 transform origin-top-right scale-95 opacity-0 invisible z-[999] overflow-hidden">
                                <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                                    <div class="flex flex-col">
                                        <h3 class="font-professional text-[11px] font-black text-white uppercase tracking-[0.25em]">Algo Center</h3>
                                        <p class="text-[8px] text-gray-500 font-bold uppercase tracking-widest mt-1 opacity-60">System Synchronized</p>
                                    </div>
                                    <span id="unread-badge" class="px-3 py-1.5 rounded-xl bg-purple-500 text-white text-[10px] font-black tracking-tighter hidden shadow-[0_0_15px_rgba(168,85,247,0.4)]">0 NEW</span>
                                </div>
                                <div id="notification-list" class="max-h-[60vh] lg:max-h-[450px] overflow-y-auto custom-scrollbar p-4 space-y-2">
                                    <div class="py-20 text-center flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-3xl bg-white/[0.02] border border-white/5 flex items-center justify-center">
                                            <i data-lucide="bell-off" class="w-8 h-8 text-gray-700"></i>
                                        </div>
                                        <span class="text-[10px] font-black font-whiskey uppercase tracking-[0.3em] text-gray-600">No Algo Transmissions</span>
                                    </div>
                                </div>
                                <div class="p-4 border-t border-white/5 text-center bg-white/[0.02]">
                                    <a href="{{ url('/account/notifications') }}" class="inline-flex items-center justify-center w-full py-3 rounded-xl bg-white/[0.03] hover:bg-white/[0.06] text-[10px] font-black text-purple-400 hover:text-white transition-all uppercase tracking-[0.2em] gap-2">
                                        Explore Full Feed <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- User Profile Badge -->
                        <a href="{{ url('/account/profile') }}" class="flex items-center gap-3 px-1 pl-1 pr-4 py-1 rounded-full border {{ $isPremium ? 'border-white/50 bg-gradient-to-r from-white/20 to-transparent hover:from-white/30 hover:border-white/80 hover:shadow-[0_0_20px_rgba(255,255,255,0.1)]' : 'border-white/10 bg-white/5 hover:bg-white/10 hover:border-purple-500/40 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)]' }} transition-all duration-300 group hover:scale-[1.02]">
                            <div class="w-8 h-8 rounded-full {{ $isPremium ? 'bg-white text-black' : 'bg-purple-600 text-white shadow-lg shadow-purple-500/20' }} flex items-center justify-center transition-transform group-hover:scale-105 overflow-hidden relative">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}" 
                                     alt="User" 
                                     class="w-full h-full object-cover global-user-photo {{ !$user->profile_photo ? 'hidden' : '' }}">
                                <span class="global-user-initial flex items-center justify-center w-full h-full {{ $user->profile_photo ? 'hidden' : '' }}">
                                    <i data-lucide="{{ $isPremium ? 'crown' : 'user' }}" 
                                       class="w-4 h-4 {{ $isPremium ? 'fill-black' : '' }}"></i>
                                </span>
                            </div>
                            <div class="flex flex-col leading-none">
                                <span class="text-[9px] font-bold {{ $isPremium ? 'text-amber-500' : 'text-purple-400' }} leading-none tracking-widest uppercase transition-colors group-hover:text-white mb-0.5">
                                    {{ $isPremium ? ($isAdmin ? 'Admin' : 'Premium Member') : 'Free Account' }}
                                </span>
                                <span class="text-[12px] font-bold text-white uppercase global-username">{{ $user->username }}</span>
                            </div>
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="w-10 h-10 rounded-xl bg-rose-950/30 border border-rose-500/20 flex items-center justify-center text-rose-500 hover:bg-rose-900/40 hover:border-rose-500/40 transition-all shadow-lg shadow-rose-900/10">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="hidden lg:inline text-[10px] font-bold text-white hover:text-purple-400 transition-colors tracking-widest uppercase mr-4">Login</a>
                    <a href="{{ url('/register') }}" class="hidden lg:inline px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-[10px] tracking-widest hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.4)] transition-all uppercase">Sign Up</a>
                @endauth
                
                <!-- Mobile Dashboard Link — visible only on mobile/tablet -->
                <a href="{{ route('account.profile') }}" class="lg:hidden w-10 h-10 rounded-xl {{ request()->is('account/profile*') ? 'bg-purple-600 text-white' : 'bg-purple-600/10 text-purple-400' }} border border-purple-500/20 flex items-center justify-center hover:bg-purple-600/30 transition-all relative z-[110]" title="Dashboard">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                </a>

                <!-- Hamburger Button — always visible on mobile -->
                <button class="lg:hidden w-10 h-10 rounded-xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center text-purple-300 hover:bg-purple-600/40 hover:text-white transition-all relative z-[110]" id="mobile-menu-btn">
                    <i data-lucide="menu" class="w-5 h-5" id="menu-icon"></i>
                    <i data-lucide="x" class="w-5 h-5 hidden" id="close-icon"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay - Main scroll container with solid background -->
<div id="mobile-menu" class="fixed inset-0 z-[95] lg:hidden invisible opacity-0 transition-all duration-300 overflow-y-auto overscroll-contain bg-[#05020a] mobile-menu-scroll" style="touch-action: pan-y; -webkit-overflow-scrolling: touch;" data-lenis-prevent>
    <!-- Ambient glow - keeping it for depth but background is now solid -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[500px] bg-purple-600/5 blur-[120px] rounded-full pointer-events-none"></div>
    
    <!-- Menu Content - min-h-full allows growth for scrolling -->
    <div class="relative min-h-full flex flex-col pt-24 px-6 pb-12 mobile-menu-panel" data-lenis-prevent>
        <!-- Navigation Section -->
        <div class="flex flex-col mb-6">
            <h3 class="text-gray-500 text-[9px] font-bold uppercase tracking-[0.3em] mb-4 px-1">Navigation</h3>
        <div class="flex flex-col gap-1.5">
                <a href="{{ url('/') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] active:scale-[0.98] transition-all">
                    <i data-lucide="home" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white/90 tracking-wide uppercase">Home</span>
                </a>
                <a href="{{ route('account.profile') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] active:scale-[0.98] transition-all">
                    <i data-lucide="layout-dashboard" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white/90 tracking-wide uppercase">Dashboard</span>
                </a>
                <a href="{{ url('/about') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] active:scale-[0.98] transition-all">
                    <i data-lucide="info" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white/90 tracking-wide uppercase">About Us</span>
                </a>
                @if($isPremium)
                <a href="{{ url('/account/notifications') }}" class="mobile-menu-item flex items-center justify-between py-3.5 px-5 rounded-2xl bg-purple-500/5 border border-purple-500/10 active:scale-[0.98] transition-all">
                    <div class="flex items-center gap-4">
                        <i data-lucide="bell" class="w-4.5 h-4.5 text-purple-400"></i>
                        <span class="text-[13px] font-bold text-white uppercase tracking-wide">Notifications</span>
                    </div>
                    <span id="mobile-unread-badge" class="hidden px-2 py-0.5 rounded-lg bg-rose-500 text-white text-[9px] font-black tracking-tighter">0</span>
                </a>
                @endif
                <a href="{{ url('/contact') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] active:scale-[0.98] transition-all">
                    <i data-lucide="mail" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white/90 tracking-wide uppercase">Contact</span>
                </a>
                <a href="{{ url('/signals') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-purple-500/10 border border-purple-500/20 active:scale-[0.98] transition-all">
                    <i data-lucide="activity" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white tracking-wide uppercase">Signals</span>
                </a>
                <a href="{{ route('signals.past') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-white/[0.02] border border-white/[0.05] active:scale-[0.98] transition-all">
                    <i data-lucide="history" class="w-4.5 h-4.5 text-purple-400"></i>
                    <span class="font-bold text-[13px] text-white/90 tracking-wide uppercase">Past Signals</span>
                </a>
                <a href="{{ url('/pricing') }}" class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-amber-500/5 border border-amber-500/10 active:scale-[0.98] transition-all">
                    <i data-lucide="crown" class="w-4.5 h-4.5 text-amber-500"></i>
                    <span class="font-bold text-[13px] text-amber-500 tracking-wide uppercase">Pricing</span>
                </a>
                
                {{-- WhatsApp Support Integration --}}
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', App\Models\SiteSetting::getValue('whatsapp_number', '91XXXXXXXXXX')) }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="mobile-menu-item flex items-center gap-4 py-3.5 px-5 rounded-2xl bg-[#25D366]/5 border border-[#25D366]/10 active:scale-[0.98] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-[#25D366]" viewBox="0 0 24 24">
                        <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.553 4.195 1.594 6.021L.188 23.813l5.885-1.547a11.968 11.968 0 0 0 5.958 1.594h.005c6.641 0 12.031-5.385 12.031-12.031 0-6.646-5.385-12.031-12.036-12.031zM19.042 16.927c-.292.818-1.464 1.563-2.026 1.636-.542.068-1.182.26-3.76-.807-3.13-1.296-5.141-4.526-5.292-4.729-.151-.203-1.266-1.688-1.266-3.219 0-1.531.792-2.286 1.078-2.589.286-.302.625-.375.833-.375s.417 0 .599.01c.193.01.448-.073.703.542.266.646.911 2.224.995 2.391.083.167.141.359.036.568-.104.208-.156.339-.313.526-.156.188-.328.396-.469.542-.156.167-.318.354-.135.672.182.318.813 1.349 1.745 2.177 1.203 1.073 2.193 1.406 2.516 1.563.323.156.51.135.703-.094.193-.229.833-.969 1.057-1.302.224-.333.443-.276.734-.167.292.109 1.844.87 2.156 1.026.313.156.521.234.599.365.078.13.078.755-.214 1.573z"/>
                    </svg>
                    <span class="font-bold text-[13px] text-[#25D366] tracking-wide uppercase">Support / WhatsApp</span>
                </a>
            </div>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- User Section -->
        <div class="flex flex-col gap-3 py-6 border-t border-white/5">
            <h3 class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mb-3 px-1">Account Terminal</h3>
            @if($user)
                <div class="mobile-menu-item flex flex-col gap-2">
                    <a href="{{ url('/account/profile') }}" class="flex items-center gap-4 py-4 px-5 rounded-2xl bg-white/[0.03] border border-white/[0.05] transition-all">
                        <div class="w-11 h-11 rounded-full border-2 border-purple-500/30 overflow-hidden shrink-0">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-purple-600 text-white font-bold text-lg">
                                    {{ substr($user->username, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col min-w-0">
                            <span class="font-bold text-white text-[14px] uppercase truncate global-username">{{ $user->username }}</span>
                            <span class="text-[9px] text-purple-400 font-bold uppercase tracking-widest">{{ $isPremium ? 'Premium Node Active' : 'Basic Sync' }}</span>
                        </div>
                    </a>
                    
                    @if(!$isPremium)
                    <a href="{{ url('/pricing') }}" class="flex items-center justify-center gap-3 py-4 px-5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-500 font-bold uppercase text-[11px] tracking-widest">
                        <i data-lucide="zap" class="w-4 h-4"></i> Upgrade to Premium
                    </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-3 py-4 px-5 rounded-2xl bg-rose-500/5 border border-rose-500/10 text-rose-500/80 font-bold uppercase text-[11px] tracking-widest active:bg-rose-500/10 transition-all">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ url('/login') }}" class="mobile-menu-item flex items-center justify-center py-4 px-5 rounded-2xl border border-white/10 bg-white/[0.03] font-bold text-white text-[11px] uppercase tracking-widest">LOGIN</a>
                    <a href="{{ url('/register') }}" class="mobile-menu-item flex items-center justify-center py-4 px-5 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 font-bold text-white text-[11px] uppercase tracking-widest shadow-lg shadow-purple-500/20"> Sign Up</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
    
    /* Ensure mobile menu items default to visible */
    .mobile-menu-item {
        opacity: 1;
    }

    /* Ensure mobile menu works correctly with scrolling */
    .mobile-menu-scroll {
        height: 100%;
        width: 100%;
    }
    .mobile-menu-panel {
        width: 100%;
    }
</style>

<script>
    const nav = document.getElementById('main-nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            nav.classList.add('py-2', 'sm:py-4');
            nav.querySelector('.glass-panel').classList.add('shadow-2xl', 'bg-black/60');
        } else {
            nav.classList.remove('py-2', 'sm:py-4');
            nav.querySelector('.glass-panel').classList.remove('shadow-2xl', 'bg-black/60');
        }
    });

    // Mobile Menu Logic
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const mobileBackdrop = document.getElementById('mobile-menu-backdrop');
    let isMenuOpen = false;

    function toggleMenu() {
        isMenuOpen = !isMenuOpen;
        if (isMenuOpen) {
            document.body.classList.add('menu-open');
            mobileMenu.classList.remove('invisible', 'opacity-0');
            mobileMenu.classList.add('visible', 'opacity-100');
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            if (typeof lenis !== 'undefined') lenis.stop();
            
            // Animate items with fromTo — resets every time
            gsap.fromTo(".mobile-menu-item", 
                { y: 15, opacity: 0 },
                { 
                    y: 0, 
                    opacity: 1, 
                    duration: 0.4, 
                    stagger: 0.04, 
                    ease: "power2.out",
                    onComplete: () => {
                        if (window.lucide) lucide.createIcons();
                    }
                }
            );
        } else {
            document.body.classList.remove('menu-open');
            mobileMenu.classList.add('invisible', 'opacity-0');
            mobileMenu.classList.remove('visible', 'opacity-100');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = '';
            if (typeof lenis !== 'undefined') lenis.start();
        }
    }

    menuBtn.addEventListener('click', toggleMenu);

    // Close menu when clicking links
    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            if (isMenuOpen) toggleMenu();
        });
    });

    @if($isPremium)
    const dropdown = document.getElementById('notification-dropdown');
    const dots = document.querySelectorAll('.notification-dot');
    const badge = document.getElementById('unread-badge');
    const mobileBadge = document.getElementById('mobile-unread-badge');
    const list = document.getElementById('notification-list');

    async function fetchNotifications() {
        try {
            const response = await fetch('{{ route("notifications.index") }}');
            const data = await response.json();
            
            if (data.unreadCount > 0) {
                dots.forEach(dot => dot.classList.remove('hidden'));
                if(badge) {
                    badge.classList.remove('hidden');
                    badge.textContent = `${data.unreadCount} NEW`;
                }
                if(mobileBadge) {
                    mobileBadge.classList.remove('hidden');
                    mobileBadge.textContent = data.unreadCount;
                }
            } else {
                dots.forEach(dot => dot.classList.add('hidden'));
                if(badge) badge.classList.add('hidden');
                if(mobileBadge) mobileBadge.classList.add('hidden');
            }

            if (data.notifications.length > 0) {
                // Display up to 3 latest notifications
                const displayNodes = data.notifications.slice(0, 3);
                
                list.innerHTML = displayNodes.map(n => `
                    <div class="p-4 rounded-[1.5rem] hover:bg-white/[0.04] border border-white/[0.03] transition-all cursor-pointer group/item relative overflow-hidden" 
                         onclick="handleNotificationClick(${n.id}, \`${n.title.replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`, \`${n.message.replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`, '${n.created_at}', '${n.icon}', this)">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/[0.05] to-transparent opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
                        <div class="flex gap-5 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover/item:bg-purple-500/20 group-hover/item:scale-105 transition-all shrink-0">
                                <i data-lucide="${n.icon || 'bell'}" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-3 mb-1.5">
                                    <h4 class="text-[11px] font-black text-white uppercase tracking-wider truncate">${n.title}</h4>
                                    ${!n.read_at ? '<div class="unread-dot w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_10px_#fbbf24] shrink-0"></div>' : ''}
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium leading-[1.6] line-clamp-2 pr-4 break-all">${n.message}</p>
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="text-[9px] font-bold text-gray-700 uppercase tracking-[0.15em]">${new Date(n.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                    <div class="w-1 h-1 rounded-full bg-white/10"></div>
                                    <span class="text-[9px] font-bold text-purple-500/50 uppercase tracking-[0.15em] group-hover/item:text-purple-400 transition-colors">Dispatch Node</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
                lucide.createIcons();
            }
        } catch (error) {
            console.error('Failed to fetch notifications');
        }
    }

    async function handleNotificationClick(id, title, message, time, icon, el) {
        // Mark as read
        markRead(id, el);
        
        // Open Detail Modal
        const modal = document.getElementById('notification-detail-modal');
        const modalTitle = document.getElementById('detail-modal-title');
        const modalMessage = document.getElementById('detail-modal-message');
        const modalTime = document.getElementById('detail-modal-time');
        const modalIcon = document.getElementById('detail-modal-icon');

        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modalTime.textContent = new Date(time).toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' });
        modalIcon.innerHTML = `<i data-lucide="${icon || 'bell'}" class="w-6 h-6"></i>`;
        lucide.createIcons();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Close the dropdown
        dropdown.classList.add('invisible', 'opacity-0', 'scale-95');
    }

    async function markRead(id, el) {
        try {
            const hasUnread = el.querySelector('.unread-dot');
            if (!hasUnread) return;

            await fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            fetchNotifications();
        } catch (e) {}
    }

    window.closeNotificationDetail = function() {
        const modal = document.getElementById('notification-detail-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelectorAll('.notification-trigger').forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = !dropdown.classList.contains('invisible');
            
            if (isOpen) {
                dropdown.classList.add('invisible', 'opacity-0', 'scale-95');
            } else {
                dropdown.classList.remove('invisible', 'opacity-0', 'scale-95');
            }
        });
    });

    document.addEventListener('click', () => {
        dropdown.classList.add('invisible');
        dropdown.classList.add('opacity-0');
        dropdown.classList.add('scale-95');
    });

    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // Fetch every 30 seconds
    fetchNotifications();
    setInterval(fetchNotifications, 30000);
    @endif
</script>

@if($isPremium)
<!-- Notification Detail Modal -->
<div id="notification-detail-modal" class="fixed inset-0 z-[999999] hidden items-center justify-center p-6 sm:p-0 transition-all duration-300">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-md" onclick="closeNotificationDetail()"></div>
    <div style="background: linear-gradient(135deg, #180a33 0%, #000000 100%);" class="w-full max-w-lg rounded-[2.5rem] border border-white/10 relative z-10 overflow-hidden shadow-[0_20px_80px_rgba(0,0,0,0.8)]">
        <div class="p-8 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div id="detail-modal-icon" class="w-12 h-12 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400">
                    <!-- Icon injected via JS -->
                </div>
                <div>
                    <h2 id="detail-modal-title" class="text-sm font-black text-white uppercase tracking-wider leading-none mb-1">NOTIFICATION</h2>
                    <p id="detail-modal-time" class="text-[9px] font-bold text-gray-500 uppercase tracking-widest"></p>
                </div>
            </div>
            <button onclick="closeNotificationDetail()" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 hover:text-white transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="p-8">
            <div id="detail-modal-message" class="text-xs text-gray-300 leading-relaxed font-medium bg-white/[0.01] p-6 rounded-2xl border border-white/[0.03] max-h-[40vh] overflow-y-auto no-scrollbar whitespace-pre-wrap">
                <!-- Message injected via JS -->
            </div>
        </div>
        <div class="p-8 pt-0">
            <button onclick="closeNotificationDetail()" class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-[10px] font-black text-white hover:bg-white/10 transition-all uppercase tracking-[0.2em]">Close Transmission</button>
        </div>
    </div>
</div>
@endif

<nav class="fixed top-0 left-0 w-full z-[100] px-3 sm:px-6 py-2 sm:py-3 transition-all duration-500" id="main-nav">
    <div class="container mx-auto">
        <div class="glass-panel px-4 py-2 sm:px-8 sm:py-2.5 rounded-xl sm:rounded-[2rem] border border-white/10 flex justify-between items-center relative group">
            <div class="absolute inset-0 rounded-xl sm:rounded-[2rem] overflow-hidden pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            </div>
            
            <a href="{{ url('/') }}" class="flex items-center gap-2 relative z-10 transition-transform hover:scale-105">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i data-lucide="zap" class="w-5 h-5 text-white fill-white"></i>
                </div>
                <div class="orbitron font-black text-base sm:text-lg italic tracking-tighter">
                    <span class="text-white">ALGO</span><span class="text-purple-500">TRADE</span>
                </div>
            </a>

            <!-- Navigation Links (Desktop only) -->
            <div class="hidden lg:flex items-center gap-8 relative z-10">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-purple-400 transition-colors tracking-wider uppercase">
                    <i data-lucide="home" class="w-3.5 h-3.5"></i> Home
                </a>
                <a href="{{ url('/about') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="info" class="w-3.5 h-3.5"></i> About Us
                </a>
                <a href="{{ url('/contact') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron text-gray-400 hover:text-white transition-colors tracking-wider uppercase">
                    <i data-lucide="mail" class="w-3.5 h-3.5"></i> Contact Us
                </a>
                <a href="{{ url('/signals') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron {{ request()->is('signals') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-500 transition-colors tracking-wider uppercase">
                    <i data-lucide="activity" class="w-3.5 h-3.5"></i> Signals
                </a>
                <a href="{{ route('signals.past') }}" class="flex items-center gap-2 text-[10px] font-bold orbitron {{ request()->is('signals/past') ? 'text-white' : 'text-gray-400' }} hover:text-white transition-colors tracking-wider uppercase">
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
                        <a href="{{ url('/signals') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-purple-900/40 border border-purple-500/30 text-purple-200 font-bold orbitron text-[10px] tracking-wider hover:bg-purple-800/40 transition-all">
                            <i data-lucide="crown" class="w-3.5 h-3.5 text-amber-500"></i> Premium Terminal
                        </a>
                        @else
                        <a href="{{ url('/pricing') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-500 font-bold orbitron text-[10px] tracking-wider hover:bg-amber-500/20 transition-all group">
                            <i data-lucide="zap" class="w-3.5 h-3.5 group-hover:animate-pulse"></i> Upgrade
                        </a>
                        @endif

                        <!-- Notification Bell -->
                        @if($isPremium)
                        <div class="relative" id="notification-wrapper">
                            <button id="notification-bell" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-amber-400 hover:bg-white/10 transition-all relative group">
                                <i data-lucide="bell" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                                <span id="notification-dot" class="hidden absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full shadow-[0_0_10px_#f43f5e]"></span>
                            </button>

                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown" class="absolute top-[120%] right-0 w-80 bg-[#0a0a12]/95 backdrop-blur-xl border border-white/10 rounded-[2rem] shadow-2xl transition-all duration-300 transform scale-95 opacity-0 invisible z-[110] overflow-hidden">
                                <div class="p-6 border-b border-white/5 flex justify-between items-center">
                                    <h3 class="orbitron text-[10px] font-black text-white uppercase tracking-widest">Notifications</h3>
                                    <span id="unread-badge" class="px-2 py-0.5 rounded-full bg-amber-500 text-black text-[8px] font-black orbitron hidden">0 NEW</span>
                                </div>
                                <div id="notification-list" class="max-h-[400px] overflow-y-auto custom-scrollbar p-2 space-y-1">
                                    <div class="py-10 text-center opacity-30 flex flex-col items-center gap-2">
                                        <i data-lucide="inbox" class="w-8 h-8"></i>
                                        <span class="text-[8px] font-bold orbitron uppercase tracking-[0.2em]">No new notifications</span>
                                    </div>
                                </div>
                                <div class="p-4 border-t border-white/5 text-center">
                                    <a href="{{ url('/account/notifications') }}" class="text-[8px] font-black orbitron text-gray-500 hover:text-white transition-colors uppercase tracking-widest">View History</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- User Profile Badge -->
                        <a href="{{ url('/account/profile') }}" class="flex items-center gap-3 px-1 pl-1 pr-4 py-1 rounded-full border {{ $isPremium ? 'border-amber-500/50 bg-gradient-to-r from-amber-600/20 to-transparent hover:from-amber-600/30 hover:border-amber-500/80 hover:shadow-[0_0_20px_rgba(245,158,11,0.1)]' : 'border-white/10 bg-white/5 hover:bg-white/10 hover:border-purple-500/40 hover:shadow-[0_0_20px_rgba(147,51,234,0.1)]' }} transition-all duration-300 group hover:scale-[1.02]">
                            <div class="w-8 h-8 rounded-full {{ $isPremium ? 'bg-amber-500 text-black' : 'bg-purple-600 text-white shadow-lg shadow-purple-500/20' }} flex items-center justify-center transition-transform group-hover:scale-105 overflow-hidden relative">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}" 
                                     alt="User" 
                                     class="w-full h-full object-cover global-user-photo {{ !$user->profile_photo ? 'hidden' : '' }}">
                                <span class="global-user-initial flex items-center justify-center w-full h-full {{ $user->profile_photo ? 'hidden' : '' }}">
                                    <i data-lucide="{{ $isPremium ? 'crown' : 'user' }}" 
                                       class="w-4 h-4 {{ $isPremium ? 'fill-black' : '' }}"></i>
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[8px] font-black orbitron {{ $isPremium ? 'text-amber-500' : 'text-purple-400' }} leading-none tracking-widest uppercase transition-colors group-hover:text-white">
                                    {{ $isPremium ? ($isAdmin ? 'Admin' : 'Premium Member') : 'Free Account' }}
                                </span>
                                <span class="text-[11px] font-bold orbitron text-white leading-tight uppercase global-username">{{ $user->username }}</span>
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
                    <a href="{{ url('/login') }}" class="hidden lg:inline text-[10px] font-bold orbitron text-white hover:text-purple-400 transition-colors tracking-widest uppercase mr-4">Login</a>
                    <a href="{{ url('/register') }}" class="hidden lg:inline px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black orbitron text-[10px] tracking-widest hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.4)] transition-all uppercase">Sign Up</a>
                @endauth
                
                <!-- Hamburger Button — always visible on mobile -->
                <button class="lg:hidden w-10 h-10 rounded-xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center text-purple-300 hover:bg-purple-600/40 hover:text-white transition-all relative z-[110]" id="mobile-menu-btn">
                    <i data-lucide="menu" class="w-5 h-5" id="menu-icon"></i>
                    <i data-lucide="x" class="w-5 h-5 hidden" id="close-icon"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu" class="fixed inset-0 z-[95] lg:hidden invisible opacity-0 transition-all duration-300 overflow-hidden">
    <!-- Backdrop — fully opaque dark background -->
    <div class="absolute inset-0 bg-[#05020a]" id="mobile-menu-backdrop"></div>
    
    <!-- Ambient glow -->
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[300px] h-[300px] bg-purple-600/10 blur-[120px] rounded-full pointer-events-none"></div>
    
    <!-- Menu Content -->
    <div class="relative h-full flex flex-col pt-20 sm:pt-24 px-5 sm:px-8 pb-8 overflow-y-auto">
        <!-- Navigation Section -->
        <div class="flex flex-col mb-6">
            <h3 class="orbitron text-gray-500 text-[9px] font-black uppercase tracking-[0.3em] mb-4 px-1">Navigation</h3>
            <div class="flex flex-col gap-2">
                <a href="{{ url('/') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0">
                        <i data-lucide="home" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-white tracking-wide uppercase">Home</span>
                </a>
                <a href="{{ url('/about') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0">
                        <i data-lucide="info" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-white tracking-wide uppercase">About Us</span>
                </a>
                <a href="{{ url('/contact') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-white tracking-wide uppercase">Contact</span>
                </a>
                <a href="{{ url('/signals') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0">
                        <i data-lucide="activity" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-white tracking-wide uppercase">Signals</span>
                </a>
                <a href="{{ route('signals.past') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-purple-500/30 hover:bg-purple-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400 shrink-0">
                        <i data-lucide="history" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-white tracking-wide uppercase">Past Signals</span>
                </a>
                <a href="{{ url('/pricing') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-white/[0.03] border border-amber-500/10 hover:border-amber-500/30 hover:bg-amber-500/10 transition-all">
                    <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-400 shrink-0">
                        <i data-lucide="crown" class="w-4 h-4"></i>
                    </div>
                    <span class="orbitron font-bold text-xs text-amber-400 tracking-wide uppercase">Pricing</span>
                </a>
            </div>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <!-- User Section -->
        <div class="flex flex-col gap-3 pt-5 border-t border-white/5">
            <h3 class="orbitron text-gray-500 text-[9px] font-black uppercase tracking-[0.3em] mb-1 px-1">Account</h3>
            @if($user)
                <a href="{{ url('/account/profile') }}" class="mobile-menu-item flex items-center gap-3 py-3 px-4 rounded-xl bg-purple-500/5 border border-purple-500/15 hover:bg-purple-500/10 transition-all">
                    <div class="w-10 h-10 rounded-full border-2 border-purple-500/50 overflow-hidden shrink-0">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-purple-600 text-white">
                                <i data-lucide="user" class="w-5 h-5"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="orbitron font-black text-white text-sm uppercase truncate global-username">{{ $user->username }}</span>
                        <span class="text-[8px] orbitron text-purple-400 font-bold uppercase tracking-widest">{{ $isPremium ? 'Premium Member' : 'Free Account' }}</span>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="mobile-menu-item w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl bg-rose-500/5 border border-rose-500/15 text-rose-400 orbitron font-bold uppercase text-xs hover:bg-rose-500/15 transition-all">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                    </button>
                </form>
            @else
                <div class="flex gap-3">
                    <a href="{{ url('/login') }}" class="mobile-menu-item flex-1 flex items-center justify-center py-3 px-4 rounded-xl border border-white/10 bg-white/[0.03] orbitron font-bold text-white text-xs uppercase hover:bg-white/10 transition-all">Login</a>
                    <a href="{{ url('/register') }}" class="mobile-menu-item flex-1 flex items-center justify-center py-3 px-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 orbitron font-black text-white text-xs uppercase shadow-lg shadow-purple-500/20 hover:scale-[1.02] transition-all">Register</a>
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
    const bell = document.getElementById('notification-bell');
    const dropdown = document.getElementById('notification-dropdown');
    const dot = document.getElementById('notification-dot');
    const badge = document.getElementById('unread-badge');
    const list = document.getElementById('notification-list');

    async function fetchNotifications() {
        try {
            const response = await fetch('{{ route("notifications.index") }}');
            const data = await response.json();
            
            if (data.unreadCount > 0) {
                dot.classList.remove('hidden');
                badge.classList.remove('hidden');
                badge.textContent = `${data.unreadCount} NEW`;
            } else {
                dot.classList.add('hidden');
                badge.classList.add('hidden');
            }

            if (data.notifications.length > 0) {
                list.innerHTML = data.notifications.map(n => `
                    <div class="p-4 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/10 transition-all cursor-pointer group/item" onclick="markRead(${n.id}, this)">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 group-hover/item:bg-purple-500/20 transition-all">
                                <i data-lucide="${n.icon || 'bell'}" class="w-5 h-5"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-[10px] font-black orbitron text-white leading-none mb-1 uppercase tracking-wider">${n.title}</h4>
                                <p class="text-[10px] text-gray-500 font-medium leading-relaxed">${n.message}</p>
                                <span class="text-[8px] font-bold orbitron text-gray-700 uppercase mt-2 block tracking-widest">${new Date(n.created_at).toLocaleTimeString()}</span>
                            </div>
                            ${!n.read_at ? '<div class="w-1.5 h-1.5 rounded-full bg-amber-500 mt-1 shadow-[0_0_5px_#fbbf24]"></div>' : ''}
                        </div>
                    </div>
                `).join('');
                lucide.createIcons();
            }
        } catch (error) {
            console.error('Failed to fetch notifications');
        }
    }

    async function markRead(id, el) {
        try {
            await fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            fetchNotifications();
        } catch (e) {}
    }

    bell.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('invisible');
        dropdown.classList.toggle('opacity-0');
        dropdown.classList.toggle('scale-95');
    });

    document.addEventListener('click', () => {
        dropdown.classList.add('invisible');
        dropdown.classList.add('opacity-0');
        dropdown.classList.add('scale-95');
    });

    // Fetch every 30 seconds
    fetchNotifications();
    setInterval(fetchNotifications, 30000);
    @endif
</script>

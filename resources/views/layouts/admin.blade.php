<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Emperor Stock Predictor</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #05020a;
            --accent-purple: #9333ea;
            --sidebar-bg: rgba(12, 5, 24, 0.8);
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }

        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(147, 51, 234, 0.5);
        }

        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(147, 51, 234, 0.2) 0%, rgba(147, 51, 234, 0) 100%);
            border-left: 3px solid var(--accent-purple);
            color: white !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--bg-deep); }
        ::-webkit-scrollbar-thumb { background: #1a1325; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--accent-purple); }

        @media (max-width: 1023px) {
            .sidebar-collapsed { transform: translateX(-100%); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#05020a] text-white">
    <div class="flex min-h-screen relative">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[90] hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" data-lenis-prevent class="fixed lg:sticky top-0 left-0 w-72 h-screen border-r border-white/5 bg-[#0c0518]/90 backdrop-blur-2xl z-[100] transition-transform duration-300 sidebar-collapsed lg:transform-none flex flex-col pt-8">
            <div class="px-8 flex items-center justify-between mb-12">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-600/20">
                        <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                    </div>
                    <div class="orbitron font-black text-xl italic tracking-tighter">
                        CORE <span class="text-purple-500">ADMIN</span>
                    </div>
                </div>
                <button class="lg:hidden text-gray-400" onclick="toggleSidebar()">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 overflow-y-auto space-y-1">
                <div class="px-4 mb-4 text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none">Main Operations</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="layout-grid" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Dashboard</span>
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.analytics') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 {{ request()->routeIs('admin.analytics') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Neural Analytics</span>
                </a>
                
                <a href="{{ route('admin.predictions.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.predictions.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="activity" class="w-5 h-5 {{ request()->routeIs('admin.predictions.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Predictions</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">User Base</span>
                </a>

                <a href="{{ route('admin.tutorial-videos.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.tutorial-videos.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="play-circle" class="w-5 h-5 {{ request()->routeIs('admin.tutorial-videos.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Learning Hub</span>
                </a>

                <div class="px-4 mt-10 mb-4 text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none">Financials</div>

                <a href="{{ route('admin.premium-packages.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.premium-packages.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="package" class="w-5 h-5 {{ request()->routeIs('admin.premium-packages.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Pricing Plans</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.payments.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="credit-card" class="w-5 h-5 {{ request()->routeIs('admin.payments.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Transactions</span>
                </a>
                
                <a href="{{ route('admin.referrals.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.referrals.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="share-2" class="w-5 h-5 {{ request()->routeIs('admin.referrals.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Referrals</span>
                </a>

                <div class="px-4 mt-10 mb-4 text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest leading-none">Configuration</div>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.settings') && !str_contains(request()->url(), 'wallet') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="sliders" class="w-5 h-5 {{ request()->routeIs('admin.settings') && !str_contains(request()->url(), 'wallet') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">System Config</span>
                </a>

                <a href="{{ route('admin.settings.wallet') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.settings.wallet') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="wallet" class="w-5 h-5 {{ request()->routeIs('admin.settings.wallet') ? 'text-purple-500' : '' }}"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-[0.2em]">Wallet Hub</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-white hover:bg-white/5 transition-all text-[10px] font-black orbitron uppercase tracking-widest">
                    <i data-lucide="eye" class="w-4 h-4"></i> View Frontend
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-rose-500/70 hover:text-rose-500 hover:bg-rose-500/5 transition-all text-[10px] font-black orbitron uppercase tracking-widest">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Terminate Session
                    </button>
                </form>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="h-20 border-b border-white/5 bg-[#05020a]/80 backdrop-blur-xl flex items-center justify-between px-8 z-50">
                <div class="flex items-center gap-6">
                    <button class="lg:hidden text-gray-400" onclick="toggleSidebar()">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h2 class="text-xs font-black orbitron text-gray-500 uppercase tracking-[0.3em]">ADMIN v2.5 / <span class="text-white">@yield('title', 'DASHBOARD')</span></h2>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:flex items-center bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-gray-500 focus-within:border-purple-500/50 transition-all">
                        <i data-lucide="search" class="w-4 h-4 mr-3"></i>
                        <input type="text" placeholder="Scan protocols..." class="bg-transparent border-none outline-none text-xs text-white placeholder-gray-600 w-48">
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center gap-4 pl-6 border-l border-white/5">
                        <div class="text-right hidden sm:block">
                            <div class="text-[10px] font-black orbitron text-white uppercase leading-none">{{ Auth::user()->username }}</div>
                            <div class="text-[9px] font-bold text-purple-500 uppercase tracking-widest mt-1">Superuser Access</div>
                        </div>
                        <div class="w-10 h-10 rounded-xl border border-white/10 bg-purple-600/20 flex items-center justify-center text-white font-black orbitron overflow-hidden">
                           @if(Auth::user()->profile_photo)
                               <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="w-full h-full object-cover">
                           @else
                               {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                           @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-8 lg:p-12 custom-scrollbar">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        lucide.createIcons();

        // Initialize Lenis
        const lenis = new Lenis();
        
        // Sync Lenis with ScrollTrigger
        if (typeof ScrollTrigger !== 'undefined') {
            lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add((time) => {
                lenis.raf(time * 1000);
            });
            gsap.ticker.lagSmoothing(0);
        }

        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('sidebar-collapsed');
            overlay.classList.toggle('hidden');
            
            if (!overlay.classList.contains('hidden')) {
                document.body.style.overflow = 'hidden';
                if (typeof lenis !== 'undefined') lenis.stop();
            } else {
                document.body.style.overflow = '';
                if (typeof lenis !== 'undefined') lenis.start();
            }
        }

        // Auto-close sidebar on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar').classList.remove('sidebar-collapsed');
                document.getElementById('sidebar-overlay').classList.add('hidden');
                document.body.style.overflow = '';
                if (typeof lenis !== 'undefined') lenis.start();
            } else {
                document.getElementById('sidebar').classList.add('sidebar-collapsed');
            }
        });

        // Global scroll refresh on load
        window.addEventListener('load', () => {
            setTimeout(() => { if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh(); }, 500);
        });
    </script>
    @stack('scripts')
</body>
</html>

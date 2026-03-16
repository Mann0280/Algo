<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Emperor Stock Predictor</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/tabulator-tables@6.3.1/dist/css/tabulator.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #000000;
            --accent-purple: #9333ea;
            --accent-magenta: #d946ef;
            --accent-blue: #3b82f6;
            --whiskey-gold: #ffffff;
            --sidebar-width: 280px;
            --header-height: 80px;
            --vibrant-gradient: linear-gradient(90deg, #9333ea 0%, #d946ef 100%);
        }

        body {
            background-color: #000000;
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .font-whiskey { 
            font-family: 'Inter', sans-serif; 
            font-weight: 600;
            letter-spacing: normal;
            color: white;
        }

        .text-vibrant {
            background: var(--vibrant-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

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
            .sidebar-active { transform: translateX(0) !important; }
        }
        
        /* Universal Table Scroll Wrapper */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
            scrollbar-width: none;
        }
        .table-wrapper::-webkit-scrollbar { display: none; }

        /* Strict Purple & Black Theme Overhaul */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #000000; }
        ::-webkit-scrollbar-thumb { background: #9333ea; border-radius: 4px; box-shadow: 0 0 10px rgba(147, 51, 234, 0.5); }

        .tabulator { 
            width: 100% !important;
            background: #000000 !important;
            border: none !important;
            font-family: 'Inter', sans-serif !important;
        }
        
        .tabulator .tabulator-header { 
            background: #000000 !important;
            border-bottom: 2px solid #9333ea !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            font-size: 11px !important;
            box-shadow: 0 4px 20px rgba(147, 51, 234, 0.1);
        }

        .tabulator .tabulator-header .tabulator-col {
            background: transparent !important;
            border: none !important;
        }

        .tabulator .tabulator-tableHolder {
            background: #000000 !important;
        }

        .tabulator-row {
            background: #000000 !important;
            border-bottom: 1px solid rgba(147, 51, 234, 0.1) !important;
            min-height: 70px !important;
            display: flex !important;
            align-items: center !important;
        }

        .tabulator-row.tabulator-row-even { background: #050505 !important; }

        .tabulator-row .tabulator-cell {
            border: none !important;
            padding: 16px 20px !important;
            display: flex !important;
            align-items: center !important;
            font-size: 12px !important;
        }

        /* Status Badge Overhaul */
        .status-badge {
            padding: 5px 15px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            border: 1px solid transparent;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        .status-win { background: #000000; color: #10b981; border-color: #10b98166; box-shadow: 0 0 10px rgba(16, 185, 129, 0.2); }
        .status-loss { background: #000000; color: #ef4444; border-color: #ef444466; box-shadow: 0 0 10px rgba(239, 68, 68, 0.2); }
        .status-live { background: #000000; color: #9333ea; border-color: #9333ea66; box-shadow: 0 0 10px rgba(147, 51, 234, 0.2); }

        /* Pagination & Footer */
        .tabulator-footer {
            background: #000000 !important;
            border-top: 2px solid #9333ea !important;
            padding: 25px 30px !important;
            box-shadow: 0 -10px 30px rgba(147, 51, 234, 0.1);
        }

        .tabulator-footer .tabulator-page, 
        .tabulator-footer .tabulator-paginator button {
            background: #000000 !important;
            border: 1px solid rgba(147, 51, 234, 0.3) !important;
            color: #94a3b8 !important;
            border-radius: 12px !important;
            margin: 0 5px !important;
            padding: 10px 18px !important;
            font-weight: 900 !important;
            transition: all 0.3s ease !important;
        }

        .tabulator-footer .tabulator-page.active {
            background: #9333ea !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.6);
        }

        /* Stats Grid System */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        /* Content Container */
        .admin-main-area {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        @media (max-width: 1023px) {
            .admin-main-area {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#000000] text-white">
    <div class="flex min-h-screen relative overflow-hidden">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[90] hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" data-lenis-prevent class="fixed top-0 left-0 w-[var(--sidebar-width)] h-screen border-r border-purple-500/10 bg-[#000000] z-[100] transition-transform duration-500 sidebar-collapsed lg:translate-x-0 flex flex-col pt-8 shadow-[20px_0_50px_rgba(0,0,0,0.8)]">
            <div class="px-8 flex items-center justify-between mb-12">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-600/20">
                        <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                    </div>
                    <div class="font-bold-tight text-xl">
                        ADMIN <span class="text-vibrant">PANEL</span>
                    </div>
                </div>
                <button class="lg:hidden text-gray-400" onclick="toggleSidebar()">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-1 px-4 overflow-y-auto space-y-1">
                <div class="px-4 mb-4 text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest leading-none">Management</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="layout-grid" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[10px] font-bold uppercase tracking-[0.2em]">Dashboard</span>
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.analytics') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 {{ request()->routeIs('admin.analytics') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Analytics</span>
                </a>
                
                <a href="{{ route('admin.predictions.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.predictions.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="activity" class="w-5 h-5 {{ request()->routeIs('admin.predictions.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[10px] font-bold uppercase tracking-[0.2em]">Predictions</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Users</span>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.contact-messages.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="mail" class="w-5 h-5 {{ request()->routeIs('admin.contact-messages.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Contact Messages</span>
                </a>

                <a href="{{ route('admin.tutorial-videos.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.tutorial-videos.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="play-circle" class="w-5 h-5 {{ request()->routeIs('admin.tutorial-videos.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Tutorials</span>
                </a>

                <a href="{{ route('admin.broadcast-notification.show') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.broadcast-notification.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="megaphone" class="w-5 h-5 {{ request()->routeIs('admin.broadcast-notification.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Broadcast</span>
                </a>

                <div class="px-4 mt-10 mb-4 text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-widest leading-none">Financials</div>

                <a href="{{ route('admin.premium-packages.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.premium-packages.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="package" class="w-5 h-5 {{ request()->routeIs('admin.premium-packages.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[10px] font-bold uppercase tracking-[0.2em]">Pricing Plans</span>
                </a>

                <a href="{{ route('admin.payment-requests.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.payment-requests.index') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="bell" class="w-5 h-5 {{ request()->routeIs('admin.payment-requests.index') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Subscription Requests</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.payments.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="credit-card" class="w-5 h-5 {{ request()->routeIs('admin.payments.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Payment History</span>
                </a>
                
                <a href="{{ route('admin.referrals.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.referrals.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="share-2" class="w-5 h-5 {{ request()->routeIs('admin.referrals.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[10px] font-bold uppercase tracking-[0.2em]">Referrals</span>
                </a>

                <a href="{{ route('admin.withdraw-requests.index') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.withdraw-requests.*') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="external-link" class="w-5 h-5 {{ request()->routeIs('admin.withdraw-requests.*') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[10px] font-bold uppercase tracking-[0.2em]">Withdrawals</span>
                </a>

                <div class="px-4 mt-10 mb-4 text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-widest leading-none">Configuration</div>

                <a href="{{ route('admin.settings') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.settings') && !str_contains(request()->url(), 'wallet') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="sliders" class="w-5 h-5 {{ request()->routeIs('admin.settings') && !str_contains(request()->url(), 'wallet') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">General Settings</span>
                </a>

                <a href="{{ route('admin.settings.wallet') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all group {{ request()->routeIs('admin.settings.wallet') ? 'sidebar-item-active text-white' : 'text-gray-500 hover:text-gray-300 hover:bg-white/5' }}">
                    <i data-lucide="wallet" class="w-5 h-5 {{ request()->routeIs('admin.settings.wallet') ? 'text-purple-500' : '' }}"></i>
                    <span class="font-whiskey text-[11px] font-semibold uppercase tracking-[0.1em]">Wallet Settings</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/5 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-gray-500 hover:text-white hover:bg-white/5 transition-all text-[10px] font-black font-whiskey uppercase tracking-widest">
                    <i data-lucide="eye" class="w-4 h-4"></i> View Frontend
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-rose-500/70 hover:text-rose-500 hover:bg-rose-500/5 transition-all text-[11px] font-semibold font-whiskey uppercase tracking-widest">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main-area bg-[#000000]">
            <!-- Top Navbar -->
            <header class="h-[var(--header-height)] border-b border-purple-500/10 bg-black/80 backdrop-blur-xl flex items-center justify-between px-8 z-[95] sticky top-0">
                <div class="flex items-center gap-6">
                    <button class="lg:hidden text-gray-400" onclick="toggleSidebar()">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div>
                        <h2 class="text-xs font-semibold font-whiskey text-gray-500 uppercase tracking-widest">Site Dashboard / <span class="text-white">@yield('title', 'Overview')</span></h2>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:flex items-center bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-gray-500 focus-within:border-purple-500/50 transition-all">
                        <i data-lucide="search" class="w-4 h-4 mr-3"></i>
                        <input type="text" placeholder="Search..." class="bg-transparent border-none outline-none text-xs text-white placeholder-gray-600 w-48">
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="flex items-center gap-4 pl-6 border-l border-white/5">
                        <div class="text-right hidden sm:block">
                            <div class="text-[11px] font-semibold font-whiskey text-white uppercase leading-none">{{ Auth::user()->username }}</div>
                            <div class="text-[9px] font-bold text-purple-500 uppercase tracking-widest mt-1">Administrator</div>
                        </div>
                        <div class="w-10 h-10 rounded-xl border border-white/10 bg-purple-600/20 flex items-center justify-center text-white font-black font-whiskey overflow-hidden">
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
            <main class="flex-1 p-6 lg:p-10">
                <div class="max-w-[1600px] mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Global Icon Init
        const initIcons = () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        };

        document.addEventListener('DOMContentLoaded', initIcons);
        window.addEventListener('load', initIcons);

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
            sidebar.classList.toggle('sidebar-active');
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
                document.getElementById('sidebar').classList.remove('sidebar-active');
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

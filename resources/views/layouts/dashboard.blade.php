<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terminal | Emperor Stock Predictor')</title>
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Dark Theme Default - Refined for Premium Feel */
            --bg-deep: #020106;
            --bg-sidebar: rgba(8, 4, 15, 0.7);
            --header-bg: rgba(2, 1, 6, 0.82);
            --text-main: #94a3b8;
            --text-white: #ffffff;
            --text-muted: #64748b;
            --accent-purple: #9333ea;
            --accent-indigo: #6366f1;
            --accent-gold: #fbbf24;
            --accent-gradient: linear-gradient(135deg, #9333ea 0%, #6366f1 100%);
            --card-glass: rgba(255, 255, 255, 0.02);
            --border-glass: rgba(255, 255, 255, 0.06);
            --input-bg: rgba(255, 255, 255, 0.02);
            --dropdown-bg: #05020c;
            --card-inner-bg: #0a0514;
            --nav-sticky-bg: rgba(2, 1, 6, 0.8);
            --logo-text: #ffffff;
            --nav-text: #6b7280;
            --nav-hover-bg: rgba(255, 255, 255, 0.04);
            --scrollbar-thumb: rgba(147, 51, 234, 0.1);
        }

        .light-mode {
            --bg-deep: #f1f5f9;
            --bg-sidebar: #ffffff;
            --header-bg: rgba(255, 255, 255, 0.9);
            --text-main: #334155;
            --text-white: #0f172a;
            --text-muted: #64748b;
            --card-glass: #ffffff;
            --border-glass: rgba(0, 0, 0, 0.08);
            --input-bg: #ffffff;
            --dropdown-bg: #ffffff;
            --card-inner-bg: #f8fafc;
            --nav-sticky-bg: rgba(255, 255, 255, 0.8);
            --logo-text: #0f172a;
            --nav-text: #64748b;
            --nav-hover-bg: #f8fafc;
            --scrollbar-thumb: rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }

        /* Main Dashboard Grid */
        .dashboard-container {
            display: grid;
            grid-template-areas: 
                "header"
                "main";
            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr;
            min-height: 100vh;
            width: 100%;
            transition: grid-template-columns 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 1024px) {
            .dashboard-container {
                grid-template-areas: 
                    "sidebar header"
                    "sidebar main";
                grid-template-columns: 280px 1fr;
            }
            .dashboard-container.collapsed {
                grid-template-columns: 88px 1fr;
            }
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: var(--bg-sidebar);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border-right: 1px solid var(--border-glass);
            display: flex;
            flex-direction: column;
            z-index: 200;
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                        width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 20px 0 50px rgba(0, 0, 0, 0.3);
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(147, 51, 234, 0.1), transparent);
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            .sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                grid-area: sidebar;
                transform: translateX(0);
                box-shadow: none;
                overflow-y: auto;
            }
            .collapsed .sidebar {
                width: 88px;
            }
        }

        .mobile-sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(4px);
            z-index: 150;
        }

        .mobile-sidebar-backdrop.active {
            display: block;
        }

        /* Header Styling */
        .header {
            grid-area: header;
            background: var(--header-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-glass);
            z-index: 1000;
            transition: background 0.3s ease, border-bottom 0.3s ease;
        }

        /* Content Area */
        .main-content {
            grid-area: main;
            background: radial-gradient(circle at top right, rgba(147, 51, 234, 0.03), transparent);
        }

        /* Institutional Components */
        .glass-panel {
            background: var(--card-glass);
            border: 1px solid var(--border-glass);
            backdrop-filter: blur(10px);
        }

        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0 4px;
        }

        .nav-link.active-link {
            background: rgba(147, 51, 234, 0.1);
            color: #fff !important;
            box-shadow: inset 0 0 20px rgba(147, 51, 234, 0.05);
        }

        .nav-link.active-link::before {
            content: "";
            position: absolute;
            left: -12px;
            top: 4px;
            bottom: 4px;
            width: 4px;
            background: var(--accent-gradient);
            border-radius: 0 4px 4px 0;
            box-shadow: 4px 0 15px rgba(147, 51, 234, 0.4);
        }

        .nav-link:not(.active-link):hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }

        /* Perfect Inputs */
        .perfect-input {
            background: var(--input-bg) !important;
            border: 1px solid var(--border-glass) !important;
            color: var(--text-white) !important;
            transition: all 0.3s ease;
        }
        .perfect-input:focus {
            border-color: rgba(147, 51, 234, 0.3) !important;
            background: var(--input-bg) !important;
            box-shadow: 0 0 0 4px rgba(147, 51, 234, 0.1);
        }

        /* Custom Scrollbar for Institutional Feel */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--scrollbar-thumb); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--scrollbar-thumb); filter: brightness(1.2); }

        .sidebar-text { transition: opacity 0.3s ease; }
        .collapsed .sidebar-text { opacity: 0; pointer-events: none; }

        @media (max-width: 1023px) {
            .collapsed .sidebar-text { opacity: 1; pointer-events: auto; }
        }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white">

    <div class="dashboard-container" id="dash-layout">
        
        <!-- Mobile Sidebar Backdrop -->
        <div class="mobile-sidebar-backdrop lg:hidden" id="sidebar-backdrop"></div>

        <!-- SIDEBAR -->
        <aside class="sidebar py-10 px-6 flex flex-col gap-14 overflow-hidden">
            <!-- Logo area -->
            <a href="{{ url('/') }}" class="flex items-center gap-4 px-2 overflow-visible shrink-0 group">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-[1.2rem] flex items-center justify-center shadow-[0_0_30px_rgba(147,51,234,0.2)] group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                    <i data-lucide="zap" class="w-6 h-6 text-white fill-white animate-pulse"></i>
                </div>
                <div class="orbitron font-black text-xl italic tracking-tighter sidebar-text flex flex-col leading-none" style="color: var(--logo-text)">
                    <span class="text-white text-lg">EMPEROR</span>
                    <span class="text-purple-500 text-sm tracking-[0.2em] -mt-1 uppercase not-italic font-bold">PREDICTOR</span>
                </div>
            </a>

            <!-- Nav -->
            <nav class="flex-1 flex flex-col gap-1">
                @php
                    $navItems = [
                        // ['icon' => 'layout-dashboard', 'label' => 'Terminal', 'url' => url('/terminal'), 'active' => Request::is('terminal*')],
                        ['icon' => 'activity', 'label' => 'Signals', 'url' => url('/signals'), 'active' => Request::is('signals*')],
                        ['icon' => 'gift', 'label' => 'Refer & Earn', 'url' => route('account.referral'), 'active' => Request::is('account/referral*')],
                        ['icon' => 'credit-card', 'label' => 'Link History', 'url' => route('account.subscription-history'), 'active' => Request::is('account/history*')],
                        ['icon' => 'settings', 'label' => 'Settings', 'url' => route('account.profile'), 'active' => Request::is('account/profile*')],
                    ];
                @endphp

                @foreach($navItems as $item)
                <a href="{{ $item['url'] }}" class="nav-link flex items-center gap-4 px-4 py-3.5 rounded-xl hover:bg-[var(--nav-hover-bg)] group {{ $item['active'] ? 'active-link' : '' }}" style="color: var(--nav-text)">
                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 shrink-0 group-hover:scale-110 transition-transform"></i>
                    <span class="text-sm font-semibold sidebar-text whitespace-nowrap tracking-wide">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <!-- Bottom Action -->
            <div class="px-2 mt-auto">
                <button id="sidebar-toggle" class="w-full flex items-center gap-4 px-2 sm:px-4 py-3.5 rounded-2xl bg-white/[0.03] border border-white/10 hover:bg-white/[0.06] hover:border-purple-500/30 transition-all group overflow-hidden relative shadow-lg shadow-black/20" style="color: var(--nav-text)">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="w-6 h-6 rounded-lg bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-purple-500/10 group-hover:text-purple-400 transition-colors">
                        <i data-lucide="chevron-left" class="w-4 h-4" id="toggle-icon"></i>
                    </div>
                    <span class="text-[10px] font-black orbitron uppercase tracking-[0.2em] sidebar-text whitespace-nowrap">Collapse System</span>
                </button>
            </div>
        </aside>

        <!-- HEADER -->
        <header class="header px-4 sm:px-10 py-5 flex items-center justify-between sticky top-0 gap-4">
            <!-- Mobile sidebar toggle -->
            <button class="lg:hidden w-10 h-10 rounded-xl border border-white/[0.05] flex items-center justify-center text-gray-400 hover:text-[var(--text-white)] transition-all shrink-0" style="background: var(--input-bg)" id="mobile-sidebar-toggle">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <div class="flex items-center gap-10 flex-1">
                <!-- Global Navigation Integrations (desktop only) -->
                <div class="hidden xl:flex items-center gap-7 pr-10 border-r border-white/10">
                    <a href="{{ url('/') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron hover:text-purple-500 transition-all uppercase tracking-widest whitespace-nowrap" style="color: var(--nav-text)">
                        <i data-lucide="home" class="w-3.5 h-3.5 transition-colors"></i> Home
                    </a>
                    <a href="{{ url('/about') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron hover:text-purple-500 transition-all uppercase tracking-widest whitespace-nowrap" style="color: var(--nav-text)">
                        <i data-lucide="info" class="w-3.5 h-3.5 transition-colors"></i> About
                    </a>
                    {{-- <a href="{{ url('/terminal/free') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="bar-chart-2" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> Signals
                    </a> --}}
                    {{-- <a href="{{ url('/terminal/premium') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> Tips
                    </a> --}}
                </div>

                <div class="relative max-w-md w-full group hidden sm:block">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-purple-500 transition-colors"></i>
                    <input type="text" placeholder="Search parameters, signals, or help..." 
                           class="w-full border border-white/[0.05] rounded-xl py-3 pl-12 pr-4 text-[11px] font-medium focus:outline-none focus:border-purple-500/30 transition-all placeholder:text-gray-600"
                           style="background: var(--input-bg); color: var(--text-white)">
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-8">
                <!-- Theme/Status -->
                <div class="flex items-center gap-1 p-1 rounded-xl border border-white/[0.05] theme-toggle-container" style="background: var(--input-bg)">
                    <button id="dark-theme-btn" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all bg-purple-600 text-white shadow-lg">
                        <i data-lucide="moon" class="w-4 h-4"></i>
                    </button>
                    <button id="light-theme-btn" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all text-gray-600 hover:text-[var(--text-white)]">
                        <i data-lucide="sun" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Notifications -->
                <button class="relative w-11 h-11 rounded-xl border border-white/[0.05] flex items-center justify-center text-gray-400 hover:text-[var(--text-white)] transition-all group" style="background: var(--input-bg)">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-3 right-3 w-2 h-2 bg-purple-500 rounded-full shadow-[0_0_10px_#9333ea]"></span>
                </button>

                <!-- Profile -->
                <div class="relative group/user">
                    <button class="flex items-center gap-4 py-1.5 pl-1.5 pr-5 rounded-2xl border border-white/[0.08] hover:bg-white/[0.08] hover:border-purple-500/40 hover:shadow-[0_0_20px_rgba(147,51,234,0.15)] transition-all duration-300 group-hover/user:scale-[1.02]" style="background: var(--input-bg)">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-xs font-black orbitron text-white italic shadow-lg group-hover/user:shadow-purple-500/20 transition-all overflow-hidden relative">
                            <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : '' }}" 
                                 alt="User" 
                                 class="w-full h-full object-cover global-user-photo {{ !Auth::user()->profile_photo ? 'hidden' : '' }}">
                            <span class="global-user-initial {{ Auth::user()->profile_photo ? 'hidden' : '' }}">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                        </div>
                        <div class="text-left hidden lg:block">
                            <p class="global-username text-[11px] font-black uppercase tracking-tight group-hover/user:text-purple-400 transition-colors" style="color: var(--text-white)">{{ Auth::user()->username }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-emerald-500 shadow-[0_0_5px_#10b981]"></span>
                                <span class="text-[8px] font-bold orbitron text-emerald-500 tracking-widest uppercase">ACCOUNT ACTIVE</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-600 group-hover/user:text-white group-hover/user:rotate-180 transition-all duration-300"></i>
                    </button>

                    <div class="absolute right-0 top-full mt-3 w-56 rounded-2xl border border-white/[0.08] overflow-hidden opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-all translate-y-2 group-hover/user:translate-y-0 shadow-[0_20px_50px_rgba(0,0,0,0.8),0_0_20px_rgba(147,51,234,0.1)] z-[2000]" style="background: var(--dropdown-bg)">
                        <div class="p-4 border-b border-white/[0.05]">
                            <p class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Signed in as</p>
                            <p class="text-[11px] font-bold mt-1" style="color: var(--text-white)">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-white/[0.05] rounded-xl text-[10px] font-bold orbitron uppercase transition-all" style="color: var(--text-muted)">
                                <i data-lucide="settings-2" class="w-4 h-4 text-purple-500"></i> Settings
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-white/[0.05] rounded-xl text-[10px] font-bold orbitron uppercase transition-all" style="color: var(--text-muted)">
                                <i data-lucide="credit-card" class="w-4 h-4 text-amber-500"></i> Subscription
                            </a>
                            <div class="h-px bg-white/[0.05] my-2 mx-2"></div>
                             <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-rose-500/10 rounded-xl text-[10px] font-black orbitron text-rose-500 uppercase text-left transition-all">
                                    <i data-lucide="power" class="w-4 h-4"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="max-w-[1600px] mx-auto p-4 sm:p-8 lg:p-12">
                @yield('content')
            </div>
        </main>

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

        // Theme Toggle Logic
        const darkBtn = document.getElementById('dark-theme-btn');
        const lightBtn = document.getElementById('light-theme-btn');
        const body = document.body;

        function setTheme(theme) {
            if (theme === 'light') {
                body.classList.add('light-mode');
                lightBtn.classList.add('bg-purple-600', 'text-white', 'shadow-lg');
                lightBtn.classList.remove('text-gray-600', 'hover:text-[var(--text-white)]');
                darkBtn.classList.remove('bg-purple-600', 'text-white', 'shadow-lg');
                darkBtn.classList.add('text-gray-600', 'hover:text-[var(--text-white)]');
            } else {
                body.classList.remove('light-mode');
                darkBtn.classList.add('bg-purple-600', 'text-white', 'shadow-lg');
                darkBtn.classList.remove('text-gray-600', 'hover:text-[var(--text-white)]');
                lightBtn.classList.remove('bg-purple-600', 'text-white', 'shadow-lg');
                lightBtn.classList.add('text-gray-600', 'hover:text-[var(--text-white)]');
            }
            localStorage.setItem('theme', theme);
        }

        darkBtn.addEventListener('click', () => setTheme('dark'));
        lightBtn.addEventListener('click', () => setTheme('light'));

        // Load persisted theme
        const savedTheme = localStorage.getItem('theme') || 'dark';
        setTheme(savedTheme);

        // Desktop Sidebar Toggle
        const dashLayout = document.getElementById('dash-layout');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const toggleIcon = document.getElementById('toggle-icon');

        sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth >= 1024) {
                dashLayout.classList.toggle('collapsed');
                const isCollapsed = dashLayout.classList.contains('collapsed');
                toggleIcon.setAttribute('data-lucide', isCollapsed ? 'chevron-right' : 'chevron-left');
                lucide.createIcons();
            } else {
                // On mobile, close sidebar
                const sidebar = document.querySelector('.sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                sidebar.classList.remove('mobile-open');
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
                if (typeof lenis !== 'undefined') lenis.start();
            }
        });

        // Mobile Sidebar Toggle
        const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function openMobileSidebar() {
            sidebar.classList.add('mobile-open');
            sidebarBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            if (typeof lenis !== 'undefined') lenis.stop();
        }

        function closeMobileSidebar() {
            sidebar.classList.remove('mobile-open');
            sidebarBackdrop.classList.remove('active');
            document.body.style.overflow = '';
            if (typeof lenis !== 'undefined') lenis.start();
        }

        mobileSidebarToggle.addEventListener('click', openMobileSidebar);
        sidebarBackdrop.addEventListener('click', closeMobileSidebar);

        // Close mobile sidebar on nav link click
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) closeMobileSidebar();
            });
        });

        // Global scroll refresh on load
        window.addEventListener('load', () => {
            setTimeout(() => { if (typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh(); }, 500);
        });
    </script>
    @stack('scripts')
</body>
</html>

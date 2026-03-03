<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Terminal | AlgoTrade AI')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #020105;
            --bg-sidebar: rgba(10, 5, 20, 0.4);
            --accent-purple: #9333ea;
            --accent-indigo: #6366f1;
            --accent-gold: #fbbf24;
            --card-glass: rgba(255, 255, 255, 0.02);
            --border-glass: rgba(255, 255, 255, 0.05);
        }

        body {
            background-color: var(--bg-deep);
            color: #d1d5db;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }

        /* Main Dashboard Grid */
        .dashboard-container {
            display: grid;
            grid-template-areas: 
                "sidebar header"
                "sidebar main";
            grid-template-columns: 280px 1fr;
            grid-template-rows: auto 1fr;
            height: 100vh;
            width: 100vw;
            transition: grid-template-columns 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dashboard-container.collapsed {
            grid-template-columns: 88px 1fr;
        }

        /* Sidebar Styling */
        .sidebar {
            grid-area: sidebar;
            background: var(--bg-sidebar);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-glass);
            display: flex;
            flex-col;
            z-index: 100;
        }

        /* Header Styling */
        .header {
            grid-area: header;
            background: rgba(2, 1, 5, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-glass);
            z-index: 90;
        }

        /* Content Area */
        .main-content {
            grid-area: main;
            overflow-y: auto;
            overflow-x: hidden;
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
        }

        .nav-link.active-link {
            background: rgba(147, 51, 234, 0.08);
            color: #fff !important;
        }

        .nav-link.active-link::before {
            content: "";
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: var(--accent-purple);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px var(--accent-purple);
        }

        /* Perfect Inputs */
        .perfect-input {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.07) !important;
            transition: all 0.3s ease;
        }
        .perfect-input:focus {
            border-color: rgba(147, 51, 234, 0.3) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 0 0 4px rgba(147, 51, 234, 0.1);
        }

        /* Custom Scrollbar for Institutional Feel */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.05); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.1); }

        .sidebar-text { transition: opacity 0.3s ease; }
        .collapsed .sidebar-text { opacity: 0; pointer-events: none; }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white">

    <div class="dashboard-container" id="dash-layout">
        
        <!-- SIDEBAR -->
        <aside class="sidebar py-8 px-6 flex flex-col gap-12 sticky top-0 overflow-hidden">
            <!-- Logo area -->
            <a href="{{ url('/') }}" class="flex items-center gap-4 px-2 overflow-hidden shrink-0 group">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                    <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                </div>
                <div class="orbitron font-black text-xl italic tracking-tighter sidebar-text text-white">
                    ALGO<span class="text-purple-500">TRADE</span>
                </div>
            </a>

            <!-- Nav -->
            <nav class="flex-1 flex flex-col gap-1">
                @php
                    $navItems = [
                        ['icon' => 'layout-dashboard', 'label' => 'Terminal', 'url' => url('/terminal')],
                        ['icon' => 'pie-chart', 'label' => 'Portfolio', 'url' => '#'],
                        ['icon' => 'activity', 'label' => 'Signals', 'url' => url('/terminal/free')],
                        ['icon' => 'arrow-left-right', 'label' => 'Wallet', 'url' => '#'],
                        ['icon' => 'settings', 'label' => 'Settings', 'url' => route('account.profile'), 'active' => true],
                    ];
                @endphp

                @foreach($navItems as $item)
                <a href="{{ $item['url'] }}" class="nav-link flex items-center gap-4 px-4 py-3.5 rounded-xl text-gray-500 hover:text-white hover:bg-white/[0.03] group {{ isset($item['active']) ? 'active-link' : '' }}">
                    <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5 shrink-0 group-hover:scale-110 transition-transform"></i>
                    <span class="text-[10px] font-black orbitron uppercase tracking-[0.15em] sidebar-text whitespace-nowrap">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            <!-- Bottom Action -->
            <div class="px-2">
                <button id="sidebar-toggle" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl bg-white/[0.03] border border-white/[0.05] text-gray-500 hover:text-white transition-all group">
                    <i data-lucide="chevron-left" class="w-4 h-4 shrink-0" id="toggle-icon"></i>
                    <span class="text-[9px] font-bold orbitron uppercase tracking-widest sidebar-text">Collapse Panel</span>
                </button>
            </div>
        </aside>

        <!-- HEADER -->
        <header class="header px-10 py-5 flex items-center justify-between sticky top-0">
            <div class="flex items-center gap-10 flex-1">
                <!-- Global Navigation Integrations -->
                <div class="hidden xl:flex items-center gap-7 pr-10 border-r border-white/10">
                    <a href="{{ url('/') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="home" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> Home
                    </a>
                    <a href="{{ url('/about') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="info" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> About
                    </a>
                    <a href="{{ url('/terminal/free') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="bar-chart-2" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> Signals
                    </a>
                    <a href="{{ url('/terminal/premium-tips') }}" class="group flex items-center gap-2 text-[10px] font-bold orbitron text-gray-500 hover:text-white transition-all uppercase tracking-widest whitespace-nowrap">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 group-hover:text-purple-500 transition-colors"></i> Tips
                    </a>
                </div>

                <div class="relative max-w-md w-full group">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 group-focus-within:text-purple-500 transition-colors"></i>
                    <input type="text" placeholder="Search parameters, signals, or help..." 
                           class="w-full bg-white/[0.03] border border-white/[0.05] rounded-xl py-3 pl-12 pr-4 text-[11px] font-medium text-white focus:outline-none focus:border-purple-500/30 transition-all placeholder:text-gray-600">
                </div>
            </div>

            <div class="flex items-center gap-8">
                <!-- Theme/Status -->
                <div class="flex items-center gap-4 p-1 rounded-xl bg-white/[0.03] border border-white/[0.05]">
                    <button class="w-8 h-8 rounded-lg bg-purple-600/10 text-purple-400 flex items-center justify-center">
                        <i data-lucide="moon" class="w-4 h-4"></i>
                    </button>
                    <button class="w-8 h-8 rounded-lg text-gray-600 hover:text-gray-400 flex items-center justify-center">
                        <i data-lucide="sun" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Notifications -->
                <button class="relative w-11 h-11 rounded-xl bg-white/[0.03] border border-white/[0.05] flex items-center justify-center text-gray-400 hover:text-white transition-all group">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <span class="absolute top-3 right-3 w-2 h-2 bg-purple-500 rounded-full shadow-[0_0_10px_#9333ea]"></span>
                </button>

                <!-- Profile -->
                <div class="relative group/user">
                    <button class="flex items-center gap-4 py-1.5 pl-1.5 pr-5 rounded-2xl border border-white/[0.05] bg-white/[0.02] hover:bg-white/[0.05] transition-all">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-xs font-black orbitron text-white italic shadow-lg">
                            {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                        </div>
                        <div class="text-left hidden lg:block">
                            <p class="text-[11px] font-black text-white uppercase tracking-tight">{{ Auth::user()->username }}</p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                <span class="text-[8px] font-bold orbitron text-emerald-500 tracking-widest uppercase">ACTIVE NODE</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-gray-600 group-hover/user:text-white transition-colors"></i>
                    </button>

                    <div class="absolute right-0 top-full mt-3 w-56 glass-panel rounded-2xl border border-white/[0.08] overflow-hidden opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-all translate-y-2 group-hover/user:translate-y-0 shadow-2xl z-[110]">
                        <div class="p-4 border-b border-white/[0.05]">
                            <p class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Signed in as</p>
                            <p class="text-[11px] font-bold text-white mt-1">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="p-2">
                            <a href="{{ route('account.profile') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-white/[0.05] rounded-xl text-[10px] font-bold orbitron text-gray-300 uppercase transition-all">
                                <i data-lucide="settings-2" class="w-4 h-4 text-purple-500"></i> Settings
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-white/[0.05] rounded-xl text-[10px] font-bold orbitron text-gray-300 uppercase transition-all">
                                <i data-lucide="credit-card" class="w-4 h-4 text-amber-500"></i> Subscription
                            </a>
                            <div class="h-px bg-white/[0.05] my-2 mx-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 hover:bg-rose-500/10 rounded-xl text-[10px] font-black orbitron text-rose-500 uppercase text-left transition-all">
                                    <i data-lucide="power" class="w-4 h-4"></i> Terminate
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="max-w-[1600px] mx-auto p-12">
                @yield('content')
            </div>
        </main>

    </div>

    <script>
        lucide.createIcons();

        // Sidebar Toggle
        const dashLayout = document.getElementById('dash-layout');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const toggleIcon = document.getElementById('toggle-icon');

        sidebarToggle.addEventListener('click', () => {
            dashLayout.classList.toggle('collapsed');
            const isCollapsed = dashLayout.classList.contains('collapsed');
            toggleIcon.setAttribute('data-lucide', isCollapsed ? 'chevron-right' : 'chevron-left');
            lucide.createIcons();
        });

        // Initialize tooltips/animations if needed
    </script>
    @stack('scripts')
</body>
</html>

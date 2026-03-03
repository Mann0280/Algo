<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | AlgoTrade AI</title>
    
    <!-- Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #05020a;
            --accent-purple: #9333ea;
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
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
    </style>
    @stack('styles')
</head>
<body class="bg-[#05020a] text-white">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 border-r border-white/5 bg-black/40 backdrop-blur-xl p-8 flex flex-col gap-10 sticky top-0 h-screen">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                </div>
                <div class="orbitron font-black text-xl italic tracking-tighter">
                    ALGO <span class="text-purple-500">ADMIN</span>
                </div>
            </div>

            <nav class="flex-1 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/20' : 'text-gray-500 hover:text-white hover:bg-white/5' }} transition-all group">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-widest">Dashboard</span>
                </a>
                <a href="{{ route('admin.predictions.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl {{ request()->routeIs('admin.predictions.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/20' : 'text-gray-500 hover:text-white hover:bg-white/5' }} transition-all group">
                    <i data-lucide="zap" class="w-5 h-5"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-widest">Signals</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-gray-500 hover:text-white hover:bg-white/5 transition-all group">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-widest">Users</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-gray-500 hover:text-white hover:bg-white/5 transition-all group">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-widest">Settings</span>
                </a>
            </nav>

            <div class="pt-8 border-t border-white/5">
                <a href="{{ route('home') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl text-gray-500 hover:text-white hover:bg-white/5 transition-all group">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    <span class="orbitron text-[10px] font-bold uppercase tracking-widest">View Site</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-rose-500/70 hover:text-rose-500 hover:bg-rose-500/5 transition-all group">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span class="orbitron text-[10px] font-bold uppercase tracking-widest">Lock Down</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-12">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

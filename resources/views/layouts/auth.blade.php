<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emperor Stock Predictor')</title>
    
    <!-- Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #05020a;
            --accent-purple: #9333ea;
            --accent-blue: #6366f1;
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(147, 51, 234, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.04);
        }

        .text-glow {
            text-shadow: 0 0 20px currentColor, 0 0 40px currentColor;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-15px) scale(1.02); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delayed { animation: float 7s ease-in-out infinite 1s; }
        .animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }

        .auth-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .auth-input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(147, 51, 234, 0.5);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1), 0 0 20px rgba(147, 51, 234, 0.1);
        }
        .auth-input::placeholder {
            color: rgba(255, 255, 255, 0.15);
        }

        .auth-btn {
            background: linear-gradient(135deg, #9333ea, #6366f1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .auth-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .auth-btn:hover::before {
            opacity: 1;
        }
        .auth-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 30px rgba(147, 51, 234, 0.4), 0 0 60px rgba(147, 51, 234, 0.15);
        }
        .auth-btn:active {
            transform: translateY(0) scale(0.98);
        }

        @keyframes shake { 
            0%, 100% { transform: translateX(0); } 
            25% { transform: translateX(-5px); } 
            75% { transform: translateX(5px); } 
        }
        .animate-shake { animation: shake 0.3s ease-in-out; }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white">

    <!-- Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-[#0a0514] via-[#050208] to-[#020105]"></div>
        <div class="absolute top-[-20%] left-[-15%] w-[500px] h-[500px] bg-purple-900/15 rounded-full blur-[150px] animate-pulse-slow"></div>
        <div class="absolute bottom-[-20%] right-[-15%] w-[500px] h-[500px] bg-indigo-900/15 rounded-full blur-[150px] animate-float-delayed"></div>
        <div class="absolute top-[40%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-purple-600/5 rounded-full blur-[100px] animate-float"></div>
    </div>

    <!-- Content -->
    <main class="relative z-10 min-h-screen flex items-center justify-center p-4 sm:p-6">
        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emperor Stock Predictor | Advanced Neural Trading Signals')</title>
    
    <!-- Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #05020a;
            --accent-purple: #9333ea;
            --accent-blue: #6366f1;
            --accent-gold: #fbbf24;
            --profit-green: #10b981;
            --loss-red: #ef4444;
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .orbitron { font-family: 'Orbitron', sans-serif; }

        .glass-panel {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .neon-glow {
            box-shadow: 0 0 60px -10px rgba(168, 85, 247, 0.3);
        }
        .premium-glow { border: 1px solid var(--accent-gold); box-shadow: 0 0 15px rgba(251, 191, 36, 0.2); }
        
        .text-gradient {
            background: linear-gradient(to right, #fff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .float-slow { animation: float 6s ease-in-out infinite; }
        .float-delayed { animation: float 7s ease-in-out infinite; animation-delay: 1s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-glow { animation: pulseGlow 2s infinite alternate; }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 10px rgba(168, 85, 247, 0.4); }
            100% { box-shadow: 0 0 25px rgba(168, 85, 247, 0.8); }
        }
        
        .rotate-slow { animation: rotateSlow 40s linear infinite; }
        @keyframes rotateSlow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .fade-in-up { opacity: 0; transform: translateY(30px); }
        .slide-in-right { opacity: 0; transform: translateX(30px); }

        .scroll-progress {
            position: fixed; top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(to right, var(--accent-purple), var(--accent-blue));
            z-index: 10000;
        }

        .price-up { animation: flashGreen 1.5s ease-out; }
        .price-down { animation: flashRed 1.5s ease-out; }
        @keyframes flashGreen { 0% { color: var(--profit-green); text-shadow: 0 0 10px var(--profit-green); } 100% { color: white; text-shadow: none; } }
        @keyframes flashRed { 0% { color: var(--loss-red); text-shadow: 0 0 10px var(--loss-red); } 100% { color: white; text-shadow: none; } }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white overflow-x-hidden">
    <div class="scroll-progress"></div>

    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[#0a0514] via-[#050208] to-[#020105]"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] bg-purple-900/10 rounded-full blur-[120px] pulse-glow"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-blue-900/10 rounded-full blur-[120px] float-delayed"></div>
        <div class="absolute top-1/4 left-1/4 w-[400px] h-[400px] bg-gradient-to-br from-purple-600/5 to-transparent rounded-full rotate-slow"></div>
    </div>

    @include('layouts.navbar')

    <main class="relative z-10 pt-24 sm:pt-32 w-full overflow-x-hidden">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script>
        lucide.createIcons();
        const lenis = new Lenis();
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
        
        gsap.to(".scroll-progress", {
            width: "100%",
            ease: "none",
            scrollTrigger: { scrub: 0.3 }
        });
    </script>
    @stack('scripts')
</body>
</html>

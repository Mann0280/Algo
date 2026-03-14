<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emperor Stock Predictor | Advanced Neural Trading Signals')</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #0a0b14;
            --accent-purple: #9333ea;
            --accent-magenta: #d946ef;
            --accent-blue: #3b82f6;
            --accent-gold: #eab308;
            --profit-green: #22c55e;
            --loss-red: #ef4444;
            --whiskey-gold: #ffffff;
            --vibrant-gradient: linear-gradient(90deg, #9333ea 0%, #d946ef 100%);
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            width: 100%;
        }

        html.lenis {
            height: auto;
        }

        .lenis.lenis-smooth {
            scroll-behavior: auto;
        }

        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }

        .lenis.lenis-stopped {
            overflow: hidden;
        }

        .lenis.lenis-scrolling iframe {
            pointer-events: none;
        }

        .font-whiskey { 
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            letter-spacing: -0.05em;
            color: white;
        }

        .font-professional {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: normal;
            color: white;
        }

        .text-vibrant {
            background: var(--vibrant-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .font-bold-tight {
            font-weight: 800;
            letter-spacing: -0.05em;
            text-transform: uppercase;
        }
        
        .text-gradient {
            background: var(--vibrant-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .neon-glow {
            box-shadow: 0 0 40px -10px rgba(139, 92, 246, 0.2);
        }
        .premium-glow { border: 1px solid var(--accent-gold); box-shadow: 0 0 15px rgba(251, 191, 36, 0.2); }
        
        /* Universal Table Scroll Wrapper */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
        }
        .table-wrapper::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
        .tabulator { 
            /* min-width: 900px !important;  */
            width: 100% !important;
            background: transparent !important;
            border: none !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .tabulator .tabulator-header { 
            white-space: nowrap !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            background: rgba(20, 15, 35, 0.4) !important;
            width: 100% !important;
        }
        .tabulator .tabulator-cell { 
            white-space: nowrap !important;
        }
        .tabulator-tableHolder {
            overflow-x: hidden !important; /* Wrapper handles content scroll */
            width: 100% !important;
        }
        /* Hide inner scrollbars */
        .tabulator-tableHolder::-webkit-scrollbar,
        .tabulator-header::-webkit-scrollbar {
            display: none !important;
        }
        .tabulator-header {
            overflow: hidden !important;
        }
        
        /* Persistent Bottom-Right Sticky Footer */
        .tabulator-footer {
            position: sticky !important;
            left: 0 !important;
            bottom: 0 !important;
            width: 100vw !important; /* Cover viewport width */
            max-width: 100vw !important;
            background: rgba(10, 5, 20, 0.98) !important;
            backdrop-filter: blur(15px) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            display: flex !important;
            justify-content: flex-end !important; /* Pin to right corner */
            z-index: 1000 !important;
            margin: 0 !important;
            padding: 0 10px !important; /* Small side padding */
        }
        
        /* Ensure the wrapper doesn't clip the table */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Clean pagination buttons */
        .tabulator-footer .tabulator-paginator {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 4px !important;
            padding: 10px 0 !important;
        }
        .tabulator-footer .tabulator-page, 
        .tabulator-footer .tabulator-paginator button {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.1) !important;
            color: #ccc !important;
            border-radius: 8px !important;
            padding: 5px 12px !important;
            font-size: 11px !important;
            font-weight: 900 !important;
            transition: all 0.2s ease !important;
        }
        .tabulator-footer .tabulator-page.active {
            background: linear-gradient(135deg, #7c3aed, #4f46e5) !important;
            color: white !important;
            border-color: rgba(255,255,255,0.2) !important;
            box-shadow: 0 0 15px rgba(124,58,237,0.3);
        }

        .float-slow { animation: float 6s ease-in-out infinite; }
        .float-delayed { animation: float 7s ease-in-out infinite; animation-delay: 1s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .pulse-glow { animation: pulseGlow 3s infinite alternate; }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 8px rgba(139, 92, 246, 0.2); }
            100% { box-shadow: 0 0 15px rgba(139, 92, 246, 0.4); }
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

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background: #25D366;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: whatsappPulse 2.5s infinite;
        }

        .whatsapp-float:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-icon {
            width: 34px;
            height: 34px;
        }

        @keyframes whatsappPulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white">
    <div class="scroll-progress"></div>

    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[#0a0514] via-[#050208] to-[#020105]"></div>
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] bg-purple-900/10 rounded-full blur-[120px] pulse-glow"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[600px] h-[600px] bg-blue-900/10 rounded-full blur-[120px] float-delayed"></div>
        <div class="absolute top-1/4 left-1/4 w-[400px] h-[400px] bg-gradient-to-br from-purple-600/5 to-transparent rounded-full rotate-slow"></div>
    </div>

    @include('layouts.navbar')

    <main class="relative z-10 pt-16 sm:pt-20 w-full overflow-x-hidden">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script>
        lucide.createIcons();
        
        // Initialize Lenis
        const lenis = new Lenis();
        
        // Sync Lenis with ScrollTrigger
        lenis.on('scroll', ScrollTrigger.update);
        
        gsap.ticker.add((time) => {
            lenis.raf(time * 1000);
        });
        
        gsap.ticker.lagSmoothing(0);

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

        // Global scroll refresh on load
        window.addEventListener('load', () => {
            setTimeout(() => ScrollTrigger.refresh(), 500);
        });
    </script>
    @stack('scripts')

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', App\Models\SiteSetting::getValue('whatsapp_number', '91XXXXXXXXXX')) }}" 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat on WhatsApp">
        <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png" 
             alt="WhatsApp" 
             class="whatsapp-icon">
    </a>
</body>
</html>

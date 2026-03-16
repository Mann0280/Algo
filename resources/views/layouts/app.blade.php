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


        .price-up { animation: flashGreen 1.5s ease-out; }
        .price-down { animation: flashRed 1.5s ease-out; }
        @keyframes flashGreen { 0% { color: var(--profit-green); text-shadow: 0 0 10px var(--profit-green); } 100% { color: white; text-shadow: none; } }
        @keyframes flashRed { 0% { color: var(--loss-red); text-shadow: 0 0 10px var(--loss-red); } 100% { color: white; text-shadow: none; } }

        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed !important;
            bottom: 30px !important;
            right: 30px !important;
            z-index: 999999 !important;
            background: #25D366;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            animation: whatsappPulse 2.5s infinite;
        }

        .whatsapp-float:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }

        .whatsapp-icon {
            width: 32px;
            height: 32px;
            fill: #ffffff;
        }

        @keyframes whatsappPulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
            70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
            100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
        }

        /* Hide floating button when mobile menu is active with smooth transition */
        .whatsapp-float-hardcoded {
            transition: opacity 0.3s ease, visibility 0.3s ease !important;
        }

        body.menu-open .whatsapp-float,
        body.menu-open .whatsapp-float-hardcoded {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
    </style>
    @stack('styles')
</head>
<body class="selection:bg-purple-500 selection:text-white">

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
        

        // Global scroll refresh on load
        window.addEventListener('load', () => {
            setTimeout(() => ScrollTrigger.refresh(), 500);
        });
    </script>
    @stack('scripts')

    <!-- WhatsApp Floating Button -->
    @if (!request()->is('account/*'))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', App\Models\SiteSetting::getValue('whatsapp_number', '91XXXXXXXXXX')) }}" 
       style="position: fixed !important; bottom: 30px !important; right: 30px !important; z-index: 99999999 !important; background-color: #25d366 !important; width: 60px !important; height: 60px !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; box-shadow: 0 10px 25px rgba(37,211,102,0.4) !important;"
       class="whatsapp-float-hardcoded hover:scale-110 transition-transform duration-300"
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" style="width: 35px !important; height: 35px !important; fill: white !important;" viewBox="0 0 24 24">
            <path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.124.553 4.195 1.594 6.021L.188 23.813l5.885-1.547a11.968 11.968 0 0 0 5.958 1.594h.005c6.641 0 12.031-5.385 12.031-12.031 0-6.646-5.385-12.031-12.036-12.031zM19.042 16.927c-.292.818-1.464 1.563-2.026 1.636-.542.068-1.182.26-3.76-.807-3.13-1.296-5.141-4.526-5.292-4.729-.151-.203-1.266-1.688-1.266-3.219 0-1.531.792-2.286 1.078-2.589.286-.302.625-.375.833-.375s.417 0 .599.01c.193.01.448-.073.703.542.266.646.911 2.224.995 2.391.083.167.141.359.036.568-.104.208-.156.339-.313.526-.156.188-.328.396-.469.542-.156.167-.318.354-.135.672.182.318.813 1.349 1.745 2.177 1.203 1.073 2.193 1.406 2.516 1.563.323.156.51.135.703-.094.193-.229.833-.969 1.057-1.302.224-.333.443-.276.734-.167.292.109 1.844.87 2.156 1.026.313.156.521.234.599.365.078.13.078.755-.214 1.573z"/>
        </svg>
    </a>
    @endif
</body>
</html>

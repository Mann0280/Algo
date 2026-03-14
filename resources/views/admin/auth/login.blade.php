<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Admin Panel</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-deep: #05020a;
            --accent-purple: #9333ea;
        }

        body {
            background-color: var(--bg-deep);
            color: white;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .font-whiskey { 
            font-family: inherit; 
            font-weight: 900;
            letter-spacing: -0.05em;
            color: #d4af37;
            text-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glow-orb {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(147, 51, 234, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(50px);
            z-index: -1;
        }

        .text-glow {
            text-shadow: 0 0 20px rgba(147, 51, 234, 0.5);
        }

        input:focus {
            box-shadow: 0 0 15px rgba(147, 51, 234, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    
    <!-- Background Decor -->
    <div class="glow-orb -top-20 -left-20"></div>
    <div class="glow-orb -bottom-20 -right-20"></div>

    <div class="w-full max-w-md space-y-8 relative z-10">
        <!-- Logo -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 shadow-[0_0_30px_rgba(147,51,234,0.3)] mb-6">
                <i data-lucide="shield-check" class="w-10 h-10 text-white"></i>
            </div>
            <h1 class="font-whiskey font-black text-3xl italic tracking-tighter uppercase mb-2">
                ADMIN <span class="text-purple-500 text-glow">PANEL</span>
            </h1>
            <p class="text-gray-500 text-[10px] font-semibold font-whiskey uppercase tracking-widest">Secure login for administrators</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-[2.5rem] border border-white/5 p-10 space-y-8 shadow-2xl">
            @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-xl space-y-1">
                @foreach($errors->all() as $error)
                <p class="text-[10px] font-bold font-whiskey text-rose-500 uppercase tracking-widest text-center">{{ $error }}</p>
                @endforeach
            </div>
            @endif

            @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-xl">
                <p class="text-[10px] font-bold font-whiskey text-rose-500 uppercase tracking-widest text-center">{{ session('error') }}</p>
            </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest px-2">Email Address</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="email" name="email" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white text-sm outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700"
                               placeholder="admin@emperorstock.ai">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest px-2">Password</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-12 text-white text-sm outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700">
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition-colors">
                            <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black font-whiskey uppercase tracking-[0.2em] text-xs hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-500/20 italic mt-4">
                    Login to Dashboard
                </button>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="text-[10px] font-bold font-whiskey text-gray-500 hover:text-white uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-3 h-3"></i> Back to Homepage
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>

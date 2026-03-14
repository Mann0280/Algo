@extends('layouts.auth')

@section('title', 'Login | Emperor Stock Predictor')

@section('content')
<div class="w-full max-w-[420px] animate-in fade-in slide-in-from-bottom-6 duration-700">
    <div class="glass-card rounded-[2.5rem] p-8 sm:p-10 relative overflow-hidden group">
        <!-- Ambient glow -->
        <div class="absolute -top-16 -right-16 w-40 h-40 bg-purple-600/10 blur-[60px] rounded-full group-hover:bg-purple-600/20 transition-all duration-1000"></div>
        <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-indigo-600/10 blur-[50px] rounded-full"></div>

        <!-- Logo & Branding -->
        <div class="text-center mb-10 flex flex-col items-center relative z-10">
            <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/25 mb-5 group-hover:shadow-purple-500/40 transition-shadow duration-500">
                <i data-lucide="crown" class="w-7 h-7 text-white"></i>
            </div>
            <div class="font-whiskey font-black text-xl tracking-tight">
                <span class="text-white">EMPEROR</span> <span class="text-purple-500 text-glow">STOCK</span>
            </div>
            <p class="text-gray-600 text-[8px] font-bold font-whiskey uppercase tracking-[0.3em] mt-2">Welcome Back</p>
        </div>

        <!-- Errors -->
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/15 text-red-400 text-[9px] font-bold p-3.5 rounded-xl mb-6 text-center font-whiskey uppercase tracking-widest animate-shake">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5 relative z-10">
            @csrf
            <div class="space-y-1.5">
                <label class="block text-[9px] font-black text-gray-500 font-whiskey uppercase tracking-[0.2em] pl-1">Email Address</label>
                <div class="relative group/input">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-purple-500/8 flex items-center justify-center group-focus-within/input:bg-purple-500/15 transition-colors">
                        <i data-lucide="mail" class="w-3.5 h-3.5 text-purple-400/50"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@domain.com" 
                        class="auth-input w-full rounded-xl pl-[3.5rem] pr-5 py-4 text-sm font-medium text-white outline-none">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-[9px] font-black text-gray-500 font-whiskey uppercase tracking-[0.2em] pl-1">Password</label>
                <div class="relative group/input">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-purple-500/8 flex items-center justify-center group-focus-within/input:bg-purple-500/15 transition-colors">
                        <i data-lucide="lock" class="w-3.5 h-3.5 text-purple-400/50"></i>
                    </div>
                    <input type="password" id="password" name="password" required placeholder="••••••••" 
                        class="auth-input w-full rounded-xl pl-[3.5rem] pr-12 py-4 text-sm font-medium text-white outline-none">
                    <button type="button" onclick="togglePassword('password', 'eye-icon')" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 hover:text-purple-400 transition-colors focus:outline-none">
                        <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <button type="submit" id="loginSubmitBtn" class="auth-btn w-full py-4 rounded-xl text-white font-black font-whiskey text-[10px] tracking-[0.2em] uppercase italic flex items-center justify-center gap-2.5 mt-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                <span id="btnText">Sign In</span>
            </button>
            <div id="throttleMsg" class="hidden text-center mt-4 animate-in fade-in zoom-in duration-300">
                <p class="text-[9px] font-black font-whiskey text-purple-400 uppercase tracking-[0.2em]">
                    Security lock active. Next attempt in <span id="throttleTimer" class="text-white text-xs ml-1">30</span>s
                </p>
            </div>
        </form>

        <!-- Footer Link -->
        <p class="text-center mt-8 text-xs text-gray-500 relative z-10">
            Don't have an account? <a href="{{ route('register') }}" class="text-purple-400 font-bold hover:text-purple-300 hover:underline transition-colors">Sign Up</a>
        </p>

        <!-- Bottom Security Badge -->
        <div class="flex items-center justify-center gap-2 mt-6 relative z-10">
            <i data-lucide="shield-check" class="w-3 h-3 text-emerald-500/40"></i>
            <span class="text-[7px] font-bold font-whiskey text-gray-700 uppercase tracking-[0.2em]">Encrypted Session</span>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    // Button Throttle Logic
    document.addEventListener('DOMContentLoaded', () => {
        const loginForm = document.querySelector('form');
        const submitBtn = document.getElementById('loginSubmitBtn');
        const btnText = document.getElementById('btnText');
        const throttleMsg = document.getElementById('throttleMsg');
        const timerSpan = document.getElementById('throttleTimer');
        const THROTTLE_TIME = 30000; // 30 seconds
        const STORAGE_KEY = 'auth_login_throttle';

        const startCountdown = (remaining) => {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            throttleMsg.classList.remove('hidden');
            
            const timer = setInterval(() => {
                remaining -= 1000;
                const seconds = Math.ceil(remaining / 1000);
                timerSpan.textContent = seconds;

                if (remaining <= 0) {
                    clearInterval(timer);
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    btnText.textContent = 'Sign In';
                    throttleMsg.classList.add('hidden');
                    localStorage.removeItem(STORAGE_KEY);
                }
            }, 1000);
        };

        // Check if throttle is active on page load
        const lastSubmit = localStorage.getItem(STORAGE_KEY);
        if (lastSubmit) {
            const timePassed = Date.now() - parseInt(lastSubmit);
            if (timePassed < THROTTLE_TIME) {
                startCountdown(THROTTLE_TIME - timePassed);
            } else {
                localStorage.removeItem(STORAGE_KEY);
            }
        }

        loginForm.addEventListener('submit', (e) => {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            btnText.textContent = 'Authenticating...';
            localStorage.setItem(STORAGE_KEY, Date.now().toString());
        });
    });
</script>
@endsection

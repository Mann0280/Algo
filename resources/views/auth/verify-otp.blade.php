@extends('layouts.app')

@section('title', 'Verify Your Protocol')

@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4 relative overflow-hidden bg-[#05020a]">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-purple-900/20 blur-[120px] rounded-full animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-900/20 blur-[120px] rounded-full animate-pulse" style="animation-delay: 2s"></div>
    </div>

    <div class="w-full max-w-xl relative z-10 animate-in fade-in slide-in-from-bottom-8 duration-700">
        <div class="glass-card p-12 rounded-[3rem] border border-white/10 shadow-[0_0_100px_rgba(147,51,234,0.1)] text-center space-y-10">
            
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 rounded-3xl bg-white/5 border border-white/10 flex items-center justify-center mb-8 relative group">
                    <div class="absolute inset-0 bg-purple-500/20 blur-2xl rounded-full group-hover:bg-purple-500/40 transition-all duration-500"></div>
                    <i data-lucide="shield-check" class="w-10 h-10 text-purple-500 relative z-10"></i>
                </div>
                
                <h1 class="orbitron text-3xl font-black text-white italic uppercase tracking-tighter mb-4">
                    Email Security <span class="text-purple-500 text-glow">Verification</span>
                </h1>
                
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                    <span class="text-[9px] font-black orbitron text-purple-500 uppercase tracking-[0.4em]">Secure Action Required</span>
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                </div>
            </div>

            <div class="space-y-6">
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                    We have sent a secure 6-digit verification code to your email. Please enter it below to authorize this session.
                </p>

                @if (session('status'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black orbitron text-emerald-400 uppercase tracking-widest">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black orbitron text-emerald-400 uppercase tracking-widest">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                @error('otp')
                    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black orbitron text-red-500 uppercase tracking-widest">
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-8" id="otpForm">
                @csrf
                
                <div class="flex justify-center gap-3 md:gap-4" dir="ltr">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" name="otp[]" maxlength="1" required
                            class="otp-input w-12 h-14 md:w-14 md:h-16 text-center text-2xl font-black orbitron bg-[#0c0518] border border-white/10 rounded-xl md:rounded-2xl text-white outline-none focus:border-purple-500 focus:shadow-[0_0_15px_rgba(147,51,234,0.3)] transition-all"
                            autocomplete="off" pattern="[0-9]*" inputmode="numeric">
                    @endfor
                </div>

                <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black orbitron uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-900/40 italic flex items-center justify-center gap-3">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    Verify Access Protocol
                </button>
            </form>

            <div class="space-y-4 pt-4 border-t border-white/5">
                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" id="resendBtn" disabled class="text-[10px] font-black orbitron text-gray-500 hover:text-white uppercase tracking-[0.2em] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Resend Code <span id="timer" class="text-purple-500 ml-2">(60s)</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('register.cancel') }}">
                    @csrf
                    <button type="submit" class="text-[9px] font-black orbitron text-gray-700 hover:text-red-400 uppercase tracking-[0.3em] transition-all relative z-50">
                        Cancel Registration
                    </button>
                </form>
            </div>
            
            <div class="pt-6 border-t border-white/5">
                <p class="text-[8px] font-black orbitron text-gray-700 uppercase tracking-[0.3em]">
                    Algorithmic Security Layer v5.1 Active
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.otp-input');
        
        inputs.forEach((input, index) => {
            // Auto-focus next input
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            // Allow pasting full code
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').substring(0, 6);
                
                if (pastedData) {
                    for (let i = 0; i < pastedData.length; i++) {
                        if (inputs[i]) {
                            inputs[i].value = pastedData[i];
                        }
                    }
                    if (pastedData.length < 6) {
                        inputs[pastedData.length].focus();
                    } else {
                        inputs[5].focus();
                    }
                }
            });
        });

        // Initialize first input focus
        inputs[0].focus();

        // Timer Logic
        let timeLeft = 60;
        const timerElement = document.getElementById('timer');
        const resendBtn = document.getElementById('resendBtn');

        const updateTimer = () => {
            if (timeLeft > 0) {
                timerElement.innerText = `(${timeLeft}s)`;
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                timerElement.innerText = '';
                resendBtn.removeAttribute('disabled');
                resendBtn.classList.remove('text-gray-500');
                resendBtn.classList.add('text-purple-500');
            }
        };

        updateTimer();
    });
</script>
@endpush
@endsection

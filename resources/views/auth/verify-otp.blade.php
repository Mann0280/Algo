@extends('layouts.auth')

@section('title', 'Check Your Identity')

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
                
                <h1 class="font-whiskey text-3xl font-black text-white italic uppercase tracking-tighter mb-4">
                    Security <span class="text-purple-500 text-glow">Check</span>
                </h1>
                
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                    <span class="text-[9px] font-black font-whiskey text-purple-500 uppercase tracking-[0.4em]">Secure Action Required</span>
                    <span class="w-8 h-[1px] bg-purple-500/50"></span>
                </div>
            </div>

            <div class="space-y-6">
                <p class="text-gray-400 text-sm leading-relaxed max-w-sm mx-auto">
                    We have sent a 6-digit check code to your email. Please enter it below to login.
                </p>

                @if (session('status'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black font-whiskey text-emerald-400 uppercase tracking-widest">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black font-whiskey text-emerald-400 uppercase tracking-widest">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                @error('otp')
                    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-4 animate-in zoom-in duration-300">
                        <p class="text-[10px] font-black font-whiskey text-red-500 uppercase tracking-widest">
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <form method="POST" action="{{ route('verification.verify') }}" class="space-y-8" id="otpForm">
                @csrf
                
                <div class="flex justify-center gap-2 md:gap-4 mb-10" dir="ltr">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" name="otp[]" maxlength="1" required
                            class="otp-input w-12 h-14 md:w-16 md:h-20 text-center text-3xl font-black font-whiskey bg-[#0c0518]/50 border-2 border-white/5 rounded-2xl text-white outline-none focus:border-purple-500 focus:bg-purple-500/5 focus:shadow-[0_0_30px_rgba(147,51,234,0.2)] transition-all duration-300 transform focus:scale-110"
                            autocomplete="one-time-code" pattern="[0-9]*" inputmode="numeric">
                    @endfor
                </div>

                <button type="submit" id="otpSubmitBtn" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black font-whiskey uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-900/40 italic flex items-center justify-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    <span id="btnText">Confirm Login</span>
                </button>
                
            </form>

            <div class="space-y-4 pt-4 border-t border-white/5">
                <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                    @csrf
                    <button type="submit" id="resendBtn" class="text-[10px] font-black font-whiskey text-purple-500 hover:text-white uppercase tracking-[0.2em] transition-all">
                        Resend Code
                    </button>
                </form>

                <form method="POST" action="{{ route('register.cancel') }}">
                    @csrf
                    <button type="submit" class="text-[9px] font-black font-whiskey text-gray-700 hover:text-red-400 uppercase tracking-[0.3em] transition-all relative z-50">
                        Cancel Registration
                    </button>
                </form>
            </div>
            
            <div class="pt-6 border-t border-white/5">
                <p class="text-[8px] font-black font-whiskey text-gray-700 uppercase tracking-[0.3em]">
                    Smart Security v5.1 Active
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('.otp-input');
        const otpForm = document.getElementById('otpForm');
        const submitBtn = document.getElementById('otpSubmitBtn');
        const btnText = document.getElementById('btnText');
        
        // Auto-focus first input
        inputs[0].focus();

        inputs.forEach((input, index) => {
            // Handle numeric input and numeric only
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                if (value && !/^[0-9]$/.test(value)) {
                    input.value = '';
                    return;
                }

                if (value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                checkAndSubmit();
            });

            // Handle keys
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace') {
                    if (!input.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                        e.preventDefault();
                    }
                } else if (e.key === 'ArrowLeft' && index > 0) {
                    inputs[index - 1].focus();
                } else if (e.key === 'ArrowRight' && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').substring(0, 6);
                
                if (pastedData) {
                    pastedData.split('').forEach((char, i) => {
                        if (inputs[i]) {
                            inputs[i].value = char;
                        }
                    });
                    
                    const nextIndex = Math.min(pastedData.length, inputs.length - 1);
                    inputs[nextIndex].focus();
                    
                    checkAndSubmit();
                }
            });

            // Visual active state focus logic
            input.addEventListener('focus', () => {
                input.select();
            });
        });

        function checkAndSubmit() {
            const code = Array.from(inputs).map(i => i.value).join('');
            if (code.length === 6) {
                // All fields filled, trigger form submit if not already submitting
                if (!submitBtn.disabled) {
                    otpForm.dispatchEvent(new Event('submit'));
                    otpForm.submit();
                }
            }
        }

        // Handle form submission visuals
        otpForm.addEventListener('submit', (e) => {
            if (submitBtn.disabled) {
                e.preventDefault();
                return;
            }
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'animate-pulse');
            btnText.textContent = 'Checking code...';
            
            // Add a subtle scan animation to inputs on submit
            inputs.forEach(input => {
                input.classList.add('border-purple-500/50', 'bg-purple-500/10');
                input.readOnly = true;
            });
        });

        // If there's an error message, shake the form
        @if($errors->has('otp'))
            const formContainer = otpForm.parentElement;
            formContainer.classList.add('animate-shake');
            setTimeout(() => formContainer.classList.remove('animate-shake'), 500);
        @endif
    });
</script>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    .animate-shake {
        animation: shake 0.4s ease-in-out;
    }
</style>
@endpush
@endsection

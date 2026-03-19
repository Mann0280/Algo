@extends('layouts.app')

@section('title', 'Contact Us | Emperor Stock Predictor')

@section('content')
<main class="relative pt-16 pb-12">
    {{-- Grid Background --}}
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, rgba(147, 51, 234, 0.15) 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="container mx-auto px-6 relative z-10 max-w-7xl">

        {{-- Hero Section --}}
        <div class="text-center max-w-3xl mx-auto mb-12 fade-in-up">
            <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Contact Portal</span>
            <h1 class="font-professional text-4xl md:text-6xl text-white mb-6 leading-tight uppercase">
                Get in Touch With <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Emperor Stock Predictor</span>
            </h1>
            <p class="text-gray-400 text-sm md:text-base font-medium leading-relaxed opacity-80">
                Talk to our dedicated support team for help, partnership offers, or platform questions.
            </p>
        </div>

        {{-- Stats Bar --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 fade-in-up">
            <div class="glass-panel p-6 rounded-2xl border border-white/5 text-center">
                <div class="text-2xl font-professional text-white tracking-tighter mb-1">&lt;2hr</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Avg Response</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 text-center">
                <div class="text-2xl font-professional text-white tracking-tighter mb-1">24/7</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Support Uptime</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 text-center">
                <div class="text-2xl font-professional text-white tracking-tighter mb-1">98%</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Satisfaction</div>
            </div>
            <div class="glass-panel p-6 rounded-2xl border border-white/5 text-center">
                <div class="text-2xl font-professional text-white tracking-tighter mb-1">5K+</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Tickets Resolved</div>
            </div>
        </div>

        {{-- Main Content: Form + Contact Info --}}
        <div class="grid grid-cols-1 xl:grid-cols-5 gap-12 items-start mb-16">
            {{-- Left: Contact Form --}}
            <div class="xl:col-span-3 fade-in-up" id="contact-form-container">
                <div class="glass-panel p-8 md:p-12 rounded-[2.5rem] border border-white/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-72 h-72 bg-purple-600/5 blur-[100px] -z-10"></div>

                    <div class="flex items-center gap-4 mb-10">
                        <div class="w-12 h-12 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                            <i data-lucide="send" class="w-6 h-6 text-purple-400"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-professional text-white uppercase tracking-tight">Send a Message</h2>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">All fields marked are required</p>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[10px] font-bold p-4 rounded-xl mb-8 text-center uppercase tracking-widest">
                            <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 align-middle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/20 text-red-500 text-[10px] font-bold p-4 rounded-xl mb-8 text-center uppercase tracking-widest">
                            <i data-lucide="alert-triangle" class="w-4 h-4 inline-block mr-2 align-middle"></i>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="#" method="POST" class="space-y-8" id="contact-form">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative group/input">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-1 transition-colors group-focus-within/input:text-purple-400">Full Name</label>
                                <input type="text" name="name" required placeholder="Enter your name" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-700">
                            </div>
                            <div class="relative group/input">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-1 transition-colors group-focus-within/input:text-purple-400">Email Address</label>
                                <input type="email" name="email" required placeholder="yourname@domain.com" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-700">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative group/input">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-1 transition-colors group-focus-within/input:text-purple-400">Phone (Optional)</label>
                                <input type="text" name="phone" placeholder="+91 XXXXX XXXXX" class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-700">
                            </div>
                            <div class="relative group/input">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-1 transition-colors group-focus-within/input:text-purple-400">Subject</label>
                                <select name="subject" required class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white appearance-none cursor-pointer">
                                    <option value="General Inquiry" class="bg-[#030014]">General Inquiry</option>
                                    <option value="Support" class="bg-[#030014]">Technical Support</option>
                                    <option value="Partnership" class="bg-[#030014]">Partnership Opportunities</option>
                                    <option value="Billing" class="bg-[#030014]">Billing & Subscriptions</option>
                                    <option value="Feedback" class="bg-[#030014]">Feedback & Suggestions</option>
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-5 bottom-4 w-4 h-4 text-gray-600 pointer-events-none"></i>
                            </div>
                        </div>

                        <div class="relative group/input">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3 px-1 transition-colors group-focus-within/input:text-purple-400">Your Message</label>
                            <textarea name="message" rows="5" required placeholder="Describe your query in detail..." class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 focus:outline-none focus:border-purple-500/50 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm font-medium text-white placeholder:text-gray-700 resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-4 px-8 rounded-xl text-[10px] tracking-[0.2em] uppercase transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_26px_rgba(79,70,229,0.35)] active:scale-95 flex items-center justify-center gap-3">
                            <span>Send Message</span>
                            <i data-lucide="zap" class="w-4 h-4 fill-white"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right: Contact Info + Social --}}
            <div class="xl:col-span-2 space-y-8 fade-in-up">
                {{-- Contact Details --}}
                <div class="glass-panel p-10 rounded-[2.5rem] border border-white/10 relative overflow-hidden">
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-emerald-600/5 blur-[80px] -z-10"></div>

                    <h3 class="font-professional text-lg text-white mb-8 flex items-center gap-3 uppercase tracking-tight">
                        <span class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                            <i data-lucide="globe" class="w-4 h-4 text-emerald-400"></i>
                        </span>
                        Office Hub
                    </h3>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4 group/info">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 group-hover/info:text-purple-400 group-hover/info:border-purple-500/30 transition-all">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Direct Support</div>
                                <div class="text-sm font-bold text-white tracking-tight">info@stockpredictor.in</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 group/info">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 group-hover/info:text-purple-400 group-hover/info:border-purple-500/30 transition-all">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Phone Number</div>
                                <div class="text-sm font-bold text-white tracking-tight">+91 (800) 555-0199</div>
                            </div>
                        </div>

                        <!-- <div class="flex items-start gap-4 group/info">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 group-hover/info:text-purple-400 group-hover/info:border-purple-500/30 transition-all">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                            <div class="text-[10px] font-bold font-whiskey text-gray-500 uppercase tracking-widest mb-1">Operational Base</div>
                                <div class="text-sm font-bold text-white tracking-tight leading-snug">Suite 405, Digital Fin-Hub,<br>Mumbai, Maharashtra, India</div>
                            </div>
                        </div> -->

                        <!-- <div class="flex items-start gap-4 group/info">
                            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-gray-500 group-hover/info:text-purple-400 group-hover/info:border-purple-500/30 transition-all">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold font-whiskey text-gray-500 uppercase tracking-widest mb-1">Operating Hours</div>
                                <div class="text-sm font-bold text-white tracking-tight">Mon – Fri: 9:00 AM – 6:00 PM IST</div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- {{-- Social Channels --}}
                <div class="glass-panel p-8 rounded-[2.5rem] border border-white/10">
                    <h3 class="font-whiskey text-sm font-black italic text-white mb-6 uppercase tracking-tight">Connect on Social</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <a href="#" class="flex flex-col items-center gap-2 p-4 bg-white/[0.03] rounded-2xl border border-white/5 hover:bg-purple-500/10 hover:border-purple-500/20 transition-all group">
                            <i data-lucide="twitter" class="w-5 h-5 text-slate-500 group-hover:text-purple-400 transition-colors"></i>
                            <span class="text-[8px] font-bold font-whiskey text-slate-600 uppercase tracking-widest group-hover:text-purple-400">Twitter</span>
                        </a>
                        <a href="#" class="flex flex-col items-center gap-2 p-4 bg-white/[0.03] rounded-2xl border border-white/5 hover:bg-purple-500/10 hover:border-purple-500/20 transition-all group">
                            <i data-lucide="instagram" class="w-5 h-5 text-slate-500 group-hover:text-purple-400 transition-colors"></i>
                            <span class="text-[8px] font-bold font-whiskey text-slate-600 uppercase tracking-widest group-hover:text-purple-400">Instagram</span>
                        </a>
                        <a href="#" class="flex flex-col items-center gap-2 p-4 bg-white/[0.03] rounded-2xl border border-white/5 hover:bg-purple-500/10 hover:border-purple-500/20 transition-all group">
                            <i data-lucide="send" class="w-5 h-5 text-slate-500 group-hover:text-purple-400 transition-colors"></i>
                            <span class="text-[8px] font-bold font-whiskey text-slate-600 uppercase tracking-widest group-hover:text-purple-400">Telegram</span>
                        </a>
                    </div>
                </div> -->

                {{-- Quick Help --}}
                <div class="glass-panel p-8 rounded-[2.5rem] border border-amber-500/20 border-l-4 border-l-amber-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-amber-500/5 blur-[60px] -z-10"></div>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center">
                            <i data-lucide="headphones" class="w-5 h-5 text-amber-400"></i>
                        </div>
                        <div>
                            <div class="text-sm font-professional text-white uppercase tracking-tight">Need Urgent Help?</div>
                            <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Premium members get priority</div>
                        </div>
                    </div>
                    <a href="{{ url('/pricing') }}" class="mt-4 inline-flex items-center gap-2 text-[10px] font-bold text-amber-400 uppercase tracking-widest hover:text-amber-300 transition-colors">
                        Upgrade to Elite <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- FAQ Section --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Knowledge Base</span>
                <h2 class="font-professional text-3xl md:text-5xl text-white uppercase">
                    Frequently <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Asked</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-purple-600/20 flex items-center justify-center border border-purple-500/30">
                            <i data-lucide="help-circle" class="w-4 h-4 text-purple-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">How accurate are the signals?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">Our AI system has a very high accuracy rate across all stocks, constantly getting better using advanced technology.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600/20 flex items-center justify-center border border-emerald-500/30">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">Is my data secure?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">Yes. We use top-level security to keep your data safe and never share your information with others.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center border border-blue-500/30">
                            <i data-lucide="credit-card" class="w-4 h-4 text-blue-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">Can I cancel anytime?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">Yes, all premium subscriptions can be cancelled at any time. You will continue to have access until the end of your current billing period.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-white mb-6">
                            <i data-lucide="clock" class="w-4 h-4 text-amber-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">What is the response time?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">Free tier users receive responses within 24 hours. Premium members enjoy priority support with average response times under 2 hours.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-rose-600/20 flex items-center justify-center border border-rose-500/30">
                            <i data-lucide="users" class="w-4 h-4 text-rose-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">Do you offer partnerships?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">We welcome institutional partnerships, affiliate programs, and white-label integrations. Select "Partnership" in the form above to discuss options.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600/20 flex items-center justify-center border border-indigo-500/30">
                            <i data-lucide="smartphone" class="w-4 h-4 text-indigo-400"></i>
                        </div>
                        <h4 class="text-sm font-professional text-white uppercase tracking-tight">Is there a mobile app?</h4>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pl-11">Our mobile app is currently in development. You can receive real-time signal alerts via Telegram and email notifications in the meantime.</p>
                </div>
            </div>
        </div>

        {{-- Trust Bar --}}
        <div class="glass-panel p-8 rounded-[2.5rem] border border-white/5 fade-in-up">
            <div class="flex flex-wrap justify-center gap-12 items-center">
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity">
                    <i data-lucide="shield-check" class="w-5 h-5 text-emerald-500"></i>
                    <span class="font-bold text-[9px] tracking-widest uppercase text-white">AES-256 Encrypted</span>
                </div>
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity">
                    <i data-lucide="lock" class="w-5 h-5 text-purple-500"></i>
                    <span class="font-bold text-[9px] tracking-widest uppercase text-white">GDPR Compliant</span>
                </div>
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity">
                    <i data-lucide="server" class="w-5 h-5 text-blue-500"></i>
                    <span class="font-bold text-[9px] tracking-widest uppercase text-white">AWS Infrastructure</span>
                </div>
                <div class="flex items-center gap-3 opacity-50 hover:opacity-100 transition-opacity">
                    <i data-lucide="mail" class="w-10 h-10 text-white mb-4"></i>
                    <span class="font-bold text-[9px] tracking-widest uppercase text-white">99.9% Uptime SLA</span>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        gsap.registerPlugin(ScrollTrigger);

        const fadeElements = gsap.utils.toArray('.fade-in-up');
        fadeElements.forEach((el, i) => {
            gsap.to(el, {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: i * 0.08,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: el,
                    start: "top 90%",
                    toggleActions: "play none none none"
                }
            });
        });

        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection

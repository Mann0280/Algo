@extends('layouts.app')

@section('title', 'About Us | Emperor Stock Predictor — Smart Trading')

@section('content')
<main class="relative pt-16 pb-12">
    {{-- Grid Background --}}
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, rgba(147, 51, 234, 0.15) 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="container mx-auto px-6 relative z-10 max-w-7xl">

        {{-- ═══════════════════════════════════════════ --}}
        {{-- HERO --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="text-center max-w-4xl mx-auto mb-16 fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold uppercase tracking-[0.3em] mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-ping"></span>
                Smart Trading Systems
            </div>
            <h1 class="text-5xl md:text-7xl font-professional leading-tight mb-8">
                <span class="block text-white">Redefining</span>
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-white to-purple-500">Trading</span>
                <span class="text-white">with AI</span>
            </h1>
            <p class="text-slate-400 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto font-medium">
                Emperor Stock Predictor uses advanced AI systems and smart risk management to help regular traders with high-level market insights.
            </p>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- KEY METRICS --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16 fade-in-up">
            <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center group hover:border-purple-500/20 transition-all">
                <div class="text-4xl font-professional text-white tracking-tighter mb-2">5K+</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Active Traders</div>
            </div>
            <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center group hover:border-emerald-500/20 transition-all">
                <div class="text-4xl font-professional text-white tracking-tighter mb-2">89%</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Win Rate</div>
            </div>
            <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center group hover:border-blue-500/20 transition-all">
                <div class="text-4xl font-professional text-white tracking-tighter mb-2">₹12Cr+</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Profits Generated</div>
            </div>
            <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center group hover:border-amber-500/20 transition-all">
                <div class="text-4xl font-professional text-white tracking-tighter mb-2">24/7</div>
                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Market Monitoring</div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- MISSION & VISION --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            {{-- Mission --}}
            <div class="glass-panel p-10 md:p-14 rounded-[2.5rem] border border-white/5 relative overflow-hidden fade-in-up group hover:border-purple-500/20 transition-all">
                <div class="absolute top-0 right-0 w-48 h-48 bg-purple-600/5 blur-[80px] -z-10"></div>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center">
                        <i data-lucide="target" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <div>
                        <h2 class="font-professional text-2xl text-white tracking-tight">Our Mission</h2>
                        <div class="h-1 w-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full mt-2"></div>
                    </div>
                </div>
                <p class="text-slate-300 text-base leading-relaxed mb-6">
                    We remove emotions from trading using clear data analysis. We provide the smart tools needed for consistent and disciplined trading performance.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-slate-400">Provide pro-level trading tools for every trader</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-slate-400">Remove guessing with AI-powered trading help</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-slate-400">Maintain unwavering transparency in every signal we generate</span>
                    </li>
                </ul>
            </div>

            {{-- Vision --}}
            <div class="glass-panel p-10 md:p-14 rounded-[2.5rem] border border-white/5 relative overflow-hidden fade-in-up group hover:border-emerald-500/20 transition-all">
                <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-600/5 blur-[80px] -z-10"></div>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center">
                        <i data-lucide="eye" class="w-7 h-7 text-emerald-400"></i>
                    </div>
                    <div>
                        <h2 class="font-professional text-2xl text-white tracking-tight">Our Vision</h2>
                        <div class="h-1 w-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full mt-2"></div>
                    </div>
                </div>
                <p class="text-slate-300 text-base leading-relaxed mb-6">
                    To become the world's most trusted AI-driven trading platform, where every individual has access to the same analytical power as hedge funds.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-slate-400">Build a global community of data-driven, emotion-free traders</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></span>
                        <span class="text-sm text-slate-400">Expand into multi-asset coverage including crypto, commodities, and forex</span>
                    </li>
{{-- <li class="flex items-start gap-3">
112:                         <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2 flex-shrink-0"></span>
113:                         <span class="text-sm text-slate-400">Pioneer fully automatic trading powered by smart AI</span>
114:                     </li> --}}
                </ul>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- OUR STORY --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Genesis</span>
                <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white">
                    Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Story</span>
                </h2>
            </div>

            <div class="glass-panel p-10 md:p-16 rounded-[2.5rem] border border-white/5 relative overflow-hidden max-w-5xl mx-auto">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-purple-600/3 to-transparent -z-10"></div>

                <div class="space-y-8 text-slate-300 text-base leading-relaxed">
                    <p>
                        Emperor Stock Predictor was born in <strong class="text-white">2024</strong> from a simple frustration: retail traders were losing consistently, not because they lacked intelligence, but because they lacked the tools that institutions had been using for decades.
                    </p>
                    <p>
                        Our founding team — a group of data analysts, software engineers, and experienced traders — built this to bridge the gap. We created an AI engine trained on over <strong class="text-white">15 years of stock market history</strong>, looking at news, trends, and patterns from 50+ sources.
                    </p>
                    <p>
                        Within our first year, the platform processed over <strong class="text-white">2 million data points daily</strong>, generating signals with high accuracy. Today, Emperor Stock Predictor serves thousands of traders across India, from beginners to pros.
                    </p>
                    <p>
                        We believe that the future of trading is not about gut feeling — it's about <strong class="text-white">precision, speed, and data</strong>. And we're just getting started.
                    </p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- HOW IT WORKS --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">How It Works</span>
                <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white">
                    How <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">It</span> Works
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center relative overflow-hidden group hover:border-purple-500/20 transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-purple-600/5 blur-2xl -z-10"></div>
                    <div class="w-16 h-16 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="database" class="w-8 h-8 text-purple-400"></i>
                    </div>
                    <div class="text-[10px] font-bold text-purple-400 uppercase tracking-widest mb-3">Step 01</div>
                    <h3 class="font-professional text-lg text-white tracking-tight mb-4">Market Data</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">We collect real-time data from stock exchanges, news systems, and social trends — over 2M data points daily.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center relative overflow-hidden group hover:border-emerald-500/20 transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-600/5 blur-2xl -z-10"></div>
                    <div class="w-16 h-16 rounded-2xl bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="brain" class="w-8 h-8 text-emerald-400"></i>
                    </div>
                    <div class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-3">Step 02</div>
                    <h3 class="font-professional text-lg text-white tracking-tight mb-4">AI Processing</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Our advanced AI system analyzes patterns and trends using smart technology trained on more than 15 years of market history.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 text-center relative overflow-hidden group hover:border-blue-500/20 transition-all">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-600/5 blur-2xl -z-10"></div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="send" class="w-8 h-8 text-blue-400"></i>
                    </div>
                    <div class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-3">Step 03</div>
                    <h3 class="font-professional text-lg text-white tracking-tight mb-4">Signal Delivery</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">High-confidence signals with entry, stop-loss, and target levels are delivered in real-time through our dashboard, email, and Telegram channels.</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- CORE VALUES --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Our Core</span>
                <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white">
                    What We <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Stand For</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-purple-500/20 transition-all group text-center">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/30 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="shield-check" class="w-7 h-7 text-purple-400"></i>
                    </div>
                    <h4 class="font-professional text-sm text-white tracking-tight mb-3">Transparency</h4>
                    <p class="text-[13px] text-slate-400 leading-relaxed">Every signal comes with a clear reason, accuracy estimate, and risk details. No hidden math.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-emerald-500/20 transition-all group text-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="lock" class="w-7 h-7 text-emerald-400"></i>
                    </div>
                    <h4 class="font-professional text-sm text-white tracking-tight mb-3">Security</h4>
                    <p class="text-[13px] text-slate-400 leading-relaxed">AES-256 encryption, GDPR compliance, and zero data sharing. Your privacy is non-negotiable.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-blue-500/20 transition-all group text-center">
                    <div class="w-14 h-14 rounded-2xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="zap" class="w-7 h-7 text-blue-400"></i>
                    </div>
                    <h4 class="font-professional text-sm text-white tracking-tight mb-3">Innovation</h4>
                    <p class="text-[13px] text-slate-400 leading-relaxed">We constantly improve our models with daily updates and the latest AI technology.</p>
                </div>

                <div class="glass-panel p-8 rounded-3xl border border-white/5 hover:border-amber-500/20 transition-all group text-center">
                    <div class="w-14 h-14 rounded-2xl bg-amber-600/20 border border-amber-500/30 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="users" class="w-7 h-7 text-amber-400"></i>
                    </div>
                    <h4 class="font-professional text-sm text-white tracking-tight mb-3">Community</h4>
                    <p class="text-[13px] text-slate-400 leading-relaxed">A thriving ecosystem of traders helping each other grow through shared insights and strategies.</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- TECHNOLOGY STACK OVERVIEW --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Infrastructure</span>
                <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white">
                    Built on <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Solid Ground</span>
                </h2>
            </div>

            <div class="glass-panel p-6 sm:p-10 md:p-14 rounded-[3rem] border border-white/5 max-w-5xl mx-auto shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-20 gap-y-5">
                    {{-- AI Systems --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="cpu" class="w-7 h-7 text-purple-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">AI Systems</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Technology</p>
                        </div>
                    </div>

                    {{-- AWS Cloud --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="server" class="w-7 h-7 text-emerald-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">AWS Cloud</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Infrastructure</p>
                        </div>
                    </div>

                    {{-- Real-time APIs --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="globe" class="w-7 h-7 text-blue-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">Real-time APIs</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Data Feeds</p>
                        </div>
                    </div>

                    {{-- 15+ Years --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="bar-chart-3" class="w-7 h-7 text-amber-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">15+ Years</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Training Data</p>
                        </div>
                    </div>

                    {{-- Weekly Retraining --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="refresh-cw" class="w-7 h-7 text-rose-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">Weekly Retraining</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Model Updates</p>
                        </div>
                    </div>

                    {{-- 2M+ Daily --}}
                    <div class="flex items-center gap-4 py-3 group">
                        <div class="w-12 h-12 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="activity" class="w-7 h-7 text-indigo-400 opacity-90 group-hover:opacity-100 transition-opacity"></i>
                        </div>
                        <div class="flex flex-col">
                            <h4 class="text-lg font-semibold text-white leading-none m-0 m-0">2M+ Daily</h4>
                            <p class="text-[12px] font-bold text-slate-500 uppercase tracking-[1px] opacity-70 mt-[2px] mb-0">Data Points</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- TIMELINE --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="mb-16 fade-in-up">
            <div class="text-center mb-16">
                <span class="text-[10px] font-bold text-purple-500 tracking-[0.3em] uppercase mb-4 block">Growth Log</span>
                <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white">
                    Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Journey</span>
                </h2>
            </div>

            <div class="max-w-3xl mx-auto space-y-0 relative">
                {{-- Vertical Line --}}
                <div class="absolute left-8 top-0 bottom-0 w-px bg-gradient-to-b from-purple-500 via-indigo-500 to-transparent"></div>

                @php
                    $milestones = [
                        ['year' => '2024 Q1', 'title' => 'Project Start', 'desc' => 'Founding team started. Early AI model prototype created. First tests showed high accuracy.', 'color' => 'purple'],
                        ['year' => '2024 Q2', 'title' => 'Beta Launch', 'desc' => 'Platform launched to 200 beta testers. Real-time signal delivery via dashboard and Telegram integration completed.', 'color' => 'indigo'],
                        ['year' => '2024 Q3', 'title' => 'Public Release', 'desc' => 'Open registration enabled. 1,000 traders onboarded within the first month. Premium subscription tier introduced.', 'color' => 'blue'],
                        ['year' => '2025 Q1', 'title' => 'Scale & Expand', 'desc' => 'Crossed 5,000 active users. Expanded to forex and crypto signals. Partnership program launched for institutional users.', 'color' => 'emerald'],
                        ['year' => '2026', 'title' => 'The Future', 'desc' => 'Mobile app and multi-language support on the roadmap.', 'color' => 'amber'],
                    ];
                @endphp

                @foreach ($milestones as $m)
                <div class="relative flex items-start gap-8 pb-12 pl-4">
                    <div class="relative z-10 w-8 h-8 rounded-full bg-{{ $m['color'] }}-500/20 border-2 border-{{ $m['color'] }}-500 flex items-center justify-center flex-shrink-0">
                        <span class="w-2 h-2 rounded-full bg-{{ $m['color'] }}-500"></span>
                    </div>
                    <div class="glass-panel p-6 rounded-2xl border border-white/5 flex-grow hover:border-{{ $m['color'] }}-500/20 transition-all">
                        <div class="text-[10px] font-bold text-{{ $m['color'] }}-400 uppercase tracking-widest mb-2">{{ $m['year'] }}</div>
                        <h4 class="font-professional text-base text-white tracking-tight mb-2">{{ $m['title'] }}</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $m['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ═══════════════════════════════════════════ --}}
        {{-- CTA --}}
        {{-- ═══════════════════════════════════════════ --}}
        <div class="glass-panel p-6 sm:p-12 md:p-20 rounded-[2rem] sm:rounded-[2.5rem] border border-white/5 text-center relative overflow-hidden fade-in-up">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-purple-600/10 blur-[120px] -z-10"></div>
            <h2 class="font-professional text-3xl md:text-5xl tracking-tighter text-white mb-6">
                Ready to <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-600">Trade Smarter</span>?
            </h2>
            <p class="text-slate-400 max-w-2xl mx-auto mb-12 text-sm leading-relaxed">
                Join thousands of traders already using Emperor Stock Predictor's AI trading system. Start your journey and get premium features.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ url('/register') }}" class="px-12 py-5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-professional text-[10px] tracking-widest rounded-2xl hover:scale-105 hover:shadow-[0_0_30px_rgba(147,51,234,0.4)] transition-all uppercase">
                    Start Trading
                </a>
                <a href="{{ url('/contact') }}" class="px-12 py-5 glass-panel border border-white/10 text-white font-professional text-[10px] tracking-widest rounded-2xl hover:bg-white/5 transition-all uppercase">
                    Contact Us
                </a>
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

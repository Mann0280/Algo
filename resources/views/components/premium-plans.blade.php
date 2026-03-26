@php
    $walletSettings = [
        'upi_id' => \App\Models\SiteSetting::getValue('wallet_upi_id'),
        'upi_name' => \App\Models\SiteSetting::getValue('wallet_upi_name'),
        'qr_code' => \App\Models\SiteSetting::getValue('wallet_qr_code'),
    ];

    // Find existing packages to link correctly
    $p1 = \App\Models\PremiumPackage::where('price', 200)->first();
    $p7 = \App\Models\PremiumPackage::where('price', 2800)->first();
    $p30 = \App\Models\PremiumPackage::where('price', 3000)->first();
    $p365 = \App\Models\PremiumPackage::where('price', 30000)->first();

    $getLink = function($package) {
        if (!$package) return route('login');
        return auth()->check() ? route('payment.show', ['package' => $package->id]) : route('login');
    };
@endphp

<!-- Premium Plans Section -->
<section class="pt-8 sm:pt-16 pb-20 sm:pb-32 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Header removed as requested to avoid duplication on pricing page -->


        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">

            @if(!isset($mode) || $mode !== 'dynamic' || (isset($packages) && $packages->isEmpty()))
                <!-- Fixed/Hardcoded plans (Fallback) -->
                <!-- 1 Day -->
                <div class="relative group">
                    <div class="absolute -inset-px rounded-3xl bg-gradient-to-r from-purple-500 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-[2px]"></div>
                    <div class="relative h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 transform" style="--accent-from:#6a5bf6; --accent-to:#9a4dff; --accent-border:rgba(138,92,246,0.42); background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-4">
                                <i data-lucide="zap" class="w-5 h-5 text-purple-400"></i>
                            </div>
                            <h3 class="font-bold text-white uppercase tracking-[0.05em] text-base">1 Day</h3>
                            <p class="text-gray-500 text-xs mt-1">Try before you commit</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-white tracking-tight">₹200</span>
                            <span class="text-xs text-gray-500 ml-1">/ day</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full day signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-gray-600 shrink-0"></i> <span class="text-gray-600">Signal history</span></li>
                        </ul>
                        <a href="{{ $getLink($p1) }}" class="plan-button">Get Started</a>
                    </div>
                </div>

                <!-- 1 Week -->
                <div class="relative group">
                    <div class="absolute -inset-px rounded-3xl bg-gradient-to-r from-indigo-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-[2px]"></div>
                    <div class="relative h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 transform" style="--accent-from:#5f7cf6; --accent-to:#b04dff; --accent-border:rgba(135,92,255,0.46); background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-4">
                                <i data-lucide="calendar" class="w-5 h-5 text-indigo-400"></i>
                            </div>
                            <h3 class="font-bold text-white uppercase tracking-[0.05em] text-base">1 Week</h3>
                            <p class="text-gray-500 text-xs mt-1">Great for short-term traders</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-white tracking-tight">₹2,800</span>
                            <span class="text-xs text-gray-500 ml-1">/ week</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 7-day full signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 7-day signal history</li>
                        </ul>
                        <a href="{{ $getLink($p7) }}" class="plan-button">Get Started</a>
                    </div>
                </div>

                <!-- 1 Month — Most Popular -->
                <div class="relative group">
                    <!-- Glow ring -->
                    <div class="absolute -inset-px rounded-3xl transition-opacity duration-500 opacity-70 group-hover:opacity-100 blur-[1px]" style="background: linear-gradient(135deg, #7c3aed, #6366f1);"></div>
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                        <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-white px-4 py-1.5 rounded-full shadow-lg whitespace-nowrap" style="background: linear-gradient(135deg, #7c3aed, #4f46e5);">Most Popular</span>
                    </div>
                    <div class="relative h-full rounded-3xl p-8 flex flex-col transition-all duration-300 transform" style="--accent-from:#f2b75c; --accent-to:#d98b2b; --accent-border:rgba(240,180,90,0.55); background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">

                        <div class="mb-6 mt-2">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, rgba(124,58,237,0.3), rgba(99,102,241,0.2)); border: 1px solid rgba(124,58,237,0.4);">
                                <i data-lucide="star" class="w-5 h-5 text-purple-300"></i>
                            </div>
                            <h3 class="font-bold text-white uppercase tracking-[0.05em] text-base">1 Month</h3>
                            <p class="text-purple-300/70 text-xs mt-1">Best value for traders</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-bold text-white tracking-tight">₹3,000</span>
                            <span class="text-xs text-purple-300/70 ml-1">/ month</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-300">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 30-day full signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full signal history</li>
                        </ul>
                        <a href="{{ $getLink($p30) }}" class="plan-button">Get Started</a>
                    </div>
                </div>

                <!-- 1 Year -->
                <div class="relative group">
                    <div class="absolute -inset-px rounded-3xl bg-gradient-to-r from-amber-500 to-yellow-300 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-[2px]"></div>
                    <div class="relative h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 transform" style="--accent-from:#f59e0b; --accent-to:#fbbf24; --accent-border:rgba(245,158,11,0.5); background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center mb-4">
                                <i data-lucide="crown" class="w-5 h-5 text-white"></i>
                            </div>
                            <h3 class="font-bold text-white uppercase tracking-[0.05em] text-base">1 Year</h3>
                            <p class="text-white/60 text-xs mt-1">Maximum savings &amp; access</p>
                        </div>
                        <div class="mb-1">
                            <span class="text-4xl font-bold text-white tracking-tight">₹30,000</span>
                            <span class="text-xs text-gray-500 ml-1">/ year</span>
                        </div>
                        <p class="text-xs text-emerald-400 mb-6">Save ₹6,000 vs monthly</p>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 365-day full access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full signal history</li>
                        </ul>
                        <a href="{{ $getLink($p365) }}" class="plan-button">Get Started</a>
                    </div>
                </div>
            @endif

            <!-- Dynamic Admin Plans (only in dynamic mode) -->
            @if(isset($mode) && $mode === 'dynamic' && isset($packages) && count($packages) > 0)
                @foreach($packages as $index => $package)
                    @php
                        // Cycle through styles for dynamic cards to distinguish them
                        $styles = [
                            ['color' => 'purple', 'glow' => 'rgba(147,51,234,0.12)', 'icon' => 'zap', 'from' => '#6a5bf6', 'to' => '#9a4dff', 'border' => 'rgba(138,92,246,0.42)'],
                            ['color' => 'indigo', 'glow' => 'rgba(99,102,241,0.12)', 'icon' => 'calendar', 'from' => '#5f7cf6', 'to' => '#b04dff', 'border' => 'rgba(135,92,255,0.46)'],
                            ['color' => 'amber', 'glow' => 'rgba(245,158,11,0.08)', 'icon' => 'crown', 'from' => '#f59e0b', 'to' => '#fbbf24', 'border' => 'rgba(245,158,11,0.5)'],
                        ];
                        $style = $styles[$index % count($styles)];
                    @endphp
                    @php
                        $glowColors = [
                            'purple' => 'from-purple-500 to-indigo-600',
                            'indigo' => 'from-indigo-500 to-purple-500',
                            'amber' => 'from-amber-500 to-yellow-300'
                        ];
                        $glowClass = $glowColors[$style['color']] ?? 'from-purple-500 to-indigo-600';
                    @endphp
                    <div class="relative group">
                        <div class="absolute -inset-px rounded-3xl bg-gradient-to-r {{ $glowClass }} opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-[2px]"></div>
                        <div class="relative h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 transform" style="--accent-from:{{ $style['from'] }}; --accent-to:{{ $style['to'] }}; --accent-border:{{ $style['border'] }}; background: rgba(10, 5, 20, 0.95); backdrop-filter: blur(10px);">
                            <div class="mb-6">
                                <div class="w-10 h-10 rounded-xl bg-{{ $style['color'] }}-500/10 border border-{{ $style['color'] }}-500/20 flex items-center justify-center mb-4">
                                    <i data-lucide="{{ $style['icon'] }}" class="w-5 h-5 text-{{ $style['color'] }}-400"></i>
                                </div>
                                <h3 class="font-bold text-white uppercase tracking-[0.05em] text-base">{{ $package->name }}</h3>
                                <p class="text-gray-500 text-xs mt-1">{{ str_replace('_', ' ', $package->description ?? 'Admin Package') }}</p>
                            </div>
                            <div class="mb-6">
                                <span class="text-4xl font-bold text-white tracking-tight">₹{{ number_format($package->price) }}</span>
                                <span class="text-xs text-gray-500 ml-1">/ {{ $package->duration_days }} days</span>
                            </div>
                            <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                                @if(is_array($package->features))
                                    @foreach($package->features as $feature)
                                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> {{ $feature }}</li>
                                    @endforeach
                                @else
                                    <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Premium signal access</li>
                                @endif
                            </ul>
                            <a href="@auth {{ route('payment.show', ['package' => $package->id]) }} @else {{ route('login') }} @endauth" class="plan-button">Get Started</a>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>

        @if(!isset($hideDetailsLink) || !$hideDetailsLink)
        <!-- Bottom CTA -->
        <div class="text-center mt-12">
            <a href="{{ url('/pricing') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-purple-400 hover:text-white transition-colors group">
                View full plan details
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    // Premium component icons initialization
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Card outline glow without flood fill */
    .relative.group > .absolute {
        pointer-events: none;
        padding: 1px;
        border-radius: 1.5rem;
        filter: blur(0);
        opacity: 0;
        background-clip: padding-box, border-box;
        mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        transition: opacity 0.25s ease, filter 0.25s ease;
    }
    .relative.group:hover > .absolute {
        opacity: 0.9;
        filter: blur(2px);
    }
    /* Card lift without inheriting to button */
    .relative.group > .relative.h-full {
        transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
    }
    .relative.group:hover > .relative.h-full {
        transform: translateY(-6px);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.38);
        border-color: rgba(255, 255, 255, 0.12);
    }
    .plan-button {
        display: block;
        width: 100%;
        padding: 0.9rem 1.2rem;
        border-radius: 1rem;
        text-align: center;
        font-weight: 700;
        font-size: 0.95rem;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease, color 0.25s ease;
    }
    .plan-button:hover,
    .plan-button:focus-visible {
        background: linear-gradient(120deg, var(--accent-from, #7c3aed), var(--accent-to, #6366f1));
        color: #0c0a1a;
        border-color: transparent;
        box-shadow: 0 8px 22px rgba(0, 0, 0, 0.35), 0 0 16px var(--accent-border, rgba(124,58,237,0.4));
        transform: translateY(-2px);
    }
    .plan-button:focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.25);
        outline-offset: 3px;
    }

    .step-indicator.active {
        background: linear-gradient(135deg, #f59e0b, #ea580c);
        color: white;
        border-color: transparent;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }
    .step-indicator.completed {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    .step-connector.active {
        background: linear-gradient(90deg, #f59e0b, #ea580c);
    }
    @keyframes scan-line {
        0%, 100% { transform: translateY(0); opacity: 0; }
        5% { opacity: 1; }
        95% { opacity: 1; }
        50% { transform: translateY(168px); }
    }
</style>
@endpush

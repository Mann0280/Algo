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
<section class="py-20 sm:py-32 relative overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Header removed as requested to avoid duplication on pricing page -->


        <!-- Pricing Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">

            @if(!isset($mode) || $mode !== 'dynamic' || (isset($packages) && $packages->isEmpty()))
                <!-- Fixed/Hardcoded plans (Fallback) -->
                <!-- 1 Day -->
                <div class="relative group">
                    <div class="h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:border-purple-500/30 hover:shadow-[0_0_40px_rgba(147,51,234,0.12)]" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-4">
                                <i data-lucide="zap" class="w-5 h-5 text-purple-400"></i>
                            </div>
                            <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">1 Day</h3>
                            <p class="text-gray-500 text-xs mt-1">Try before you commit</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white orbitron">₹200</span>
                            <span class="text-xs text-gray-500 ml-1">/ day</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full day signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="x" class="w-4 h-4 text-gray-600 shrink-0"></i> <span class="text-gray-600">Historical archive</span></li>
                        </ul>
                        <a href="{{ $getLink($p1) }}" class="block w-full py-3.5 rounded-2xl text-center text-sm font-bold text-white border border-white/10 hover:border-purple-500/40 hover:bg-purple-500/10 transition-all">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- 1 Week -->
                <div class="relative group">
                    <div class="h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:border-purple-500/30 hover:shadow-[0_0_40px_rgba(147,51,234,0.12)]" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-4">
                                <i data-lucide="calendar" class="w-5 h-5 text-indigo-400"></i>
                            </div>
                            <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">1 Week</h3>
                            <p class="text-gray-500 text-xs mt-1">Great for short-term traders</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white orbitron">₹2,800</span>
                            <span class="text-xs text-gray-500 ml-1">/ week</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 7-day full signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 7-day signal history</li>
                        </ul>
                        <a href="{{ $getLink($p7) }}" class="block w-full py-3.5 rounded-2xl text-center text-sm font-bold text-white border border-white/10 hover:border-purple-500/40 hover:bg-purple-500/10 transition-all">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- 1 Month — Most Popular -->
                <div class="relative group">
                    <!-- Glow ring -->
                    <div class="absolute -inset-px rounded-3xl" style="background: linear-gradient(135deg, #7c3aed, #6366f1); opacity: 0.7;"></div>
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                        <span class="text-[9px] font-black orbitron uppercase tracking-[0.2em] text-white px-4 py-1.5 rounded-full shadow-lg whitespace-nowrap" style="background: linear-gradient(135deg, #7c3aed, #6366f1);">Most Popular</span>
                    </div>
                    <div class="relative h-full rounded-3xl p-8 flex flex-col transition-all duration-300 hover:-translate-y-2" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">

                        <div class="mb-6 mt-2">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" style="background: linear-gradient(135deg, rgba(124,58,237,0.3), rgba(99,102,241,0.2)); border: 1px solid rgba(124,58,237,0.4);">
                                <i data-lucide="star" class="w-5 h-5 text-purple-300"></i>
                            </div>
                            <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">1 Month</h3>
                            <p class="text-purple-300/70 text-xs mt-1">Best value for traders</p>
                        </div>
                        <div class="mb-6">
                            <span class="text-4xl font-black text-white orbitron">₹3,000</span>
                            <span class="text-xs text-purple-300/70 ml-1">/ month</span>
                        </div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-300">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 30-day full signal access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full historical archive</li>
                        </ul>
                        <a href="{{ $getLink($p30) }}" class="block w-full py-3.5 rounded-2xl text-center text-sm font-bold text-white transition-all hover:scale-[1.02] hover:shadow-[0_0_30px_rgba(124,58,237,0.4)]" style="background: linear-gradient(135deg, #7c3aed, #6366f1);">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- 1 Year -->
                <div class="relative group">
                    <div class="h-full rounded-3xl border border-amber-500/20 p-8 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:border-amber-500/40 hover:shadow-[0_0_40px_rgba(245,158,11,0.08)]" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">
                        <div class="mb-6">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center mb-4">
                                <i data-lucide="crown" class="w-5 h-5 text-amber-400"></i>
                            </div>
                            <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">1 Year</h3>
                            <p class="text-amber-400/60 text-xs mt-1">Maximum savings &amp; access</p>
                        </div>
                        <div class="mb-1">
                            <span class="text-4xl font-black text-white orbitron">₹30,000</span>
                            <span class="text-xs text-gray-500 ml-1">/ year</span>
                        </div>
                        <p class="text-xs text-emerald-400 mb-6">Save ₹6,000 vs monthly</p>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> 365-day full access</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Real-time AI alerts</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Entry, Target &amp; Stop Loss</li>
                            <li class="flex items-center gap-2"><i data-lucide="check" class="w-4 h-4 text-emerald-400 shrink-0"></i> Full historical archive</li>
                        </ul>
                        <a href="{{ $getLink($p365) }}" class="block w-full py-3.5 rounded-2xl text-center text-sm font-bold text-white border border-amber-500/30 hover:bg-amber-500/10 hover:border-amber-500/50 transition-all">
                            Get Started
                        </a>
                    </div>
                </div>
            @endif

            <!-- Dynamic Admin Plans (only in dynamic mode) -->
            @if(isset($mode) && $mode === 'dynamic' && isset($packages) && count($packages) > 0)
                @foreach($packages as $index => $package)
                    @php
                        // Cycle through styles for dynamic cards to distinguish them
                        $styles = [
                            ['color' => 'purple', 'glow' => 'rgba(147,51,234,0.12)', 'icon' => 'zap'],
                            ['color' => 'indigo', 'glow' => 'rgba(99,102,241,0.12)', 'icon' => 'calendar'],
                            ['color' => 'amber', 'glow' => 'rgba(245,158,11,0.08)', 'icon' => 'crown']
                        ];
                        $style = $styles[$index % count($styles)];
                    @endphp
                    <div class="relative group">
                        <div class="h-full rounded-3xl border border-white/10 p-8 flex flex-col transition-all duration-300 hover:-translate-y-2 hover:border-{{ $style['color'] }}-500/30 hover:shadow-[0_0_40px_{{ $style['glow'] }}]" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">
                            <div class="mb-6">
                                <div class="w-10 h-10 rounded-xl bg-{{ $style['color'] }}-500/10 border border-{{ $style['color'] }}-500/20 flex items-center justify-center mb-4">
                                    <i data-lucide="{{ $style['icon'] }}" class="w-5 h-5 text-{{ $style['color'] }}-400"></i>
                                </div>
                                <h3 class="orbitron text-lg font-black text-white uppercase italic tracking-tight">{{ $package->name }}</h3>
                                <p class="text-gray-500 text-xs mt-1">{{ str_replace('_', ' ', $package->description ?? 'Admin Package') }}</p>
                            </div>
                            <div class="mb-6">
                                <span class="text-4xl font-black text-white orbitron">₹{{ number_format($package->price) }}</span>
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
                            <a href="@auth {{ route('payment.show', ['package' => $package->id]) }} @else {{ route('login') }} @endauth" class="block w-full py-3.5 rounded-2xl text-center text-sm font-bold text-white border border-white/10 hover:border-{{ $style['color'] }}-500/40 hover:bg-{{ $style['color'] }}-500/10 transition-all">
                                Get Started
                            </a>
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

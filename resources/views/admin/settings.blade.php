@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-10 max-w-5xl">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="orbitron text-2xl font-black italic tracking-tighter uppercase">System <span class="text-purple-500">Configuration</span></h1>
            <p class="text-gray-500 text-sm mt-1">Manage platform-wide settings and neural engine parameters.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span>
            <span class="text-[9px] font-black orbitron text-emerald-400 uppercase tracking-widest">System Online</span>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-l-4 border-l-emerald-500 px-6 py-4 rounded-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
        <span class="text-sm font-bold text-emerald-400">{{ session('success') }}</span>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
        @csrf

        <!-- General Settings -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center gap-3 bg-white/[0.02]">
                <div class="w-8 h-8 rounded-lg bg-purple-600/20 flex items-center justify-center">
                    <i data-lucide="globe" class="w-4 h-4 text-purple-400"></i>
                </div>
                <h2 class="orbitron text-xs font-bold tracking-widest uppercase text-white">General Settings</h2>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Support Email</label>
                        <input type="email" name="support_email" value="{{ $settings['support_email'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Telegram Channel</label>
                        <input type="text" name="telegram_link" value="{{ $settings['telegram_link'] }}" placeholder="https://t.me/your_channel" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Engine Settings -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center gap-3 bg-white/[0.02]">
                <div class="w-8 h-8 rounded-lg bg-indigo-600/20 flex items-center justify-center">
                    <i data-lucide="brain" class="w-4 h-4 text-indigo-400"></i>
                </div>
                <h2 class="orbitron text-xs font-bold tracking-widest uppercase text-white">Neural Engine</h2>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Breakeven Point (₹)</label>
                        <input type="number" step="0.01" name="breakeven_point" value="{{ $settings['breakeven_point'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Live Refresh Rate (sec)</label>
                        <input type="number" name="ai_refresh_rate" value="{{ $settings['ai_refresh_rate'] }}" min="1" max="60" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white">
                    </div>
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Max Free Signals</label>
                        <input type="number" name="max_free_signals" value="{{ $settings['max_free_signals'] }}" min="0" max="50" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white">
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Settings -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center gap-3 bg-white/[0.02]">
                <div class="w-8 h-8 rounded-lg bg-amber-600/20 flex items-center justify-center">
                    <i data-lucide="crown" class="w-4 h-4 text-amber-400"></i>
                </div>
                <h2 class="orbitron text-xs font-bold tracking-widest uppercase text-white">Subscription</h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Premium Price (₹/month)</label>
                        <input type="number" name="premium_price" value="{{ $settings['premium_price'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Protocol Header</label>
                        <input type="text" name="subscription_header" value="{{ $settings['subscription_header'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                    <div>
                        <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest block mb-2">Protocol Sub-header</label>
                        <input type="text" name="subscription_subheader" value="{{ $settings['subscription_subheader'] }}" class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-3.5 focus:outline-none focus:border-purple-500/40 focus:ring-4 focus:ring-purple-500/10 transition-all text-sm text-white placeholder:text-gray-700">
                    </div>
                </div>
            </div>
        </div>

        <!-- System Toggles -->
        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex items-center gap-3 bg-white/[0.02]">
                <div class="w-8 h-8 rounded-lg bg-rose-600/20 flex items-center justify-center">
                    <i data-lucide="shield" class="w-4 h-4 text-rose-400"></i>
                </div>
                <h2 class="orbitron text-xs font-bold tracking-widest uppercase text-white">System Controls</h2>
            </div>
            <div class="p-8 space-y-6">
                <!-- Maintenance Mode Toggle -->
                <div class="flex items-center justify-between p-5 rounded-xl bg-white/[0.02] border border-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-rose-500/10 border border-rose-500/20 flex items-center justify-center">
                            <i data-lucide="construction" class="w-5 h-5 text-rose-400"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Maintenance Mode</div>
                            <div class="text-[10px] font-bold text-gray-600 orbitron uppercase tracking-widest">Display maintenance page to visitors</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-7 bg-white/10 peer-focus:ring-4 peer-focus:ring-purple-500/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-gray-400 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-600 peer-checked:after:bg-white"></div>
                    </label>
                </div>

                <!-- Registration Toggle -->
                <div class="flex items-center justify-between p-5 rounded-xl bg-white/[0.02] border border-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                            <i data-lucide="user-plus" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">Open Registration</div>
                            <div class="text-[10px] font-bold text-gray-600 orbitron uppercase tracking-widest">Allow new users to register accounts</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="registration_open" value="1" {{ $settings['registration_open'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-14 h-7 bg-white/10 peer-focus:ring-4 peer-focus:ring-purple-500/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-gray-400 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600 peer-checked:after:bg-white"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-10 py-4 bg-purple-600 rounded-2xl text-white font-black orbitron uppercase tracking-widest text-[10px] hover:bg-purple-700 hover:scale-105 transition-all shadow-[0_0_30px_rgba(147,51,234,0.3)] flex items-center gap-3">
                <i data-lucide="save" class="w-4 h-4"></i>
                Synchronize Configuration
            </button>
        </div>
    </form>
</div>
@endsection

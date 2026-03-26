@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<div class="space-y-12 max-w-[1200px] mx-auto pb-20">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">SETTINGS</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                SITE <span class="text-purple-500 text-glow">SETTINGS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Manage Site Settings</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white/5 border border-white/10 px-6 py-4 rounded-2xl">
            <div class="flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_#10b981]"></span>
                <span class="text-[10px] font-semibold font-whiskey text-emerald-400 uppercase tracking-widest text-glow-sm">SYSTEM ACTIVE</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-10">
        @csrf

        <!-- General Engine Settings -->
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="px-10 py-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-600/10 border border-purple-500/20 flex items-center justify-center text-purple-400 shadow-[0_0_20px_rgba(147,51,234,0.1)]">
                        <i data-lucide="settings-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="font-whiskey text-sm font-black tracking-widest uppercase text-white leading-none">Site Identity</h2>
                        <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-2 leading-none">Site Branding and Settings</p>
                    </div>
                </div>
            </div>
            <div class="p-10 space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Site name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] }}" required class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Site Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Support Email</label>
                        <input type="email" name="support_email" value="{{ $settings['support_email'] }}" required class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Telegram Channel</label>
                        <input type="text" name="telegram_link" value="{{ $settings['telegram_link'] }}" placeholder="https://t.me/your_protocol" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] }}" placeholder="919876543210 (Country code + Number)" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Core Parameters -->
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="px-10 py-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-600/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="font-whiskey text-sm font-black tracking-widest uppercase text-white leading-none">System Settings</h2>
                        <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-2 leading-none">Core System Settings</p>
                    </div>
                </div>
            </div>
            <div class="p-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Breakeven Point (₹)</label>
                        <input type="number" step="0.01" name="breakeven_point" value="{{ $settings['breakeven_point'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-indigo-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Refresh Rate (sec)</label>
                        <input type="number" name="ai_refresh_rate" value="{{ $settings['ai_refresh_rate'] }}" min="1" max="60" class="w-full bg-[#0c0518] border border-white/10 focus:border-indigo-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Free Signal Limit</label>
                        <input type="number" name="max_free_signals" value="{{ $settings['max_free_signals'] }}" min="0" max="100" class="w-full bg-[#0c0518] border border-white/10 focus:border-indigo-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Projected Revenue (₹)</label>
                        <input type="number" step="0.01" name="net_revenue" value="{{ $settings['net_revenue'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-indigo-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Prediction Accuracy (%)</label>
                        <input type="number" step="0.1" name="ai_accuracy" value="{{ $settings['ai_accuracy'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-indigo-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Access Grid -->
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
            <div class="px-10 py-8 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-white">
                        <i data-lucide="crown" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h2 class="font-whiskey text-sm font-black tracking-widest uppercase text-white leading-none">Subscription Settings</h2>
                        <p class="text-[9px] font-bold text-gray-600 uppercase tracking-widest mt-2 leading-none">Pricing and display information</p>
                    </div>
                </div>
            </div>
            <div class="p-10 space-y-10">
                <div class="max-w-md">
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Premium Price (₹/month)</label>
                        <input type="number" name="premium_price" value="{{ $settings['premium_price'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-white/50 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Pricing Title</label>
                        <input type="text" name="subscription_header" value="{{ $settings['subscription_header'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-white/20 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest pl-1">Pricing Subtitle</label>
                        <input type="text" name="subscription_subheader" value="{{ $settings['subscription_subheader'] }}" class="w-full bg-[#0c0518] border border-white/10 focus:border-white/20 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black font-whiskey tracking-tight text-white placeholder:text-gray-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- System Protocols Toggles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Maintenance Protocol -->
            <div class="glass-card p-10 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-500 shadow-[0_0_20px_rgba(244,63,94,0.1)]">
                            <i data-lucide="construction" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <div class="text-sm font-black text-white font-whiskey tracking-tight">Maintenance Mode</div>
                            <div class="text-[9px] font-bold text-gray-600 font-whiskey uppercase tracking-widest mt-2 leading-none">Turn off the site for maintenance</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-16 h-8 bg-white/5 border border-white/10 peer-focus:ring-4 peer-focus:ring-rose-500/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-gray-700 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-rose-600 peer-checked:after:bg-white shadow-inner transition-all duration-300"></div>
                    </label>
                </div>
            </div>

            <!-- Population Growth Protocol -->
            <div class="glass-card p-10 rounded-[2.5rem] border border-white/5 relative overflow-hidden group">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 shadow-[0_0_20px_rgba(16,185,129,0.1)]">
                            <i data-lucide="user-plus" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <div class="text-sm font-black text-white font-whiskey tracking-tight">User Registration</div>
                            <div class="text-[9px] font-bold text-gray-600 font-whiskey uppercase tracking-widest mt-2 leading-none">Allow new users to register</div>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="registration_open" value="1" {{ $settings['registration_open'] == '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-16 h-8 bg-white/5 border border-white/10 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-gray-700 after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-600 peer-checked:after:bg-white shadow-inner transition-all duration-300"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Global Save Action -->
        <div class="flex justify-center md:justify-end pt-10">
            <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-purple-600 to-indigo-600 px-12 py-6 rounded-[2.5rem] font-black font-whiskey text-[11px] tracking-widest uppercase shadow-2xl shadow-purple-900/40 hover:scale-[1.02] active:scale-95 transition-all text-white italic">
                Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection

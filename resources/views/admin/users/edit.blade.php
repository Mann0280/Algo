@extends('layouts.admin')

@section('title', 'Edit User Settings')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="p-3 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                EDIT <span class="text-purple-500 text-glow">USER PROFILE</span>
            </h1>
            <p class="text-gray-400 text-xs font-medium uppercase tracking-widest mt-1">Editing Account: <span class="text-white">{{ $user->username }}</span></p>
        </div>
    </div>

    @if($errors->any())
    <div class="glass-panel p-6 rounded-2xl border border-rose-500/20 bg-rose-500/10 space-y-2">
        @foreach($errors->all() as $error)
        <div class="text-rose-500 text-[10px] font-bold font-whiskey uppercase tracking-widest flex items-center gap-2">
            <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $error }}
        </div>
        @endforeach
    </div>
    @endif

    <!-- Form -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-3 px-1">Username</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all"
                               placeholder="e.g. neuro_trader">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-3 px-1">Email Address</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 group-focus-within:text-purple-500 transition-colors"></i>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all"
                               placeholder="user@emperorstock.ai">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-3 px-1">User Role</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['user' => 'Standard', 'premium' => 'Premium', 'admin' => 'Admin'] as $key => $label)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="role" value="{{ $key }}" class="peer hidden" {{ old('role', $user->role) === $key ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border border-white/10 bg-white/5 text-center transition-all peer-checked:bg-purple-600 peer-checked:border-purple-500 peer-checked:text-white group-hover:border-white/20">
                                <span class="text-[9px] font-black font-whiskey uppercase tracking-widest">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="shield-alert" class="w-3.5 h-3.5 text-amber-500"></i>
                        <span class="text-[9px] font-semibold font-whiskey text-amber-500 uppercase tracking-widest">Update Password (Leave blank to keep current)</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-3 px-1">New Password</label>
                            <input type="password" name="password" 
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-3 px-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-4 text-white text-sm outline-none focus:border-purple-500/50 focus:bg-white/[0.08] transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-semibold font-whiskey uppercase tracking-widest text-xs hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-purple-500/20 italic">
                Save Profile Changes
            </button>
        </form>
    </div>

    <!-- Premium Management -->
    <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden">
        <div class="p-10 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black font-whiskey italic uppercase tracking-tighter text-white mb-1">
                        PLAN <span class="text-purple-500 text-glow">CONTROL</span>
                    </h3>
                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest">Manage User Subscription Access</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-500/5 border border-purple-500/10 flex items-center justify-center">
                    <i data-lucide="zap" class="w-6 h-6 text-purple-500"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-[9px] font-black font-whiskey text-gray-500 uppercase tracking-widest mb-4">Current Status</div>
                    <div class="flex items-center gap-3">
                        @if($user->premium_expiry && $user->premium_expiry->isFuture())
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-[0_0_10px_#10b981]"></div>
                            <span class="text-base font-black font-whiskey text-white uppercase tracking-tight">ACTIVE PREMIUM</span>
                        @else
                            <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                            <span class="text-base font-black font-whiskey text-gray-500 uppercase tracking-tight">STANDARD ACCESS</span>
                        @endif
                    </div>
                </div>
                <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
                    <div class="text-[9px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-4">Expiry Date</div>
                    <div class="text-base font-black font-whiskey text-white uppercase tracking-tight">
                        {{ $user->premium_expiry ? $user->premium_expiry->format('d M, Y') : 'NOT SET (FREE)' }}
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.users.update-plan', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-500 uppercase tracking-widest mb-4 px-1">Assign New Plan</label>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach([
                            'day' => ['label' => '1 Day', 'sub' => 'Trial Access'],
                            'week' => ['label' => '1 Week', 'sub' => 'Short Term'],
                            'month' => ['label' => '1 Month', 'sub' => 'Monthly Access'],
                            'year' => ['label' => '1 Year', 'sub' => 'Yearly Access'],
                        ] as $key => $info)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="plan" value="{{ $key }}" class="peer hidden" required>
                            <div class="p-4 rounded-2xl border border-white/10 bg-white/5 text-center transition-all peer-checked:bg-purple-600 peer-checked:border-purple-500 peer-checked:text-white group-hover:border-white/20">
                                <span class="block text-[10px] font-black font-whiskey uppercase tracking-widest mb-1">{{ $info['label'] }}</span>
                                <span class="block text-[8px] font-bold text-gray-500 peer-checked:text-purple-200 uppercase tracking-widest opacity-60 italic">{{ $info['sub'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-white font-semibold font-whiskey uppercase tracking-widest text-[10px] hover:bg-white/10 hover:border-purple-500/50 transition-all flex items-center justify-center gap-3">
                    <i data-lucide="refresh-ccw" class="w-4 h-4 text-purple-500"></i>
                    Update Subscription Plan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

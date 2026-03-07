@extends('layouts.dashboard')

@section('title', 'Refer & Earn | AlgoTrade AI')

@section('dashboard-content')
<div class="space-y-8 animate-in fade-in slide-in-from-bottom-5 duration-700">
    <!-- Header Section -->
    <div class="relative p-8 rounded-[2rem] overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 via-purple-600/5 to-transparent"></div>
        <div class="absolute inset-0 border border-white/10 rounded-[2rem]"></div>
        
        <div class="relative flex flex-col md:flex-row items-center gap-8">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl shadow-purple-500/20 shrink-0">
                <i data-lucide="gift" class="w-12 h-12 text-white fill-white/10"></i>
            </div>
            
            <div class="text-center md:text-left space-y-2">
                <h1 class="orbitron text-3xl font-black text-white italic tracking-tight uppercase">Refer & <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Earn Rewards</span></h1>
                <p class="text-gray-400 text-sm max-w-xl font-medium leading-relaxed">Invite your network to join the premium signal protocol. Earn <span class="text-emerald-400 font-bold">&#8377;100</span> reward in your wallet for every friend's first successful top-up.</p>
            </div>
        </div>
    </div>

    <!-- Stats Matrix -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="glass-panel p-6 rounded-3xl border border-white/5 space-y-3 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="users" class="w-12 h-12 text-indigo-400"></i>
            </div>
            <p class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Total Invited</p>
            <h3 class="text-3xl font-black orbitron text-white italic tracking-tighter">{{ number_format($totalReferrals) }}</h3>
            <p class="text-[8px] font-bold text-indigo-400/60 uppercase tracking-wider italic">Network Growth</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-white/5 space-y-3 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="wallet" class="w-12 h-12 text-emerald-400"></i>
            </div>
            <p class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Total Earnings</p>
            <h3 class="text-3xl font-black orbitron text-emerald-400 italic tracking-tighter">&#8377;{{ number_format($totalEarnings, 2) }}</h3>
            <p class="text-[8px] font-bold text-emerald-400/60 uppercase tracking-wider italic">Wallet Credits</p>
        </div>

        <div class="glass-panel p-6 rounded-3xl border border-white/5 space-y-3 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="zap" class="w-12 h-12 text-amber-400"></i>
            </div>
            <p class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-widest">Conversion Rate</p>
            <h3 class="text-3xl font-black orbitron text-white italic tracking-tighter">
                {{ $totalReferrals > 0 ? number_format(($referralList->where('status', 'rewarded')->count() / $totalReferrals) * 100, 1) : 0 }}%
            </h3>
            <p class="text-[8px] font-bold text-amber-400/60 uppercase tracking-wider italic">Activation Success</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Referral Tools -->
        <div class="space-y-6">
            <div class="glass-panel p-8 rounded-[2.5rem] border border-white/5 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                    <h2 class="orbitron text-lg font-black text-white italic uppercase tracking-tight">Your Referral <span class="text-indigo-400">Protocol</span></h2>
                </div>

                <!-- Code Display -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] px-1">Unique Protocol Code</label>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-indigo-500/5 blur-xl group-hover:bg-indigo-500/10 transition-all opacity-0 group-hover:opacity-100"></div>
                        <div class="relative bg-black/40 border border-white/10 rounded-2xl flex items-center justify-between p-4 px-6 overflow-hidden">
                            <span class="text-2xl font-black orbitron text-white tracking-[0.3em] italic">{{ $user->referral_code }}</span>
                            <button onclick="copyToClipboard('{{ $user->referral_code }}', 'code')" class="group/copy flex items-center gap-2 px-4 py-2 bg-indigo-500/10 hover:bg-indigo-500 text-indigo-400 hover:text-white rounded-xl transition-all border border-indigo-500/30">
                                <span id="code-copy-text" class="text-[9px] font-black orbitron uppercase tracking-widest">Copy Code</span>
                                <i data-lucide="copy" id="code-copy-icon" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Link Display -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black orbitron text-gray-500 uppercase tracking-[0.2em] px-1">Invite Link</label>
                    <div class="relative group">
                        <div class="relative bg-black/40 border border-white/10 rounded-2xl flex items-center justify-between p-4 px-6 gap-4">
                            <span class="text-[10px] font-bold text-gray-400 truncate tracking-wider">{{ url('/register?ref=' . $user->referral_code) }}</span>
                            <button onclick="copyToClipboard('{{ url('/register?ref=' . $user->referral_code) }}', 'link')" class="group/copy flex items-center gap-2 px-4 py-2 bg-purple-500/10 hover:bg-purple-500 text-purple-400 hover:text-white rounded-xl transition-all border border-purple-500/30 shrink-0">
                                <span id="link-copy-text" class="text-[9px] font-black orbitron uppercase tracking-widest">Copy Link</span>
                                <i data-lucide="link" id="link-copy-icon" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Share Instruction -->
                <div class="p-5 rounded-2xl bg-white/[0.02] border border-white/5 flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/10 flex items-center justify-center shrink-0">
                        <i data-lucide="help-circle" class="w-5 h-5 text-amber-400"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[9px] font-black orbitron text-amber-400 uppercase tracking-widest leading-relaxed mt-1">Experimental Instruction</p>
                        <p class="text-[11px] text-gray-500 font-medium leading-relaxed">Share your unique link or code. Rewards are processed automatically 5-10 minutes after your friend's top-up is approved by HQ.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referral List -->
        <div class="glass-panel p-8 rounded-[2.5rem] border border-white/5 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-6 bg-purple-500 rounded-full"></div>
                    <h2 class="orbitron text-lg font-black text-white italic uppercase tracking-tight">Recent <span class="text-purple-400">Referrals</span></h2>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-white/5 border border-white/10 text-[8px] font-black orbitron text-gray-500 uppercase tracking-widest">{{ $referralList->count() }} TOTAL</span>
            </div>

            <div class="space-y-3 overflow-y-auto max-h-[400px] no-scrollbar pr-2">
                @forelse($referralList as $referral)
                <div class="p-4 rounded-2xl bg-white/[0.02] border border-white/5 flex items-center justify-between group hover:bg-white/[0.04] transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500/10 to-purple-600/10 border border-white/10 flex items-center justify-center text-[10px] font-black orbitron text-purple-400">
                            {{ strtoupper(substr($referral->referredUser->username, 0, 1)) }}
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-xs font-black orbitron text-white italic">{{ $referral->referredUser->username }}</p>
                            <p class="text-[8px] font-bold text-gray-600 uppercase tracking-widest">Joined {{ $referral->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        @if($referral->status === 'rewarded')
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[9px] font-black orbitron text-emerald-400 uppercase tracking-widest">+&#8377;100.00</span>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-[6px] font-black orbitron text-emerald-500 uppercase tracking-[0.2em] border border-emerald-500/20">Claimed</span>
                        </div>
                        @else
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[9px] font-black orbitron text-gray-500 uppercase tracking-widest">Pending</span>
                            <span class="px-2 py-0.5 rounded-full bg-white/5 text-[6px] font-black orbitron text-gray-600 uppercase tracking-[0.2em] border border-white/10 italic">In Queue</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="py-12 flex flex-col items-center justify-center text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-white/[0.02] border border-dashed border-white/10 flex items-center justify-center grayscale opacity-20">
                        <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black orbitron text-gray-600 uppercase tracking-widest italic">No Data Nodes Found</p>
                        <p class="text-[11px] text-gray-800 font-medium">Your network protocol is currently isolated. Start sharing to earn.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text, type) {
        navigator.clipboard.writeText(text).then(() => {
            const btnText = document.getElementById(`${type}-copy-text`);
            const btnIcon = document.getElementById(`${type}-copy-icon`);
            const originalText = btnText.innerText;
            
            btnText.innerText = 'COPIED!';
            btnText.classList.add('text-white');
            btnIcon.setAttribute('data-lucide', 'check');
            lucide.createIcons();
            
            setTimeout(() => {
                btnText.innerText = originalText;
                btnText.classList.remove('text-white');
                btnIcon.setAttribute('data-lucide', type === 'code' ? 'copy' : 'link');
                lucide.createIcons();
            }, 2000);
        });
    }
</script>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection

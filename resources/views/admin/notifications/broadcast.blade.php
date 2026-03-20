@extends('layouts.admin')

@section('title', 'Broadcast Communication')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">COMMUNICATION MODULE</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                GLOBAL <span class="text-purple-500 text-glow">BROADCAST</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Deploy system-wide algo notifications</p>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-panel p-4 rounded-2xl border-emerald-500/30 bg-emerald-500/5 text-emerald-500 text-xs font-bold uppercase tracking-widest flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Form Panel -->
    <div class="glass-card rounded-[3rem] border border-white/5 overflow-hidden shadow-[0_0_100px_rgba(147,51,234,0.05)]">
        <div class="p-10 border-b border-white/5 bg-white/[0.02]">
            <h2 class="font-whiskey font-black text-xl text-white italic tracking-tighter uppercase">Authorized Transmission</h2>
            <p class="text-[9px] font-semibold font-whiskey text-gray-500 tracking-widest mt-1 uppercase italic">Encryption: AES-256 Algo Link Active</p>
        </div>
        
        <form action="{{ route('admin.broadcast-notification') }}" method="POST" class="p-10 space-y-10">
            @csrf
            <div class="space-y-8">
                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest mb-3">Broadcast Subject</label>
                    <input type="text" name="title" required placeholder="Enter notification title..." 
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs font-whiskey outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest mb-3">Message Payload</label>
                    <textarea name="message" required rows="6" placeholder="Construct your global broadcast message here..." 
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white text-xs font-whiskey outline-none focus:border-purple-500/50 transition-all placeholder:text-gray-700 resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] mb-3">Distribution Nodes</label>
                        <select name="target" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[11px] font-black font-whiskey outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="premium">PREMIUM NODES ONLY</option>
                            <option value="all" selected>ALL GLOBAL NODES</option>
                            <option value="admin">OFFICER NODES ONLY</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black font-whiskey text-gray-600 uppercase tracking-[0.2em] mb-3">Transmission Intensity</label>
                        <select name="type" required class="w-full bg-[#0c0518] border border-white/10 rounded-2xl px-6 py-4 text-white text-[11px] font-black font-whiskey outline-none focus:border-purple-500/50 transition-all appearance-none cursor-pointer">
                            <option value="info" selected>ROUTINE (INFO)</option>
                            <option value="success">POSITIVE (SUCCESS)</option>
                            <option value="warning">CAUTION (WARNING)</option>
                            <option value="danger">CRITICAL (DANGER)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button id="test-push-btn" type="button" class="w-full py-4 bg-white/5 border border-white/10 rounded-2xl text-gray-400 font-whiskey uppercase tracking-[0.2em] text-[10px] hover:bg-white/10 transition-all flex items-center justify-center gap-3 mb-4">
                    <i data-lucide="zap" class="w-4 h-4"></i>
                    TEST FCM CONNECTION (FOR YOUR SESSION)
                </button>
                <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl text-white font-black font-whiskey uppercase tracking-[0.3em] text-[10px] hover:scale-[1.02] transition-all shadow-xl shadow-purple-900/40 italic flex items-center justify-center gap-3">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    AUTHORIZE GLOBAL TRANSMISSION
                </button>
            </div>
        </form>
    </div>

    <!-- History Preview Card (Optional) -->
    <div class="glass-card rounded-[2.5rem] p-10 border border-white/5">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center">
                <i data-lucide="history" class="w-4 h-4 text-gray-400"></i>
            </div>
            <h3 class="font-whiskey font-black text-xs tracking-widest text-white uppercase italic">Broadcast Protocol Advice</h3>
        </div>
        <div class="space-y-4 text-[11px] text-gray-500 leading-relaxed font-whiskey bg-black/20 p-6 rounded-2xl border border-white/5">
            <p><span class="text-purple-500 font-bold tracking-widest">•</span> Strategic broadcasts ensure higher user engagement and retention.</p>
            <p><span class="text-purple-500 font-bold tracking-widest">•</span> Use "Critical" intensity only for major system updates or security notices.</p>
            <p><span class="text-purple-500 font-bold tracking-widest">•</span> Notifications are delivered in real-time to the main terminal dashboard.</p>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById('test-push-btn').onclick = async () => {
        const btn = document.getElementById('test-push-btn');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> TRANSMITTING...';
        
        try {
            const response = await fetch("{{ route('admin.notifications.test-push') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await response.json();
            
            if (window.showAlgoNotification) {
                window.showAlgoNotification(data.success ? 'Success' : 'Error', data.message, data.success ? 'success' : 'danger');
            } else {
                alert(data.message);
            }
        } catch (e) {
            console.error(e);
            alert('Transmission failed. Ensure you are logged in and have granted notification permissions.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
            if (window.lucide) lucide.createIcons();
        }
    };
</script>
@endsection

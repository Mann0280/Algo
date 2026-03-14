@extends('layouts.admin')

@section('title', 'Refine Package')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.premium-packages.index') }}" class="p-3 rounded-xl bg-white/5 border border-white/5 text-gray-400 hover:text-white transition-all">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                REFINE <span class="text-purple-500 text-glow">PACKAGE</span>
            </h1>
            <p class="text-gray-400 text-sm font-medium mt-1 uppercase tracking-widest leading-none">Modify protocol: {{ $premiumPackage->name }}</p>
        </div>
    </div>

    <form action="{{ route('admin.premium-packages.update', $premiumPackage) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="glass-card rounded-[2.5rem] p-10 border border-white/5 space-y-8">
            <div class="flex items-center justify-between p-6 bg-white/5 rounded-2xl border border-white/5">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500">
                        <i data-lucide="power" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black font-whiskey text-white uppercase tracking-widest">Protocol Status</p>
                        <p class="text-[9px] text-gray-500 uppercase tracking-widest">Toggle active state for this package</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" {{ $premiumPackage->is_active ? 'checked' : '' }}>
                    <div class="w-14 h-7 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600 shadow-[0_0_15px_rgba(147,51,234,0.3)]"></div>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Package Name</label>
                    <input type="text" name="name" required value="{{ $premiumPackage->name }}" placeholder="e.g. ELITE TRADER" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold font-whiskey text-xs outline-none focus:border-purple-500/50 transition-all">
                </div>

                <!-- Multi-Tags Section -->
                <div class="space-y-4 md:col-span-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Dynamic Feature Tags</label>
                    <div id="tags-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($premiumPackage->tags_json && count($premiumPackage->tags_json) > 0)
                            @foreach($premiumPackage->tags_json as $t)
                            <div class="flex gap-2 items-center bg-white/2 rounded-2xl p-3 border border-white/5">
                                <input type="text" name="tag_names[]" value="{{ $t['name'] }}" placeholder="Tag Name (e.g. LIMITED)" class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-[10px] outline-none focus:border-purple-500/30">
                                <input type="color" name="tag_colors[]" value="{{ $t['color'] ?? '#8B5CF6' }}" class="w-10 h-10 bg-transparent border-none cursor-pointer">
                                <button type="button" onclick="removeTag(this)" class="p-2 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="x" class="w-4 h-4"></i></button>
                            </div>
                            @endforeach
                        @else
                            <div class="flex gap-2 items-center bg-white/2 rounded-2xl p-3 border border-white/5">
                                <input type="text" name="tag_names[]" placeholder="Tag Name (e.g. LIMITED)" class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-[10px] outline-none focus:border-purple-500/30">
                                <input type="color" name="tag_colors[]" value="#8B5CF6" class="w-10 h-10 bg-transparent border-none cursor-pointer">
                                <button type="button" onclick="removeTag(this)" class="p-2 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="x" class="w-4 h-4"></i></button>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addTag()" class="px-6 py-2 rounded-xl border border-white/5 text-[8px] font-black font-whiskey text-gray-400 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest flex items-center gap-2 mt-2">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Append Protocol Tag
                    </button>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Price (INR)</label>
                    <input type="number" name="price" required value="{{ $premiumPackage->price }}" placeholder="4999" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold font-whiskey text-xs outline-none focus:border-purple-500/50 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Upgrade Button Color</label>
                    <div class="flex gap-4 items-center h-[58px]">
                        <input type="color" name="button_color" value="{{ $premiumPackage->button_color ?? '#fbbf24' }}" class="w-12 h-12 bg-transparent border-none cursor-pointer">
                        <span class="text-[10px] font-bold font-whiskey text-gray-500 uppercase tracking-widest">Select Visual Theme</span>
                    </div>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Payment Instructions</label>
                    <textarea name="payment_info" rows="3" placeholder="Step-by-step payment protocol..." class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-medium text-xs outline-none focus:border-purple-500/50 transition-all">{{ $premiumPackage->payment_info }}</textarea>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Duration Protocol</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" id="duration_val" required value="{{ $premiumPackage->duration_days }}" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold font-whiskey text-xs outline-none focus:border-purple-500/50 transition-all">
                        <select id="duration_unit" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold font-whiskey text-[10px] outline-none focus:border-purple-500/50 transition-all uppercase tracking-widest">
                            <option value="1" selected>Days</option>
                            <option value="30">Months</option>
                            <option value="365">Years</option>
                        </select>
                    </div>
                    <input type="hidden" name="duration_days" id="duration_days" value="{{ $premiumPackage->duration_days }}">
                    <p class="text-[9px] text-gray-500 mt-2 ml-1 uppercase tracking-widest">Calculated: <span id="days_preview" class="text-purple-400 font-black">{{ $premiumPackage->duration_days }}</span> Days</p>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Protocol Description</label>
                    <input type="text" name="description" value="{{ $premiumPackage->description }}" placeholder="Advanced neural analytics access" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white font-bold font-whiskey text-xs outline-none focus:border-purple-500/50 transition-all">
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-[10px] font-black font-whiskey text-gray-500 uppercase tracking-widest ml-1">Feature Matrix</label>
                <div id="features-container" class="space-y-3">
                    @if($premiumPackage->features && count($premiumPackage->features) > 0)
                        @foreach($premiumPackage->features as $feature)
                        <div class="flex gap-3">
                            <input type="text" name="features[]" value="{{ $feature }}" placeholder="Feature detail..." class="flex-1 bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-white text-[11px] outline-none focus:border-purple-500/30 transition-all">
                            <button type="button" onclick="removeFeature(this)" class="p-3 rounded-xl bg-white/5 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </div>
                        @endforeach
                    @else
                        <div class="flex gap-3">
                            <input type="text" name="features[]" placeholder="Feature detail..." class="flex-1 bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-white text-[11px] outline-none focus:border-purple-500/30 transition-all">
                            <button type="button" onclick="removeFeature(this)" class="p-3 rounded-xl bg-white/5 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addFeature()" class="px-6 py-2.5 rounded-xl border border-white/5 text-[9px] font-black font-whiskey text-gray-500 hover:text-white hover:bg-white/5 transition-all uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Append Feature Row
                </button>
            </div>
        </div>

        <button type="submit" class="w-full py-5 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-[2rem] text-white font-black font-whiskey uppercase tracking-[0.2em] text-xs hover:scale-[1.02] transition-all shadow-2xl shadow-purple-500/20 italic">
            Synchronize Protocol Updates
        </button>
    </form>
</div>

@push('scripts')
<script>
    const dVal = document.getElementById('duration_val');
    const dUnit = document.getElementById('duration_unit');
    const dDays = document.getElementById('duration_days');
    const dPreview = document.getElementById('days_preview');

    function updateDays() {
        const total = parseInt(dVal.value || 0) * parseInt(dUnit.value);
        dDays.value = total;
        dPreview.textContent = total;
    }

    dVal.addEventListener('input', updateDays);
    dUnit.addEventListener('change', updateDays);

    function addTag() {
        const container = document.getElementById('tags-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2 items-center bg-white/2 rounded-2xl p-3 border border-white/5 animate-in slide-in-from-top-2 duration-300';
        div.innerHTML = `
            <input type="text" name="tag_names[]" placeholder="Tag Name (e.g. LIMITED)" class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white text-[10px] outline-none focus:border-purple-500/30">
            <input type="color" name="tag_colors[]" value="#8B5CF6" class="w-10 h-10 bg-transparent border-none cursor-pointer">
            <button type="button" onclick="removeTag(this)" class="p-2 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="x" class="w-4 h-4"></i></button>
        `;
        container.appendChild(div);
        lucide.createIcons();
    }

    function removeTag(btn) {
        btn.parentElement.remove();
    }

    function addFeature() {
        const container = document.getElementById('features-container');
        const div = document.createElement('div');
        div.className = 'flex gap-3 animate-in slide-in-from-top-2 duration-300';
        div.innerHTML = `
            <input type="text" name="features[]" placeholder="Feature detail..." class="flex-1 bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-white text-[11px] outline-none focus:border-purple-500/30 transition-all">
            <button type="button" onclick="removeFeature(this)" class="p-3 rounded-xl bg-white/5 text-gray-600 hover:text-rose-500 transition-all"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
        `;
        container.appendChild(div);
        lucide.createIcons();
    }

    function removeFeature(btn) {
        btn.parentElement.remove();
    }
</script>
@endpush
@endsection

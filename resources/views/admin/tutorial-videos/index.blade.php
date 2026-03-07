@extends('layouts.admin')

@section('title', 'Tutorial Video Management')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black orbitron italic uppercase tracking-tighter text-white">
                LEARNING <span class="text-purple-500 text-glow">RESOURCES</span>
            </h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.2em] mt-2">Educational Signal Protocols</p>
        </div>
        <button onclick="document.getElementById('add-video-modal').classList.remove('hidden')" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 px-6 py-3 rounded-xl font-bold orbitron text-[10px] tracking-widest uppercase flex items-center gap-2 transition-all active:scale-95 shadow-lg shadow-purple-500/20">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Inject New Tutorial
        </button>
    </div>

    @if (session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 p-4 rounded-xl text-[10px] orbitron font-bold uppercase tracking-wider text-center animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($videos as $video)
        <div class="glass-card p-6 rounded-3xl border border-white/5 relative group transition-all hover:border-purple-500/30 flex flex-col">
            <!-- Video Preview -->
            <div class="aspect-video rounded-2xl overflow-hidden bg-black mb-6 relative group/vid">
                @php
                    $embedUrl = $video->video_url;
                    if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                        $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                    } elseif (str_contains($embedUrl, 'youtu.be/')) {
                        $parts = explode('/', $embedUrl);
                        $embedUrl = 'https://www.youtube.com/embed/' . end($parts);
                    }
                @endphp
                <iframe class="w-full h-full" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent pointer-events-none"></div>
            </div>

            <!-- Info -->
            <div class="flex-1 space-y-2">
                <h3 class="text-xl font-black orbitron text-white italic tracking-tighter line-clamp-1">{{ $video->title }}</h3>
                <p class="text-[10px] text-gray-500 line-clamp-2 leading-relaxed">{{ $video->description ?? 'No protocol description available.' }}</p>
            </div>

            <!-- Actions -->
            <div class="mt-6 pt-6 border-t border-white/5 flex gap-2">
                <button onclick='openEditModal(@json($video))' class="flex-1 py-2 rounded-lg bg-white/5 text-[10px] font-bold orbitron uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/10 transition-all">Edit Protocol</button>
                <form action="{{ route('admin.tutorial-videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Terminate this video protocol?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Add Modal -->
<div id="add-video-modal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center hidden p-6">
    <div class="w-full max-w-lg glass-card p-8 rounded-3xl border border-white/10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="orbitron font-black text-xl italic uppercase tracking-tighter text-white">New <span class="text-purple-500 text-glow">Tutorial</span></h2>
            <button onclick="document.getElementById('add-video-modal').classList.add('hidden')" class="text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form action="{{ route('admin.tutorial-videos.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Protocol Title</label>
                <input type="text" name="title" required placeholder="How to use Neural Indicators" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" required placeholder="https://youtube.com/..." class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">System Description</label>
                <textarea name="description" rows="3" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white resize-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 py-4 rounded-xl font-bold orbitron text-[10px] tracking-widest uppercase shadow-xl shadow-purple-500/20 active:scale-95 transition-all text-white">
                Deploy Tutorial Protocol
            </button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-video-modal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[100] flex items-center justify-center hidden p-6">
    <div class="w-full max-w-lg glass-card p-8 rounded-3xl border border-white/10">
        <div class="flex justify-between items-center mb-8">
            <h2 class="orbitron font-black text-xl italic uppercase tracking-tighter text-white">Update <span class="text-purple-500 text-glow">Protocol</span></h2>
            <button onclick="document.getElementById('edit-video-modal').classList.add('hidden')" class="text-gray-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form id="edit-form" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Protocol Title</label>
                <input type="text" name="title" id="edit-title" required class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">Video URL</label>
                <input type="url" name="video_url" id="edit-url" required class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-bold orbitron text-gray-500 uppercase tracking-widest pl-1">System Description</label>
                <textarea name="description" id="edit-desc" rows="3" class="w-full bg-white/5 border border-white/5 focus:border-purple-600/50 rounded-xl py-3 px-4 outline-none transition-all text-sm text-white resize-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-blue-600 py-4 rounded-xl font-bold orbitron text-[10px] tracking-widest uppercase shadow-xl shadow-purple-500/20 active:scale-95 transition-all text-white">
                Update Video Protocol
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openEditModal(video) {
        document.getElementById('edit-title').value = video.title;
        document.getElementById('edit-url').value = video.video_url;
        document.getElementById('edit-desc').value = video.description || '';
        document.getElementById('edit-form').action = `/admin/tutorial-videos/${video.id}`;
        document.getElementById('edit-video-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection

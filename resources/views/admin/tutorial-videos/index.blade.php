@extends('layouts.admin')

@section('title', 'Tutorials')

@section('content')
<div class="space-y-12 max-w-[1400px] mx-auto pb-20 animate-in fade-in slide-in-from-bottom-6 duration-1000">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 text-glow-indigo">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-8 h-[1px] bg-purple-500"></span>
                <span class="text-[10px] font-semibold font-whiskey text-purple-500 uppercase tracking-widest">TUTORIAL MANAGEMENT</span>
            </div>
            <h1 class="text-4xl font-black font-whiskey italic uppercase tracking-tighter text-white">
                TUTORIAL <span class="text-purple-500 text-glow">VIDEOS</span>
            </h1>
            <p class="text-gray-500 text-xs font-bold mt-2 uppercase tracking-widest">Manage platform educational videos</p>
        </div>
        
        <button onclick="toggleModal('add-video-modal')" class="group relative px-8 py-4 bg-purple-600 rounded-2xl overflow-hidden shadow-[0_0_30px_rgba(147,51,234,0.3)] hover:scale-105 active:scale-95 transition-all text-white italic">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600"></div>
            <div class="relative flex items-center gap-3">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span class="text-[10px] font-semibold font-whiskey uppercase tracking-widest">Add New Video</span>
            </div>
        </button>
    </div>

    @if (session('success'))
    <div class="glass-panel border-emerald-500/20 bg-emerald-500/5 text-emerald-400 p-5 rounded-2xl text-[10px] font-whiskey font-black uppercase tracking-[0.2em] text-center animate-pulse">
        <i data-lucide="check-circle" class="w-4 h-4 inline-block mr-2 mb-0.5"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Video Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($videos as $video)
        <div class="glass-card rounded-[2.5rem] border border-white/5 overflow-hidden shadow-2xl group transition-all duration-700 hover:border-purple-500/30 flex flex-col relative">
            <div class="absolute inset-0 bg-gradient-to-t from-purple-600/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            
            <!-- Video Container -->
            <div class="aspect-video relative overflow-hidden bg-black">
                @php
                    $embedUrl = $video->video_url;
                    if (str_contains($embedUrl, 'youtube.com/watch?v=')) {
                        $embedUrl = str_replace('watch?v=', 'embed/', $embedUrl);
                    } elseif (str_contains($embedUrl, 'youtu.be/')) {
                        $parts = explode('/', $embedUrl);
                        $embedUrl = 'https://www.youtube.com/embed/' . end($parts);
                    }
                @endphp
                <iframe class="w-full h-full grayscale-[20%] group-hover:grayscale-0 transition-all duration-700" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div class="absolute inset-0 bg-gradient-to-t from-[#0c0518] to-transparent pointer-events-none opacity-60 group-hover:opacity-20 transition-opacity"></div>
            </div>

            <div class="p-8 flex-1 flex flex-col relative z-10">
                <div class="flex-1 space-y-3">
                    <h3 class="text-xl font-black font-whiskey text-white italic tracking-tighter line-clamp-1 group-hover:text-purple-400 transition-colors uppercase">{{ $video->title }}</h3>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-relaxed line-clamp-3 italic opacity-60 group-hover:opacity-100 transition-opacity">{{ $video->description ?: 'No description provided' }}</p>
                </div>

                <div class="mt-8 pt-8 border-t border-white/5 flex gap-3">
                    <button onclick='openEditModal(@json($video))' class="flex-1 py-3 bg-white/5 border border-white/10 rounded-xl text-[9px] font-semibold font-whiskey uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/10 hover:border-white/20 transition-all italic flex items-center justify-center gap-2">
                        <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                        Edit Video
                    </button>
                    <form action="{{ route('admin.tutorial-videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Delete this video?')" class="flex shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-12 h-12 flex items-center justify-center rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-all group/btn">
                            <i data-lucide="trash-2" class="w-4 h-4 group-hover/btn:scale-110 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center opacity-20">
            <div class="w-24 h-24 mx-auto mb-6 rounded-[2.5rem] bg-white/5 border border-white/10 flex items-center justify-center">
                 <i data-lucide="video-off" class="w-12 h-12 text-white"></i>
            </div>
            <span class="text-[10px] font-semibold font-whiskey uppercase tracking-widest text-white">No Tutorials Found</span>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Modal -->
<div id="add-video-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-6 transition-all duration-500">
    <div class="w-full max-w-xl glass-card p-12 rounded-[3rem] border border-white/10 shadow-2xl animate-in zoom-in duration-500">
        <div class="flex justify-between items-center mb-10">
            <div class="flex flex-col">
                <h2 class="font-whiskey font-black text-2xl italic uppercase tracking-tighter text-white leading-none">NEW <span class="text-purple-500 text-glow">TUTORIAL</span></h2>
                <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest mt-2">Add a new educational video link</span>
            </div>
            <button onclick="document.getElementById('add-video-modal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all flex items-center justify-center">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="{{ route('admin.tutorial-videos.store') }}" method="POST" class="space-y-8">
            @csrf
            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Video Title</label>
                <input type="text" name="title" required placeholder="Mastering Neural Scalping" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white placeholder:text-gray-800">
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Video URL (YouTube/Vimeo)</label>
                <input type="url" name="video_url" required placeholder="https://youtube.com/watch?v=..." class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white placeholder:text-gray-800">
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Description</label>
                <textarea name="description" rows="3" placeholder="Elaborate on the strategic scope of this protocol..." class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white resize-none placeholder:text-gray-800"></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 py-5 rounded-2xl font-black font-whiskey text-[10px] tracking-widest uppercase shadow-2xl shadow-purple-950/20 hover:scale-[1.02] active:scale-95 transition-all text-white italic">
                Add Video
            </button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="edit-video-modal" class="fixed inset-0 bg-black/95 backdrop-blur-3xl z-[200] hidden items-center justify-center p-6 transition-all duration-500">
    <div class="w-full max-w-xl glass-card p-12 rounded-[3rem] border border-white/10 shadow-2xl animate-in zoom-in duration-500">
        <div class="flex justify-between items-center mb-10">
            <div class="flex flex-col">
                <h2 class="font-whiskey font-black text-2xl italic uppercase tracking-tighter text-white leading-none">UPDATE <span class="text-purple-500 text-glow">VIDEO</span></h2>
                <span class="text-[8px] font-bold text-gray-500 uppercase tracking-widest mt-2">Edit tutorial video details</span>
            </div>
            <button onclick="document.getElementById('edit-video-modal').classList.add('hidden')" class="w-10 h-10 rounded-full bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all flex items-center justify-center">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="edit-form" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Video Title</label>
                <input type="text" name="title" id="edit-title" required class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white shadow-inner">
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Video URL</label>
                <input type="url" name="video_url" id="edit-url" required class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white shadow-inner">
            </div>

            <div class="space-y-4">
                <label class="text-[10px] font-semibold font-whiskey text-gray-600 uppercase tracking-widest ml-1">Description</label>
                <textarea name="description" id="edit-desc" rows="3" class="w-full bg-[#0c0518] border border-white/10 focus:border-purple-600/50 rounded-2xl py-4 px-6 outline-none transition-all text-[11px] font-bold tracking-tight text-white resize-none shadow-inner"></textarea>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 py-5 rounded-2xl font-black font-whiskey text-[10px] tracking-widest uppercase shadow-2xl shadow-purple-950/20 hover:scale-[1.02] active:scale-95 transition-all text-white italic">
                Save Changes
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
        modal.classList.toggle('flex');
    }

    function openEditModal(video) {
        document.getElementById('edit-title').value = video.title;
        document.getElementById('edit-url').value = video.video_url;
        document.getElementById('edit-desc').value = video.description || '';
        document.getElementById('edit-form').action = `/admin/tutorial-videos/${video.id}`;
        toggleModal('edit-video-modal');
    }
</script>
@endpush
@endsection

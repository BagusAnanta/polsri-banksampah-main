<x-layouts.app title="" subtitle="">

<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('edukasi-masyarakat.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
        <h1 class="text-2xl font-bold text-slate-900">{{ $artikel->judul_artikel }}</h1>
        
        @if($artikel->gambar_artikel)
            <div class="w-full h-80 rounded-lg overflow-hidden">
                <img src="{{ asset($artikel->gambar_artikel) }}" alt="{{ $artikel->judul_artikel }}" class="w-full h-full object-cover">
            </div>
        @endif
        
        <div class="prose prose-sm max-w-none">
            {!! $artikel->isi_artikel !!}
        </div>
    
    </div>
</div>

</x-layouts.app>

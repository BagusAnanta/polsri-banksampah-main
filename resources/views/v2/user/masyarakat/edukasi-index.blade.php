<x-layouts.app title="" subtitle="">

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Artikel Edukasi</h1>
            <p class="text-sm text-slate-600">Dapatkan edukasi terkait Bank Sampah</p>
        </div>
    </div>

    <!-- Article List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($artikels as $artikel)
            <button class="bg-base-200/30 rounded-xl border border-slate-200 overflow-hidden text-left" onclick="window.location='{{ route('edukasi-masyarakat.show', $artikel->artikel_id) }}'">
                <div class="flex flex-col h-full">
                    @if($artikel->gambar_artikel)
                        <div class="h-40 overflow-hidden">
                            <img src="{{ asset($artikel->gambar_artikel) }}" alt="{{ $artikel->judul_artikel }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-40 bg-slate-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-400" style="font-size: 48px;">image</span>
                        </div>
                    @endif
                    <div class="p-4 space-y-3">
                        <h3 class="font-semibold text-slate-900 text-sm leading-tight">{{ $artikel->judul_artikel }}</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">{{ \Illuminate\Support\Str::limit(strip_tags($artikel->isi_artikel), 120) }}</p>
                        <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($artikel->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </button>
        @empty
            <div class="lg:col-span-3 py-12 text-center text-slate-500 bg-base-200/30 rounded-xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 block">menu_book</span>
                Belum ada artikel edukasi
            </div>
        @endforelse
    </div>
</div>

</x-layouts.app>

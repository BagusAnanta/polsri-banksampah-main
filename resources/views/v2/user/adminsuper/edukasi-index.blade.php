
<x-layouts.app title="Daftar Artikel Edukasi" subtitle="Kelola artikel edukasi masyarakat">

<div class="space-y-6">
    <!-- <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Artikel Edukasi</h1>
            <p class="text-sm text-slate-600">Kelola artikel edukasi masyarakat</p>
        </div>
        <a href="{{ route('sa.edukasi.create') }}" class="btn btn-primary gap-2 self-start">
            <span class="material-symbols-outlined">add</span> Tambah Artikel
        </a>
    </div> -->

    <x-slot name="actions">
        <a href="{{ route('sa.edukasi.create') }}"
           class="btn w-full rounded-lg bg-[#16A34A] hover:bg-[#16A34A] text-white sm:w-auto sm:rounded-full">
             + Tambah Artikel
        </a>
    </x-slot>

    <!-- KPI -->
    <div class="bg-[#E1EFE3] rounded-xl p-4 border border-slate-200">
        <p class="text-sm text-slate-600 font-medium">Total Artikel</p>
        <p class="text-3xl font-bold text-slate-900">{{ $totalArtikel ?? 0 }}</p>
    </div>

    <!-- Article List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($artikels as $artikel)
            <div class="bg-[#E1EFE3] rounded-xl border border-slate-200 overflow-hidden">
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
                    <div class="flex gap-2">
                        <a href="{{ route('sa.edukasi.edit', $artikel->artikel_id) }}" class="btn btn-outline btn-sm flex-1 gap-1">
                            <span class="material-symbols-outlined" style="font-size: 16px;">edit</span> Edit
                        </a>
                        <form action="{{ route('sa.edukasi.destroy', $artikel->artikel_id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm w-full text-red-600 hover:bg-red-50 gap-1" onclick="return confirm('Hapus artikel ini?')">
                                <span class="material-symbols-outlined" style="font-size: 16px;">delete</span> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 py-12 text-center text-slate-500 bg-[#E1EFE3] rounded-xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 block">menu_book</span>
                Belum ada artikel edukasi
            </div>
        @endforelse
    </div>
</div>


</x-layouts.app>

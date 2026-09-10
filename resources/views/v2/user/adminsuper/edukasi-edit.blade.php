<x-layouts.app title="" subtitle="">

<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('sa.edukasi-superadmin.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sa.edukasi.update', $artikel->artikel_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Judul Artikel -->
        <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Judul Artikel</h3>
            <div class="form-control">
                <input type="text" name="judul_artikel" class="input input-bordered rounded-xl bg-[#E4CEA5] text-sm px-4 py-3 pr-12 text-stone-800 placeholder-[#93764A] w-full" value="{{ old('judul_artikel', $artikel->judul_artikel) }}" required>
                @error('judul_artikel')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>
        </div>

        <!-- Card 2: Gambar Sampul -->
        <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Gambar Sampul (Opsional)</h3>
            @if($artikel->gambar_artikel)
                <div class="w-full h-40 rounded-lg overflow-hidden">
                    <img src="{{ asset($artikel->gambar_artikel) }}" alt="Gambar Artikel" class="w-full h-full object-cover">
                </div>
            @endif
            <div class="form-control">
                <input type="file" name="gambar_artikel" class="file-input file-input-bordered bg-white @error('gambar_artikel') file-input-error @enderror" accept="image/*">
                @error('gambar_artikel')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
                <label class="label">
                    <span class="label-text-alt">Format: JPG, PNG. Ukuran maksimal: 2MB</span>
                </label>
            </div>
        </div>

        <!-- Card 3: Isi Artikel dengan Rich Text Editor -->
        <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Isi Artikel</h3>
            <div class="form-control">
                <x-richtext.richtext name="isi_artikel" id="editor" :defaultvalue="$artikel->isi_artikel"/>
                @error('isi_artikel')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('sa.edukasi-superadmin.index') }}" class="btn flex-1 rounded-xl bg-[#E4CEA5] hover:bg-red-600">Batal</a>
            <button type="submit" class="btn flex-1 rounded-xl bg-[#A3A85C] hover:bg-[#A3A85C] text-white">
                <span class="material-symbols-outlined">save</span> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

</x-layouts.app>

<x-layouts.app title="" subtitle="">

    <div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('sa.edukasi.index') }}" class="btn btn-ghost btn-sm">
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

    <form action="{{ route('sa.edukasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Card 1: Judul Artikel -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Judul Artikel</h3>
            <div class="form-control">
                <input type="text" name="judul_artikel" class="input input-bordered bg-white text-lg" placeholder="Masukkan judul artikel" value="{{ old('judul_artikel') }}" required>
            </div>
        </div>

        <!-- Card 2: Gambar Sampul -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Gambar Sampul (Opsional)</h3>
            <div class="form-control">
                <input type="file" name="gambar_artikel" class="file-input file-input-bordered bg-white" accept="image/*">
                <label class="label">
                    <span class="label-text-alt">Format: JPG, PNG. Ukuran maksimal: 2MB</span>
                </label>
            </div>
        </div>

        <!-- Card 3: Isi Artikel dengan Rich Text Editor -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Isi Artikel</h3>
            <div class="form-control">
               <x-richtext.richtext name="isi_artikel" id="editor" :defaultvalue="old('isi_artikel')"/>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('sa.edukasi.index') }}" class="btn btn-ghost flex-1">Batal</a>
            <button type="submit" class="btn btn-primary flex-1">
                <span class="material-symbols-outlined">publish</span> Terbitkan Artikel
            </button>
        </div>
    </form>
</div>

</x-layouts.app>

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

    <form action="{{ route('sa.edukasi.update', $artikel->artikel_id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Judul Artikel -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Judul Artikel</h3>
            <div class="form-control">
                <input type="text" name="judul_artikel" class="input input-bordered bg-white text-lg @error('judul_artikel') input-error @enderror" value="{{ old('judul_artikel', $artikel->judul_artikel) }}" required>
                @error('judul_artikel')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
            </div>
        </div>

        <!-- Card 2: Gambar Sampul -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
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
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Isi Artikel</h3>
            <div class="form-control">
                <div class="flex gap-1 border-b border-slate-200 pb-2 mb-2 flex-wrap">
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="bold" title="Bold">
                        <span class="material-symbols-outlined text-sm">format_bold</span>
                    </button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="italic" title="Italic">
                        <span class="material-symbols-outlined text-sm">format_italic</span>
                    </button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="underline" title="Underline">
                        <span class="material-symbols-outlined text-sm">format_underlined</span>
                    </button>
                    <div class="divider divider-horizontal mx-0 w-px my-0"></div>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="formatBlock" data-arg="h1" title="Heading 1">H1</button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="formatBlock" data-arg="h2" title="Heading 2">H2</button>
                    <div class="divider divider-horizontal mx-0 w-px my-0"></div>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="insertUnorderedList" title="Bullet List">
                        <span class="material-symbols-outlined text-sm">format_list_bulleted</span>
                    </button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="insertOrderedList" title="Number List">
                        <span class="material-symbols-outlined text-sm">format_list_numbered</span>
                    </button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" data-cmd="formatBlock" data-arg="blockquote" title="Quote">
                        <span class="material-symbols-outlined text-sm">format_quote</span>
                    </button>
                    <div class="divider divider-horizontal mx-0 w-px my-0"></div>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" id="linkBtn" title="Add Link">
                        <span class="material-symbols-outlined text-sm">link</span>
                    </button>
                    <button type="button" class="rte-btn p-2 hover:bg-slate-100 rounded" id="unlinkBtn" title="Remove Link">
                        <span class="material-symbols-outlined text-sm">link_off</span>
                    </button>
                </div>
                @error('isi_artikel')
                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                @enderror
                <div id="editor" class="border border-slate-300 rounded-md p-3 bg-white min-h-80 focus:outline-none focus:ring-2 focus:ring-blue-500" contenteditable="true">{!! $artikel->isi_artikel !!}</div>
                <input type="hidden" id="isiArtikelHidden" name="isi_artikel">
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('sa.edukasi.index') }}" class="btn btn-ghost flex-1">Batal</a>
            <button type="submit" class="btn btn-primary flex-1">
                <span class="material-symbols-outlined">save</span> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const editor = document.getElementById('editor');
    const hiddenInput = document.getElementById('isiArtikelHidden');
    const linkBtn = document.getElementById('linkBtn');
    const unlinkBtn = document.getElementById('unlinkBtn');
    const form = document.querySelector('form');

    document.querySelectorAll('.rte-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const cmd = btn.dataset.cmd;
            const arg = btn.dataset.arg || null;

            if (cmd === 'createLink') {
                const url = prompt('Enter URL:');
                if (url) document.execCommand('createLink', false, url);
            } else {
                document.execCommand(cmd, false, arg);
            }
            editor.focus();
        });
    });

    linkBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const url = prompt('Enter URL:');
        if (url) document.execCommand('createLink', false, url);
        editor.focus();
    });

    unlinkBtn.addEventListener('click', (e) => {
        e.preventDefault();
        document.execCommand('unlink', false, null);
        editor.focus();
    });

    form.addEventListener('submit', (e) => {
        hiddenInput.value = editor.innerHTML;
        console.log('Form submitted with isi_artikel:', hiddenInput.value);
        
        if (!hiddenInput.value.trim()) {
            e.preventDefault();
            alert('Isi artikel tidak boleh kosong!');
            return false;
        }
    });
</script>
@endpush

</x-layouts.app>

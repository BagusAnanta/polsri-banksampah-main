<x-layouts.app title="" subtitle="">

<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('sa.masyarakat.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <!-- Card 1: Identity -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Data Masyarakat</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-600 font-medium">Nama Masyarakat</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Status</p>
                <div class="mt-1">
                    <x-layouts.status-badge :status="$masyarakat->verification" />
                </div>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">NIK</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->decrypted_nik ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Tanggal Mendaftar</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ \Carbon\Carbon::parse($masyarakat->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2: Contact Info -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Informasi Kontak</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-600 font-medium">Email</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->user->email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">No. Telepon</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->user->phone ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3: Personal Data -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Data Pribadi</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-600 font-medium">Jenis Kelamin</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->gender ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Alamat</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $masyarakat->user->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 4: KTP Photo -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Foto KTP</h3>
        @if($masyarakat->identity_photo)
            <img src="{{ asset($masyarakat->identity_photo) }}" alt="KTP" class="w-full h-auto rounded-lg border border-slate-200">
        @else
            <div class="w-full h-64 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300 flex items-center justify-center">
                <p class="text-slate-500 text-sm">Tidak ada foto KTP</p>
            </div>
        @endif
    </div>

    <!-- Card 5: Review Actions (Approval/Rejection) -->
    @if($masyarakat->verification === 'Menunggu')
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Tinjau Pendaftaran</h3>
            <p class="text-sm text-slate-600 mt-1">Setujui untuk memberikan akses ke platform, atau tolak dengan alasan yang jelas</p>
        </div>
        <form action="{{ route('sa.masyarakat.review-process', $masyarakat->masyarakat_id) }}" method="POST" class="space-y-3">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Alasan (jika ditolak)</span>
                </label>
                <textarea class="textarea textarea-bordered bg-white" name="alasan_tolak" placeholder="Tulis alasan penolakan..." rows="3"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" name="action" value="setuju" class="btn btn-success flex-1 rounded-lg hover:bg-green-600">
                    <span class="material-symbols-outlined">check_circle</span> Setujui Pendaftaran
                </button>
                <button type="submit" name="action" value="tolak" class="btn btn-ghost text-red-600 rounded-lg hover:bg-red-50 flex-1" onclick="return confirm('Tolak pendaftaran masyarakat ini?')">
                    <span class="material-symbols-outlined">cancel</span> Tolak Pendaftaran
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-slate-100 rounded-xl p-4 text-center text-slate-600 text-sm">
        Masyarakat sudah diproses ({{ $masyarakat->verification }}) dan tidak dapat diubah
    </div>
    @endif
</div>


</x-layouts.app>


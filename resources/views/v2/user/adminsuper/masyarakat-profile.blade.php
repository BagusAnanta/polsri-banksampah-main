<x-layouts.app title="" subtitle="">

<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center gap-3">
        <a href="{{ route('sa.masyarakat.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <!-- Card 1: Identity -->
    <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
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
    <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
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
    <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
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
    <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Foto KTP</h3>
        @if($masyarakat->identity_photo)
            <img src="{{ asset($masyarakat->identity_photo) }}" alt="KTP" class="w-full h-auto rounded-lg border border-slate-200">
        @else
            <div class="w-full h-64 bg-slate-100 rounded-lg border-2 border-dashed border-slate-300 flex items-center justify-center">
                <p class="text-slate-500 text-sm">Tidak ada foto KTP</p>
            </div>
        @endif
    </div>

    <!-- Statistics Card -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
            <p class="text-xs text-blue-600 font-medium">Total Poin</p>
            <p class="text-2xl font-bold text-blue-700 mt-1">{{ number_format($masyarakat->poin ?? 0, 0) }}</p>
        </div>
        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
            <p class="text-xs text-green-600 font-medium">Total Gramasi</p>
            <p class="text-2xl font-bold text-green-700 mt-1">{{ number_format($masyarakat->total_gramasi ?? 0, 0) }}g</p>
        </div>
        <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
            <p class="text-xs text-purple-600 font-medium">Setor Selesai</p>
            <p class="text-2xl font-bold text-purple-700 mt-1">{{ $masyarakat->total_selesai ?? 0 }}</p>
        </div>
    </div>
</div>

</x-layouts.app>

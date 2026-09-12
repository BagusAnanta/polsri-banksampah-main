<x-layouts.app title="" subtitle="">

<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <!-- Card 1: Identity -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Profile Bank Sampah</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-600 font-medium">Nama Bank Sampah</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->username ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Jam Operasional</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->jam_operasional ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Tanggal Mendaftar</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ \Carbon\Carbon::parse($banksampah->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
            </div>
             <div>
                <p class="text-xs text-slate-600 font-medium">Deskripsi</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->deskripsi ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 2: Contact Info -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Informasi Kontak</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- <div>
                <p class="text-xs text-slate-600 font-medium">Email</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->user->email ?? '-' }}</p>
            </div> -->
            <div>
                <p class="text-xs text-slate-600 font-medium">No. Telepon</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->nomor_telepon ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Card 3: Address -->
    <div class="bg-[#E1EFE3] rounded-xl p-6 border border-slate-200 space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Alamat dan Kecamatan</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-slate-600 font-medium">Kecamatan</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->kecamatan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 font-medium">Alamat</p>
                <p class="text-sm font-semibold text-slate-900 mt-1">{{ $banksampah->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

</div>

</x-layouts.app>

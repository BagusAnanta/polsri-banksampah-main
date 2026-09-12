
<x-layouts.app title="Daftar Admin/Bank Sampah" subtitle="Semua bank sampah yang terdaftar dalam sistem">

<div class="space-y-6">
    <!-- <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Admin/Bank Sampah</h1>
            <p class="text-sm text-slate-600">Semua bank sampah yang terdaftar dalam sistem</p>
        </div>
        <a href="{{ route('sa.bank-sampah.create') }}" class="btn btn-primary gap-2 self-start">
            <span class="material-symbols-outlined">add</span> Tambah Bank Sampah
        </a>
    </div> -->

     <x-slot name="actions">
        <a href="{{ route('sa.bank-sampah.create') }}"
           class="btn w-full rounded-lg bg-[#16A34A] hover:bg-[#16A34A] text-white sm:w-auto sm:rounded-full">
             + Tambah Bank Sampah
        </a>
    </x-slot>

    <!-- KPI -->
    <div class="bg-[#E1EFE3] rounded-xl p-4 border border-slate-200">
        <p class="text-sm text-slate-600 font-medium">Total Bank Sampah</p>
        <p class="text-3xl font-bold text-slate-900">{{ $totalBankSampah ?? 0 }}</p>
    </div>

    <!-- Bank List (1 Column per row) -->
    <div class="space-y-3">
        @forelse($banks as $bank)
            <div class="bg-[#E1EFE3] rounded-xl p-5 border border-slate-200 hover:border-[#16A34A] transition">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Nama Bank Sampah</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $bank->nama_bank_sampah ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Kecamatan</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $bank->kecamatan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Jadwal</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $bank->jam_operasional ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Alamat</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1 truncate">{{ $bank->alamat ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">No. Telepon</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $bank->nomor_telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-12 text-center text-slate-500 bg-[#E1EFE3] rounded-xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 block">store</span>
                Belum ada bank sampah terdaftar
            </div>
        @endforelse
    </div>
</div>

</x-layouts.app>

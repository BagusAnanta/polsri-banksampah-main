<x-layouts.app title="" subtitle="">

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Daftar Pengajuan Setoran Sampah</h1>
            <p class="text-sm text-slate-600">Semua tiket deposit sampah dari masyarakat</p>
        </div>
        <div class="form-control w-full sm:w-64">
            <select class="select select-bordered bg-[#E1EFE3] rounded-lg" id="statusFilter">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- KPI -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#E1EFE3] rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Total Tiket</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalTiket ?? 0 }}</p>
        </div>
        <div class="bg-[#E1EFE3] rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Menunggu Proses</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $menungguProses ?? 0 }}</p>
        </div>
        <div class="bg-[#E1EFE3] rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Selesai</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $selesai ?? 0 }}</p>
        </div>
    </div>

    <!-- 3-Column Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($tikets as $tiket)
            <a href="{{ route('admin.tiket-setor.show', $tiket->tiketsampah_id) }}" data-status="{{ strtolower($tiket->status) }}" class="bg-[#E1EFE3] rounded-xl p-5 border border-slate-200 hover:border-[#16A34A] transition block">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $tiket->masyarakat->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $tiket->masyarakat->decrypted_nik ?? '-' }}</p>
                    </div>
                    <x-layouts.status-badge :status="strtolower($tiket->status)" />
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Estimasi Berat</span>
                        <span class="font-medium text-slate-900">{{ number_format($tiket->berat_sampah, 0) }} gram</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-600">Tanggal</span>
                        <span class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($tiket->created_at)->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="lg:col-span-3 py-12 text-center text-slate-500 bg-[#E1EFE3] rounded-xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 block">inbox</span>
                Belum ada tiket pengajuan
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('statusFilter')?.addEventListener('change', function () {
        const val = this.value;
        document.querySelectorAll('[data-status]').forEach(el => {
            el.style.display = (!val || el.dataset.status === val) ? '' : 'none';
        });
    });
</script>
@endpush

</x-layouts>

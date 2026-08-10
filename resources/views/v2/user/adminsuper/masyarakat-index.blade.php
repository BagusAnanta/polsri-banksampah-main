
<x-layouts.app title="" subtitle="">

<div class="space-y-6">

    <!-- Titile and subtitle -->
    <div class="space-y-1">
        <h1 class="text-2xl font-bold text-slate-900">Daftar Masyarakat</h1>
        <p class="text-sm text-slate-600">Semua pengguna masyarakat yang terdaftar</p>
    </div>
  
    <!-- KPI -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Total Masyarakat</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalMasyarakat ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Menunggu Persetujuan</p>
            <p class="text-2xl font-bold text-amber-600">{{ $menungguPersetujuan ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-sm text-slate-600 font-medium">Telah Disetujui</p>
            <p class="text-2xl font-bold text-green-600">{{ $telahDisetujui ?? 0 }}</p>
        </div>
    </div>

    <!-- Tab Filter -->
    <div class="tabs tabs-bordered">
        <button class="tab tab-active text-sm font-medium" data-filter="semua">Semua</button>
        <button class="tab text-sm font-medium" data-filter="Menunggu">Menunggu</button>
        <button class="tab text-sm font-medium" data-filter="Disetujui">Disetujui</button>
        <button class="tab text-sm font-medium" data-filter="Ditolak">Ditolak</button>
    </div>

    <!-- 3-Column Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($masyarakat as $m)
            <div class="bg-white rounded-xl p-5 border border-slate-200" data-verification="{{ $m->verification }}">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-sm font-bold text-green-700">
                        {{ strtoupper(substr($m->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $m->user->name ?? '-' }}</p>
                        <x-layouts.status-badge :status="$m->verification" />
                    </div>
                </div>
                <div class="space-y-1.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">NIK</span>
                        <span class="font-medium text-slate-900">{{ $m->decrypted_nik ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">No. HP</span>
                        <span class="font-medium text-slate-900">{{ $m->user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-600">Jenis Kelamin</span>
                        <span class="font-medium text-slate-900">{{ $m->gender ?? '-' }}</span>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    @if($m->verification === 'Menunggu')
                        <a href="{{ route('sa.masyarakat.review', $m->masyarakat_id) }}" class="btn btn-outline btn-sm flex-1">Tinjau</a>
                    @else
                        <a href="{{ route('sa.masyarakat.show', $m->masyarakat_id) }}" class="btn btn-outline btn-sm flex-1">Lihat</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="lg:col-span-3 py-12 text-center text-slate-500 bg-white rounded-xl border border-slate-200">
                <span class="material-symbols-outlined text-4xl mb-2 block">people</span>
                Belum ada masyarakat terdaftar
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('tab-active'));
            this.classList.add('tab-active');
            const filter = this.dataset.filter;
            document.querySelectorAll('[data-verification]').forEach(el => {
                el.style.display = (filter === 'semua' || el.dataset.verification === filter) ? '' : 'none';
            });
        });
    });
</script>
@endpush

</x-layouts.app>

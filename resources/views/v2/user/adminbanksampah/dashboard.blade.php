<x-layouts.app title="" subtitle="">

    <div class="space-y-6">
    <!-- Page Header -->
    <div class="space-y-1">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin Bank Sampah</h1>
        <p class="text-sm text-slate-600">Kelola setoran dan penukaran poin sampah</p>
    </div>

    <!-- KPI Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Tiket Setor -->
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Total Tiket Setor</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $totalTiketSetor ?? 0 }}</p>
                </div>
                <div class="p-2.5 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600" style="font-size: 24px;">inventory_2</span>
                </div>
            </div>
        </div>

        <!-- Tiket Setor Pending -->
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Tiket Setor Pending</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ $tiketSetorPending ?? 0 }}</p>
                </div>
                <div class="p-2.5 bg-amber-100 rounded-lg">
                    <span class="material-symbols-outlined text-amber-600" style="font-size: 24px;">schedule</span>
                </div>
            </div>
        </div>

        <!-- Tiket Setor Selesai -->
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Tiket Setor Selesai</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $tiketSetorSelesai ?? 0 }}</p>
                </div>
                <div class="p-2.5 bg-green-100 rounded-lg">
                    <span class="material-symbols-outlined text-green-600" style="font-size: 24px;">check_circle</span>
                </div>
            </div>
        </div>

        <!-- Tiket Poin Pending -->
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-medium">Tiket Poin Pending</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $tiketPoinPending ?? 0 }}</p>
                </div>
                <div class="p-2.5 bg-purple-100 rounded-lg">
                    <span class="material-symbols-outlined text-purple-600" style="font-size: 24px;">star</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid (Chart + Info + Buttons) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Card (Tiket Per Bulan) -->
        <div class="lg:col-span-2 bg-white rounded-xl p-6 border border-slate-200">
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Tiket Per Bulan</h3>
                    <p class="text-sm text-slate-600 mt-1">Timeline setoran sampah 12 bulan terakhir</p>
                </div>
                <div id="tiketChart" class="h-64"></div>
            </div>
        </div>

        <!-- Info & Actions Card -->
        <div class="space-y-4">
            <!-- Bank Info -->
            <div class="bg-white rounded-xl p-6 border border-slate-200">
                <h3 class="text-sm font-semibold text-slate-900 mb-4">Informasi Bank Sampah</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Alamat</p>
                        <p class="text-sm text-slate-900 mt-1">{{ $bankInfo->alamat ?? 'Tidak tersedia' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">Jam Operasional</p>
                        <p class="text-sm text-slate-900 mt-1">{{ $bankInfo->jam_operasional ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 font-medium">No. Telepon</p>
                        <p class="text-sm text-slate-900 mt-1">{{ $bankInfo->nomor_telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                    <span class="material-symbols-outlined" style="font-size: 20px;">qr_code_2</span>
                    Scan QR
                </button>
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                    <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
                    Deposit
                </button>
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition">
                    <span class="material-symbols-outlined" style="font-size: 20px;">card_giftcard</span>
                    Voucher
                </button>
            </div>
        </div>
    </div>

    <!-- Lists Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tiket Setor Pending List -->
        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Tiket Setor Pending</h3>
                <a href="{{ route('admin.tiket-setor.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($tiketSetorPendingList ?? [] as $tiket)
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-200">
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $tiket->masyarakat->user->name ?? '-' }}</p>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $tiket->berat_sampah ?? 0 }}g</p>
                        </div>
                        <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Menunggu</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Tidak ada tiket pending</p>
                @endforelse
            </div>
        </div>

        <!-- Tiket Poin Pending List -->
        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Tiket Poin Pending</h3>
                <a href="{{ route('admin.tiket-poin.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($tiketPoinPendingList ?? [] as $tiket)
                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg border border-purple-200">
                        <div>
                            <p class="text-sm font-medium text-slate-900">{{ $tiket->masyarakat->user->name ?? '-' }}</p>
                            <p class="text-xs text-slate-600 mt-0.5">{{ $tiket->poin ?? 0 }} poin</p>
                        </div>
                        <span class="inline-block px-2.5 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Menunggu</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-4">Tidak ada tiket pending</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
<script>
    const chartOptions = {
        series: [
            { name: 'Tiket Selesai', data: {{ json_encode($tiketPerBulan['selesai'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }} },
            { name: 'Tiket Menunggu', data: {{ json_encode($tiketPerBulan['menunggu'] ?? [0,0,0,0,0,0,0,0,0,0,0,0]) }} }
        ],
        chart: { type: 'area', height: 280, toolbar: { show: false } },
        colors: ['#10b981', '#f59e0b'],
        xaxis: { 
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            labels: { style: { fontSize: '12px' } }
        },
        yaxis: { labels: { style: { fontSize: '12px' } } },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.1 } }
    };
    new ApexCharts(document.querySelector('#tiketChart'), chartOptions).render();
</script>
</x-layouts>
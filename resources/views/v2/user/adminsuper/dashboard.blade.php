<x-layouts.app title="" subtitle="">

<div class="space-y-6">

    <!-- Titile and subtitle -->
    <div class="space-y-1">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Super Admin</h1>
        <p class="text-sm text-slate-600">Ringkasan dan monitoring aplikasi Bank Sampah</p>
    </div>
    
    <!-- KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Total Masyarakat</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalMasyarakat ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Menunggu Approval</p>
            <p class="text-2xl font-bold text-amber-600">{{ $menungguApproval ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Disetujui</p>
            <p class="text-2xl font-bold text-green-600">{{ $disetujui ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $ditolak ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Bank Sampah</p>
            <p class="text-2xl font-bold text-sky-600">{{ $totalBankSampah ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-slate-200">
            <p class="text-xs text-slate-600 font-medium">Artikel Edukasi</p>
            <p class="text-2xl font-bold text-purple-600">{{ $totalArtikel ?? 0 }}</p>
        </div>
    </div>

    <!-- Warning Card -->
    @if(($menungguApproval ?? 0) > 0)
    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center gap-3">
        <span class="material-symbols-outlined text-amber-600">warning</span>
        <p class="text-sm text-amber-800">
            Terdapat <strong>{{ $menungguApproval }}</strong> masyarakat menunggu persetujuan.
            <a href="{{ route('sa.masyarakat.index') }}" class="underline font-medium">Tinjau sekarang</a>
        </p>
    </div>
    @endif

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Donut Chart (Status Masyarakat) -->
        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Status Masyarakat</h3>
            <div id="statusDonutChart" class="h-64"></div>
        </div>

        <!-- Bar Chart (Pendaftaran per Bulan) -->
        <div class="bg-white rounded-xl p-6 border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Pendaftaran per Bulan</h3>
            <div id="pendaftaranBarChart" class="h-64"></div>
        </div>
    </div>

    <!-- Quick Navigation Buttons -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('sa.masyarakat.index') }}" class="btn btn-outline h-auto py-3 gap-2">
            <span class="material-symbols-outlined">group</span> Masyarakat
        </a>
        <a href="{{ route('sa.bank-sampah.index') }}" class="btn btn-outline h-auto py-3 gap-2">
            <span class="material-symbols-outlined">store</span> Bank Sampah
        </a>
        <a href="{{ route('sa.edukasi.index') }}" class="btn btn-outline h-auto py-3 gap-2">
            <span class="material-symbols-outlined">menu_book</span> Edukasi
        </a>
        <a href="{{ route('sa.pengaturan.index') }}" class="btn btn-outline h-auto py-3 gap-2">
            <span class="material-symbols-outlined">settings</span> Pengaturan
        </a>
    </div>
</div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
    <script>
        new ApexCharts(document.querySelector('#statusDonutChart'), {
            series: [{{ $disetujui ?? 0 }}, {{ $menungguApproval ?? 0 }}, {{ $ditolak ?? 0 }}],
            labels: ['Disetujui', 'Menunggu', 'Ditolak'],
            chart: { type: 'donut', height: 280 },
            colors: ['#10b981', '#f59e0b', '#ef4444'],
            legend: { position: 'bottom' }
        }).render();

        new ApexCharts(document.querySelector('#pendaftaranBarChart'), {
            series: [{ name: 'Pendaftar', data: {!! json_encode($pendaftaranPerBulan ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!} }],
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            colors: ['#3b82f6'],
            xaxis: { categories: {!! json_encode($bulanLabels ?? []) !!} },
            plotOptions: { bar: { borderRadius: 4 } }
        }).render();
    </script>
    @endpush

</x-layouts>

@php
    $poinSaatIni = $poinSaatIni ?? 0;
    $targetPoin = $targetPoin ?? 500;
    $totalPoin = $totalPoin ?? 0;
    $totalGramasi = $totalGramasi ?? 0;
    $setorSelesai = $setorSelesai ?? 0;
    $tiketSetorTerbaru = $tiketSetorTerbaru ?? [];
    $tiketPoinTerbaru = $tiketPoinTerbaru ?? [];
    $poinPerBulan = $poinPerBulan ?? [];
    $bulanLabels = $bulanLabels ?? [];
    
    $sisaPoin = max($targetPoin - $poinSaatIni, 0);
    $persentase = $targetPoin > 0 ? min(round(($poinSaatIni / $targetPoin) * 100), 100) : 0;
    $siapDitukar = $poinSaatIni >= $targetPoin;
@endphp

<x-layouts.app title="Beranda" subtitle="Selamat datang kembali">

    {{-- KPI Stat Cards Row: Total Poin / Total Gramasi / Setor Selesai --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-2xl bg-gradient-to-br from-olive-50 to-olive-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-olive-600 sm:text-sm">Total Poin</p>
                    <p class="text-2xl font-bold text-olive-700 sm:text-3xl mt-2">{{ number_format(session('user_total_poin',0) ?? 0) }}</p>
                    <p class="mt-2 text-xs text-olive-600/70">Poin terakumulasi</p>
                </div>
                <span class="material-symbols-outlined">trending_up</span>
            </div>
        </div>

        <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-blue-600 sm:text-sm">Total Gramasi</p>
                    <p class="text-2xl font-bold text-blue-700 sm:text-3xl mt-2">{{ number_format(session('user_total_gramasi',0) ?? 0) }}</p>
                    <p class="mt-2 text-xs text-blue-600/70">gram</p>
                </div>
                <span class="material-symbols-outlined">delete</span>
            </div>
        </div>

        <div class="rounded-2xl bg-gradient-to-br from-green-50 to-green-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <p class="text-xs font-medium text-green-600 sm:text-sm">Setor Selesai</p>
                    <p class="text-2xl font-bold text-green-700 sm:text-3xl mt-2">{{number_format(session('user_total_selesai',0) ?? 0)}}</p>
                    <p class="mt-2 text-xs text-green-600/70">transaksi</p>
                </div>
                <span class="material-symbols-outlined">check_circle</span>
            </div>
        </div>
    </div>

    {{-- Main Content: Chart + Voucher Progress --}}
    <div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        
        {{-- Chart Card (2/3 width on desktop) --}}
        <div class="rounded-2xl bg-base-100 p-5 lg:col-span-2 border border-base-300/20 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-base-content">Poin Per Bulan</h2>
                    <p class="text-xs text-base-content/50 mt-0.5">6 bulan terakhir</p>
                </div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-olive-100 px-3 py-1 text-xs font-medium text-olive-700 flex-shrink-0">
                    <span class="h-2 w-2 rounded-full bg-olive-600"></span>
                    Aktif
                </span>
            </div>
            <div id="chartPoin" class="h-72 w-full"></div>
        </div>

        {{-- Voucher Progress Card (1/3 width on desktop) --}}
        <div class="rounded-2xl bg-olive-700 text-black p-5 shadow-sm lg:col-span-1">
            {{-- Header dengan ikon --}}
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">🎁</span>
                <h3 class="text-base font-semibold">Progress Voucher</h3>
            </div>

            <p class="text-xs text-black/70 mb-4">Poin menuju voucher berikutnya</p>

            {{-- Angka poin besar --}}
            <div class="flex items-baseline gap-1 mb-3">
                <span class="text-3xl font-bold leading-none">{{ number_format($poinSaatIni) }}</span>
                <span class="text-sm text-black/70">/ {{ number_format($targetPoin) }}</span>
            </div>

            {{-- Progress bar --}}
            <div class="mb-2">
                <div class="w-full bg-black/25 rounded-full h-2">
                    <div class="bg-black h-2 rounded-full transition-all" style="width: {{ $persentase }}%"></div>
                </div>
            </div>

            <p class="text-xs text-black/70 mb-3">{{ $persentase }}% tercapai</p>

            {{-- Tombol / badge muncul cuma kalau sudah 100% --}}
            @if($siapDitukar)
                <button type="button" class="w-full bg-black/20 hover:bg-black/30 text-white text-sm py-2 rounded-full transition">
                    {{ number_format(session('user_total_voucher')) }} voucher siap ditukar!
                </button>
            @else
                <p class="text-xs text-white/60">
                    {{ number_format($sisaPoin) }} poin lagi
                </p>
            @endif
        </div>

    </div>

    {{-- Quick Action Menu --}}
    <div class="mb-6">
        <h2 class="mb-4 text-base font-semibold text-base-content">Menu Cepat</h2>
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-3 lg:grid-cols-3">
            <a href="{{ route('tiket-sampah.index') }}" 
               class="group rounded-2xl bg-base-100 p-4 text-center transition hover:bg-olive-50 hover:shadow-md border border-base-300/20 hover:border-olive-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-olive-100 mx-auto mb-2 group-hover:bg-olive-200 transition">
                    <span class="material-symbols-outlined">delete</span>
                </div>
                <span class="text-xs font-medium text-base-content">Setor Sampah</span>
            </a>

            <a href="{{ route('tiket-poin.index') }}" 
               class="group rounded-2xl bg-base-100 p-4 text-center transition hover:bg-amber-50 hover:shadow-md border border-base-300/20 hover:border-amber-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 mx-auto mb-2 group-hover:bg-amber-200 transition">
                    <span class="material-symbols-outlined">confirmation_number</span>
                </div>
                <span class="text-xs font-medium text-base-content">Tukar Poin</span>
            </a>

            <a href="{{ route('edukasi.index') }}" 
               class="group rounded-2xl bg-base-100 p-4 text-center transition hover:bg-sky-50 hover:shadow-md border border-base-300/20 hover:border-sky-200">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-100 mx-auto mb-2 group-hover:bg-sky-200 transition">
                    <span class="material-symbols-outlined">import_contacts</span>
                </div>
                <span class="text-xs font-medium text-base-content">Edukasi</span>
            </a>
        </div>
    </div>

    {{-- Recent Activity Section --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        
        {{-- Tiket Setor Terbaru --}}
        <div class="rounded-2xl bg-base-100 p-5 border border-base-300/20 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-base-content">Tiket Setor Terbaru</h3>
                <a href="{{ route('tiket-sampah.index') }}" class="text-xs font-medium text-olive-600 hover:text-olive-700 transition">
                    Lihat semua →
                </a>
            </div>
            <div class="space-y-2">
                @forelse($tiketSetorTerbaru ?? [] as $tiket)
                    <div class="rounded-lg bg-base-200/40 p-3 hover:bg-base-200/60 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-base-content truncate">Tiket #{{ $tiket->id }}</p>
                                <p class="text-xs text-base-content/60 mt-0.5">{{ $tiket->created_at->translatedFormat('d M Y H:i') }}</p>
                            </div>
                            <span @class([
                                'inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap flex-shrink-0',
                                'bg-amber-100 text-amber-700' => $tiket->status === 'menunggu',
                                'bg-green-100 text-green-700' => $tiket->status === 'selesai',
                                'bg-red-100 text-red-700' => $tiket->status === 'ditolak',
                            ])>
                                <span class="h-1.5 w-1.5 rounded-full" @class([
                                    'bg-amber-600' => $tiket->status === 'menunggu',
                                    'bg-green-600' => $tiket->status === 'selesai',
                                    'bg-red-600' => $tiket->status === 'ditolak',
                                ])></span>
                                {{ ucfirst($tiket->status) }}
                            </span>
                        </div>
                        <div class="mt-2 flex items-center justify-between text-xs">
                            <span class="text-base-content/60">{{ number_format($tiket->estimasi_gram ?? 0) }}g</span>
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg bg-base-200/20 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/20 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-xs text-base-content/50 font-medium">Belum ada tiket</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Tiket Tukar Poin Terbaru --}}
        <div class="rounded-2xl bg-base-100 p-5 border border-base-300/20 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-base-content">Tiket Tukar Poin Terbaru</h3>
                <a href="{{ route('tiket-poin.index') }}" class="text-xs font-medium text-olive-600 hover:text-olive-700 transition">
                    Lihat semua →
                </a>
            </div>
            <div class="space-y-2">
                @forelse($tiketPoinTerbaru ?? [] as $tiket)
                    <div class="rounded-lg bg-base-200/40 p-3 hover:bg-base-200/60 transition">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-base-content truncate">Tiket #{{ $tiket->id }}</p>
                                <p class="text-xs text-base-content/60 mt-0.5">{{ $tiket->created_at->translatedFormat('d M Y H:i') }}</p>
                            </div>
                            <span @class([
                                'inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap flex-shrink-0',
                                'bg-amber-100 text-amber-700' => $tiket->status === 'menunggu',
                                'bg-green-100 text-green-700' => $tiket->status === 'selesai',
                                'bg-red-100 text-red-700' => $tiket->status === 'ditolak',
                            ])>
                                <span class="h-1.5 w-1.5 rounded-full" @class([
                                    'bg-amber-600' => $tiket->status === 'menunggu',
                                    'bg-green-600' => $tiket->status === 'selesai',
                                    'bg-red-600' => $tiket->status === 'ditolak',
                                ])></span>
                                {{ ucfirst($tiket->status) }}
                            </span>
                        </div>
                        <p class="mt-2 text-xs text-base-content/60">{{ number_format($tiket->poin ?? 0) }} poin</p>
                    </div>
                @empty
                    <div class="rounded-lg bg-base-200/20 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-base-content/20 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-xs text-base-content/50 font-medium">Belum ada tiket</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const options = {
            chart: {
                type: 'area',
                sparkline: { enabled: false },
                toolbar: { show: false },
                fontFamily: 'inherit',
                animations: { enabled: true, speed: 800, animateGradually: { enabled: true, delay: 150 } }
            },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1, stops: [0, 100] } },
            colors: ['#6b7280'],
            series: [{ name: 'Poin', data: @json($poinPerBulan ?? []) }],
            xaxis: { categories: @json($bulanLabels ?? []), axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { fontSize: '12px', fontWeight: 500 } } },
            yaxis: { axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { fontSize: '12px' } } },
            grid: { borderColor: '#e5e7eb', strokeDashArray: 4, xaxis: { lines: { show: false } } },
            dataLabels: { enabled: false },
            responsive: [{ breakpoint: 768, options: { chart: { height: 250 } } }]
        };
        const chart = new ApexCharts(document.querySelector("#chartPoin"), options);
        chart.render();
    </script>
    @endpush

</x-layouts.app>

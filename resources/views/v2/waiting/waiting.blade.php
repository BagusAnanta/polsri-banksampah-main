<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Verifikasi - Bank Sampah Sekanak Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-color: #FAF5EB;
        }
    </style>
</head>
<body>
    <div class="min-h-screen bg-[#FAF5EB]">
        <!-- TopBar -->
        <div class="bg-white border-b border-stone-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-[#5B6E33] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-base font-bold text-stone-800">Bank Sampah</h1>
                        <p class="text-[10px] text-stone-500 -mt-0.5">Sekanak Connect</p>
                    </div>
                </div>
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm gap-2 text-stone-500 hover:text-red-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </a>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- 2×2 Responsive Grid: asymmetric (1 large left, stacked right) -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                <!-- Left Column: StatusCard (spans 3/5) -->
                <div class="lg:col-span-3">
                    <div class="card bg-[#EADDCD] rounded-2xl p-7">
                        <div class="card-body p-0">
                            <div class="flex items-center justify-between mb-6">
                                <div class="h-14 w-14 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="badge badge-lg bg-amber-100 text-amber-700 gap-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Verifikasi
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-stone-800 mb-2">Akun Anda Sedang Ditinjau</h3>
                            <p class="text-sm text-stone-600 leading-relaxed mb-4">
                                Terima kasih telah mendaftar. Tim kami akan memeriksa data pendaftaran Anda.
                                Proses verifikasi biasanya memakan waktu 1×24 jam.
                            </p>
                            <p class="text-sm text-[#5B6E33] font-medium">
                                Selamat datang, <span class="font-semibold">{{ session('user_name', 'Calon Anggota') }}</span> 👋
                            </p>
                        </div>
                    </div>

                    <!-- InfoCard: Informasi Pendaftar -->
                    <div class="card bg-[#EADDCD] rounded-2xl p-7 mt-6">
                        <div class="card-body p-0">
                            <h4 class="text-base font-bold text-stone-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#5B6E33]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Informasi Pendaftar
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-[#FAF5EB] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs text-stone-500">Nama Lengkap</span>
                                        <p class="text-sm font-medium text-stone-800">{{ session('user_name', '—') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-[#FAF5EB] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs text-stone-500">NIK</span>
                                        <p class="text-sm font-medium text-stone-800">{{ session('user_nik', '—') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-[#FAF5EB] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs text-stone-500">Email</span>
                                        <p class="text-sm font-medium text-stone-800">{{ session('user_email', '—') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (stacks on mobile, spans 2/5 on desktop) -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <!-- ProgressStepper -->
                    <div class="card bg-[#EADDCD] rounded-2xl p-7">
                        <div class="card-body p-0">
                            <h4 class="text-base font-bold text-stone-800 mb-6">Status Pendaftaran</h4>
                            <div class="flex flex-col gap-0">
                                <!-- Step 1: Pendaftaran (completed) -->
                                <div class="flex items-start gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="h-8 w-8 rounded-full bg-[#5B6E33] flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div class="w-0.5 h-10 bg-[#5B6E33]/30 mt-1"></div>
                                    </div>
                                    <div class="pb-4">
                                        <p class="text-sm font-semibold text-[#5B6E33]">Pendaftaran</p>
                                        <p class="text-xs text-stone-500">Data berhasil dikirim</p>
                                    </div>
                                </div>
                                <!-- Step 2: Verifikasi (current) -->
                                <div class="flex items-start gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="h-8 w-8 rounded-full bg-amber-100 border-2 border-amber-500 flex items-center justify-center flex-shrink-0">
                                            <div class="h-2.5 w-2.5 rounded-full bg-amber-500"></div>
                                        </div>
                                        <div class="w-0.5 h-10 bg-stone-300 mt-1"></div>
                                    </div>
                                    <div class="pb-4">
                                        <p class="text-sm font-semibold text-amber-600">Verifikasi</p>
                                        <p class="text-xs text-stone-500">Sedang diperiksa oleh admin</p>
                                    </div>
                                </div>
                                <!-- Step 3: Akses (pending) -->
                                <div class="flex items-start gap-4">
                                    <div class="flex flex-col items-center">
                                        <div class="h-8 w-8 rounded-full bg-stone-200 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-stone-400">Akses Akun</p>
                                        <p class="text-xs text-stone-400">Akses akan diberikan setelah verifikasi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- InfoCard: Apa yang Bisa Kamu Lakukan -->
                    <div class="card bg-[#EADDCD] rounded-2xl p-7">
                        <div class="card-body p-0">
                            <div class="flex items-start gap-3 mb-4">
                                <div class="h-8 w-8 rounded-full bg-sky-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-stone-800">Apa yang Bisa Kamu Lakukan?</h4>
                                    <p class="text-xs text-stone-500 mt-1 leading-relaxed">
                                        Setelah akun diverifikasi, kamu bisa mulai menyetor sampah, mengumpulkan poin, dan menukarkannya dengan berbagai voucher.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-3 border-t border-stone-300/50">
                                <span class="text-xs text-stone-500">Estimasi verifikasi</span>
                                <span class="text-xs font-semibold text-[#5B6E33]">1×24 Jam</span>
                            </div>

                            <a href="{{ route('login') }}" class="btn btn-block btn-sm rounded-full bg-stone-200 text-stone-600 border-none hover:bg-stone-300 text-sm mt-4">
                                Kembali ke Halaman Login
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="text-center py-6">
            <p class="text-xs text-stone-400">&copy; {{ date('Y') }} Bank Sampah. Hak cipta dilindungi.</p>
        </div>
    </div>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/daisyui@4/dist/index.umd.js"></script>
</body>
</html>

{{-- resources/views/auth/reset-password-status.blade.php --}}
{{-- Kirim variable $status = 'success' atau 'failed' dari controller --}}
@php
    $isSuccess = ($status ?? 'success') === 'success';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Bank Sampah Sekanak Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility,visibility_off" />
    <link rel="stylesheet" href="{{ asset('css/colors.css') }}">
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: 400;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-flex;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
    </style>
    <script>
        tailwindConfig = {
            theme: {
                extend: {
                    colors: {
                        'bg-primary': '#FAF5EB',
                        'bg-surface': '#EADDCD',
                        'primary': '#5B6E33',
                        'primary-dark': '#4A5D23',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAF5EB; }
    </style>
</head>
<body>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[6fr_4fr] bg-[#FAF5EB]">
        <!-- Main Column -->
        <div class="flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-8">
            <div class="w-full max-w-md mx-auto">

                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <div class="h-10 w-10 rounded-full bg-[#5B6E33] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-stone-800">Bank Sampah</h1>
                        <p class="text-xs text-stone-500 -mt-0.5">Sekanak Connect</p>
                    </div>
                </div>

                <!-- Status Card (adapted from original) -->
                <div class="card w-full bg-base-200 border border-base-300 shadow-md rounded-2xl">
                    <div class="card-body items-center text-center p-8">

                        @if ($isSuccess)
                            <span class="material-symbols-outlined text-success text-6xl">check_circle</span>
                        @else
                            <span class="material-symbols-outlined text-error text-6xl">cancel</span>
                        @endif

                        <h2 class="text-2xl font-bold text-stone-800 mt-4">
                            Proses Ubah {{ $isSuccess ? 'Berhasil' : 'Gagal' }}
                        </h2>

                        <p class="text-sm text-stone-600 mt-3 leading-relaxed">
                            @if ($isSuccess)
                                Password anda berhasil diubah. Silakan kembali ke halaman login untuk melakukan login kembali.
                            @else
                                Ubah password anda gagal. {{ $message ?? 'Link reset mungkin sudah kedaluwarsa, silakan coba lagi.' }}
                            @endif
                        </p>

                        <a href="{{ route('login') }}" class="btn btn-block rounded-full bg-[#5B6E33] text-white border-none hover:bg-[#4A5D23] text-sm mt-6">
                            Kembali ke halaman login
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-xs text-stone-400 mt-6">&copy; {{ date('Y') }} Bank Sampah. Hak cipta dilindungi.</p>
            </div>
        </div>

        <!-- Promo Panel -->
        <div class="hidden lg:flex flex-col relative bg-cover bg-center overflow-hidden"
             style="background-image: url('{{ asset('img/promo-auth.jpg') }}')">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>

            <div class="absolute top-6 left-6 z-10">
                <div class="flex items-center gap-3 bg-white/15 backdrop-blur-md rounded-full px-4 py-2">
                    <div class="h-8 w-8 rounded-full bg-white/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-white text-sm font-medium">Bank Sampah Sekanak</span>
                </div>
            </div>

            <div class="relative z-10 flex flex-col justify-end h-full px-10 pb-16">
                <div class="max-w-sm">
                    <p class="text-white/80 text-sm font-medium uppercase tracking-wider mb-2">Bank Sampah Digital</p>
                    <h2 class="text-3xl font-bold text-white mb-3">Kelola Sampah,<br>Dapatkan Manfaat</h2>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Setor sampah Anda, kumpulkan poin, dan tukarkan dengan berbagai voucher menarik.
                    </p>
                </div>

                <div class="flex gap-2 mt-10">
                    <span class="h-2 w-8 rounded-full bg-white"></span>
                    <span class="h-2 w-2 rounded-full bg-white/40"></span>
                    <span class="h-2 w-2 rounded-full bg-white/40"></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>



@props([
    'title' => null,
    'subtitle' => null,
])

<!DOCTYPE html>
<html lang="id" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title . ' - Trash Bank' : 'Trash Bank' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="{{ asset('assets/icons/project2.ico') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: 'var(--dark)'
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-[#F1E3C7] text-base-content rounded-2xl">

    <div class="flex h-screen flex-col overflow-hidden lg:flex-row">

        {{-- Sidebar: hidden on mobile, visible on lg --}}
        <div class="hidden h-full lg:block">
            <x-layouts.sidebar />
        </div>

        <div class="flex flex-1 flex-col overflow-hidden">

            {{-- Navbar: sama untuk semua halaman --}}
            <x-layouts.topbar />

            {{-- Area konten yang berubah-ubah per halaman --}}
            <main class="flex-1 overflow-y-auto px-4 py-4 sm:px-6 sm:py-6 pb-20 lg:pb-6">

                {{-- Header halaman: judul + subtitle + tombol aksi (opsional) --}}
                @if($title)
                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-lg font-semibold sm:text-xl">{{ $title }}</h1>
                            @if($subtitle)
                                <p class="text-xs text-base-content/60 sm:text-sm">{{ $subtitle }}</p>
                            @endif
                        </div>

                        {{-- Slot khusus tombol aksi kanan-atas, beda tiap halaman --}}
                        @isset($actions)
                            <div class="w-full sm:w-auto">{{ $actions }}</div>
                        @endisset
                    </div>
                @endif

                {{-- INI BAGIAN YANG "NEMPEL" — konten tiap halaman masuk sini --}}
                {{ $slot }}

            </main>
        </div>
    </div>

    {{-- Mobile bottom nav (visible only on mobile) --}}
    <div class="fixed bottom-0 left-0 right-0 flex lg:hidden border-t border-base-300/40 bg-base-100">
        <x-layouts.mobile-nav />
    </div>

    @stack('scripts')
</body>
</html>

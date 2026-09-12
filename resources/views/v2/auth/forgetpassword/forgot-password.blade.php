<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Bank Sampah Sekanak Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="{{ asset('assets/icons/project2.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
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
                        'bg-primary': '#FFFFFF',
                        'bg-surface': '#F3F8F4',
                        'primary': '#14532D',
                        'primary-dark': '#1B3B2B',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[6fr_4fr] bg-[#FFFFFF]">
        <!-- Form Column -->
        <div class="flex flex-col justify-center px-6 sm:px-12 lg:px-16 py-8">
            <div class="w-full max-w-md mx-auto">
                
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-10">
                    <div class="h-10 w-10 rounded-full bg-[#14532D] flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-stone-800">Bank Sampah</h1>
                        <p class="text-xs text-stone-500 -mt-0.5">Sekanak Connect</p>
                    </div>
                </div>

                <!-- Heading -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-stone-800 mb-2">Reset Password</h2>
                    <p class="text-sm text-stone-500">Mohon masukkan Email anda disini:</p>
                </div>

                @if (session('status'))
                    <div role="alert" class="alert alert-success text-sm">
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('password.email')  }}" class="space-y-5">
                    @csrf

                    <!-- Email Field -->
                    <fieldset class="fieldset">
                    <div class="form-control">
                        <label class="label" for="email">
                            <span class="label-text text-sm font-medium">Email</span>
                        </label>
                        <div class="relative">
                            <input type="email" name="email" id="email"
                                   placeholder="Masukkan email terdaftar"
                                   value="{{ old('email') }}"
                                   class="input input-bordered rounded-xl bg-[#F3F8F4] text-sm placeholder-stone-400 w-full pr-12 @error('email') input-error @enderror"
                                   required
                                   autofocus/>
                        </div>

                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-red-500">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                    </fieldset>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-block rounded-full bg-[#14532D] text-white border-none hover:bg-[#1B3B2B] text-sm">
                        Kirim email &amp; Ubah Password
                    </button>

                     <!-- Divider -->
                    <div class="divider my-6"></div>

                    <a href="{{ route('login') }}" class="btn btn-block btn-outline rounded-full border-2 border-[#14532D] text-[#14532D] hover:bg-[#14532D]/5 text-sm">
                        &larr; Kembali ke halaman login
                    </a>
                </form>
            </div>

        </div>

        <!-- Promo Panel -->
        <div class="hidden lg:flex flex-col relative bg-cover bg-center overflow-hidden"
             style="background-image: url('{{ asset('img/promo-auth.jpg') }}')">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>

            <div class="absolute top-6 left-6 z-10">
                <div class="flex items-center gap-3 bg-white/15 backdrop-blur-md rounded-full px-4 py-2">
                    <img
                        src="{{ asset('assets/icons/project2_icon1.svg') }}"
                        alt="project2_icon1"
                        class="size-16"
                    >
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



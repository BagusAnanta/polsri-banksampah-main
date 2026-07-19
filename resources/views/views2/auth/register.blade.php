<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Bank Sampah Sekanak Connect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4/dist/full.min.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=visibility,visibility_off" />
    
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

    <style>
        body {
            background-color: #FAF5EB;
        }
    </style>
</head>
<body>
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-[6fr_4fr] bg-[#FAF5EB]">
        <!-- Form Column -->
        <div class="flex flex-col justify-start px-6 sm:px-12 lg:px-16 py-8">
            <div class="w-full max-w-md mx-auto">
                <!-- Back Button & Logo -->
                <div class="flex items-center justify-between mb-10">
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm text-[#5B6E33] hover:text-[#4A5D23]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="text-sm font-medium">Kembali</span>
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-[#5B6E33] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Heading -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-stone-800 mb-2">Daftar Akun Baru</h2>
                    <p class="text-sm text-stone-500">Lengkapi data Anda untuk memulai</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('registerUser') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Nama Lengkap *</span>
                        </label>
                        <input type="text" name="name" id="name"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name') }}"
                               class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 text-stone-800 placeholder-stone-400 @error('name') input-error @enderror"
                               required />
                        @error('name') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- NIK -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">NIK (Nomor Identitas Kependudukan) *</span>
                        </label>
                        <input type="text" name="nik" id="nik"
                               placeholder="Masukkan NIK"
                               value="{{ old('nik') }}"
                               class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 text-stone-800 placeholder-stone-400 @error('nik') input-error @enderror"
                               required />
                        @error('nik') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Jenis Kelamin *</span>
                        </label>
                        <select name="gender" id="gender"
                                class="select select-bordered rounded-xl bg-[#EADDCD] text-sm text-stone-800 @error('gender') select-error @enderror"
                                required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Email *</span>
                        </label>
                        <input type="email" name="email" id="email"
                               placeholder="Masukkan email"
                               value="{{ old('email') }}"
                               class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 text-stone-800 placeholder-stone-400 @error('email') input-error @enderror"
                               required />
                        @error('email') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Nomor Telepon *</span>
                        </label>
                        <input type="tel" name="phone" id="phone"
                               placeholder="Masukkan nomor telepon"
                               value="{{ old('phone') }}"
                               class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 text-stone-800 placeholder-stone-400 @error('phone') input-error @enderror"
                               required />
                        @error('phone') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Alamat Lengkap *</span>
                        </label>
                        <textarea name="address" id="address"
                                  placeholder="Masukkan alamat lengkap"
                                  rows="3"
                                  class="textarea textarea-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 text-stone-800 placeholder-stone-400 @error('address') textarea-error @enderror"
                                  required>{{ old('address') }}</textarea>
                        @error('address') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- KTP upload -->
                    <x-ktp-upload name="foto_ktp"/>

                    <!-- Password -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Password *</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   placeholder="Buat password yang kuat"
                                   class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 pr-12 text-stone-800 placeholder-stone-400 w-full @error('password') input-error @enderror"
                                   required />
                            <button type="button" onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 transition">
                                
                                <div class="w-5 h-5 hidden" id="password-eye">
                                    <span class="material-symbols-outlined">visibility</span>
                                </div>

                                <div class="w-5 h-5" id="password-eye-off">
                                    <span class="material-symbols-outlined">visibility_off</span>
                                </div>
                            </button>
                        </div>
                        @error('password') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text text-sm font-medium text-stone-700">Konfirmasi Password *</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   placeholder="Konfirmasi password"
                                   class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 pr-12 text-stone-800 placeholder-stone-400 w-full"
                                   required />
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 transition">
                                

                                <div class="w-5 h-5 hidden" id="password_confirmation-eye">
                                    <span class="material-symbols-outlined">visibility</span>
                                </div>

                                <div class="w-5 h-5" id="password_confirmation-eye-off">
                                    <span class="material-symbols-outlined">visibility_off</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-block rounded-full bg-[#5B6E33] text-white border-none hover:bg-[#4A5D23] text-sm mt-6">
                        Daftar
                    </button>
                </form>

                <!-- Login Link -->
                <p class="text-center text-xs text-stone-400 mt-6">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="text-[#5B6E33] hover:text-[#4A5D23] font-medium transition">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <!-- Footer -->
            <p class="text-center text-xs text-stone-400 mt-12">&copy; {{ date('Y') }} Bank Sampah. Hak cipta dilindungi.</p>
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
                    <p class="text-white/80 text-sm font-medium uppercase tracking-wider mb-2">Bergabunglah Sekarang</p>
                    <h2 class="text-3xl font-bold text-white mb-3">Mulai Perjalanan Anda</h2>
                    <p class="text-white/80 text-sm leading-relaxed">
                        Daftar sebagai anggota dan mulai kumpulkan poin dari setiap setor sampah Anda.
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

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/daisyui@4/dist/index.umd.js"></script>
    <script>
        function togglePassword(id) {
            const field = document.getElementById(id);
            const eyeIcon = document.getElementById(id + '-eye');
            const eyeOffIcon = document.getElementById(id + '-eye-off');

            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            } else {
                field.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            }
        }

    </script>

    @stack('scripts')
</body>
</html>

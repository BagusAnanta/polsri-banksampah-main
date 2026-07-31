<x-layouts.app title="" subtitle="">

<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('sa.bank-sampah.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    <form action="{{ route('sa.bank-sampah.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card 1: Akun Login -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Akun Login</h3>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Username Login Admin *</span>
                </label>
                <input type="text" name="username" placeholder="Masukkan Username Admin" class="input input-bordered bg-white" required>
                @error('username') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Password *</span>
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                            placeholder="Buat password yang kuat"
                            class="input input-bordered rounded-xl bg-[#EADDCD] text-sm px-4 py-3 pr-12 text-stone-800 placeholder-stone-400 w-full @error('password') input-error @enderror"
                            required />
                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 transition">
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
        </div>

        <!-- Card 2: Informasi Bank Sampah -->
        <div class="bg-white rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Informasi Bank Sampah</h3>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Nama Bank Sampah *</span>
                </label>
                <input type="text" name="nama_bank_sampah" placeholder="Masukkan Nama Bank Sampah" class="input input-bordered bg-white" required>
                @error('nama_bank_sampah') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Alamat *</span>
                </label>
                <textarea name="alamat" placeholder="Masukkan Alamat" class="textarea textarea-bordered bg-white" rows="3" required></textarea>
                @error('alamat') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Area / Kecamatan *</span>
                </label>
                <input type="text" name="kecamatan" placeholder="Masukkan Area/Kecamatan" class="input input-bordered bg-white" required>
                @error('kecamatan') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Jam Operasional *</span>
                </label>
                <input type="text" name="jam_operasional" class="input input-bordered bg-white" placeholder="Contoh: Senin-Jumat, 08:00-16:00" required>
                @error('jam_operasional') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Nomor Telepon *</span>
                </label>
                <input type="text" name="nomor_telepon" placeholder="Masukkan Nomor Telepon" class="input input-bordered bg-white">
                @error('nomor_telepon') <label class="label"><span class="label-text-alt text-red-500">{{ $message }}</span></label> @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Deskripsi (Opsional)</span>
                </label>
                <textarea name="deskripsi" placeholder="Masukkan Deskripsi (Optional)" class="textarea textarea-bordered bg-white" rows="2"></textarea>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <a href="{{ route('sa.bank-sampah.index') }}" class="btn btn-ghost flex-1">Batal</a>
            <button type="submit" class="btn btn-primary flex-1">
                <span class="material-symbols-outlined">person_add</span> Buat Akun Admin
            </button>
        </div>
    </form>
</div>

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

</x-layouts.app>

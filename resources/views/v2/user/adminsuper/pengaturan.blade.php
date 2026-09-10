<x-layouts.app title="" subtitle="">
    
<div class="max-w-2xl mx-auto space-y-6">
    <div class="space-y-1">
        <h1 class="text-2xl font-bold text-slate-900">Pengaturan Sistem</h1>
        <p class="text-sm text-slate-600">Atur nilai konversi dan parameter sistem</p>
    </div>

    <form action="{{ route('sa.pengaturan.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Konversi Gramasi ke Poin -->
        <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Konversi Gramasi ke Poin</h3>
            <p class="text-sm text-slate-600">Tentukan berapa gram sampah setara dengan 1 poin</p>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Gram per Poin</span>
                </label>
                <div class="input-group">
                    <input type="number" name="gram_per_point" class="input input-bordered bg-[#E4CEA5] flex-1" value="{{ $setting->gram_per_point ?? 10 }}" min="1" step="0.1" required>
                </div>
                <label class="label">
                    <span class="label-text-alt">Contoh: 10 gram = 1 poin</span>
                </label>
            </div>
        </div>

        <!-- Card 2: Konversi Poin ke Voucher -->
        <div class="bg-[#E4CEA5] rounded-xl p-6 border border-slate-200 space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Konversi Poin ke Voucher</h3>
            <p class="text-sm text-slate-600">Tentukan berapa poin yang dibutuhkan untuk 1 voucher</p>
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Poin per Voucher</span>
                </label>
                <div class="input-group">
                    <input type="number" name="point_per_voucher" class="input input-bordered bg-[#E4CEA5] flex-1" value="{{ $setting->point_per_voucher ?? 500 }}" min="1" step="1" required>
                </div>
                <label class="label">
                    <span class="label-text-alt">Contoh: 500 poin = 1 voucher</span>
                </label>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
            <div class="flex gap-3">
                <span class="material-symbols-outlined text-blue-600 flex-shrink-0">info</span>
                <div class="text-sm text-blue-800">
                    <p class="font-medium">Catatan Penting</p>
                    <p class="mt-1">Perubahan nilai konversi akan berlaku untuk semua tiket baru. Tiket yang sudah diproses tidak akan terpengaruh.</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3">
            <button type="reset" class="btn flex-1 rounded-xl bg-[#E4CEA5] hover:bg-red-600">Reset</button>
            <button type="submit" class="btn flex-1 rounded-xl bg-[#A3A85C] hover:bg-[#A3A85C] text-white">
                <span class="material-symbols-outlined">save</span> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

</x-layouts.app>

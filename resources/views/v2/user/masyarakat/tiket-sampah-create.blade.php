<x-layouts.app title="Buat Tiket Setor Sampah">

    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl bg-[#E1EFE3] p-6 shadow-sm">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-base-content">Buat Tiket Setor Sampah</h1>
                <p class="mt-1 text-sm text-base-content/60">Isi form di bawah untuk membuat tiket setor sampah baru</p>
            </div>

            <form action="{{ route('tiketsetorsampahs.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="form-group">
                    <label for="berat_sampah" class="label">
                        <span class="label-text font-medium">Berat Estimasi (gram)</span>
                    </label>
                    <input 
                        type="number" 
                        id="berat_sampah"
                        name="berat_sampah" 
                        placeholder="Masukkan berat sampah dalam gram"
                        class="input input-bordered bg-[#F3F8F4] w-full rounded-lg @error('berat_sampah') input-error @enderror"
                        min="1"
                        required
                    >
                    @error('berat_sampah')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Estimasi akan menjadi berat aktual, dapat diubah oleh petugas bank sampah</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="banksampah_id" class="label">
                        <span class="label-text font-medium">Pilih Bank Sampah</span>
                    </label>
                    <select 
                        id="banksampah_id"
                        name="banksampah_id"
                        class="select select-bordered bg-[#F3F8F4] w-full rounded-lg @error('banksampah_id') select-error @enderror"
                        required
                    >
                        <option value="">-- Pilih Bank Sampah --</option>
                        @foreach($banksampahusers ?? [] as $bank)
                            <option value="{{ $bank->banksampah_id }}">{{ $bank->nama_bank_sampah }}</option>
                        @endforeach
                    </select>
                    @error('banksampah_id')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="divider my-4"></div>

                <div class="space-y-3">
                    <h3 class="font-medium text-base-content">Ringkasan</h3>
                    <div class="rounded-lg bg-base-200/50 p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Berat Sampah:</span>
                            <span id="summary_berat" class="font-semibold">0 gram</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Poin Estimasi:</span>
                            <span id="summary_poin" class="font-semibold text-olive-700">0 poin</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('tiket-sampah.index') }}" class="btn btn-outline flex-1 rounded-lg text-sm text-base-content hover:bg-red-700">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary flex-1 rounded-lg bg-[#1B3B2B] border-none hover:bg-[#14532D] text-white">
                        Buat Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const beratInput = document.getElementById('berat_sampah');
        const summaryBerat = document.getElementById('summary_berat');
        const summaryPoin = document.getElementById('summary_poin');
        
        const gramPerPoint = {{ $gramPerPoint ?? 1000 }};

        function updateSummary() {
            const berat = parseInt(beratInput.value) || 0;
            const poin = Math.floor(berat / gramPerPoint);
            
            summaryBerat.textContent = berat.toLocaleString('id-ID') + ' gram';
            summaryPoin.textContent = poin.toLocaleString('id-ID') + ' poin';
        }

        beratInput.addEventListener('input', updateSummary);
        updateSummary();
    </script>
    @endpush

</x-layouts.app>

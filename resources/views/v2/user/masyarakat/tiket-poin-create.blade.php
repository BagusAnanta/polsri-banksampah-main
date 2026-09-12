<x-layouts.app title="Buat Tiket Tukar Poin">

    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl bg-[#E1EFE3] p-6 shadow-sm">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-base-content">Buat Tiket Tukar Poin</h1>
                <p class="mt-1 text-sm text-base-content/60">Tukarkan poin Anda dengan voucher di bank sampah pilihan</p>
            </div>

            <form action="{{ route('tikettukarpoin.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="alert alert-info bg-[#16A34A]" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Poin Anda saat ini: <strong>{{ $userCurrentPoints ?? 0 }}</strong> poin</span>
                </div>

                <div class="form-group">
                    <label for="poin" class="label">
                        <span class="label-text font-medium">Jumlah Poin</span>
                    </label>
                    <input 
                        type="number" 
                        id="poin"
                        name="poin" 
                        placeholder="Masukkan jumlah poin yang ingin ditukar"
                        class="input input-bordered bg-[#F3F8F4] w-full rounded-lg @error('poin') input-error @enderror"
                        min="1"
                    >
                    @error('poin')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Masukkan jumlah poin atau jumlah voucher di bawah</span>
                    </label>
                </div>

                <div class="divider">atau</div>

                <div class="form-group">
                    <label for="voucher" class="label">
                        <span class="label-text font-medium">Jumlah Voucher</span>
                    </label>
                    <input 
                        type="number" 
                        id="voucher"
                        name="voucher"
                        placeholder="Masukkan jumlah voucher yang ingin diperoleh"
                        class="input input-bordered bg-[#F3F8F4] w-full rounded-lg"
                        min="1"
                    >
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">1 voucher = {{ $pointPerVoucher ?? 500 }} poin</span>
                    </label>
                </div>

                <div id="error-container" class="alert alert-error hidden" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2m2-2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span id="error-text"></span>
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
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Pilih bank sampah tempat Anda melakukan setor sampah sebelumnya</span>
                    </label>
                </div>

                <div class="divider my-4"></div>

                <div class="space-y-3">
                    <h3 class="font-medium text-base-content">Ringkasan</h3>
                    <div class="rounded-lg bg-base-200/50 p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Jumlah Poin:</span>
                            <span id="summary_poin" class="font-semibold">0 poin</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Jumlah Voucher:</span>
                            <span id="summary_voucher" class="font-semibold text-olive-700">0 voucher</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('tiket-poin.index') }}" class="btn btn-outline flex-1 rounded-lg text-sm text-base-content hover:bg-red-700">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn" class="btn btn-primary flex-1 rounded-lg bg-[#1B3B2B] border-none hover:bg-[#14532D] text-white" disabled>
                        Buat Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const poinInput = document.getElementById('poin');
        const voucherInput = document.getElementById('voucher');
        const submitBtn = document.getElementById('submit-btn');
        const errorContainer = document.getElementById('error-container');
        const errorText = document.getElementById('error-text');
        const summaryPoin = document.getElementById('summary_poin');
        const summaryVoucher = document.getElementById('summary_voucher');
        
        const pointPerVoucher = {{ $pointPerVoucher ?? 500 }};
        const userCurrentPoints = {{ $userCurrentPoints ?? 0 }};

        function clearError() {
            errorContainer.classList.add('hidden');
            errorText.textContent = '';
        }

        function showError(message) {
            errorText.textContent = message;
            errorContainer.classList.remove('hidden');
        }

        function validateAndUpdate() {
            clearError();
            submitBtn.disabled = true;

            const poin = parseInt(poinInput.value) || 0;
            const voucher = parseInt(voucherInput.value) || 0;

            if (poin === 0 && voucher === 0) {
                submitBtn.disabled = true;
                summaryPoin.textContent = '0 poin';
                summaryVoucher.textContent = '0 voucher';
                return;
            }

            if (poin > 0 && voucher === 0) {
                if (poin > userCurrentPoints) {
                    showError(`Poin tidak mencukupi. Anda hanya memiliki ${userCurrentPoints} poin.`);
                    return;
                }
                
                const calculatedVoucher = Math.floor(poin / pointPerVoucher);
                voucherInput.value = calculatedVoucher;
                summaryPoin.textContent = poin.toLocaleString('id-ID') + ' poin';
                summaryVoucher.textContent = calculatedVoucher.toLocaleString('id-ID') + ' voucher';
                
                if (poin >= pointPerVoucher) {
                    submitBtn.disabled = false;
                } else {
                    showError(`Poin minimal untuk 1 voucher adalah ${pointPerVoucher} poin.`);
                }
            } 
            else if (voucher > 0 && poin === 0) {
                const calculatedPoin = voucher * pointPerVoucher;
                
                if (calculatedPoin > userCurrentPoints) {
                    showError(`Poin tidak mencukupi. Untuk ${voucher} voucher Anda membutuhkan ${calculatedPoin} poin, namun Anda hanya memiliki ${userCurrentPoints} poin.`);
                    return;
                }
                
                poinInput.value = calculatedPoin;
                summaryPoin.textContent = calculatedPoin.toLocaleString('id-ID') + ' poin';
                summaryVoucher.textContent = voucher.toLocaleString('id-ID') + ' voucher';
                submitBtn.disabled = false;
            }
            else if (poin > 0 && voucher > 0) {
                const expectedPoin = voucher * pointPerVoucher;
                if (poin !== expectedPoin) {
                    showError(`Poin dan voucher tidak sesuai. ${voucher} voucher harus sama dengan ${expectedPoin} poin.`);
                    return;
                }
                
                if (poin > userCurrentPoints) {
                    showError(`Poin tidak mencukupi. Anda hanya memiliki ${userCurrentPoints} poin.`);
                    return;
                }
                
                summaryPoin.textContent = poin.toLocaleString('id-ID') + ' poin';
                summaryVoucher.textContent = voucher.toLocaleString('id-ID') + ' voucher';
                submitBtn.disabled = false;
            }
        }

        poinInput.addEventListener('input', validateAndUpdate);
        voucherInput.addEventListener('input', validateAndUpdate);
    </script>
    @endpush

</x-layouts.app>

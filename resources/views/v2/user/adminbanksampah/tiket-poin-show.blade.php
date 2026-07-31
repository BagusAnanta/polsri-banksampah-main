<x-layouts.app title="" subtitle="">

<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.tiket-poin.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
        <button class="btn btn-outline btn-sm gap-2" data-modal="qrScanModal">
            <span class="material-symbols-outlined">qr_code_2</span>
            Scan QR
        </button>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-6">
        <!-- Header -->
        <div class="text-center border-b border-slate-100 pb-4">
            <p class="text-sm text-slate-500 font-medium">Tiket Tukar Poin</p>
            <p class="text-xl font-bold text-slate-900 mt-1">#{{ $tiket->tiketpoin_inc ?? $tiket->tiketpoin_id }}</p>
            <div class="mt-2">
                <x-layouts.status-badge status="$tiket->status" />
            </div>
            <p class="text-xs text-slate-500 mt-2">
                {{ \Carbon\Carbon::parse($tiket->created_at)->locale('id')->translatedFormat('l, d F Y H:i') }}
            </p>
        </div>

        <!-- Identitas Warga -->
        <div class="space-y-3">
            <h4 class="text-sm font-semibold text-slate-900">Identitas Warga</h4>
            <div class="space-y-2 bg-slate-50 rounded-lg p-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Nama</span>
                    <span class="font-medium text-slate-900">{{ $tiket->masyarakat->user->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">No. Telepon</span>
                    <span class="font-medium text-slate-900">{{ $tiket->masyarakat->user->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">NIK</span>
                    <span class="font-medium text-slate-900">{{ $tiket->masyarakat->nik ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Penukaran -->
        <div class="space-y-3">
            <h4 class="text-sm font-semibold text-slate-900">Detail Penukaran</h4>
            <div class="space-y-2 bg-slate-50 rounded-lg p-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Poin Ditukar</span>
                    <span class="font-medium text-slate-900">{{ number_format($tiket->poin, 0) }} poin</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Voucher</span>
                    <span class="font-medium text-slate-900">{{ $tiket->voucher_count ?? 0 }} item</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if($tiket->status === 'Menunggu')
            <form action="{{ route('admin.tiket-poin.validate', $tiket->tiketpoin_id) }}" method="POST" class="flex gap-3">
                @csrf
                @method('PUT')
                <button type="submit" name="action" value="setuju" class="btn btn-success flex-1 gap-2">
                    <span class="material-symbols-outlined">check_circle</span> Setuju & Terbitkan
                </button>
                <button type="submit" name="action" value="batalkan" class="btn btn-ghost text-red-600 hover:bg-red-50 flex-1 gap-2" onclick="return confirm('Batalkan tiket ini?')">
                    <span class="material-symbols-outlined">cancel</span> Batalkan
                </button>
            </form>
        @else
            <div class="p-3 bg-slate-100 text-slate-600 text-sm rounded-lg text-center">
                Tiket sudah diproses dan tidak dapat diubah
            </div>
        @endif
    </div>
</div>

<!-- QR Scan Modal -->
<dialog id="qrScanModal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Scan QR Tiket</h3>
        <div id="qrReader" class="my-4"></div>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Tutup</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.1.5/html5-qrcode.min.js"></script>
<script>
    const modal = document.getElementById('qrScanModal');
    document.querySelector('[data-modal="qrScanModal"]')?.addEventListener('click', () => {
        modal?.showModal();
        setTimeout(() => {
            const html5QrcodeScanner = new Html5QrcodeScanner(
                "qrReader",
                { fps: 10, qrbox: { width: 250, height: 250 } },
                false
            );
            html5QrcodeScanner.render((decodedText) => {
                console.log("QR Code:", decodedText);
                html5QrcodeScanner.clear();
                modal?.close();
            });
        }, 100);
    });
</script>
@endpush

</x-layouts>

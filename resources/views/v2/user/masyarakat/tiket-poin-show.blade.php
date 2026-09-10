<x-layouts.app title="Detail Tiket Tukar Poin" subtitle="Tiket #{{ $tiket->tiketpoin_inc }}">

    <div class="mx-auto max-w-md">
        <div class="card divide-y divide-base-300/40 rounded-2xl bg-[#E4CEA5] shadow-sm">
            <div class="card-body gap-4 p-6">

                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-base-content/50">
                            Tiket Tukar Poin
                        </p>
                        <p class="text-3xl font-bold text-olive-800">#{{ $tiket->tiketpoin_inc }}</p>
                        <p class="mt-1 text-xs text-base-content/50">
                            {{ $tiket->created_at->translatedFormat('l, d M Y · H:i') }}
                        </p>
                    </div>
                    <div class="mt-1">
                        <x-layouts.status-badge :status="strtolower($tiket->status)" />
                    </div>

                    <!-- <span @class([
                        'inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium whitespace-nowrap flex-shrink-0',
                        'bg-amber-100 text-amber-700' => strtolower($tiket->status) === 'menunggu',
                        'bg-green-100 text-green-700' => strtolower($tiket->status) === 'selesai',
                        'bg-red-100 text-red-700' => strtolower($tiket->status) === 'dibatalkan',
                    ])>
                        {{ $tiket->status }}
                    </span> -->
                </div>

                <div class="pt-4">
                    <p class="mb-2 text-xs font-medium uppercase tracking-wide text-base-content/50">
                        Identitas Bank Sampah
                    </p>

                    <div class="flex items-start gap-3 rounded-xl bg-base-200/50 p-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-olive-100 text-olive-700">
                            🏢
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold">{{ $tiket->bankSampahUser->nama_bank_sampah ?? 'N/A' }}</p>
                            <p class="text-base-content/60">{{ $tiket->bankSampahUser->alamat ?? 'N/A' }}</p>
                            <p class="text-base-content/60">{{ $tiket->bankSampahUser->nomor_telepon ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="mb-2 text-xs font-medium uppercase tracking-wide text-base-content/50">
                        Detail Penukaran
                    </p>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-base-content/50">Poin Ditukar</p>
                            <p class="text-lg font-semibold">{{ number_format($tiket->poin) }} poin</p>
                        </div>
                        <div>
                            <p class="text-xs text-base-content/50">Jumlah Voucher</p>
                            <p class="text-lg font-semibold">
                                @php
                                    $setting = \App\Models\Setting::first();
                                    $pointPerVoucher = $setting ? $setting->point_per_voucher : 500;
                                    $voucherCount = $pointPerVoucher > 0 ? floor($tiket->poin / $pointPerVoucher) : 0;
                                @endphp
                                {{ $voucherCount }} voucher
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-base-content/50">Tanggal Pengajuan</p>
                            <p class="text-sm font-medium">{{ $tiket->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>

                    @if(strtolower($tiket->status) === 'selesai')
                        <div class="mt-3 flex items-center gap-2 rounded-xl bg-green-50 p-3">
                            <span class="text-green-600">🎟️</span>
                            <p class="text-sm text-green-700">
                                Voucher sudah diterbitkan, cek di menu Riwayat.
                            </p>
                        </div>
                    @endif
                </div>

                @if(strtolower($tiket->status) === 'menunggu')
                    <div class="flex gap-3 pt-4">
                        <button
                            type="button"
                            class="btn flex-1 rounded-full border-none bg-base-200 text-sm font-medium hover:bg-base-300"
                            onclick="document.getElementById('qr-modal-{{ $tiket->tiketpoin_id }}').showModal()"
                        >
                            Lihat QR
                        </button>

                        <form method="POST" action="{{ route('tiket-poin.cancel', $tiket->tiketpoin_id) }}" class="flex-1">
                            @csrf
                            @method('PUT')
                            <button
                                type="submit"
                                class="btn w-full rounded-full border-none bg-red-100 text-sm font-medium text-red-500 hover:bg-red-200"
                                onclick="return confirm('Batalkan tiket ini?')"
                            >
                                Batalkan
                            </button>
                        </form>
                    </div>

                    <dialog id="qr-modal-{{ $tiket->tiketpoin_id }}" class="modal">
                        <div class="modal-box max-w-xs text-center">
                            <h3 class="font-semibold">QR Tiket #{{ $tiket->tiketpoin_inc }}</h3>
                            <p class="mb-4 text-xs text-base-content/50">Tunjukkan ke petugas bank sampah</p>
                            <div id="qr_{{ $tiket->tiketpoin_id }}" class="mx-auto"></div>
                            <div class="modal-action justify-center">
                                <form method="dialog">
                                    <button class="btn btn-sm rounded-full">Tutup</button>
                                </form>
                            </div>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>

                    @push('scripts')
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                    <script>
                        new QRCode(document.getElementById("qr_{{ $tiket->tiketpoin_id }}"), {
                            text: "{{ $tiket->qr_code_id }}",
                            width: 200,
                            height: 200,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    </script>
                    @endpush
                @endif

            </div>
        </div>
    </div>

</x-layouts.app>

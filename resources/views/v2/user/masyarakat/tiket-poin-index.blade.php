<x-layouts.app title="Tukar Poin" :subtitle="($tikets ?? collect())->count() . ' tiket tercatat'">

     <x-slot name="actions">
        <a href="{{ route('tiket-poin.create') }}"
           class="btn btn-sm w-full rounded-lg bg-[#A3A85C] text-white hover:bg-olive-800 sm:w-auto sm:rounded-full">
             + Tukar Poin
        </a>
    </x-slot>

    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div class="rounded-xl bg-[#E4CEA5] from-blue-50 to-blue-100 p-4">
            <p class="text-xs text-blue-600 sm:text-sm">Poin Saya</p>
            <p class="text-xl font-bold text-blue-700 sm:text-2xl">{{ number_format($totalGramasi ?? 0) }}</p>
        </div>
        <div class="rounded-xl bg-[#E4CEA5] from-amber-50 to-amber-100 p-4">
            <p class="text-xs text-amber-600 sm:text-sm">Menunggu</p>
            <p class="text-xl font-bold text-amber-700 sm:text-2xl">{{ ($tikets ?? collect())->where('status', 'Menunggu')->count() }}</p>
        </div>
        <div class="rounded-xl bg-[#E4CEA5] from-green-50 to-green-100 p-4">
            <p class="text-xs text-green-600 sm:text-sm">Selesai</p>
            <p class="text-xl font-bold text-green-700 sm:text-2xl">{{ ($tikets ?? collect())->where('status', 'Selesai')->count() }}</p>
            <p class="mt-0.5 text-xs text-green-600/70">tiket</p>
        </div>
    </div>

     <div class="space-y-3">
        @forelse($tikets ?? collect() as $tiket)
            <div class="overflow-hidden rounded-xl bg-base-200/50 transition hover:bg-[#E4CEA5]">
                <div class="p-3 sm:p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-base-content sm:text-sm">Tiket #{{ $tiket->tiketpoin_inc }}</p>
                            <p class="text-xs text-base-content/50">{{ $tiket->created_at->translatedFormat('d M Y H:i') }}</p>
                        </div>
                        <div class="mt-1">
                            <x-layouts.status-badge :status="strtolower($tiket->status)" />
                        </div>

                        <!-- <span @class([
                            'rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap',
                            'bg-amber-100 text-amber-600' => strtolower($tiket->status) === 'menunggu',
                            'bg-green-100 text-green-600' => strtolower($tiket->status) === 'selesai',
                            'bg-red-100 text-red-600' => strtolower($tiket->status) === 'ditolak' || strtolower($tiket->status) === 'dibatalkan',
                        ])>
                            {{ $tiket->status }}
                        </span> -->
                    </div>

                    <div class="mb-3 flex flex-wrap gap-2 text-xs">
                        @if($tiket->bankSampahUser)
                            <span class="rounded-full bg-base-300/50 px-2.5 py-0.5">{{ $tiket->bankSampahUser->nama_bank_sampah }}</span>
                        @endif
                        <span class="rounded-full bg-base-300/50 px-2.5 py-0.5">{{ number_format($tiket->poin ?? 0) }} poin</span>
                    </div>

                    @if(strtolower($tiket->status) === 'menunggu')
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <button class="btn btn-outline btn-sm flex-1 rounded-lg text-xs" 
                                    onclick="document.getElementById('qr_modal_{{ $tiket->tiketpoin_id }}').showModal()">
                                    <span class="material-symbols-outlined">qr_code_2</span>
                                    Tampilkan QR
                            </button>
                            <form method="POST" action="{{ route('tiket-poin.cancel', $tiket->tiketpoin_id) }}" class="flex-1">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-error btn-sm w-full rounded-lg text-xs text-white">
                                    Batalkan
                                </button>
                            </form>
                        </div>

                        <dialog id="qr_modal_{{ $tiket->tiketpoin_id }}" class="modal">
                            <div class="modal-box w-full max-w-xs">
                                <h3 class="text-lg font-bold">QR Code Tiket</h3>
                                <div class="py-4 text-center">
                                    <div id="qr_{{ $tiket->tiketpoin_id }}" class="mx-auto"></div>
                                    <p class="mt-2 text-sm text-base-content/60">Tiket #{{ $tiket->tiketpoin_inc }}</p>
                                </div>
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
                    @else
                        <a href="{{ route('tiket-poin.show', $tiket->tiketpoin_id) }}" class="btn btn-outline btn-sm w-full rounded-lg text-xs">
                            Lihat Detail
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-xl bg-base-200/30 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-base-content/50">Belum ada tiket poin</p>
                <a href="{{ route('tiket-poin.create') }}" class="btn btn-sm mt-3 rounded-full bg-[#A3A85C] text-white hover:bg-olive-800 sm:w-auto sm:rounded-full">
                    Buat Tiket Pertama
                </a>
            </div>
        @endforelse
    </div>
</x-layouts.app>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@endpush


<x-layouts.app title="Riwayat Transaksi" subtitle="Riwayat setor sampah dan tukar poin selesai">

    <div class="rounded-2xl bg-[#E1EFE3] p-5 shadow-sm">
        <h3 class="text-base font-semibold text-base-content mb-4">Riwayat Transaksi</h3>

        @if(count($riwayat ?? []) > 0)
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-base-content/50">
                            <th>ID Tiket</th>
                            <th>Tanggal</th>
                            <th>Bank Sampah</th>
                            <th>Detail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat ?? [] as $item)
                            <tr class="hover:bg-base-200/40 transition">
                                <td class="font-medium text-sm">
                                    #{{ $item['nomor'] ?? $item->nomor ?? '-' }}
                                </td>
                                <td class="text-sm text-base-content/60">
                                    {{ \Carbon\Carbon::parse($item['tanggal'] ?? $item->tanggal)->translatedFormat('d M Y H:i') }}
                                </td>
                                <td class="text-sm">
                                    {{ $item['bank_sampah'] ?? $item->bank_sampah ?? '-' }}
                                </td>
                                <td class="text-sm">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ ($item['type'] ?? $item->type) === 'sampah' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ($item['type'] ?? $item->type) === 'sampah' ? 'Setor Sampah' : 'Tukar Poin' }}
                                    </span>
                                    <span class="ml-2 text-xs">
                                        {{ $item['nilai'] ?? $item->nilai ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-xl bg-base-200/30 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-base-content/50">Belum ada riwayat transaksi selesai</p>
                <a href="{{ route('tiket-sampah.create') }}" class="btn btn-sm mt-3 rounded-full bg-[#16A34A] text-white hover:bg-olive-800 sm:w-auto sm:rounded-full">
                    Setor Sampah Sekarang
                </a>
            </div>
        @endif
    </div>

</x-layouts.app>

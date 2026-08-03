<x-layouts.app title="" subtitle="">

<div class="max-w-xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.tiket-setor.index') }}" class="btn btn-ghost btn-sm">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-slate-200 space-y-6">
        <!-- Header -->
        <div class="text-center border-b border-slate-100 pb-4">
            <p class="text-sm text-slate-500 font-medium">Tiket Setor Sampah</p>
            <p class="text-xl font-bold text-slate-900 mt-1">#{{ $tiket->tiketsampah_inc ?? $tiket->tiketsampah_id }}</p>
             <span @class([
                            'rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap mt-2',
                            'bg-amber-100 text-amber-600' => strtolower($tiket->status) === 'menunggu',
                            'bg-green-100 text-green-600' => strtolower($tiket->status) === 'selesai',
                            'bg-red-100 text-red-600' => strtolower($tiket->status) === 'ditolak' || strtolower($tiket->status) === 'dibatalkan',
                ])>
                    {{ $tiket->status }}
            </span>
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

        <!-- Detail Sampah -->
        <div class="space-y-3">
            <h4 class="text-sm font-semibold text-slate-900">Detail Sampah</h4>
            <div class="space-y-2 bg-slate-50 rounded-lg p-3">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Estimasi Berat</span>
                    <span class="font-medium text-slate-900">{{ number_format($tiket->berat_sampah, 0) }} gram</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">Nilai Konversi</span>
                    <span class="font-medium text-slate-900">1 gram = {{ number_format($gramPerPoint, 2) }} poin</span>
                </div>
            </div>
        </div>

        <!-- Validasi Tiket -->
        <div class="space-y-3">
            <h4 class="text-sm font-semibold text-slate-900">Validasi Tiket</h4>
            <form action="{{ route('admin.tiket-setor.validate', $tiket->tiketsampah_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-3 bg-slate-50 rounded-lg p-3">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-slate-900">Gramasi Aktual (gram)</span>
                        </label>
                        <input type="number" name="berat_aktual" id="beratAktual"
                            class="input input-bordered bg-white"
                            value="{{ $tiket->berat_sampah_actual ?? $tiket->berat_sampah }}"
                            {{ $tiket->status !== 'Menunggu' ? 'disabled' : '' }}
                            min="0" step="1" required>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium text-slate-900">Poin yang Diberikan</span>
                        </label>
                        <input type="number" name="poin" id="poinHasil"
                            class="input input-bordered bg-white"
                            value="{{ $tiket->poin ?? 0 }}"
                            {{ $tiket->status !== 'Menunggu' ? 'disabled' : '' }}
                            readonly>
                    </div>
                </div>
                @if($tiket->status === 'Menunggu')
                    <div class="flex gap-3 mt-4">
                        <button type="submit" name="action" value="setuju" class="btn btn-success flex-1 gap-2">
                            <span class="material-symbols-outlined">check_circle</span> Setuju
                        </button>
                        <button type="submit" name="action" value="tolak" class="btn btn-ghost text-red-600 hover:bg-red-50 flex-1 gap-2" onclick="return confirm('Tolak tiket ini?')">
                            <span class="material-symbols-outlined">cancel</span> Tolak
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const gramPerPoint = {{ $gramPerPoint ?? 1 }};
    const beratInput = document.getElementById('beratAktual');
    const poinOutput = document.getElementById('poinHasil');

    function hitungPoin() {
        const berat = parseFloat(beratInput.value) || 0;
        poinOutput.value = Math.floor(berat / gramPerPoint);
    }

    beratInput?.addEventListener('input', hitungPoin);
    hitungPoin();
</script>
@endpush

</x-layouts>

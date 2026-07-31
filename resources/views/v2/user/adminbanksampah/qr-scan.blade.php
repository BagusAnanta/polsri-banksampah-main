<x-layouts.app title="" subtitle="">

<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl p-6 border border-slate-200">
            <div class="text-center space-y-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                    <span class="material-symbols-outlined text-blue-600" style="font-size: 32px;">qr_code_2</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Scan QR Tiket</h1>
                <p class="text-sm text-slate-600">Arahkan kamera ke QR code pada tiket pengajuan</p>
            </div>

            <div id="qrReader" class="my-6 rounded-lg overflow-hidden border-2 border-blue-200" style="width: 100%;"></div>

            <div class="space-y-2 text-sm text-slate-600">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <p class="font-medium text-blue-900">Hasil Scan:</p>
                    <p id="scanResult" class="text-sm mt-1 font-mono">Menunggu pemindaian...</p>
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <button id="startScan" class="btn btn-primary flex-1 gap-2">
                    <span class="material-symbols-outlined">play_arrow</span> Mulai Scan
                </button>
                <button id="stopScan" class="btn btn-ghost flex-1 gap-2" disabled>
                    <span class="material-symbols-outlined">stop</span> Berhenti
                </button>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline w-full mt-2">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.1.5/html5-qrcode.min.js"></script>
<script>
    let scanner;
    const startBtn = document.getElementById('startScan');
    const stopBtn = document.getElementById('stopScan');
    const resultEl = document.getElementById('scanResult');

    startBtn.addEventListener('click', () => {
        if (!scanner) {
            scanner = new Html5QrcodeScanner('qrReader', {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                rememberLastUsedCamera: true
            }, false);
        }

        scanner.render(
            (decodedText) => {
                resultEl.textContent = `✓ ${decodedText}`;
                resultEl.classList.remove('text-slate-600');
                resultEl.classList.add('text-green-600');
                setTimeout(() => {
                    window.location.href = `/admin/tiket/${decodedText}`;
                }, 1500);
            },
            (errorMessage) => {
                resultEl.textContent = 'Scanning...';
            }
        );

        startBtn.disabled = true;
        stopBtn.disabled = false;
    });

    stopBtn.addEventListener('click', () => {
        if (scanner) {
            scanner.clear();
            scanner = null;
        }
        startBtn.disabled = false;
        stopBtn.disabled = true;
        resultEl.textContent = 'Scan dihentikan';
        resultEl.classList.add('text-slate-600');
    });
</script>
@endpush

</x-layouts>

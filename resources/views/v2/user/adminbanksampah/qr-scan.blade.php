<x-layouts.app title="" subtitle="">

<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm">
        <div class="bg-[#E4CEA5] rounded-2xl p-6 border border-slate-200">
            <div class="text-center space-y-4">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                    <span class="material-symbols-outlined text-blue-600" style="font-size: 32px;">qr_code_2</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900">Scan QR Tiket</h1>
                <p class="text-sm text-slate-600">Arahkan kamera ke QR code pada tiket pengajuan</p>
            </div>

            <div id="qrReader" class="my-6 rounded-lg overflow-hidden border-2 border-white" style="width: 100%; height: 280px; position: relative;"></div>

            <div class="space-y-2 text-sm text-slate-600">
                <div class="p-3 bg-[#A3A85C] rounded-lg">
                    <p class="font-medium text-white">Hasil Scan:</p>
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
    let scanner = null;
    const startBtn = document.getElementById('startScan');
    const stopBtn = document.getElementById('stopScan');
    const resultEl = document.getElementById('scanResult');

    function setResult(text, ok = false) {
        resultEl.textContent = text;
        resultEl.classList.toggle('text-green-600', ok);
        resultEl.classList.toggle('text-red-600', !ok && text !== 'Menunggu pemindaian...');
    }

    if (window.isSecureContext === false) {
        setResult('⚠️ Kamera hanya bisa diakses melalui HTTPS atau localhost');
    }

    startBtn.addEventListener('click', async () => {
        if (scanner) return;

        if (typeof Html5Qrcode === 'undefined') {
            setResult('⚠️ Library pemindai gagal dimuat. Periksa koneksi internet.');
            return;
        }

        scanner = new Html5Qrcode('qrReader');

        try {
            await scanner.start(
                { facingMode: 'environment' },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                (decodedText) => {
                    setResult(`✓ ${decodedText}`, true);
                    setTimeout(() => {
                        window.location.href = `/admin/tiket-setor/${decodedText}`;
                    }, 1500);
                },
                (errorMessage) => {
                    if (resultEl.textContent === 'Menunggu pemindaian...') {
                        setResult('Scanning...');
                    }
                }
            );

            startBtn.disabled = true;
            stopBtn.disabled = false;
        } catch (err) {
            scanner = null;
            let msg = 'Tidak dapat mengakses kamera.';
            if (err && (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError')) {
                msg = '⚠️ Izin kamera ditolak. Izinkan akses kamera di browser, lalu coba lagi.';
            } else if (err && (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError')) {
                msg = '⚠️ Tidak ada kamera yang terdeteksi pada perangkat.';
            } else if (err && err.name === 'NotReadableError') {
                msg = '⚠️ Kamera sedang digunakan aplikasi lain. Tutup aplikasi tersebut lalu coba lagi.';
            } else if (!window.isSecureContext) {
                msg = '⚠️ Kamera hanya bisa diakses melalui HTTPS atau localhost.';
            }
            setResult(msg);
        }
    });

    stopBtn.addEventListener('click', async () => {
        if (!scanner) return;

        try {
            await scanner.stop();
            scanner.clear();
        } catch (e) {
            // abaikan error saat menghentikan
        }

        scanner = null;
        startBtn.disabled = false;
        stopBtn.disabled = true;
        setResult('Menunggu pemindaian...');
    });
</script>
@endpush

</x-layouts>

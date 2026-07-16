<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        width: 100%;
    }
    .popup-content {
        text-align: center;
        font-family: Arial, sans-serif;
    }
</style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <?php
                    $previousUrl = session('previous_url', route('dashboard')); // Default ke halaman index

                    // Validasi URL agar hanya dari domain aplikasi
                    if (!str_contains($previousUrl, config('app.url'))) {
                        $previousUrl = route('dashboard'); // Pastikan URL aman
                    }
                ?>

                <a href="<?php echo e($previousUrl); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Maps</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div id="map"></div>
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    const boxes = <?php echo json_encode($box, 15, 512) ?>;

    // Inisialisasi peta tanpa setView awal, karena akan menggunakan fitBounds nanti
    var map = L.map('map');

    // Tambahkan layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Ikon kustom untuk box sampah
    var trashIcon = L.icon({
        iconUrl: '<?php echo e(asset('img/recycle-bin1.png')); ?>', // Path relatif ke gambar lokal
        iconSize: [42, 42], // Ukuran ikon
        iconAnchor: [16, 32], // Titik anchor ikon di tengah bawah
        popupAnchor: [0, -32] // Posisi popup relatif terhadap ikon
    });

    // Menentukan bounds untuk mencakup semua marker
    var bounds = [];

    // Menambahkan marker dengan ikon kustom untuk setiap box sampah
    boxes.forEach(box => {
        // Menambahkan koordinat ke bounds
        bounds.push([box.latitude, box.longitude]);

        // Membuat marker
        L.marker([box.latitude, box.longitude], { icon: trashIcon }).addTo(map)
            .bindTooltip(box.id_box, { 
                permanent: true, 
                direction: 'top' 
            }) // Tooltip khusus
            .bindPopup(
                '<div style="text-align: center;">' +
                    '<b>' + box.id_box + '</b>' +
                    '<hr>' +
                    '<p>' + (box.description || 'Deskripsi tidak tersedia') + '</p>' +
                '</div>'
            );
    });

    // Menyesuaikan tampilan peta agar mencakup semua marker
    if (bounds.length > 0) {
        map.fitBounds(bounds);
    } else {
        // Jika tidak ada marker, set view default ke Jakarta
        map.setView([-6.1751, 106.8650], 12);
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/dashboard/maps.blade.php ENDPATH**/ ?>
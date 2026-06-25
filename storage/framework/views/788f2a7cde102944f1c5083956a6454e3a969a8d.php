<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('users.index')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Jenis Sampah</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="edit-profile">
        <form action="<?php echo e(route('jenis_sampahs.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <div class="mb-3">
                    <label class="form-label" for="nama">Jenis Sampah</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="nama" name="nama" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="gramasi">Satuan</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="gramasi" name="gramasi" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="harga">Harga</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="harga" name="harga" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="catatan">Catatan</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="catatan" name="catatan" class="form-control">
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" style="width: 100%" class="btn btn-success">SIMPAN</button>
            </div>
        </form>
    </div>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, '', '<?php echo e(route('dashboard')); ?>');
        }

        document.getElementById('harga').addEventListener('input', function(e) {
            let value = e.target.value;
            // Hapus semua selain angka dan koma
            value = value.replace(/[^0-9,]/g, '');
            // Format ribuan
            let parts = value.split(',');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            e.target.value = parts.join(',');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/jenis-sampah/create.blade.php ENDPATH**/ ?>
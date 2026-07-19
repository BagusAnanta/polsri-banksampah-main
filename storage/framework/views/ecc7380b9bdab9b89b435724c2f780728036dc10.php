<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Box Sampah</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="edit-profile">
        <form action="<?php echo e(route('box-sampahs.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <div class="mb-3">
                    <label class="form-label" for="id_box">ID Box</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="id_box" name="id_box" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="latitude">Latitude</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="latitude" name="latitude" class="form-control" required
                            placeholder="-6.208764">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="longitude">Longitude</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="longitude" name="longitude" class="form-control" required
                            placeholder="106.845599">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="description" name="description" class="form-control" required>
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/box-sampah/create.blade.php ENDPATH**/ ?>
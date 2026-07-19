<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('users.index')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Product</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="edit-profile">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="<?php echo e(route('data-products.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <div class="mb-3">
                    <label class="form-label" for="name">Nama</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="price">Harga</label>
                    <div class="input-group input-mini input-sm">
                        <input type="number" id="price" name="price" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Deskripsi</label>
                    <div class="input-group input-mini input-sm">
                        <input type="text" id="description" name="description" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="image">Gambar</label>
                    <div class="input-group">
                        <input type="file" id="image" name="image" class="form-control">
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

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/data-products/create.blade.php ENDPATH**/ ?>
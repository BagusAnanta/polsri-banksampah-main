<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('laporan-pengaduans.index')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Tambah Laporan</h4>
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
        <form action="<?php echo e(route('laporan-pengaduans.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group mb-3">
                <label for="box_sampah_id">Pilih Box Sampah</label>
                <select name="box_sampah_id" id="box_sampah_id" class="form-control" required>
                    <option value="">-- Pilih Box Sampah --</option>
                    <?php $__currentLoopData = $boxSampahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($box->id); ?>"><?php echo e($box->id_box); ?> (<?php echo e($box->latitude); ?>,
                            <?php echo e($box->longitude); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
        </form>
    </div>

    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/laporan-pengaduan/create.blade.php ENDPATH**/ ?>
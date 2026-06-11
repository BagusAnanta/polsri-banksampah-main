<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Laporan Pengaduan</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                <a href="<?php echo e(route('laporan-pengaduans.create')); ?>">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <ul>
            <?php $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li onclick="location.href='<?php echo e(route('laporan-pengaduans.show', $laporan->id)); ?>'">
                    <div class="dz-card list">
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title">
                                    <?php echo e(ucfirst($laporan->boxSampah->id_box)); ?>

                                </h6>
                                <ul class="tag-list">
                                    <li><a href="javascript:void(0);">
                                            <?php echo e($laporan->catatan); ?>

                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/laporan-pengaduan/indexNasabah.blade.php ENDPATH**/ ?>
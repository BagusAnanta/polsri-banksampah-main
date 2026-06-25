<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <?php
                    $previousUrl = session('previous_url', route('dashboard')); // Default ke halaman index

                    // Validasi URL agar hanya dari domain aplikasi
                    if (!str_contains($previousUrl, config('app.url'))) {
                        $previousUrl = route('jenis_sampahs.index'); // Pastikan URL aman
                    }
                ?>

                <a href="<?php echo e($previousUrl); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Box Sampah</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                <a href="<?php echo e(route('box-sampahs.create')); ?>">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">
        <ul>
            <?php $__currentLoopData = $boxSampah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $box): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-items pull_delete" onclick="location.href='<?php echo e(route('box-sampahs.show', $box->id)); ?>'">
                    <div class="media">
                        <div class="list-content">
                            <h5 class="title"><?php echo e(ucfirst($box->id_box)); ?></h5>
                            <span class="date"><?php echo e($box->description); ?></span>
                        </div>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/box-sampah/index.blade.php ENDPATH**/ ?>
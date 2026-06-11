<!-- Header -->
<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Detail Penyetoran</h4>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<!-- Header -->
<!-- Main Content Start -->
<?php $__env->startSection('content'); ?>
    <div class="profile-area">
        <div class="widget_getintuch pb-15">
            <?php $__currentLoopData = $penyetoranNasabah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <ul>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Nama Nasabah</p>
                            <h6 class="title"><?php echo e($item->user->name); ?></h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Tanggal Setor</p>
                            <h6 class="title"><?php echo e($item->tanggal_setor); ?></h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Status</p>
                            <h6 class="title"><?php echo e($item->status); ?></h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Jenis Sampah</p>
                            <?php $__currentLoopData = $item->detailJenisSampah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <h6 class="title"><?php echo e($detail->jenisSampah->nama); ?> - <?php echo e($detail->qty); ?> qty
                                </h6>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<!-- Main Content End -->

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/bank-sampah/show.blade.php ENDPATH**/ ?>
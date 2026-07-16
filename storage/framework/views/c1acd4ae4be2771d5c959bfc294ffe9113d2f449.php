<?php $__env->startSection('header'); ?>
<header class="header header-fixed">
    <div class="header-content">
        <div class="left-content">
            <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                <i class="feather icon-arrow-left"></i>
            </a>
        </div>
        <div class="mid-content">
            <h4 class="title">Role</h4>
        </div>
        <div class="right-content d-flex align-items-center gap-4">
            <a href="<?php echo e(route('departements.create')); ?>">
                <i class="fi fi-rr-plus"></i>
            </a>
        </div>
    </div>
</header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="dz-list notification-list">
    <ul>
        <?php $__currentLoopData = $departements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-items pull_delete" onclick="location.href='<?php echo e(route('departements.show', $departement->id)); ?>'">
            <div class="media">
                
                <div class="list-content">
                    <h5 class="title"><?php echo e(ucfirst($departement->name)); ?></h5>
                    
                </div>
            </div>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/departements/index.blade.php ENDPATH**/ ?>
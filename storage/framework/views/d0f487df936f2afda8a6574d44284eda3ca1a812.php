<?php $__env->startSection('header'); ?>
<header class="header header-fixed">
    <div class="header-content">
        <div class="left-content">
            <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                <i class="feather icon-arrow-left"></i>
            </a>
        </div>
        <div class="mid-content">
            <h4 class="title">Daftar Pengguna</h4>
        </div>
        <div class="right-content d-flex align-items-center gap-4">
            <a href="<?php echo e(route('users.create')); ?>">
                <i class="fi fi-rr-plus"></i>
            </a>
        </div>
    </div>
</header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="dz-list notification-list">
    <ul>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-items pull_delete" onclick="location.href='<?php echo e(route('users.show', $user->id)); ?>'">
            <div class="media">
                <div class="media-60 m-r10">
                    <img src="<?php echo e(asset('ui/images/profile/'.($user->avatar ?? 'user.png'))); ?>" alt="">
                </div>
                <div class="list-content">
                    <h5 class="title"><?php echo e(ucfirst($user->name)); ?></h5>
                    <span class="date"><?php echo e($user->getRoleNames()->first() ?? 'No role'); ?></span>
                </div>
            </div>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/users/index.blade.php ENDPATH**/ ?>
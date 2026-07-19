<?php $__env->startSection('header'); ?>
<header class="header header-fixed border-bottom">
    <div class="header-content">
        <div class="left-content">
            <a href="<?php echo e(route('users.index')); ?>" class="back-btn">
                <i class="feather icon-arrow-left"></i>
            </a>
        </div>
        <div class="mid-content">
            <h4 class="title">Create Role</h4>
        </div>
        <div class="right-content"></div>
    </div>
</header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="edit-profile">
<form action="<?php echo e(route('departements.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="mb-4">
        <label class="form-label" for="name">Name</label>
        <div class="input-group input-mini input-sm">
            <input type="text" id="name" name="name" class="form-control">
        </div>
    </div>
    
    <div class="mb-4">
        <button type="submit" style="width: 100%" class="btn btn-success">SAVE PROFILE</button>
    </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/departements/create.blade.php ENDPATH**/ ?>
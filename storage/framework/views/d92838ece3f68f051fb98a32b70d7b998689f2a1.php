<?php $__env->startSection('header'); ?>
<header class="header header-fixed border-bottom">
    <div class="header-content">
        <div class="left-content">
            <a href="<?php echo e(route('departements.index')); ?>" class="back-btn">
                <i class="feather icon-arrow-left"></i>
            </a>
        </div>
        <div class="mid-content">
            <h4 class="title">Ubah Role</h4>
        </div>
        <div class="right-content"></div>
    </div>
</header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="edit-profile">
<form action="<?php echo e(route('departements.update', $departement->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="mb-4">
        <label class="form-label" for="name">Role</label>
        <div class="input-group input-mini input-sm">
            <input type="text" id="name" name="name" class="form-control" value="<?php echo e($departement->name); ?>">
        </div>
    </div>
    <div class="mb-4">
        <button type="submit" style="width: 100%" class="btn btn-success">UBAH</button>
    </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/departements/edit.blade.php ENDPATH**/ ?>
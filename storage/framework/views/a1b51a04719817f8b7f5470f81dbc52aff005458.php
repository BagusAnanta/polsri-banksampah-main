<?php if(session()->has('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e(session()->get('success')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session()->has('warning')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo e(session()->get('warning')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if(session()->has('failed')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo e(session()->get('failed')); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/components/flash-message.blade.php ENDPATH**/ ?>
<div class="menubar-area footer-fixed">
    <div class="toolbar-inner menubar-nav">
        <a href="<?php echo e(route('dashboard')); ?>" class="nav-link">
            <i class="fi fi-rr-home"></i>
        </a>
        <a href="<?php echo e(route('products-list.index')); ?>" class="nav-link">
            <i class="fi fi-rr-shopping-cart"></i>
        </a>
        <a href="<?php echo e(route('bank_sampahs.create')); ?>" class="nav-link active">
            <i class="fi fi-rr-plus"></i>
        </a>
        <a href="<?php echo e(route('riwayat-setor')); ?>" class="nav-link">
            <i class="fi fi-rr-clock"></i>
        </a>
        <a href="<?php echo e(route('users.show', Auth::user()->id)); ?>" class="nav-link">
            <i class="fi fi-rr-user"></i>
        </a>
    </div>
</div>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/layout-mobile/components/appBottomMenu.blade.php ENDPATH**/ ?>
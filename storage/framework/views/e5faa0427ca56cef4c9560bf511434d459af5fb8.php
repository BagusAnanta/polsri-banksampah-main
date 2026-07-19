<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Products</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                <a href="<?php echo e(route('data-products.create')); ?>">
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
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <li onclick="location.href='<?php echo e(route('data-products.show', $product->id)); ?>'">
                    <div class="dz-card list">
                        <div class="dz-media">
                            <img class="img-thumbnail img-cover" style="height: 130px"
                                src="<?php echo e(Storage::url($product->image)); ?>" alt="<?php echo e($product->name); ?>">
                        </div>
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title">
                                    <?php echo e(ucfirst($product->name)); ?>

                                </h6>
                                <ul class="tag-list">
                                    <li><a
                                            href="javascript:void(0);"><?php echo e(strlen($product->description) > 100 ? Str::limit($product->description, 100) : $product->description); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="dz-meta">
                                <li class="dz-price mt-4 flex-1"><?php echo e('Rp. ' . number_format($product->price, 0, ',', ',')); ?>

                                </li>
                            </ul>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/data-products/index.blade.php ENDPATH**/ ?>
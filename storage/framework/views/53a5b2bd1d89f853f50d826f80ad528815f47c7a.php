<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('data-products.index')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Ubah Product</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="edit-profile">
        <form action="<?php echo e(route('data-products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <div class="mb-4">
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Product</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="name" name="name" class="form-control"
                                value="<?php echo e($product->name); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Deskripsi</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="description" name="description" class="form-control"
                                value="<?php echo e($product->description); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Harga</label>
                        <div class="input-group input-mini input-sm">
                            <input type="text" id="price" name="price" class="form-control"
                                value="<?php echo e(floor($product->price)); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image">Gambar</label>
                        <div class="input-group">
                            <input type="file" id="image" name="image" class="form-control">
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>"
                                class="img-thumbnail mt-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" style="width: 100%" class="btn btn-success">UBAH</button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/data-products/edit.blade.php ENDPATH**/ ?>
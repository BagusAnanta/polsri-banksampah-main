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
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">
        <header class="header py-2 mx-auto">
            <div class="header-content">
                <div class="left-content">
                    <div class="info">
                        <p class="text m-b10">Good Morning</p>
                        <h3 class="title"><?php echo e(Auth::user()->name); ?></h3>
                    </div>
                </div>
                <div class="mid-content"></div>
                <div class="right-content d-flex align-items-center gap-4">
                    <a href="javascript:void(0);" class="icon dz-floating-toggler">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                            <rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                            <rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                        </svg>
                    </a>
                </div>
            </div>
        </header>
        <!-- Header -->

        <!-- Main Content Start -->
        <main class="page-content bg-white p-b60">
            <div class="container">
                <!-- SearchBox -->
                <div class="search-box">
                    <div class="input-group input-radius input-rounded input-lg">
                        <input type="text" placeholder="Search beverages or foods" class="form-control">
                        <span class="input-group-text">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z"
                                    fill="#C9C9C9" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Featured Beverages -->
                <div class="title-bar">
                    <h5 class="title">List Products</h5>
                </div>

                <ul class="featured-list">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li style="cursor: pointer">
                            <div class="dz-card list">
                                <div class="dz-media">
                                    <img class="img-thumbnail img-cover" style="height: 130px"
                                        src="<?php echo e(Storage::url($product->image)); ?>" alt="<?php echo e($product->name); ?>">
                                </div>
                                <div class="dz-content">
                                    <div class="dz-head">
                                        <h6 class="title">
                                            <?php echo e($product->name); ?>

                                        </h6>
                                        <ul class="tag-list">
                                            <li><?php echo e(strlen($product->description) > 100 ? Str::limit($product->description, 100) : $product->description); ?>

                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="dz-meta">
                                        <li class="dz-price mt-4 flex-1">
                                            <?php echo e('Rp. ' . number_format($product->price, 0, ',', ',')); ?>

                                        </li>
                                    </ul>
                                    <form class="d-flex align-items-center mt-4 gap-2" action="<?php echo e(route('orders.store')); ?>"
                                        method="POST" style="margin-top: 10px;">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <input type="number" name="qty" class="form-control" placeholder="Jumlah"
                                            min="1" required>
                                        <button type="submit" class="btn btn-primary">Order</button>
                                    </form>

                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <!-- Featured Beverages -->
            </div>
        </main>
        <!-- Main Content End -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/products/index.blade.php ENDPATH**/ ?>
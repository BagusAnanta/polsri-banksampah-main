<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Orders List</h4>
            </div>
            
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">
        <div class="container pt-0">
            <div class="default-tab style-2 mt-1">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="home" role="tabpanel">
                        <?php if(session('success')): ?>
                            <div class="alert alert-success solid alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="me-2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    <span><i class="icon feather icon-x"></i></span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <ul class="featured-list">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="dz-card list">
                                        <div class="dz-media">
                                            <img class="img-thumbnail img-cover" style="height: 130px"
                                                src="<?php echo e(Storage::url($order->product->image)); ?>"
                                                alt="<?php echo e($order->product->name); ?>">
                                        </div>
                                        <div class="dz-content">
                                            <div class="dz-head">
                                                <h6 class="title">
                                                    ID Order: <?php echo e($order->id); ?>

                                                </h6>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">tanggal order:
                                                            <?php echo e($order->created_at); ?>,</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">nama:
                                                            <?php echo e($order->user->username); ?>,</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">produk:
                                                            <?php echo e($order->product->name); ?>,</a></li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">deskripsi:
                                                            <?php echo e(strlen($order->product->description) > 100 ? Str::limit($order->product->description, 100) : $order->product->description); ?>,</a>
                                                    </li>
                                                </ul>
                                                <ul class="tag-list">
                                                    <li><a href="javascript:void(0);">qty: <?php echo e($order->qty); ?></a></li>
                                                </ul>
                                            </div>
                                            <ul class="dz-meta">
                                                <li class="dz-price flex-1" style="font-size: 16px">
                                                    Total <?php echo e('Rp. ' . number_format($order->total_price, 0, ',', ',')); ?>

                                                </li>
                                                <li>
                                                    <form action="<?php echo e(route('orders.update', $order->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <select name="status" onchange="this.form.submit()"
                                                            class="form-select form-select-sm
                                                        <?php echo e($order->status == 'pending' ? 'btn btn-warning' : ''); ?>

                                                        <?php echo e($order->status == 'proses' ? 'btn btn-info' : ''); ?>

                                                        <?php echo e($order->status == 'selesai' ? 'btn btn-success' : ''); ?>

                                                        <?php echo e($order->status == 'batal' ? 'btn btn-danger' : ''); ?>">
                                                            <option value="pending"
                                                                <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending
                                                            </option>
                                                            <option value="proses"
                                                                <?php echo e($order->status == 'proses' ? 'selected' : ''); ?>>Proses
                                                            </option>
                                                            <option value="selesai"
                                                                <?php echo e($order->status == 'selesai' ? 'selected' : ''); ?>>Selesai
                                                            </option>
                                                            <option value="batal"
                                                                <?php echo e($order->status == 'batal' ? 'selected' : ''); ?>>Batal
                                                            </option>
                                                        </select>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/orders/index.blade.php ENDPATH**/ ?>
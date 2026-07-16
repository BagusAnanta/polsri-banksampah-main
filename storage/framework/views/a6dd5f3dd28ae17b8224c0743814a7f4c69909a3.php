<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('users.index')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Setor</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__errorArgs = ['generalError'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="alert alert-danger solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                <span><i class="icon feather icon-x"></i></span>
            </button>
        </div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php if(!$jenis_sampah->isEmpty()): ?>
        <form action="<?php echo e(route('bank_sampahs.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="accordion dz-accordion" id="accordionExample">
                <div class="alert alert-info solid alert-dismissible fade show py-3 d-flex align-items-center mb-2">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                        fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <span class="font-18 fw-semibold"> User Id: <?php echo e(Auth::user()->user_code); ?></span>
                </div>
                <?php $__currentLoopData = $jenis_sampah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="dz-add-box mb-2">
                        <span><?php echo e($item->nama); ?></span>
                        <div class="mb-2 input-group input-group-icon" style="width: 40%">
                            <span class="input-group-text">
                                <input class="form-control" name="qty[<?php echo e($item->id); ?>]" type="number" placeholder="0"
                                    value="<?php echo e($item->getQtyAttribute($item->id, Auth::user()->id)); ?>">
                                <span>&nbsp;gram</span>
                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <button type="submit" class="btn btn-thin btn-primary rounded-xl btn-block">SIMPAN</button>
        </form>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/bank-sampah/create.blade.php ENDPATH**/ ?>
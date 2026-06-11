<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <?php
                    $previousUrl = session('previous_url', route('dashboard')); // Default ke halaman index

                    // Validasi URL agar hanya dari domain aplikasi
                    if (!str_contains($previousUrl, config('app.url'))) {
                        $previousUrl = route('jenis_sampahs.index'); // Pastikan URL aman
                    }
                ?>

                <a href="<?php echo e($previousUrl); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Pemantauan Realtime</h4>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
$count = 4;
?>
<div class="accordion dz-accordion" id="accordionExample">
    <?php for($i=1;$i <= $count;$i++): ?>
    <div class="accordion-item">
        <div class="accordion-header acco-select" id="heading<?php echo e($i); ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($i); ?>" aria-expanded="true" aria-controls="collapse<?php echo e($i); ?>">
                <span class="dz-icon">
                    <i class="fi fi-rr-dashboard"></i>
                </span>
                <span class="acco-title">Bank Sampah - Sensor <?php echo e($i); ?></span>
                <span class="checkmark"></span>
            </button>
        </div>
        <div id="collapse<?php echo e($i); ?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo e($i); ?>">
            <div class="accordion-body text-center p-4">
                <span id="bankSampah1-sensor<?php echo e($i); ?>" class="fs-1 fw-bold d-block">0</span>
                <span class="fs-6 text-muted">cm</span>
            </div>
        </div>
    </div>
    <?php endfor; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/monitoring/viewSensor.blade.php ENDPATH**/ ?>
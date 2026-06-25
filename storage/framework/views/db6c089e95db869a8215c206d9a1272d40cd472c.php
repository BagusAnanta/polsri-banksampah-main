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
                <h4 class="title">Kontrol Selenoid</h4>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="dz-list style-3">
    <ul>
    <?php $__currentLoopData = $selenoid_sensor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $selenoid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li>
        <a class="item-content">
            <div class="d-flex align-items-center w-100">
                <div class="d-flex align-items-center">
                    <!-- <div class="dz-icon icon-xs icon-fill me-2">
                        <i class="fi fi-rr-bold text-dark"></i>
                    </div> -->
                    <span class="title">Selenoid <?php echo e($selenoid->sensor_name); ?> - <?php echo e($selenoid->status); ?></span>
                </div>
                <div class="ms-auto">
                    <button class="btn btn-sm btn-success" onclick="changeStatusSelenoid('<?php echo e($selenoid->sensor_name); ?>', 1)">On</button>
                    <button class="btn btn-sm btn-danger" onclick="changeStatusSelenoid('<?php echo e($selenoid->sensor_name); ?>', 0)">Off</button>
                </div>
            </div>
        </a>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>


    function changeStatusSelenoid(topic, status) {
        if (!topic) {
            console.error("Topic tidak boleh kosong!");
            return;
        }

        // Emit event realtime ke server socket.io
        socket.emit('selenoid', { topic: topic, status: status });

        console.log(`Emit sent: topic=${topic}, status=${status}`);
    }
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/monitoring/selenoidSwitch.blade.php ENDPATH**/ ?>
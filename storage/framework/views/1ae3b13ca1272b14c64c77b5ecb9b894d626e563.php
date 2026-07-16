<?php $__env->startSection('header'); ?>
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Riwayat Setor</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="title-bar mb-0">
        <h5 class="title">Filter</h5>
    </div>
    <div class="swiper categories-swiper dz-swiper m-b20">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide" onclick="location.href='<?php echo e(route('riwayat-setor', $key)); ?>'">
                    <div class="dz-categories-bx">
                        <div class="icon-bx">
                            <a href="javascript:void(0);">
                                <div class="fw-bold"><?php echo e(date('Y')); ?></div>
                            </a>
                        </div>
                        <div class="dz-content">
                            <h6 class="title"><a href="javascript:void(0);"><?php echo e($item); ?></a></h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="alert alert-info solid alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        Periode bulan <?php echo e($period); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <span><i class="icon feather icon-x"></i></span>
        </button>
    </div>
    <div class="my-4">
        <h5 class="title">Cetak Laporan</h5>
        <form action="<?php echo e(route('download-slip-penyetoran-bulan-pdf')); ?>" method="GET" class="d-flex gap-3">
            <select name="month" class="form-select" style="width: 50%">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <button type="submit" class="btn btn-danger" style="width: 50%">Cetak Laporan</button>
        </form>
    </div>
    <div class="accordion dz-accordion" id="accordionExample">
        <?php
            $no = 1;
        ?>
        <?php $__currentLoopData = $currentMonth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accordion-item">
                <div class="accordion-header acco-select" id="heading<?php echo e($no); ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?php echo e($no); ?>" aria-expanded="true"
                        aria-controls="collapse<?php echo e($no); ?>">
                        <span class="acco-title"><?php echo e($date); ?></span>
                        &nbsp;
                        &nbsp;
                        <?php if($date == date('Y-m-d')): ?>
                            <span class="badge badge-success">Today</span>
                            <span class="checkmark"></span>
                        <?php endif; ?>
                    </button>
                </div>
                <div id="collapse<?php echo e($no); ?>" class="accordion-collapse collapse"
                    aria-labelledby="heading<?php echo e($no); ?>" data-bs-parent="#accordionExample">
                    <?php if($collection['entries']->isEmpty()): ?>
                        <div class="accordion-body">
                            <div class="text-center">
                                Tidak ada riwayat setor.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="accordion-body">
                            <div class="mb-3">
                                <button class="btn btn-primary rounded-xl btn-thin w-100" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                    aria-controls="offcanvasRight">
                                    Total Pendapatan: Rp. <?php echo e(number_format($collection['total'], 0, ',', '.')); ?>

                                </button>
                            </div>
                            
                            <table class="table table-striped">
                                <?php $__currentLoopData = $collection['entries']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td style="width: 50%" class="center">
                                            <span class="fw-bold"><?php echo e($item->jenisSampah->nama); ?></span>
                                        </td>
                                        <td>
                                            <div class="mb-2 input-group input-group-icon justify-content-end"
                                                style="width: 100%">
                                                <span class="input-group-text">
                                                    <input class="form-control" name="qty" type="number" disabled
                                                        placeholder="0" value="<?php echo e($item->qty); ?>">
                                                    <span>&nbsp;gram</span>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                $no++;
            ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/history/index.blade.php ENDPATH**/ ?>
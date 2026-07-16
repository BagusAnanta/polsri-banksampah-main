<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Transaksi</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">

        <!-- Main Content Start -->
        <main class="page-content bg-white p-b60">
            <div class="container">

                <!-- Flash message -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
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

                <?php $__errorArgs = ['kredit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
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
                <?php $__errorArgs = ['tabungan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
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
                <!-- Form Input Kredit -->
                <form class="d-flex align-items-center gap-3" action="<?php echo e(route('transaksi.updateKredit')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php if($firstTabungan): ?>
                        <input type="hidden" name="tabungan_id" value="<?php echo e($firstTabungan->id); ?>">
                    <?php endif; ?>
                    <div class="mb-3" style="width: 70%">
                        <label for="kredit" class="form-label">Nominal Kredit</label>
                        <?php if($kreditNasabah): ?>
                            <input type="number" name="kredit" id="kredit" class="form-control"
                                <?php echo e($kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending' ? 'disabled' : ''); ?>

                                required min="0">
                        <?php else: ?>
                            <input type="number" name="kredit" id="kredit" class="form-control" disabled required
                                min="0">
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 btn-simpan"
                        <?php if($kreditNasabah && $kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending'): ?> disabled <?php endif; ?> style="width: 30%">Simpan</button>
                </form>
                <div class="d-flex align-items-center gap-3 mt-5" style="width: 100% !important">
                    <form action="<?php echo e(route('download-nota-pdf')); ?>" method="GET" class="mt-3" style="width: 100%">
                        <?php echo csrf_field(); ?>
                        <?php if($firstTabungan): ?>
                            <input type="hidden" name="tabungan_id" value="<?php echo e($firstTabungan->id); ?>">
                        <?php else: ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-outline-info" style="width: 100%">Cetak
                            Nota</button>
                    </form>
                    <form action="<?php echo e(route('download-tabungan-pdf')); ?>" method="GET" class="mt-3"
                        style="width: 100%">
                        <?php echo csrf_field(); ?>
                        <?php if($firstTabungan): ?>
                            <input type="hidden" name="tabungan_id" value="<?php echo e($firstTabungan->id); ?>">
                        <?php else: ?>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-outline-primary" style="width: 100%">
                            Cetak Tabungan
                        </button>
                    </form>
                </div>

                <!-- Tabel Tabungan -->
                <h5 class="mt-5">Data Tabungan</h5>
                <?php if($lastTabungan != null && $lastTabungan->status === 'pending'): ?>
                    <div class="alert alert-warning solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Penyetoran menunggu approved dari admin.
                    </div>
                <?php elseif($lastTabungan != null && $lastTabungan->status === 'gagal'): ?>
                    <div class="alert alert-danger solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Penyetoran gagal, silahkan setor ulang dan perhatikan sampah yang disetor.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if($kreditNasabah->kredit > 0 && $kreditNasabah->status === 'pending'): ?>
                    <div class="alert alert-warning solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        Kredit menunggu persetujuan Admin.
                    </div>
                <?php endif; ?>
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Sisa Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($tabungan->count() > 0): ?>
                            <?php
                                $nomor = ($tabungan->currentPage() - 1) * $tabungan->perPage() + 1;
                            ?>
                            <?php $__currentLoopData = $tabungan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($nomor++); ?></td>
                                    <td><?php echo e(formatDateIndo($item->tanggal)); ?></td>
                                    <?php if($item->kredit > 0): ?>
                                        <td></td>
                                        <td><?php echo e('Rp. ' . number_format($item->kredit, 0, ',', '.')); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e('Rp. ' . number_format($item->debit, 0, ',', '.')); ?></td>
                                        <td></td>
                                    <?php endif; ?>
                                    <td><?php echo e('Rp. ' . number_format($item->sisa_saldo, 0, ',', '.')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Tidak ada data.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if($tabungan->count() > 0): ?>
                    <div class="d-flex">
                        <?php echo e($tabungan->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
            

        </main>
        <!-- Main Content End -->
    </div>

    
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/transaksi/index.blade.php ENDPATH**/ ?>
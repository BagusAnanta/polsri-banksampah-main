<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Penyetoran Nasabah</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dz-list notification-list">
        
        <!-- Header -->

        <!-- Main Content Start -->
        <main class="page-content bg-white p-b60">
            <div class="container">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <?php echo e($errors->first('message')); ?>

                    </div>
                <?php endif; ?>
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

                <!-- SearchBox -->
                <div class="search-box">
                    <form action="<?php echo e(route('bank_sampahs.index')); ?>" method="GET">
                        <div class="input-group input-radius input-rounded input-lg">
                            <input type="text" placeholder="Masukkan ID Nasabah" id="search"
                                value="<?php echo e(request('search')); ?>" name="search" class="form-control">

                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
                <!-- SearchBox -->

                <table id="myTable" class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Nasabah</th>
                            <th>Nama Nasabah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($penyetoranNasabah->count() > 0): ?>
                            <?php
                                $nomor = ($penyetoranNasabah->currentPage() - 1) * $penyetoranNasabah->perPage() + 1;
                            ?>
                            <?php $__currentLoopData = $penyetoranNasabah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($nomor++); ?></td>
                                    
                                    <td><?php echo e($item->user->user_code); ?></td>
                                    <td><?php echo e($item->user->name); ?></td>
                                    <td><?php echo e(formatDateIndo($item->tanggal_setor)); ?></td>
                                    <td>
                                        <span
                                            class="badge
                                                <?php echo e($item->status === 'approved' ? 'bg-success' : ($item->status === 'pending' ? 'bg-warning' : 'bg-danger')); ?>">
                                            <?php echo e(ucfirst($item->status)); ?>

                                        </span>
                                    </td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="<?php echo e(route('bank-sampah.detail', $item->user_id)); ?>" class="text-info">
                                            Detail
                                        </a>
                                        <form action="<?php echo e(route('bank-sampah.updateStatus', $item->user_id)); ?>"
                                            method="POST" id="statusForm-<?php echo e($item->user_id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="document.getElementById('statusForm-<?php echo e($item->user_id); ?>').submit()">
                                                <option value="pending"
                                                    <?php echo e($item->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                                <option value="approved"
                                                    <?php echo e($item->status === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                                <option value="gagal" <?php echo e($item->status === 'gagal' ? 'selected' : ''); ?>>
                                                    Gagal</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if($penyetoranNasabah->count() > 0): ?>
                    <div class="d-flex">
                        <?php echo e($penyetoranNasabah->appends(['search' => request('search')])->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
            

        </main>
        <!-- Main Content End -->
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-approved');

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    history.pushState(null, '', '<?php echo e(route('dashboard')); ?>');
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/bank-sampah/adminIndex.blade.php ENDPATH**/ ?>
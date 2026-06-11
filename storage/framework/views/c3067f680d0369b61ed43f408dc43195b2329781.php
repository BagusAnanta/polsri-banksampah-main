<!-- Header -->
<?php $__env->startSection('header'); ?>
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="<?php echo e(route('dashboard')); ?>" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Detail Laporan</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                
                
                <form action="<?php echo e(route('laporan-pengaduans.destroyAdmin', $laporan->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="padding-right: 0 !important;" class="btn btn-hapus"
                        onclick="return confirm('Apa Anda yakin ingin menghapus data ini?')"
                        class="dropdown-item">Hapus</button>
                </form>
                
                
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<!-- Header -->
<!-- Main Content Start -->
<?php $__env->startSection('content'); ?>
    <div class="profile-area">
        <div class="widget_getintuch pb-15">
            <ul>
                <li>
                    <div class="dz-content">
                        <p class="sub-title">ID User</p>
                        <h6 class="title"><?php echo e($laporan->user->user_code); ?></h6>
                    </div>
                </li>
                <li>
                    <div class="dz-content">
                        <p class="sub-title">Nama Nasabah</p>
                        <h6 class="title"><?php echo e($laporan->user->name); ?></h6>
                    </div>
                </li>
                <li>
                    <div class="dz-content">
                        <p class="sub-title">ID Box</p>
                        <h6 class="title"><?php echo e($laporan->boxSampah->id_box); ?></h6>
                    </div>
                </li>
                <li>
                    <div class="dz-content">
                        <p class="sub-title">Catatan</p>
                        <h6 class="title"><?php echo e($laporan->catatan); ?></h6>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-hapus');

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    history.pushState(null, '', '<?php echo e(route('dashboard')); ?>');
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<!-- Main Content End -->

<?php echo $__env->make('layout-mobile.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/laporan-pengaduan/showAdmin.blade.php ENDPATH**/ ?>
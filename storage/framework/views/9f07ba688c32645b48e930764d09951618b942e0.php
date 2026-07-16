<?php $__env->startPush('css'); ?>
<style>
    .text-blue {
        color: #71afde;
    }
</style>
    <?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($page_title); ?></h4>
                    <a href="<?php echo e(route('tickets.create')); ?>" class="btn btn-sm btn-primary">ADD TICKET</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php echo $__env->make('components.flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Tiket</th>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Update</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($ticket->nomor_tiket); ?></td>
                                    <td><?php echo e($ticket->created_at); ?></td>
                                    <td><?php echo e($ticket->judul); ?></td>
                                    <td><?php echo e($ticket->deskripsi); ?></td>
                                    <td><?php echo e(ucfirst($ticket->user->name) . ' - ('. $ticket->user->getRoleNames()[0] .')'); ?></td>
                                    
                                    <td>
                                        <?php if($ticket->status == 'open'): ?>
                                            <i class="fa fa-circle text-danger me-1"></i>Open
                                        <?php elseif($ticket->status == 'progress'): ?>
                                            <i class="fa fa-circle text-blue me-1"></i>Progress by <?php echo e($ticket->findUser($ticket->progress_by)); ?>

                                        <?php else: ?>
                                            <i class="fa fa-circle text-success me-1"></i>Closed by <?php echo e($ticket->findUser($ticket->closed_by)); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($ticket->updated_at); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-success light" data-bs-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <?php if($ticket->status != 'close'): ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('tickets.edit', $ticket->id)); ?>">Edit</a>
                                                <?php else: ?>
                                                    <a class="dropdown-item" href="<?php echo e(route('tickets.show', $ticket->id)); ?>">Detail</a>
                                                <?php endif; ?>
                                                <form action="<?php echo e(route('tickets.destroy', $ticket->id)); ?>" method="POST" style="display: inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" onclick="return confirm('Apa Anda yakin ingin menghapus tiket ini?')" class="dropdown-item">Delete</button>
                                                </form>
                                                <?php if($ticket->status != 'close' && auth()->user()->getRoleNames()[0] != 'HRD'): ?>
                                                    <a href="<?php echo e(route('tickets.update-ticket', $ticket->id)); ?>" class="dropdown-item">Submit</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/ticket/index.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layouts.app','data' => ['title' => 'Riwayat Transaksi','subtitle' => 'Riwayat setor sampah dan tukar poin selesai']]); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Riwayat Transaksi','subtitle' => 'Riwayat setor sampah dan tukar poin selesai']); ?>

    <div class="rounded-2xl bg-base-100 p-5 shadow-sm">
        <h3 class="text-base font-semibold text-base-content mb-4">Riwayat Transaksi</h3>

        <?php if(count($riwayat ?? []) > 0): ?>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-base-content/50">
                            <th>ID Tiket</th>
                            <th>Tanggal</th>
                            <th>Bank Sampah</th>
                            <th>Detail</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $riwayat ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-base-200/40 transition">
                                <td class="font-medium text-sm">
                                    #<?php echo e($item['nomor'] ?? $item->nomor ?? '-'); ?>

                                </td>
                                <td class="text-sm text-base-content/60">
                                    <?php echo e(\Carbon\Carbon::parse($item['tanggal'] ?? $item->tanggal)->translatedFormat('d M Y H:i')); ?>

                                </td>
                                <td class="text-sm">
                                    <?php echo e($item['bank_sampah'] ?? $item->bank_sampah ?? '-'); ?>

                                </td>
                                <td class="text-sm">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e(($item['type'] ?? $item->type) === 'sampah' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700'); ?>">
                                        <?php echo e(($item['type'] ?? $item->type) === 'sampah' ? 'Setor Sampah' : 'Tukar Poin'); ?>

                                    </span>
                                    <span class="ml-2 text-xs">
                                        <?php echo e($item['nilai'] ?? $item->nilai ?? ''); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="rounded-xl bg-base-200/30 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-base-content/50">Belum ada riwayat transaksi selesai</p>
                <a href="<?php echo e(route('tiket-sampah.create')); ?>" class="btn btn-primary btn-sm mt-3 rounded-full">
                    Setor Sampah Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/v2/user/masyarakat/riwayat-index.blade.php ENDPATH**/ ?>
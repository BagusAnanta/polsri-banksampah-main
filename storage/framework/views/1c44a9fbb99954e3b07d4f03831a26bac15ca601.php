<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layouts.app','data' => ['title' => 'Tukar Poin','subtitle' => ($tikets ?? collect())->count() . ' tiket tercatat']]); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Tukar Poin','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(($tikets ?? collect())->count() . ' tiket tercatat')]); ?>

      <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('tiket-poin.create')); ?>"
           class="btn btn-sm w-full rounded-lg bg-olive-700 text-white hover:bg-olive-800 sm:w-auto sm:rounded-full">
             + Tukar Poin
        </a>
     <?php $__env->endSlot(); ?>

    <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 p-4">
            <p class="text-xs text-blue-600 sm:text-sm">Poin Saya</p>
            <p class="text-xl font-bold text-blue-700 sm:text-2xl"><?php echo e(number_format($totalGramasi ?? 0)); ?></p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 p-4">
            <p class="text-xs text-amber-600 sm:text-sm">Menunggu</p>
            <p class="text-xl font-bold text-amber-700 sm:text-2xl"><?php echo e(($tikets ?? collect())->where('status', 'Menunggu')->count()); ?></p>
        </div>
        <div class="rounded-xl bg-gradient-to-br from-green-50 to-green-100 p-4">
            <p class="text-xs text-green-600 sm:text-sm">Selesai</p>
            <p class="text-xl font-bold text-green-700 sm:text-2xl"><?php echo e(($tikets ?? collect())->where('status', 'Selesai')->count()); ?></p>
            <p class="mt-0.5 text-xs text-green-600/70">tiket</p>
        </div>
    </div>

     <div class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $tikets ?? collect(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tiket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="overflow-hidden rounded-xl bg-base-200/50 transition hover:bg-base-200">
                <div class="p-3 sm:p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-base-content sm:text-sm">Tiket #<?php echo e($tiket->tiketpoin_inc); ?></p>
                            <p class="text-xs text-base-content/50"><?php echo e($tiket->created_at->translatedFormat('d M Y H:i')); ?></p>
                        </div>
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'rounded-full px-2.5 py-0.5 text-xs font-medium whitespace-nowrap',
                            'bg-amber-100 text-amber-600' => strtolower($tiket->status) === 'menunggu',
                            'bg-green-100 text-green-600' => strtolower($tiket->status) === 'selesai',
                            'bg-red-100 text-red-600' => strtolower($tiket->status) === 'ditolak' || strtolower($tiket->status) === 'dibatalkan',
                        ]) ?>">
                            <?php echo e($tiket->status); ?>

                        </span>
                    </div>

                    <div class="mb-3 flex flex-wrap gap-2 text-xs">
                        <?php if($tiket->bankSampahUser): ?>
                            <span class="rounded-full bg-base-300/50 px-2.5 py-0.5"><?php echo e($tiket->bankSampahUser->nama_bank_sampah); ?></span>
                        <?php endif; ?>
                        <span class="rounded-full bg-base-300/50 px-2.5 py-0.5"><?php echo e(number_format($tiket->poin ?? 0)); ?> poin</span>
                    </div>

                    <?php if(strtolower($tiket->status) === 'menunggu'): ?>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <button class="btn btn-outline btn-sm flex-1 rounded-lg text-xs" 
                                    onclick="document.getElementById('qr_modal_<?php echo e($tiket->tiketpoin_id); ?>').showModal()">
                                📱 Tampilkan QR
                            </button>
                            <form method="POST" action="<?php echo e(route('tiket-poin.cancel', $tiket->tiketpoin_id)); ?>" class="flex-1">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <button type="submit" class="btn btn-error btn-sm w-full rounded-lg text-xs text-white">
                                    Batalkan
                                </button>
                            </form>
                        </div>

                        <dialog id="qr_modal_<?php echo e($tiket->tiketpoin_id); ?>" class="modal">
                            <div class="modal-box w-full max-w-xs">
                                <h3 class="text-lg font-bold">QR Code Tiket</h3>
                                <div class="py-4 text-center">
                                    <div id="qr_<?php echo e($tiket->tiketpoin_id); ?>" class="mx-auto"></div>
                                    <p class="mt-2 text-sm text-base-content/60">Tiket #<?php echo e($tiket->tiketpoin_inc); ?></p>
                                </div>
                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="btn">Tutup</button>
                                    </form>
                                </div>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>

                        <?php $__env->startPush('scripts'); ?>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                        <script>
                            new QRCode(document.getElementById("qr_<?php echo e($tiket->tiketpoin_id); ?>"), {
                                text: "<?php echo e($tiket->qr_code_id); ?>",
                                width: 200,
                                height: 200,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        </script>
                        <?php $__env->stopPush(); ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('tiket-poin.show', $tiket->tiketpoin_id)); ?>" class="btn btn-outline btn-sm w-full rounded-lg text-xs">
                            Lihat Detail
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="rounded-xl bg-base-200/30 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-base-content/20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-base-content/50">Belum ada tiket poin</p>
                <a href="<?php echo e(route('tiket-poin.create')); ?>" class="btn btn-primary btn-sm mt-3 rounded-full">
                    Buat Tiket Pertama
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

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/v2/user/masyarakat/tiket-poin-index.blade.php ENDPATH**/ ?>
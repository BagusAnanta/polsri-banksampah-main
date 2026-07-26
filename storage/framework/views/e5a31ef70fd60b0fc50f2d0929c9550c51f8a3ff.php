<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layouts.app','data' => ['title' => 'Buat Tiket Setor Sampah']]); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Buat Tiket Setor Sampah']); ?>

    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl bg-base-100 p-6 shadow-sm">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-base-content">Buat Tiket Setor Sampah</h1>
                <p class="mt-1 text-sm text-base-content/60">Isi form di bawah untuk membuat tiket setor sampah baru</p>
            </div>

            <form action="<?php echo e(route('tiketsetorsampahs.store')); ?>" method="POST" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="berat_sampah" class="label">
                        <span class="label-text font-medium">Berat Estimasi (gram)</span>
                    </label>
                    <input 
                        type="number" 
                        id="berat_sampah"
                        name="berat_sampah" 
                        placeholder="Masukkan berat sampah dalam gram"
                        class="input input-bordered w-full rounded-lg <?php $__errorArgs = ['berat_sampah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        min="1"
                        required
                    >
                    <?php $__errorArgs = ['berat_sampah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label class="label">
                            <span class="label-text-alt text-error"><?php echo e($message); ?></span>
                        </label>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Estimasi akan menjadi berat aktual, dapat diubah oleh petugas bank sampah</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="banksampah_id" class="label">
                        <span class="label-text font-medium">Pilih Bank Sampah</span>
                    </label>
                    <select 
                        id="banksampah_id"
                        name="banksampah_id"
                        class="select select-bordered w-full rounded-lg <?php $__errorArgs = ['banksampah_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> select-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required
                    >
                        <option value="">-- Pilih Bank Sampah --</option>
                        <?php $__currentLoopData = $banksampahusers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($bank->banksampah_id); ?>"><?php echo e($bank->nama_bank_sampah); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['banksampah_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <label class="label">
                            <span class="label-text-alt text-error"><?php echo e($message); ?></span>
                        </label>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="divider my-4"></div>

                <div class="space-y-3">
                    <h3 class="font-medium text-base-content">Ringkasan</h3>
                    <div class="rounded-lg bg-base-200/50 p-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Berat Sampah:</span>
                            <span id="summary_berat" class="font-semibold">0 gram</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-base-content/60">Poin Estimasi:</span>
                            <span id="summary_poin" class="font-semibold text-olive-700">0 poin</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="<?php echo e(route('tiket-sampah.index')); ?>" class="btn btn-outline flex-1 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary flex-1 rounded-lg">
                        Buat Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        const beratInput = document.getElementById('berat_sampah');
        const summaryBerat = document.getElementById('summary_berat');
        const summaryPoin = document.getElementById('summary_poin');
        
        const gramPerPoint = <?php echo e($gramPerPoint ?? 1000); ?>;

        function updateSummary() {
            const berat = parseInt(beratInput.value) || 0;
            const poin = Math.floor(berat / gramPerPoint);
            
            summaryBerat.textContent = berat.toLocaleString('id-ID') + ' gram';
            summaryPoin.textContent = poin.toLocaleString('id-ID') + ' poin';
        }

        beratInput.addEventListener('input', updateSummary);
        updateSummary();
    </script>
    <?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/v2/user/masyarakat/tiket-sampah-create.blade.php ENDPATH**/ ?>
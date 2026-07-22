
<?php $attributes = $attributes->exceptProps([
    'name' => 'foto_ktp',
    'label' => 'Foto KTP',
    'maxSizeMb' => 2,
    'accept' => '.jpg,.jpeg,.png,.webp',
]); ?>
<?php foreach (array_filter(([
    'name' => 'foto_ktp',
    'label' => 'Foto KTP',
    'maxSizeMb' => 2,
    'accept' => '.jpg,.jpeg,.png,.webp',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    // ID unik supaya komponen ini aman dipakai lebih dari sekali di satu halaman
    $uid = 'ktp-upload-' . Str::random(8);
?>

<div id="<?php echo e($uid); ?>" class="w-full" data-ktp-upload>
    <label class="label">
        <span class="label-text text-sm font-medium text-stone-700"><?php echo e($label); ?></span>
    </label>

    
    <div
        data-dropzone
        class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed
               border-base-content/25 bg-[#EADDCD] px-6 py-8 text-center transition-colors duration-150
               hover:bg-base-200/60"
    >
        
        <div data-empty-state class="flex flex-col items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-base-content/50" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 8.25 12 3.75m0 0L7.5 8.25M12 3.75v13.5" />
            </svg>

            <p class="text-sm text-base-content/70">
                Klik untuk upload <?php echo e(Str::lower($label)); ?>

            </p>
            <p class="text-xs text-base-content/40">
                Maks <?php echo e($maxSizeMb); ?>MB &middot; JPG / PNG / WebP
            </p>
        </div>

        
        <div data-filled-state class="hidden flex-col items-center gap-2">
            <img data-preview src="" alt="Preview KTP" class="h-20 rounded-lg object-cover shadow-sm" />
            <p data-filename class="max-w-[220px] truncate text-sm font-medium text-base-content/80"></p>
            <button type="button" data-reset-btn class="btn btn-ghost btn-xs text-error">
                Hapus & ganti file
            </button>
        </div>
    </div>

    
    <input
        data-file-input
        type="file"
        name="<?php echo e($name); ?>"
        accept="<?php echo e($accept); ?>"
        class="hidden"
    />

    
    <p data-error-msg class="mt-1.5 hidden text-xs text-error"></p>

    
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1.5 text-xs text-error"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>

<?php if (! $__env->hasRenderedOnce('57d8350b-c246-4017-a2c5-a004d4745ba4')): $__env->markAsRenderedOnce('57d8350b-c246-4017-a2c5-a004d4745ba4'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Inisialisasi semua komponen upload KTP yang ada di halaman ini
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-ktp-upload]').forEach(function (root) {
                const dropzone   = root.querySelector('[data-dropzone]');
                const input      = root.querySelector('[data-file-input]');
                const emptyState = root.querySelector('[data-empty-state]');
                const filledState= root.querySelector('[data-filled-state]');
                const preview    = root.querySelector('[data-preview]');
                const filename   = root.querySelector('[data-filename]');
                const errorMsg   = root.querySelector('[data-error-msg]');
                const resetBtn   = root.querySelector('[data-reset-btn]');

                const maxSizeMb  = <?php echo e($maxSizeMb); ?>;
                const maxSizeBytes = maxSizeMb * 1024 * 1024;
                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

                function showError(message) {
                    errorMsg.textContent = message;
                    errorMsg.classList.remove('hidden');
                }

                function clearError() {
                    errorMsg.textContent = '';
                    errorMsg.classList.add('hidden');
                }

                function resetInput() {
                    input.value = '';
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                    filledState.classList.add('hidden');
                    filledState.classList.remove('flex');
                    preview.src = '';
                    filename.textContent = '';
                }

                function handleFile(file) {
                    clearError();

                    if (!file) return;

                    if (!allowedTypes.includes(file.type)) {
                        showError('Format file harus JPG, PNG, atau WebP.');
                        resetInput();
                        return;
                    }

                    if (file.size > maxSizeBytes) {
                        showError('Ukuran file maksimal ' + maxSizeMb + 'MB.');
                        resetInput();
                        return;
                    }

                    const url = URL.createObjectURL(file);
                    preview.src = url;
                    filename.textContent = file.name;

                    emptyState.classList.add('hidden');
                    emptyState.classList.remove('flex');
                    filledState.classList.remove('hidden');
                    filledState.classList.add('flex');
                }

                // Klik dropzone -> buka file picker
                dropzone.addEventListener('click', function () {
                    input.click();
                });

                // Pilih file lewat dialog
                input.addEventListener('change', function (e) {
                    handleFile(e.target.files[0]);
                });

                // Drag & drop
                dropzone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    dropzone.classList.add('border-primary', 'bg-primary/5');
                });

                dropzone.addEventListener('dragleave', function () {
                    dropzone.classList.remove('border-primary', 'bg-primary/5');
                });

                dropzone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    dropzone.classList.remove('border-primary', 'bg-primary/5');
                    const file = e.dataTransfer.files[0];
                    input.files = e.dataTransfer.files;
                    handleFile(file);
                });

                // Tombol hapus & ganti file
                resetBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    clearError();
                    resetInput();
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/components/ktp-upload.blade.php ENDPATH**/ ?>
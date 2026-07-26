<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layouts.app','data' => ['title' => 'Edukasi','subtitle' => 'Pelajari tentang pengelolaan sampah']]); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Edukasi','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Pelajari tentang pengelolaan sampah')]); ?>
    <div class="rounded-xl bg-base-200/50 p-6">
        <p class="text-sm text-base-content/60">Daftar artikel edukasi</p>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/v2/user/masyarakat/edukasi-index.blade.php ENDPATH**/ ?>
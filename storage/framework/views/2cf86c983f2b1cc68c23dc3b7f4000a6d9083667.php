<?php $attributes = $attributes->exceptProps(['route', 'icon', 'label']); ?>
<?php foreach (array_filter((['route', 'icon', 'label']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $isActive = request()->routeIs($route);
?>

<a href="<?php echo e(route($route)); ?>"
   class="flex flex-col items-center gap-0.5 px-3 py-1 text-xs font-medium transition-colors
          <?php echo e($isActive ? 'text-olive-700' : 'text-base-content/50 hover:text-base-content/80'); ?>">

    <div>
        <?php if($icon === 'home'): ?>
            <span class="material-symbols-outlined">home</span>
        <?php elseif($icon === 'trash'): ?>
            <span class="material-symbols-outlined">delete</span>
        <?php elseif($icon === 'gift'): ?>
            <span class="material-symbols-outlined">confirmation_number</span>
        <?php elseif($icon === 'book-open'): ?>
            <span class="material-symbols-outlined">import_contacts</span>
        <?php elseif($icon === 'clock'): ?>
            <span class="material-symbols-outlined">history</span>
        <?php elseif($icon === 'qr-code'): ?>
            <span class="material-symbols-outlined">qr_code</span>
        <?php elseif($icon === 'grid'): ?>
            <span class="material-symbols-outlined">dashboard</span>
        <?php elseif($icon === 'users'): ?>
            <span class="material-symbols-outlined">people</span>
        <?php elseif($icon === 'building'): ?>
            <span class="material-symbols-outlined">domain</span>
        <?php elseif($icon === 'cog'): ?>
            <span class="material-symbols-outlined">settings</span>
        <?php else: ?>
            <span class="material-symbols-outlined">menu</span>
        <?php endif; ?>
    </div>

    <span><?php echo e($label); ?></span>
</a>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/components/layouts/mobile-nav-item.blade.php ENDPATH**/ ?>
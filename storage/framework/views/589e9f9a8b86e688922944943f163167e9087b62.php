

<header class="flex items-center justify-between border-b border-base-300/40 px-4 py-3 sm:px-6">

    <div class="flex items-center gap-2">
        <img src="/images/logo-icon.svg" alt="Trash Bank" class="h-5 w-5 sm:h-6 sm:w-6" />
        <span class="hidden font-semibold sm:inline">Trash Bank</span>
    </div>

    
    <nav class="hidden items-center gap-1 rounded-full bg-base-200 p-1 lg:inline-flex">
        <a href="<?php echo e(route('dashboard')); ?>"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('dashboard') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50'); ?>">
            Beranda
        </a>
        <a href="<?php echo e(route('tiket-sampah.index')); ?>"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('tiket-sampah.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50'); ?>">
            Tiket Sampah
        </a>
        <a href="<?php echo e(route('tiket-poin.index')); ?>"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('tiket-poin.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50'); ?>">
            Tiket Poin
        </a>
        <a href="<?php echo e(route('edukasi.index')); ?>"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('edukasi.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50'); ?>">
            Edukasi
        </a>
        <a href="<?php echo e(route('riwayat.index')); ?>"
           class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors
                  <?php echo e(request()->routeIs('riwayat.*') ? 'bg-olive-700 text-white' : 'text-base-content/70 hover:bg-base-300/50'); ?>">
            Riwayat
        </a>
    </nav>

    <div class="flex items-center gap-2 sm:gap-3">
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">search</span>
        </button>
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="btn btn-ghost btn-circle btn-sm">
            <span class="material-symbols-outlined">logout</span>
        </button>

        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="flex items-center gap-2 rounded-full px-2 py-1 hover:bg-base-200">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-olive-200 text-xs font-semibold">
                    <?php echo e(Str::of(session('user_name','User'))->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('')); ?>

                </div>
                <div class="text-left text-sm leading-tight">
                    <p class="font-medium"><?php echo e(session('user_name','User')); ?></p>
                    <p class="text-xs text-base-content/50"><?php echo e(number_format(session('user_total_poin',0) ?? 0)); ?> poin</p>
                </div>
            </div>
            <ul tabindex="0" class="dropdown-content menu z-10 mt-2 w-40 rounded-box bg-base-100 p-2 shadow">
                <li><a href="<?php echo e(route('profil')); ?>">Profil</a></li>
                <li>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit">Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/components/layouts/topbar.blade.php ENDPATH**/ ?>
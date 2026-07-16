<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="<?php echo e(asset('ui/images/profile/' . (Auth::user()->avatar ?? 'user.png'))); ?>" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600">Hi, <b><?php echo e(ucfirst(auth()->user()->username)); ?></b></span>
                        <small class="font-w400"><?php echo e(auth()->user()->getRoleNames()[0]); ?></small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                </div>
            </li>
            <li>
                <a href="https://www.gcpi-ais.com" target="__blank">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('tickets.index')); ?>">
                    <i class="fa-solid fa-headset"></i>
                    <span class="nav-text">Support</span>
                </a>
            </li>
            <?php if(auth()->user()->getRoleNames()[0] == 'Admin'): ?>
            <li>
                <a href="<?php echo e(route('notification-mails.index')); ?>">
                    <i class="fa-solid fa-inbox"></i>
                    <span class="nav-text">Mail Notification</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(auth()->user()->getRoleNames()[0] == 'Admin'): ?>
            <li>
                <a href="<?php echo e(route('users.index')); ?>">
                    <i class="fa-solid fa-user"></i>
                    <span class="nav-text">User Management</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if(auth()->user()->getRoleNames()[0] == 'Admin'): ?>
            <li class="d-none">
                <a href="<?php echo e(route('departements.index')); ?>">
                    <i class="fa-solid fa-building"></i>
                    <span class="nav-text">Department</span>
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="#" onclick="logout()">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH /home/bagusanantahidayatullah/BagusFile/FileKerjaBagus/polsri-banksampah-main/resources/views/layouts/partials/sidebar.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>POLSRI - Bank Sampah</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">

    <meta name="keywords"
        content="android, ios, mobile, mobile template, mobile app, ui kit, dark layout, app, delivery, ecommerce, material design, mobile, mobile web, order, phonegap, pwa, store, web app, Ombe, coffee app, coffee template, coffee shop, mobile UI, coffee design, app template, responsive design, coffee showcase, style app, trendy app, modern UI, technology, User-Friendly Interface, Coffee Shop App, PWA (Progressive Web App), Mobile Ordering, Coffee Experience, Digital Menu, Innovative Technology, App Development, Coffee Experience, cafe, bootatrap, Bootstrap Framework, UI/UX Design, Coffee Shop Technology, Online Presence, Coffee Shop Website, Cafe Template, Mobile App Design, Web Application, Digital Presence, ">

    <meta name="description"
        content="Discover the perfect blend of design and functionality with Ombe, a Coffee Shop Mobile App Template crafted with Bootstrap and enhanced with Progressive Web App (PWA) capabilities. Elevate your coffee shop's online presence with a seamless, responsive, and feature-rich template. Explore a modern design, user-friendly interface, and PWA technology for an immersive mobile experience. Brew success for your coffee shop effortlessly – Ombe is the ideal template to caffeinate your digital presence.">

    <meta property="og:title" content="Ombe- Coffee Shop Mobile App Template (Bootstrap + PWA) | DexignZone">
    <meta property="og:description"
        content="Discover the perfect blend of design and functionality with Ombe, a Coffee Shop Mobile App Template crafted with Bootstrap and enhanced with Progressive Web App (PWA) capabilities. Elevate your coffee shop's online presence with a seamless, responsive, and feature-rich template. Explore a modern design, user-friendly interface, and PWA technology for an immersive mobile experience. Brew success for your coffee shop effortlessly – Ombe is the ideal template to caffeinate your digital presence.">

    <meta name="format-detection" content="telephone=no">

    <meta name="twitter:title" content="Ombe- Coffee Shop Mobile App Template (Bootstrap + PWA) | DexignZone">
    <meta name="twitter:description"
        content="Discover the perfect blend of design and functionality with Ombe, a Coffee Shop Mobile App Template crafted with Bootstrap and enhanced with Progressive Web App (PWA) capabilities. Elevate your coffee shop's online presence with a seamless, responsive, and feature-rich template. Explore a modern design, user-friendly interface, and PWA technology for an immersive mobile experience. Brew success for your coffee shop effortlessly – Ombe is the ideal template to caffeinate your digital presence.">

    <meta name="twitter:image" content="../../xhtml/social-image.png">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Mobile Specific -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">

    <!-- Favicons Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets')); ?>/images/app-logo/favicon.png">

    <!-- Globle Stylesheets -->

    <!-- Stylesheets -->
    <link rel="stylesheet" class="main-css" type="text/css" href="<?php echo e(asset('assets')); ?>/css/style.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&amp;family=Raleway:wght@300;400;500&amp;display=swap"
        rel="stylesheet">

</head>

<body>
    <div class="page-wrapper">
        <!-- Preloader -->
        <div id="preloader">
            <div class="loader">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <!-- Preloader end-->

        <!-- Main Content Start  -->
        <main class="page-content">
            <div class="container py-0">
                <div class="dz-authentication-area">
                    <div class="main-logo">
                        <a href="<?php echo e(route('login')); ?>" class="back-btn">
                            <i class="feather icon-arrow-left"></i>
                        </a>
                        <div class="logo">
                            <img src="<?php echo e(asset('img')); ?>/logo-polsri.png" alt="logo">
                            <img src="<?php echo e(asset('img')); ?>/logo-pertamina-ep.png" style="width: 500px;height: 100px"
                                alt="logo">
                        </div>
                    </div>
                    <div class="section-head">
                        <h3 class="title">Buat akun baru</h3>
                    </div>
                    <div class="account-section">
                        <form method="POST" action="<?php echo e(route('registerUser')); ?>" class="m-b20">
                            <?php echo csrf_field(); ?>
                            <div class="mb-4">
                                <label class="form-label" for="username">Nama pengguna</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="text" id="username" name="username"
                                        class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="name">Nama lengkap</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="text" id="name" name="name"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="email">Email</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="email" name="email" id="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="phone">Nomor telepon</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="number" name="phone" id="phone"
                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="no_rekening">No Rekening</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="number" name="no_rekening" id="no_rekening"
                                        class="form-control <?php $__errorArgs = ['no_rekening'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="bank">Nama Bank</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="text" name="bank" id="bank"
                                        class="form-control <?php $__errorArgs = ['bank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="role">Role</label>
                                <div class="input-group input-mini input-lg">
                                    <select name="role" id="role" class="form-control">
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($role == 'Admin'): ?>
                                                <?php continue; ?>
                                            <?php endif; ?>
                                            <option value="<?php echo e($role); ?>"><?php echo e($role); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="m-b30">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-mini input-lg">
                                    <input type="password" id="password" name="password"
                                        class="form-control dz-password <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <span class="input-group-text show-pass">
                                        <i class="icon feather icon-eye-off eye-close"></i>
                                        <i class="icon feather icon-eye eye-open"></i>
                                    </span>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-thin btn-lg w-100 btn-primary rounded-xl">Daftar</button>
                        </form>
                        <div class="text-center account-footer">
                            <a href="<?php echo e(route('login')); ?>"
                                class="btn btn-secondary btn-lg btn-thin rounded-xl w-100">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Main Content End  -->


    </div>
    <!--**********************************
    Scripts
***********************************-->
    <script src="<?php echo e(asset('assets')); ?>/js/jquery.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
    <script src="<?php echo e(asset('assets')); ?>/js/dz.carousel.js"></script><!-- Swiper -->
    <script src="<?php echo e(asset('assets')); ?>/js/settings.js"></script>
    <script src="<?php echo e(asset('assets')); ?>/js/custom.js"></script>
</body>

</html>
<?php /**PATH /var/www/polsri-banksampah.grootech.id/resources/views/auth/register.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Title -->
	<title>POLSRI - Bank Sampah</title>

	<?php echo $__env->make('layout-mobile.components.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
	
	<!-- Sidebar -->
	<?php echo $__env->make('layout-mobile.components.appSideMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<!-- Sidebar End -->

	<!-- Nav Floting Start -->
	<div class="dz-nav-floting">
		<!-- Header -->
        
		<?php echo $__env->yieldContent('header'); ?>
		<!-- Header -->
		
		<!-- Main Content Start -->
		<main class="page-content bg-white p-b60">
			<div class="container">
				<?php echo $__env->yieldContent('content'); ?>
				<!-- SearchBox -->
				
				<!-- SearchBox -->
				
				<!-- Overlay Card -->
				
				<!-- Overlay Card -->
				
				<!-- Categories Swiper -->
				
				<!-- Categories Swiper -->


				<!-- Featured Beverages -->
				
				<!-- Featured Beverages -->
			</div>
		</main>
		<!-- Main Content End -->
		
		<!-- Menubar -->
		<?php echo $__env->make('layout-mobile.components.appBottomMenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<!-- Menubar -->
	</div>
	<!-- Nav Floting End -->
	
	<!-- Modal -->
	
	<!-- PWA End --> 
	
</div>  

<!--**********************************
    Modals
***********************************-->
<?php echo $__env->yieldPushContent('modals'); ?>
<!--**********************************
    Scripts
***********************************-->
<?php echo $__env->make('layout-mobile.components.foot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/layout-mobile/app2.blade.php ENDPATH**/ ?>
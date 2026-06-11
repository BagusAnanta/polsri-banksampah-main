<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Title -->
	<title>POLSRI - Bank Sampah</title>

	@include('layout-mobile.components.head')
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
	@include('layout-mobile.components.appSideMenu')
	<!-- Sidebar End -->

	<!-- Nav Floting Start -->
	<div class="dz-nav-floting">
		<!-- Header -->
        {{-- @include('layout-mobile.components.appHeaderMenu') --}}
		@yield('header')
		<!-- Header -->
		
		<!-- Main Content Start -->
		<main class="page-content space-top p-b80">
			<div class="container">
				@yield('content')
				<!-- SearchBox -->
				{{-- <div class="search-box">
					<div class="input-group input-radius input-rounded input-lg">
						<input type="text" placeholder="Search beverages or foods" class="form-control">
						<span class="input-group-text">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z" fill="#C9C9C9"/>
							</svg>
						</span>
					</div>
				</div> --}}
				<!-- SearchBox -->
				
				<!-- Overlay Card -->
				{{-- <div class="swiper overlay-swiper1">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="dz-card-overlay style-1">
								<div class="dz-media">
									<a href="product-detail.html">
										<img src="assets/images/featured/pic1.png" alt="image">
									</a>
								</div>
								<div class="dz-info">
									<h6 class="title"><a href="product-detail.html">Creamy Ice Coffe</a></h6>
									<ul class="dz-meta">
										<li class="dz-price"><sup>$</sup>5.8<del>$9.9</del></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-card-overlay style-1">
								<div class="dz-media">
									<a href="product-detail.html">
										<img src="assets/images/featured/pic2.png" alt="image">
									</a>
								</div>
								<div class="dz-info">
									<h6 class="title"><a href="product-detail.html">Chocolate Coffee</a></h6>
									<ul class="dz-meta">
										<li class="dz-price"><sup>$</sup>5.8<del>$9.9</del></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-card-overlay style-1">
								<div class="dz-media">
									<a href="product-detail.html">
										<img src="assets/images/featured/pic2.png" alt="image">
									</a>
								</div>
								<div class="dz-info">
									<h6 class="title"><a href="product-detail.html">Creamy Ice Coffe</a></h6>
									<ul class="dz-meta">
										<li class="dz-price"><sup>$</sup>5.8<del>$9.9</del></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-card-overlay style-1">
								<div class="dz-media">
									<a href="product-detail.html">
										<img src="assets/images/featured/pic1.png" alt="image">
									</a>
								</div>
								<div class="dz-info">
									<h6 class="title"><a href="product-detail.html">Chocolate Coffee</a></h6>
									<ul class="dz-meta">
										<li class="dz-price"><sup>$</sup>5.8<del>$9.9</del></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-card-overlay style-1">
								<div class="dz-media">
									<a href="product-detail.html">
										<img src="assets/images/featured/pic2.png" alt="image">
									</a>
								</div>
								<div class="dz-info">
									<h6 class="title"><a href="product-detail.html">Chocolate Coffee</a></h6>
									<ul class="dz-meta">
										<li class="dz-price"><sup>$</sup>5.8<del>$9.9</del></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div> --}}
				<!-- Overlay Card -->
				
				<!-- Categories Swiper -->
				{{-- <div class="title-bar mb-0">
					<h5 class="title">Categories</h5>
				</div>
				<div class="swiper categories-swiper dz-swiper m-b20">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="dz-categories-bx">
								<div class="icon-bx">
									<a href="products.html">
										<svg enable-background="new 0 0 48 48" height="24" viewBox="0 0 48 48" width="24" xmlns="http://www.w3.org/2000/svg">
											<path d="m30.1 47.5h-21.8c-.9 0-1.7-.7-1.9-1.6l-5.9-30.5c-.1-.6 0-1.2.4-1.6.4-.5.9-.7 1.5-.7h33.5c.6 0 1.1.3 1.5.7s.5 1 .4 1.6l-5.8 30.5c-.2.9-1 1.6-1.9 1.6zm-20.2-3.9h18.6l5.1-26.6h-28.8z" fill="#fff"/>
											<path d="m31.3 42.3c-.5 0-1.1-.2-1.5-.7-.7-.8-.6-2.1.2-2.8 3.9-3.4 6.1-5.5 9-8.2 1-.9 2-1.9 3.2-3 1.8-1.7 1.4-3.4.9-4.2-.9-1.7-3.3-3.1-6.5-2.4-1.1.2-2.1-.4-2.3-1.5s.4-2.1 1.5-2.3c4.5-1 8.9.9 10.8 4.5 1.6 3 .9 6.4-1.8 8.9-1.2 1.1-2.2 2.1-3.2 3-2.8 2.6-5.2 4.9-9.1 8.3-.3.2-.7.4-1.2.4z" fill="#fff"/>
											<path d="m9.3 10.1c-1.1 0-2-.9-2-2v-5.6c0-1.1.9-2 2-2s2 .9 2 2v5.7c-.1 1-.9 1.9-2 1.9z" fill="#fff"/>
											<path d="m18.1 10.1c-1.1 0-2-.9-2-2v-5.6c0-1.1.9-2 2-2s2 .9 2 2v5.7c-.1 1-.9 1.9-2 1.9z" fill="#fff"/>
											<path d="m26.9 10.1c-1.1 0-2-.9-2-2v-5.6c0-1.1.9-2 2-2s2 .9 2 2v5.7c-.1 1-.9 1.9-2 1.9z" fill="#fff"/>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="products.html">Beverages</a></h6>
									<span class="menus text-primary">41 Menus</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx">
								<div class="icon-bx">
									<a href="products.html">
										<svg enable-background="new 0 0 48 48" height="24" viewBox="0 0 48 48" width="24" xmlns="http://www.w3.org/2000/svg">
											<path d="m43 47.5h-38c-2.5 0-4.5-1.9-4.5-4.1v-9.8c0-1.1.9-2 2-2h43.1c1.1 0 2 .9 2 2v9.8c-.1 2.2-2.1 4.1-4.6 4.1zm-38.6-12v7.8s.2.2.6.2h38c.4 0 .6-.2.6-.3v-7.8h-39.2z" fill="#fff"></path>
											<path d="m45.5 23.8h-43c-1.1 0-2-.9-2-2v-3.8c0-9.6 7.9-17.5 17.5-17.5h12c9.7 0 17.5 7.9 17.5 17.5v3.8c0 1.1-.9 2-2 2zm-41.1-4h39.2v-1.8c0-7.5-6.1-13.6-13.6-13.6h-12c-7.5 0-13.6 6.1-13.6 13.6z" fill="#fff"></path>
											<path d="m45.5 30h-43c-1.1 0-2-.9-2-2s.9-2 2-2h43.1c1.1 0 2 .9 2 2s-1 2-2.1 2z" fill="#fff"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="products.html">Foods</a></h6>
									<span class="menus text-primary">37 Menus</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx">
								<div class="icon-bx">
									<a href="products.html">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" x="0" y="0" viewBox="0 0 510 510" style="enable-background:new 0 0 512 512" xml:space="preserve">
											<path d="m510 30v-30h-116.079l-27.692 90h-217.427l16.154 210h-164.956v45c0 90.981 74.019 165 165 165h283.891l32.308-420h-83.581l18.462-60zm-153.002 90-23.077 75h-146.954l-5.769-75zm-167.723 105h251.449l-15 195h-113.776c11.537-22.515 18.052-48.011 18.052-75v-45h-134.956zm-93.278 149.373c-3.856-9.025-5.997-18.953-5.997-29.373v-15h42.975zm54.003-17.942v62.06c-13.795-2.811-26.215-9.432-36.136-18.696zm30 0 36.136 43.363c-9.921 9.265-22.34 15.886-36.136 18.696zm60-11.431c0 10.42-2.141 20.348-5.997 29.373l-36.978-44.373h42.975zm-210 0v-15h30v15c0 57.897 47.103 105 105 105s105-47.103 105-105v-15h30v15c0 74.439-60.561 135-135 135s-135-60.561-135-135zm229.758 135c12.102-8.52 23.015-18.617 32.429-30h131.23l-2.308 30zm189.044-360-5.77 75h-77.722l23.077-75z" fill="#ffffff" data-original="#000000"></path>
											<path d="m375 270h30v30h-30z" fill="#ffffff" data-original="#000000"></path>
											<path d="m360 345h30v30h-30z" fill="#ffffff" data-original="#000000"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="products.html">Pizza</a></h6>
									<span class="menus text-primary">28 Menus</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx">
								<div class="icon-bx">
									<a href="products.html">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
											<path d="m433.609 152.564c1.742.696 2.484 2.064 2.77 2.818.286.753.642 2.268-.198 3.947l-16.12 35.271 27.396 12.512 15.796-34.587c4.245-8.679 4.712-18.809 1.276-27.847-3.472-9.132-10.666-16.45-19.736-20.078-2.257-.902-3.494-3.312-2.974-5.638l8.689-19.358-27.475-12.334-9.412 20.969-.239.717c-5.857 17.572 3.027 36.728 20.227 43.608z" fill="#ffffff" data-original="#000000"></path>
											<path d="m323.205 65.725c1.743.697 2.485 2.065 2.771 2.818s.642 2.268-.198 3.947l-16.121 35.272 27.396 12.512 15.796-34.585c4.245-8.679 4.713-18.81 1.277-27.849-3.473-9.133-10.666-16.45-19.736-20.077-2.258-.903-3.496-3.313-2.974-5.638l8.688-19.359-27.476-12.335-9.411 20.968-.239.716c-5.857 17.573 3.026 36.728 20.227 43.61z" fill="#ffffff" data-original="#000000"></path>
											<path d="m177.609 65.725c1.742.696 2.484 2.064 2.77 2.818.286.753.642 2.268-.198 3.947l-16.12 35.271 27.396 12.512 15.796-34.587c4.245-8.679 4.712-18.809 1.276-27.847-3.472-9.132-10.666-16.45-19.736-20.078-2.257-.902-3.494-3.312-2.974-5.638l8.689-19.358-27.476-12.334-9.411 20.969-.239.717c-5.857 17.572 3.027 36.728 20.227 43.608z" fill="#ffffff" data-original="#000000"></path>
											<path d="m67.205 147.042c1.743.697 2.485 2.065 2.771 2.818s.642 2.268-.198 3.947l-16.121 35.271 27.396 12.512 15.796-34.585c4.245-8.679 4.713-18.81 1.277-27.849-3.473-9.133-10.666-16.45-19.736-20.077-2.258-.903-3.496-3.313-2.974-5.638l8.688-19.359-27.476-12.334-9.411 20.968-.239.716c-5.857 17.574 3.026 36.729 20.227 43.61z" fill="#ffffff" data-original="#000000"></path>
											<path d="m481.376 421.216c-3.575-54.667-26.56-105.569-65.654-144.664-31.809-31.809-71.436-52.956-114.546-61.66v-19.558c0-24.91-20.266-45.176-45.176-45.176-24.911 0-45.176 20.266-45.176 45.176v19.558c-43.109 8.704-82.737 29.851-114.546 61.66-39.094 39.094-62.08 89.998-65.653 144.664h-30.625v90.353h512v-90.353zm-240.435-210.319v-15.563c0-8.303 6.754-15.059 15.059-15.059 8.303 0 15.059 6.755 15.059 15.059v15.563c-9.609-.687-19.674-.647-30.118 0zm41.502 31.406c90.595 12.288 161.706 86.776 168.748 178.914h-390.382c7.043-92.138 78.153-166.625 168.748-178.914 17.615-2.088 35.243-2.17 52.886 0zm199.439 239.149h-451.764v-30.118h451.765v30.118z" fill="#ffffff" data-original="#000000"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="products.html">Drink</a></h6>
									<span class="menus text-primary">12 Menus</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx">
								<div class="icon-bx">
									<a href="products.html">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve">
											<path d="m433.609 152.564c1.742.696 2.484 2.064 2.77 2.818.286.753.642 2.268-.198 3.947l-16.12 35.271 27.396 12.512 15.796-34.587c4.245-8.679 4.712-18.809 1.276-27.847-3.472-9.132-10.666-16.45-19.736-20.078-2.257-.902-3.494-3.312-2.974-5.638l8.689-19.358-27.475-12.334-9.412 20.969-.239.717c-5.857 17.572 3.027 36.728 20.227 43.608z" fill="#ffffff" data-original="#000000"></path>
											<path d="m323.205 65.725c1.743.697 2.485 2.065 2.771 2.818s.642 2.268-.198 3.947l-16.121 35.272 27.396 12.512 15.796-34.585c4.245-8.679 4.713-18.81 1.277-27.849-3.473-9.133-10.666-16.45-19.736-20.077-2.258-.903-3.496-3.313-2.974-5.638l8.688-19.359-27.476-12.335-9.411 20.968-.239.716c-5.857 17.573 3.026 36.728 20.227 43.61z" fill="#ffffff" data-original="#000000"></path>
											<path d="m177.609 65.725c1.742.696 2.484 2.064 2.77 2.818.286.753.642 2.268-.198 3.947l-16.12 35.271 27.396 12.512 15.796-34.587c4.245-8.679 4.712-18.809 1.276-27.847-3.472-9.132-10.666-16.45-19.736-20.078-2.257-.902-3.494-3.312-2.974-5.638l8.689-19.358-27.476-12.334-9.411 20.969-.239.717c-5.857 17.572 3.027 36.728 20.227 43.608z" fill="#ffffff" data-original="#000000"></path>
											<path d="m67.205 147.042c1.743.697 2.485 2.065 2.771 2.818s.642 2.268-.198 3.947l-16.121 35.271 27.396 12.512 15.796-34.585c4.245-8.679 4.713-18.81 1.277-27.849-3.473-9.133-10.666-16.45-19.736-20.077-2.258-.903-3.496-3.313-2.974-5.638l8.688-19.359-27.476-12.334-9.411 20.968-.239.716c-5.857 17.574 3.026 36.729 20.227 43.61z" fill="#ffffff" data-original="#000000"></path>
											<path d="m481.376 421.216c-3.575-54.667-26.56-105.569-65.654-144.664-31.809-31.809-71.436-52.956-114.546-61.66v-19.558c0-24.91-20.266-45.176-45.176-45.176-24.911 0-45.176 20.266-45.176 45.176v19.558c-43.109 8.704-82.737 29.851-114.546 61.66-39.094 39.094-62.08 89.998-65.653 144.664h-30.625v90.353h512v-90.353zm-240.435-210.319v-15.563c0-8.303 6.754-15.059 15.059-15.059 8.303 0 15.059 6.755 15.059 15.059v15.563c-9.609-.687-19.674-.647-30.118 0zm41.502 31.406c90.595 12.288 161.706 86.776 168.748 178.914h-390.382c7.043-92.138 78.153-166.625 168.748-178.914 17.615-2.088 35.243-2.17 52.886 0zm199.439 239.149h-451.764v-30.118h451.765v30.118z" fill="#ffffff" data-original="#000000"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="products.html">Lunch</a></h6>
									<span class="menus text-primary">67 Menus</span>
								</div>
							</div>
						</div>
					</div>
				</div> --}}
				<!-- Categories Swiper -->


				<!-- Featured Beverages -->
				{{-- <div class="title-bar">
					<h5 class="title">Featured Beverages</h5>
					<a href="products.html">More</a>
				</div>
				
				<ul class="featured-list">
					<li>
						<div class="dz-card list">
							<div class="dz-media">
								<a href="product-detail.html"><img src="assets/images/products/product1.jpg" alt=""></a>
								<div class="dz-rating"><i class="fa fa-star"></i> 3.8</div>
							</div>
							<div class="dz-content">
								<div class="dz-head">
									<h6 class="title"><a href="product-detail.html">Hot Creamy Cappuccino Latte Ombe</a></h6>
								</div>
								<ul class="dz-meta">
									<li class="dz-price flex-1">$12.6</li>
									<li class="dz-pts">50 Pts</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="dz-card list">
							<div class="dz-media">
								<a href="product-detail.html"><img src="assets/images/products/product2.jpg" alt=""></a>
								<div class="dz-rating"><i class="fa fa-star"></i> 3.8</div>
							</div>
							<div class="dz-content">
								<div class="dz-head">
									<h6 class="title"><a href="product-detail.html">Creamy Mocha Ome Coffee </a></h6>
								</div>
								<ul class="dz-meta">
									<li class="dz-price flex-1">$12.6</li>
									<li class="dz-pts">50 Pts</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="dz-card list">
							<div class="dz-media">
								<a href="product-detail.html"><img src="assets/images/products/product3.jpg" alt=""></a>
								<div class="dz-rating"><i class="fa fa-star"></i> 3.8</div>
							</div>
							<div class="dz-content">
								<div class="dz-head">
									<h6 class="title"><a href="product-detail.html">Arabica Latte Ombe Coffee </a></h6>
								</div>
								<ul class="dz-meta">
									<li class="dz-price flex-1">$12.6</li>
									<li class="dz-pts">50 Pts</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<div class="dz-card list">
							<div class="dz-media">
								<a href="product-detail.html"><img src="assets/images/products/product4.jpg" alt=""></a>
								<div class="dz-rating"><i class="fa fa-star"></i> 3.8</div>
							</div>
							<div class="dz-content">
								<div class="dz-head">
									<h6 class="title"><a href="product-detail.html">Original Hot Coffee  </a></h6>
								</div>
								<ul class="dz-meta">
									<li class="dz-price flex-1">$12.6</li>
									<li class="dz-pts">50 Pts</li>
								</ul>
							</div>
						</div>
					</li>
				</ul> --}}
				<!-- Featured Beverages -->
			</div>
		</main>
		<!-- Main Content End -->
		
		<!-- Menubar -->
		@include('layout-mobile.components.appBottomMenu')
		<!-- Menubar -->
	</div>
	<!-- Nav Floting End -->
	
	<!-- Modal -->
	{{-- <div class="modal fade dz-pwa-modal" id="pwaModal" tabindex="-1" aria-labelledby="pwaModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<a href="javascript:void(0);" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="feather icon-x"></i></a>
				<img class="logo dark" src="assets/images/app-logo/logo.png" alt="">
				<img class="logo light" src="assets/images/app-logo/logo-white.png" alt="">
				<h5 class="title">Ombe - Coffee Shop Mobile App Template</h5>
				<p class="pwa-text">Install "Ombe Coffee Shop Mobile App Template" to your home screen for easy access, just like any other app</p>
				<button type="button" class="btn pwa-btn">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 16.0001V13.0001M12 13.0001V10.0001M12 13.0001H9M12 13.0001H15M4 16.8002V11.4522C4 10.9179 4 10.6506 4.06497 10.4019C4.12255 10.1816 4.2173 9.97307 4.34521 9.78464C4.48955 9.57201 4.69064 9.39569 5.09277 9.04383L9.89436 4.84244C10.6398 4.19014 11.0126 3.86397 11.4324 3.73982C11.8026 3.63035 12.1972 3.63035 12.5674 3.73982C12.9875 3.86406 13.3608 4.19054 14.1074 4.84383L18.9074 9.04383C19.3096 9.39569 19.5102 9.57201 19.6546 9.78464C19.7825 9.97307 19.8775 10.1816 19.9351 10.4019C20 10.6505 20 10.9184 20 11.4522V16.8037C20 17.9216 20 18.4811 19.7822 18.9086C19.5905 19.2849 19.2842 19.5906 18.9079 19.7823C18.4805 20.0001 17.9215 20.0001 16.8036 20.0001H7.19691C6.07899 20.0001 5.5192 20.0001 5.0918 19.7823C4.71547 19.5906 4.40973 19.2849 4.21799 18.9086C4 18.4807 4 17.9203 4 16.8002Z" stroke="#03764D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<span>Add to Home Screen</span>
				</button>
			</div>
		</div>
	</div> --}}
	<!-- PWA End --> 
	
</div>  
<!--**********************************
    Scripts
***********************************-->
@include('layout-mobile.components.foot')

</body>

</html>
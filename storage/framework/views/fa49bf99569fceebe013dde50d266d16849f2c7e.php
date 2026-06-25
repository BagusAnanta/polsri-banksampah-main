<?php $__env->startSection('header'); ?>
    <header class="header py-2 mx-auto">
        <div class="header-content">
            <div class="left-content">
                <div class="info">
                    <p class="text m-b10"><?php echo e($greeting); ?></p>
                    <h3 class="title"><?php echo e(ucfirst(Auth::user()->name)); ?></h3>
                </div>
            </div>
            <div class="mid-content"></div>
            <div class="right-content d-flex align-items-center gap-4">
                
                <a href="javascript:void(0);" class="icon dz-floating-toggler">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                        <rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                        <rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


    <?php if(!$users->isEmpty() && Auth::user()->hasRole('Admin')): ?>
        <!-- Daftar Setoran Pengguna -->
        <div class="title-bar">
            <h5 class="title">Daftar Setoran Pengguna Hari Ini</h5>
        </div>
        <!-- SearchBox -->
        <div class="search-box">
            <div class="input-group input-radius input-rounded input-lg">
                <input type="text" placeholder="Cari nama atau alamat" id="search" class="form-control">
                <span class="input-group-text">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z"
                            fill="#C9C9C9" />
                    </svg>
                </span>
            </div>
        </div>
        <!-- SearchBox -->

        <div class="alert alert-info solid alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            Ketuk untuk melihat detail setoran
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                <span><i class="icon feather icon-x"></i></span>
            </button>
        </div>

        <ul class="featured-list">
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <hr>
                <li onclick="modalDetailSetoran(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')">
                    <div class="dz-card list">
                        <div class="dz-media">
                            <a href="javascript:void(0);"><img src="<?php echo e(asset('img/home-control.png')); ?>"
                                    style="width: 100px;" alt=""></a>
                        </div>
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title"><a href="javascript:void(0)"><?php echo e(ucfirst($user->name)); ?></a></h6>
                                <ul class="dz-meta">
                                    <li class="dz-price flex-1"><?php echo e($user->address); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="dz-card d-flex flex-column shadow-sm list rounded-3 mt-5">
                <div class="d-flex bg-primary p-4 rounded-top-3">
                    <div class="dz-media">
                        <a href="javascript:void(0);"><img class="img-thumbnail rounded-circle"
                                src="<?php echo e(asset('ui/images/profile/' . ($userTabungan->avatar ?? 'user.png'))); ?>"
                                style="width: 100%;" alt=""></a>
                    </div>
                    <div class="dz-content text-white">
                        <div class="dz-head">
                            <h6 class="title fw-bold"><a href="javascript:void(0)" class="text-white"
                                    style="font-size: 22px">
                                    <?php echo e($userTabungan->name ?? '-'); ?></a>
                            </h6>
                            <h6 class="title"><a href="javascript:void(0)" class="text-white fw-normal">ID<span>:</span>
                                    <?php echo e($userTabungan->user_code ?? '-'); ?></a>
                            </h6>
                            <ul class="dz-meta mt-4">
                                <li class="dz-price fw-medium flex-1">
                                    Saldo: Rp.
                                    <?php echo e(isset($tabunganData) ? number_format($tabunganData, 0, ',', '.') : '0'); ?>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-5 p-4 justify-content-between" style="width: 100%;margin-top: 50px">
                    <a href="<?php echo e(route('bank_sampahs.create')); ?>"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width=28 height=28 viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                            <line x1="16" x2="8" y1="17" y2="17" />
                            <line x1="10" x2="8" y1="9" y2="9" />
                        </svg>
                        <span>Setor</span>
                    </a>
                    <a href="<?php echo e(route('transaksi.index')); ?>"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width=28 height=28 viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Transaksi</span>
                    </a>
                    <a href="<?php echo e(route('riwayat-setor')); ?>"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width=28 height=28 viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                            <line x1="16" x2="8" y1="17" y2="17" />
                            <line x1="10" x2="8" y1="9" y2="9" />
                        </svg>
                        <span>Laporan</span>
                    </a>
                    <a href="<?php echo e(route('products-list.index')); ?>"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <i class="fi fi-rr-shopping-cart" style="font-size: 28px;font-weight: 300"></i>
                        <span>Shop</span>
                    </a>
                </div>
            </div>
        </ul>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('modals'); ?>
    <div class="modal fade" id="modalSetoran">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setoran Harian Kris Setiyadi</h5>
                    <button class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var search = $(this).val();

                $.ajax({
                    url: '<?php echo e(route('dashboard.search')); ?>',
                    method: 'GET',
                    data: {
                        search: search
                    },
                    success: function(response) {
                        var featuredList = $('.featured-list');
                        featuredList.empty();

                        if (response.length > 0) {
                            $.each(response, function(index, user) {
                                var userHtml = `
                            <hr>
                            <li>
                                <div class="dz-card list">
                                    <div class="dz-media">
                                        <a href="javascript:void(0)"><img src="<?php echo e(asset('img/home-control.png')); ?>" style="width: 100px;" alt=""></a>
                                    </div>
                                    <div class="dz-content">
                                        <div class="dz-head">
                                            <h6 class="title"><a href="javascript:void(0)">${user.name}</a></h6>
                                            <ul class="dz-meta">
                                                <li class="dz-price flex-1">${user.address}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <hr>`;
                                featuredList.append(userHtml);
                            });
                        } else {
                            featuredList.append('<li>No results found</li>');
                        }
                    }
                });
            });
        });

        function modalDetailSetoran(id, name) {
            $.ajax({
                url: "<?php echo e(url('/api/setor')); ?>/" + id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {

                    // Set modal title
                    $('#modalSetoran .modal-title').text('Setoran Harian ' + name);

                    // Get the list element inside modal body
                    var listGroup = $('#modalSetoran .modal-body ul');
                    listGroup.empty(); // Clear any previous content

                    // Loop through the response data
                    $.each(res, function(index, item) {
                        // Format the data as you wish
                        var listItem = `
                    <li class="list-group-item">
                        <strong>Jenis Sampah:</strong> ${item.nama} <br>
                        <strong>Harga:</strong> Rp ${item.harga} <br>
                        <strong>Qty:</strong> ${item.qty} <br>
                        <strong>Total:</strong> Rp ${item.total} <br>
                        <strong>Tanggal Setor:</strong> ${item.tanggal_setor}
                    </li>
                `;
                        listGroup.append(listItem); // Append each item to the list
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // This will help debug in case of errors
                }
            });

            // Show the modal
            $('#modalSetoran').modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout-mobile.app2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/bagusanantahidayatullah/BagusFile/FIleKerjaBagus/polsri-banksampah-main/resources/views/dashboard/index.blade.php ENDPATH**/ ?>
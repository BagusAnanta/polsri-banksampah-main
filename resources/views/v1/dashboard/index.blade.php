@extends('layout-mobile.app2')
@section('header')
    <header class="header py-2 mx-auto">
        <div class="header-content">
            <div class="left-content">
                <div class="info">
                    <p class="text m-b10">{{ $greeting }}</p>
                    <h3 class="title">{{ ucfirst(Auth::user()->name) }}</h3>
                </div>
            </div>
            <div class="mid-content"></div>
            <div class="right-content d-flex align-items-center gap-4">
                {{-- <a href="notification.html" class="notification-badge font-20 badge-active">
                <svg width="30" height="30" viewBox="0 0 24 24" class="svg-primary" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.7329 21.68C21.8273 21.5791 21.8998 21.4597 21.9457 21.3295C21.9917 21.1992 22.0101 21.0608 21.9999 20.923L20.9999 7.92299C20.9805 7.67134 20.8666 7.43634 20.6811 7.26515C20.4957 7.09396 20.2523 6.99924 19.9999 6.99999H16.9999C16.9999 5.67391 16.4731 4.40214 15.5355 3.46446C14.5978 2.52677 13.326 1.99999 11.9999 1.99999C10.6738 1.99999 9.40207 2.52677 8.46438 3.46446C7.5267 4.40214 6.99992 5.67391 6.99992 6.99999H3.99992C3.74752 6.99924 3.50417 7.09396 3.3187 7.26515C3.13323 7.43634 3.01935 7.67134 2.99992 7.92299L1.99992 20.923C1.98929 21.0606 2.00727 21.199 2.05275 21.3294C2.09822 21.4597 2.17019 21.5792 2.26413 21.6804C2.35807 21.7816 2.47194 21.8622 2.59858 21.9172C2.72521 21.9722 2.86186 22.0004 2.99992 22H20.9999C21.1375 22 21.2737 21.9715 21.3998 21.9165C21.5259 21.8614 21.6393 21.7809 21.7329 21.68ZM11.9999 3.99999C12.7956 3.99999 13.5586 4.31606 14.1212 4.87867C14.6838 5.44128 14.9999 6.20434 14.9999 6.99999H8.99992C8.99992 6.20434 9.31599 5.44128 9.8786 4.87867C10.4412 4.31606 11.2043 3.99999 11.9999 3.99999ZM4.07992 20L4.92592 8.99999H6.99992V11C6.99992 11.2652 7.10527 11.5196 7.29281 11.7071C7.48035 11.8946 7.7347 12 7.99992 12C8.26513 12 8.51949 11.8946 8.70702 11.7071C8.89456 11.5196 8.99992 11.2652 8.99992 11V8.99999H14.9999V11C14.9999 11.2652 15.1053 11.5196 15.2928 11.7071C15.4803 11.8946 15.7347 12 15.9999 12C16.2651 12 16.5195 11.8946 16.707 11.7071C16.8946 11.5196 16.9999 11.2652 16.9999 11V8.99999H19.0739L19.9199 20H4.07992Z" fill="#04764E"></path>
                </svg>
            </a> --}}
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
@endsection
@section('content')


    @if (!$users->isEmpty() && Auth::user()->hasRole('Admin'))
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
            @foreach ($users as $user)
                <hr>
                <li onclick="modalDetailSetoran({{ $user->id }}, '{{ $user->name }}')">
                    <div class="dz-card list">
                        <div class="dz-media">
                            <a href="javascript:void(0);"><img src="{{ asset('img/home-control.png') }}"
                                    style="width: 100px;" alt=""></a>
                        </div>
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title"><a href="javascript:void(0)">{{ ucfirst($user->name) }}</a></h6>
                                <ul class="dz-meta">
                                    <li class="dz-price flex-1">{{ $user->address }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <hr>
            @endforeach
        @else
            <div class="dz-card d-flex flex-column shadow-sm list rounded-3 mt-5">
                <div class="d-flex bg-primary p-4 rounded-top-3">
                    <div class="dz-media">
                        <a href="javascript:void(0);"><img class="img-thumbnail rounded-circle"
                                src="{{ asset('ui/images/profile/' . ($userTabungan->avatar ?? 'user.png')) }}"
                                style="width: 100%;" alt=""></a>
                    </div>
                    <div class="dz-content text-white">
                        <div class="dz-head">
                            <h6 class="title fw-bold"><a href="javascript:void(0)" class="text-white"
                                    style="font-size: 22px">
                                    {{ $userTabungan->name ?? '-' }}</a>
                            </h6>
                            <h6 class="title"><a href="javascript:void(0)" class="text-white fw-normal">ID<span>:</span>
                                    {{ $userTabungan->user_code ?? '-' }}</a>
                            </h6>
                            <ul class="dz-meta mt-4">
                                <li class="dz-price fw-medium flex-1">
                                    Saldo: Rp.
                                    {{ isset($tabunganData) ? number_format($tabunganData, 0, ',', '.') : '0' }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-5 p-4 justify-content-between" style="width: 100%;margin-top: 50px">
                    <a href="{{ route('bank_sampahs.create') }}"
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
                    <a href="{{ route('transaksi.index') }}"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width=28 height=28 viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>Transaksi</span>
                    </a>
                    <a href="{{ route('riwayat-setor') }}"
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
                    <a href="{{ route('products-list.index') }}"
                        class="d-flex gap-2 flex-column justify-content-center align-items-center">
                        <i class="fi fi-rr-shopping-cart" style="font-size: 28px;font-weight: 300"></i>
                        <span>Shop</span>
                    </a>
                </div>
            </div>
        </ul>
    @endif
@endsection
@push('modals')
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
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var search = $(this).val();

                $.ajax({
                    url: '{{ route('dashboard.search') }}',
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
                                        <a href="javascript:void(0)"><img src="{{ asset('img/home-control.png') }}" style="width: 100px;" alt=""></a>
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
                url: "{{ url('/api/setor') }}/" + id,
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
@endpush

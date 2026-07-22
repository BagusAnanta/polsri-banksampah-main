@extends('layout-mobile.app')
@section('header')
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Penyetoran Nasabah</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
            </div>
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">
        {{-- <header class="header py-2 mx-auto">
            <div class="header-content">
                <div class="left-content">
                    <div class="info">
                        <p class="text m-b10">Good Morning</p>
                        <h3 class="title">{{ Auth::user()->name }}</h3>
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
        </header> --}}
        <!-- Header -->

        <!-- Main Content Start -->
        <main class="page-content bg-white p-b60">
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success solid alert-dismissible fade show">
                        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2"
                            fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            <span><i class="icon feather icon-x"></i></span>
                        </button>
                    </div>
                @endif

                <!-- SearchBox -->
                <div class="search-box">
                    <form action="{{ route('bank_sampahs.index') }}" method="GET">
                        <div class="input-group input-radius input-rounded input-lg">
                            <input type="text" placeholder="Masukkan ID Nasabah" id="search"
                                value="{{ request('search') }}" name="search" class="form-control">

                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                </div>
                <!-- SearchBox -->

                <table id="myTable" class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Nasabah</th>
                            <th>Nama Nasabah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($penyetoranNasabah->count() > 0)
                            @php
                                $nomor = ($penyetoranNasabah->currentPage() - 1) * $penyetoranNasabah->perPage() + 1;
                            @endphp
                            @foreach ($penyetoranNasabah as $item)
                                <tr>
                                    <td>{{ $nomor++ }}</td>
                                    {{-- <td>{{ $loop->iteration }}</td> --}}
                                    <td>{{ $item->user->user_code }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ formatDateIndo($item->tanggal_setor) }}</td>
                                    <td>
                                        <span
                                            class="badge
                                                {{ $item->status === 'approved' ? 'bg-success' : ($item->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('bank-sampah.detail', $item->user_id) }}" class="text-info">
                                            Detail
                                        </a>
                                        <form action="{{ route('bank-sampah.updateStatus', $item->user_id) }}"
                                            method="POST" id="statusForm-{{ $item->user_id }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="document.getElementById('statusForm-{{ $item->user_id }}').submit()">
                                                <option value="pending"
                                                    {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved"
                                                    {{ $item->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="gagal" {{ $item->status === 'gagal' ? 'selected' : '' }}>
                                                    Gagal</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($penyetoranNasabah->count() > 0)
                    <div class="d-flex">
                        {{ $penyetoranNasabah->appends(['search' => request('search')])->links() }}
                    </div>
                @endif
            </div>
            {{-- @endif --}}

        </main>
        <!-- Main Content End -->
    </div>

    {{-- <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, '', '{{ route('dashboard') }}');
        }
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButton = document.querySelector('.btn-approved');

            if (deleteButton) {
                deleteButton.addEventListener('click', () => {
                    history.pushState(null, '', '{{ route('dashboard') }}');
                });
            }
        });
    </script>
@endsection

@extends('layout-mobile.app')
@section('header')
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                @php
                    $previousUrl = session('previous_url', route('dashboard')); // Default ke halaman index

                    // Validasi URL agar hanya dari domain aplikasi
                    if (!str_contains($previousUrl, config('app.url'))) {
                        $previousUrl = route('jenis_sampahs.index'); // Pastikan URL aman
                    }
                @endphp

                <a href="{{ $previousUrl }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Jenis Sampah</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                <a href="{{ route('jenis_sampahs.create') }}">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div>
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">
        <ul>
            @foreach ($jenis_sampahs as $jenis_sampah)
                <li class="list-items pull_delete"
                    onclick="location.href='{{ route('jenis_sampahs.show', $jenis_sampah->id) }}'">
                    <div class="media">
                        <div class="list-content">
                            <h5 class="title">{{ ucfirst($jenis_sampah->nama) }}</h5>
                            <span class="date">{{ $jenis_sampah->catatan }}</span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

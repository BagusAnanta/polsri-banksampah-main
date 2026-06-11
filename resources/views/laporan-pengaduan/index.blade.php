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
                <h4 class="title">Laporan Pengaduan</h4>
            </div>
            <div class="right-content d-flex align-items-center gap-4">
                {{-- <a href="{{ route('laporan-pengaduans.create') }}">
                    <i class="fi fi-rr-plus"></i>
                </a> --}}
            </div>
        </div>
    </header>
@endsection
@section('content')
    <div class="dz-list notification-list">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <ul>
            @foreach ($laporans as $laporan)
                <li onclick="location.href='{{ route('laporan-pengaduans.showAdmin', $laporan->id) }}'">
                    <div class="dz-card list">
                        <div class="dz-content">
                            <div class="dz-head">
                                <h6 class="title">
                                    User Id: {{ ucfirst($laporan->user->user_code) }}
                                </h6>
                                <ul class="tag-list">
                                    <li><a href="javascript:void(0);">
                                            {{ $laporan->boxSampah->id_box }}
                                        </a>
                                    </li>
                                    <li><a href="javascript:void(0);">
                                            {{ $laporan->catatan }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
            @endforeach
        </ul>
    </div>
@endsection

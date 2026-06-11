@extends('layout-mobile.app')
<!-- Header -->
@section('header')
    <header class="header header-fixed">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Detail Penyetoran</h4>
            </div>
        </div>
    </header>
@endsection
<!-- Header -->
<!-- Main Content Start -->
@section('content')
    <div class="profile-area">
        <div class="widget_getintuch pb-15">
            @foreach ($penyetoranNasabah as $item)
                <ul>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Nama Nasabah</p>
                            <h6 class="title">{{ $item->user->name }}</h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Tanggal Setor</p>
                            <h6 class="title">{{ $item->tanggal_setor }}</h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Status</p>
                            <h6 class="title">{{ $item->status }}</h6>
                        </div>
                    </li>
                    <li>
                        <div class="dz-content">
                            <p class="sub-title">Jenis Sampah</p>
                            @foreach ($item->detailJenisSampah as $detail)
                                <h6 class="title">{{ $detail->jenisSampah->nama }} - {{ $detail->qty }} qty
                                </h6>
                            @endforeach
                        </div>
                    </li>
            @endforeach
            </ul>
        </div>
    </div>
@endsection
<!-- Main Content End -->

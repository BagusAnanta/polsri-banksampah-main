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
                <h4 class="title">Pemantauan Realtime</h4>
            </div>
        </div>
    </header>
@endsection
@section('content')
@php
$count = 4;
@endphp
<div class="accordion dz-accordion" id="accordionExample">
    @for($i=1;$i <= $count;$i++)
    <div class="accordion-item">
        <div class="accordion-header acco-select" id="heading{{$i}}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}">
                <span class="dz-icon">
                    <i class="fi fi-rr-dashboard"></i>
                </span>
                <span class="acco-title">Bank Sampah - Sensor {{$i}}</span>
                <span class="checkmark"></span>
            </button>
        </div>
        <div id="collapse{{$i}}" class="accordion-collapse collapse show" aria-labelledby="heading{{$i}}">
            <div class="accordion-body text-center p-4">
                <span id="bankSampah1-sensor{{$i}}" class="fs-1 fw-bold d-block">0</span>
                <span class="fs-6 text-muted">cm</span>
            </div>
        </div>
    </div>
    @endfor
</div>
@endsection

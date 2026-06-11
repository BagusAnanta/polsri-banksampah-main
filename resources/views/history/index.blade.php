@extends('layout-mobile.app')

@section('header')
    <header class="header header-fixed border-bottom">
        <div class="header-content">
            <div class="left-content">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <i class="feather icon-arrow-left"></i>
                </a>
            </div>
            <div class="mid-content">
                <h4 class="title">Riwayat Setor</h4>
            </div>
            <div class="right-content"></div>
        </div>
    </header>
@endsection

@section('content')
    <div class="title-bar mb-0">
        <h5 class="title">Filter</h5>
    </div>
    <div class="swiper categories-swiper dz-swiper m-b20">
        <div class="swiper-wrapper">
            @foreach ($month as $key => $item)
                <div class="swiper-slide" onclick="location.href='{{ route('riwayat-setor', $key) }}'">
                    <div class="dz-categories-bx">
                        <div class="icon-bx">
                            <a href="javascript:void(0);">
                                <div class="fw-bold">{{ date('Y') }}</div>
                            </a>
                        </div>
                        <div class="dz-content">
                            <h6 class="title"><a href="javascript:void(0);">{{ $item }}</a></h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="alert alert-info solid alert-dismissible fade show">
        <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"
            stroke-linecap="round" stroke-linejoin="round" class="me-2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        Periode bulan {{ $period }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            <span><i class="icon feather icon-x"></i></span>
        </button>
    </div>
    <div class="my-4">
        <h5 class="title">Cetak Laporan</h5>
        <form action="{{ route('download-slip-penyetoran-bulan-pdf') }}" method="GET" class="d-flex gap-3">
            <select name="month" class="form-select" style="width: 50%">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <button type="submit" class="btn btn-danger" style="width: 50%">Cetak Laporan</button>
        </form>
    </div>
    <div class="accordion dz-accordion" id="accordionExample">
        @php
            $no = 1;
        @endphp
        @foreach ($currentMonth as $date => $collection)
            <div class="accordion-item">
                <div class="accordion-header acco-select" id="heading{{ $no }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $no }}" aria-expanded="true"
                        aria-controls="collapse{{ $no }}">
                        <span class="acco-title">{{ $date }}</span>
                        &nbsp;
                        &nbsp;
                        @if ($date == date('Y-m-d'))
                            <span class="badge badge-success">Today</span>
                            <span class="checkmark"></span>
                        @endif
                    </button>
                </div>
                <div id="collapse{{ $no }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $no }}" data-bs-parent="#accordionExample">
                    @if ($collection['entries']->isEmpty())
                        <div class="accordion-body">
                            <div class="text-center">
                                Tidak ada riwayat setor.
                            </div>
                        </div>
                    @else
                        <div class="accordion-body">
                            <div class="mb-3">
                                <button class="btn btn-primary rounded-xl btn-thin w-100" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                    aria-controls="offcanvasRight">
                                    Total Pendapatan: Rp. {{ number_format($collection['total'], 0, ',', '.') }}
                                </button>
                            </div>
                            {{-- <div class="mb-3 d-flex justify-content-between gap-2">
                                <a href="{{ route('download-slip-penyetoran-pdf', $date) }}" target="_blank"
                                    class="btn btn-outline-danger rounded-xl btn-thin" style="width: 50%">
                                    Cetak Laporan
                                </a>
                                <a href="{{ route('download-nota-pdf', $date) }}" target="_blank"
                                    class="btn btn-outline-primary rounded-xl btn-thin" style="width: 50%">
                                    Cetak Nota
                                </a>
                            </div> --}}
                            <table class="table table-striped">
                                @foreach ($collection['entries'] as $item)
                                    <tr>
                                        <td style="width: 50%" class="center">
                                            <span class="fw-bold">{{ $item->jenisSampah->nama }}</span>
                                        </td>
                                        <td>
                                            <div class="mb-2 input-group input-group-icon justify-content-end"
                                                style="width: 100%">
                                                <span class="input-group-text">
                                                    <input class="form-control" name="qty" type="number" disabled
                                                        placeholder="0" value="{{ $item->qty }}">
                                                    <span>&nbsp;gram</span>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            @php
                $no++;
            @endphp
        @endforeach
    </div>
@endsection

@push('script')
@endpush
